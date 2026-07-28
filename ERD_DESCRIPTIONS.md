# Plumbfix Database Entity Descriptions

This document provides a summary of all entities defined in the Plumbfix Entity Relationship Diagram (ERD).

---

## Entity Descriptions Table

| Entity | Description |
| :--- | :--- |
| **Staff** (`staffs`) | Store the information of staff members and plumbers, including contact details, admin hierarchy, and account status |
| **Customer** (`customers`) | Store the information of registered customers, including personal profiles, addresses, contact details, and bank account info |
| **Notification** (`notifications`) | Store the information of push and in-app system notifications sent to customers and staff members |
| **Booking** (`bookings`) | Store the information of plumbing service bookings, appointment dates, time slots, problem descriptions, and booking statuses |
| **Payment** (`payments`) | Store the information of booking payments, deposit amounts, payment verification statuses, payment methods, and verifier details |
| **PaymentReceipt** (`payment_receipts`) | Store the information of uploaded payment receipt images, upload timestamps, verification statuses, and verification remarks |
| **Cancellation** (`cancellations`) | Store the information of cancelled service bookings, including cancellation dates, reasons, and descriptions |
| **Refund** (`refunds`) | Store the information of booking refund requests, refund amounts, processing statuses, completion dates, refund proof slips, and remarks |
| **JobRecord** (`job_records`) | Store the information of completed plumbing jobs, completion dates, itemized costs, service notes, and job attachments |
| **Feedback** (`feedbacks`) | Store the information of customer ratings, review comments, attached review photos, and staff response messages |
| **ChatMessage** (`chat_messages`) | Store the information of chat messages exchanged between customers and plumbers for active bookings, including senders and read statuses |

---

## Entity Relationship Overview

1. **Staff**: Manages multiple **Booking** entries, creates **JobRecord** entries, receives **Notification** updates, and can handle/supervise other **Staff** members.
2. **Customer**: Makes **Booking** entries, submits **Feedback**, receives **Notification** updates, and initiates payments.
3. **Booking**: Central entity connected to **Customer**, **Staff**, **Payment**, **Cancellation**, **JobRecord**, **Feedback**, and **ChatMessage**.
4. **Payment**: Belongs to a **Booking** and holds one or more **PaymentReceipt** verification files.
5. **Cancellation**: Linked to a cancelled **Booking** and triggers a **Refund** entry if eligible.
6. **Refund**: Linked to a **Cancellation** to track money refunded to the customer.
7. **JobRecord**: Created by **Staff** for a completed **Booking** detailing final cost and work done.
8. **Feedback**: Submitted by a **Customer** for a completed **Booking** with rating and staff response.
9. **ChatMessage**: Contains real-time communication messages for a specific **Booking**.
10. **Notification**: Polymorphic notification entries received by **Customer** or **Staff**.
