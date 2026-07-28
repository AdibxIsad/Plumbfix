# Plumbfix Package Diagram Functions and Content

This document provides the Package Functions and Package Content tables mapped directly from the **Plumbfix Package Diagram**.

---

### 4.1.2 Package Functions

#### Table 4.1 Package functions

| Package | Package Functions |
| :--- | :--- |
| **View Layer**<br>`(SDD_PKG_100)` | • To display form<br>• To display data and accept input data<br>• To update and validate input data<br>• To submit user requests and render system feedback |
| **Domain Layer (Controllers)**<br>`(SDD_PKG_200)` | • To process system rules with logic<br>• To control the information from the view layer to the data access layer<br>• To manage user authentication, session state, and business workflow processing |
| **Data Access Layer (Eloquent Models)**<br>`(SDD_PKG_300)` | • To establish and maintain the connection of database<br>• To define entity relational mappings and model attributes<br>• To retrieve and manipulate data from the database via SQL queries |

---

### 4.1.3 Package Content

#### Table 4.2 Package Content

| Package | Class ID | Class Name |
| :--- | :--- | :--- |
| **View Layer**<br>`(SDD_PKG_100)` | SDD_CLASS_101 | welcome |
| | SDD_CLASS_102 | login |
| | SDD_CLASS_103 | register |
| | SDD_CLASS_104 | customer_dashboard |
| | SDD_CLASS_105 | customer_profile |
| | SDD_CLASS_106 | customer_bookings |
| | SDD_CLASS_107 | customer_booking_create |
| | SDD_CLASS_108 | customer_payment |
| | SDD_CLASS_109 | customer_feedback |
| | SDD_CLASS_110 | staff_dashboard |
| | SDD_CLASS_111 | staff_profile |
| | SDD_CLASS_112 | staff_bookings |
| | SDD_CLASS_113 | staff_job_records |
| | SDD_CLASS_114 | staff_job_record_create |
| | SDD_CLASS_115 | admin_plumbers |
| | SDD_CLASS_116 | admin_payment_verification |
| | SDD_CLASS_117 | admin_refunds |
| | SDD_CLASS_118 | admin_analytics |
| **Domain Layer (Controllers)**<br>`(SDD_PKG_200)` | SDD_CLASS_201 | LoginController |
| | SDD_CLASS_202 | RegisterController |
| | SDD_CLASS_203 | ChatController |
| | SDD_CLASS_204 | GoogleAuthController |
| | SDD_CLASS_205 | CustomerController |
| | SDD_CLASS_206 | StaffController |
| | SDD_CLASS_207 | PlumberController |
| | SDD_CLASS_208 | PaymentController |
| | SDD_CLASS_209 | PaymentVerificationController |
| | SDD_CLASS_210 | RefundController |
| | SDD_CLASS_211 | AnalyticsController |
| | SDD_CLASS_212 | InvoiceController |
| **Data Access Layer (Eloquent Models)**<br>`(SDD_PKG_300)` | SDD_CLASS_301 | Customer |
| | SDD_CLASS_302 | Staff |
| | SDD_CLASS_303 | Booking |
| | SDD_CLASS_304 | Payment |
| | SDD_CLASS_305 | PaymentReceipt |
| | SDD_CLASS_306 | Cancellation |
| | SDD_CLASS_307 | Refund |
| | SDD_CLASS_308 | JobRecord |
| | SDD_CLASS_309 | ChatMessage |
| | SDD_CLASS_310 | Feedback |
| | SDD_CLASS_311 | Notification |
