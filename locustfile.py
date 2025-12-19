from locust import HttpUser, SequentialTaskSet, task, between, events
import re 
import logging

EMAIL_USER = "customer@gmail.com" 
PASSWORD_USER = "password"
RESPONSE_TIME_THRESHOLD = 3000 #3 detik

class UserJourney(SequentialTaskSet):
    catalog_token = None
    target_item_id = "1" 

    # STEP 1: HOME PAGE 
    @task
    def open_home(self):
        task_name = "1. Home Page"
        with self.client.get("/home", catch_response=True, name=task_name) as response:
            logging.info(f"[{task_name}] Status Code: {response.status_code}")
            
            if response.status_code != 200:
                response.failure(f"Failed to load Home: {response.status_code}")

    # STEP 2: KATALOG PRODUK 
    @task
    def open_catalog(self):
        task_name = "2. Catalog"
        self.catalog_token = None

        with self.client.get("/products", catch_response=True, name=task_name) as response:
            logging.info(f"[{task_name}] Status Code: {response.status_code}")

            if response.status_code != 200:
                response.failure(f"Failed to load Catalog: {response.status_code}")
                return

            # Cari token
            csrf_token = re.search(r'name="_token" value="(.+?)"', response.text)
            if csrf_token:
                self.catalog_token = csrf_token.group(1)
            else:
                logging.error("CSRF Token not found in Catalog Page!")

    # STEP 3: LIHAT DETAIL PRODUK
    @task
    def view_product_detail(self):
        task_name = "3. Product Detail"
        product_id = str(1) 
        with self.client.get(f"/product-detail/{product_id}", catch_response=True, name=task_name) as response:
            logging.info(f"[{task_name}] Status Code: {response.status_code}")

            if response.status_code != 200:
                response.failure(f"Failed to load Product Detail: {response.status_code}")
                
    # STEP 4: ADD TO CART 
    @task
    def add_to_cart(self):
        task_name = "4. Add to Cart"
        
        if not self.catalog_token:
            logging.warning("Skipping Add to Cart: No CSRF token available")
            return

        with self.client.post("/cart/add", 
                              data={
                                  "item_id": self.target_item_id, 
                                  "quantity": 1, 
                                  "_token": self.catalog_token,
                              }, 
                              catch_response=True, 
                              name=task_name) as response:
            
            logging.info(f"[{task_name}] Status Code: {response.status_code}")

            if response.status_code not in [200, 201, 302]: 
                 response.failure(f"Failed Add to Cart: {response.status_code} - {response.text}")

    # STEP 5: LIHAT KERANJANG
    @task
    def view_cart(self):
        task_name = "5. View Cart"
        with self.client.get("/cart", catch_response=True, name=task_name) as response:
            logging.info(f"[{task_name}] Status Code: {response.status_code}")

            if response.status_code != 200:
                response.failure(f"Failed to load Cart: {response.status_code}")
        
    # STEP 6: CHECKOUT PAGE
    @task
    def checkout_page(self):
        task_name = "6. View Checkout Page"
        with self.client.get("/checkout", catch_response=True, name=task_name) as response:
            logging.info(f"[{task_name}] Status Code: {response.status_code}")

            if response.status_code != 200:
                response.failure(f"Failed to load Checkout: {response.status_code}")

    # STEP 7: DON 
    @task
    def stop(self):
        self.interrupt()

class PharmaCustomer(HttpUser): # LOGIN
    host = "http://127.0.0.1:8000" 
    tasks = [UserJourney]
    wait_time = between(1, 3)

    def on_start(self):
        # 1. Init Login adalah 
        res_init = self.client.get("/login", name="0. Init Login")
        logging.info(f"[0. Init Login] Status Code: {res_init.status_code}") # Log Init

        csrf_token = re.search(r'name="_token" value="(.+?)"', res_init.text)

        if csrf_token:
            token = csrf_token.group(1)
            # 2. Perform Login
            res = self.client.post("/login", {
                "email": EMAIL_USER,
                "password": PASSWORD_USER,
                "_token": token
            }, name="0. Perform Login")
            
            # Log Perform Login
            logging.info(f"[0. Perform Login] Status Code: {res.status_code}")

            if res.status_code not in [200, 302]:
                logging.error(f"Login failed with status {res.status_code}")
                self.stop()

@events.request.add_listener
def my_request_handler(request_type, name, response_time, response_length, exception, **kwargs):
    if exception:
        logging.error(f"FAIL: {request_type} {name}: {exception}")
    elif response_time > RESPONSE_TIME_THRESHOLD:
        logging.warning(f"SLOW: {request_type} {name} took {response_time}ms")