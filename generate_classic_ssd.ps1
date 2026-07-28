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

function Create-ClassicSSD {
    param(
        [string]$Filename,
        [string]$ActorLabel,
        [string]$RequestMsg,
        [string]$ResponseMsg
    )

    $width = 560
    $height = 380
    $bmp = New-Object System.Drawing.Bitmap($width, $height)
    $g = [System.Drawing.Graphics]::FromImage($bmp)
    $g.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::HighQuality
    $g.TextRenderingHint = [System.Drawing.Text.TextRenderingHint]::AntiAliasGridFit
    $g.Clear([System.Drawing.Color]::White)

    $penBorder = New-Object System.Drawing.Pen([System.Drawing.Color]::Black, 1.5)
    $penSolid = New-Object System.Drawing.Pen([System.Drawing.Color]::Black, 1.2)
    $penDashed = New-Object System.Drawing.Pen([System.Drawing.Color]::FromArgb(80, 80, 80), 1.2)
    $penDashed.DashStyle = [System.Drawing.Drawing2D.DashStyle]::Dash

    $brushBlack = [System.Drawing.Brushes]::Black

    $fontText = New-Object System.Drawing.Font("Arial", 9.5, [System.Drawing.FontStyle]::Regular)
    $fontSystem = New-Object System.Drawing.Font("Arial", 10.5, [System.Drawing.FontStyle]::Underline)

    $sfCenter = New-Object System.Drawing.StringFormat
    $sfCenter.Alignment = [System.Drawing.StringAlignment]::Center
    $sfCenter.LineAlignment = [System.Drawing.StringAlignment]::Center

    # 1. Outer Frame
    $margin = 15
    $frameW = $width - ($margin * 2)
    $frameH = $height - ($margin * 2)
    $g.DrawRectangle($penBorder, $margin, $margin, $frameW, $frameH)

    # Lifeline X positions
    $actorX = 110
    $systemX = 440

    # 2. Draw Actor Stick Figure (Left)
    $headR = 14
    $headY = 55
    # Head
    $g.DrawEllipse($penSolid, ($actorX - $headR), ($headY - $headR), ($headR * 2), ($headR * 2))
    # Body
    $g.DrawLine($penSolid, $actorX, ($headY + $headR), $actorX, 102)
    # Arms
    $g.DrawLine($penSolid, ($actorX - 22), 80, ($actorX + 22), 80)
    # Legs
    $g.DrawLine($penSolid, $actorX, 102, ($actorX - 16), 130)
    $g.DrawLine($penSolid, $actorX, 102, ($actorX + 16), 130)

    # Actor Text Label
    $rectActorText = New-Object System.Drawing.RectangleF(($actorX - 70), 134, 140, 22)
    $g.DrawString($ActorLabel, $fontText, $brushBlack, $rectActorText, $sfCenter)

    # 3. Draw :System Box (Right)
    $boxW = 130
    $boxH = 55
    $boxX = $systemX - ($boxW / 2) # 375
    $boxY = 55
    $rectSystemBox = New-Object System.Drawing.RectangleF($boxX, $boxY, $boxW, $boxH)
    $g.DrawRectangle($penSolid, $boxX, $boxY, $boxW, $boxH)
    $g.DrawString(":System", $fontSystem, $brushBlack, $rectSystemBox, $sfCenter)

    # 4. Vertical Dashed Lifelines
    $actorLineTopY = 156
    $systemLineTopY = 110 # EXACTLY boxY + boxH
    $lineBottomY = 350

    $g.DrawLine($penDashed, $actorX, $actorLineTopY, $actorX, $lineBottomY)
    $g.DrawLine($penDashed, $systemX, $systemLineTopY, $systemX, $lineBottomY)

    # 5. Request Message (Solid Arrow, Top)
    $reqY = 205
    $g.DrawLine($penSolid, $actorX, $reqY, $systemX, $reqY)
    $arrowSize = 5.5
    $ptsReq = @(
        (New-Object System.Drawing.PointF($systemX, $reqY)),
        (New-Object System.Drawing.PointF(($systemX - 10), ($reqY - $arrowSize))),
        (New-Object System.Drawing.PointF(($systemX - 10), ($reqY + $arrowSize)))
    )
    $g.FillPolygon($brushBlack, $ptsReq)

    # Request Text Label above arrow
    $rectReqText = New-Object System.Drawing.RectangleF(($actorX + 10), ($reqY - 32), ($systemX - $actorX - 20), 30)
    $g.DrawString($RequestMsg, $fontText, $brushBlack, $rectReqText, $sfCenter)

    # 6. Response Message (Dashed Arrow, Bottom)
    $resY = 280
    $g.DrawLine($penDashed, $systemX, $resY, $actorX, $resY)
    # Open Arrowhead at $actorX pointing left
    $g.DrawLine($penSolid, $actorX, $resY, ($actorX + 10), ($resY - $arrowSize))
    $g.DrawLine($penSolid, $actorX, $resY, ($actorX + 10), ($resY + $arrowSize))

    # Response Text Label above arrow
    $rectResText = New-Object System.Drawing.RectangleF(($actorX + 10), ($resY - 26), ($systemX - $actorX - 20), 24)
    $g.DrawString($ResponseMsg, $fontText, $brushBlack, $rectResText, $sfCenter)

    # Save to picture directory
    $filePath = Join-Path $pictureDir $Filename
    $bmp.Save($filePath, [System.Drawing.Imaging.ImageFormat]::Png)

    if (Test-Path $desktopPictureDir) {
        $desktopFilePath = Join-Path $desktopPictureDir $Filename
        $bmp.Save($desktopFilePath, [System.Drawing.Imaging.ImageFormat]::Png)
    }

    $g.Dispose()
    $bmp.Dispose()
    Write-Host "Generated SSD with updated actor ($ActorLabel): $Filename"
}

# -----------------------------------------------------------
# ALL 24 SYSTEM SEQUENCE DIAGRAMS (Classic 2-Lifeline SSDs)
# -----------------------------------------------------------

Create-ClassicSSD -Filename "ssd001.png" -ActorLabel "Staff / Customer" `
    -RequestMsg "create account (name, address,`nphone number, password)" `
    -ResponseMsg "account successfully register"

Create-ClassicSSD -Filename "ssd002.png" -ActorLabel "Staff / Customer" `
    -RequestMsg "login (email, password)" `
    -ResponseMsg "login successful, display dashboard"

Create-ClassicSSD -Filename "ssd003.png" -ActorLabel "Staff / Customer" `
    -RequestMsg "view account details ()" `
    -ResponseMsg "display profile details"

Create-ClassicSSD -Filename "ssd004.png" -ActorLabel "Staff / Customer" `
    -RequestMsg "update account (name, phone number, address, password)" `
    -ResponseMsg "account successfully updated"

Create-ClassicSSD -Filename "ssd005.png" -ActorLabel "Staff / Admin" `
    -RequestMsg "delete account (plumber_id)" `
    -ResponseMsg "account successfully deleted"

Create-ClassicSSD -Filename "ssd006.png" -ActorLabel "Customer" `
    -RequestMsg "create booking (service_type, date, time_slot, description)" `
    -ResponseMsg "booking created, prompt deposit payment"

Create-ClassicSSD -Filename "ssd007.png" -ActorLabel "Staff / Customer" `
    -RequestMsg "view booking details (booking_id)" `
    -ResponseMsg "display booking details"

Create-ClassicSSD -Filename "ssd008.png" -ActorLabel "Staff / Admin" `
    -RequestMsg "update booking (booking_id, status, assigned_plumber)" `
    -ResponseMsg "booking successfully updated"

Create-ClassicSSD -Filename "ssd009.png" -ActorLabel "Customer" `
    -RequestMsg "cancel booking (booking_id, reason)" `
    -ResponseMsg "booking cancelled, refund status logged"

Create-ClassicSSD -Filename "ssd010.png" -ActorLabel "Customer" `
    -RequestMsg "submit payment receipt (booking_id, receipt_slip)" `
    -ResponseMsg "payment receipt uploaded successfully"

Create-ClassicSSD -Filename "ssd011.png" -ActorLabel "Customer / Staff" `
    -RequestMsg "view payment receipt (payment_id)" `
    -ResponseMsg "display receipt details and invoice"

Create-ClassicSSD -Filename "ssd012.png" -ActorLabel "Staff / Admin" `
    -RequestMsg "verify payment (payment_id, status, plumber_id)" `
    -ResponseMsg "payment verified successfully"

Create-ClassicSSD -Filename "ssd013.png" -ActorLabel "Customer" `
    -RequestMsg "initiate refund (booking_id, refund_amount)" `
    -ResponseMsg "refund request created"

Create-ClassicSSD -Filename "ssd014.png" -ActorLabel "Customer / Staff" `
    -RequestMsg "view refund list ()" `
    -ResponseMsg "display refund list and bank details"

Create-ClassicSSD -Filename "ssd015.png" -ActorLabel "Staff / Admin" `
    -RequestMsg "complete refund (refund_id, transfer_slip)" `
    -ResponseMsg "refund completed successfully"

Create-ClassicSSD -Filename "ssd016.png" -ActorLabel "Staff / Admin" `
    -RequestMsg "create job record (booking_id, labor_cost, parts_cost, notes)" `
    -ResponseMsg "job record saved, booking completed"

Create-ClassicSSD -Filename "ssd017.png" -ActorLabel "Staff / Customer" `
    -RequestMsg "view job record (job_id)" `
    -ResponseMsg "display job summary and invoice"

Create-ClassicSSD -Filename "ssd018.png" -ActorLabel "Staff / Admin" `
    -RequestMsg "update job record (job_id, labor_cost, parts_cost, notes)" `
    -ResponseMsg "job record updated successfully"

Create-ClassicSSD -Filename "ssd019.png" -ActorLabel "Staff / Admin" `
    -RequestMsg "generate system report (year, report_type)" `
    -ResponseMsg "display analytics report and charts"

Create-ClassicSSD -Filename "ssd020.png" -ActorLabel "Customer" `
    -RequestMsg "submit feedback (booking_id, rating, comment)" `
    -ResponseMsg "feedback submitted successfully"

Create-ClassicSSD -Filename "ssd021.png" -ActorLabel "Customer" `
    -RequestMsg "view feedback list ()" `
    -ResponseMsg "display feedback list and ratings"

Create-ClassicSSD -Filename "ssd022.png" -ActorLabel "Customer / Staff" `
    -RequestMsg "send chat message (booking_id, message_text)" `
    -ResponseMsg "message sent successfully"

Create-ClassicSSD -Filename "ssd023.png" -ActorLabel "Customer / Staff" `
    -RequestMsg "view chat history (booking_id)" `
    -ResponseMsg "display chat message history"

Create-ClassicSSD -Filename "ssd024.png" -ActorLabel "Staff / Customer" `
    -RequestMsg "view notifications ()" `
    -ResponseMsg "display unread notification list"

Write-Host "All 24 SSD PNG images updated with requested actors!"
