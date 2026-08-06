<?php

$outputPath = 'c:/Users/adibi/plumbfix/Plumbfix_Critical_Coding_FYP_Defense.docx';

$zip = new ZipArchive();
if ($zip->open($outputPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    die("Cannot open $outputPath\n");
}

// 1. [Content_Types].xml
$contentTypesXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
    <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
    <Default Extension="xml" ContentType="application/xml"/>
    <Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/>
    <Override PartName="/word/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.styles+xml"/>
</Types>';

// 2. _rels/.rels
$relsXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/>
</Relationships>';

// 3. word/_rels/document.xml.rels
$docRelsXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>
</Relationships>';

// 4. word/styles.xml
$stylesXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:styles xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
    <w:docDefaults>
        <w:rPrDefault>
            <w:rPr>
                <w:rFonts w:ascii="Calibri" w:hAnsi="Calibri" w:cs="Calibri"/>
                <w:sz w:val="22"/>
                <w:szCs w:val="22"/>
                <w:lang w:val="ms-MY"/>
            </w:rPr>
        </w:rPrDefault>
    </w:docDefaults>
    <w:style w:type="paragraph" w:styleId="Normal">
        <w:name w:val="Normal"/>
    </w:style>
    <w:style w:type="paragraph" w:styleId="Heading1">
        <w:name w:val="heading 1"/>
        <w:rPr>
            <w:b/>
            <w:color w:val="1F4E78"/>
            <w:sz w:val="32"/>
            <w:szCs w:val="32"/>
        </w:rPr>
    </w:style>
    <w:style w:type="paragraph" w:styleId="Heading2">
        <w:name w:val="heading 2"/>
        <w:rPr>
            <w:b/>
            <w:color w:val="2E75B6"/>
            <w:sz w:val="26"/>
            <w:szCs w:val="26"/>
        </w:rPr>
    </w:style>
    <w:style w:type="paragraph" w:styleId="Heading3">
        <w:name w:val="heading 3"/>
        <w:rPr>
            <w:b/>
            <w:color w:val="333333"/>
            <w:sz w:val="24"/>
            <w:szCs w:val="24"/>
        </w:rPr>
    </w:style>
</w:styles>';

// Helper XML builder
function xmlE($str) {
    return htmlspecialchars($str, ENT_QUOTES | ENT_XML1, 'UTF-8');
}

function buildTitle($text) {
    return '<w:p>
        <w:pPr><w:jc w:val="center"/><w:spacing w:before="240" w:after="120"/></w:pPr>
        <w:r><w:rPr><w:b/><w:sz w:val="40"/><w:color w:val="1B365D"/></w:rPr><w:t>' . xmlE($text) . '</w:t></w:r>
    </w:p>';
}

function buildSubtitle($text) {
    return '<w:p>
        <w:pPr><w:jc w:val="center"/><w:spacing w:before="0" w:after="360"/></w:pPr>
        <w:r><w:rPr><w:i/><w:sz w:val="24"/><w:color w:val="595959"/></w:rPr><w:t>' . xmlE($text) . '</w:t></w:r>
    </w:p>';
}

function buildH1($text) {
    return '<w:p>
        <w:pPr><w:pStyle w:val="Heading1"/><w:spacing w:before="360" w:after="120"/></w:pPr>
        <w:r><w:t>' . xmlE($text) . '</w:t></w:r>
    </w:p>';
}

function buildH2($text) {
    return '<w:p>
        <w:pPr><w:pStyle w:val="Heading2"/><w:spacing w:before="240" w:after="80"/></w:pPr>
        <w:r><w:t>' . xmlE($text) . '</w:t></w:r>
    </w:p>';
}

function buildP($text, $boldPrefix = '', $italic = false) {
    $xml = '<w:p><w:pPr><w:spacing w:after="120" w:line="276" w:lineRule="auto"/></w:pPr>';
    if ($boldPrefix) {
        $xml .= '<w:r><w:rPr><w:b/><w:color w:val="1F4E78"/></w:rPr><w:t>' . xmlE($boldPrefix) . ' </w:t></w:r>';
    }
    $xml .= '<w:r><w:rPr>';
    if ($italic) $xml .= '<w:i/>';
    $xml .= '</w:rPr><w:t>' . xmlE($text) . '</w:t></w:r></w:p>';
    return $xml;
}

function buildBullet($text, $boldPrefix = '') {
    $xml = '<w:p>
        <w:pPr>
            <w:ind w:left="400" w:hanging="240"/>
            <w:spacing w:after="80" w:line="276" w:lineRule="auto"/>
        </w:pPr>
        <w:r><w:rPr><w:b/><w:color w:val="1F4E78"/></w:rPr><w:t>• </w:t></w:r>';
    if ($boldPrefix) {
        $xml .= '<w:r><w:rPr><w:b/></w:rPr><w:t>' . xmlE($boldPrefix) . ' </w:t></w:r>';
    }
    $xml .= '<w:r><w:t>' . xmlE($text) . '</w:t></w:r></w:p>';
    return $xml;
}

function buildCodeBlock($code) {
    $lines = explode("\n", $code);
    $xml = '<w:p><w:pPr><w:pBdr><w:top w:val="single" w:sz="6" w:space="4" w:color="D9D9D9"/><w:left w:val="single" w:sz="24" w:space="12" w:color="2E75B6"/><w:bottom w:val="single" w:sz="6" w:space="4" w:color="D9D9D9"/><w:right w:val="single" w:sz="6" w:space="4" w:color="D9D9D9"/></w:pBdr><w:shd w:val="clear" w:color="auto" w:fill="F2F4F7"/><w:spacing w:before="120" w:after="120"/></w:pPr>';
    foreach ($lines as $index => $line) {
        if ($index > 0) {
            $xml .= '</w:p><w:p><w:pPr><w:pBdr><w:top w:val="none"/><w:left w:val="single" w:sz="24" w:space="12" w:color="2E75B6"/><w:bottom w:val="none"/><w:right w:val="none"/></w:pBdr><w:shd w:val="clear" w:color="auto" w:fill="F2F4F7"/><w:spacing w:after="0"/></w:pPr>';
        }
        $xml .= '<w:r><w:rPr><w:rFonts w:ascii="Consolas" w:hAnsi="Consolas"/><w:sz w:val="19"/><w:color w:val="222222"/></w:rPr><w:t xml:space="preserve">' . xmlE($line) . '</w:t></w:r>';
    }
    $xml .= '</w:p>';
    return $xml;
}

function buildTable($headers, $rows) {
    $xml = '<w:tbl>
        <w:tblPr>
            <w:tblW w:w="5000" w:type="pct"/>
            <w:tblBorders>
                <w:top w:val="single" w:sz="8" w:space="0" w:color="2E75B6"/>
                <w:bottom w:val="single" w:sz="8" w:space="0" w:color="2E75B6"/>
                <w:insideH w:val="single" w:sz="4" w:space="0" w:color="D9D9D9"/>
                <w:insideV w:val="single" w:sz="4" w:space="0" w:color="D9D9D9"/>
            </w:tblBorders>
            <w:tblCellMar>
                <w:top w:w="120" w:type="dxa"/>
                <w:bottom w:w="120" w:type="dxa"/>
                <w:left w:w="180" w:type="dxa"/>
                <w:right w:w="180" w:type="dxa"/>
            </w:tblCellMar>
        </w:tblPr>';
    
    // Header row
    $xml .= '<w:tr><w:trPr><w:tblHeader/></w:trPr>';
    foreach ($headers as $h) {
        $xml .= '<w:tc><w:tcPr><w:shd w:val="clear" w:color="auto" w:fill="1F4E78"/></w:tcPr>
            <w:p><w:pPr><w:spacing w:after="60" w:before="60"/></w:pPr>
            <w:r><w:rPr><w:b/><w:color w:val="FFFFFF"/></w:rPr><w:t>' . xmlE($h) . '</w:t></w:r></w:p></w:tc>';
    }
    $xml .= '</w:tr>';

    // Data rows
    foreach ($rows as $rIndex => $row) {
        $bgColor = ($rIndex % 2 === 0) ? 'F9FAFB' : 'FFFFFF';
        $xml .= '<w:tr>';
        foreach ($row as $cell) {
            $xml .= '<w:tc><w:tcPr><w:shd w:val="clear" w:color="auto" w:fill="' . $bgColor . '"/></w:tcPr>
                <w:p><w:pPr><w:spacing w:after="60" w:before="60" w:line="240" w:lineRule="auto"/></w:pPr>
                <w:r><w:t>' . xmlE($cell) . '</w:t></w:r></w:p></w:tc>';
        }
        $xml .= '</w:tr>';
    }
    $xml .= '</w:tbl><w:p><w:pPr><w:spacing w:after="180"/></w:pPr></w:p>';
    return $xml;
}

// 5. Build Document Body XML
$docXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
<w:body>';

$docXml .= buildTitle('PLUMBFIX FYP DEFENSE: PERSAIPAN KOD KRITIKAL');
$docXml .= buildSubtitle('Panduan Penjelasan Coding Komprehensif untuk Sesi Viva / Pembentangan Projek (Examiner Review)');

// Intro
$docXml .= buildP('Dokumen ini menyediakan maklumat dan penerangan terperinci mengenai 3 modul paling kritikal dalam Sistem Pengurusan Perkhidmatan Plumbfix. Maklumat ini dirangka khusus untuk membantu anda menjawab soalan penilai (examiner) dengan jelas, tepat, dan berkeyakinan tinggi.');

// Section 1
$docXml .= buildH1('1. Modul Tempahan & Slot Masa (Schedule & Book Slot Logic)');
$docXml .= buildP('Modul ini mengendalikan urusan pemilihan tarikh, masa, serta mengelakkan isu pertindihan slot perkhidmatan.');
$docXml .= buildBullet('app/Http/Controllers/Customer/CustomerController.php (Fungsi bookingStore & getBookedSlots)', 'Lokasi Kod:');
$docXml .= buildBullet('app/Models/Booking.php', 'Model Terlibat:');

$docXml .= buildH2('Peraturan & Logik Kod Utama:');
$docXml .= buildBullet('Sistem menyemak akaun pelanggan. Jika No. Telefon, Alamat, Nama Bank, atau No. Akaun Bank masih kosong, sistem akan mengarahkan pelanggan melengkapkan profil terlebih dahulu bagi memudahkan urusan perkhidmatan dan tuntutan refund.', '1. Semakan Profil Lengkap (Profile Dependency):');
$docXml .= buildBullet('Slot masa dikawal secara dinamik mengikut hari. Hari Jumaat ditetapkan 3 slot sahaja (08:00, 10:00, 15:00) bagi menghormati waktu Solat Jumaat. Hari biasa (Isnin-Khamis & Hujung Minggu) mempunyai 5 slot (08:00, 10:00, 12:00, 14:00, 16:00).', '2. Peruntukan Slot Mengikut Hari (Day-Based Slot Allocation):');
$docXml .= buildBullet('Menggunakan perpustakaan Carbon (Timezone Asia/Kuala_Lumpur). Tempahan mestilah sekurang-kurangnya 12 jam awal daripada masa perkhidmatan yang dipilih ($bookingDateTime->lt($now->copy()->addHours(12))). Ini menghalang tempahan mengejut (last-minute emergency).', '3. Syarat Masa Notis Minimum 12 Jam (12-Hour Lead Time):');
$docXml .= buildBullet('Sebelum rekod disimpan, query dipanggil: Booking::where(\'bookingDate\', $date)->where(\'bookingTime\', $time)->whereNotIn(\'bookingStatus\', [\'cancelled\'])->exists(). Jika slot sudah diambil oleh pelanggan lain, sistem akan memulakan proses rollback dan memaparkan ralat.', '4. Pencegahan Double Booking (Conflict Check):');
$docXml .= buildBullet('Fungsi getBookedSlots(Request $request) dipanggil secara AJAX semasa pelanggan memilih tarikh pada kalendar untuk meletakkan status disabled pada slot yang telah berpunya.', '5. Tapisan Real-Time (AJAX Slot Filtering):');

$docXml .= buildH2('Potongan Kod Contoh (Snippet):');
$docXml .= buildCodeBlock('// Enforce 12-hour minimum lead time restriction
$bookingDateTime = Carbon::parse($date . \' \' . $request->bookingTime, \'Asia/Kuala_Lumpur\');
if ($bookingDateTime->lt(now(\'Asia/Kuala_Lumpur\')->addHours(12))) {
    return back()->withErrors([\'bookingTime\' => \'Bookings must be made at least 12 hours in advance.\']);
}

// Check slot conflict
$conflict = Booking::where(\'bookingDate\', $date)
    ->where(\'bookingTime\', $request->bookingTime)
    ->whereNotIn(\'bookingStatus\', [\'cancelled\'])
    ->exists();');


// Section 2
$docXml .= buildH1('2. Modul Pembayaran & Pengesahan (Payment & Verification Logic)');
$docXml .= buildP('Modul ini mengendalikan proses muat naik bukti pembayaran deposit oleh pelanggan dan pengesahan oleh pihak pengurusan/plumber.');
$docXml .= buildBullet('app/Http/Controllers/Customer/PaymentController.php (uploadReceipt, downloadReceipt)', 'Lokasi Kod Pelanggan:');
$docXml .= buildBullet('app/Http/Controllers/Staff/PaymentVerificationController.php (approve, reject)', 'Lokasi Kod Staff:');
$docXml .= buildBullet('app/Services/InventoryService.php (deductIngredients)', 'Servis Terlibat:');

$docXml .= buildH2('Peraturan & Logik Kod Utama:');
$docXml .= buildBullet('Pelanggan memuat naik resit pembayaran (JPEG, PNG, JPG, PDF max 5MB). Pelanggan wajib menanda pilihan bersetuju dengan Syarat & Terma Pembatalan. Rekod pembayaran baharu dimasukkan ke jadual payment_receipts dan status booking dikemas kini ke Awaiting Verification.', '1. Muat Naik Bukti Bayaran Deposit:');
$docXml .= buildBullet('Apabila staff menekan butang Approve, akaun plumber ditugaskan. Status pembayaran dikemas kini ke Paid dan status tempahan bertukar ke in_progress.', '2. Proses Kelulusan Staff (Approval Workflow):');
$docXml .= buildBullet('Sebaik sahaja bayaran disahkan, sistem memanggil InventoryService::deductIngredients($booking) untuk menolak stok barang/peralatan paip yang diperlukan secara automatik.', '3. Penolakan Stok Inventori Automatik:');
$docXml .= buildBullet('Sistem menggunakan barryvdh/laravel-dompdf untuk menjana resit rasmi PDF secara dinamik (pdf.receipt) dan melampirkan fail tersebut terus ke emel pelanggan menerusi Laravel Mailer.', '4. Penjana Resit PDF & Penghantaran Emel:');
$docXml .= buildBullet('Jika resit tidak sah/kabur, staff memasukkan rejection_reason. Status bayaran bertukar ke Rejected dan notifikasi dihantar kepada pelanggan.', '5. Penolakan Resit (Rejection Flow):');

$docXml .= buildH2('Potongan Kod Contoh (Snippet):');
$docXml .= buildCodeBlock('public function approve(Request $request, $bookingID) {
    $booking = Booking::with(\'customer\')->findOrFail($bookingID);
    $booking->bookingStatus        = \'in_progress\';
    $booking->paymentStatus        = \'Paid\';
    $booking->paymentApprovedAt    = Carbon::now(\'Asia/Kuala_Lumpur\');
    $booking->approvedBy           = $staff->staffID;

    // Deduct Inventory automatically
    InventoryService::deductIngredients($booking);
    $booking->save();

    // Generate PDF & Send Email
    $pdf = Pdf::loadView(\'pdf.receipt\', compact(\'booking\'));
    Mail::to($customer->customerEmail)->send(new ActivityNotificationMail(..., $pdf->output()));
}');


// Section 3
$docXml .= buildH1('3. Modul Pembatalan & Polisi Pemulangan Wang (Cancellation & Refund Logic)');
$docXml .= buildP('Modul ini mengendalikan proses pembatalan tempahan dan pengiraan kelayakan pulangan deposit mengikut polisi bertingkat.');
$docXml .= buildBullet('app/Models/Booking.php (Fungsi calculateRefundEligibility)', 'Lokasi Polisi Pengiraan:');
$docXml .= buildBullet('app/Http/Controllers/Customer/CustomerController.php (Fungsi bookingDelete)', 'Lokasi Pembatalan Customer:');
$docXml .= buildBullet('app/Http/Controllers/Staff/RefundController.php (Fungsi markAsRefunded)', 'Lokasi Pemprosesan Staff:');

$docXml .= buildH2('Formula Polisi Refund (Tiered Refund Policy):');
$docXml .= buildBullet('Jika tempahan dibatalkan dalam masa 30 minit selepas dibuat -> Pulangan 100% (RM 50.00).', 'Tier 1 - Grace Period (30 Minit Pertama):');
$docXml .= buildBullet('Jika pembatalan dibuat 48 jam atau lebih sebelum tarikh perkhidmatan -> Pulangan 100% (RM 50.00).', 'Tier 2 - Notis 48 Jam atau Lebih:');
$docXml .= buildBullet('Jika pembatalan dibuat antara 24 jam hingga 48 jam sebelum servis -> Pulangan Separa (RM 50.00 - RM 3.00 caj admin/gateway = RM 47.00).', 'Tier 3 - Notis 24 Jam hingga 48 Jam:');
$docXml .= buildBullet('Jika pembatalan dibuat kurang daripada 24 jam sebelum tarikh servis -> Tiada pulangan wang (RM 0.00 / Non-refundable).', 'Tier 4 - Notis Kurang 24 Jam:');
$docXml .= buildBullet('Jika status bayaran deposit masih belum Paid (cth: Pending/Rejected), akaun automatik tidak layak mendapat refund.', 'Syarat Asas:');

$docXml .= buildH2('Potongan Kod Contoh (Snippet):');
$docXml .= buildCodeBlock('public function calculateRefundEligibility(): array {
    $createdAt = $this->created_at;
    $bookingDateTime = Carbon::parse($dateStr . \' \' . $this->bookingTime);
    $now = now();

    if ($this->paymentStatus !== \'Paid\') {
        return [\'eligible\' => false, \'amount\' => 0.00, \'reason\' => \'Deposit payment not paid.\'];
    }
    if ($now->diffInMinutes($createdAt) <= 30) {
        return [\'eligible\' => true, \'amount\' => $this->bookingDepositAmount, \'reason\' => \'Grace Period.\'];
    }
    $hoursToService = $now->diffInHours($bookingDateTime, false);
    if ($hoursToService >= 48) {
        return [\'eligible\' => true, \'amount\' => $this->bookingDepositAmount];
    } elseif ($hoursToService >= 24) {
        return [\'eligible\' => true, \'amount\' => $this->bookingDepositAmount - 3.00];
    }
    return [\'eligible\' => false, \'amount\' => 0.00];
}');


// Section 4: Table of Q&A
$docXml .= buildH1('4. Panduan Soalan & Jawapan Lisan (Examiner Viva Q&A)');
$docXml .= buildP('Berikut adalah senarai soalan yang kerap ditanya oleh penilai beserta jawapan bernilai tinggi:');

$headers = ['Soalan Kemungkinan Examiner', 'Jawapan Penuh & Penjelasan Teknikal'];
$rows = [
    [
        'Bagaimanakah sistem mengelakkan dua pelanggan memilih slot tarikh dan masa yang sama (double booking)?',
        'Sistem mempunyai 2 peringkat perlindungan. Pertama di bahagian antaramuka (Frontend), fungsi AJAX getBookedSlots dipanggil untuk disable slot pilihan. Kedua di bahagian Backend (CustomerController), validation query mengecek sama ada wujud rekod aktif pada tarikh dan masa tersebut sebelum transaksi disimpan.'
    ],
    [
        'Mengapakah logik pengiraan kelayakan refund diletakkan di dalam Model Booking.php dan bukannya dalam Controller?',
        'Ini dipanggil prinsip Fat Model, Thin Controller. Memindahkan logik perniagaan (business logic) seperti calculateRefundEligibility() ke dalam Model membolehkan kod tersebut dikemas rapi, diselenggara dengan mudah, dan boleh diguna semula (reusable) di pelbagai Controller tanpa pengulangan kod (DRY principle).'
    ],
    [
        'Bagaimanakah inventori/stok barang dikemaskini apabila bayaran disahkan?',
        'Apabila staff meluluskan bayaran deposit di PaymentVerificationController, sistem secara automatik memanggil InventoryService::deductIngredients($booking). Servis ini menyemak jenis perkhidmatan tempahan dan menolak kuantiti alatan/bahan paip dalam pangkalan data secara automatik.'
    ],
    [
        'Bagaimana sistem menjana resit dan menghantar dokumen PDF kepada pelanggan?',
        'Sistem menggunakan package barryvdh/laravel-dompdf. View Blade pdf.receipt direka bentuk dengan CSS bercetak. Apabila kelulusan dibuat, controller menjana output stream PDF lalu dihantar sebagai lampiran emel menerusi Laravel Mail (ActivityNotificationMail).'
    ],
    [
        'Apakah yang berlaku jika pelanggan membatalkan tempahan kurang daripada 24 jam?',
        'Fungsi calculateRefundEligibility() akan mengembalikan refund_amount = 0.00 dan eligible = false. Status refund pada tempahan direkodkan sebagai not_applicable dan deposit RM50 tidak dipulangkan mengikut polisi pembatalan.'
    ]
];

$docXml .= buildTable($headers, $rows);

$docXml .= '</w:body></w:document>';

// Add files to ZipArchive
$zip->addFromString('[Content_Types].xml', $contentTypesXml);
$zip->addFromString('_rels/.rels', $relsXml);
$zip->addFromString('word/_rels/document.xml.rels', $docRelsXml);
$zip->addFromString('word/styles.xml', $stylesXml);
$zip->addFromString('word/document.xml', $docXml);

$zip->close();

echo "Document generated successfully at: $outputPath\n";
