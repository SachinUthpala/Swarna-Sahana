<?php

require_once '../DbActions/Db.conn.php';
session_start();
error_reporting(0);
date_default_timezone_set("Asia/Colombo");

if (!$_SESSION['UserName'] && !$_SESSION['UserId']) {
  header('Location: ../index.html');
  exit();
}

$userId = (int)$_SESSION['UserId'];

$sql = "
SELECT 
    complete_task.*, 
    task.* 
FROM 
    complete_task 
LEFT JOIN 
    task 
ON 
    complete_task.taskID = task.task_id ORDER BY complete_task.compteled_date DESC";

$result = mysqli_query($conn, $sql);

$n = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
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
      

      <!-- navigation -->
      <?php require './Components/Nav.php'; ?>
      <!-- end of navigation -->

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="row">
            <!-- Date & Time Cards -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Date</h5>
                          <h2 class="mb-3 font-18"><?php echo date('Y-m-d'); ?></h2>
                          <p class="mb-0"><span class="col-green">Have a good Day</span></p>
                        </div>
                      </div>
                      <div class="col-lg-6 pl-0">
                        <div class="banner-img">
                          <img src="assets/img/banner/1.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Time</h5>
                          <h2 class="mb-3 font-18"><?php echo date('H:i:s'); ?></h2>
                        </div>
                      </div>
                      <div class="col-lg-6 pl-0">
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

          <!-- Expenses Table -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Expenses Table</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                      <thead>
                        <tr>
                          <th>Inquiry Number</th>
                          <th>customer Name/th>
                          <th>date</th>
                          <th>completed date</th>
                          <th>Completed By</th>
                          <th>Price</th>
                          <th>Commitions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while ($rows = $result->fetch_assoc()) { ?>
                          <tr>
                            <td><?php echo $rows['inqueryNumber']; ?></td>
                            <td><?php echo $rows['customerName']; ?></td>
                            <td><?php echo $rows['date']; ?></td>
                            <td><?php echo $rows['compteled_date']; ?></td>
                            <td><?php echo $rows['completedBy']; ?></td>
                            <td><?php echo "Rs ." . $rows['price'] . ".00"; ?></td>
                            <td><?php echo "Rs ." . $rows['commition'] . ".00"; ?></td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </section>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="assets/js/app.min.js"></script>
  <script src="assets/bundles/datatables/datatables.min.js"></script>
  <script src="assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/js/page/datatables.js"></script>
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>

</body>

</html>