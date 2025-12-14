#  B2C Cloud-Based Pharmacy System

**FinalProjectCC** is a cloud-native e-commerce application designed for the pharmaceutical industry. Developed as the final project for the **Cloud Computing** course, this system allows customers to browse medicines, upload prescriptions, and manage orders securely.

The core focus of this project is its robust deployment architecture on **Amazon Web Services (AWS)**, demonstrating scalability, security, and high availability.

##  Cloud Architecture (AWS)

This application is deployed using a standard scalable cloud infrastructure:

  * **Compute:** Hosted on **Amazon EC2** instances (Auto Scaling Group) to handle varying traffic loads.
  * **Database:** Managed relational database using **Amazon RDS** (MySQL) for reliability and automated backups.
  * **Storage:** **Amazon S3** is used for storing static assets, product images, and user-uploaded prescriptions.
  * **Networking:** Configured within a **VPC** with Public/Private subnets and Security Groups to ensure secure data access.
  * **Load Balancing:** **Application Load Balancer (ALB)** distributes incoming traffic across instances.

##  Tech Stack

  * **Framework:** [Laravel](https://laravel.com/) (PHP)
  * **Frontend:** Blade Templates / Tailwind CSS
  * **Database:** MySQL (AWS RDS)
  * **Cloud Provider:** AWS

##  Key Features

  * **Product Catalog:** Browse medicines by category (OTC, Prescription, etc.).
  * **Digital Prescriptions:** Secure upload feature for doctor's notes/prescriptions directly to S3.
  * **Cart & Checkout:** Complete B2C ordering flow.
  * **Admin Dashboard:** Manage inventory, view orders, and verify prescriptions.
