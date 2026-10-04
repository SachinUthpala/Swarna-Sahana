<?php
require '../DbActions/Db.conn.php';;

$id = $_POST['completeId'];

$sql = "SELECT * FROM complete_task WHERE cid = $id";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Recip</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    
    <style>
        .wrapper {
            padding: 20px 25px;
            border: 2px solid rgb(255, 204, 0);
            border-radius: 10px;
        }

        .headdings {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            padding: 10px 15px;
            font-family: "Roboto", sans-serif;
        }

        .image-tab {
            padding: 10px 0px;
            display: flex;
            flex-direction: row;
            gap: 20px;
        }

        .image-tab img {
            width: 300px;
            height: 250px;
            border-radius: 10px;
        }

    </style>
</head>
<body>
    <div class="wrapper" id="section-to-pdf">
        <h3 style="color: #ffae00;text-align:center;">Swarna Sahana Holding (Pvt) LTD</h3>
        <div class="headdings">
            <div class="left">
                <p>Completed Date : <?php echo $row['compteled_date']; ?>  </p>
                <p>Customer ID : <?php echo $row['IdNumber']; ?> </p>
                <p>Amount : <?php echo 'Rs. ' . number_format($row['price'], 2, '.', ','); ?></p>
            </div>

            <div class="right">
                <p>Completed By : <?php echo $row['completedBy']; ?>  </p>
                <p>Weight : <?php echo $row['weight'] . ' g'; ?> </p>
                <p>Ref ID : <?php echo 'REF-' . $row['taskID'] . $id; ?> </p>
            </div>
        </div>

        <div class="images">
            <h4 style="color: #ffae00;text-align:center;font-family: 'Roboto', sans-serif;">Gold Item Images</h4>
            <div class="image-tab">
                <img src="<?php echo '../' . $row['jewelryImg']; ?>" alt="" <?php if (empty($row['jewelryImg'])) {
                    echo 'style="display: none;"';
                } ?>>
                <img src="<?php echo '../' . $row['jewelryImg']; ?>" alt="" <?php if (empty($row['jewelryImg'])) {
                    echo 'style="display: none;"';
                } ?>>
                <img src="<?php echo '../' . $row['jewelryImg_2']; ?>" alt="" <?php if (empty($row['jewelryImg_2'])) {
                    echo 'style="display: none;"';
                } ?>>
            </div>
        </div>

        <br><br>

        <div class="images">
            <h4 style="color: #ffae00;text-align:center;font-family: 'Roboto', sans-serif;">ID Front and Back Images</h4>
            <div class="image-tab">
                <img src="<?php echo '../' . $row['Id_image']; ?>" alt="" <?php if (empty($row['Id_image'])) {
                    echo 'style="display: none;"';
                } ?>>
                <img src="<?php echo '../' . $row['Id_image1']; ?>" alt="" <?php if (empty($row['Id_image1'])) {
                    echo 'style="display: none;"';
                } ?>>
            </div>
        </div>

        <br><br>

        <div class="images">
            <h4 style="color: #ffae00;text-align:center;font-family: 'Roboto', sans-serif;">Receipt Images</h4>
            <div class="image-tab" style="flex-direction:column;">
                <img src="<?php echo '../' . $row['receipt_img']; ?>" style="width:600px !important;height:650px !important;" alt="" <?php if (empty($row['receipt_img'])) {
                    echo 'style="display: none;"';
                } ?>>
                <img src="<?php echo '../' . $row['receipt_img1']; ?>"  <?php if (empty($row['receipt_img1'])) {
                    echo 'style="display: none;"';
                }else{ echo 'width:600px !important;height:650px !important;'; } ?>>
            </div>
        </div>

    </div>

    <br><br>
    <button onclick="downloadPDF()">Download Document</button>

    <script>
        function downloadPDF() {
            var element = document.getElementById('section-to-pdf');

            // Set up options for jsPDF
            var options = {
                margin: [10, 10, 10, 10], // Adjust margins (top, left, bottom, right)
                filename: '<?php echo "DailyReport" . date('Y-m-d') . ".pdf"; ?>', // Set filename dynamically
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
                pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
            };

            // Create the PDF with html2pdf and then apply a border to each page
            html2pdf().set(options).from(element).toPdf().get('pdf').then(function (pdf) {
                var totalPages = pdf.internal.getNumberOfPages();

                // Draw a border around each page
                for (var i = 1; i <= totalPages; i++) {
                    pdf.setPage(i);
                    pdf.setLineWidth(1); // Border width
                    pdf.setDrawColor(0, 0, 0); // Black border color
                    pdf.rect(5, 5, pdf.internal.pageSize.getWidth() - 10, pdf.internal.pageSize.getHeight() - 10); // Add border
                }
            }).save();
        }
    </script>
</body>
</html>
