# Graph Report - plumbfix  (2026-06-16)

## Corpus Check
- 171 files · ~664,109 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 493 nodes · 529 edges · 143 communities (139 shown, 4 thin omitted)
- Extraction: 95% EXTRACTED · 5% INFERRED · 0% AMBIGUOUS · INFERRED: 27 edges (avg confidence: 0.8)
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
- [[_COMMUNITY_UserFactory & UserFactory|UserFactory & UserFactory]]
- [[_COMMUNITY_AppServiceProvider & AppServiceProvider|AppServiceProvider & AppServiceProvider]]
- [[_COMMUNITY_Community 65|Community 65]]
- [[_COMMUNITY_Community 134|Community 134]]
- [[_COMMUNITY_Community 216|Community 216]]
- [[_COMMUNITY_Community 217|Community 217]]
- [[_COMMUNITY_Community 218|Community 218]]

## God Nodes (most connected - your core abstractions)
1. `Controller` - 26 edges
2. `StaffController` - 15 edges
3. `TestCase` - 14 edges
4. `User` - 13 edges
5. `CustomerController` - 12 edges
6. `Booking` - 12 edges
7. `PaymentReceipt` - 10 edges
8. `BookingDepositTest` - 10 edges
9. `Staff` - 9 edges
10. `scripts` - 9 edges

## Surprising Connections (you probably didn't know these)
- `ChatController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Chat/ChatController.php → app/Http/Controllers/Controller.php
- `InvoiceController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Invoice/InvoiceController.php → app/Http/Controllers/Controller.php
- `AnalyticsController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Staff/AnalyticsController.php → app/Http/Controllers/Controller.php
- `PaymentVerificationController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Staff/PaymentVerificationController.php → app/Http/Controllers/Controller.php
- `StaffController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Staff/StaffController.php → app/Http/Controllers/Controller.php

## Import Cycles
- None detected.

## Communities (143 total, 4 thin omitted)

### Community 0 - "Feature & Unit Tests"
Cohesion: 0.05
Nodes (43): autoload, autoload-dev, psr-4, psr-4, description, extra, laravel, keywords (+35 more)

### Community 1 - "Invoice Controller Group"
Cohesion: 0.07
Nodes (15): Request, Request, Request, Request, Request, Request, GoogleAuthController, LoginController (+7 more)

### Community 2 - "Staff Controller Group"
Cohesion: 0.17
Nodes (6): Booking, Request, Request, InvoiceController, JobRecord, StaffController

### Community 3 - "Database Migrations"
Cohesion: 0.06
Nodes (11): BaseTestCase, BookingDepositTest, ExampleTest, LoginWelcomeTest, PlumberTest, PlumbfixImprovementsTest, Notification, RecentActivityNotification (+3 more)

### Community 4 - "Booking Model Group"
Cohesion: 0.09
Nodes (8): HasFactory, Model, Booking, ChatMessage, Feedback, JobRecord, PaymentReceipt, Report

### Community 5 - "User Model Group"
Cohesion: 0.09
Nodes (5): Authenticatable, Customer, Staff, User, Notifiable

### Community 7 - "Chat Controller Group"
Cohesion: 0.12
Nodes (13): Request, ChatController, ChatMessage, Content, Dispatchable, Envelope, ChatMessageSent, InteractsWithSockets (+5 more)

### Community 8 - "devDependencies & package"
Cohesion: 0.14
Nodes (13): devDependencies, axios, concurrently, laravel-vite-plugin, tailwindcss, @tailwindcss/vite, vite, private (+5 more)

### Community 9 - "Plumber Controller Group"
Cohesion: 0.29
Nodes (4): Request, Booking, InventoryService, PaymentVerificationController

### Community 10 - "Application Models"
Cohesion: 0.39
Nodes (4): Seeder, DatabaseSeeder, PlumbersSeeder, WithoutModelEvents

### Community 11 - "BrevoApiTransport & BrevoApiTransport"
Cohesion: 0.38
Nodes (3): AbstractTransport, BrevoApiTransport, SentMessage

### Community 13 - "UserFactory & UserFactory"
Cohesion: 0.47
Nodes (3): UserFactory, Factory, static

### Community 65 - "Community 65"
Cohesion: 0.29
Nodes (7): pestphp/pest-plugin, php-http/discovery, config, allow-plugins, optimize-autoloader, preferred-install, sort-packages

### Community 216 - "Community 216"
Cohesion: 0.22
Nodes (8): About Laravel, Code of Conduct, Contributing, Laravel Sponsors, Learning Laravel, License, Premium Partners, Security Vulnerabilities

## Knowledge Gaps
- **60 isolated node(s):** `Request`, `$schema`, `name`, `type`, `description` (+55 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **4 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `PaymentReceipt` connect `Booking Model Group` to `Invoice Controller Group`, `Database Migrations`, `Plumber Controller Group`?**
  _High betweenness centrality (0.105) - this node is a cross-community bridge._
- **Why does `Controller` connect `Invoice Controller Group` to `Plumber Controller Group`, `Staff Controller Group`, `Community 134`, `Chat Controller Group`?**
  _High betweenness centrality (0.087) - this node is a cross-community bridge._
- **Why does `User` connect `User Model Group` to `Application Models`, `Booking Model Group`?**
  _High betweenness centrality (0.049) - this node is a cross-community bridge._
- **What connects `Request`, `$schema`, `name` to the rest of the system?**
  _60 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `Feature & Unit Tests` be split into smaller, more focused modules?**
  _Cohesion score 0.045454545454545456 - nodes in this community are weakly interconnected._
- **Should `Invoice Controller Group` be split into smaller, more focused modules?**
  _Cohesion score 0.06568832983927324 - nodes in this community are weakly interconnected._
- **Should `Database Migrations` be split into smaller, more focused modules?**
  _Cohesion score 0.06377551020408163 - nodes in this community are weakly interconnected._