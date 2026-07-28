# Graph Report - plumbfix  (2026-06-18)

## Corpus Check
- 181 files · ~735,212 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 516 nodes · 552 edges · 154 communities (149 shown, 5 thin omitted)
- Extraction: 95% EXTRACTED · 5% INFERRED · 0% AMBIGUOUS · INFERRED: 30 edges (avg confidence: 0.8)
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
- [[_COMMUNITY_Community 216|Community 216]]
- [[_COMMUNITY_Community 217|Community 217]]
- [[_COMMUNITY_Community 218|Community 218]]

## God Nodes (most connected - your core abstractions)
1. `Controller` - 28 edges
2. `StaffController` - 15 edges
3. `BookingDepositTest` - 14 edges
4. `TestCase` - 14 edges
5. `CustomerController` - 13 edges
6. `Booking` - 13 edges
7. `User` - 13 edges
8. `PaymentReceipt` - 11 edges
9. `Staff` - 9 edges
10. `scripts` - 9 edges

## Surprising Connections (you probably didn't know these)
- `ChatController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Chat/ChatController.php → app/Http/Controllers/Controller.php
- `PaymentController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Customer/PaymentController.php → app/Http/Controllers/Controller.php
- `InvoiceController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Invoice/InvoiceController.php → app/Http/Controllers/Controller.php
- `PaymentVerificationController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Staff/PaymentVerificationController.php → app/Http/Controllers/Controller.php
- `PlumberController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Staff/PlumberController.php → app/Http/Controllers/Controller.php

## Import Cycles
- None detected.

## Communities (154 total, 5 thin omitted)

### Community 0 - "Feature & Unit Tests"
Cohesion: 0.05
Nodes (43): autoload, autoload-dev, psr-4, psr-4, description, extra, laravel, keywords (+35 more)

### Community 1 - "Invoice Controller Group"
Cohesion: 0.07
Nodes (15): Request, Request, Request, Request, Request, Request, GoogleAuthController, LoginController (+7 more)

### Community 2 - "Staff Controller Group"
Cohesion: 0.28
Nodes (3): Request, JobRecord, StaffController

### Community 3 - "Database Migrations"
Cohesion: 0.10
Nodes (8): BaseTestCase, ExampleTest, LoginWelcomeTest, PlumberTest, PlumbfixImprovementsTest, RefreshDatabase, TestCase, ExampleTest

### Community 4 - "Booking Model Group"
Cohesion: 0.10
Nodes (7): HasFactory, Model, Booking, ChatMessage, Feedback, JobRecord, Report

### Community 5 - "User Model Group"
Cohesion: 0.09
Nodes (5): Authenticatable, Customer, Staff, User, Notifiable

### Community 7 - "Chat Controller Group"
Cohesion: 0.09
Nodes (15): Request, ChatController, ChatMessage, Content, Dispatchable, Envelope, ChatMessageSent, InteractsWithSockets (+7 more)

### Community 8 - "devDependencies & package"
Cohesion: 0.14
Nodes (13): devDependencies, axios, concurrently, laravel-vite-plugin, tailwindcss, @tailwindcss/vite, vite, private (+5 more)

### Community 9 - "Plumber Controller Group"
Cohesion: 0.11
Nodes (6): Request, Booking, BookingDepositTest, PaymentReceipt, InventoryService, PaymentVerificationController

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

### Community 138 - "Community 138"
Cohesion: 0.43
Nodes (3): Booking, Request, InvoiceController

### Community 216 - "Community 216"
Cohesion: 0.22
Nodes (8): About Laravel, Code of Conduct, Contributing, Laravel Sponsors, Learning Laravel, License, Premium Partners, Security Vulnerabilities

## Knowledge Gaps
- **60 isolated node(s):** `Request`, `$schema`, `name`, `type`, `description` (+55 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **5 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `PaymentReceipt` connect `Plumber Controller Group` to `Community 144`, `Booking Model Group`?**
  _High betweenness centrality (0.106) - this node is a cross-community bridge._
- **Why does `Controller` connect `Invoice Controller Group` to `Staff Controller Group`, `Chat Controller Group`, `Plumber Controller Group`, `Community 138`, `Community 12`, `Community 144`?**
  _High betweenness centrality (0.087) - this node is a cross-community bridge._
- **Why does `User` connect `User Model Group` to `Application Models`, `Booking Model Group`?**
  _High betweenness centrality (0.047) - this node is a cross-community bridge._
- **What connects `Request`, `$schema`, `name` to the rest of the system?**
  _60 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `Feature & Unit Tests` be split into smaller, more focused modules?**
  _Cohesion score 0.045454545454545456 - nodes in this community are weakly interconnected._
- **Should `Invoice Controller Group` be split into smaller, more focused modules?**
  _Cohesion score 0.06588235294117648 - nodes in this community are weakly interconnected._
- **Should `Database Migrations` be split into smaller, more focused modules?**
  _Cohesion score 0.09803921568627451 - nodes in this community are weakly interconnected._