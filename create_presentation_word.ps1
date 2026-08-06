$ErrorActionPreference = "Stop"

# Initialize Word Application
$word = New-Object -ComObject Word.Application
$word.Visible = $false

# Create a new document
$doc = $word.Documents.Add()

# Helper function to add styled headings
function Add-Heading {
    param([string]$text, [int]$level)
    $p = $doc.Paragraphs.Add()
    $p.Range.Text = $text
    if ($level -eq 1) {
        $p.Style = "Heading 1"
        $p.Range.Font.Size = 16
        $p.Range.Font.Bold = 1
        $p.Range.ParagraphFormat.SpaceBefore = 14
        $p.Range.ParagraphFormat.SpaceAfter = 6
    } elseif ($level -eq 2) {
        $p.Style = "Heading 2"
        $p.Range.Font.Size = 13
        $p.Range.Font.Bold = 1
        $p.Range.ParagraphFormat.SpaceBefore = 10
        $p.Range.ParagraphFormat.SpaceAfter = 4
    } elseif ($level -eq 3) {
        $p.Style = "Heading 3"
        $p.Range.Font.Size = 11
        $p.Range.Font.Bold = 1
        $p.Range.ParagraphFormat.SpaceBefore = 6
        $p.Range.ParagraphFormat.SpaceAfter = 2
    }
    $p.Range.InsertParagraphAfter()
}

# Helper function to add normal paragraphs
function Add-Paragraph {
    param([string]$text, [bool]$isItalic = $false, [bool]$isBold = $false)
    $p = $doc.Paragraphs.Add()
    $p.Range.Text = $text
    $p.Range.Font.Name = "Calibri"
    $p.Range.Font.Size = 11
    $p.Range.Font.Bold = [int]$isBold
    $p.Range.Font.Italic = [int]$isItalic
    $p.Range.ParagraphFormat.SpaceBefore = 2
    $p.Range.ParagraphFormat.SpaceAfter = 6
    $p.Range.InsertParagraphAfter()
}

# Helper function to add bullet points
function Add-Bullet {
    param([string]$text)
    $p = $doc.Paragraphs.Add()
    $p.Range.Text = "• " + $text
    $p.Range.Font.Name = "Calibri"
    $p.Range.Font.Size = 11
    $p.Range.ParagraphFormat.LeftIndent = 18
    $p.Range.ParagraphFormat.SpaceBefore = 1
    $p.Range.ParagraphFormat.SpaceAfter = 3
    $p.Range.InsertParagraphAfter()
}

# Document Title
$titleP = $doc.Paragraphs.Add()
$titleP.Range.Text = "PLUMBFIX: PLUMBING MANAGEMENT SYSTEM`nFinal Year Project Presentation Script & Talking Points"
$titleP.Range.Font.Name = "Calibri"
$titleP.Range.Font.Size = 22
$titleP.Range.Font.Bold = 1
$titleP.Range.ParagraphFormat.Alignment = 1 # Center
$titleP.Range.ParagraphFormat.SpaceAfter = 12
$titleP.Range.InsertParagraphAfter()

# Subtitle Info
$subP = $doc.Paragraphs.Add()
$subP.Range.Text = "Author: Muhammad Adib Is'ad bin Mohd Zulkefli | Supervisor: Sir Zainal Fikri bin Zamzuri`nFaculty of Computer and Mathematical Sciences (FSKM) | UiTM Melaka Kampus Jasin | August 2026"
$subP.Range.Font.Name = "Calibri"
$subP.Range.Font.Size = 11
$subP.Range.Font.Italic = 1
$subP.Range.ParagraphFormat.Alignment = 1 # Center
$subP.Range.ParagraphFormat.SpaceAfter = 24
$subP.Range.InsertParagraphAfter()

# Section 1
Add-Heading "1. Introduction & Opening Remarks" 1
Add-Heading "Verbal Script (What to say):" 3
Add-Paragraph """Good morning / afternoon to the respected evaluators and panel members. My name is Muhammad Adib Is’ad bin Mohd Zulkefli, under the supervision of Sir Zainal Fikri bin Zamzuri. Today, I am honored to present my Final Year Project entitled 'Plumbfix: Plumbing Management System'.""" $true

Add-Heading "Key Talking Points:" 3
Add-Bullet "Client & Target Business: Developed specifically for Ikhlas Jujur Bakti Services to modernize their traditional plumbing operations."
Add-Bullet "Core Goal: Transform manual phone call & WhatsApp bookings into a centralized, 24/7 web-based management portal."
Add-Bullet "Key Innovations: Automated service booking, technician dispatching, deposit payment verification via DuitNow QR, real-time live chat, and business analytics."

# Section 2
Add-Heading "2. Problem Statement" 1
Add-Heading "Verbal Script (What to say):" 3
Add-Paragraph """Before Plumbfix was developed, Ikhlas Jujur Bakti Services faced three critical operational challenges that impacted their service quality and business growth.""" $true

Add-Heading "Key Talking Points:" 3
Add-Bullet "1. Manual Booking Process: Heavy reliance on phone calls and WhatsApp messages, resulting in communication delays, unorganized customer records, and frequent schedule overlaps."
Add-Bullet "2. No Dedicated Feedback Platform: Lack of a structured channel to collect customer reviews, service ratings, or feedback for quality evaluation."
Add-Bullet "3. Poor Record & Data Tracking: Dependence on traditional paperwork and scattered manual records, making job history, customer details, and revenue tracking hard to trace and retain."

# Section 3
Add-Heading "3. Project Objectives" 1
Add-Heading "Verbal Script (What to say):" 3
Add-Paragraph """To address these challenges, three main objectives were established for this project:""" $true

Add-Heading "Key Talking Points:" 3
Add-Bullet "Objective 1: To gather and analyze the requirements for the Plumbfix: Plumbing Management System tailored to Ikhlas Jujur Bakti's business workflow."
Add-Bullet "Objective 2: To design the web-based portal architecture, data models (ERD), sequence flows, and UI wireframes."
Add-Bullet "Objective 3: To develop and test the complete Plumbfix system to ensure high performance and user satisfaction."

# Section 4
Add-Heading "4. Methodology & Technology Stack" 1
Add-Heading "Verbal Script (What to say):" 3
Add-Paragraph """The project followed a structured system development life cycle, progressing through three main phases: Requirement Analysis, System Design, and Implementation.""" $true

Add-Heading "Key Talking Points:" 3
Add-Bullet "Phase 1 - Requirement & Analysis: Captured business specs for Ikhlas Jujur Bakti and defined the Software Requirements Specification (SRS)."
Add-Bullet "Phase 2 - Design: Designed ERD diagrams, Sequence diagrams, Data Dictionaries, and UI wireframes."
Add-Bullet "Phase 3 - Implementation (Tech Stack):"
Add-Bullet "   • Backend Framework: Laravel 12 (PHP)"
Add-Bullet "   • Frontend & UI: Tailwind CSS & Blade Templating Engine"
Add-Bullet "   • Database: MySQL"

# Section 5
Add-Heading "5. System Result & Interface" 1
Add-Heading "Verbal Script (What to say):" 3
Add-Paragraph """The Plumbfix system provides distinct, tailored interfaces for both Staff and Customers to streamline operations end-to-end.""" $true

Add-Heading "Staff Module Features:" 3
Add-Bullet "Track Booking: Monitor active customer bookings, verify DuitNow QR deposit payments, and dispatch plumbers efficiently."
Add-Bullet "Record Management & Analytics: Automated sales reports, revenue metrics, and performance charts to monitor business growth."

Add-Heading "Customer Module Features:" 3
Add-Bullet "Make Booking: 24/7 self-service portal to schedule plumbing appointments without waiting for manual replies."
Add-Bullet "Feedback & Live Chat: Real-time chat with assigned plumbers, automated PDF receipts, and direct customer rating submission."

# Section 6
Add-Heading "6. Project Significance" 1
Add-Heading "Verbal Script (What to say):" 3
Add-Paragraph """Plumbfix delivers significant value and tangible improvements for both internal business operations and external customer satisfaction.""" $true

Add-Heading "Key Talking Points:" 3
Add-Bullet "Staff & Business Impact: Replaces manual chat bookings, eliminates schedule overlaps, centralizes deposit verification & technician dispatching, and automates sales reports."
Add-Bullet "Customer Impact: Provides 24/7 instant booking access, direct real-time communication with plumbers, downloadable PDF receipts, and a transparent rating/feedback system."

# Section 7
Add-Heading "7. Conclusion & Q&A Preparation" 1
Add-Heading "Verbal Script (What to say):" 3
Add-Paragraph """In conclusion, Plumbfix successfully modernizes traditional plumbing management for Ikhlas Jujur Bakti into a centralized, automated web portal. By automating bookings, payment verification, live chat, and reporting, Plumbfix boosts operational efficiency for staff while providing a seamless, 24/7 digital ordering experience for customers. Thank you for your attention, and I am now ready for your questions.""" $true

Add-Heading "Anticipated Questions & Best Answers:" 3
Add-Bullet "Q: How is the DuitNow QR deposit verified?"
Add-Bullet "A: Customers upload their DuitNow QR payment receipt during booking. Staff review and verify the transaction status on their Track Booking dashboard before dispatching a technician."
Add-Bullet "Q: How is the Live Chat feature implemented?"
Add-Bullet "A: Real-time messaging allows direct communication between customers and plumbers/staff to discuss job details and location specifics."
Add-Bullet "Q: What is the main novelty or improvement over existing methods?"
Add-Bullet "A: It eliminates manual WhatsApp back-and-forth, prevents double-booking through structured time slot management, and automates record-keeping and financial reporting."

# Save document
$outputPath = "c:\Users\adibi\plumbfix\Plumbfix_Presentation_Script.docx"
$doc.SaveAs([ref]$outputPath)
$doc.Close()
$word.Quit()

Write-Host "Successfully generated: $outputPath"
