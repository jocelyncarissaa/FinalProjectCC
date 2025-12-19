from locust import HttpUser, SequentialTaskSet, task, between, events
import re 
import logging
import random

EMAIL_USER = "customer@gmail.com" 
PASSWORD_USER = "password"

EMAIL_ADMIN = "admin@pharmaplus.com" 
PASSWORD_ADMIN = "password"

RESPONSE_TIME_THRESHOLD = 3000 # 3 detik

# USER
class UserJourney(SequentialTaskSet):
    catalog_token = None
    target_item_id = "1" 

    @task
    def open_home(self):
        task_name = "[USER] 1. Home Page"
        with self.client.get("/home", catch_response=True, name=task_name) as response:
            logging.info(f"[USER][{task_name}] Status: {response.status_code}")
            if response.status_code != 200:
                response.failure(f"Failed to load Home: {response.status_code}")

    @task
    def open_catalog(self):
        task_name = "[USER] 2. Catalog"
        self.catalog_token = None
        with self.client.get("/products", catch_response=True, name=task_name) as response:
            logging.info(f"[USER][{task_name}] Status: {response.status_code}")
            if response.status_code != 200:
                response.failure(f"Failed to load Catalog: {response.status_code}")
                return
            
            csrf_token = re.search(r'name="_token" value="(.+?)"', response.text)
            if csrf_token:
                self.catalog_token = csrf_token.group(1)
            else:
                logging.error("CSRF Token not found in Catalog Page!")

    @task
    def view_product_detail(self):
        task_name = "[USER] 3. Product Detail"
        product_id = str(1) 
        with self.client.get(f"/product-detail/{product_id}", catch_response=True, name=task_name) as response:
            logging.info(f"[USER][{task_name}] Status: {response.status_code}")
            if response.status_code != 200:
                response.failure(f"Failed to load Product Detail: {response.status_code}")
                
    @task
    def add_to_cart(self):
        task_name = "[USER] 4. Add to Cart"
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
            logging.info(f"[USER][{task_name}] Status: {response.status_code}")
            if response.status_code not in [200, 201, 302]: 
                 response.failure(f"Failed Add to Cart: {response.status_code} - {response.text}")

    @task
    def view_cart(self):
        task_name = "[USER] 5. View Cart"
        with self.client.get("/cart", catch_response=True, name=task_name) as response:
            logging.info(f"[USER][{task_name}] Status: {response.status_code}")
            if response.status_code != 200:
                response.failure(f"Failed to load Cart: {response.status_code}")
        
    @task
    def checkout_page(self):
        task_name = "[USER] 6. View Checkout Page"
        with self.client.get("/checkout", catch_response=True, name=task_name) as response:
            logging.info(f"[USER][{task_name}] Status: {response.status_code}")
            if response.status_code != 200:
                response.failure(f"Failed to load Checkout: {response.status_code}")

    @task
    def stop(self):
        self.interrupt()

# ADMIN
class AdminJourney(SequentialTaskSet):
    admin_token = None
    target_order_id = "1" 

    @task
    def open_dashboard(self):
        task_name = "[ADMIN] 1. Admin Dashboard"
        with self.client.get("/admin/dashboard", catch_response=True, name=task_name) as response:
            logging.info(f"[ADMIN][{task_name}] Status: {response.status_code}")
            if response.status_code != 200:
                response.failure(f"Failed to load Dashboard: {response.status_code}")

    @task
    def view_product_list(self):
        task_name = "[ADMIN] 2. View Product List"
        self.admin_token = None
        
        with self.client.get("/admin/items", catch_response=True, name=task_name) as response:
            logging.info(f"[ADMIN][{task_name}] Status: {response.status_code}")
            if response.status_code != 200:
                response.failure(f"Failed to load Product List: {response.status_code}")
                return

            csrf_token = re.search(r'name="_token" value="(.+?)"', response.text)
            if csrf_token:
                self.admin_token = csrf_token.group(1)

    @task
    def create_product(self):
        task_name = "[ADMIN] 3. Create New Product"
        if not self.admin_token:
            logging.warning("Skipping Create Product: No CSRF token")
            return

        random_num = random.randint(1000, 9999) 
        
        with self.client.post("/admin/items", 
                              data={
                                  "name": f"Obat Test Locust {random_num}",
                                  "category": "Antibiotic",
                                  "price": 50000,
                                  "stock": 100,
                                  "description": "Auto generated by Locust",
                                  "_token": self.admin_token
                              }, 
                              catch_response=True, 
                              name=task_name) as response:
            
            logging.info(f"[ADMIN][{task_name}] Status: {response.status_code}")
            if response.status_code not in [200, 201, 302]: 
                 response.failure(f"Failed Create Product: {response.status_code}")

    @task
    def view_orders(self):
        task_name = "[ADMIN] 4. View Order List"
        self.admin_token = None 

        with self.client.get("/admin/orders", catch_response=True, name=task_name) as response:
            logging.info(f"[ADMIN][{task_name}] Status: {response.status_code}")
            if response.status_code != 200:
                response.failure(f"Failed View Orders: {response.status_code}")
                return

            csrf_token = re.search(r'name="_token" value="(.+?)"', response.text)
            if csrf_token:
                self.admin_token = csrf_token.group(1)

    @task
    def update_order_status(self):
        task_name = "[ADMIN] 5. Update Order Status"
        if not self.admin_token:
            return

        with self.client.post(f"/admin/orders/{self.target_order_id}", 
                              data={
                                  "status": "completed", 
                                  "_token": self.admin_token
                              }, 
                              catch_response=True, 
                              name=task_name) as response:
            
            logging.info(f"[ADMIN][{task_name}] Status: {response.status_code}")
            if response.status_code not in [200, 201, 302]: 
                 response.failure(f"Failed Update Order: {response.status_code}")

    @task
    def stop(self):
        self.interrupt()

# LOGIN USER
class PharmaCustomer(HttpUser):
    weight = 10  
    host = "http://127.0.0.1:8000" 
    tasks = [UserJourney]
    wait_time = between(1, 3)

    def on_start(self):
        res_init = self.client.get("/login", name="[USER] 0. Init Login")
        logging.info(f"[USER][Init] Status: {res_init.status_code}")
        csrf_token = re.search(r'name="_token" value="(.+?)"', res_init.text)

        if csrf_token:
            token = csrf_token.group(1)
            res = self.client.post("/login", {
                "email": EMAIL_USER,
                "password": PASSWORD_USER,
                "_token": token
            }, name="[USER] 0. Perform Login")
            
            logging.info(f"[USER][Login] Status: {res.status_code}")
            if res.status_code not in [200, 302]:
                logging.error(f"User Login failed: {res.status_code}")
                self.stop()

# LOGIN ADMIN
class PharmaAdmin(HttpUser):
    weight = 1   
    host = "http://127.0.0.1:8000"
    tasks = [AdminJourney]
    wait_time = between(2, 5)

    def on_start(self):
        response = self.client.get("/login", name="[ADMIN] 0. Init Admin Login")
        logging.info(f"[ADMIN][Init] Status: {response.status_code}")
        
        csrf_token = re.search(r'name="_token" value="(.+?)"', response.text)
        if csrf_token:
            token = csrf_token.group(1)
            res = self.client.post("/login", {
                "email": EMAIL_ADMIN,
                "password": PASSWORD_ADMIN,
                "_token": token
            }, name="[ADMIN] 0. Perform Admin Login")
            
            logging.info(f"[ADMIN][Login] Status: {res.status_code}")
            if res.status_code not in [200, 302]:
                logging.error("Admin Login Failed")
                self.stop()
        else:
            self.stop()

@events.request.add_listener
def my_request_handler(request_type, name, response_time, response_length, exception, **kwargs):
    if exception:
        logging.error(f"FAIL: {request_type} {name}: {exception}")
    elif response_time > RESPONSE_TIME_THRESHOLD:
        logging.warning(f"SLOW: {request_type} {name} took {response_time}ms")