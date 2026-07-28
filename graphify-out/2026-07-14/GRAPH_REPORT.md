# Graph Report - plumbfix  (2026-07-14)

## Corpus Check
- 191 files · ~791,400 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 568 nodes · 613 edges · 172 communities (166 shown, 6 thin omitted)
- Extraction: 95% EXTRACTED · 5% INFERRED · 0% AMBIGUOUS · INFERRED: 32 edges (avg confidence: 0.8)
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
- [[_COMMUNITY_Community 216|Community 216]]
- [[_COMMUNITY_Community 217|Community 217]]
- [[_COMMUNITY_Community 218|Community 218]]

## God Nodes (most connected - your core abstractions)
1. `Controller` - 28 edges
2. `System Sequence Diagrams` - 25 edges
3. `StaffController` - 16 edges
4. `BookingDepositTest` - 14 edges
5. `TestCase` - 14 edges
6. `CustomerController` - 13 edges
7. `Booking` - 13 edges
8. `User` - 13 edges
9. `PlumbfixImprovementsTest` - 12 edges
10. `PaymentReceipt` - 11 edges

## Surprising Connections (you probably didn't know these)
- `LoginController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Auth/LoginController.php → app/Http/Controllers/Controller.php
- `ChatController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Chat/ChatController.php → app/Http/Controllers/Controller.php
- `CustomerController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Customer/CustomerController.php → app/Http/Controllers/Controller.php
- `PaymentController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Customer/PaymentController.php → app/Http/Controllers/Controller.php
- `InvoiceController` --inherits--> `Controller`  [EXTRACTED]
  app/Http/Controllers/Invoice/InvoiceController.php → app/Http/Controllers/Controller.php

## Import Cycles
- None detected.

## Communities (172 total, 6 thin omitted)

### Community 0 - "Feature & Unit Tests"
Cohesion: 0.22
Nodes (8): description, keywords, license, minimum-stability, name, prefer-stable, $schema, type

### Community 1 - "Invoice Controller Group"
Cohesion: 0.08
Nodes (13): Request, Request, Request, Request, Request, GoogleAuthController, RegisterController, Controller (+5 more)

### Community 2 - "Staff Controller Group"
Cohesion: 0.14
Nodes (5): Request, Request, CustomerController, JobRecord, StaffController

### Community 3 - "Database Migrations"
Cohesion: 0.11
Nodes (7): BaseTestCase, ExampleTest, LoginWelcomeTest, PlumberTest, RefreshDatabase, TestCase, ExampleTest

### Community 4 - "Booking Model Group"
Cohesion: 0.09
Nodes (7): HasFactory, Model, Booking, ChatMessage, Feedback, JobRecord, Report

### Community 5 - "User Model Group"
Cohesion: 0.09
Nodes (5): Authenticatable, Customer, Staff, User, Notifiable

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
Cohesion: 0.23
Nodes (7): Request, ChatController, ChatMessage, Dispatchable, ChatMessageSent, InteractsWithSockets, ShouldBroadcast

### Community 152 - "Community 152"
Cohesion: 0.25
Nodes (8): require-dev, fakerphp/faker, laravel/pail, laravel/pint, laravel/sail, mockery/mockery, nunomaduro/collision, phpunit/phpunit

### Community 153 - "Community 153"
Cohesion: 0.29
Nodes (7): require, barryvdh/laravel-dompdf, laravel/framework, laravel/socialite, laravel/tinker, php, pusher/pusher-php-server

### Community 154 - "Community 154"
Cohesion: 0.07
Nodes (28): Actor Definitions, Plumbfix System Sequence Diagrams (SSD), System Sequence Diagrams, Table of Contents, UC-01: Login, UC-02: Create Account, UC-03: View Account, UC-04: Update Account (+20 more)

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
Cohesion: 0.16
Nodes (7): Content, Envelope, ActivityNotificationMail, Mailable, RecentActivityNotification, Queueable, SerializesModels

### Community 216 - "Community 216"
Cohesion: 0.22
Nodes (8): About Laravel, Code of Conduct, Contributing, Laravel Sponsors, Learning Laravel, License, Premium Partners, Security Vulnerabilities

## Knowledge Gaps
- **86 isolated node(s):** `Request`, `$schema`, `name`, `type`, `description` (+81 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **6 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `PaymentReceipt` connect `Plumber Controller Group` to `Community 164`, `Booking Model Group`?**
  _High betweenness centrality (0.091) - this node is a cross-community bridge._
- **Why does `Controller` connect `Invoice Controller Group` to `Staff Controller Group`, `Community 163`, `Community 164`, `Plumber Controller Group`, `Community 138`, `Community 144`?**
  _High betweenness centrality (0.074) - this node is a cross-community bridge._
- **Why does `User` connect `User Model Group` to `Application Models`, `Booking Model Group`?**
  _High betweenness centrality (0.040) - this node is a cross-community bridge._
- **What connects `Request`, `$schema`, `name` to the rest of the system?**
  _86 weakly-connected nodes found - possible documentation gaps or missing edges._
- **Should `Invoice Controller Group` be split into smaller, more focused modules?**
  _Cohesion score 0.08097165991902834 - nodes in this community are weakly interconnected._
- **Should `Staff Controller Group` be split into smaller, more focused modules?**
  _Cohesion score 0.13825757575757575 - nodes in this community are weakly interconnected._
- **Should `Database Migrations` be split into smaller, more focused modules?**
  _Cohesion score 0.11076923076923077 - nodes in this community are weakly interconnected._