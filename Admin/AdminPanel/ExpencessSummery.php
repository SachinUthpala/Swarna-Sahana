<?php

require_once '../DbActions/Db.conn.php';
session_start();
error_reporting(0);
date_default_timezone_set("Asia/Colombo");

if(!$_SESSION['UserName'] && !$_SESSION['UserId']){
  header('Location: ../index.html');
  exit();
}

$userId = (int)$_SESSION['UserId'];

// $specialSql = "SELECT 
//                             expencess.*, 
//                             users.UserName,
//                             SUM(expencess.amount) AS total_amount 
//                         FROM 
//                             expencess 
//                         LEFT JOIN 
//                             users 
//                         ON 
//                             expencess.user_id = users.UserId
//                             WHERE 
//                             (date >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-26'), INTERVAL 1 MONTH) AND date < DATE_FORMAT(CURDATE(), '%Y-%m-26')) AND approved_exp = 1
//                             Group By
//                             expencess.user_id,
//                             users.UserName";


// $specialSql = "SELECT 
//     user_id,
//     SUM(CAST(amount AS DECIMAL(10,2))) AS total_approved_amount,
//     COUNT(*) AS total_approved_entries
// FROM 
//     expencess
// WHERE 
//     approved_exp = 1
//     AND STR_TO_DATE(date, '%Y-%m-%d') >= DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH, '%Y-%m-25')
//     AND STR_TO_DATE(date, '%Y-%m-%d') < DATE_FORMAT(CURDATE(), '%Y-%m-25')
// GROUP BY 
//     user_id;";




$specialSql = "SELECT 
    user_id,
    SUM(CAST(amount AS DECIMAL(10,2))) AS total_approved_amount,
    COUNT(*) AS total_approved_entries
FROM 
    expencess
WHERE 
    approved_exp = 1
    AND STR_TO_DATE(date, '%Y-%m-%d') >= 
        IF(DAY(CURDATE()) >= 26, 
           DATE_FORMAT(CURDATE(), '%Y-%m-26'), 
           DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 MONTH), '%Y-%m-26'))
    AND STR_TO_DATE(date, '%Y-%m-%d') < 
        IF(DAY(CURDATE()) >= 26, 
           DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL 1 MONTH), '%Y-%m-26'), 
           DATE_FORMAT(CURDATE(), '%Y-%m-26'))
GROUP BY 
    user_id;";



$stmt = $conn->prepare($specialSql);
// $stmt->bind_param("i", $userId);

$stmt->execute();

// Get the result of the query
$result = $stmt->get_result();

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
                          
                          <th>User Name</th>
                          <th>Total Expenses</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while ($rows = $result->fetch_assoc()) { ?>
                          <tr>
                            
                            <td><?php 
                            $userID = $rows['user_id'];

                            $sql2 = "SELECT UserName FROM users WHERE UserId = ?";
                            $stmt2 = $conn->prepare($sql2);
                            $stmt2->bind_param("i", $userID);
                            
                            $stmt2->execute();
                            $result2 = $stmt2->get_result();
                            $usernamerow = $result2->fetch_assoc();
                            echo $usernamerow['UserName'];
                            ?></td>
                            <td><?php echo "Rs ." .$rows['total_approved_amount']; ?></td>
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
