Add-Type -AssemblyName System.Drawing

$pictureDir = "c:\Users\adibi\plumbfix\picture"
if (-not (Test-Path $pictureDir)) {
    New-Item -ItemType Directory -Path $pictureDir -Force
}

$desktopPictureDir = "C:\Users\adibi\OneDrive\Desktop\srs\picture"
if (Test-Path "C:\Users\adibi\OneDrive\Desktop\srs") {
    if (-not (Test-Path $desktopPictureDir)) {
        New-Item -ItemType Directory -Path $desktopPictureDir -Force
    }
}

function Render-SSD {
    param(
        [string]$Filename,
        [string]$Title,
        [string]$ActorName,
        [string]$ViewName,
        [string]$ControllerName,
        [string]$ModelName,
        [string]$DBName,
        [array]$Messages
    )

    $width = 580
    $height = 680
    $bmp = New-Object System.Drawing.Bitmap($width, $height)
    $g = [System.Drawing.Graphics]::FromImage($bmp)
    $g.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::HighQuality
    $g.TextRenderingHint = [System.Drawing.Text.TextRenderingHint]::AntiAliasGridFit
    $g.Clear([System.Drawing.Color]::White)

    $penBlack = New-Object System.Drawing.Pen([System.Drawing.Color]::Black, 1.5)
    $penThin = New-Object System.Drawing.Pen([System.Drawing.Color]::Black, 1)
    $penDashed = New-Object System.Drawing.Pen([System.Drawing.Color]::FromArgb(100, 100, 100), 1)
    $penDashed.DashStyle = [System.Drawing.Drawing2D.DashStyle]::Dash

    $brushBlack = [System.Drawing.Brushes]::Black
    $brushWhite = [System.Drawing.Brushes]::White
    $brushGray = New-Object System.Drawing.SolidBrush([System.Drawing.Color]::FromArgb(245, 245, 245))

    $fontTitle = New-Object System.Drawing.Font("Arial", 11, [System.Drawing.FontStyle]::Bold)
    $fontHeader = New-Object System.Drawing.Font("Arial", 8.5, [System.Drawing.FontStyle]::Bold)
    $fontText = New-Object System.Drawing.Font("Arial", 8, [System.Drawing.FontStyle]::Regular)
    $fontNum = New-Object System.Drawing.Font("Arial", 7.5, [System.Drawing.FontStyle]::Bold)

    $sfCenter = New-Object System.Drawing.StringFormat
    $sfCenter.Alignment = [System.Drawing.StringAlignment]::Center
    $sfCenter.LineAlignment = [System.Drawing.StringAlignment]::Center

    # Outer Frame
    $margin = 15
    $frameW = $width - ($margin * 2)
    $frameH = $height - ($margin * 2)
    $g.DrawRectangle($penBlack, $margin, $margin, $frameW, $frameH)

    # Title Header Bar
    $titleH = 30
    $g.DrawRectangle($penThin, $margin, $margin, $frameW, $titleH)
    $rectTitle = New-Object System.Drawing.RectangleF($margin, $margin, $frameW, $titleH)
    $g.DrawString($Title, $fontTitle, $brushBlack, $rectTitle, $sfCenter)

    # 5 Lifelines X coordinates
    $startX = 60
    $stepX = 110
    $lifelines = @(
        @{ Name=$ActorName; X=($startX + (0 * $stepX)); IsActor=$true },
        @{ Name=$ViewName; X=($startX + (1 * $stepX)); IsActor=$false },
        @{ Name=$ControllerName; X=($startX + (2 * $stepX)); IsActor=$false },
        @{ Name=$ModelName; X=($startX + (3 * $stepX)); IsActor=$false },
        @{ Name=$DBName; X=($startX + (4 * $stepX)); IsActor=$false }
    )

    $headerY = $margin + $titleH + 15
    $headerH = 34
    $bottomY = $margin + $frameH - 25

    # Draw Participant Headers & Vertical Dashed Lifelines
    foreach ($ll in $lifelines) {
        $cx = $ll.X
        $boxW = 96
        $bx = $cx - ($boxW / 2)

        # Draw vertical dashed lifeline
        $g.DrawLine($penDashed, $cx, ($headerY + $headerH), $cx, $bottomY)

        # Draw Header Box
        $rectBox = New-Object System.Drawing.RectangleF($bx, $headerY, $boxW, $headerH)
        $g.FillRectangle($brushGray, $rectBox)
        $g.DrawRectangle($penThin, $bx, $headerY, $boxW, $headerH)
        $g.DrawString($ll.Name, $fontHeader, $brushBlack, $rectBox, $sfCenter)

        # Draw Bottom Participant Box
        $rectBoxBottom = New-Object System.Drawing.RectangleF($bx, ($bottomY - 15), $boxW, 24)
        $g.FillRectangle($brushGray, $rectBoxBottom)
        $g.DrawRectangle($penThin, $bx, ($bottomY - 15), $boxW, 24)
        $g.DrawString($ll.Name, $fontHeader, $brushBlack, $rectBoxBottom, $sfCenter)
    }

    # Helper function to draw horizontal message arrow
    function Draw-SSDMessage($msgNum, $fromIdx, $toIdx, $y, $text, $isReturn) {
        $x1 = $lifelines[$fromIdx].X
        $x2 = $lifelines[$toIdx].X

        $p = if ($isReturn) { $penDashed } else { $penThin }
        $arrowSize = 4

        # Draw horizontal line
        $g.DrawLine($p, $x1, $y, $x2, $y)

        # Draw Arrowhead at x2
        if ($x2 -gt $x1) { # Right
            if ($isReturn) {
                # Open arrowhead
                $g.DrawLine($penThin, $x2, $y, ($x2 - 7), ($y - 4))
                $g.DrawLine($penThin, $x2, $y, ($x2 - 7), ($y + 4))
            } else {
                # Filled arrowhead
                $ap = @(
                    (New-Object System.Drawing.PointF($x2, $y)),
                    (New-Object System.Drawing.PointF(($x2 - 7), ($y - 4))),
                    (New-Object System.Drawing.PointF(($x2 - 7), ($y + 4)))
                )
                $g.FillPolygon($brushBlack, $ap)
            }
        } else { # Left
            if ($isReturn) {
                # Open arrowhead
                $g.DrawLine($penThin, $x2, $y, ($x2 + 7), ($y - 4))
                $g.DrawLine($penThin, $x2, $y, ($x2 + 7), ($y + 4))
            } else {
                # Filled arrowhead
                $ap = @(
                    (New-Object System.Drawing.PointF($x2, $y)),
                    (New-Object System.Drawing.PointF(($x2 + 7), ($y - 4))),
                    (New-Object System.Drawing.PointF(($x2 + 7), ($y + 4)))
                )
                $g.FillPolygon($brushBlack, $ap)
            }
        }

        # Message Text Label above line
        $midX = ($x1 + $x2) / 2
        $lblText = "$msgNum. $text"
        $rectLbl = New-Object System.Drawing.RectangleF(($midX - 110), ($y - 14), 220, 14)
        $g.DrawString($lblText, $fontText, $brushBlack, $rectLbl, $sfCenter)
    }

    # Render Messages
    $startMsgY = $headerY + $headerH + 30
    $msgGap = 48

    for ($i = 0; $i -lt $Messages.Count; $i++) {
        $m = $Messages[$i]
        $msgY = $startMsgY + ($i * $msgGap)
        $num = $i + 1
        Draw-SSDMessage $num $m.From $m.To $msgY $m.Text $m.Return
    }

    $filePath = Join-Path $pictureDir $Filename
    $bmp.Save($filePath, [System.Drawing.Imaging.ImageFormat]::Png)

    if (Test-Path $desktopPictureDir) {
        $desktopFilePath = Join-Path $desktopPictureDir $Filename
        $bmp.Save($desktopFilePath, [System.Drawing.Imaging.ImageFormat]::Png)
    }

    $g.Dispose()
    $bmp.Dispose()
    Write-Host "Generated SSD diagram: $Filename"
}

# ====================================================================
# DEFINE ALL 24 SYSTEM SEQUENCE DIAGRAMS (ssd001.png - ssd024.png)
# ====================================================================

# 1. SSD001: Create Account
Render-SSD -Filename "ssd001.png" -Title "4.6.1 SSD001 Create Account" `
    -ActorName "User (Actor)" -ViewName "Register View" -ControllerName "Register Ctrl" `
    -ModelName "Customer Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="input details & click register"; Return=$false },
        @{ From=1; To=2; Text="register(data)"; Return=$false },
        @{ From=2; To=3; Text="create(validatedData)"; Return=$false },
        @{ From=3; To=4; Text="INSERT INTO customers (name, email...)"; Return=$false },
        @{ From=4; To=3; Text="confirm insertion & row ID"; Return=$true },
        @{ From=3; To=2; Text="Customer instance"; Return=$true },
        @{ From=2; To=1; Text="redirect to dashboard with success"; Return=$true },
        @{ From=1; To=0; Text="display success toast & update view"; Return=$true }
    )

# 2. SSD002: Login
Render-SSD -Filename "ssd002.png" -Title "4.6.2 SSD002 Login" `
    -ActorName "User (Actor)" -ViewName "Login View" -ControllerName "Login Ctrl" `
    -ModelName "User Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="submit login form (email, password)"; Return=$false },
        @{ From=1; To=2; Text="login(email, password)"; Return=$false },
        @{ From=2; To=3; Text="attempt(credentials)"; Return=$false },
        @{ From=3; To=4; Text="SELECT * FROM users WHERE email=?"; Return=$false },
        @{ From=4; To=3; Text="user record & hashed password"; Return=$true },
        @{ From=3; To=2; Text="success status boolean"; Return=$true },
        @{ From=2; To=1; Text="authorize session & redirect dashboard"; Return=$true },
        @{ From=1; To=0; Text="render dashboard page"; Return=$true }
    )

# 3. SSD003: View Account
Render-SSD -Filename "ssd003.png" -Title "4.6.3 SSD003 View Account" `
    -ActorName "User (Actor)" -ViewName "Profile View" -ControllerName "Customer Ctrl" `
    -ModelName "Customer Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="click Profile / Account Details"; Return=$false },
        @{ From=1; To=2; Text="showProfile(userID)"; Return=$false },
        @{ From=2; To=3; Text="findOrFail(userID)"; Return=$false },
        @{ From=3; To=4; Text="SELECT * FROM customers WHERE id=?"; Return=$false },
        @{ From=4; To=3; Text="profile attributes & avatar path"; Return=$true },
        @{ From=3; To=2; Text="Customer object"; Return=$true },
        @{ From=2; To=1; Text="render profile page view"; Return=$true },
        @{ From=1; To=0; Text="display profile details"; Return=$true }
    )

# 4. SSD004: Update Account
Render-SSD -Filename "ssd004.png" -Title "4.6.4 SSD004 Update Account" `
    -ActorName "User (Actor)" -ViewName "Profile View" -ControllerName "Customer Ctrl" `
    -ModelName "Customer Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="modify fields & click Update Profile"; Return=$false },
        @{ From=1; To=2; Text="updateProfile(data)"; Return=$false },
        @{ From=2; To=3; Text="update(validatedData)"; Return=$false },
        @{ From=3; To=4; Text="UPDATE customers SET phone=?, address=?"; Return=$false },
        @{ From=4; To=3; Text="rows updated count"; Return=$true },
        @{ From=3; To=2; Text="updated Customer instance"; Return=$true },
        @{ From=2; To=1; Text="return success alert message"; Return=$true },
        @{ From=1; To=0; Text="display success toast banner"; Return=$true }
    )

# 5. SSD005: Delete Account
Render-SSD -Filename "ssd005.png" -Title "4.6.5 SSD005 Delete Account" `
    -ActorName "Admin" -ViewName "Plumber View" -ControllerName "Staff Ctrl" `
    -ModelName "Staff Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="select plumber & click Delete"; Return=$false },
        @{ From=1; To=2; Text="destroy(plumberID)"; Return=$false },
        @{ From=2; To=3; Text="delete(plumberID)"; Return=$false },
        @{ From=3; To=4; Text="DELETE FROM staffs WHERE id=?"; Return=$false },
        @{ From=4; To=3; Text="confirm record deletion"; Return=$true },
        @{ From=3; To=2; Text="deletion success status"; Return=$true },
        @{ From=2; To=1; Text="redirect & refresh staff list"; Return=$true },
        @{ From=1; To=0; Text="display success alert message"; Return=$true }
    )

# 6. SSD006: Create Booking
Render-SSD -Filename "ssd006.png" -Title "4.6.6 SSD006 Create Booking" `
    -ActorName "Customer" -ViewName "Booking View" -ControllerName "Booking Ctrl" `
    -ModelName "Booking Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="select slot, service & click Submit"; Return=$false },
        @{ From=1; To=2; Text="store(bookingData)"; Return=$false },
        @{ From=2; To=3; Text="create(bookingData)"; Return=$false },
        @{ From=3; To=4; Text="INSERT INTO bookings (service, date...)"; Return=$false },
        @{ From=4; To=3; Text="booking ID & status Pending"; Return=$true },
        @{ From=3; To=2; Text="Booking instance"; Return=$true },
        @{ From=2; To=1; Text="redirect to deposit payment page"; Return=$true },
        @{ From=1; To=0; Text="display deposit payment form"; Return=$true }
    )

# 7. SSD007: View Booking
Render-SSD -Filename "ssd007.png" -Title "4.6.7 SSD007 View Booking" `
    -ActorName "User (Actor)" -ViewName "Bookings View" -ControllerName "Booking Ctrl" `
    -ModelName "Booking Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="click Bookings in sidebar menu"; Return=$false },
        @{ From=1; To=2; Text="index()"; Return=$false },
        @{ From=2; To=3; Text="where('user_id', id)->get()"; Return=$false },
        @{ From=3; To=4; Text="SELECT * FROM bookings WHERE user_id=?"; Return=$false },
        @{ From=4; To=3; Text="booking collection dataset"; Return=$true },
        @{ From=3; To=2; Text="bookings list object"; Return=$true },
        @{ From=2; To=1; Text="render bookings table page"; Return=$true },
        @{ From=1; To=0; Text="display bookings table and status"; Return=$true }
    )

# 8. SSD008: Update Booking
Render-SSD -Filename "ssd008.png" -Title "4.6.8 SSD008 Update Booking" `
    -ActorName "Staff / Admin" -ViewName "Management View" -ControllerName "Booking Ctrl" `
    -ModelName "Booking Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="select plumber & status In Progress"; Return=$false },
        @{ From=1; To=2; Text="updateStatus(bookingID, status)"; Return=$false },
        @{ From=2; To=3; Text="update(['status' => status])"; Return=$false },
        @{ From=3; To=4; Text="UPDATE bookings SET status=? WHERE id=?"; Return=$false },
        @{ From=4; To=3; Text="confirm status update"; Return=$true },
        @{ From=3; To=2; Text="updated Booking instance"; Return=$true },
        @{ From=2; To=1; Text="trigger notification & return"; Return=$true },
        @{ From=1; To=0; Text="display updated status badge"; Return=$true }
    )

# 9. SSD009: Delete Booking
Render-SSD -Filename "ssd009.png" -Title "4.6.9 SSD009 Delete Booking" `
    -ActorName "Customer" -ViewName "Booking View" -ControllerName "Booking Ctrl" `
    -ModelName "Booking Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="click Cancel Booking & enter reason"; Return=$false },
        @{ From=1; To=2; Text="cancel(bookingID, reason)"; Return=$false },
        @{ From=2; To=3; Text="update(['status' => 'cancelled'])"; Return=$false },
        @{ From=3; To=4; Text="UPDATE bookings SET status='cancelled'"; Return=$false },
        @{ From=4; To=3; Text="confirm cancellation record"; Return=$true },
        @{ From=3; To=2; Text="calculate refund eligibility"; Return=$true },
        @{ From=2; To=1; Text="return cancellation summary"; Return=$true },
        @{ From=1; To=0; Text="display cancellation notice"; Return=$true }
    )

# 10. SSD010: Create Payment
Render-SSD -Filename "ssd010.png" -Title "4.6.10 SSD010 Create Payment" `
    -ActorName "Customer" -ViewName "Payment View" -ControllerName "Payment Ctrl" `
    -ModelName "Receipt Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="upload receipt slip & click Submit"; Return=$false },
        @{ From=1; To=2; Text="storeReceipt(fileData)"; Return=$false },
        @{ From=2; To=3; Text="create(receiptData)"; Return=$false },
        @{ From=3; To=4; Text="INSERT INTO payment_receipts (file_path...)"; Return=$false },
        @{ From=4; To=3; Text="receipt ID & status Awaiting"; Return=$true },
        @{ From=3; To=2; Text="PaymentReceipt instance"; Return=$true },
        @{ From=2; To=1; Text="notify admin & redirect"; Return=$true },
        @{ From=1; To=0; Text="display receipt submitted notice"; Return=$true }
    )

# 11. SSD011: View Payment
Render-SSD -Filename "ssd011.png" -Title "4.6.11 SSD011 View Payment" `
    -ActorName "Customer / Admin" -ViewName "Payment View" -ControllerName "Payment Ctrl" `
    -ModelName "Receipt Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="click View Receipt / Download PDF"; Return=$false },
        @{ From=1; To=2; Text="showReceipt(receiptID)"; Return=$false },
        @{ From=2; To=3; Text="findOrFail(receiptID)"; Return=$false },
        @{ From=3; To=4; Text="SELECT * FROM payment_receipts WHERE id=?"; Return=$false },
        @{ From=4; To=3; Text="receipt record & slip file"; Return=$true },
        @{ From=3; To=2; Text="PaymentReceipt object"; Return=$true },
        @{ From=2; To=1; Text="stream PDF file / display modal"; Return=$true },
        @{ From=1; To=0; Text="render receipt preview"; Return=$true }
    )

# 12. SSD012: Update Payment
Render-SSD -Filename "ssd012.png" -Title "4.6.12 SSD012 Update Payment" `
    -ActorName "Admin" -ViewName "Verification View" -ControllerName "Payment Ctrl" `
    -ModelName "Booking/Payment" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="select plumber & click Approve"; Return=$false },
        @{ From=1; To=2; Text="verifyPayment(receiptID, 'Paid')"; Return=$false },
        @{ From=2; To=3; Text="update(['status' => 'Paid'])"; Return=$false },
        @{ From=3; To=4; Text="UPDATE payment_receipts & bookings"; Return=$false },
        @{ From=4; To=3; Text="confirm payment status Paid"; Return=$true },
        @{ From=3; To=2; Text="updated Models"; Return=$true },
        @{ From=2; To=1; Text="send confirmation email & return"; Return=$true },
        @{ From=1; To=0; Text="display payment approved alert"; Return=$true }
    )

# 13. SSD013: Create Refund
Render-SSD -Filename "ssd013.png" -Title "4.6.13 SSD013 Create Refund" `
    -ActorName "System" -ViewName "Cancel Engine" -ControllerName "Refund Ctrl" `
    -ModelName "Refund Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="trigger refund check (cancellation)"; Return=$false },
        @{ From=1; To=2; Text="processRefund(bookingID)"; Return=$false },
        @{ From=2; To=3; Text="create(['amount' => calc, 'status' => 'pending'])"; Return=$false },
        @{ From=3; To=4; Text="INSERT INTO refunds (booking_id, amount...)"; Return=$false },
        @{ From=4; To=3; Text="refund record ID"; Return=$true },
        @{ From=3; To=2; Text="Refund instance"; Return=$true },
        @{ From=2; To=1; Text="log in admin refund queue"; Return=$true },
        @{ From=1; To=0; Text="refund request initiated"; Return=$true }
    )

# 14. SSD014: View Refund
Render-SSD -Filename "ssd014.png" -Title "4.6.14 SSD014 View Refund" `
    -ActorName "Admin" -ViewName "Refund View" -ControllerName "Refund Ctrl" `
    -ModelName "Refund Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="click Refunds menu tab"; Return=$false },
        @{ From=1; To=2; Text="index()"; Return=$false },
        @{ From=2; To=3; Text="with('booking.customer')->get()"; Return=$false },
        @{ From=3; To=4; Text="SELECT * FROM refunds JOIN bookings"; Return=$false },
        @{ From=4; To=3; Text="refund records collection"; Return=$true },
        @{ From=3; To=2; Text="refund list"; Return=$true },
        @{ From=2; To=1; Text="render refunds table"; Return=$true },
        @{ From=1; To=0; Text="display bank details & amounts"; Return=$true }
    )

# 15. SSD015: Update Refund
Render-SSD -Filename "ssd015.png" -Title "4.6.15 SSD015 Update Refund" `
    -ActorName "Admin" -ViewName "Refund View" -ControllerName "Refund Ctrl" `
    -ModelName "Refund Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="upload transfer slip & click Complete"; Return=$false },
        @{ From=1; To=2; Text="completeRefund(refundID, file)"; Return=$false },
        @{ From=2; To=3; Text="update(['status' => 'refunded'])"; Return=$false },
        @{ From=3; To=4; Text="UPDATE refunds SET status='refunded'"; Return=$false },
        @{ From=4; To=3; Text="confirm status update"; Return=$true },
        @{ From=3; To=2; Text="updated Refund"; Return=$true },
        @{ From=2; To=1; Text="email proof slip to customer"; Return=$true },
        @{ From=1; To=0; Text="display refund completed toast"; Return=$true }
    )

# 16. SSD016: Create Job Record
Render-SSD -Filename "ssd016.png" -Title "4.6.16 SSD016 Create Job Record" `
    -ActorName "Plumber" -ViewName "Job Form View" -ControllerName "JobRecord Ctrl" `
    -ModelName "JobRecord Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="input costs & click save job record"; Return=$false },
        @{ From=1; To=2; Text="store(jobRecordData)"; Return=$false },
        @{ From=2; To=3; Text="create(jobRecordData)"; Return=$false },
        @{ From=3; To=4; Text="INSERT INTO job_records (labor, parts...)"; Return=$false },
        @{ From=4; To=3; Text="job record ID"; Return=$true },
        @{ From=3; To=2; Text="JobRecord instance"; Return=$true },
        @{ From=2; To=1; Text="set booking Completed & return"; Return=$true },
        @{ From=1; To=0; Text="display job completed alert"; Return=$true }
    )

# 17. SSD017: View Job Record
Render-SSD -Filename "ssd017.png" -Title "4.6.17 SSD017 View Job Record" `
    -ActorName "User (Actor)" -ViewName "Invoice View" -ControllerName "JobRecord Ctrl" `
    -ModelName "JobRecord Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="click View Job Summary / Print Invoice"; Return=$false },
        @{ From=1; To=2; Text="show(jobRecordID)"; Return=$false },
        @{ From=2; To=3; Text="findOrFail(jobRecordID)"; Return=$false },
        @{ From=3; To=4; Text="SELECT * FROM job_records WHERE id=?"; Return=$false },
        @{ From=4; To=3; Text="job record details"; Return=$true },
        @{ From=3; To=2; Text="JobRecord object"; Return=$true },
        @{ From=2; To=1; Text="render itemized invoice layout"; Return=$true },
        @{ From=1; To=0; Text="display invoice summary"; Return=$true }
    )

# 18. SSD018: Update Job Record
Render-SSD -Filename "ssd018.png" -Title "4.6.18 SSD018 Update Job Record" `
    -ActorName "Plumber" -ViewName "Job Edit View" -ControllerName "JobRecord Ctrl" `
    -ModelName "JobRecord Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="modify costs & click update record"; Return=$false },
        @{ From=1; To=2; Text="update(jobRecordID, data)"; Return=$false },
        @{ From=2; To=3; Text="update(data)"; Return=$false },
        @{ From=3; To=4; Text="UPDATE job_records SET labor=?, parts=?"; Return=$false },
        @{ From=4; To=3; Text="confirm record update"; Return=$true },
        @{ From=3; To=2; Text="updated JobRecord"; Return=$true },
        @{ From=2; To=1; Text="return success notification"; Return=$true },
        @{ From=1; To=0; Text="display job record updated toast"; Return=$true }
    )

# 19. SSD019: Generate Report
Render-SSD -Filename "ssd019.png" -Title "4.6.19 SSD019 Generate Report" `
    -ActorName "Admin" -ViewName "Analytics View" -ControllerName "Report Ctrl" `
    -ModelName "Report Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="select calendar year filter"; Return=$false },
        @{ From=1; To=2; Text="generateReport(year)"; Return=$false },
        @{ From=2; To=3; Text="aggregateMonthlyMetrics(year)"; Return=$false },
        @{ From=3; To=4; Text="SELECT SUM(total), COUNT(*) FROM bookings"; Return=$false },
        @{ From=4; To=3; Text="revenue & booking statistics"; Return=$true },
        @{ From=3; To=2; Text="aggregated dataset"; Return=$true },
        @{ From=2; To=1; Text="render revenue charts & tables"; Return=$true },
        @{ From=1; To=0; Text="display analytics dashboard"; Return=$true }
    )

# 20. SSD020: Create Feedback
Render-SSD -Filename "ssd020.png" -Title "4.6.20 SSD020 Create Feedback" `
    -ActorName "Customer" -ViewName "Feedback View" -ControllerName "Feedback Ctrl" `
    -ModelName "Feedback Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="select rating, enter comment & click submit"; Return=$false },
        @{ From=1; To=2; Text="store(feedbackData)"; Return=$false },
        @{ From=2; To=3; Text="create(feedbackData)"; Return=$false },
        @{ From=3; To=4; Text="INSERT INTO feedbacks (rating, comment...)"; Return=$false },
        @{ From=4; To=3; Text="feedback ID"; Return=$true },
        @{ From=3; To=2; Text="Feedback instance"; Return=$true },
        @{ From=2; To=1; Text="alert plumber & return confirmation"; Return=$true },
        @{ From=1; To=0; Text="display Thank You modal"; Return=$true }
    )

# 21. SSD021: View Feedback
Render-SSD -Filename "ssd021.png" -Title "4.6.21 SSD021 View Feedback" `
    -ActorName "Staff / Admin" -ViewName "Feedback View" -ControllerName "Feedback Ctrl" `
    -ModelName "Feedback Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="click feedback menu tab"; Return=$false },
        @{ From=1; To=2; Text="index()"; Return=$false },
        @{ From=2; To=3; Text="with('customer', 'booking')->get()"; Return=$false },
        @{ From=3; To=4; Text="SELECT * FROM feedbacks"; Return=$false },
        @{ From=4; To=3; Text="feedbacks collection"; Return=$true },
        @{ From=3; To=2; Text="feedback feed"; Return=$true },
        @{ From=2; To=1; Text="render feedback feed & reply box"; Return=$true },
        @{ From=1; To=0; Text="display reviews & star ratings"; Return=$true }
    )

# 22. SSD022: Create Chat Message
Render-SSD -Filename "ssd022.png" -Title "4.6.22 SSD022 Create Chat Message" `
    -ActorName "User (Actor)" -ViewName "Chat View" -ControllerName "Chat Ctrl" `
    -ModelName "Message Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="type text message & click send"; Return=$false },
        @{ From=1; To=2; Text="sendMessage(bookingID, text)"; Return=$false },
        @{ From=2; To=3; Text="create(['message' => text])"; Return=$false },
        @{ From=3; To=4; Text="INSERT INTO chat_messages (booking_id...)"; Return=$false },
        @{ From=4; To=3; Text="message ID & timestamp"; Return=$true },
        @{ From=3; To=2; Text="ChatMessage instance"; Return=$true },
        @{ From=2; To=1; Text="broadcast Pusher event"; Return=$true },
        @{ From=1; To=0; Text="append message bubble to chat"; Return=$true }
    )

# 23. SSD023: View Chat Messages
Render-SSD -Filename "ssd023.png" -Title "4.6.23 SSD023 View Chat Messages" `
    -ActorName "User (Actor)" -ViewName "Chat View" -ControllerName "Chat Ctrl" `
    -ModelName "Message Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="open chat widget on booking"; Return=$false },
        @{ From=1; To=2; Text="getMessages(bookingID)"; Return=$false },
        @{ From=2; To=3; Text="where('booking_id', id)->get()"; Return=$false },
        @{ From=3; To=4; Text="SELECT * FROM chat_messages WHERE booking_id=?"; Return=$false },
        @{ From=4; To=3; Text="chat message logs"; Return=$true },
        @{ From=3; To=2; Text="message collection"; Return=$true },
        @{ From=2; To=1; Text="update is_read=true & render"; Return=$true },
        @{ From=1; To=0; Text="display conversation timeline"; Return=$true }
    )

# 24. SSD024: View Push Notifications
Render-SSD -Filename "ssd024.png" -Title "4.6.24 SSD024 View Push Notifications" `
    -ActorName "User (Actor)" -ViewName "Header View" -ControllerName "Notification Ctrl" `
    -ModelName "Notification Model" -DBName "Database" -Messages @(
        @{ From=0; To=1; Text="click notification bell icon"; Return=$false },
        @{ From=1; To=2; Text="getUnreadNotifications()"; Return=$false },
        @{ From=2; To=3; Text="where('user_id', id)->whereNull('read_at')->get()"; Return=$false },
        @{ From=3; To=4; Text="SELECT * FROM notifications WHERE user_id=?"; Return=$false },
        @{ From=4; To=3; Text="unread notifications list"; Return=$true },
        @{ From=3; To=2; Text="notifications collection"; Return=$true },
        @{ From=2; To=1; Text="render dropdown & update read_at"; Return=$true },
        @{ From=1; To=0; Text="display notification dropdown list"; Return=$true }
    )

Write-Host "All 24 System Sequence Diagrams (ssd001.png - ssd024.png) rendered successfully!"
