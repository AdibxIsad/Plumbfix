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

function Draw-ArrowLine {
    param($g, $pen, $brush, $x1, $y1, $x2, $y2, $label="")

    $g.DrawLine($pen, $x1, $y1, $x2, $y2)
    $arrowSize = 5

    if ($x1 -eq $x2) {
        if ($y2 -gt $y1) { # Down
            $pts = @(
                (New-Object System.Drawing.PointF($x2, $y2)),
                (New-Object System.Drawing.PointF(($x2 - $arrowSize), ($y2 - ($arrowSize * 1.6)))),
                (New-Object System.Drawing.PointF(($x2 + $arrowSize), ($y2 - ($arrowSize * 1.6))))
            )
            $g.FillPolygon($brush, $pts)
        } elseif ($y2 -lt $y1) { # Up
            $pts = @(
                (New-Object System.Drawing.PointF($x2, $y2)),
                (New-Object System.Drawing.PointF(($x2 - $arrowSize), ($y2 + ($arrowSize * 1.6)))),
                (New-Object System.Drawing.PointF(($x2 + $arrowSize), ($y2 + ($arrowSize * 1.6))))
            )
            $g.FillPolygon($brush, $pts)
        }
    } elseif ($y1 -eq $y2) {
        if ($x2 -gt $x1) { # Right
            $pts = @(
                (New-Object System.Drawing.PointF($x2, $y2)),
                (New-Object System.Drawing.PointF(($x2 - ($arrowSize * 1.6)), ($y2 - $arrowSize))),
                (New-Object System.Drawing.PointF(($x2 - ($arrowSize * 1.6)), ($y2 + $arrowSize)))
            )
            $g.FillPolygon($brush, $pts)
        } elseif ($x2 -lt $x1) { # Left
            $pts = @(
                (New-Object System.Drawing.PointF($x2, $y2)),
                (New-Object System.Drawing.PointF(($x2 + ($arrowSize * 1.6)), ($y2 - $arrowSize))),
                (New-Object System.Drawing.PointF(($x2 + ($arrowSize * 1.6)), ($y2 + $arrowSize)))
            )
            $g.FillPolygon($brush, $pts)
        }
    }

    if ($label -ne "") {
        $fontLabel = New-Object System.Drawing.Font("Arial", 8, [System.Drawing.FontStyle]::Bold)
        $midX = ($x1 + $x2) / 2
        $midY = ($y1 + $y2) / 2
        $g.DrawString($label, $fontLabel, $brush, ($midX + 4), ($midY - 14))
    }
}

function Draw-PolylineArrow {
    param($g, $pen, $brush, [array]$pts, $label="")

    for ($i = 0; $i -lt ($pts.Length - 1); $i++) {
        $pA = $pts[$i]
        $pB = $pts[$i+1]
        $g.DrawLine($pen, $pA.X, $pA.Y, $pB.X, $pB.Y)
    }

    $pLast = $pts[$pts.Length - 1]
    $pPrev = $pts[$pts.Length - 2]
    $arrowSize = 5

    if ([Math]::Abs($pPrev.X - $pLast.X) -lt 2) {
        if ($pLast.Y -gt $pPrev.Y) { # Down
            $ap = @(
                (New-Object System.Drawing.PointF($pLast.X, $pLast.Y)),
                (New-Object System.Drawing.PointF(($pLast.X - $arrowSize), ($pLast.Y - ($arrowSize * 1.6)))),
                (New-Object System.Drawing.PointF(($pLast.X + $arrowSize), ($pLast.Y - ($arrowSize * 1.6))))
            )
            $g.FillPolygon($brush, $ap)
        } elseif ($pLast.Y -lt $pPrev.Y) { # Up
            $ap = @(
                (New-Object System.Drawing.PointF($pLast.X, $pLast.Y)),
                (New-Object System.Drawing.PointF(($pLast.X - $arrowSize), ($pLast.Y + ($arrowSize * 1.6)))),
                (New-Object System.Drawing.PointF(($pLast.X + $arrowSize), ($pLast.Y + ($arrowSize * 1.6))))
            )
            $g.FillPolygon($brush, $ap)
        }
    } elseif ([Math]::Abs($pPrev.Y - $pLast.Y) -lt 2) {
        if ($pLast.X -gt $pPrev.X) { # Right
            $ap = @(
                (New-Object System.Drawing.PointF($pLast.X, $pLast.Y)),
                (New-Object System.Drawing.PointF(($pLast.X - ($arrowSize * 1.6)), ($pLast.Y - $arrowSize))),
                (New-Object System.Drawing.PointF(($pLast.X - ($arrowSize * 1.6)), ($pLast.Y + $arrowSize)))
            )
            $g.FillPolygon($brush, $ap)
        } elseif ($pLast.X -lt $pPrev.X) { # Left
            $ap = @(
                (New-Object System.Drawing.PointF($pLast.X, $pLast.Y)),
                (New-Object System.Drawing.PointF(($pLast.X + ($arrowSize * 1.6)), ($pLast.Y - $arrowSize))),
                (New-Object System.Drawing.PointF(($pLast.X + ($arrowSize * 1.6)), ($pLast.Y + $arrowSize)))
            )
            $g.FillPolygon($brush, $ap)
        }
    }

    if ($label -ne "") {
        $fontLabel = New-Object System.Drawing.Font("Arial", 8, [System.Drawing.FontStyle]::Bold)
        $p1 = $pts[0]
        $p2 = $pts[1]
        $lx = ($p1.X + $p2.X) / 2
        $ly = ($p1.Y + $p2.Y) / 2
        $g.DrawString($label, $fontLabel, $brush, ($lx - 25), ($ly - 14))
    }
}

function Render-InteractiveDiagram {
    param(
        [string]$Filename,
        [string]$Title,
        [string]$ActorName,
        [string]$ActorStep1,
        [string]$ActorStep2,
        [string]$SystemStep1,
        [string]$ActorStep3,
        [string]$SystemStep2,
        [string]$DecisionText,
        [string]$SystemSuccess,
        [string]$SystemNext
    )

    $width = 550
    $height = 700
    $bmp = New-Object System.Drawing.Bitmap($width, $height)
    $g = [System.Drawing.Graphics]::FromImage($bmp)
    $g.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::HighQuality
    $g.TextRenderingHint = [System.Drawing.Text.TextRenderingHint]::AntiAliasGridFit
    $g.Clear([System.Drawing.Color]::White)

    $penBlack = New-Object System.Drawing.Pen([System.Drawing.Color]::Black, 1.5)
    $penThin = New-Object System.Drawing.Pen([System.Drawing.Color]::Black, 1)
    $brushBlack = [System.Drawing.Brushes]::Black
    $brushWhite = [System.Drawing.Brushes]::White

    $fontTitle = New-Object System.Drawing.Font("Arial", 11, [System.Drawing.FontStyle]::Bold)
    $fontHeader = New-Object System.Drawing.Font("Arial", 9.5, [System.Drawing.FontStyle]::Bold)
    $fontText = New-Object System.Drawing.Font("Arial", 8.5, [System.Drawing.FontStyle]::Regular)
    $fontLabel = New-Object System.Drawing.Font("Arial", 8, [System.Drawing.FontStyle]::Bold)

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

    # Swimlane Headers
    $swimHeaderY = $margin + $titleH
    $swimHeaderH = 28
    $midX = $margin + ($frameW / 2)
    $g.DrawRectangle($penThin, $margin, $swimHeaderY, $frameW, $swimHeaderH)
    $g.DrawLine($penBlack, $midX, $swimHeaderY, $midX, ($margin + $frameH))

    $rectLeftHeader = New-Object System.Drawing.RectangleF($margin, $swimHeaderY, ($frameW/2), $swimHeaderH)
    $rectRightHeader = New-Object System.Drawing.RectangleF($midX, $swimHeaderY, ($frameW/2), $swimHeaderH)
    $g.DrawString($ActorName, $fontHeader, $brushBlack, $rectLeftHeader, $sfCenter)
    $g.DrawString("System", $fontHeader, $brushBlack, $rectRightHeader, $sfCenter)

    $leftX = $margin + ($frameW / 4) # 145
    $rightX = $midX + ($frameW / 4)  # 405

    # Helper to draw rounded rectangle box
    function Draw-Box($cx, $cy, $bw, $bh, $text) {
        $bx = $cx - ($bw / 2)
        $by = $cy - ($bh / 2)
        $rect = New-Object System.Drawing.RectangleF($bx, $by, $bw, $bh)
        $path = New-Object System.Drawing.Drawing2D.GraphicsPath
        $cornerR = 10
        $path.AddArc($bx, $by, $cornerR, $cornerR, 180, 90)
        $path.AddArc(($bx + $bw - $cornerR), $by, $cornerR, $cornerR, 270, 90)
        $path.AddArc(($bx + $bw - $cornerR), ($by + $bh - $cornerR), $cornerR, $cornerR, 0, 90)
        $path.AddArc($bx, ($by + $bh - $cornerR), $cornerR, $cornerR, 90, 90)
        $path.CloseFigure()

        $g.FillPath($brushWhite, $path)
        $g.DrawPath($penThin, $path)
        $g.DrawString($text, $fontText, $brushBlack, $rect, $sfCenter)
    }

    # 1. Start Node
    $rStart = 13
    $g.FillEllipse($brushBlack, ($leftX - $rStart), (85 - $rStart), ($rStart * 2), ($rStart * 2))

    # Arrow Start -> Actor Step 1
    Draw-ArrowLine $g $penThin $brushBlack $leftX (85 + $rStart) $leftX (135 - 18)

    # 2. Actor Step 1 Box
    Draw-Box $leftX 135 150 36 $ActorStep1

    # Arrow Step 1 -> Step 2
    Draw-ArrowLine $g $penThin $brushBlack $leftX (135 + 18) $leftX (195 - 18)

    # 3. Actor Step 2 Box
    Draw-Box $leftX 195 150 36 $ActorStep2

    # Arrow Step 2 -> System Step 1
    Draw-ArrowLine $g $penThin $brushBlack ($leftX + 75) 195 ($rightX - 75) 195

    # 4. System Step 1 Box
    Draw-Box $rightX 195 150 36 $SystemStep1

    # Arrow System Step 1 -> Actor Step 3 (Down-Left Polyline)
    $ptsSysToAct = @(
        (New-Object System.Drawing.PointF($rightX, (195 + 18))),
        (New-Object System.Drawing.PointF($rightX, 245)),
        (New-Object System.Drawing.PointF($leftX, 245)),
        (New-Object System.Drawing.PointF($leftX, (280 - 20)))
    )
    Draw-PolylineArrow $g $penThin $brushBlack $ptsSysToAct

    # 5. Actor Step 3 Box
    Draw-Box $leftX 280 160 40 $ActorStep3

    # Arrow Actor Step 3 -> System Step 2 (Horizontal Right)
    Draw-ArrowLine $g $penThin $brushBlack ($leftX + 80) 280 ($rightX - 75) 280

    # 6. System Step 2 Box
    Draw-Box $rightX 280 150 36 $SystemStep2

    # Arrow System Step 2 -> Decision (Vertical Down)
    Draw-ArrowLine $g $penThin $brushBlack $rightX (280 + 18) $rightX (370 - 22)

    # 7. Decision Diamond
    $dw = 90
    $dh = 44
    $decY = 370
    $ptsDec = @(
        (New-Object System.Drawing.PointF($rightX, ($decY - ($dh/2)))),
        (New-Object System.Drawing.PointF(($rightX + ($dw/2)), $decY)),
        (New-Object System.Drawing.PointF($rightX, ($decY + ($dh/2)))),
        (New-Object System.Drawing.PointF(($rightX - ($dw/2)), $decY))
    )
    $g.FillPolygon($brushWhite, $ptsDec)
    $g.DrawPolygon($penThin, $ptsDec)
    $rectDec = New-Object System.Drawing.RectangleF(($rightX - ($dw/2)), ($decY - ($dh/2)), $dw, $dh)
    $g.DrawString($DecisionText, $fontText, $brushBlack, $rectDec, $sfCenter)

    # NO Branch (Loopback to Actor Step 3)
    $ptsNo = @(
        (New-Object System.Drawing.PointF(($rightX - ($dw/2)), $decY)),
        (New-Object System.Drawing.PointF($leftX, $decY)),
        (New-Object System.Drawing.PointF($leftX, (280 + 20)))
    )
    Draw-PolylineArrow $g $penThin $brushBlack $ptsNo "NO"

    # YES Branch (Down to System Success Box)
    $succY = 460
    Draw-ArrowLine $g $penThin $brushBlack $rightX ($decY + ($dh/2)) $rightX ($succY - 19) "YES"

    # 8. System Success Box
    Draw-Box $rightX $succY 150 38 $SystemSuccess

    if ($SystemNext) {
        $nextY = 540
        Draw-ArrowLine $g $penThin $brushBlack $rightX ($succY + 19) $rightX ($nextY - 18)
        Draw-Box $rightX $nextY 150 36 $SystemNext

        # Arrow to End Node
        $endY = 615
        Draw-ArrowLine $g $penThin $brushBlack $rightX ($nextY + 18) $rightX ($endY - 16)
        $rEnd1 = 15
        $rEnd2 = 9
        $g.DrawEllipse($penBlack, ($rightX - $rEnd1), ($endY - $rEnd1), ($rEnd1 * 2), ($rEnd1 * 2))
        $g.FillEllipse($brushBlack, ($rightX - $rEnd2), ($endY - $rEnd2), ($rEnd2 * 2), ($rEnd2 * 2))
    } else {
        $endY = 540
        Draw-ArrowLine $g $penThin $brushBlack $rightX ($succY + 19) $rightX ($endY - 16)
        $rEnd1 = 15
        $rEnd2 = 9
        $g.DrawEllipse($penBlack, ($rightX - $rEnd1), ($endY - $rEnd1), ($rEnd1 * 2), ($rEnd1 * 2))
        $g.FillEllipse($brushBlack, ($rightX - $rEnd2), ($endY - $rEnd2), ($rEnd2 * 2), ($rEnd2 * 2))
    }

    $filePath = Join-Path $pictureDir $Filename
    $bmp.Save($filePath, [System.Drawing.Imaging.ImageFormat]::Png)

    if (Test-Path $desktopPictureDir) {
        $desktopFilePath = Join-Path $desktopPictureDir $Filename
        $bmp.Save($desktopFilePath, [System.Drawing.Imaging.ImageFormat]::Png)
    }

    $g.Dispose()
    $bmp.Dispose()
    Write-Host "Generated interactive diagram: $Filename"
}

function Render-LinearDiagram {
    param(
        [string]$Filename,
        [string]$Title,
        [string]$ActorName,
        [string]$ActorStep1,
        [string]$SystemStep1,
        [string]$SystemStep2,
        [string]$ActorStep2,
        [string]$SystemStep3
    )

    $width = 550
    $height = 700
    $bmp = New-Object System.Drawing.Bitmap($width, $height)
    $g = [System.Drawing.Graphics]::FromImage($bmp)
    $g.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::HighQuality
    $g.TextRenderingHint = [System.Drawing.Text.TextRenderingHint]::AntiAliasGridFit
    $g.Clear([System.Drawing.Color]::White)

    $penBlack = New-Object System.Drawing.Pen([System.Drawing.Color]::Black, 1.5)
    $penThin = New-Object System.Drawing.Pen([System.Drawing.Color]::Black, 1)
    $brushBlack = [System.Drawing.Brushes]::Black
    $brushWhite = [System.Drawing.Brushes]::White

    $fontTitle = New-Object System.Drawing.Font("Arial", 11, [System.Drawing.FontStyle]::Bold)
    $fontHeader = New-Object System.Drawing.Font("Arial", 9.5, [System.Drawing.FontStyle]::Bold)
    $fontText = New-Object System.Drawing.Font("Arial", 8.5, [System.Drawing.FontStyle]::Regular)

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

    # Swimlane Headers
    $swimHeaderY = $margin + $titleH
    $swimHeaderH = 28
    $midX = $margin + ($frameW / 2)
    $g.DrawRectangle($penThin, $margin, $swimHeaderY, $frameW, $swimHeaderH)
    $g.DrawLine($penBlack, $midX, $swimHeaderY, $midX, ($margin + $frameH))

    $rectLeftHeader = New-Object System.Drawing.RectangleF($margin, $swimHeaderY, ($frameW/2), $swimHeaderH)
    $rectRightHeader = New-Object System.Drawing.RectangleF($midX, $swimHeaderY, ($frameW/2), $swimHeaderH)
    $g.DrawString($ActorName, $fontHeader, $brushBlack, $rectLeftHeader, $sfCenter)
    $g.DrawString("System", $fontHeader, $brushBlack, $rectRightHeader, $sfCenter)

    $leftX = $margin + ($frameW / 4) # 145
    $rightX = $midX + ($frameW / 4)  # 405

    function Draw-Box($cx, $cy, $bw, $bh, $text) {
        $bx = $cx - ($bw / 2)
        $by = $cy - ($bh / 2)
        $rect = New-Object System.Drawing.RectangleF($bx, $by, $bw, $bh)
        $path = New-Object System.Drawing.Drawing2D.GraphicsPath
        $cornerR = 10
        $path.AddArc($bx, $by, $cornerR, $cornerR, 180, 90)
        $path.AddArc(($bx + $bw - $cornerR), $by, $cornerR, $cornerR, 270, 90)
        $path.AddArc(($bx + $bw - $cornerR), ($by + $bh - $cornerR), $cornerR, $cornerR, 0, 90)
        $path.AddArc($bx, ($by + $bh - $cornerR), $cornerR, $cornerR, 90, 90)
        $path.CloseFigure()

        $g.FillPath($brushWhite, $path)
        $g.DrawPath($penThin, $path)
        $g.DrawString($text, $fontText, $brushBlack, $rect, $sfCenter)
    }

    # Start Node
    $rStart = 13
    $g.FillEllipse($brushBlack, ($leftX - $rStart), (105 - $rStart), ($rStart * 2), ($rStart * 2))

    # Arrow Start -> Actor Step 1
    Draw-ArrowLine $g $penThin $brushBlack $leftX (105 + $rStart) $leftX (165 - 19)

    # Actor Step 1 Box
    Draw-Box $leftX 165 155 38 $ActorStep1

    # Arrow Actor Step 1 -> System Step 1
    Draw-ArrowLine $g $penThin $brushBlack ($leftX + 77) 165 ($rightX - 77) 165

    # System Step 1 Box
    Draw-Box $rightX 165 155 38 $SystemStep1

    # Arrow System Step 1 -> System Step 2
    Draw-ArrowLine $g $penThin $brushBlack $rightX (165 + 19) $rightX (245 - 19)

    # System Step 2 Box
    Draw-Box $rightX 245 155 38 $SystemStep2

    if ($ActorStep2) {
        # Arrow System Step 2 -> Actor Step 2
        $ptsToAct2 = @(
            (New-Object System.Drawing.PointF($rightX, (245 + 19))),
            (New-Object System.Drawing.PointF($rightX, 295)),
            (New-Object System.Drawing.PointF($leftX, 295)),
            (New-Object System.Drawing.PointF($leftX, (325 - 19)))
        )
        Draw-PolylineArrow $g $penThin $brushBlack $ptsToAct2

        # Actor Step 2 Box
        Draw-Box $leftX 325 155 38 $ActorStep2

        if ($SystemStep3) {
            # Arrow Actor Step 2 -> System Step 3
            Draw-ArrowLine $g $penThin $brushBlack ($leftX + 77) 325 ($rightX - 77) 325

            # System Step 3 Box
            Draw-Box $rightX 325 155 38 $SystemStep3

            # End Node
            $endY = 415
            Draw-ArrowLine $g $penThin $brushBlack $rightX (325 + 19) $rightX ($endY - 16)
            $rEnd1 = 15
            $rEnd2 = 9
            $g.DrawEllipse($penBlack, ($rightX - $rEnd1), ($endY - $rEnd1), ($rEnd1 * 2), ($rEnd1 * 2))
            $g.FillEllipse($brushBlack, ($rightX - $rEnd2), ($endY - $rEnd2), ($rEnd2 * 2), ($rEnd2 * 2))
        } else {
            # End Node
            $endY = 405
            Draw-ArrowLine $g $penThin $brushBlack $leftX (325 + 19) $leftX ($endY - 16)
            $rEnd1 = 15
            $rEnd2 = 9
            $g.DrawEllipse($penBlack, ($leftX - $rEnd1), ($endY - $rEnd1), ($rEnd1 * 2), ($rEnd1 * 2))
            $g.FillEllipse($brushBlack, ($leftX - $rEnd2), ($endY - $rEnd2), ($rEnd2 * 2), ($rEnd2 * 2))
        }
    } else {
        # End Node
        $endY = 325
        Draw-ArrowLine $g $penThin $brushBlack $rightX (245 + 19) $rightX ($endY - 16)
        $rEnd1 = 15
        $rEnd2 = 9
        $g.DrawEllipse($penBlack, ($rightX - $rEnd1), ($endY - $rEnd1), ($rEnd1 * 2), ($rEnd1 * 2))
        $g.FillEllipse($brushBlack, ($rightX - $rEnd2), ($endY - $rEnd2), ($rEnd2 * 2), ($rEnd2 * 2))
    }

    $filePath = Join-Path $pictureDir $Filename
    $bmp.Save($filePath, [System.Drawing.Imaging.ImageFormat]::Png)

    if (Test-Path $desktopPictureDir) {
        $desktopFilePath = Join-Path $desktopPictureDir $Filename
        $bmp.Save($desktopFilePath, [System.Drawing.Imaging.ImageFormat]::Png)
    }

    $g.Dispose()
    $bmp.Dispose()
    Write-Host "Generated linear diagram: $Filename"
}

# ------------------------------------------------------------------
# GENERATE ALL 24 DIAGRAMS
# ------------------------------------------------------------------

# 1. BAD001 Login
Render-InteractiveDiagram -Filename "bad001.png" -Title "Login" -ActorName "Customer / Staff" `
    -ActorStep1 "Login Page" -ActorStep2 "Click 'Login'" -SystemStep1 "Display Login Form" `
    -ActorStep3 "Enter Email and Password" -SystemStep2 "Check Validity" -DecisionText "Valid?" `
    -SystemSuccess "Account Authorized &`nRedirect Dashboard" -SystemNext ""

# 2. BAD002 Create Account
Render-InteractiveDiagram -Filename "bad002.png" -Title "Create Account" -ActorName "Staff / Customer" `
    -ActorStep1 "Login Page" -ActorStep2 "Click 'Sign Up'" -SystemStep1 "Prompt to registration page" `
    -ActorStep3 "Input name, email,`nphone number, password" -SystemStep2 "Check validity" -DecisionText "Valid?" `
    -SystemSuccess "Account is created" -SystemNext "Prompt to login page"

# 3. BAD003 View Account
Render-LinearDiagram -Filename "bad003.png" -Title "View Account" -ActorName "Staff / Customer" `
    -ActorStep1 "Click 'Profile' / 'Account Details'" -SystemStep1 "Query database for user profile" `
    -SystemStep2 "Fetch profile attributes & avatar" -ActorStep2 "View personal profile details" -SystemStep3 "Render profile page view"

# 4. BAD004 Update Account
Render-InteractiveDiagram -Filename "bad004.png" -Title "Update Account" -ActorName "Staff / Customer" `
    -ActorStep1 "Navigate to Profile Page" -ActorStep2 "Click 'Edit Profile'" -SystemStep1 "Display editable profile form" `
    -ActorStep3 "Modify profile fields /`nupload avatar" -SystemStep2 "Check input validity & file size" -DecisionText "Valid?" `
    -SystemSuccess "Save updated profile in DB" -SystemNext "Display success notification toast"

# 5. BAD005 Delete Account
Render-InteractiveDiagram -Filename "bad005.png" -Title "Delete Account" -ActorName "Staff / Admin" `
    -ActorStep1 "Navigate to Plumbers list" -ActorStep2 "Select Plumber & click 'Delete'" -SystemStep1 "Display plumbers list table" `
    -ActorStep3 "Confirm deletion prompt ('OK')" -SystemStep2 "Check confirmation" -DecisionText "Confirmed?" `
    -SystemSuccess "Delete staff record from DB" -SystemNext "Display success alert & refresh list"

# 6. BAD006 Create Booking
Render-InteractiveDiagram -Filename "bad006.png" -Title "Create Booking" -ActorName "Customer" `
    -ActorStep1 "Click 'Create Booking'" -ActorStep2 "Select Service & Date" -SystemStep1 "Load form & available slots" `
    -ActorStep3 "Select Time Slot & enter`nproblem description" -SystemStep2 "Check slot availability" -DecisionText "Slot Free?" `
    -SystemSuccess "Save booking as 'Pending'" -SystemNext "Redirect to deposit payment page"

# 7. BAD007 View Booking
Render-LinearDiagram -Filename "bad007.png" -Title "View Booking" -ActorName "Staff / Customer" `
    -ActorStep1 "Click 'Bookings' in sidebar menu" -SystemStep1 "Query user bookings from DB" `
    -SystemStep2 "Display bookings list table" -ActorStep2 "Select specific booking card" -SystemStep3 "Render detailed booking view"

# 8. BAD008 Update Booking
Render-InteractiveDiagram -Filename "bad008.png" -Title "Update Booking" -ActorName "Staff / Admin" `
    -ActorStep1 "Open Booking Management" -ActorStep2 "Click 'Update Status'" -SystemStep1 "Display active bookings list" `
    -ActorStep3 "Select Plumber / select status`n& click 'Save'" -SystemStep2 "Check plumber schedule overlap" -DecisionText "No Overlap?" `
    -SystemSuccess "Update booking status & plumber ID" -SystemNext "Send push notification to customer"

# 9. BAD009 Delete Booking
Render-InteractiveDiagram -Filename "bad009.png" -Title "Delete Booking" -ActorName "Customer" `
    -ActorStep1 "Select active booking" -ActorStep2 "Click 'Cancel Booking'" -SystemStep1 "Prompt cancellation page" `
    -ActorStep3 "Input cancellation reason`n& click 'Confirm'" -SystemStep2 "Check booking status eligibility" -DecisionText "Status OK?" `
    -SystemSuccess "Calculate refund (24h/48h rule)" -SystemNext "Save as Cancelled & log refund"

# 10. BAD010 Create Payment
Render-InteractiveDiagram -Filename "bad010.png" -Title "Create Payment" -ActorName "Customer" `
    -ActorStep1 "Open Deposit Payment page" -ActorStep2 "View payment details" -SystemStep1 "Display deposit amount & bank info" `
    -ActorStep3 "Upload receipt slip image`n& click 'Submit'" -SystemStep2 "Validate file format & size (<4MB)" -DecisionText "File Valid?" `
    -SystemSuccess "Save slip asset & log PaymentReceipt" -SystemNext "Set status Awaiting Verification"

# 11. BAD011 View Payment
Render-LinearDiagram -Filename "bad011.png" -Title "View Payment" -ActorName "Customer / Staff" `
    -ActorStep1 "Click 'View Slip' or 'Download PDF'" -SystemStep1 "Fetch payment record & slip image" `
    -SystemStep2 "Render slip modal / stream PDF" -ActorStep2 "View receipt details & download" -SystemStep3 "Complete process"

# 12. BAD012 Update Payment
Render-InteractiveDiagram -Filename "bad012.png" -Title "Update Payment" -ActorName "Staff / Admin" `
    -ActorStep1 "Open Payment Verification" -ActorStep2 "Inspect uploaded receipt slip" -SystemStep1 "Display pending payment queue" `
    -ActorStep3 "Select Plumber & Approve`nOR enter reason & Reject" -SystemStep2 "Verify receipt & check action" -DecisionText "Approve?" `
    -SystemSuccess "Mark Payment Paid & Booking Confirmed" -SystemNext "Generate PDF & email confirmation"

# 13. BAD013 Create Refund
Render-InteractiveDiagram -Filename "bad013.png" -Title "Create Refund" -ActorName "Staff / Admin" `
    -ActorStep1 "Cancel booking event" -ActorStep2 "Trigger refund check" -SystemStep1 "Verify deposit payment status" `
    -ActorStep3 "System verifies cancellation timing" -SystemStep2 "Check notice window (>24h)" -DecisionText "Notice >24h?" `
    -SystemSuccess "Calculate refund total (100%/50%)" -SystemNext "Create pending Refund in queue"

# 14. BAD014 View Refund
Render-LinearDiagram -Filename "bad014.png" -Title "View Refund" -ActorName "Staff / Admin" `
    -ActorStep1 "Click 'Refunds' menu tab" -SystemStep1 "Query cancelled bookings with refunds" `
    -SystemStep2 "Render refund table with bank info" -ActorStep2 "Search or filter by refund status" -SystemStep3 "Display filtered list"

# 15. BAD015 Update Refund
Render-InteractiveDiagram -Filename "bad015.png" -Title "Update Refund" -ActorName "Staff / Admin" `
    -ActorStep1 "Select pending refund record" -ActorStep2 "Execute manual online bank transfer" -SystemStep1 "Display customer bank account info" `
    -ActorStep3 "Upload bank refund slip PDF`n& click 'Complete'" -SystemStep2 "Validate slip upload file" -DecisionText "Slip Valid?" `
    -SystemSuccess "Set status Refunded & record timestamp" -SystemNext "Send confirmation email with proof slip"

# 16. BAD016 Create Job Record
Render-InteractiveDiagram -Filename "bad016.png" -Title "Create Job Record" -ActorName "Staff / Admin" `
    -ActorStep1 "Open assigned booking at site" -ActorStep2 "Click 'Create Job Record'" -SystemStep1 "Display job completion form template" `
    -ActorStep3 "Input Labor cost, Parts cost`n& work completion notes" -SystemStep2 "Validate required cost fields" -DecisionText "Fields Valid?" `
    -SystemSuccess "Calculate total job cost" -SystemNext "Save JobRecord & set booking Completed"

# 17. BAD017 View Job Record
Render-LinearDiagram -Filename "bad017.png" -Title "View Job Record" -ActorName "Staff / Customer" `
    -ActorStep1 "Click View Job Summary / Print Invoice" -SystemStep1 "Query job_records linked to booking" `
    -SystemStep2 "Render itemized invoice layout" -ActorStep2 "Inspect summary & cost breakdown" -SystemStep3 "Complete print / download"

# 18. BAD018 Update Job Record
Render-InteractiveDiagram -Filename "bad018.png" -Title "Update Job Record" -ActorName "Staff / Admin" `
    -ActorStep1 "Open Job Records list" -ActorStep2 "Click 'Edit Job Record'" -SystemStep1 "Display populated job edit form" `
    -ActorStep3 "Modify labor cost, parts cost`nor work completion notes" -SystemStep2 "Validate updated values" -DecisionText "Valid?" `
    -SystemSuccess "Recalculate total cost & update DB" -SystemNext "Display success notification toast"

# 19. BAD019 Generate Report
Render-LinearDiagram -Filename "bad019.png" -Title "Generate Report" -ActorName "Staff / Admin" `
    -ActorStep1 "Click 'Analytics' in navigation" -SystemStep1 "Display analytics dashboard" `
    -SystemStep2 "Aggregate DB transactions & ratios" -ActorStep2 "Select Calendar Year / Date range" -SystemStep3 "Render revenue bar charts & summary tables"

# 20. BAD020 Create Feedback
Render-InteractiveDiagram -Filename "bad020.png" -Title "Create Feedback" -ActorName "Customer / Staff" `
    -ActorStep1 "Open completed booking" -ActorStep2 "Click 'Submit Feedback'" -SystemStep1 "Display feedback popup modal form" `
    -ActorStep3 "Select star rating (1-5),`nenter comment & photo" -SystemStep2 "Check star rating selection" -DecisionText "Rating Selected?" `
    -SystemSuccess "Save feedback in DB linked to booking" -SystemNext "Display Thank You & alert plumber"

# 21. BAD021 View Feedback
Render-LinearDiagram -Filename "bad021.png" -Title "View Feedback" -ActorName "Customer / Admin" `
    -ActorStep1 "Click 'Feedback' menu tab" -SystemStep1 "Query feedback records & review photos" `
    -SystemStep2 "Render customer review feed" -ActorStep2 "Select feedback & optionally reply" -SystemStep3 "Save staff response comment"

# 22. BAD022 Create Chat Message
Render-InteractiveDiagram -Filename "bad022.png" -Title "Create Chat Message" -ActorName "Customer / Staff" `
    -ActorStep1 "Open active booking" -ActorStep2 "Open Live Chat widget" -SystemStep1 "Display live chat interface window" `
    -ActorStep3 "Type text message into input bar`n& click 'Send'" -SystemStep2 "Check message text non-empty" -DecisionText "Non-Empty?" `
    -SystemSuccess "Save ChatMessage in DB (is_read=false)" -SystemNext "Broadcast Pusher event to recipient"

# 23. BAD023 View Chat Messages
Render-LinearDiagram -Filename "bad023.png" -Title "View Chat Messages" -ActorName "Customer / Staff" `
    -ActorStep1 "Click Live Chat icon on booking" -SystemStep1 "Retrieve message thread for booking" `
    -SystemStep2 "Update unread messages (is_read=true)" -ActorStep2 "View message history thread" -SystemStep3 "Render conversation bubble timeline"

# 24. BAD024 View Push Notifications
Render-LinearDiagram -Filename "bad024.png" -Title "View Push Notifications" -ActorName "Staff / Customer" `
    -ActorStep1 "Click Notification Bell in header" -SystemStep1 "Fetch unread alerts for user ID" `
    -SystemStep2 "Display dropdown preview list" -ActorStep2 "Click notification item or Mark All Read" -SystemStep3 "Update read_at & reset bell badge"

Write-Host "All 24 Activity Diagram PNG images updated with requested actors!"


Write-Host "All 24 Activity Diagram PNG images generated with perfect arrows!"
