# Graph Report - plumbfix  (2026-07-28)

## Corpus Check
- 202 files · ~864,912 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 705 nodes · 746 edges · 179 communities (175 shown, 4 thin omitted)
- Extraction: 96% EXTRACTED · 4% INFERRED · 0% AMBIGUOUS · INFERRED: 32 edges (avg confidence: 0.8)
- Token cost: 0 input · 0 output

## Community Hubs (Navigation)
- [[_COMMUNITY_Feature & Unit Tests|Feature & Unit Tests]]
- [[_COMMUNITY_Invoice Controller Group|Invoice Controller Group]]
- [[_COMMUNITY_Staff Controller Group|Staff Controller Group]]
- [[_COMMUNITY_Database Migrations|Database Migrations]]
- [[_COMMUNITY_Booking Model Group|Booking Model Group]]
- [[_COMMUNITY_User Model Group|User Model Group]]
- [[_COMMUNITY_Chat Controller Group|Chat Controller Group]]
- [[_COMMUNITY_devDependencies & package|devDependencies & package]]
- [[_COMMUNITY_Plumber Controller Group|Plumber Controller Group]]
- [[_COMMUNITY_Application Models|Application Models]]
- [[_COMMUNITY_BrevoApiTransport & BrevoApiTransport|BrevoApiTransport & BrevoApiTransport]]
- [[_COMMUNITY_Community 12|Community 12]]
- [[_COMMUNITY_UserFactory & UserFactory|UserFactory & UserFactory]]
- [[_COMMUNITY_AppServiceProvider & AppServiceProvider|AppServiceProvider & AppServiceProvider]]
- [[_COMMUNITY_Community 65|Community 65]]
- [[_COMMUNITY_Community 138|Community 138]]
- [[_COMMUNITY_Community 144|Community 144]]
- [[_COMMUNITY_Community 152|Community 152]]
- [[_COMMUNITY_Community 153|Community 153]]
- [[_COMMUNITY_Community 154|Community 154]]
- [[_COMMUNITY_Community 155|Community 155]]
- [[_COMMUNITY_Community 156|Community 156]]
- [[_COMMUNITY_Community 157|Community 157]]
- [[_COMMUNITY_Community 160|Community 160]]
- [[_COMMUNITY_Community 163|Community 163]]
- [[_COMMUNITY_Community 164|Community 164]]
- [[_COMMUNITY_Community 166|Community 166]]
- [[_COMMUNITY_Community 167|Community 167]]
- [[_COMMUNITY_Community 168|Community 168]]
- [[_COMMUNITY_Community 169|Community 169]]
- [[_COMMUNITY_Community 216|Community 216]]
- [[_COMMUNITY_Community 217|Community 217]]
- [[_COMMUNITY_Community 218|Community 218]]

## God Nodes (most connected - your core abstractions)
1. `Controller` - 28 edges
2. `4.6 System Sequence Diagrams (SSD)` - 26 edges
3. `Business Activity Diagrams` - 25 edges
4. `System Sequence Diagrams` - 25 edges
5. `Use Case Specifications` - 25 edges
6. `StaffController` - 16 edges
7. `BookingDepositTest` - 14 edges
8. `TestCase` - 14 edges
9. `CustomerController` - 13 edges
10. `Booking` - 13 edges

## Surprising Connections (you probably didn't know these)
- `ChatController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Chat/ChatController.php → app/Http/Controllers/Controller.php
- `CustomerController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Customer/CustomerController.php → app/Http/Controllers/Controller.php
- `InvoiceController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Invoice/InvoiceController.php → app/Http/Controllers/Controller.php
- `PaymentVerificationController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Staff/PaymentVerificationController.php → app/Http/Controllers/Controller.php
- `PlumberController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Staff/PlumberController.php → app/Http/Controllers/Controller.php

## Import Cycles
- None detected.

## Communities (179 total, 4 thin omitted)

### Community 0 - "Feature & Unit Tests"
Cohesion: 0.22
Nodes (8): description, keywords, license, minimum-stability, name, prefer-stable, $schema, type

### Community 1 - "Invoice Controller Group"
Cohesion: 0.07
Nodes (15): Request, Request, Request, Request, Request, Request, GoogleAuthController, LoginController (+7 more)

### Community 2 - "Staff Controller Group"
Cohesion: 0.14
Nodes (5): Request, Request, CustomerController, JobRecord, StaffController

### Community 3 - "Database Migrations"
Cohesion: 0.10
Nodes (9): BaseTestCase, ExampleTest, LoginWelcomeTest, PlumberTest, PlumbfixImprovementsTest, Notification, RefreshDatabase, TestCase (+1 more)

### Community 4 - "Booking Model Group"
Cohesion: 0.10
Nodes (7): HasFactory, Model, Booking, ChatMessage, Feedback, JobRecord, Report

### Community 5 - "User Model Group"
Cohesion: 0.07
Nodes (8): Authenticatable, Customer, Staff, User, Notifiable, Seeder, DatabaseSeeder, PlumbersSeeder

### Community 7 - "Chat Controller Group"
Cohesion: 0.17
Nodes (11): 1. Presentation Layer (Client-Side), 2. Communication & Routing Layer, 3. Application & Business Logic Tier, 4. Data Access & Storage Tier, 5. External Integrations, Architecture Overview Diagram, Core System Integration Flows, Flow A: Deposit Payment Upload and Verification (+3 more)

### Community 8 - "devDependencies & package"
Cohesion: 0.14
Nodes (13): devDependencies, axios, concurrently, laravel-vite-plugin, tailwindcss, @tailwindcss/vite, vite, private (+5 more)

### Community 9 - "Plumber Controller Group"
Cohesion: 0.10
Nodes (6): Request, Booking, BookingDepositTest, PaymentReceipt, InventoryService, PaymentVerificationController

### Community 10 - "Application Models"
Cohesion: 0.07
Nodes (27): 4.4.10 BAD010 Create Payment, 4.4.11 BAD011 View Payment, 4.4.12 BAD012 Update Payment, 4.4.13 BAD013 Create Refund, 4.4.14 BAD014 View Refund, 4.4.15 BAD015 Update Refund, 4.4.16 BAD016 Create Job Record, 4.4.17 BAD017 View Job Record (+19 more)

### Community 11 - "BrevoApiTransport & BrevoApiTransport"
Cohesion: 0.38
Nodes (3): AbstractTransport, BrevoApiTransport, SentMessage

### Community 12 - "Community 12"
Cohesion: 0.22
Nodes (9): scripts, dev, post-autoload-dump, post-create-project-cmd, post-root-package-install, post-update-cmd, pre-package-uninstall, setup (+1 more)

### Community 13 - "UserFactory & UserFactory"
Cohesion: 0.47
Nodes (3): UserFactory, Factory, static

### Community 65 - "Community 65"
Cohesion: 0.29
Nodes (7): pestphp/pest-plugin, php-http/discovery, config, allow-plugins, optimize-autoloader, preferred-install, sort-packages

### Community 138 - "Community 138"
Cohesion: 0.43
Nodes (3): Booking, Request, InvoiceController

### Community 144 - "Community 144"
Cohesion: 0.07
Nodes (27): Plumbfix: Plumbing Management System - Use Case Descriptions, Table of Contents, UC-01: Login, UC-02: Create Account, UC-03: View Account, UC-04: Update Account, UC-05: Delete Account, UC-06: Create Booking (+19 more)

### Community 152 - "Community 152"
Cohesion: 0.25
Nodes (8): require-dev, fakerphp/faker, laravel/pail, laravel/pint, laravel/sail, mockery/mockery, nunomaduro/collision, phpunit/phpunit

### Community 153 - "Community 153"
Cohesion: 0.29
Nodes (7): require, barryvdh/laravel-dompdf, laravel/framework, laravel/socialite, laravel/tinker, php, pusher/pusher-php-server

### Community 154 - "Community 154"
Cohesion: 0.07
Nodes (28): Architectural Layer Definitions, Plumbfix Multilayer System Sequence Diagrams (SSD), System Sequence Diagrams, Table of Contents, UC-01: Login, UC-02: Create Account, UC-03: View Account, UC-04: Update Account (+20 more)

### Community 155 - "Community 155"
Cohesion: 0.40
Nodes (5): autoload, psr-4, App\\, Database\\Factories\\, Database\\Seeders\\

### Community 156 - "Community 156"
Cohesion: 0.67
Nodes (3): autoload-dev, psr-4, Tests\\

### Community 157 - "Community 157"
Cohesion: 0.67
Nodes (3): extra, laravel, dont-discover

### Community 160 - "Community 160"
Cohesion: 0.09
Nodes (15): Request, ChatController, ChatMessage, Content, Dispatchable, Envelope, ChatMessageSent, InteractsWithSockets (+7 more)

### Community 163 - "Community 163"
Cohesion: 0.14
Nodes (13): 10. Feedback, 11. ChatMessage, 1. Staff, 2. Customer, 3. Notification, 4. Booking, 5. Payment, 6. PaymentReceipt (+5 more)

### Community 164 - "Community 164"
Cohesion: 0.07
Nodes (26): 4.6.10 SSD010 Create Payment, 4.6.11 SSD011 View Payment, 4.6.12 SSD012 Update Payment, 4.6.13 SSD013 Create Refund, 4.6.14 SSD014 View Refund, 4.6.15 SSD015 Update Refund, 4.6.16 SSD016 Create Job Record, 4.6.17 SSD017 View Job Record (+18 more)

### Community 167 - "Community 167"
Cohesion: 0.33
Nodes (5): 4.1.2 Package Functions, 4.1.3 Package Content, Plumbfix Package Diagram Functions and Content, Table 4.1 Package functions, Table 4.2 Package Content

### Community 168 - "Community 168"
Cohesion: 0.50
Nodes (3): Entity Descriptions Table, Entity Relationship Overview, Plumbfix Database Entity Descriptions

### Community 169 - "Community 169"
Cohesion: 0.80
Nodes (4): Draw-ArrowLine(), Draw-PolylineArrow(), Render-InteractiveDiagram(), Render-LinearDiagram()

### Community 216 - "Community 216"
Cohesion: 0.13
Nodes (15): 👤 Author, 👤 Customer Portal, 🚀 Getting Started, Installation Steps, ✨ Key Features, 📄 License, 🌐 Live System Demo, 📌 Overview (+7 more)

## Knowledge Gaps
- **188 isolated node(s):** `Request`, `$schema`, `name`, `type`, `description` (+183 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **4 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `PaymentReceipt` connect `Plumber Controller Group` to `Invoice Controller Group`, `Booking Model Group`?**
  _High betweenness centrality (0.059) - this node is a cross-community bridge._
- **Why does `Controller` connect `Invoice Controller Group` to `Community 160`, `Staff Controller Group`, `Community 166`, `Plumber Controller Group`, `Community 138`?**
  _High betweenness centrality (0.048) - this node is a cross-community bridge._
- **Why does `BookingDepositTest` connect `Plumber Controller Group` to `Database Migrations`?**
  _High betweenness centrality (0.026) - this node is a cross-community bridge._
- **What connects `Request`, `$schema`, `name` to the rest of the system?**
  _188 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `Invoice Controller Group` be split into smaller, more focused modules?**
  _Cohesion score 0.06852497096399536 - nodes in this community are weakly interconnected._
- **Should `Staff Controller Group` be split into smaller, more focused modules?**
  _Cohesion score 0.13825757575757575 - nodes in this community are weakly interconnected._
- **Should `Database Migrations` be split into smaller, more focused modules?**
  _Cohesion score 0.09716599190283401 - nodes in this community are weakly interconnected._