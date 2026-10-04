<?php


require_once '../DbActions/Db.conn.php';
session_start();
error_reporting(0);
date_default_timezone_set("Asia/Colombo");

if(!$_SESSION['UserName'] && !$_SESSION['UserId']){
  header('Location: ../index.html');
}

$userNames = $_SESSION['UserName'];

$userId = (int)$_SESSION['UserId'];

$stmt = $conn->prepare("SELECT * FROM `task` WHERE `select_user` = ?");
$stmt->bind_param("i", $userId); // 'i' denotes the type integer for $userId

$stmt->execute();

// Get the result of the query
$result = $stmt->get_result();

// Fetch the number of rows


$TotalUsers = "SELECT * FROM users";
$result_total = $conn->query($TotalUsers);
$AllUsers = $result_total->num_rows ; 

$sql_admin = "SELECT * FROM users WHERE `AdminAccess` = 1";
$result_admin = $conn->query($sql_admin);
$adminUsers = $result_admin->num_rows ; 

$sql_nonAdmin = "SELECT * FROM users WHERE `AdminAccess` = 1";
$result_nonAdmin = $conn->query($sql_nonAdmin);
$nonadminUsers = $result_nonAdmin->num_rows ; 


$TotalTask = "SELECT * FROM task";
$result_total = $conn->query($TotalTask);
$AllTasks = $result_total->num_rows ; 

$sql_onGoing = "SELECT * FROM task WHERE `completion` = 0";
$result_ongoing = $conn->query($sql_onGoing);
$allOngoing = $result_ongoing->num_rows ; 

$sql_completed = "SELECT * FROM task WHERE `completion` = 2";
$result_completed = $conn->query($sql_completed);
$allCompleted = $result_completed->num_rows ; 


$sql_expencess = "SELECT * FROM expencess WHERE `user_id` = '$userId'";
$result_expencess = $conn->query($sql_expencess);
$allexpencess = $result_expencess->num_rows ; 

?>

<!DOCTYPE html>
<html lang="en">


<!-- index.html  21 Nov 2019 03:44:50 GMT -->
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
  <!-- Toastify CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">


<style>
    /* Custom class for 8 columns per row on large screens */
    @media (min-width: 1200px) {
      .col-xl-1-5 {
        flex: 0 0 12.5%;
        max-width: 12.5%;
      }
    }

  
  </style>


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

        <!-- only admin rows -->
         <h4
         <?php
          if( $_SESSION['AdminAccess'] == 1) {
            echo 'style="display:block;"';
          }else{
            echo 'style="display:none;"';
          }
          ?>
         >Daily Buisness</h4>

         <div class="row" <?php if($_SESSION['AdminAccess'] != 1) { echo 'style="display:none;"'; } ?>>
            <?php
                $sql3 = "SELECT * FROM dailybuisness WHERE WEEK(date) = WEEK(CURDATE()) AND YEAR(date) = YEAR(CURDATE())";
                $result3 = mysqli_query($conn , $sql3);
                $totalProfit2 = 0.00;

                while($rows3 = $result3-> fetch_assoc()){
                    $rowProfit2  = $rows3['sellingPrice'] - $rows3['buyingPrice'] ; 
                    $totalProfit2 = $totalProfit2 + $rowProfit2 ;
                } 
            ?>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Current Week</h5>
                          <h2 class="mb-3 font-18"><?php 
                                if($totalProfit2 > 0){
                                    echo '<span style= "color:green;">Rs.'.$totalProfit2.'.00</span>';
                                } else {
                                    echo '<span style= "color:red;">Rs.'.$totalProfit2.'.00</span>';
                                }
                          ?></h2>
                          <p class="mb-0"><span class="col-orange">
                          
                          </span>Total Current Week Profit</p>
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

            <?php
                $sql4 = "SELECT * FROM dailybuisness WHERE (date >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-25'), INTERVAL 1 MONTH) AND date < DATE_FORMAT(CURDATE(), '%Y-%m-25'))";
                $result4 = mysqli_query($conn , $sql4);
                $totalProfit3 = 0.00;

                while($rows4 = $result4-> fetch_assoc()){
                    $rowProfit3  = $rows4['sellingPrice'] - $rows4['buyingPrice'] ; 
                    $totalProfit3 = $totalProfit3 + $rowProfit3 ;
                } 
            ?>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12" onclick="location.href='./MonthlyReport.php'">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Current Month</h5>
                          <h2 class="mb-3 font-18"><?php 
                                if($totalProfit3 > 0){
                                    echo '<span style= "color:green;">Rs.'.$totalProfit3.'.00</span>';
                                } else {
                                    echo '<span style= "color:red;">Rs.'.$totalProfit3.'.00</span>';
                                }
                          ?></h2>
                          <p class="mb-0"><span class="col-orange">
                          
                          </span>Total Current Month Profit</p>
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

            <?php
                $sql5 = "SELECT * FROM dailybuisness WHERE date = (CURDATE()-1)";
                $result5 = mysqli_query($conn , $sql5);
                $totalProfit5 = 0.00;

                while($rows5 = $result5-> fetch_assoc()){
                    $rowProfit5  = $rows5['sellingPrice'] - $rows5['buyingPrice'] ; 
                    $totalProfit5 = $totalProfit5 + $rowProfit5 ;
                } 
            ?>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12"  onclick="location.href='./DailyReport.php'">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Yeaster Day</h5>
                          <h2 class="mb-3 font-18"><?php 
                                if($totalProfit5 > 0){
                                    echo '<span style= "color:green;">Rs.'.$totalProfit5.'.00</span>';
                                } else {
                                    echo '<span style= "color:red;">Rs.'.$totalProfit5.'.00</span>';
                                }
                          ?></h2>
                          <p class="mb-0"><span class="col-orange">
                          
                          </span>Total Yearster Day Profit</p>
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
        
          <h4 <?php if($_SESSION['AdminAccess'] == 1 || $_SESSION['AdminAccess'] == 2) { echo 'style="display:block;"'; } else {echo 'style="display:none;"';} ?> >Daily Gold Price</h4>

          <div class="row" >
            <br>
          <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12" <?php if($_SESSION['AdminAccess'] != 1) { echo 'style="display:none;"'; } ?> style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#addGoldModal" >
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Add Gold Types</h5>
                          <h2 class="mb-3 font-18 text-success">+ Add Codes</h2>
                          <p class="mb-0"><span class="col-orange">
                          
                          </span>Add Gold Types & Codes</p>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="../images/goldBar-removebg-preview.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12" <?php if($_SESSION['AdminAccess'] != 1) { echo 'style="display:none;"'; } ?> style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#addGoldPriceModal" >
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Update Today Price</h5>
                          <h2 class="mb-3 font-18 text-success">Update Price</h2>
                          <p class="mb-0"><span class="col-orange">
                          
                          </span>Update 24K Gold Price</p>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="../images/Money-removebg-preview.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12" <?php if($_SESSION['AdminAccess'] == 1 || $_SESSION['AdminAccess'] == 2) { echo 'style="display:block;"'; } else{echo 'style="display:none;"'; } ?> style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#goldCalculatorModal" >
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Gold Calculator</h5>
                          <h2 class="mb-3 font-18 text-success">Calculaor</h2>
                          <p class="mb-0"><span class="col-orange">
                          
                          </span>Enter Code and Weight</p>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="../images/cal-removebg-preview.png" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <h6   >Today Gold Price 24K</h6>
          <br>

          <div class="row">
          <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Today 24K Gold Price</h5>
                          <h2 class="mb-3 font-18">
                            <?php 

                                $sql44 = "SELECT * FROM goldprice ORDER BY createdDate DESC LIMIT 1";
                                $result_44 = mysqli_query($conn, $sql44);

                                if ($result_44 && $priceRow = $result_44->fetch_assoc()) {
                                    $price = (float) $priceRow['price']; // Convert safely to float
                                    echo 'Rs. ' . number_format($price, 0) . ' /=';
                                } else {
                                    echo 'No price data available.';
                                }

                            ?>
                          </h2>
                          <p class="mb-0"><span class="col-green">24K</span> Gold Price</p>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="../images/goldBar-removebg-preview.png" width="100px" alt="">
                          <p class="mb-0"><span class="col-green">Latest Update : </span> <?php echo $priceRow['createdDate']; ?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <br>

          <h6 <?php if($_SESSION['AdminAccess'] != 1) { echo 'style="display:none;"'; } ?>  >Avilable Codes</h6>
          <div class="row text-center" <?php if($_SESSION['AdminAccess'] != 1) { echo 'style="display:none;"'; } ?>  >
            <?php
            
            $sql223 = "SELECT * FROM goldtype";
            $sqlix_results_types = mysqli_query($conn , $sql223);
            
            while($type_row = $sqlix_results_types->fetch_assoc()){

            ?>
            <!-- Repeat this card 8 times with different values -->
            <div class="col-xl-1-5 col-lg-3 col-md-3 col-sm-6 col-6 mb-4" >
              <div class="card p-3 shadow-sm" style="border-bottom: 2px solid rgb(255, 84, 5) !important;">
                <h5 class="font-14" style="color: #0c0d57 !important;"><?php echo $type_row['code'].' = '.$type_row['carrots']; ?></h5>
              </div>
            </div>

            <?php 
            }
            ?>


          </div>

          

          <!-- new update -->

     

     <h4 <?php if($_SESSION['AdminAccess'] != 1) { echo 'style="display:none;"'; } ?> >Users Summery</h4>

        <div class="row"
        <?php
                if($_SESSION['AdminAccess'] == 2 || $_SESSION['AdminAccess'] == 0) {
                  echo 'style="display:none;"';
                }
              ?>
        >
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">All Users</h5>
                          <h2 class="mb-3 font-18"><?php echo $AllUsers; ?></h2>
                          <p class="mb-0"><span class="col-green">100%</span> From Total Users</p>
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

            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15"> Admin Users</h5>
                          <h2 class="mb-3 font-18"><?php echo $adminUsers; ?></h2>
                          <p class="mb-0"><span class="col-orange">
                          <?php
                            $adminP = $adminUsers/$AllUsers*100;
                            echo $adminP.'%';
                            // echo $adminUsers;
                            // echo $AllUsers;
                          ?>
                          </span> From Total Users</p>
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

            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Non Admin Users</h5>
                          <h2 class="mb-3 font-18"><?php echo $nonadminUsers;   ?></h2>
                          <p class="mb-0"><span class="col-green">
                          <?php
                            $normalP = $nonadminUsers/$AllUsers*100;
                            echo $normalP.'%';
                          ?>
                          </span>
                          From Total Users</p>
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

            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">All Tasks</h5>
                          <h2 class="mb-3 font-18"><?php echo $AllTasks; ?></h2>
                          <p class="mb-0"><span class="col-green">100%</span> Total Tasks</p>
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

          </div>
          
          <div class="row "
            <?php
                  if($_SESSION['AdminAccess'] == 2 || $_SESSION['AdminAccess'] == 0) {
                    echo 'style="display:none;"';
                  }
                ?>
            >

              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-6">
                <div class="card">
                  <div class="card-header">
                    <h4>System User's Chart</h4>
                  </div>
                  <div class="card-body">
                    <div class="recent-report__chart">
                      <div id="gaugeChart"></div>
                    </div>
                  </div>
                </div>
              </div>
            

            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15"> All Completed Task</h5>
                          <h2 class="mb-3 font-18"><?php echo $allCompleted; ?></h2>
                          <p class="mb-0"><span class="col-orange">
                          <?php
                            $adminP = $allCompleted/$AllTasks*100;
                            echo (int)$adminP.'%';
                            // echo $adminUsers;
                            // echo $AllUsers;
                          ?>
                          </span> From Total Users</p>
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

            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">All On Going Task</h5>
                          <h2 class="mb-3 font-18"><?php echo $allOngoing;   ?></h2>
                          <p class="mb-0"><span class="col-green">
                          <?php
                            $normalP = $allOngoing/$AllTasks*100;
                            echo (int)$normalP.'%';
                          ?>
                          </span>
                          From Total Users</p>
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

          <div class="row"
            <?php
            if( $_SESSION['AdminAccess'] == 1) {
              echo 'style="display:none;"';
            }
            ?>
          >

              <div class="col-12"
                  <?php
                    if( $_SESSION['AdminAccess'] == 1) {
                      echo 'style="display:none;"';
                    }
                    ?>
              >
                <div class="card">
                  <div class="card-header">
                    <h4>MY TASKS</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                        <tr>
                            <th>Inquery Number</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Customer Name</th>
                            <th>Pnone</th>
                            <th>Bank/Shop</th>
                            <th>City</th>
                            <th>Price</th>
                            <th>Location</th>
                            <th>Completion</th>
                            <th>Complete Now</th>
     
                          </tr>
                        </thead>
                        <tbody>

                        <?php while($rows = $result-> fetch_assoc()){ ?>
                          <tr>
                           
                            <td><?php echo $rows['inqueryNumber']; ?></td>
                            <td><?php echo $rows['date']; ?></td>
                            <td><?php echo $rows['time']; ?></td>
                            <td><?php echo $rows['customerName']; ?></td>
                            <td><?php echo $rows['Phone']; ?></td>
                            <td><?php echo $rows['bank_shop']; ?></td>
                            <td><?php echo $rows['city']; ?></td>
                            <td><?php echo $rows['enterPrice']; ?></td>
                            <td><a href="<?php echo $rows['location']; ?>">Map</a></td>
                            <td>
                                <?php
                                    if($rows['completion'] == 2) {
                                        echo "<p style='color:green;font-weight:bold;'>Completed</p>";
                                    }else if($rows['completion'] == 0){
                                        echo "<p style='color:#ffa800;font-weight:bold;'>OnGoing</p>";
                                    }else if($rows['completion'] == 1){
                                        echo "<p style='color:0019ff;font-weight:bold;'>Pending</p>";
                                    }else if($rows['completion'] == 3){
                                        echo "<p style='color:red;font-weight:bold;'>Canceled</p>";
                                    }
                                ?>
                            </td>
                            
                            <td 
                            <?php
                              if($rows['completion'] == 0){
                                echo "style='display:block;'";
                              }else{
                                echo "style='display:none;'";
                              }
                            ?>
                            >
                                <form action="./CompleteTask.php" method="post">
                                    <input type="hidden" name="task_id" value="<?php echo $rows['task_id']; ?>">
                                    <input type="submit" name="complete" value="Complete Now" class="btn btn-success">
                                </form>
                            </td>

                            <td
                            <?php

                              if($rows['completion'] == 2){
                                echo "style='display:block;'";
                              }else{
                                echo "style='display:none;'";
                              }
                            ?>  
                        
                            >
                                <form action="./MoreDetails.php" method="post">
                                    <input type="hidden" name="task_id" value="<?php echo $rows['task_id']; ?>">
                                    <input type="submit" name="complete" value="Update Submitions" class="btn btn-success">
                                </form>
                            </td>
                            
                            
                            
                                    
                           
                            
                           
                          </tr>
                          <?php 
                            $n++;
                        } ?>
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- =========================== -->

            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12"
                <?php
              if( $_SESSION['AdminAccess'] == 1) {
                echo 'style="display:none;"';
              }
              ?>
            >
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">MY TOTAL COMMITION AMOUNT</h5>
                          <h2 class="mb-3 font-18"></h2>
                          <p class="mb-0"><span class="col-green">
                            <?php
                             $sqlis_txs = "SELECT * FROM commition_total WHERE completedBy = '$userNames'";
                             $sqlix_results = mysqli_query($conn , $sqlis_txs);
                             $mysqli_rowss = $sqlix_results->fetch_assoc();

                             echo 'Rs . '.$mysqli_rowss['Commition'].'.00';
                            ?>
                          </span>
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
             <!-- ========================= -->
             <?php
                             $sqlis_txs11 = "SELECT * FROM complete_task  WHERE completedBy = '$userNames'";
                             $sqlix_results11 = mysqli_query($conn , $sqlis_txs11);
                             
                            ?>
              <!-- =========================== -->

             <div class="row"
             <?php
          if( $_SESSION['AdminAccess'] == 1) {
            echo 'style="display:none;"';
          }
          ?>
             >
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>MY Expencess</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                        <tr>
                            <th>Task ID</th>
                            <th>Completed Date</th>
                            <th>Completed Time</th>
                            <th>Commition</th>
     
                          </tr>
                        </thead>
                        <tbody>

                        <?php while($rows21 = $sqlix_results11-> fetch_assoc()){ ?>
                          <tr>
                           
                            <td><?php echo $rows21['taskID']; ?></td>
                            <td><?php echo $rows21['compteled_date']; ?></td>
                            <td><?php echo $rows21['completedTime']; ?></td>
                            <td><?php echo 'Rs '.$rows21['commition'].'.00'; ?></td>
                            
                            

                          </tr>
                          <?php 
                            $n++;
                        } ?>
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>


             <!-- ======================= -->

            
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12"
            <?php
          if( $_SESSION['AdminAccess'] == 1) {
            echo 'style="display:none;"';
          }
          ?>
            >
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">MY TOTAL EXPENCESS AMOUNT</h5>
                          <h2 class="mb-3 font-18"></h2>
                          <p class="mb-0"><span class="col-green">
                            <?php
                             $sqlis_tx = "SELECT amount FROM total_expencess WHERE userID = '$userId'";
                             $sqlix_result = mysqli_query($conn , $sqlis_tx);
                             $mysqli_row = $sqlix_result->fetch_assoc();

                             echo 'Rs '.$mysqli_row['amount'].'.00';
                            ?>
                          </span>
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


            <div class="row"
            <?php
          if( $_SESSION['AdminAccess'] == 1) {
            echo 'style="display:none;"';
          }
          ?>
            >
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>MY Expencess</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                        <tr>
                            <th>Expencess</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Recipt Image</th>
     
                          </tr>
                        </thead>
                        <tbody>

                        <?php while($rows2 = $result_expencess-> fetch_assoc()){ ?>
                          <tr>
                           
                            <td><?php echo $rows2['expencess_type']; ?></td>
                            <td><?php echo 'Rs '.$rows2['amount'].'.00'; ?></td>
                            <td><?php echo $rows2['date']; ?></td>
                            <td>
                              <img src="<?php echo '../'.$rows2['reciptImg']; ?>" alt="" width="40px" height="30px">
                            </td>

                          </tr>
                          <?php 
                            $n++;
                        } ?>
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>


          
        </section>




        <div class="settingSidebar">
          <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
          </a>
          <div class="settingSidebar-body ps-container ps-theme-default">
            <div class=" fade show active">
              <div class="setting-panel-header">Setting Panel
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Select Layout</h6>
                <div class="selectgroup layout-color w-50">
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
                    <span class="selectgroup-button">Light</span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
                    <span class="selectgroup-button">Dark</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Sidebar Color</h6>
                <div class="selectgroup selectgroup-pills sidebar-color">
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                      data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                      data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Color Theme</h6>
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
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="mini_sidebar_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Mini Sidebar</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="sticky_header_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Sticky Header</span>
                  </label>
                </div>
              </div>
              <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                  <i class="fas fa-undo"></i> Restore Default
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          <a href="https://github.com/SachinUthpala/">Sachin Gunasekara</a></a>
        </div>
        <div class="footer-right">
        </div>
      </footer>



                <!-- popup models -->

                <div class="modal fade" id="addGoldModal" tabindex="-1" aria-labelledby="addGoldModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="goldTypeForm">
        <div class="modal-header">
          <h5 class="modal-title" id="addGoldModalLabel">Add Gold Type</h5>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">X</button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="goldType" class="form-label">Gold Code</label>
            <input type="text" class="form-control" id="goldType" name="goldType" placeholder="Eg : A , B , C .." required>
          </div>
          <div class="mb-3">
            <label for="goldCode" class="form-label">Value</label>
            <input type="text" class="form-control" id="goldCode" name="goldCode" placeholder="Eg : 22 24 ...." required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- add gold price 2 -->
 <!-- Add Gold Price Modal -->
 <div class="modal fade" id="addGoldPriceModal" tabindex="-1" aria-labelledby="addGoldPriceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="goldPriceForm">
        <div class="modal-header">
          <h5 class="modal-title" id="addGoldPriceModalLabel">Add Gold Price</h5>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">X</button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="goldDate" class="form-label">Date</label>
            <input type="date" class="form-control" id="goldDate" name="goldDate" required>
          </div>
          <div class="mb-3">
            <label for="goldPrice" class="form-label">Price</label>
            <input type="number" class="form-control" id="goldPrice" name="goldPrice" placeholder="Eg: 6500" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Gold Calculator Modal -->
<div class="modal fade" id="goldCalculatorModal" tabindex="-1" aria-labelledby="goldCalculatorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="goldCalcForm">
        <div class="modal-header">
          <h5 class="modal-title" id="goldCalculatorModalLabel">Gold Calculator</h5>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">X</button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="goldCodeSelect" class="form-label">Select Gold Code</label>
            <select class="form-control" id="goldCodeSelect" required>
              <option value="">-- Select Code --</option>
              <!-- Options will be loaded via PHP or JS -->
              <?php require './BE/getGoldTypes.php'; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="goldWeight" class="form-label">Weight (g)</label>
            <input type="number" class="form-control" id="goldWeight" placeholder="e.g. 5.5" min="0" step="0.01" required />
          </div>
          <div class="mb-3">
            <button type="button" class="btn btn-primary w-100" onclick="calculateGoldValue()">Calculate</button>
          </div>
          <div id="calcResult" class="alert alert-info d-none"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
document.getElementById("goldTypeForm").addEventListener("submit", function(e) {
  e.preventDefault();
  console.log("Form submit handler triggered.");

  const goldType = document.getElementById("goldType").value;
  const goldCode = document.getElementById("goldCode").value;
  console.log("Values:", { goldType, goldCode });

  fetch("./BE/addGoldType.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: `carrots=${encodeURIComponent(goldType)}&code=${encodeURIComponent(goldCode)}`
  })
  .then(response => {
    console.log("Fetch response status:", response.status, response.statusText);
    return response.json().catch(err => {
      console.log("JSON parse error:", err);
      // still throw to catch below
      throw err;
    });
  })
  .then(data => {
    console.log("Backend returned:", data);
    if (data.success) {
      showToast("Gold type added successfully!", "success");
      const modal = bootstrap.Modal.getInstance(document.getElementById('addGoldModal'));
      modal.hide();
      document.getElementById("goldTypeForm").reset();
    } else {
      showToast(data.message || "Something went wrong.", "danger");
    }
  })
  .catch(error => {
    console.error("Error in fetch / processing:", error);
    showToast("An error occurred.", "danger");
  });
});


function showToast(message, type = "success") {
  Toastify({
    text: message,
    duration: 4000,
    gravity: "top", // top or bottom
    position: "right", // left, center, or right
    backgroundColor: type === "success" ? "green" : "red",
    close: true,
    stopOnFocus: true
  }).showToast();
}

document.getElementById("goldPriceForm").addEventListener("submit", function (e) {
  e.preventDefault();
  console.log("Gold Price form submit triggered.");

  const goldDate = document.getElementById("goldDate").value;
  const goldPrice = document.getElementById("goldPrice").value;
  console.log("Submitted:", { goldDate, goldPrice });

  fetch("./BE/addGoldPrice.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: `date=${encodeURIComponent(goldDate)}&price=${encodeURIComponent(goldPrice)}`
  })
    .then(response => {
      console.log("Fetch response status:", response.status, response.statusText);
      return response.json().catch(err => {
        console.log("JSON parse error:", err);
        throw err;
      });
    })
    .then(data => {
      console.log("Backend returned:", data);
      if (data.success) {
        showToast("Gold price added successfully!", "success");
        const modal = bootstrap.Modal.getInstance(document.getElementById('addGoldPriceModal'));
        modal.hide();
        location.reload();
        document.getElementById("goldPriceForm").reset();
      } else {
        showToast(data.message || "Something went wrong.", "danger");
      }
    })
    .catch(error => {
      console.error("Error in fetch / processing:", error);
      showToast("An error occurred.", "danger");
    });
});




// calculator


function calculateGoldValue() {
  const carrots = parseFloat(document.getElementById("goldCodeSelect").value);
  const weight = parseFloat(document.getElementById("goldWeight").value);

  if (isNaN(carrots) || isNaN(weight) || weight <= 0) {
    showToast("Please select a valid code and enter a positive weight", "danger");
    return;
  }

  fetch('./BE/getLatestPrice.php')
    .then(response => response.json())
    .then(data => {
      if (!data.success) {
        showToast(data.message || "Failed to get latest price", "danger");
        return;
      }

      const todayPrice = parseFloat(data.price);

      // ✅ Updated formula:
      const basePrice = (todayPrice / 24) * carrots;
      const finalValue = (basePrice / 8) * weight;

      const formatted = new Intl.NumberFormat().format(finalValue.toFixed(2));

      const resultBox = document.getElementById("calcResult");
      resultBox.classList.remove("d-none");
      resultBox.innerHTML = `Estimated Value: <strong>Rs. ${formatted} /=</strong>`;
    })
    .catch(err => {
      console.error(err);
      showToast("An error occurred while calculating.", "danger");
    });
}



</script>








<!--  -->
<!-- Toastify JS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>



    </div>
  </div>


  



  <!-- General JS Scripts -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <script src="assets/bundles/apexcharts/apexcharts.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="assets/js/page/index.js"></script>
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>
  <!-- JS Libraies -->
  <script src="assets/bundles/amcharts4/core.js"></script>
  <script src="assets/bundles/amcharts4/charts.js"></script>
  <script src="assets/bundles/amcharts4/animated.js"></script>
  <script src="assets/bundles/amcharts4/worldLow.js"></script>
  <script src="assets/bundles/amcharts4/maps.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>



<script>

'use strict';
$(function () {
  gaugeChart();
});


  function gaugeChart() {
  // Themes begin
  am4core.useTheme(am4themes_animated);
  // Themes end



  // Create chart instance
  var chart = am4core.create("gaugeChart", am4charts.RadarChart);

  // Add data
  chart.data = [
    {
    "category": "Non admin Users",
    "value": <?php echo $nonadminUsers; ?>,
    "full": <?php echo $AllUsers; ?>
  },{
    "category": "Admin Usrs",
    "value": <?php echo $adminUsers; ?>,
    "full": <?php echo $AllUsers; ?>
  } ,{
    "category": "All Users",
    "value": <?php echo $AllUsers; ?>,
    "full": <?php echo $AllUsers; ?>
  }];

  // Make chart not full circle
  chart.startAngle = -90;
  chart.endAngle = 180;
  chart.innerRadius = am4core.percent(20);

  // Set number format
  chart.numberFormatter.numberFormat = "#.#'%'";

  // Create axes
  var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
  categoryAxis.dataFields.category = "category";
  categoryAxis.renderer.grid.template.location = 0;
  categoryAxis.renderer.grid.template.strokeOpacity = 0;
  categoryAxis.renderer.labels.template.horizontalCenter = "right";
  categoryAxis.renderer.labels.template.fontWeight = 500;
  categoryAxis.renderer.labels.template.adapter.add("fill", function (fill, target) {
    return (target.dataItem.index >= 0) ? chart.colors.getIndex(target.dataItem.index) : fill;
  });
  categoryAxis.renderer.minGridDistance = 10;

  var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
  valueAxis.renderer.grid.template.strokeOpacity = 0;
  valueAxis.min = 0;
  valueAxis.max = 100;
  valueAxis.strictMinMax = true;
  valueAxis.renderer.labels.template.fill = am4core.color("#9aa0ac");

  // Create series
  var series1 = chart.series.push(new am4charts.RadarColumnSeries());
  series1.dataFields.valueX = "full";
  series1.dataFields.categoryY = "category";
  series1.clustered = false;
  series1.columns.template.fill = new am4core.InterfaceColorSet().getFor("alternativeBackground");
  series1.columns.template.fillOpacity = 0.08;
  series1.columns.template.cornerRadiusTopLeft = 20;
  series1.columns.template.strokeWidth = 0;
  series1.columns.template.radarColumn.cornerRadius = 20;

  var series2 = chart.series.push(new am4charts.RadarColumnSeries());
  series2.dataFields.valueX = "value";
  series2.dataFields.categoryY = "category";
  series2.clustered = false;
  series2.columns.template.strokeWidth = 0;
  series2.columns.template.tooltipText = "{category}: [bold]{value}[/]";
  series2.columns.template.radarColumn.cornerRadius = 20;

  series2.columns.template.adapter.add("fill", function (fill, target) {
    return chart.colors.getIndex(target.dataItem.index);
  });

  // Add cursor
  chart.cursor = new am4charts.RadarCursor();
}
</script>


<!-- index.html  21 Nov 2019 03:47:04 GMT -->
</html>