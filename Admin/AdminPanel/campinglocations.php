<?php

require_once '../DbActions/Db.conn.php';

session_start();

error_reporting(0);

date_default_timezone_set("Asia/Colombo");


// --------------------------------------------------
// LOGIN CHECK
// --------------------------------------------------

if (
    !isset($_SESSION['UserName']) ||
    !isset($_SESSION['UserId'])
) {
    header('Location: ../index.html');
    exit;
}


$n = 0;


// --------------------------------------------------
// GET BOARD CAMPING LOCATIONS
// --------------------------------------------------

$sql = "SELECT * FROM boardcampinglocations ORDER BY date DESC, time DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta name="robots" content="noindex, nofollow">

    <meta charset="UTF-8">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">

    <title>Swarna Sahana</title>


    <!-- General CSS Files -->

    <link rel="stylesheet" href="assets/css/app.min.css">


    <!-- Template CSS -->

    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" href="assets/css/components.css">


    <!-- Custom style CSS -->

    <link rel="stylesheet" href="assets/css/custom.css">

</head>


<body>

<div class="loader"></div>


<div id="app">

    <div class="main-wrapper main-wrapper-1">

        <div class="navbar-bg"></div>


        <!-- Navigation -->

        <?php require './Components/Nav.php'; ?>

        <!-- End Navigation -->


        <!-- Main Content -->

        <div class="main-content">

            <section class="section">


                <!-- =====================================================
                     DATE AND TIME CARDS
                ====================================================== -->

                <div class="row">


                    <!-- DATE -->

                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">

                        <div class="card">

                            <div class="card-statistic-4">

                                <div class="align-items-center justify-content-between">

                                    <div class="row">

                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">

                                            <div class="card-content">

                                                <h5 class="font-15">
                                                    Date
                                                </h5>

                                                <h2 class="mb-3 font-18">
                                                    <?php echo date('Y-m-d'); ?>
                                                </h2>

                                                <p class="mb-0">

                                                    <span class="col-green">
                                                        Have a good Day
                                                    </span>

                                                </p>

                                            </div>

                                        </div>


                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">

                                            <div class="banner-img">

                                                <img src="assets/img/banner/1.png" alt="">

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- TIME -->

                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-xs-12">

                        <div class="card">

                            <div class="card-statistic-4">

                                <div class="align-items-center justify-content-between">

                                    <div class="row">

                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">

                                            <div class="card-content">

                                                <h5 class="font-15">
                                                    Time
                                                </h5>

                                                <h2 class="mb-3 font-18">
                                                    <?php echo date('H:i'); ?>
                                                </h2>

                                                <p class="mb-0">

                                                    <span class="col-orange">
                                                    </span>

                                                    Time

                                                </p>

                                            </div>

                                        </div>


                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">

                                            <div class="banner-img">

                                                <img src="assets/img/banner/2.png" alt="">

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                </div>


                <!-- =====================================================
                     BOARD CAMPING TABLE
                ====================================================== -->

                <div class="row">

                    <div class="col-12">

                        <div class="card">


                            <!-- CARD HEADER -->

                            <div class="card-header d-flex justify-content-between align-items-center">

                                <h4>
                                    Board Camping Locations
                                </h4>


                                <!-- DOWNLOAD REPORT BUTTON -->

                                <button
                                    type="button"
                                    class="btn btn-primary btn-lg"
                                    data-toggle="modal"
                                    data-target="#reportDateModal"
                                >

                                    <i class="fas fa-file-pdf"></i>

                                    Download Report

                                </button>


                            </div>


                            <!-- CARD BODY -->

                            <div class="card-body">

                                <div class="table-responsive">

                                    <table
                                        class="table table-striped"
                                        id="table-1"
                                    >

                                        <thead>

                                        <tr>

                                            <th class="text-center">
                                                #
                                            </th>

                                            <th>
                                                Located User
                                            </th>

                                            <th>
                                                Date
                                            </th>

                                            <th>
                                                Time
                                            </th>

                                            <th>
                                                Count
                                            </th>

                                            <th>
                                                Riding Type
                                            </th>

                                            <th>
                                                Total Cost
                                            </th>

                                            <th>
                                                Location
                                            </th>

                                        </tr>

                                        </thead>


                                        <tbody>


                                        <?php

                                        if ($result && mysqli_num_rows($result) > 0) {

                                            while ($rows = mysqli_fetch_assoc($result)) {

                                                ?>

                                                <tr>

                                                    <!-- NUMBER -->

                                                    <td>

                                                        <?php

                                                        echo $n + 1;

                                                        ?>

                                                    </td>


                                                    <!-- USER -->

                                                    <td>

                                                        <?php

                                                        echo htmlspecialchars(
                                                            $rows['createduser'],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        );

                                                        ?>

                                                    </td>


                                                    <!-- DATE -->

                                                    <td>

                                                        <?php

                                                        echo htmlspecialchars(
                                                            $rows['date'],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        );

                                                        ?>

                                                    </td>


                                                    <!-- TIME -->

                                                    <td>

                                                        <?php

                                                        echo htmlspecialchars(
                                                            $rows['time'],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        );

                                                        ?>

                                                    </td>


                                                    <!-- COUNT -->

                                                    <td>

                                                        <?php

                                                        echo (int)$rows['count'];

                                                        ?>

                                                    </td>


                                                    <!-- RIDING TYPE -->

                                                    <td>

                                                        <?php

                                                        if ((int)$rows['ridingtype'] == 1) {

                                                            echo '<p style="color:green;font-weight:bold;margin:0;">
                                                                    By Office Bike
                                                                  </p>';

                                                        } else {

                                                            echo '<p style="color:blue;font-weight:bold;margin:0;">
                                                                    By Own Bike
                                                                  </p>';

                                                        }

                                                        ?>

                                                    </td>


                                                    <!-- TOTAL COST -->

                                                    <td>

                                                        <?php

                                                        $count = (int)$rows['count'];

                                                        $ridingType = (int)$rows['ridingtype'];


                                                        if ($ridingType == 1) {

                                                            $cost = $count * 10;

                                                        } else {

                                                            $cost = $count * 15;

                                                        }


                                                        echo "Rs " . number_format($cost, 2);

                                                        ?>

                                                    </td>


                                                    <!-- LOCATION -->

                                                    <td>

                                                        <?php

                                                        echo htmlspecialchars(
                                                            $rows['location'],
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        );

                                                        ?>

                                                    </td>

                                                </tr>

                                                <?php

                                                $n++;

                                            }

                                        } else {

                                            ?>

                                            <tr>

                                                <td colspan="8" class="text-center">

                                                    No board camping records found.

                                                </td>

                                            </tr>

                                            <?php

                                        }

                                        ?>


                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


            </section>


            <!-- =====================================================
                 SETTINGS SIDEBAR
            ====================================================== -->

            <div class="settingSidebar">

                <a href="javascript:void(0)" class="settingPanelToggle">

                    <i class="fa fa-spin fa-cog"></i>

                </a>


                <div class="settingSidebar-body ps-container ps-theme-default">

                    <div class="fade show active">


                        <div class="setting-panel-header">
                            Setting Panel
                        </div>


                        <div class="p-15 border-bottom">

                            <h6 class="font-medium m-b-10">
                                Select Layout
                            </h6>


                            <div class="selectgroup layout-color w-50">

                                <label class="selectgroup-item">

                                    <input
                                        type="radio"
                                        name="value"
                                        value="1"
                                        class="selectgroup-input-radio select-layout"
                                        checked
                                    >

                                    <span class="selectgroup-button">
                                        Light
                                    </span>

                                </label>


                                <label class="selectgroup-item">

                                    <input
                                        type="radio"
                                        name="value"
                                        value="2"
                                        class="selectgroup-input-radio select-layout"
                                    >

                                    <span class="selectgroup-button">
                                        Dark
                                    </span>

                                </label>

                            </div>

                        </div>


                        <div class="p-15 border-bottom">

                            <h6 class="font-medium m-b-10">
                                Sidebar Color
                            </h6>


                            <div class="selectgroup selectgroup-pills sidebar-color">

                                <label class="selectgroup-item">

                                    <input
                                        type="radio"
                                        name="icon-input"
                                        value="1"
                                        class="selectgroup-input select-sidebar"
                                    >

                                    <span
                                        class="selectgroup-button selectgroup-button-icon"
                                        data-toggle="tooltip"
                                        data-original-title="Light Sidebar"
                                    >

                                        <i class="fas fa-sun"></i>

                                    </span>

                                </label>


                                <label class="selectgroup-item">

                                    <input
                                        type="radio"
                                        name="icon-input"
                                        value="2"
                                        class="selectgroup-input select-sidebar"
                                        checked
                                    >

                                    <span
                                        class="selectgroup-button selectgroup-button-icon"
                                        data-toggle="tooltip"
                                        data-original-title="Dark Sidebar"
                                    >

                                        <i class="fas fa-moon"></i>

                                    </span>

                                </label>

                            </div>

                        </div>


                        <div class="p-15 border-bottom">

                            <h6 class="font-medium m-b-10">
                                Color Theme
                            </h6>


                            <div class="theme-setting-options">

                                <ul class="choose-theme list-unstyled mb-0">

                                    <li title="white" class="active">
                                        <div class="white"></div>
                                    </li>

                                    <li title="cyan">
                                        <div class="cyan"></div>
                                    </li>

                                    <li title="black">
                                        <div class="black"></div>
                                    </li>

                                    <li title="purple">
                                        <div class="purple"></div>
                                    </li>

                                    <li title="orange">
                                        <div class="orange"></div>
                                    </li>

                                    <li title="green">
                                        <div class="green"></div>
                                    </li>

                                    <li title="red">
                                        <div class="red"></div>
                                    </li>

                                </ul>

                            </div>

                        </div>


                        <div class="p-15 border-bottom">

                            <div class="theme-setting-options">

                                <label class="m-b-0">

                                    <input
                                        type="checkbox"
                                        name="custom-switch-checkbox"
                                        class="custom-switch-input"
                                        id="mini_sidebar_setting"
                                    >

                                    <span class="custom-switch-indicator"></span>

                                    <span class="control-label p-l-10">
                                        Mini Sidebar
                                    </span>

                                </label>

                            </div>

                        </div>


                        <div class="p-15 border-bottom">

                            <div class="theme-setting-options">

                                <label class="m-b-0">

                                    <input
                                        type="checkbox"
                                        name="custom-switch-checkbox"
                                        class="custom-switch-input"
                                        id="sticky_header_setting"
                                    >

                                    <span class="custom-switch-indicator"></span>

                                    <span class="control-label p-l-10">
                                        Sticky Header
                                    </span>

                                </label>

                            </div>

                        </div>


                        <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">

                            <a
                                href="#"
                                class="btn btn-icon icon-left btn-primary btn-restore-theme"
                            >

                                <i class="fas fa-undo"></i>

                                Restore Default

                            </a>

                        </div>


                    </div>

                </div>

            </div>


        </div>


        <!-- =====================================================
             FOOTER
        ====================================================== -->

        <footer class="main-footer">

            <div class="footer-left">

                <a href="#">
                    Sachin Gunasekara
                </a>

            </div>


            <div class="footer-right">
            </div>

        </footer>


    </div>

</div>


<!-- ==========================================================
     DATE RANGE MODAL
=========================================================== -->

<div
    class="modal fade"
    id="reportDateModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="reportDateModalLabel"
    aria-hidden="true"
>


    <div
        class="modal-dialog modal-dialog-centered"
        role="document"
    >


        <div class="modal-content">


            <!-- MODAL HEADER -->

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="reportDateModalLabel"
                >

                    <i class="fas fa-file-pdf"></i>

                    Download Board Camping Report

                </h5>


                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >

                    <span aria-hidden="true">
                        &times;
                    </span>

                </button>

            </div>


            <!-- FORM -->

            <form
                action="../DbActions/DailyBuisness/downloadBoardCampingReport.php"
                method="GET"
                target="_blank"
                id="reportForm"
            >


                <div class="modal-body">


                    <!-- FROM DATE -->

                    <div class="form-group">

                        <label for="from_date">

                            <strong>
                                From Date
                            </strong>

                        </label>


                        <input
                            type="date"
                            class="form-control"
                            id="from_date"
                            name="from_date"
                            required
                        >

                    </div>


                    <!-- TO DATE -->

                    <div class="form-group">

                        <label for="to_date">

                            <strong>
                                To Date
                            </strong>

                        </label>


                        <input
                            type="date"
                            class="form-control"
                            id="to_date"
                            name="to_date"
                            required
                        >

                    </div>


                    <!-- ERROR -->

                    <div
                        id="dateError"
                        class="alert alert-danger"
                        style="display:none;"
                    >

                        To Date must be greater than or equal to From Date.

                    </div>


                </div>


                <!-- MODAL FOOTER -->

                <div class="modal-footer">


                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >

                        Cancel

                    </button>


                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="downloadReportBtn"
                    >

                        <i class="fas fa-download"></i>

                        Download PDF

                    </button>


                </div>


            </form>


        </div>

    </div>

</div>


<!-- ==========================================================
     GENERAL JS
=========================================================== -->

<script src="assets/js/app.min.js"></script>


<!-- Apex Charts -->

<script src="assets/bundles/apexcharts/apexcharts.min.js"></script>


<!-- Page Specific JS -->

<script src="assets/js/page/index.js"></script>


<!-- Template JS -->

<script src="assets/js/scripts.js"></script>


<!-- Custom JS -->

<script src="assets/js/custom.js"></script>


<!-- SweetAlert -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- DataTables -->

<script src="assets/bundles/datatables/datatables.min.js"></script>

<script src="assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>

<script src="assets/bundles/jquery-ui/jquery-ui.min.js"></script>

<script src="assets/js/page/datatables.js"></script>


<!-- ==========================================================
     DATE VALIDATION
=========================================================== -->

<script>

document.addEventListener("DOMContentLoaded", function () {


    const fromDate =
        document.getElementById("from_date");


    const toDate =
        document.getElementById("to_date");


    const dateError =
        document.getElementById("dateError");


    const downloadButton =
        document.getElementById("downloadReportBtn");


    const reportForm =
        document.getElementById("reportForm");


    function validateDates() {


        if (
            fromDate.value !== "" &&
            toDate.value !== ""
        ) {


            if (
                toDate.value < fromDate.value
            ) {


                dateError.style.display = "block";

                downloadButton.disabled = true;


            } else {


                dateError.style.display = "none";

                downloadButton.disabled = false;

            }

        }

    }


    fromDate.addEventListener(
        "change",
        validateDates
    );


    toDate.addEventListener(
        "change",
        validateDates
    );


    reportForm.addEventListener(
        "submit",
        function (event) {


            if (
                fromDate.value === "" ||
                toDate.value === ""
            ) {

                event.preventDefault();

                return;

            }


            if (
                toDate.value < fromDate.value
            ) {

                event.preventDefault();

                dateError.style.display = "block";

                downloadButton.disabled = true;

                return;

            }


            downloadButton.innerHTML =
                '<i class="fas fa-spinner fa-spin"></i> Generating PDF...';


            downloadButton.disabled = true;


            // Allow the PDF to open in the new tab/window.


            setTimeout(function () {

                downloadButton.innerHTML =
                    '<i class="fas fa-download"></i> Download PDF';

                downloadButton.disabled = false;

            }, 3000);


        }
    );


});

</script>


<!-- ==========================================================
     TASK CREATED / DELETED MESSAGE
=========================================================== -->

<?php

if (
    isset($_SESSION['TaskCreated']) &&
    $_SESSION['TaskCreated'] == 1
) {

    echo '

    <script>

        Swal.fire({

            position: "top-end",

            icon: "success",

            title: "Information Deleted Successfully",

            showConfirmButton: false,

            timer: 1500

        });

    </script>

    ';


    $_SESSION['TaskCreated'] = null;

}

?>


</body>

</html>