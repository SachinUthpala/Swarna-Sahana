<?php

require_once '../DbActions/Db.conn.php';

session_start();

error_reporting(0);

date_default_timezone_set("Asia/Colombo");

// Check login
if (empty($_SESSION['UserName']) && empty($_SESSION['UserId'])) {
    header('Location: ../index.html');
    exit();
}

$userId = (int) $_SESSION['UserId'];

// Get expenses
$sql = "
    SELECT 
        expencess.*,
        users.UserName
    FROM expencess
    LEFT JOIN users 
        ON expencess.user_id = users.UserId
    ORDER BY expencess.date DESC
    LIMIT 50
";

$result = mysqli_query($conn, $sql);

$n = 1;

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta name="robots" content="noindex, nofollow">

    <meta charset="UTF-8">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no"
        name="viewport">

    <title>Swarna Sahana</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="assets/css/app.min.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/components.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/custom.css">

</head>


<body>

    <div class="loader"></div>


    <!--
    ============================================================
    SESSION SUCCESS MESSAGE
    ============================================================
    -->

    <?php

    if (isset($_SESSION['expencessReject']) && $_SESSION['expencessReject'] == 1) {

        echo '
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Expense Rejected Successfully",
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>
        ';

        $_SESSION['expencessReject'] = null;
    }

    ?>


    <div id="app">

        <div class="main-wrapper main-wrapper-1">

            <div class="navbar-bg"></div>


            <!-- Navigation -->
            <?php require './Components/Nav.php'; ?>
            <!-- End Navigation -->


            <!-- Main Content -->

            <div class="main-content">

                <section class="section">


                    <!--
                    ============================================================
                    DATE & TIME
                    ============================================================
                    -->

                    <div class="row">


                        <!-- Date -->

                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">

                            <div class="card">

                                <div class="card-statistic-4">

                                    <div class="align-items-center justify-content-between">

                                        <div class="row">

                                            <div class="col-lg-6 pr-0 pt-3">

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


                                            <div class="col-lg-6 pl-0">

                                                <div class="banner-img">

                                                    <img
                                                        src="assets/img/banner/1.png"
                                                        alt="Date">

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- Time -->

                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">

                            <div class="card">

                                <div class="card-statistic-4">

                                    <div class="align-items-center justify-content-between">

                                        <div class="row">

                                            <div class="col-lg-6 pr-0 pt-3">

                                                <div class="card-content">

                                                    <h5 class="font-15">
                                                        Time
                                                    </h5>

                                                    <h2 class="mb-3 font-18">
                                                        <?php echo date('H:i:s'); ?>
                                                    </h2>

                                                </div>

                                            </div>


                                            <div class="col-lg-6 pl-0">

                                                <div class="banner-img">

                                                    <img
                                                        src="assets/img/banner/2.png"
                                                        alt="Time">

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                    </div>


                    <!--
                    ============================================================
                    EXPENSES TABLE
                    ============================================================
                    -->

                    <div class="row">

                        <div class="col-12">

                            <div class="card">


                                <div class="card-header">

                                    <h4>
                                        Expenses Table
                                    </h4>

                                </div>


                                <div class="card-body">

                                    <div class="table-responsive">


                                        <table
                                            class="table table-striped"
                                            id="table-1">


                                            <thead>

                                                <tr>

                                                    <th>
                                                        Expense Type
                                                    </th>

                                                    <th>
                                                        UserName
                                                    </th>

                                                    <th>
                                                        Distance
                                                    </th>

                                                    <th>
                                                        Amount
                                                    </th>

                                                    <th>
                                                        Date
                                                    </th>

                                                    <th>
                                                        Approved
                                                    </th>

                                                    <th>
                                                        Change Approved
                                                    </th>

                                                    <th>
                                                        Reject
                                                    </th>

                                                </tr>

                                            </thead>


                                            <tbody>


                                                <?php

                                                if ($result && mysqli_num_rows($result) > 0) {

                                                    while ($rows = mysqli_fetch_assoc($result)) {

                                                        $expenseId = (int) $rows['expenxess_id'];

                                                        ?>


                                                        <tr
                                                            data-expense-id="<?php echo $expenseId; ?>">


                                                            <!-- Expense Type -->

                                                            <td>

                                                                <?php
                                                                echo htmlspecialchars(
                                                                    $rows['expencess_type']
                                                                );
                                                                ?>

                                                            </td>


                                                            <!-- Username -->

                                                            <td>

                                                                <?php
                                                                echo htmlspecialchars(
                                                                    $rows['UserName']
                                                                );
                                                                ?>

                                                            </td>


                                                            <!-- Distance -->

                                                            <td>

                                                                <?php
                                                                echo htmlspecialchars(
                                                                    $rows['distance']
                                                                );
                                                                ?>

                                                            </td>


                                                            <!-- Amount -->

                                                            <td>

                                                                <?php
                                                                echo "Rs. " .
                                                                    number_format(
                                                                        (float)$rows['amount'],
                                                                        2
                                                                    );
                                                                ?>

                                                            </td>


                                                            <!-- Date -->

                                                            <td>

                                                                <?php
                                                                echo htmlspecialchars(
                                                                    $rows['date']
                                                                );
                                                                ?>

                                                            </td>


                                                            <!-- Approved Status -->

                                                            <td class="status-cell">


                                                                <?php

                                                                if ($rows['approved_exp'] == 0) {

                                                                    echo '
                                                                    <p
                                                                        style="
                                                                        color:orange;
                                                                        font-weight:bold;
                                                                        font-size:14px;
                                                                        margin:0;
                                                                        "
                                                                    >
                                                                        Pending
                                                                    </p>
                                                                    ';

                                                                } elseif ($rows['approved_exp'] == 2) {

                                                                    echo '
                                                                    <p
                                                                        style="
                                                                        color:red;
                                                                        font-weight:bold;
                                                                        font-size:14px;
                                                                        margin:0;
                                                                        "
                                                                    >
                                                                        Rejected
                                                                    </p>
                                                                    ';

                                                                } else {

                                                                    echo '
                                                                    <p
                                                                        style="
                                                                        color:green;
                                                                        font-weight:bold;
                                                                        font-size:14px;
                                                                        margin:0;
                                                                        "
                                                                    >
                                                                        Approved
                                                                    </p>
                                                                    ';
                                                                }

                                                                ?>


                                                            </td>


                                                            <!--
                                                            ========================================================
                                                            APPROVE / REMOVE APPROVAL
                                                            ========================================================
                                                            -->

                                                            <td class="approval-action-cell">


                                                                <?php

                                                                if ($rows['approved_exp'] == 0) {

                                                                    ?>


                                                                    <!-- Approve Button -->

                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-success approveBtn"
                                                                        data-id="<?php echo $expenseId; ?>">

                                                                        Approved

                                                                    </button>


                                                                    <?php

                                                                } else {

                                                                    ?>


                                                                    <!-- Remove Approval Button -->

                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-danger removeApproveBtn"
                                                                        data-id="<?php echo $expenseId; ?>">

                                                                        Remove Approved

                                                                    </button>


                                                                    <?php

                                                                }

                                                                ?>


                                                            </td>


                                                            <!--
                                                            ========================================================
                                                            REJECT BUTTON
                                                            ========================================================
                                                            -->

                                                            <td class="reject-action-cell">


                                                                <?php

                                                                if ($rows['approved_exp'] == 0) {

                                                                    ?>


                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-danger rejectBtn"
                                                                        data-id="<?php echo $expenseId; ?>">

                                                                        Reject

                                                                    </button>


                                                                    <?php

                                                                }

                                                                ?>


                                                            </td>


                                                        </tr>


                                                        <?php

                                                        $n++;

                                                    }

                                                } else {

                                                    ?>


                                                    <tr>

                                                        <td
                                                            colspan="8"
                                                            class="text-center">

                                                            No expenses found.

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


                    <!-- Show All Expenses -->

                    <a
                        href="showAllExpencess2.php"
                        target="_blank"
                        class="btn btn-primary">

                        Show All Expenses

                    </a>


                </section>

            </div>


        </div>

    </div>


    <!--
    ============================================================
    SCRIPTS
    ============================================================
    -->


    <!-- jQuery / Bootstrap etc. -->

    <script src="assets/js/app.min.js"></script>


    <!-- SweetAlert2 -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- DataTables -->

    <script src="assets/bundles/datatables/datatables.min.js"></script>

    <script src="assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>

    <script src="assets/js/page/datatables.js"></script>


    <!-- Main scripts -->

    <script src="assets/js/scripts.js"></script>

    <script src="assets/js/custom.js"></script>


    <!--
    ============================================================
    AJAX EXPENSE MANAGEMENT
    ============================================================
    -->

    <script>

        document.addEventListener("DOMContentLoaded", function () {


            /*
            ========================================================
            APPROVE EXPENSE
            ========================================================
            */

            document.querySelectorAll(".approveBtn").forEach(function (button) {


                button.addEventListener("click", function () {


                    const expId = this.dataset.id;

                    const currentButton = this;

                    const row = currentButton.closest("tr");


                    Swal.fire({

                        title: "Are you sure?",

                        text: "Do you want to approve this expense?",

                        icon: "warning",

                        showCancelButton: true,

                        confirmButtonColor: "#28a745",

                        cancelButtonColor: "#d33",

                        confirmButtonText: "Yes, approve it!",

                        cancelButtonText: "Cancel"

                    }).then(function (result) {


                        if (!result.isConfirmed) {

                            return;

                        }


                        // Disable button

                        currentButton.disabled = true;

                        currentButton.innerHTML = "Updating...";


                        /*
                        ====================================================
                        AJAX REQUEST
                        ====================================================
                        */

                        fetch(
                            "../DbActions/expencess/changeApproval.php",
                            {

                                method: "POST",

                                headers: {

                                    "Content-Type":
                                        "application/x-www-form-urlencoded"

                                },

                                body:
                                    "expId=" +
                                    encodeURIComponent(expId) +
                                    "&approval=Approved"

                            }
                        )


                        .then(function (response) {

                            return response.json();

                        })


                        .then(function (data) {


                            if (data.success) {


                                /*
                                ============================================
                                UPDATE STATUS WITHOUT REFRESH
                                ============================================
                                */

                                row.querySelector(".status-cell").innerHTML = `

                                    <p
                                        style="
                                        color:green;
                                        font-weight:bold;
                                        font-size:14px;
                                        margin:0;
                                        "
                                    >
                                        Approved
                                    </p>

                                `;


                                /*
                                ============================================
                                CHANGE BUTTON
                                ============================================
                                */

                                row.querySelector(".approval-action-cell").innerHTML = `

                                    <button
                                        type="button"
                                        class="btn btn-danger removeApproveBtn"
                                        data-id="${expId}">

                                        Remove Approved

                                    </button>

                                `;


                                /*
                                ============================================
                                REMOVE REJECT BUTTON
                                ============================================
                                */

                                row.querySelector(".reject-action-cell").innerHTML = "";


                                /*
                                ============================================
                                SUCCESS POPUP
                                ============================================
                                */

                                Swal.fire({

                                    position: "top-end",

                                    icon: "success",

                                    title: "Expense Approved Successfully",

                                    showConfirmButton: false,

                                    timer: 1500

                                });


                                /*
                                ============================================
                                RE-INITIALIZE REMOVE BUTTON
                                ============================================
                                */

                                initializeRemoveButtons();


                            } else {


                                Swal.fire({

                                    icon: "error",

                                    title: "Error",

                                    text:
                                        data.message ||
                                        "Unable to approve expense."

                                });


                                currentButton.disabled = false;

                                currentButton.innerHTML = "Approved";

                            }


                        })


                        .catch(function (error) {


                            console.error(error);


                            Swal.fire({

                                icon: "error",

                                title: "Server Error",

                                text:
                                    "Something went wrong. Please try again."

                            });


                            currentButton.disabled = false;

                            currentButton.innerHTML = "Approved";


                        });


                    });


                });


            });


            /*
            ========================================================
            REMOVE APPROVAL
            ========================================================
            */

            function initializeRemoveButtons() {


                document.querySelectorAll(".removeApproveBtn").forEach(function (button) {


                    // Prevent duplicate event listeners

                    if (button.dataset.initialized === "1") {

                        return;

                    }


                    button.dataset.initialized = "1";


                    button.addEventListener("click", function () {


                        const expId = this.dataset.id;

                        const currentButton = this;

                        const row = currentButton.closest("tr");


                        Swal.fire({

                            title: "Are you sure?",

                            text: "Do you want to remove the approval?",

                            icon: "warning",

                            showCancelButton: true,

                            confirmButtonColor: "#d33",

                            cancelButtonColor: "#6c757d",

                            confirmButtonText: "Yes, remove it!",

                            cancelButtonText: "Cancel"

                        }).then(function (result) {


                            if (!result.isConfirmed) {

                                return;

                            }


                            currentButton.disabled = true;

                            currentButton.innerHTML = "Updating...";


                            /*
                            ================================================
                            AJAX REQUEST
                            ================================================
                            */

                            fetch(
                                "../DbActions/expencess/removeApp.php",
                                {

                                    method: "POST",

                                    headers: {

                                        "Content-Type":
                                            "application/x-www-form-urlencoded"

                                    },

                                    body:
                                        "expId=" +
                                        encodeURIComponent(expId) +
                                        "&removeapp=1"

                                }
                            )


                            .then(function (response) {

                                return response.json();

                            })


                            .then(function (data) {


                                if (data.success) {


                                    /*
                                    ========================================
                                    UPDATE STATUS
                                    ========================================
                                    */

                                    row.querySelector(".status-cell").innerHTML = `

                                        <p
                                            style="
                                            color:orange;
                                            font-weight:bold;
                                            font-size:14px;
                                            margin:0;
                                            "
                                        >
                                            Pending
                                        </p>

                                    `;


                                    /*
                                    ========================================
                                    SHOW APPROVE BUTTON
                                    ========================================
                                    */

                                    row.querySelector(".approval-action-cell").innerHTML = `

                                        <button
                                            type="button"
                                            class="btn btn-success approveBtn"
                                            data-id="${expId}">

                                            Approved

                                        </button>

                                    `;


                                    /*
                                    ========================================
                                    SHOW REJECT BUTTON
                                    ========================================
                                    */

                                    row.querySelector(".reject-action-cell").innerHTML = `

                                        <button
                                            type="button"
                                            class="btn btn-danger rejectBtn"
                                            data-id="${expId}">

                                            Reject

                                        </button>

                                    `;


                                    /*
                                    ========================================
                                    SUCCESS POPUP
                                    ========================================
                                    */

                                    Swal.fire({

                                        position: "top-end",

                                        icon: "success",

                                        title: "Approval Removed Successfully",

                                        showConfirmButton: false,

                                        timer: 1500

                                    });


                                    /*
                                    ========================================
                                    RE-INITIALIZE BUTTONS
                                    ========================================
                                    */

                                    initializeApproveButtons();

                                    initializeRejectButtons();


                                } else {


                                    Swal.fire({

                                        icon: "error",

                                        title: "Error",

                                        text:
                                            data.message ||
                                            "Unable to remove approval."

                                    });


                                    currentButton.disabled = false;

                                    currentButton.innerHTML =
                                        "Remove Approved";

                                }


                            })


                            .catch(function (error) {


                                console.error(error);


                                Swal.fire({

                                    icon: "error",

                                    title: "Server Error",

                                    text:
                                        "Something went wrong. Please try again."

                                });


                                currentButton.disabled = false;

                                currentButton.innerHTML =
                                    "Remove Approved";


                            });


                        });


                    });


                });

            }


            /*
            ========================================================
            REJECT EXPENSE
            ========================================================
            */

            function initializeRejectButtons() {


                document.querySelectorAll(".rejectBtn").forEach(function (button) {


                    if (button.dataset.initialized === "1") {

                        return;

                    }


                    button.dataset.initialized = "1";


                    button.addEventListener("click", function () {


                        const expId = this.dataset.id;

                        const currentButton = this;

                        const row = currentButton.closest("tr");


                        Swal.fire({

                            title: "Reject Expense?",

                            text: "Do you want to reject this expense?",

                            icon: "warning",

                            showCancelButton: true,

                            confirmButtonColor: "#d33",

                            cancelButtonColor: "#6c757d",

                            confirmButtonText: "Yes, reject it!",

                            cancelButtonText: "Cancel"

                        }).then(function (result) {


                            if (!result.isConfirmed) {

                                return;

                            }


                            currentButton.disabled = true;

                            currentButton.innerHTML = "Rejecting...";


                            /*
                            ================================================
                            AJAX REQUEST
                            ================================================
                            */

                            fetch(
                                "../DbActions/expencess/RejectExpencess.php",
                                {

                                    method: "POST",

                                    headers: {

                                        "Content-Type":
                                            "application/x-www-form-urlencoded"

                                    },

                                    body:
                                        "expId=" +
                                        encodeURIComponent(expId) +
                                        "&Reject=1"

                                }
                            )


                            .then(function (response) {

                                return response.json();

                            })


                            .then(function (data) {


                                if (data.success) {


                                    /*
                                    ========================================
                                    UPDATE STATUS
                                    ========================================
                                    */

                                    row.querySelector(".status-cell").innerHTML = `

                                        <p
                                            style="
                                            color:red;
                                            font-weight:bold;
                                            font-size:14px;
                                            margin:0;
                                            "
                                        >
                                            Rejected
                                        </p>

                                    `;


                                    /*
                                    ========================================
                                    REMOVE BUTTONS
                                    ========================================
                                    */

                                    row.querySelector(".approval-action-cell").innerHTML = "";

                                    row.querySelector(".reject-action-cell").innerHTML = "";


                                    /*
                                    ========================================
                                    SUCCESS POPUP
                                    ========================================
                                    */

                                    Swal.fire({

                                        position: "top-end",

                                        icon: "success",

                                        title: "Expense Rejected Successfully",

                                        showConfirmButton: false,

                                        timer: 1500

                                    });


                                } else {


                                    Swal.fire({

                                        icon: "error",

                                        title: "Error",

                                        text:
                                            data.message ||
                                            "Unable to reject expense."

                                    });


                                    currentButton.disabled = false;

                                    currentButton.innerHTML = "Reject";

                                }


                            })


                            .catch(function (error) {


                                console.error(error);


                                Swal.fire({

                                    icon: "error",

                                    title: "Server Error",

                                    text:
                                        "Something went wrong. Please try again."

                                });


                                currentButton.disabled = false;

                                currentButton.innerHTML = "Reject";


                            });


                        });


                    });


                });

            }


            /*
            ========================================================
            INITIALIZE ALL BUTTONS
            ========================================================
            */

            initializeRemoveButtons();

            initializeRejectButtons();


            /*
            ========================================================
            APPROVE BUTTONS
            ========================================================
            */

            function initializeApproveButtons() {


                document.querySelectorAll(".approveBtn").forEach(function (button) {


                    if (button.dataset.initialized === "1") {

                        return;

                    }


                    button.dataset.initialized = "1";


                    button.addEventListener("click", function () {


                        const expId = this.dataset.id;

                        const currentButton = this;

                        const row = currentButton.closest("tr");


                        Swal.fire({

                            title: "Are you sure?",

                            text: "Do you want to approve this expense?",

                            icon: "warning",

                            showCancelButton: true,

                            confirmButtonColor: "#28a745",

                            cancelButtonColor: "#d33",

                            confirmButtonText: "Yes, approve it!",

                            cancelButtonText: "Cancel"

                        }).then(function (result) {


                            if (!result.isConfirmed) {

                                return;

                            }


                            currentButton.disabled = true;

                            currentButton.innerHTML = "Updating...";


                            fetch(
                                "../DbActions/expencess/changeApproval.php",
                                {

                                    method: "POST",

                                    headers: {

                                        "Content-Type":
                                            "application/x-www-form-urlencoded"

                                    },

                                    body:
                                        "expId=" +
                                        encodeURIComponent(expId) +
                                        "&approval=Approved"

                                }
                            )


                            .then(function (response) {

                                return response.json();

                            })


                            .then(function (data) {


                                if (data.success) {


                                    row.querySelector(".status-cell").innerHTML = `

                                        <p
                                            style="
                                            color:green;
                                            font-weight:bold;
                                            font-size:14px;
                                            margin:0;
                                            "
                                        >
                                            Approved
                                        </p>

                                    `;


                                    row.querySelector(".approval-action-cell").innerHTML = `

                                        <button
                                            type="button"
                                            class="btn btn-danger removeApproveBtn"
                                            data-id="${expId}">

                                            Remove Approved

                                        </button>

                                    `;


                                    row.querySelector(".reject-action-cell").innerHTML = "";


                                    Swal.fire({

                                        position: "top-end",

                                        icon: "success",

                                        title: "Expense Approved Successfully",

                                        showConfirmButton: false,

                                        timer: 1500

                                    });


                                    initializeRemoveButtons();


                                } else {


                                    Swal.fire({

                                        icon: "error",

                                        title: "Error",

                                        text:
                                            data.message ||
                                            "Unable to approve expense."

                                    });


                                    currentButton.disabled = false;

                                    currentButton.innerHTML = "Approved";

                                }


                            })


                            .catch(function (error) {


                                console.error(error);


                                Swal.fire({

                                    icon: "error",

                                    title: "Server Error",

                                    text:
                                        "Something went wrong. Please try again."

                                });


                                currentButton.disabled = false;

                                currentButton.innerHTML = "Approved";


                            });


                        });


                    });


                });

            }


            // Start approve buttons

            initializeApproveButtons();


        });

    </script>


</body>

</html>