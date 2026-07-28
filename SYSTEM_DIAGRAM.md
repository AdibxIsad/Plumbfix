# Plumbfix Multilayer System Sequence Diagrams (SSD)

This document contains the Multilayer System Sequence Diagrams (SSDs) mapped directly from the **Plumbfix: Plumbing Management System Use Case Diagram**. Each SSD represents a 5-layer software architecture flow:
1. **Actor** (Initiator: Admin/Staff or Customer)
2. **View (UI Layer)**: Blade templates and front-end pages
3. **Controller (Logical Layer)**: Laravel Controllers handling routing and business logic
4. **Model (Object Entity Layer)**: Laravel Eloquent Models representing core abstractions
5. **Database (Data Access Layer)**: The database engine executing SQL commands

---

## Table of Contents

1. [Architectural Layer Definitions](#architectural-layer-definitions)
2. [System Sequence Diagrams](#system-sequence-diagrams)
   - [UC-01: Login](#uc-01-login)
   - [UC-02: Create Account](#uc-02-create-account)
   - [UC-03: View Account](#uc-03-view-account)
   - [UC-04: Update Account](#uc-04-update-account)
   - [UC-05: Delete Account](#uc-05-delete-account)
   - [UC-06: Create Booking](#uc-06-create-booking)
   - [UC-07: View Booking](#uc-07-view-booking)
   - [UC-08: Update Booking](#uc-08-update-booking)
   - [UC-09: Delete Booking](#uc-09-delete-booking)
   - [UC-10: Create payment](#uc-10-create-payment)
   - [UC-11: View Payment](#uc-11-view-payment)
   - [UC-12: Update payment](#uc-12-update-payment)
   - [UC-13: Create Refund](#uc-13-create-refund)
   - [UC-14: View Refund](#uc-14-view-refund)
   - [UC-15: Update Refund](#uc-15-update-refund)
   - [UC-16: Create Job Record](#uc-16-create-job-record)
   - [UC-17: View Job Record](#uc-17-view-job-record)
   - [UC-18: Update Job Record](#uc-18-update-job-record)
   - [UC-19: Generate Report](#uc-19-generate-report)
   - [UC-20: Create Feedback](#uc-20-create-feedback)
   - [UC-21: View Feedback](#uc-21-view-feedback)
   - [UC-22: Create Chat Message](#uc-22-create-chat-message)
   - [UC-23: View Chat Messages](#uc-23-view-chat-messages)
   - [UC-24: View Push Notifications](#uc-24-view-push-notifications)

---

## Architectural Layer Definitions

- **Actor**: The human operator triggering the request. Classified as **Customer** or **Admin/Staff** (Admins or Plumbers).
- **View**: The browser frontend interface containing Blade templates (e.g. `login.blade.php`, `customer/dashboard.blade.php`, `staff/bookings.blade.php`) which renders forms, handles button clicks, and processes input files.
- **Controller**: Laravel Controller classes (e.g. `LoginController`, `CustomerController`, `StaffController`, `PaymentController`, `ChatController`) where request arguments are validated, policies checked, and workflows executed.
- **Model**: Eloquent Models representing relational database maps (`Customer`, `Staff`, `Booking`, `PaymentReceipt`, `JobRecord`, `Feedback`, `ChatMessage`, `Notification`).
- **Database (DB)**: The MySQL Database engine execution. It runs query instructions such as `SELECT`, `INSERT`, `UPDATE`, and `DELETE`.

---

## System Sequence Diagrams

### UC-01: Login
Authenticates and logs in a Customer or Admin/Staff into their session.

```mermaid
sequenceDiagram
    actor User as Customer / Staff
    participant View as login.blade.php (View)
    participant Controller as LoginController (Controller)
    participant Model as User/Customer/Staff (Model)
    participant DB as Database (DB)
    
    User->>View: submit login form (email, password)
    activate View
    View->>Controller: login(email, password)
    activate Controller
    Controller->>Model: attempt(credentials)
    activate Model
    Model->>DB: SELECT * FROM customers / staffs WHERE email = ? LIMIT 1
    activate DB
    DB-->>Model: user record & hashed password
    deactivate DB
    Model-->>Controller: success status boolean
    deactivate Model
    
    alt Login Successful
        Controller-->>View: redirect to dashboard
        View-->>User: render dashboard page
    else Login Failed
        Controller-->>View: return validation errors
        deactivate Controller
        View-->>User: display error alert
        deactivate View
    end
```

---

### UC-02: Create Account
Used by new Customers to register, or Admins to register a new plumber/staff profile.

```mermaid
sequenceDiagram
    actor User as Customer / Admin
    participant View as register / staff.plumbers (View)
    participant Controller as RegisterController / PlumberController (Controller)
    participant Model as Customer / Staff (Model)
    participant DB as Database (DB)
    
    User->>View: input details & click register / save
    activate View
    View->>Controller: register(data) / store(plumberData)
    activate Controller
    Controller->>Model: create(validatedData)
    activate Model
    Model->>DB: INSERT INTO customers / staffs (name, email, password, ...)
    activate DB
    DB-->>Model: confirm insertion & return row ID
    deactivate DB
    Model-->>Controller: accountInstance
    deactivate Model
    Controller-->>View: redirect to dashboard / list with success message
    deactivate Controller
    View-->>User: display success toast & update listing
    deactivate View
```

---

### UC-03: View Account
Retrieves and displays the Customer or Staff profile details on the user interface.

```mermaid
sequenceDiagram
    actor User as Customer / Staff
    participant View as profile.blade.php (View)
    participant Controller as CustomerController / StaffController (Controller)
    participant Model as Customer / Staff (Model)
    participant DB as Database (DB)
    
    User->>View: click profile page link
    activate View
    View->>Controller: profile()
    activate Controller
    Controller->>Model: Auth::user()
    activate Model
    Model->>DB: SELECT * FROM customers / staffs WHERE id = ?
    activate DB
    DB-->>Model: user details array
    deactivate DB
    Model-->>Controller: user profile object
    deactivate Model
    Controller-->>View: render profile view with user object
    deactivate Controller
    View-->>User: display profile details screen
    deactivate View
```

---

### UC-04: Update Account
Saves changes made to the user profile (e.g. addresses, password edits).

```mermaid
sequenceDiagram
    actor User as Customer / Staff
    participant View as profile.blade.php (View)
    participant Controller as CustomerController / StaffController (Controller)
    participant Model as Customer / Staff (Model)
    participant DB as Database (DB)
    
    User->>View: enter updated fields & submit profile form
    activate View
    View->>Controller: profileUpdate(requestFields)
    activate Controller
    Controller->>Model: fill(requestFields) & save()
    activate Model
    Model->>DB: UPDATE customers / staffs SET name=?, phone=?, address=? WHERE id=?
    activate DB
    DB-->>Model: confirm update success
    deactivate DB
    Model-->>Controller: success confirmation
    deactivate Model
    Controller-->>View: redirect back with success banner
    deactivate Controller
    View-->>User: display profile updated success alert
    deactivate View
```

---

### UC-05: Delete Account
Admins delete a plumber profile, or Customer accounts are deactivated.

```mermaid
sequenceDiagram
    actor Admin as Staff (Admin)
    participant View as staff.plumbers (View)
    participant Controller as PlumberController (Controller)
    participant Model as Staff (Model)
    participant DB as Database (DB)
    
    Admin->>View: click delete plumber profile button
    activate View
    View->>Controller: destroy(plumberID)
    activate Controller
    Controller->>Model: findOrFail(plumberID)
    activate Model
    Model->>DB: SELECT * FROM staffs WHERE staffID = ?
    activate DB
    DB-->>Model: plumber database record
    deactivate DB
    Controller->>Model: delete()
    Model->>DB: DELETE FROM staffs WHERE staffID = ?
    activate DB
    DB-->>Model: confirm deletion
    deactivate DB
    Model-->>Controller: success boolean
    deactivate Model
    Controller-->>View: redirect back to plumbers index with alert
    deactivate Controller
    View-->>Admin: update list and show plumber deleted notification
    deactivate View
```

---

### UC-06: Create Booking
Customers reserve a service booking slot by detailing their issue.

```mermaid
sequenceDiagram
    actor Customer
    participant View as booking-create.blade.php (View)
    participant Controller as CustomerController (Controller)
    participant Model as Booking (Model)
    participant DB as Database (DB)
    
    Customer->>View: select slot, upload photo & submit booking form
    activate View
    View->>Controller: bookingStore(bookingParams)
    activate Controller
    Controller->>Model: create(bookingParams, status='pending')
    activate Model
    Model->>DB: INSERT INTO bookings (customerID, type, problem, date, time, status, ...)
    activate DB
    DB-->>Model: record insertion confirmation
    deactivate DB
    Model-->>Controller: bookingInstance
    deactivate Model
    Controller-->>View: redirect to bookings list with success alert
    deactivate Controller
    View-->>Customer: display submitted booking card in booking history
    deactivate View
```

---

### UC-07: View Booking
Fetches details of past or pending booking appointments.

```mermaid
sequenceDiagram
    actor User as Customer / Staff
    participant View as bookings.blade.php (View)
    participant Controller as CustomerController / StaffController (Controller)
    participant Model as Booking (Model)
    participant DB as Database (DB)
    
    User->>View: open bookings index or filter dashboard lists
    activate View
    View->>Controller: bookings(year, month, date)
    activate Controller
    Controller->>Model: where('customerID', id)->with('staff')->get()
    activate Model
    Model->>DB: SELECT * FROM bookings JOIN staffs ON staffID WHERE ...
    activate DB
    DB-->>Model: collection of booking rows
    deactivate DB
    Model-->>Controller: bookings collections array
    deactivate Model
    Controller-->>View: render bookings view with collection array
    deactivate Controller
    View-->>User: display bookings calendar or listing page
    deactivate View
```

---

### UC-08: Update Booking
Staff members update scheduled times, update statuses, or assign plumbers.

```mermaid
sequenceDiagram
    actor Staff
    participant View as staff.bookings (View)
    participant Controller as StaffController (Controller)
    participant Model as Booking (Model)
    participant DB as Database (DB)
    
    Staff->>View: update booking status dropdown
    activate View
    View->>Controller: bookingUpdateStatus(bookingID, bookingStatus)
    activate Controller
    Controller->>Model: findOrFail(bookingID)
    activate Model
    Model->>DB: SELECT * FROM bookings WHERE bookingID = ?
    activate DB
    DB-->>Model: bookingInstance
    deactivate DB
    Controller->>Model: update(bookingStatus)
    Model->>DB: UPDATE bookings SET bookingStatus = ? WHERE bookingID = ?
    activate DB
    DB-->>Model: confirm update success
    deactivate DB
    Model-->>Controller: success boolean
    deactivate Model
    Controller-->>View: redirect to bookings index with success badge
    deactivate Controller
    View-->>Staff: update row design with new status tag
    deactivate View
```

---

### UC-09: Delete Booking
Customers cancel an existing booking request, releasing the scheduled slot.

```mermaid
sequenceDiagram
    actor Customer
    participant View as cancel-confirm.blade.php (View)
    participant Controller as CustomerController (Controller)
    participant Model as Booking (Model)
    participant DB as Database (DB)
    
    Customer->>View: enter cancellation reason & submit cancellation
    activate View
    View->>Controller: bookingDelete(bookingID, cancellation_reason)
    activate Controller
    Controller->>Model: findOrFail(bookingID)
    activate Model
    Model->>DB: SELECT * FROM bookings WHERE bookingID = ?
    activate DB
    DB-->>Model: bookingInstance
    deactivate DB
    Controller->>Model: calculateRefundEligibility()
    activate Model
    Model-->>Controller: refundStatus & refundAmount
    deactivate Model
    Controller->>Model: update(bookingStatus='cancelled', refund_status, refund_amount)
    Model->>DB: UPDATE bookings SET bookingStatus = 'cancelled', refund_status = ? WHERE bookingID = ?
    activate DB
    DB-->>Model: confirm update success
    deactivate DB
    Model-->>Controller: success confirmation
    deactivate Model
    Controller-->>View: redirect with cancellation alert & refund details
    deactivate Controller
    View-->>Customer: display cancelled booking state with refund feedback
    deactivate View
```

---

### UC-10: Create payment
Customers upload deposit receipt screenshots to confirm a booking schedule.

```mermaid
sequenceDiagram
    actor Customer
    participant View as payment.blade.php (View)
    participant Controller as PaymentController (Controller)
    participant Model as PaymentReceipt (Model)
    participant DB as Database (DB)
    
    Customer->>View: upload receipt image, select payment method & submit
    activate View
    View->>Controller: uploadReceipt(receiptFile, paymentMethod)
    activate Controller
    Controller->>Model: create(bookingID, receiptPath, paymentMethod, status='Awaiting Verification')
    activate Model
    Model->>DB: INSERT INTO payment_receipts (orderId, receiptPath, status, ...)
    activate DB
    DB-->>Model: confirm insertion
    deactivate DB
    Model-->>Controller: receiptInstance
    deactivate Model
    Controller->>Controller: updateBookingPaymentStatus(bookingID)
    Controller-->>View: redirect to bookings page with submission notification
    deactivate Controller
    View-->>Customer: display payment status as "Awaiting Verification"
    deactivate View
```

---

### UC-11: View Payment
Allows Customer and Admin/Staff to verify transaction receipts and download PDFs.

```mermaid
sequenceDiagram
    actor User as Customer / Staff
    participant View as bookings / payments (View)
    participant Controller as PaymentController / PaymentVerificationController (Controller)
    participant Model as Booking (Model)
    participant DB as Database (DB)
    
    User->>View: click download receipt / inspect receipt
    activate View
    View->>Controller: downloadReceipt(bookingID) / index()
    activate Controller
    Controller->>Model: with('paymentReceipts')->findOrFail(bookingID)
    activate Model
    Model->>DB: SELECT * FROM bookings JOIN payment_receipts WHERE bookingID = ?
    activate DB
    DB-->>Model: booking with related receipt rows
    deactivate DB
    Model-->>Controller: bookingInstance
    deactivate Model
    Controller-->>View: generate PDF view & stream download
    deactivate Controller
    View-->>User: prompt file download Dialog
    deactivate View
```

---

### UC-12: Update payment
Admins verify, approve (assigning a plumber) or reject payment receipts.

```mermaid
sequenceDiagram
    actor Admin as Staff (Admin)
    participant View as payment-verification.blade.php (View)
    participant Controller as PaymentVerificationController (Controller)
    participant Model as Booking / PaymentReceipt (Model)
    participant DB as Database (DB)
    
    Admin->>View: choose plumber and click approve (or click reject & type reason)
    activate View
    View->>Controller: approve(bookingID, staff_id) / reject(bookingID, rejection_reason)
    activate Controller
    Controller->>Model: findOrFail(bookingID)
    activate Model
    Model->>DB: SELECT * FROM bookings WHERE bookingID = ?
    activate DB
    DB-->>Model: bookingInstance
    deactivate DB
    Controller->>Model: updatePaymentReceiptAndBookingState()
    activate Model
    Model->>DB: UPDATE payment_receipts SET status='Paid'/'Rejected' WHERE orderId=?
    Model->>DB: UPDATE bookings SET paymentStatus='Paid'/'Rejected', bookingStatus='in_progress', staffID=?
    activate DB
    DB-->>Model: confirm update success
    deactivate DB
    Model-->>Controller: success confirmation
    deactivate Model
    Controller-->>View: redirect to payment index with alert
    deactivate Controller
    View-->>Admin: update page layout and show new status tags
    deactivate View
```

---

### UC-13: Create Refund
Cancellations automatically generate refund entries in the bookings table.

```mermaid
sequenceDiagram
    actor Customer
    participant View as cancel-confirm.blade.php (View)
    participant Controller as CustomerController (Controller)
    participant Model as Booking (Model)
    participant DB as Database (DB)
    
    Customer->>View: cancel booking request
    activate View
    View->>Controller: bookingDelete(bookingID)
    activate Controller
    Controller->>Model: calculateRefundEligibility()
    activate Model
    Model-->>Controller: refundData(eligible=true, amount)
    deactivate Model
    Controller->>Model: update(refund_status='pending', refund_amount=amount)
    activate Model
    Model->>DB: UPDATE bookings SET refund_status = 'pending', refund_amount = ? WHERE bookingID = ?
    activate DB
    DB-->>Model: database update success
    deactivate DB
    Model-->>Controller: success confirmation
    deactivate Model
    Controller-->>View: redirect with success info
    deactivate Controller
    View-->>Customer: display booking as cancelled, refund pending
    deactivate View
```

---

### UC-14: View Refund
Allows Customer and Admin/Staff to review status details of refunds.

```mermaid
sequenceDiagram
    actor User as Customer / Staff
    participant View as customer.bookings / staff.refunds (View)
    participant Controller as CustomerController / RefundController (Controller)
    participant Model as Booking (Model)
    participant DB as Database (DB)
    
    User->>View: navigate to refunds list
    activate View
    View->>Controller: index() / bookings()
    activate Controller
    Controller->>Model: where('refund_status', '!=', 'not_applicable')->get()
    activate Model
    Model->>DB: SELECT * FROM bookings WHERE refund_status IN ('pending', 'refunded')
    activate DB
    DB-->>Model: collection of refund bookings
    deactivate DB
    Model-->>Controller: collections collection
    deactivate Model
    Controller-->>View: render refunds page with collection
    deactivate Controller
    View-->>User: show listings with transaction status
    deactivate View
```

---

### UC-15: Update Refund
Admins upload refund proof receipts to settle pending refunds.

```mermaid
sequenceDiagram
    actor Admin as Staff (Admin)
    participant View as staff.refunds (View)
    participant Controller as RefundController (Controller)
    participant Model as Booking (Model)
    participant DB as Database (DB)
    
    Admin->>View: upload receipt file, input remarks, & click refund
    activate View
    View->>Controller: markAsRefunded(bookingID, refund_receipt, refund_remarks)
    activate Controller
    Controller->>Model: findOrFail(bookingID)
    activate Model
    Model->>DB: SELECT * FROM bookings WHERE bookingID = ?
    activate DB
    DB-->>Model: bookingInstance
    deactivate DB
    Controller->>Model: update(refund_status='refunded', receiptPath, remarks)
    activate Model
    Model->>DB: UPDATE bookings SET refund_status='refunded', refund_receipt_path=?, refund_remarks=? WHERE bookingID=?
    activate DB
    DB-->>Model: confirm update success
    deactivate DB
    Model-->>Controller: success confirmation
    deactivate Model
    Controller-->>View: redirect to index with success message
    deactivate Controller
    View-->>Admin: update list row to show "Refunded" state
    deactivate View
```

---

### UC-16: Create Job Record
Plumbers document service tasks, costs, and notes on job completion.

```mermaid
sequenceDiagram
    actor Plumber as Staff (Plumber)
    participant View as job-record-create.blade.php (View)
    participant Controller as StaffController (Controller)
    participant Model as JobRecord (Model)
    participant DB as Database (DB)
    
    Plumber->>View: enter completionDate, totalCost, jobNotes, & submit record
    activate View
    View->>Controller: jobRecordStore(jobRecordData)
    activate Controller
    Controller->>Model: create(jobRecordData)
    activate Model
    Model->>DB: INSERT INTO job_records (bookingID, staffID, totalCost, notes, ...)
    activate DB
    DB-->>Model: confirm row creation
    deactivate DB
    Model-->>Controller: jobRecordInstance
    deactivate Model
    Controller-->>View: redirect with success notice
    deactivate Controller
    View-->>Plumber: display list of completed jobs
    deactivate View
```

---

### UC-17: View Job Record
Customers and staff inspect the final job summary, total cost, and invoice.

```mermaid
sequenceDiagram
    actor User as Customer / Staff
    participant View as job-records.blade.php (View)
    participant Controller as StaffController / CustomerController (Controller)
    participant Model as JobRecord (Model)
    participant DB as Database (DB)
    
    User->>View: click view job report / print record
    activate View
    View->>Controller: jobRecords() / bookings()
    activate Controller
    Controller->>Model: with('booking.customer')->findOrFail(jobRecordID)
    activate Model
    Model->>DB: SELECT * FROM job_records JOIN bookings ON bookingID WHERE ...
    activate DB
    DB-->>Model: job record details row
    deactivate DB
    Model-->>Controller: jobRecordInstance
    deactivate Model
    Controller-->>View: render job record view details page
    deactivate Controller
    View-->>User: display job details panel
    deactivate View
```

---

### UC-18: Update Job Record
Plumbers edit costs, completion details, or notes of already logged job reports.

```mermaid
sequenceDiagram
    actor Plumber as Staff (Plumber)
    participant View as job-record-create.blade.php (View)
    participant Controller as StaffController (Controller)
    participant Model as JobRecord (Model)
    participant DB as Database (DB)
    
    Plumber->>View: edit job fields and click save record
    activate View
    View->>Controller: jobRecordStore(updatedFields)
    activate Controller
    Controller->>Model: update(updatedFields)
    activate Model
    Model->>DB: UPDATE job_records SET totalCost=?, notes=? WHERE jobRecordID=?
    activate DB
    DB-->>Model: confirm update success
    deactivate DB
    Model-->>Controller: success confirmation
    deactivate Model
    Controller-->>View: redirect to list with update banner
    deactivate Controller
    View-->>Plumber: update job records index listing
    deactivate View
```

---

### UC-19: Generate Report
Admins review sales, earnings, active customers, and performance analytics.

```mermaid
sequenceDiagram
    actor Admin as Staff (Admin)
    participant View as staff.dashboard (View)
    participant Controller as StaffController (Controller)
    participant Model as JobRecord (Model)
    participant DB as Database (DB)
    
    Admin->>View: filter sales charts by selected year
    activate View
    View->>Controller: dashboard(chart_year)
    activate Controller
    Controller->>Model: whereYear('jobRecordCompletionDate', chart_year)->get()
    activate Model
    Model->>DB: SELECT * FROM job_records WHERE YEAR(jobRecordCompletionDate) = ?
    activate DB
    DB-->>Model: list of completed job records
    deactivate DB
    Model-->>Controller: jobRecords collection
    deactivate Model
    Controller->>Controller: sumMonthlySalesAndMoMChanges()
    Controller-->>View: render dashboard with sales array and chart values
    deactivate Controller
    View-->>Admin: display interactive sales columns & analytics metrics
    deactivate View
```

---

### UC-20: Create Feedback
Customers submit reviews and rating scores for completed plumbing tasks.

```mermaid
sequenceDiagram
    actor Customer
    participant View as customer.feedback (View)
    participant Controller as CustomerController (Controller)
    participant Model as Feedback (Model)
    participant DB as Database (DB)
    
    Customer->>View: choose rating, write comments, attach photos, & submit review
    activate View
    View->>Controller: feedbackStore(feedbackParams)
    activate Controller
    Controller->>Model: create(feedbackParams)
    activate Model
    Model->>DB: INSERT INTO feedbacks (customerID, bookingID, rating, comments, ...)
    activate DB
    DB-->>Model: database insertion success
    deactivate DB
    Model-->>Controller: feedbackInstance
    deactivate Model
    Controller-->>View: redirect to feedback index with thank-you toast
    deactivate Controller
    View-->>Customer: display reviews listing showing new customer comment
    deactivate View
```

---

### UC-21: View Feedback
Both Customer and Admin/Staff read review comments and reply messages.

```mermaid
sequenceDiagram
    actor User as Customer / Staff
    participant View as feedback.blade.php (View)
    participant Controller as CustomerController / StaffController (Controller)
    participant Model as Feedback (Model)
    participant DB as Database (DB)
    
    User->>View: open feedback review boards
    activate View
    View->>Controller: feedback()
    activate Controller
    Controller->>Model: with('customer', 'booking')->get()
    activate Model
    Model->>DB: SELECT * FROM feedbacks JOIN customers JOIN bookings
    activate DB
    DB-->>Model: feedbacks array listing
    deactivate DB
    Model-->>Controller: feedback collection
    deactivate Model
    Controller-->>View: render feedback list template
    deactivate Controller
    View-->>User: display feedback records, ratings & staff responses
    deactivate View
```

---

### UC-22: Create Chat Message
Real-time discussion regarding plumbing problems between customers and plumbers.

```mermaid
sequenceDiagram
    actor User as Customer / Staff
    participant View as chat.blade.php (View)
    participant Controller as ChatController (Controller)
    participant Model as ChatMessage (Model)
    participant DB as Database (DB)
    
    User->>View: type chat message and click send button
    activate View
    View->>Controller: sendMessage(bookingID, messageText)
    activate Controller
    Controller->>Model: create(bookingID, messageText, sender_type, sender_id)
    activate Model
    Model->>DB: INSERT INTO chat_messages (bookingID, message, sender_type, sender_id)
    activate DB
    DB-->>Model: confirm message insertion
    deactivate DB
    Model-->>Controller: chatMessageInstance
    deactivate Model
    Controller->>Controller: broadcast(ChatMessageSent) & notifyRecipient()
    Controller-->>View: return JSON message payload response
    deactivate Controller
    View-->>User: append message box in chat window timeline
    deactivate View
```

---

### UC-23: View Chat Messages
Loads all previous chat messages of a booking and updates read status flags.

```mermaid
sequenceDiagram
    actor User as Customer / Staff
    participant View as chat.blade.php (View)
    participant Controller as ChatController (Controller)
    participant Model as ChatMessage (Model)
    participant DB as Database (DB)
    
    User->>View: navigate to booking chat view page
    activate View
    View->>Controller: getMessages(bookingID)
    activate Controller
    Controller->>Model: where('bookingID', bookingID)->get()
    activate Model
    Model->>DB: SELECT * FROM chat_messages WHERE bookingID = ?
    activate DB
    DB-->>Model: message records list
    deactivate DB
    Controller->>Model: update(is_read=true) (for unread incoming messages)
    Model->>DB: UPDATE chat_messages SET is_read=true WHERE bookingID=? AND sender_type!=?
    activate DB
    DB-->>Model: confirm read status update success
    deactivate DB
    Model-->>Controller: chatMessageCollection
    deactivate Model
    Controller-->>View: return chatMessageCollection JSON response
    deactivate Controller
    View-->>User: display historical chat conversation timeline
    deactivate View
```

---

### UC-24: View Push Notifications
Loads user-specific notifications to inform them about status adjustments.

```mermaid
sequenceDiagram
    actor User as Customer / Staff
    participant View as layout.navigation (View)
    participant Controller as NotificationController (Controller)
    participant Model as Notification (Model)
    participant DB as Database (DB)
    
    User->>View: click navigation notification dropdown bell icon
    activate View
    View->>Controller: getUnreadNotifications()
    activate Controller
    Controller->>Model: Auth::user()->unreadNotifications()->get()
    activate Model
    Model->>DB: SELECT * FROM notifications WHERE notifiable_id=? AND read_at IS NULL
    activate DB
    DB-->>Model: notifications list array
    deactivate DB
    Model-->>Controller: unreadNotifications collection
    deactivate Model
    Controller-->>View: return notifications list JSON response
    deactivate Controller
    View-->>User: display unread notification items in header dropdown list
    deactivate View
```
