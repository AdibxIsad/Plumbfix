# Plumbfix Database Data Dictionary

This document contains the comprehensive **Data Dictionary** for the Plumbfix Plumbing Management System database schema based on the system's Entity Relationship Diagram (ERD).

**Legend:**
- **M**: Mandatory? (Y = Yes / NOT NULL, N = No / NULLable)
- **U**: Unique? (Y = Yes / UNIQUE / Primary Key, N = No)

---

## Table of Contents

1. [1. Staff](#1-staff)
2. [2. Customer](#2-customer)
3. [3. Notification](#3-notification)
4. [4. Booking](#4-booking)
5. [5. Payment](#5-payment)
6. [6. PaymentReceipt](#6-paymentreceipt)
7. [7. Cancellation](#7-cancellation)
8. [8. Refund](#8-refund)
9. [9. JobRecord](#9-jobrecord)
10. [10. Feedback](#10-feedback)
11. [11. ChatMessage](#11-chatmessage)

---

### 1. Staff

| Attribute Name | Description | Type | Additional Type Information | Default Value | M | U |
| :--- | :--- | :--- | :--- | :--- | :---: | :---: |
| **staffID** | Primary Key ID for each staff member | int | max = 11 | AUTO_INCREMENT | Y | Y |
| **adminID** | Foreign Key ID for managing admin | int | max = 11 | - | N | N |
| **staffName** | Full name of staff member | varchar | max = 255 | - | Y | N |
| **staffEmail** | Email address of staff member | varchar | max = 255 | - | Y | Y |
| **staffPhoneNo** | Phone number of staff member | varchar | max = 20 | - | Y | N |
| **staffPassword** | Hashed account password | varchar | max = 255 | - | Y | N |
| **staffStatus** | Account status (e.g. active, inactive) | varchar | max = 50 | 'active' | Y | N |

---

### 2. Customer

| Attribute Name | Description | Type | Additional Type Information | Default Value | M | U |
| :--- | :--- | :--- | :--- | :--- | :---: | :---: |
| **customerID** | Primary Key ID for each customer | int | max = 11 | AUTO_INCREMENT | Y | Y |
| **customerName** | Full name of customer | varchar | max = 255 | - | Y | N |
| **customerEmail** | Email address of customer | varchar | max = 255 | - | Y | Y |
| **customerPhoneNo** | Contact phone number of customer | varchar | max = 20 | - | Y | N |
| **customerAddress** | Full residential/service address | text | - | - | Y | N |
| **customerPassword** | Hashed account password | varchar | max = 255 | - | Y | N |
| **customerBankName** | Bank name for refund processing | varchar | max = 100 | - | N | N |
| **customerBankAccountNo** | Bank account number for refund processing | varchar | max = 50 | - | N | N |

---

### 3. Notification

| Attribute Name | Description | Type | Additional Type Information | Default Value | M | U |
| :--- | :--- | :--- | :--- | :--- | :---: | :---: |
| **id** | Primary Key ID for each notification | int | max = 11 | AUTO_INCREMENT | Y | Y |
| **notifiableID** | ID of recipient entity (Customer / Staff) | int | max = 11 | - | Y | N |
| **notifiableType** | Model class type of recipient entity | varchar | max = 255 | - | Y | N |
| **data** | JSON payload containing notification details | text | - | - | Y | N |
| **readAt** | Timestamp when notification was read | timestamp | - | - | N | N |
| **createdAt** | Timestamp when notification was created | timestamp | - | CURRENT_TIMESTAMP | Y | N |

---

### 4. Booking

| Attribute Name | Description | Type | Additional Type Information | Default Value | M | U |
| :--- | :--- | :--- | :--- | :--- | :---: | :---: |
| **bookingID** | Primary Key ID for each service booking | int | max = 11 | AUTO_INCREMENT | Y | Y |
| **customerID** | Foreign Key ID of booking customer | int | max = 11 | - | Y | N |
| **staffID** | Foreign Key ID of assigned staff/plumber | int | max = 11 | - | N | N |
| **bookingType** | Category of plumbing service requested | varchar | max = 100 | - | Y | N |
| **bookingProblem** | Short summary title of plumbing issue | varchar | max = 255 | - | Y | N |
| **bookingIssueDescription** | Detailed description of plumbing problem | text | - | - | N | N |
| **bookingDate** | Scheduled date of appointment | date | - | - | Y | N |
| **bookingTime** | Scheduled time slot of appointment | time | - | - | Y | N |
| **bookingStatus** | Status of booking (e.g. pending, in_progress, completed, cancelled) | varchar | max = 50 | 'pending' | Y | N |
| **bookingAttachment** | File path of uploaded problem photo | varchar | max = 255 | - | N | N |

---

### 5. Payment

| Attribute Name | Description | Type | Additional Type Information | Default Value | M | U |
| :--- | :--- | :--- | :--- | :--- | :---: | :---: |
| **paymentID** | Primary Key ID for each payment record | int | max = 11 | AUTO_INCREMENT | Y | Y |
| **cancellationID** | Foreign Key ID of associated cancellation (if applicable) | int | max = 11 | - | N | N |
| **depositAmount** | Amount of deposit paid by customer | decimal | 10,2 | 0.00 | Y | N |
| **depositStatus** | Status of deposit (e.g. unpaid, paid) | varchar | max = 50 | 'unpaid' | Y | N |
| **verificationStatus** | Staff verification status (e.g. pending, approved, rejected) | varchar | max = 50 | 'pending' | Y | N |
| **submittedAt** | Timestamp when payment proof was submitted | timestamp | - | - | N | N |
| **verifiedAt** | Timestamp when payment was verified | timestamp | - | - | N | N |
| **verifiedBy** | Foreign Key ID of staff who verified payment | int | max = 11 | - | N | N |
| **rejectionReason** | Explanation for payment rejection | text | - | - | N | N |
| **paymentMethod** | Payment method used (e.g. Online Transfer) | varchar | max = 50 | 'Online Transfer' | Y | N |

---

### 6. PaymentReceipt

| Attribute Name | Description | Type | Additional Type Information | Default Value | M | U |
| :--- | :--- | :--- | :--- | :--- | :---: | :---: |
| **receiptID** | Primary Key ID for payment receipt | int | max = 11 | AUTO_INCREMENT | Y | Y |
| **paymentID** | Foreign Key ID of associated payment record | int | max = 11 | - | Y | N |
| **receiptPath** | Storage file path of uploaded receipt image | varchar | max = 255 | - | Y | N |
| **uploadedAt** | Timestamp when receipt image was uploaded | timestamp | - | CURRENT_TIMESTAMP | Y | N |
| **receiptStatus** | Status of receipt verification | varchar | max = 50 | 'pending' | Y | N |
| **receiptRemarks** | Staff remarks regarding receipt proof | text | - | - | N | N |

---

### 7. Cancellation

| Attribute Name | Description | Type | Additional Type Information | Default Value | M | U |
| :--- | :--- | :--- | :--- | :--- | :---: | :---: |
| **cancellationID** | Primary Key ID for cancellation record | int | max = 11 | AUTO_INCREMENT | Y | Y |
| **bookingID** | Foreign Key ID of cancelled booking | int | max = 11 | - | Y | N |
| **cancelledAt** | Timestamp when booking was cancelled | timestamp | - | CURRENT_TIMESTAMP | Y | N |
| **reason** | Reason category for cancellation | varchar | max = 255 | - | Y | N |
| **description** | Detailed explanation of cancellation | text | - | - | N | N |

---

### 8. Refund

| Attribute Name | Description | Type | Additional Type Information | Default Value | M | U |
| :--- | :--- | :--- | :--- | :--- | :---: | :---: |
| **refundID** | Primary Key ID for refund record | int | max = 11 | AUTO_INCREMENT | Y | Y |
| **cancellationID** | Foreign Key ID of associated cancellation | int | max = 11 | - | Y | N |
| **refundAmount** | Amount to be refunded to customer | decimal | 10,2 | 0.00 | Y | N |
| **refundStatus** | Status of refund processing (e.g. pending, refunded) | varchar | max = 50 | 'pending' | Y | N |
| **completedAt** | Timestamp when refund transfer was completed | timestamp | - | - | N | N |
| **receiptPath** | File path of refund proof transfer slip | varchar | max = 255 | - | N | N |
| **remarks** | Staff notes or remarks on refund transaction | text | - | - | N | N |

---

### 9. JobRecord

| Attribute Name | Description | Type | Additional Type Information | Default Value | M | U |
| :--- | :--- | :--- | :--- | :--- | :---: | :---: |
| **jobRecordID** | Primary Key ID for completed job record | int | max = 11 | AUTO_INCREMENT | Y | Y |
| **bookingID** | Foreign Key ID of associated booking | int | max = 11 | - | Y | N |
| **staffID** | Foreign Key ID of staff/plumber who completed job | int | max = 11 | - | Y | N |
| **jobRecordCompletionDate** | Date and time when job was completed | datetime | - | - | Y | N |
| **jobRecordTotalCost** | Total billing cost of completed plumbing job | decimal | 10,2 | 0.00 | Y | N |
| **jobRecordNotes** | Work notes, replaced parts, and service summary | text | - | - | N | N |
| **jobRecordAttachments** | File path of job completion photos | varchar | max = 255 | - | N | N |

---

### 10. Feedback

| Attribute Name | Description | Type | Additional Type Information | Default Value | M | U |
| :--- | :--- | :--- | :--- | :--- | :---: | :---: |
| **feedbackID** | Primary Key ID for feedback record | int | max = 11 | AUTO_INCREMENT | Y | Y |
| **customerID** | Foreign Key ID of customer submitting feedback | int | max = 11 | - | Y | N |
| **bookingID** | Foreign Key ID of associated booking | int | max = 11 | - | Y | N |
| **feedbackComments** | Customer review comments | text | - | - | N | N |
| **staffResponse** | Response comment posted by staff/admin | text | - | - | N | N |
| **feedbackRating** | Rating score awarded by customer (1 to 5) | int | max = 1 | - | Y | N |
| **feedbackAttachments** | File path of customer attached review photos | varchar | max = 255 | - | N | N |

---

### 11. ChatMessage

| Attribute Name | Description | Type | Additional Type Information | Default Value | M | U |
| :--- | :--- | :--- | :--- | :--- | :---: | :---: |
| **chatMessageID** | Primary Key ID for chat message | int | max = 11 | AUTO_INCREMENT | Y | Y |
| **bookingID** | Foreign Key ID of associated booking chat session | int | max = 11 | - | Y | N |
| **senderID** | ID of message sender (Customer or Staff) | int | max = 11 | - | Y | N |
| **senderType** | Sender entity type ('Customer' or 'Staff') | varchar | max = 50 | - | Y | N |
| **message** | Text content of chat message | text | - | - | Y | N |
| **isRead** | Status flag indicating if message was read (0=Unread, 1=Read) | boolean | - | 0 | Y | N |
