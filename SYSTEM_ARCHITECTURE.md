# Plumbfix System Architecture

This document describes the high-level system architecture of the **Plumbfix Plumbing Management System**. The architecture is structured in a multi-tier pattern, separating client presentation, routing/middleware, core application logic, data access, and third-party external integrations.

---

## Architecture Overview Diagram

The diagram below illustrates the components in each tier and their interactions. It utilizes custom visual styling to clearly distinguish between client, routing, application logic, data, and external service components.

```mermaid
flowchart TB
    %% Styling definitions
    classDef client fill:#e0f2fe,stroke:#0284c7,stroke-width:2px,color:#0369a1;
    classDef router fill:#fef3c7,stroke:#d97706,stroke-width:2px,color:#92400e;
    classDef app fill:#f3e8ff,stroke:#7c3aed,stroke-width:2px,color:#6b21a8;
    classDef service fill:#f0fdf4,stroke:#16a34a,stroke-width:2px,color:#166534;
    classDef db fill:#ffe4e6,stroke:#e11d48,stroke-width:2px,color:#9f1239;
    classDef ext fill:#f1f5f9,stroke:#475569,stroke-width:2px,color:#334155;

    subgraph ClientLayer["Presentation Layer (Client-Side)"]
        Browser["🌐 Web Browser Session"]:::client
        
        subgraph Views["User Interfaces (HTML5 / CSS3 / Tailwind CSS v4)"]
            CustomerUI["👤 Customer Portal<br>(Bookings, Payments, Chat, Feedback)"]:::client
            AdminUI["🔑 Admin & Staff Portal<br>(Dashboard, Jobs, Verification, Analytics)"]:::client
        end
        
        subgraph JSClient["Client Logic (JS)"]
            Axios["HTTP Client (Axios)"]:::client
            PusherEcho["WebSockets (Pusher Echo Client)"]:::client
        end
    end

    subgraph CommLayer["Communication & Routing Layer"]
        HTTPGateway["HTTPS REST Gateway"]:::router
        WSGateway["WSS Protocol (WebSockets)"]:::router
        LaravelRouter["🛣️ Laravel HTTP Router<br>(routes/web.php, routes/api.php)"]:::router
        Middleware["🛡️ Middleware Pipeline<br>(Session, CSRF, Auth Guards)"]:::router
    end

    subgraph ApplicationLayer["Application & Business Logic Tier"]
        subgraph Controllers["MVC Controllers (app/Http/Controllers)"]
            AuthController["Auth Controllers<br>(Login, Register, Google OAuth)"]:::app
            CustController["Customer Controllers<br>(CustomerController, PaymentController)"]:::app
            StaffCtrlGroup["Staff Controllers<br>(StaffController, PlumberController, Dashboard)"]:::app
            VerifyCtrl["Payment & Refund Controllers<br>(PaymentVerification, RefundController)"]:::app
            ChatCtrl["Chat Controllers<br>(ChatController)"]:::app
            InvoiceCtrl["Invoice Controller<br>(InvoiceController)"]:::app
            NotifCtrl["Notification Controller<br>(NotificationController)"]:::app
        end

        subgraph Services["Core Business Services & Events"]
            InvService["📦 InventoryService"]:::service
            PDFEngine["📄 DomPDF Invoice Engine"]:::service
            MailService["✉️ ActivityNotificationMail / BrevoApiTransport"]:::service
            BroadcastEvent["📡 ChatMessageSent Event"]:::service
        end
    end

    subgraph DataLayer["Data Access & Storage Tier"]
        EloquentORM["⚙️ Eloquent ORM (Models)"]:::db
        
        subgraph Models["Application Models (app/Models)"]
            UserModel["User / Customer / Staff"]:::db
            BookingModel["Booking"]:::db
            PaymentReceiptModel["PaymentReceipt"]:::db
            JobRecordModel["JobRecord"]:::db
            ChatMessageModel["ChatMessage"]:::db
            FeedbackModel["Feedback / Report"]:::db
        end

        DB["🗄️ Relational Database<br>(SQLite / MySQL)"]:::db
        Storage["💾 File Storage System<br>(Public/Private Local Disks)"]:::db
    end

    subgraph ExternalServices["External Services & Integrations"]
        GoogleAuth["🔑 Google OAuth API"]:::ext
        PusherServer["📡 Pusher WebSockets Server"]:::ext
        BrevoGateway["✉️ Brevo SMTP/API Gateway"]:::ext
    end

    %% Component Interconnections
    Browser -->|HTTP Requests| HTTPGateway
    Browser -->|Real-time Events| WSGateway
    
    HTTPGateway --> LaravelRouter
    WSGateway <--> PusherServer
    PusherEcho <--> WSGateway
    
    LaravelRouter --> Middleware
    Middleware --> AuthController
    Middleware --> CustController
    Middleware --> StaffCtrlGroup
    Middleware --> VerifyCtrl
    Middleware --> ChatCtrl
    Middleware --> InvoiceCtrl
    Middleware --> NotifCtrl
    
    %% Controller interactions with Services & Events
    AuthController --> GoogleAuth
    CustController --> InvService
    VerifyCtrl --> InvService
    VerifyCtrl --> MailService
    ChatCtrl --> BroadcastEvent
    InvoiceCtrl --> PDFEngine
    NotifCtrl --> MailService
    
    %% Broadcasting & Mailers
    BroadcastEvent --> PusherServer
    MailService --> BrevoGateway
    
    %% Database / Storage Interactions
    Controllers --> EloquentORM
    InvService --> EloquentORM
    EloquentORM --> Models
    
    Models --> DB
    VerifyCtrl --> Storage
    PDFEngine --> Storage
    InvoiceCtrl --> Storage
```

---

## Tier Breakdown & Architecture Layers

### 1. Presentation Layer (Client-Side)
- **User Interfaces**: Formatted as responsive blade layouts powered by HTML5, CSS3, and Tailwind CSS v4. Different dashboards serve different portals:
  - *Customer Portal*: Manage bookings, submit deposits, review feedback, and initiate live chat.
  - *Admin & Staff Portal*: Review analytics charts, verify payments, manage inventory/plumber assignments, log job details, and reply to customers.
- **Client Scripts**: Standard HTTP REST interactions are made using `Axios`. Real-time notifications and message indicators use the `Pusher Echo` websocket library.

### 2. Communication & Routing Layer
- **Gateways**: Standard HTTP/HTTPS handles standard page fetches and form posts, while WSS (WebSocket Secure) is utilized for real-time messaging communication.
- **Laravel Router**: All entry points are mapped via `routes/web.php` or `routes/api.php`, mapping incoming HTTP verbs to specific controllers.
- **Middleware**: Intercepts requests to perform session state management, check CSRF tokens, verify active user roles, and apply authentication guards (e.g., redirecting unauthenticated traffic).

### 3. Application & Business Logic Tier
- **MVC Controllers**: Handles request parsing and coordinates interactions between services, models, and presentation outputs:
  - [GoogleAuthController](file:///c:/Users/adibi/plumbfix/app/Http/Controllers/Auth/GoogleAuthController.php): Integrates Socialite for Google OAuth login.
  - [CustomerController](file:///c:/Users/adibi/plumbfix/app/Http/Controllers/Customer/CustomerController.php) & [StaffController](file:///c:/Users/adibi/plumbfix/app/Http/Controllers/Staff/StaffController.php): Business operations for client-side bookings and admin management.
  - [PaymentVerificationController](file:///c:/Users/adibi/plumbfix/app/Http/Controllers/Staff/PaymentVerificationController.php) & [RefundController](file:///c:/Users/adibi/plumbfix/app/Http/Controllers/Staff/RefundController.php): Handlers for managing receipt processing, approval/rejection, and ledger balancing.
- **Core Business Services & Observers**:
  - [InventoryService](file:///c:/Users/adibi/plumbfix/app/Services/InventoryService.php): Automatically tracks, reserves, and updates plumbing equipment stock levels whenever a booking is created or updated.
  - **DomPDF Engine**: Renders HTML/CSS views into strict PDF invoices and receipt vouchers.
  - [BrevoApiTransport](file:///c:/Users/adibi/plumbfix/app/Mail/BrevoApiTransport.php): Custom transport layer that sends transaction emails and activity notifications using the Brevo SMTP API.

### 4. Data Access & Storage Tier
- **Eloquent ORM**: Translates SQL rows to object-oriented representation via Active Record.
- **Application Models**:
  - [User](file:///c:/Users/adibi/plumbfix/app/Models/User.php), [Customer](file:///c:/Users/adibi/plumbfix/app/Models/Customer.php), [Staff](file:///c:/Users/adibi/plumbfix/app/Models/Staff.php): Identity and user role definitions.
  - [Booking](file:///c:/Users/adibi/plumbfix/app/Models/Booking.php): The core domain model representing service appointments, timestamps, status, and plumber assignments.
  - [PaymentReceipt](file:///c:/Users/adibi/plumbfix/app/Models/PaymentReceipt.php) & [JobRecord](file:///c:/Users/adibi/plumbfix/app/Models/JobRecord.php): Documents financial transactions and plumber task sheets.
- **Relational Database**: Relational engine (SQLite for local testing/MySQL for production) storing tables and foreign-key constraints.
- **Storage Subsystem**: Public and private storage disks containing user-uploaded transaction receipts, plumber job photos, and compiled invoice PDFs.

### 5. External Integrations
- **Google OAuth**: Third-party secure credentials delegate authentication.
- **Pusher WebSockets**: Broadcasts event payloads to client connections, enabling instant customer-to-plumber chat.
- **Brevo API Gateway**: Delivers automated status emails for payment confirmations, booking schedules, and warnings.

---

## Core System Integration Flows

Below are sequence representations of key cross-tier workflows.

### Flow A: Deposit Payment Upload and Verification
```mermaid
sequenceDiagram
    autonumber
    actor Customer as 👤 Customer
    actor Admin as 🔑 Admin / Staff
    participant Gateway as 🛣️ Routing/Middleware
    participant PayCtrl as ⚙️ PaymentVerificationCtrl
    participant InvServ as 📦 InventoryService
    participant DB as 🗄️ Database (Models)
    participant Storage as 💾 File Storage
    participant Mailer as ✉️ Brevo Mailer

    Customer->>Gateway: Submit createPayment(bookingID, receipt_file)
    Gateway->>Gateway: Validate Session & Receipt Format
    Gateway->>PayCtrl: Handle Payment Request
    PayCtrl->>Storage: Store receipt file (Receipt_bookingID.jpg)
    PayCtrl->>DB: Save PaymentReceipt record (status = Awaiting Verification)
    PayCtrl-->>Customer: Render Success / Pending Screen
    
    Note over Admin, PayCtrl: Verification Step
    
    Admin->>Gateway: Submit updatePayment(bookingID, paymentStatus=Approved)
    Gateway->>PayCtrl: Process Payment Approval
    PayCtrl->>DB: Update Booking (status = Confirmed) & PaymentReceipt (status = Paid)
    PayCtrl->>InvServ: deductInventory(bookingID)
    InvServ->>DB: Update inventory stock counts
    PayCtrl->>Mailer: Send Confirmation Email (PDF Invoice attached)
    Mailer->>Customer: Deliver Receipt Approved Email
    PayCtrl-->>Admin: Redirect to Verification Dashboard (Success)
```

### Flow B: Real-Time Communication
```mermaid
sequenceDiagram
    autonumber
    actor UserA as 👤 User A (Customer)
    participant Gateway as 🛣️ Routing/Middleware
    participant ChatCtrl as ⚙️ ChatController
    participant DB as 🗄️ Database (Models)
    participant Event as 📡 ChatMessageSent Event
    participant Pusher as 📡 Pusher Server
    actor UserB as 👤 User B (Plumber)

    UserA->>Gateway: Type and Send Message
    Gateway->>ChatCtrl: storeMessage(bookingID, message)
    ChatCtrl->>DB: Save ChatMessage model (status = unread)
    ChatCtrl->>Event: dispatch(ChatMessageSent)
    Event->>Pusher: Trigger WebSocket Event Broadcast
    Pusher->>UserB: Send WSS payload (Pusher Echo client receives)
    Note over UserB: Browser appends message to active chat frame in real-time
```
