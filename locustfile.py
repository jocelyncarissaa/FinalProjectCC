from locust import HttpUser, task, between

class PharmaUser(HttpUser):
    # Simulasi jeda waktu user berpikir (1-3 detik)
    # Semakin kecil jeda, semakin berat beban server (bagus untuk stress test)
    wait_time = between(1, 3)

    @task(1)
    def home_page(self):
        # Mengakses Halaman Utama
        self.client.get("/")

    # @task(3)
    # def browse_products(self):
    #     # Mengakses halaman katalog obat (ini akan query ke RDS dan ambil gambar dari S3)
    #     # Pastikan endpoint ini valid di Laravel Anda (Dev 1 & 2)
    #     self.client.get("/products") 
        
    # @task(2)
    # def view_single_product(self):
    #     # Mengakses detail produk (Query specific item)
    #     # Ganti '1' dengan ID obat yang pasti ada di Seeder Anda
    #     self.client.get("/products/1") 

    # OPSIONAL: "The CPU Killer"
    # Jika server t2.micro terlalu kuat dan CPU tidak naik-naik,
    # Minta Dev 2 buat route khusus di Laravel (/stress-test) yang melakukan looping berat.
    # @task(5)
    # def stress_cpu(self):
    #     self.client.get("/stress-test")