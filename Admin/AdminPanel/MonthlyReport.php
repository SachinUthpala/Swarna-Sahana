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
  

  <style>
    #section-to-pdf {
       /* Black border with 5px width */
      padding: 10px; /* Padding to give some space between content and border */
 /* Margin to add space around the section */
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
        <section class="section" id="section-to-pdf">


 <!-- only admin rows -->
 <h5
            <?php
            if( $_SESSION['AdminAccess'] == 1) {
                echo 'style="display:block;"';
            }else{
                echo 'style="display:none;"';
            }
            ?>
            >Today Is <?php echo date('Y-m-d'); ?> and Welcome to Monthly Reports</h5>

            <br>

            <h6>1.) Monthly Task Report</h6>
            
            <?php
                
                $allTaskDaily = 0;
                $allDailyPending = 0;
                $allDailyCompleted = 0;
            
                $allDailyTask = "SELECT * FROM task WHERE (date >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-26'), INTERVAL 1 MONTH) AND date < DATE_FORMAT(CURDATE(), '%Y-%m-26'));";
                $resultDailyAllTask = mysqli_query($conn , $allDailyTask);
                
                while($rowsAllDaily = $resultDailyAllTask-> fetch_assoc()){
                    if((int)$rowsAllDaily['completion'] == 2){
                       $allDailyCompleted = $allDailyCompleted +1 ; 
                    }else if((int)$rowsAllDaily['completion'] == 0) {
                        $allDailyPending = $allDailyPending +1 ;
                    }
                    
                    $allTaskDaily = $allTaskDaily + 1;
                }
                
                
            
            ?>

            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="card">
                    <div class="card-statistic-4">
                      <div class="align-items-center justify-content-between">
                        <div class="row ">
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                              <h5 class="font-15"> All Created Tasks</h5>
                              <h2 class="mb-3 font-18"><?php echo $allTaskDaily; ?></h2>
                              <p class="mb-0"><span class="col-orange">
                              
                              </span> From Task Table</p>
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
                              <h5 class="font-15"> All Completed Tasks</h5>
                              <h2 class="mb-3 font-18"><?php echo $allDailyCompleted; ?></h2>
                              <p class="mb-0"><span class="col-orange">
                              
                              </span> From Task Table</p>
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

                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="card">
                    <div class="card-statistic-4">
                      <div class="align-items-center justify-content-between">
                        <div class="row ">
                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                              <h5 class="font-15"> All Ongoing Tasks</h5>
                              <h2 class="mb-3 font-18"><?php echo $allDailyPending; ?></h2>
                              <p class="mb-0"><span class="col-orange">
                              
                              </span> From Task Table</p>
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

            <?php $currentDate =  date('Y-m-d'); ?>

            <?php
              $sql = "
              SELECT 
                  task.*, 
                  users.* 
              FROM 
                  task 
              LEFT JOIN 
                  users 
              ON 
                  task.select_user = users.UserId 
              WHERE
                  (task.date >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-26'), INTERVAL 1 MONTH) AND task.date < DATE_FORMAT(CURDATE(), '%Y-%m-26'))";
              $result = mysqli_query($conn, $sql);
            ?>

        <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Monthly Task Table</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                        <thead>
                          <tr>
                          
                            <th>Date</th>
                            
                            <th>Customer Name</th>
                            <th>Pnone</th>
                            <th>Bank/Shop</th>
                            <th>City</th>
                            <th>Price</th>
                            <th>Completed By</th>
                            <th>Completion</th>
                          </tr>
                        </thead>
                        <tbody>
                          

                        <?php while($rows = $result-> fetch_assoc()){ ?>
                          <tr>
                            
                            <td><?php echo $rows['date']; ?></td>
                            
                            <td><?php echo $rows['customerName']; ?></td>
                            <td><?php echo $rows['Phone']; ?></td>
                            <td><?php echo $rows['bank_shop']; ?></td>
                            <td><?php echo $rows['city']; ?></td>
                            <td><?php echo $rows['enterPrice']; ?></td>
                            <td><?php echo $rows['UserName']; ?></td>
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
          </div>

          <br>

            <h6>2.) Monthly Buisness Report</h6>

            <?php
                $sql5 = "SELECT * FROM dailybuisness WHERE (date >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-26'), INTERVAL 1 MONTH) AND date < DATE_FORMAT(CURDATE(), '%Y-%m-26'))";
                $result5 = mysqli_query($conn , $sql5);
                $totalProfit5 = 0.00;

                while($rows5 = $result5-> fetch_assoc()){
                    $rowProfit5  = $rows5['sellingPrice'] - $rows5['buyingPrice'] ; 
                    $totalProfit5 = $totalProfit5 + $rowProfit5 ;
                } 
            ?>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Current Day</h5>
                          <h2 class="mb-3 font-18"><?php 
                                if($totalProfit5 > 0){
                                    echo '<span style= "color:green;">Rs.'.$totalProfit5.'.00</span>';
                                } else {
                                    echo '<span style= "color:red;">Rs.'.$totalProfit5.'.00</span>';
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
              $sql6 = "SELECT * FROM dailybuisness WHERE (date >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-26'), INTERVAL 1 MONTH) AND date < DATE_FORMAT(CURDATE(), '%Y-%m-26'))";
              $result6 = mysqli_query($conn , $sql6);
            ?>
            <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Monthly Buisness Table</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" id="tableExport2" style="width:100%;">
                        <thead>
                          <tr>
                            <th>Buisness ID</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Weight</th>
                            <th>Buying Price</th>
                            <th>Selling Price</th>
                            <th>Daily Profit</th>
                            
                          </tr>
                        </thead>
                        <tbody>

                        <?php while($rows6 = $result6-> fetch_assoc()){ ?>
                          <tr>
                            <td><?php echo $rows6['bId']; ?></td>
                            <td><?php echo $rows6['date']; ?></td>
                            <td><?php echo $rows6['time']; ?></td>
                            
                            <td><?php echo $rows6['weight']; ?></td>
                            <td><?php echo "Rs.".$rows6['buyingPrice'].".00"; ?></td>
                            <td><?php echo "Rs.".$rows6['sellingPrice'].".00"; ?></td>
                            <td><?php 
                                $profit6 = $rows6['sellingPrice'] - $rows6['buyingPrice'] ;

                                if($profit6 > 0){
                                    echo '<span style= "color:green;">Rs.'.$profit6.'.00</span>';
                                } else {
                                    echo '<span style= "color:red;">Rs.'.$profit6.'.00</span>';
                                }
                            ?></td>
                            
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
          </div>

          <br>

          <h6>2.) Monthly Other Costs</h6>

          <?php
                $sql7 = "SELECT * FROM dailyothercost WHERE (date >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-26'), INTERVAL 1 MONTH) AND date < DATE_FORMAT(CURDATE(), '%Y-%m-26'))";
                $result7 = mysqli_query($conn , $sql7);
                $totalOtherCost = 0 ; 

                while($rows7 = $result7-> fetch_assoc()){
                    $totalOtherCost = $totalOtherCost + (float)$rows7['amount'];
                } 
            ?>

           <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Current Month</h5>
                          <h2 class="mb-3 font-18"><?php 
                                
                                    echo '<span style= "color:red;">Rs.'.$totalOtherCost.'.00</span>';
                               
                          ?></h2>
                          <p class="mb-0"><span class="col-orange">
                          
                          </span>Total Current Month Other Cost</p>
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
              $sql8 = "SELECT * FROM dailyothercost WHERE (date >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-26'), INTERVAL 1 MONTH) AND date < DATE_FORMAT(CURDATE(), '%Y-%m-26'))";
              $result8 = mysqli_query($conn , $sql8);
            ?>
            <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Monthly Other Cost Table</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" id="tableExport2" style="width:100%;">
                        <thead>
                          <tr>
                            <th>Cost ID</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Cost Type</th>
                            <th>Cost Amount</th>
                            
                            
                          </tr>
                        </thead>
                        <tbody>

                        <?php while($row8 = $result8-> fetch_assoc()){ ?>
                          <tr>
                            <td><?php echo $row8['costId']; ?></td>
                            <td><?php echo $row8['date']; ?></td>
                            <td><?php echo $row8['time']; ?></td>
                            <td><?php echo $row8['costType']; ?></td>
                            
                            <td><?php 
                                
                                    echo '<span style= "color:red;">Rs.'.$row8['amount'].'.00</span>';
                              
                            ?></td>
                            
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
          </div>

          <hr style="width: 3px; background-color: #7CFC00;">

          <h6>3.) Monthly Board Camping Costs</h6>

          <?php
                $sql9 = "SELECT * FROM bordcampingcost WHERE (date >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-26'), INTERVAL 1 MONTH) AND date < DATE_FORMAT(CURDATE(), '%Y-%m-26'))";
                $result9 = mysqli_query($conn , $sql9);
                $totalDailyBoardCampingCost = 0 ; 

                while($rows9 = $result9-> fetch_assoc()){
                    $totalDailyBoardCampingCost = $totalDailyBoardCampingCost + (float)$rows9['amount'];
                } 
            ?>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Current Month</h5>
                          <h2 class="mb-3 font-18"><?php 
                                
                                    echo '<span style= "color:blue;">Rs.'.$totalDailyBoardCampingCost.'.00</span>';
                               
                          ?></h2>
                          <p class="mb-0"><span class="col-orange">
                          
                          </span>Total Current Month Board Camping Cost</p>
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
              $sql10 = "SELECT * FROM bordcampingcost WHERE (date >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-26'), INTERVAL 1 MONTH) AND date < DATE_FORMAT(CURDATE(), '%Y-%m-26'))";
              $result10 = mysqli_query($conn , $sql10);
            ?>
            <div class="section-body">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                      <h4>Monthly Board Camping Cost Table</h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-striped table-hover" id="tableExport2" style="width:100%;">
                          <thead>
                            <tr>
                              <th>Cost ID</th>
                              <th>Date</th>
                              <th>Time</th>
                              <th>Cost Type</th>
                              <th>Cost Amount</th>
                              
                              
                            </tr>
                          </thead>
                          <tbody>

                          <?php while($row10 = $result10-> fetch_assoc()){ ?>
                            <tr>
                              <td><?php echo $row10['costId']; ?></td>
                              <td><?php echo $row10['date']; ?></td>
                              <td><?php echo $row10['time']; ?></td>
                              <td><?php echo $row10['costType']; ?></td>
                              
                              <td><?php 
                                  
                                      echo '<span style= "color:blue;">Rs.'.$row10['amount'].'.00</span>';
                                
                              ?></td>
                              
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
            </div>

            <h6>4.)Current Month Total Commition Details</h6>

            <?php
              $sql22 = "
              SELECT 
                  completedBy, 
                  SUM(commition) AS total_commission
              FROM 
                  complete_task
              WHERE 
                 (compteled_date >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-26'), INTERVAL 1 MONTH) AND compteled_date < DATE_FORMAT(CURDATE(), '%Y-%m-26'))
              GROUP BY 
                  completedBy
            ";
            $result22 = mysqli_query($conn, $sql22);
            ?>

            <div class="section-body">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                      <h4>Daily Commition Details</h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-striped table-hover" id="tableExport2" style="width:100%;">
                          <thead>
                            <tr>
                              
                              <th>Commition</th>
                              <th>User</th>
                            </tr>
                          </thead>
                          <tbody>

                          <?php while($row22 = $result22-> fetch_assoc()){ ?>
                            <tr>
                              
                              <td><?php 
                                  
                                  echo '<span style= "color:blue;">Rs.'.$row22['total_commission'].'.00</span>';
                            
                          ?></td>
                          <td><?php echo $row22['completedBy']; ?></td>
                              
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
            </div>

            <h6>5.)Current Month Total Expencess Details</h6>

            <?php
              $sql23 = "SELECT 
                            expencess.*, 
                            users.UserName,
                            SUM(expencess.amount) AS total_amount 
                        FROM 
                            expencess 
                        LEFT JOIN 
                            users 
                        ON 
                            expencess.user_id = users.UserId
                            WHERE 
                            (date >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-26'), INTERVAL 1 MONTH) AND date < DATE_FORMAT(CURDATE(), '%Y-%m-26')) AND approved_exp = 1
                            Group By
                            expencess.user_id,
                            users.UserName";
              $result23 = mysqli_query($conn , $sql23);
            ?>

            <div class="section-body">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                      <h4>Month Expencess Details</h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-striped table-hover" id="tableExport2" style="width:100%;">
                          <thead>
                            <tr>
                              <th>Username</th>
                              <th>Total Expencess</th>
                              
                            </tr>
                          </thead>
                          <tbody>

                          <?php while($row23 = $result23-> fetch_assoc()){ ?>
                            <tr>
                              
                              <td><?php echo $row23['UserName']; ?></td>
                              
                              <td><?php 
                                  
                                      echo '<span style= "color:blue;">Rs.'.$row23['total_amount'].'.00</span>';
                                
                              ?></td>
                              
                              
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
            </div>

            <h6>6.) Monthly Total Commitions and Expencess Costs</h6>

            <?php
                $sql11 = "SELECT * FROM complete_task WHERE  (compteled_date >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-26'), INTERVAL 1 MONTH) AND compteled_date < DATE_FORMAT(CURDATE(), '%Y-%m-26'))";
                $result11 = mysqli_query($conn , $sql11);
                $totalDailyCommitions = 0 ; 

                while($rows11 = $result11-> fetch_assoc()){
                    $totalDailyCommitions = $totalDailyCommitions + (float)$rows11['commition'];
                } 

                $sql12 = "SELECT * FROM expencess WHERE (date >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-26'), INTERVAL 1 MONTH) AND date < DATE_FORMAT(CURDATE(), '%Y-%m-26')) and approved_exp = 1";
                $result12 = mysqli_query($conn , $sql12);
                $dailyTotalExpencess = 0 ; 

                while($rows12 = $result12-> fetch_assoc()){
                    $dailyTotalExpencess = $dailyTotalExpencess + (float)$rows12['amount'];
                } 

                // task creator commition
                $sql_taskCreator = "SELECT * FROM complete_task WHERE (compteled_date >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-26'), INTERVAL 1 MONTH) AND compteled_date < DATE_FORMAT(CURDATE(), '%Y-%m-26')) ";
                $resultTaskCreator = mysqli_query($conn , $sql_taskCreator);
                $taskCreatorNumRows = mysqli_num_rows($resultTaskCreator);

                //taskCreators
                $totalTaskCreatorRows = "SELECT * FROM taskcreatorcommition";
                $resultTotalTaskCreators = mysqli_query($conn , $totalTaskCreatorRows);
                $TotalTaskCreators = mysqli_num_rows($resultTotalTaskCreators);
            ?>

            <div class="row">

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Current Month</h5>
                          <h2 class="mb-3 font-18"><?php 
                                
                                    echo '<span style= "color:blue;">Rs.'.$totalDailyCommitions.'.00</span>';
                               
                          ?></h2>
                          <p class="mb-0"><span class="col-orange">
                          
                          </span>Total Commitions</p>
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

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15"><?php echo $TotalTaskCreators."-Task Creators"?></h5>
                          <h2 class="mb-3 font-18"><?php 
                                    $AllDayTaskCreatorAllCommition = $taskCreatorNumRows*$TotalTaskCreators*200;
                                    echo '<span style= "color:blue;">Rs.'.$AllDayTaskCreatorAllCommition.'.00</span>';
                               
                          ?></h2>
                          <p class="mb-0"><span class="col-orange">
                          
                          </span>Total Task Creatoe Commitiom</p>
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

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Current Month</h5>
                          <h2 class="mb-3 font-18"><?php 
                                
                                    echo '<span style= "color:purple;">Rs.'.$dailyTotalExpencess.'.00</span>';
                               
                          ?></h2>
                          <p class="mb-0"><span class="col-orange">
                          
                          </span>Total Expencess</p>
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

            <h6>7.) Current Full Summery</h6>

            <div class="row">
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                  <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                      <div class="row ">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                          <div class="card-content">
                            <h5 class="font-15">Current Month</h5>
                            <h2 class="mb-3 font-18"><?php 

                                    $allTotalExpencess =  $totalDailyCommitions + $dailyTotalExpencess + $AllDayTaskCreatorAllCommition + $totalOtherCost + $totalDailyBoardCampingCost;
                                  
                                      echo '<span style= "color:blue;">Rs.'.$allTotalExpencess .'.00</span>';
                                
                            ?></h2>
                            <p class="mb-0"><span class="col-orange">
                            
                            </span>Total Expencess</p>
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

              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                  <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                      <div class="row ">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                          <div class="card-content">
                            <h5 class="font-15">Current Month</h5>
                            <h2 class="mb-3 font-18"><?php 
                                  
                                  if($totalProfit5 > 0){
                                    echo '<span style= "color:green;">Rs.'.$totalProfit5.'.00</span>';
                                  } else {
                                      echo '<span style= "color:red;">Rs.'.$totalProfit5.'.00</span>';
                                  }
                                
                            ?></h2>
                            <p class="mb-0"><span class="col-orange">
                            
                            </span>All Month Buisness Profit</p>
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

              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="card">
                  <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                      <div class="row ">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                          <div class="card-content">
                            <h5 class="font-15">Current Month</h5>
                            <h2 class="mb-3 font-18"><?php 

                                  $finalProfit = $totalProfit5 - $allTotalExpencess;
                                  
                                  if($finalProfit > 0){
                                    echo '<span style= "color:green;">Rs.'.$finalProfit.'.00</span>';
                                  } else {
                                      echo '<span style= "color:red;">Rs.'.$finalProfit.'.00</span>';
                                  }
                                
                            ?></h2>
                            <p class="mb-0"><span class="col-orange">
                            
                            </span>All Month Final Profit</p>
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

            <br>

            <h6>8.) Other Options </h6> <br>

                  <div class="card w-50">
    <div class="card-header">
        <h4>Get Monthly Summary By Month</h4>
    </div>
    <div class="card-body">
        <form action="./MonthlyReportByMonth.php" method="post" id="form23">
            <div class="section-title">Enter The From Date To Date</div>
            <div class="form-group">
                <div class="input-group mb-3">
                    <input type="date" class="form-control" name="FromDate" style="margin-left:10px;" required>
                    <input type="date" class="form-control" name="ToDate" required>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" onclick="SubmitForm2()">Generate</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function SubmitForm2() {
            // Get the form element
            const form = document.getElementById('form23');

            // Validate the date inputs
            const fromDate = form.querySelector('input[name="FromDate"]');
            const toDate = form.querySelector('input[name="ToDate"]');
            
            if (!fromDate.value || !toDate.value) {
                alert("Please enter both From and To dates.");
                return; // Prevent form submission if dates are missing
            }

            // Submit the form
            form.submit();
        }
    </script>
</div>


                 



         


            

          
        
          
        </section>

        <script>
    function downloadPDF() {
      var element = document.getElementById('section-to-pdf');
      
      // Set up options for jsPDF
      var options = {
        margin: [10, 10, 10, 10], // Adjust margins (top, left, bottom, right)
        filename: '<?php echo "DailyReport".date('Y/m/d')."pdf"; ?>',
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

  <!-- table css -->
  <script src="assets/bundles/datatables/datatables.min.js"></script>
  <script src="assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/bundles/datatables/export-tables/dataTables.buttons.min.js"></script>
  <script src="assets/bundles/datatables/export-tables/buttons.flash.min.js"></script>
  <script src="assets/bundles/datatables/export-tables/jszip.min.js"></script>
  <script src="assets/bundles/datatables/export-tables/pdfmake.min.js"></script>
  <script src="assets/bundles/datatables/export-tables/vfs_fonts.js"></script>
  <script src="assets/bundles/datatables/export-tables/buttons.print.min.js"></script>
  <script src="assets/js/page/datatables.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

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