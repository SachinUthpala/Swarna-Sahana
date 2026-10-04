<?php

require_once '../Db.conn.php';

session_start();

error_reporting(0);

date_default_timezone_set("Asia/Colombo");


// =====================================================
// LOGIN CHECK
// =====================================================

if (
    !isset($_SESSION['UserName']) ||
    !isset($_SESSION['UserId'])
) {
    die("Unauthorized access.");
}


// =====================================================
// GET DATES
// =====================================================

$from_date = $_GET['from_date'] ?? '';
$to_date   = $_GET['to_date'] ?? '';


// =====================================================
// VALIDATE DATES
// =====================================================

if ($from_date == '' || $to_date == '') {
    die("Please select From Date and To Date.");
}


// Check date format

$fromDate = DateTime::createFromFormat('Y-m-d', $from_date);
$toDate   = DateTime::createFromFormat('Y-m-d', $to_date);


if (!$fromDate || !$toDate) {
    die("Invalid date format.");
}


// Check date range

if ($from_date > $to_date) {
    die("To Date cannot be before From Date.");
}


// =====================================================
// DATABASE QUERY
// =====================================================

$sql = "
    SELECT
        createduser,
        date,
        time,
        count,
        ridingtype,
        location
    FROM boardcampinglocations
    WHERE DATE(date) BETWEEN ? AND ?
    ORDER BY date ASC, time ASC
";


$stmt = mysqli_prepare($conn, $sql);


if (!$stmt) {
    die("Database error: " . mysqli_error($conn));
}


// =====================================================
// BIND PARAMETERS
// =====================================================

mysqli_stmt_bind_param(
    $stmt,
    "ss",
    $from_date,
    $to_date
);


// =====================================================
// EXECUTE
// =====================================================

if (!mysqli_stmt_execute($stmt)) {
    die("Database error: " . mysqli_stmt_error($stmt));
}


// =====================================================
// GET RESULT
// =====================================================

$result = mysqli_stmt_get_result($stmt);


if (!$result) {
    die("Database result error.");
}


// =====================================================
// GET ALL DATA
// =====================================================

$records = [];

$totalCount = 0;
$totalCost  = 0;


while ($row = mysqli_fetch_assoc($result)) {

    $count = (int)$row['count'];

    $ridingType = (int)$row['ridingtype'];


    // =================================================
    // CALCULATE COST
    // =================================================

    if ($ridingType == 1) {

        $ridingText = "By Office Bike";

        $cost = $count * 10;

    } else {

        $ridingText = "By Own Bike";

        $cost = $count * 15;
    }


    $totalCount += $count;

    $totalCost += $cost;


    $records[] = [
        'createduser' => $row['createduser'],
        'date'        => $row['date'],
        'time'        => $row['time'],
        'count'       => $count,
        'ridingtype'  => $ridingText,
        'cost'        => $cost,
        'location'    => $row['location']
    ];
}


$totalRecords = count($records);


// =====================================================
// SIMPLE PDF GENERATOR
// NO FPDF
// NO COMPOSER
// NO LIBRARY
// =====================================================


// =====================================================
// PDF TEXT ESCAPE FUNCTION
// =====================================================

function pdfText($text)
{
    $text = (string)$text;

    // Remove unsupported characters first

    $text = preg_replace(
        '/[^\x20-\x7E]/',
        '',
        $text
    );

    // Escape PDF special characters

    $text = str_replace(
        ["\\", "(", ")"],
        ["\\\\", "\\(", "\\)"],
        $text
    );

    return $text;
}


// =====================================================
// CREATE PDF PAGES
// =====================================================

$pages = [];


// =====================================================
// TABLE HEADER FUNCTION
// =====================================================

function addTableHeader(&$lines)
{
    $lines[] =
        "No.   User                Date        Time      Count  Riding Type    Cost          Location";

    $lines[] =
        "--------------------------------------------------------------------------------------------------------";
}


// =====================================================
// FIRST PAGE
// =====================================================

$currentLines = [];


// =====================================================
// REPORT HEADER
// =====================================================

$currentLines[] = "SWARNA SAHANA";

$currentLines[] = "BOARD CAMPING REPORT";

$currentLines[] = "";

$currentLines[] =
    "Report Period: " .
    $from_date .
    " to " .
    $to_date;

$currentLines[] = "";


// =====================================================
// TABLE HEADER
// =====================================================

addTableHeader($currentLines);


// =====================================================
// ADD RECORDS
// =====================================================

if ($totalRecords > 0) {

    $number = 1;


    foreach ($records as $row) {


        // =============================================
        // USER
        // =============================================

        $user = trim(
            (string)$row['createduser']
        );

        $user = substr(
            $user,
            0,
            18
        );


        // =============================================
        // LOCATION
        // =============================================

        $location = trim(
            (string)$row['location']
        );

        $location = substr(
            $location,
            0,
            22
        );


        // =============================================
        // DATE
        // =============================================

        $date = substr(
            $row['date'],
            0,
            10
        );


        // =============================================
        // TIME
        // =============================================

        $time = substr(
            $row['time'],
            0,
            8
        );


        // =============================================
        // COUNT
        // =============================================

        $count = (int)$row['count'];


        // =============================================
        // RIDING TYPE
        // =============================================

        if ($row['ridingtype'] == "By Office Bike") {

            $riding = "Office Bike";

        } else {

            $riding = "Own Bike";
        }


        // =============================================
        // COST
        // =============================================

        $cost =
            "Rs " .
            number_format(
                $row['cost'],
                2
            );


        // =============================================
        // CREATE TABLE ROW
        // =============================================

        $line = sprintf(
            "%-4s  %-18s  %-10s  %-8s  %5s  %-12s  %12s  %-22s",
            $number,
            $user,
            $date,
            $time,
            $count,
            $riding,
            $cost,
            $location
        );


        $currentLines[] = $line;


        // =============================================
        // PAGE LIMIT
        // =============================================

        // Maximum data rows per page

        if (count($currentLines) >= 40) {

            $pages[] = $currentLines;

            $currentLines = [];

            // Add table header to next page

            addTableHeader($currentLines);
        }


        $number++;
    }


} else {

    $currentLines[] =
        "No records found for the selected date range.";
}


// =====================================================
// ADD REMAINING LINES
// =====================================================

if (count($currentLines) > 0) {

    $pages[] = $currentLines;
}


// =====================================================
// MAKE SURE AT LEAST ONE PAGE EXISTS
// =====================================================

if (count($pages) == 0) {

    $pages[] = [];
}


// =====================================================
// ADD SUMMARY TO LAST PAGE
// =====================================================

$lastPageIndex = count($pages) - 1;


// =====================================================
// SUMMARY
// =====================================================

$pages[$lastPageIndex][] = "";

$pages[$lastPageIndex][] =
    "--------------------------------------------------------";

$pages[$lastPageIndex][] =
    "REPORT SUMMARY";

$pages[$lastPageIndex][] =
    "Total Records : " .
    $totalRecords;

$pages[$lastPageIndex][] =
    "Total Count   : " .
    $totalCount;

$pages[$lastPageIndex][] =
    "Total Cost    : Rs " .
    number_format(
        $totalCost,
        2
    );

$pages[$lastPageIndex][] = "";

$pages[$lastPageIndex][] =
    "Generated On  : " .
    date('Y-m-d H:i:s');


// =====================================================
// CREATE PDF OBJECTS
// =====================================================

$pdfObjects = [];


// =====================================================
// PDF CATALOG
// =====================================================

$pdfObjects[] =
    "<< /Type /Catalog /Pages 2 0 R >>";


// =====================================================
// PAGE INFORMATION
// =====================================================

$pageCount = count($pages);

$pagesObjectNumber = 2;

$nextObjectNumber = 3;


// =====================================================
// RESERVE PAGE / CONTENT OBJECTS
// =====================================================

$pageObjectNumbers = [];

$contentObjectNumbers = [];


for (
    $i = 0;
    $i < $pageCount;
    $i++
) {

    $pageObjectNumbers[] =
        $nextObjectNumber++;

    $contentObjectNumbers[] =
        $nextObjectNumber++;
}


// =====================================================
// PAGES KIDS
// =====================================================

$kids = "";


foreach (
    $pageObjectNumbers
    as $pageNumber
) {

    $kids .=
        $pageNumber .
        " 0 R ";

}


$pdfObjects[$pagesObjectNumber - 1] =
    "<< /Type /Pages /Kids [" .
    $kids .
    "] /Count " .
    $pageCount .
    " >>";


// =====================================================
// FONT OBJECT NUMBER
// =====================================================

// The font object comes after all page/content objects

$fontObjectNumber = $nextObjectNumber;


// =====================================================
// CREATE PAGE CONTENT
// =====================================================

foreach (
    $pages as $pageIndex => $lines
) {


    // =================================================
    // PDF CONTENT
    // =================================================

    $content = "";


    $content .=
        "BT\n";


    // =================================================
    // DEFAULT FONT
    // =================================================

    $content .=
        "/F1 8 Tf\n";


    // =================================================
    // STARTING POSITION
    // =================================================

    // Landscape A4 = 842 x 595

    $content .=
        "35 550 Td\n";


    $lineNumber = 0;


    foreach (
        $lines as $line
    ) {


        // =============================================
        // TITLE
        // =============================================

        if ($lineNumber == 0) {

            $content .=
                "/F1 16 Tf\n";

        }


        // =============================================
        // SUBTITLE
        // =============================================

        elseif ($lineNumber == 1) {

            $content .=
                "/F1 12 Tf\n";

        }


        // =============================================
        // NORMAL TEXT
        // =============================================

        else {

            $content .=
                "/F1 8 Tf\n";
        }


        // =============================================
        // ADD TEXT
        // =============================================

        $content .=
            "(" .
            pdfText($line) .
            ") Tj\n";


        // =============================================
        // MOVE DOWN
        // =============================================

        $content .=
            "0 -14 Td\n";


        $lineNumber++;
    }


    $content .=
        "ET";


    // =================================================
    // CONTENT OBJECT
    // =================================================

    $contentObjectNumber =
        $contentObjectNumbers[$pageIndex];


    $pdfObjects[$contentObjectNumber - 1] =
        "<< /Length " .
        strlen($content) .
        " >>\n" .
        "stream\n" .
        $content .
        "\nendstream";


    // =================================================
    // PAGE OBJECT
    // =================================================

    $pageObjectNumber =
        $pageObjectNumbers[$pageIndex];


    $pdfObjects[$pageObjectNumber - 1] =
        "<< " .
        "/Type /Page " .
        "/Parent 2 0 R " .
        "/MediaBox [0 0 842 595] " .
        "/Resources << " .
        "/Font << " .
        "/F1 " .
        $fontObjectNumber .
        " 0 R" .
        " >>" .
        " >> " .
        "/Contents " .
        $contentObjectNumber .
        " 0 R " .
        ">>";
}


// =====================================================
// FONT OBJECT
// =====================================================

// Courier is a MONOSPACED font.
// This makes the table columns align correctly.

$pdfObjects[] =
    "<< " .
    "/Type /Font " .
    "/Subtype /Type1 " .
    "/BaseFont /Courier " .
    ">>";


// =====================================================
// BUILD FINAL PDF
// =====================================================

$pdf =
    "%PDF-1.4\n";


// =====================================================
// BINARY MARKER
// =====================================================

$pdf .=
    "%\xE2\xE3\xCF\xD3\n";


// =====================================================
// OBJECT OFFSETS
// =====================================================

$offsets = [];


// =====================================================
// OBJECT COUNT
// =====================================================

$objectCount =
    count($pdfObjects);


// =====================================================
// WRITE OBJECTS
// =====================================================

for (
    $i = 0;
    $i < $objectCount;
    $i++
) {

    $objectNumber =
        $i + 1;


    // Save object offset

    $offsets[$objectNumber] =
        strlen($pdf);


    // Object start

    $pdf .=
        $objectNumber .
        " 0 obj\n";


    // Object content

    $pdf .=
        $pdfObjects[$i];


    // Object end

    $pdf .=
        "\nendobj\n";
}


// =====================================================
// XREF POSITION
// =====================================================

$xrefPosition =
    strlen($pdf);


// =====================================================
// XREF
// =====================================================

$pdf .=
    "xref\n";


$pdf .=
    "0 " .
    ($objectCount + 1) .
    "\n";


$pdf .=
    "0000000000 65535 f \n";


for (
    $i = 1;
    $i <= $objectCount;
    $i++
) {

    $pdf .=
        sprintf(
            "%010d 00000 n \n",
            $offsets[$i]
        );
}


// =====================================================
// TRAILER
// =====================================================

$pdf .=
    "trailer\n";


$pdf .=
    "<< /Size " .
    ($objectCount + 1) .
    " /Root 1 0 R >>\n";


$pdf .=
    "startxref\n";


$pdf .=
    $xrefPosition .
    "\n";


$pdf .=
    "%%EOF";


// =====================================================
// CLEAR OUTPUT BUFFER
// =====================================================

while (
    ob_get_level()
) {

    ob_end_clean();
}


// =====================================================
// PDF HEADERS
// =====================================================

header(
    'Content-Type: application/pdf'
);


header(
    'Content-Disposition: attachment; filename="Board_Camping_Report_' .
    $from_date .
    '_to_' .
    $to_date .
    '.pdf"'
);


header(
    'Content-Length: ' .
    strlen($pdf)
);


header(
    'Cache-Control: private, max-age=0, must-revalidate'
);


header(
    'Pragma: public'
);


// =====================================================
// OUTPUT PDF
// =====================================================

echo $pdf;


// =====================================================
// CLOSE DATABASE
// =====================================================

mysqli_stmt_close($stmt);

mysqli_close($conn);


exit;

?>