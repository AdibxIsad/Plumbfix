# Plumbfix: Plumbing Management System - Use Case Descriptions

This document provides detailed Use Case Specifications (Descriptions) for all **24 Use Cases** defined in the **Plumbfix Use Case Diagram**.

---

## Table of Contents

1. [UC-01: Login](#uc-01-login)
2. [UC-02: Create Account](#uc-02-create-account)
3. [UC-03: View Account](#uc-03-view-account)
4. [UC-04: Update Account](#uc-04-update-account)
5. [UC-05: Delete Account](#uc-05-delete-account)
6. [UC-06: Create Booking](#uc-06-create-booking)
7. [UC-07: View Booking](#uc-07-view-booking)
8. [UC-08: Update Booking](#uc-08-update-booking)
9. [UC-09: Delete Booking](#uc-09-delete-booking)
10. [UC-10: Create Payment](#uc-10-create-payment)
11. [UC-11: View Payment](#uc-11-view-payment)
12. [UC-12: Update Payment](#uc-12-update-payment)
13. [UC-13: Create Refund](#uc-13-create-refund)
14. [UC-14: View Refund](#uc-14-view-refund)
15. [UC-15: Update Refund](#uc-15-update-refund)
16. [UC-16: Create Job Record](#uc-16-create-job-record)
17. [UC-17: View Job Record](#uc-17-view-job-record)
18. [UC-18: Update Job Record](#uc-18-update-job-record)
19. [UC-19: Generate Report](#uc-19-generate-report)
20. [UC-20: Create Feedback](#uc-20-create-feedback)
21. [UC-21: View Feedback](#uc-21-view-feedback)
22. [UC-22: Create Chat Message](#uc-22-create-chat-message)
23. [UC-23: View Chat Messages](#uc-23-view-chat-messages)
24. [UC-24: View Push Notifications](#uc-24-view-push-notifications)

---

## Use Case Specifications

### UC-01: Login

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-01 |
| **Use Case Name** | Login |
| **Primary Actor(s)** | Customer, Admin / Staff |
| **Description** | Authenticates user credentials (email and password) to grant secure access to role-specific dashboards. |
| **Preconditions** | User must have an active registered account in the system database. |
| **Postconditions** | An authenticated session is initiated, and the user is redirected to their respective home/dashboard page. |
| **Basic Flow** | 1. User accesses the login page.<br>2. User enters registered email address and password.<br>3. User clicks the "Login" button.<br>4. System validates inputs and verifies credentials against stored password hashes.<br>5. System authorizes the session and redirects Customer to Customer Dashboard or Staff to Staff Dashboard. |
| **Alternative / Exception Flow** | **4a. Invalid Credentials:** System displays an error notification ("Invalid credentials provided") and prompts user to re-enter email or password. |

---

### UC-02: Create Account

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-02 |
| **Use Case Name** | Create Account |
| **Primary Actor(s)** | Customer, Admin / Staff |
| **Description** | Enables new customers to register a user account, or allows Admins to provision new plumber/staff profiles. |
| **Preconditions** | Email address used for registration must not already exist in the database. |
| **Postconditions** | A new user profile record is created in the database and credentials are stored securely. |
| **Basic Flow** | 1. User navigates to the Registration page (or Admin accesses Staff Management).<br>2. User fills in required fields (Name, Email, Phone, Address, Password).<br>3. User submits the registration form.<br>4. System validates field formats and checks for email uniqueness.<br>5. System hashes password, saves record to database, and confirms registration. |
| **Alternative / Exception Flow** | **4a. Existing Email / Validation Failure:** System flags invalid or duplicate input fields and requests correction. |

---

### UC-03: View Account

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-03 |
| **Use Case Name** | View Account |
| **Primary Actor(s)** | Customer, Admin / Staff |
| **Description** | Displays comprehensive account profile details including personal information, contact information, role, and address. |
| **Preconditions** | User must be logged into the system. |
| **Postconditions** | Profile details are rendered on screen for user review. |
| **Basic Flow** | 1. User selects the "Profile" / "Account Details" menu option.<br>2. System queries database for authenticated user ID.<br>3. System retrieves profile attributes (Name, Email, Contact Number, Address, Role).<br>4. System renders the account profile view. |
| **Alternative / Exception Flow** | **2a. Session Expired:** System redirects user to the Login page with a session timeout warning. |

---

### UC-04: Update Account

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-04 |
| **Use Case Name** | Update Account |
| **Primary Actor(s)** | Customer, Admin / Staff |
| **Description** | Allows users to modify their personal details, contact number, address, or password credentials. |
| **Preconditions** | User is authenticated and viewing their profile page. |
| **Postconditions** | Updated user details are stored in database records. |
| **Basic Flow** | 1. User edits target profile fields (e.g. phone number, address) or changes password.<br>2. User clicks "Save Changes" / "Update Profile".<br>3. System validates input formatting and password security rules.<br>4. System updates database record and returns a success notification. |
| **Alternative / Exception Flow** | **3a. Validation Error:** System halts submission and highlights invalid fields (e.g., weak password, improper phone format). |

---

### UC-05: Delete Account

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-05 |
| **Use Case Name** | Delete Account |
| **Primary Actor(s)** | Customer, Admin / Staff |
| **Description** | Enables Admins to remove plumber/staff accounts or allows customers to deactivate their profiles. |
| **Preconditions** | User is authenticated; Admin has appropriate privileges to delete staff accounts. |
| **Postconditions** | The specified user account is removed or soft-deleted from the active database records. |
| **Basic Flow** | 1. Admin/Customer navigates to account management and selects an account to delete.<br>2. User clicks "Delete Account" and confirms deletion modal.<br>3. System verifies user authorization.<br>4. System deletes/deactivates the user record in database.<br>5. System logs out deleted user or refreshes staff directory list with success notice. |
| **Alternative / Exception Flow** | **2a. Action Cancelled:** User cancels confirmation prompt; no changes occur. |

---

### UC-06: Create Booking

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-06 |
| **Use Case Name** | Create Booking |
| **Primary Actor(s)** | Customer, Admin / Staff |
| **Description** | Allows Customers (or Staff on behalf of customers) to schedule a new plumbing service appointment by specifying problem details, preferred date, and time slot. |
| **Preconditions** | User is logged in; selected time slot must be available. |
| **Postconditions** | A new booking entry is created with status set to `pending`. |
| **Basic Flow** | 1. Customer opens "New Booking" page.<br>2. Customer selects plumbing service type, appointment date, time slot, and enters problem description/photos.<br>3. Customer submits booking form.<br>4. System verifies slot availability and stores booking record with `pending` status.<br>5. System alerts user to proceed with deposit payment. |
| **Alternative / Exception Flow** | **4a. Slot Unavailable:** System alerts user that chosen schedule slot is already booked and requests selection of an alternate date/time. |

---

### UC-07: View Booking

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-07 |
| **Use Case Name** | View Booking |
| **Primary Actor(s)** | Customer, Admin / Staff |
| **Description** | Displays single or listed booking appointments including status, date/time, assigned plumber, and problem descriptions. |
| **Preconditions** | User is authenticated. |
| **Postconditions** | Relevant booking details are rendered on screen. |
| **Basic Flow** | 1. User opens "My Bookings" (Customer) or "Booking Management" (Staff).<br>2. System fetches matching bookings from database.<br>3. System displays booking list categorized by status (Pending, In Progress, Completed, Cancelled).<br>4. User clicks specific booking to view detailed appointment card. |
| **Alternative / Exception Flow** | **2a. No Bookings Found:** System displays an empty state message with a prompt to create a new booking. |

---

### UC-08: Update Booking

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-08 |
| **Use Case Name** | Update Booking |
| **Primary Actor(s)** | Admin / Staff, Customer |
| **Description** | Allows Staff/Admins to assign plumbers, reschedule dates, or update booking status (e.g. In Progress, Completed); allows Customers to edit unconfirmed booking details. |
| **Preconditions** | Booking record exists in database. |
| **Postconditions** | Booking record details and status are updated. |
| **Basic Flow** | 1. Staff selects a target booking from the management dashboard.<br>2. Staff updates status dropdown, assigns a plumber, or changes scheduled date/time.<br>3. Staff submits update.<br>4. System updates database and sends push notification to customer. |
| **Alternative / Exception Flow** | **2a. Plumber Conflict:** System warns if assigned plumber already has an overlapping appointment slot. |

---

### UC-09: Delete Booking

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-09 |
| **Use Case Name** | Delete Booking |
| **Primary Actor(s)** | Customer, Admin / Staff |
| **Description** | Enables Customers to cancel an appointment or allows Admins to remove invalid booking records. |
| **Preconditions** | Booking must be in `pending` or `confirmed` status (prior to job start). |
| **Postconditions** | Booking status changes to `cancelled` and refund eligibility is calculated. |
| **Basic Flow** | 1. Customer/Staff selects "Cancel Booking" on an active booking.<br>2. User inputs cancellation reason and confirms action.<br>3. System calculates refund eligibility based on deposit rules.<br>4. System marks booking as `cancelled` and initiates refund process if applicable. |
| **Alternative / Exception Flow** | **1a. Cancellation Window Passed:** If cancelled too close to appointment time, system warns user deposit may not be refundable. |

---

### UC-10: Create Payment

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-10 |
| **Use Case Name** | Create Payment |
| **Primary Actor(s)** | Customer, Admin / Staff |
| **Description** | Allows Customers to upload payment receipt images or input transaction details for booking deposits or total charges. |
| **Preconditions** | A booking entry exists requiring deposit or balance payment. |
| **Postconditions** | Payment receipt record is stored with status `Awaiting Verification`. |
| **Basic Flow** | 1. Customer navigates to payment screen for an active booking.<br>2. Customer uploads bank transfer receipt / payment slip image.<br>3. Customer submits payment.<br>4. System saves file asset and links receipt record to booking with status `Awaiting Verification`. |
| **Alternative / Exception Flow** | **2a. Invalid Image Format:** System rejects non-image files or files exceeding size limits (e.g. >5MB). |

---

### UC-11: View Payment

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-11 |
| **Use Case Name** | View Payment |
| **Primary Actor(s)** | Customer, Staff |
| **Description** | Displays payment details, transaction status, receipt image previews, and generates downloadable PDF receipts. |
| **Preconditions** | Payment record exists in database. |
| **Postconditions** | Payment details or downloadable PDF invoice are rendered to user. |
| **Basic Flow** | 1. User clicks "View Payment Details" or "Download Receipt" for a booking.<br>2. System fetches payment receipt record and invoice data.<br>3. System displays payment overview modal or streams PDF receipt download. |
| **Alternative / Exception Flow** | **2a. Receipt File Missing:** System alerts user and prompts re-upload or admin intervention. |

---

### UC-12: Update Payment

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-12 |
| **Use Case Name** | Update Payment |
| **Primary Actor(s)** | Staff, Admin |
| **Description** | Allows Admin/Staff to review submitted payment receipts and update status to `Paid` (Approve) or `Rejected`. |
| **Preconditions** | Payment receipt exists in `Awaiting Verification` state. |
| **Postconditions** | Payment status is updated to `Paid` or `Rejected`, updating booking status accordingly. |
| **Basic Flow** | 1. Admin accesses Payment Verification dashboard.<br>2. Admin reviews uploaded receipt screenshot against bank records.<br>3. Admin selects "Approve" (assigning staff) or "Reject" (entering rejection reason).<br>4. System updates payment status and sends push notification to customer. |
| **Alternative / Exception Flow** | **3a. Rejection Flow:** If rejected, customer is prompted to upload a valid payment receipt. |

---

### UC-13: Create Refund

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-13 |
| **Use Case Name** | Create Refund |
| **Primary Actor(s)** | Staff, Admin |
| **Description** | Generates a refund request entry when an eligible booking is cancelled by a customer or staff. |
| **Preconditions** | Booking was cancelled with deposit paid and verified as eligible for refund. |
| **Postconditions** | A refund record is initiated with status `pending`. |
| **Basic Flow** | 1. System processes booking cancellation (UC-09).<br>2. System evaluates refund rules (e.g. full/partial deposit refund).<br>3. System creates refund entry with status `pending` and sets refund amount.<br>4. Notification sent to Admin refund queue. |
| **Alternative / Exception Flow** | **2a. Non-Refundable Policy:** If booking was cancelled last minute, system marks refund status as `not_applicable`. |

---

### UC-14: View Refund

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-14 |
| **Use Case Name** | View Refund |
| **Primary Actor(s)** | Staff, Admin |
| **Description** | Displays refund request status, calculated refund amounts, bank account details, and proof of refund transfer slips. |
| **Preconditions** | Refund record associated with a booking exists. |
| **Postconditions** | Refund details screen is displayed to user. |
| **Basic Flow** | 1. User navigates to Refund List / Cancellation Summary.<br>2. System queries bookings with active refund records.<br>3. System presents refund status (`pending` or `refunded`), refund amount, and proof upload link. |
| **Alternative / Exception Flow** | **2a. No Refunds Exist:** Display empty table with status banner. |

---

### UC-15: Update Refund

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-15 |
| **Use Case Name** | Update Refund |
| **Primary Actor(s)** | Staff, Admin |
| **Description** | Enables Admin/Staff to process refund payments, attach bank transfer refund receipts, and update status to `Refunded`. |
| **Preconditions** | Refund status is `pending`. |
| **Postconditions** | Refund status is updated to `refunded` with proof receipt attached. |
| **Basic Flow** | 1. Admin opens Refund Management dashboard.<br>2. Admin selects pending refund request.<br>3. Admin uploads bank transfer refund proof image and inputs transaction reference/notes.<br>4. Admin submits update.<br>5. System updates refund status to `refunded` and notifies customer. |
| **Alternative / Exception Flow** | **3a. Missing Proof:** System requires receipt file upload before setting status to `refunded`. |

---

### UC-16: Create Job Record

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-16 |
| **Use Case Name** | Create Job Record |
| **Primary Actor(s)** | Staff, Admin |
| **Description** | Allows Plumbers/Staff to create a job completion record detailing materials used, total cost, work summary, and completion date. |
| **Preconditions** | Service booking is assigned to plumber and in progress. |
| **Postconditions** | Job record entry created and booking status updated to `completed`. |
| **Basic Flow** | 1. Plumber completes physical plumbing job.<br>2. Plumber opens "Create Job Record" form.<br>3. Plumber inputs total cost, completion date, parts replaced, and job notes.<br>4. Plumber submits record.<br>5. System creates job record, marks booking as `completed`, and generates final billing balance. |
| **Alternative / Exception Flow** | **3a. Incomplete Fields:** System requires total cost and work notes prior to submission. |

---

### UC-17: View Job Record

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-17 |
| **Use Case Name** | View Job Record |
| **Primary Actor(s)** | Staff, Customer |
| **Description** | Allows Customers and Staff to inspect completed job details, total work cost, replaced parts breakdown, and invoice summaries. |
| **Preconditions** | Job record has been generated for a booking. |
| **Postconditions** | Complete job record details are rendered on screen. |
| **Basic Flow** | 1. User selects "View Job Summary" / "Invoice" on a completed booking.<br>2. System fetches corresponding job record entry.<br>3. System displays job completion summary, cost breakdown, assigned plumber, and completion date. |
| **Alternative / Exception Flow** | **2a. Record Not Found:** System notifies user job record is currently being compiled by plumber. |

---

### UC-18: Update Job Record

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-18 |
| **Use Case Name** | Update Job Record |
| **Primary Actor(s)** | Staff, Admin |
| **Description** | Enables Plumbers or Admins to edit existing job record entries (e.g., adjusting total cost or updating work notes). |
| **Preconditions** | Job record exists in database. |
| **Postconditions** | Updated job record values are saved in database. |
| **Basic Flow** | 1. Staff selects an existing job record and clicks "Edit Record".<br>2. Staff updates cost fields, additional notes, or completion details.<br>3. Staff submits updates.<br>4. System validates inputs and updates database record. |
| **Alternative / Exception Flow** | **3a. Authorization Failure:** Non-assigned staff without admin privileges are blocked from modifying records. |

---

### UC-19: Generate Report

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-19 |
| **Use Case Name** | Generate Report |
| **Primary Actor(s)** | Staff, Admin |
| **Description** | Provides Admins with business intelligence analytics, revenue reports, booking count statistics, and Month-over-Month (MoM) performance charts. |
| **Preconditions** | User must be logged in as an Admin. |
| **Postconditions** | Visual charts and summary statistics tables are rendered on the analytics dashboard. |
| **Basic Flow** | 1. Admin navigates to "Reports & Analytics" tab.<br>2. Admin selects date range / year filter (e.g. 2026).<br>3. System aggregates data from `job_records`, `bookings`, and `payment_receipts`.<br>4. System displays total revenue, completed jobs, active customers, and interactive monthly revenue charts. |
| **Alternative / Exception Flow** | **3a. Data Gap:** If no completed jobs exist for chosen range, chart renders zero values with empty state indicator. |

---

### UC-20: Create Feedback

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-20 |
| **Use Case Name** | Create Feedback |
| **Primary Actor(s)** | Customer, Staff |
| **Description** | Allows Customers to rate service quality, write reviews, and upload feedback photos; allows Staff to post official response comments. |
| **Preconditions** | Booking status must be `completed`. |
| **Postconditions** | A feedback record is created in database and linked to booking. |
| **Basic Flow** | 1. Customer selects "Leave Feedback" on completed booking.<br>2. Customer selects 1–5 star rating, types review comments, and attaches photo.<br>3. Customer submits review.<br>4. System validates rating input and saves feedback entry to database. |
| **Alternative / Exception Flow** | **1a. Duplicate Review:** System blocks multiple feedback submissions for the same completed booking ID. |

---

### UC-21: View Feedback

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-21 |
| **Use Case Name** | View Feedback |
| **Primary Actor(s)** | Customer, Admin |
| **Description** | Displays customer service reviews, star ratings, attached review photos, and staff response messages. |
| **Preconditions** | Feedback entries exist in database. |
| **Postconditions** | Feedback list/review board is rendered. |
| **Basic Flow** | 1. User navigates to Feedback page.<br>2. System fetches customer feedback records with related customer names and booking info.<br>3. System renders feedback items sorted by submission date. |
| **Alternative / Exception Flow** | **2a. Filter Reviews:** User can filter feedback by star rating or specific plumber. |

---

### UC-22: Create Chat Message

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-22 |
| **Use Case Name** | Create Chat Message |
| **Primary Actor(s)** | Customer, Admin / Staff |
| **Description** | Facilitates real-time communication between Customer and Staff/Plumber regarding booking details and service inquiries. |
| **Preconditions** | Active booking exists linking Customer and assigned Plumber/Staff. |
| **Postconditions** | Message record is created, appended to chat timeline, and notification sent to recipient. |
| **Basic Flow** | 1. User opens booking chat window.<br>2. User types message text into chat input field and clicks Send.<br>3. System creates chat message record with timestamp and sender role.<br>4. System appends message to timeline and broadcasts update to recipient. |
| **Alternative / Exception Flow** | **2a. Empty Message:** System prevents sending empty message strings. |

---

### UC-23: View Chat Messages

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-23 |
| **Use Case Name** | View Chat Messages |
| **Primary Actor(s)** | Customer, Admin / Staff |
| **Description** | Loads full conversation message history for a specific booking and updates unread message read indicators. |
| **Preconditions** | User is authenticated and participant in booking session. |
| **Postconditions** | Conversation history rendered; unread messages marked as `is_read = true`. |
| **Basic Flow** | 1. User selects "Chat" icon on a booking.<br>2. System retrieves chronological chat messages for booking ID.<br>3. System sets incoming unread messages to `is_read = true`.<br>4. System renders conversation bubble layout. |
| **Alternative / Exception Flow** | **2a. No Prior Messages:** System displays initial empty chat prompt ("Start a conversation regarding your booking"). |

---

### UC-24: View Push Notifications

| Attribute | Specification |
| :--- | :--- |
| **Use Case ID** | UC-24 |
| **Use Case Name** | View Push Notifications |
| **Primary Actor(s)** | Customer, Admin / Staff |
| **Description** | Displays user-specific real-time notifications regarding booking updates, payment status changes, and new chat messages. |
| **Preconditions** | User is authenticated. |
| **Postconditions** | Notification dropdown list is displayed and unread counter updated. |
| **Basic Flow** | 1. User clicks notification bell icon in navigation header.<br>2. System queries user's unread notification entries.<br>3. System displays notification list items with title, preview text, and timestamp.<br>4. Clicking a notification redirects user to relevant screen (e.g. Booking details, Payment screen). |
| **Alternative / Exception Flow** | **2a. Zero Unread Notifications:** System displays notification dropdown with message "No new notifications". |
