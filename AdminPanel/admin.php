<?php


require_once '../DbActions/Db.conn.php';
session_start();
error_reporting(0);
date_default_timezone_set("Asia/Colombo");

if(!$_SESSION['UserName'] && !$_SESSION['UserId']){
  header('Location: ../index.html');
}


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

?>

<!DOCTYPE html>
<html lang="en">


<!-- index.html  21 Nov 2019 03:44:50 GMT -->
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
  <
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
              </a></li>
            <li>
              
              <form class="form-inline mr-auto">
                <div class="search-element">
                  <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">
                  <button class="btn" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </form>
            </li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          
          
          
          <li class="dropdown"><a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="<?php echo $_SESSION['userImage']; ?>"
                class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title">Hello <?php echo $_SESSION['UserName']; ?></div>
              <a href="profile.html" class="dropdown-item has-icon"> <i class="far
										fa-user"></i> Profile
              </a>  <a href="#" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                Settings
              </a>
              <div class="dropdown-divider"></div>
              <a href="../DbActions/logOut/logout.php" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                Logout
              </a>
            </div>


          </li>


        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="admin.php"> <span class="logo-name">Swarna Sahana</spanclass=>
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown active">
              <a href="admin.php" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <li class="dropdown"
            <?php
                  if($_SESSION['AdminAccess'] == 2) {
                    echo 'style="display:none;"';
                  }
                ?>
            >
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="briefcase"
                    <?php
                  if($_SESSION['AdminAccess'] == 2) {
                    echo 'style="display:none;"';
                  }
                ?>
                  ></i><span>My Tasks</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="./MyAllTask.php">All Tasks</a></li>
                <li><a class="nav-link" href="./myCompletedTasks.php">Completed Tasks</a></li>
                <li><a class="nav-link" href="./myOngoing.php">On Going Task</a></li>
              </ul>
            </li>
            <li class="dropdown"
            <?php
                  if($_SESSION['AdminAccess'] == 2) {
                    echo 'style="display:none;"';
                  }
                ?>
            >
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Expences</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="">Your Expences</a></li>
              </ul>
            </li>
            
            <li class="menu-header"
            <?php
                if( $_SESSION['AdminAccess'] == 0) {
                  echo 'style="display:none;"';
                }
              ?>
            >Task Functions</li>
            <li class="dropdown"
            <?php
                if( $_SESSION['AdminAccess'] == 0) {
                  echo 'style="display:none;"';
                }
              ?>
            >
              <a href="#" class="menu-toggle nav-link has-dropdown"
                
              ><i data-feather="copy"></i><span>Main Functions</span></a>
              <ul class="dropdown-menu"
              <?php
                if( $_SESSION['AdminAccess'] == 0) {
                  echo 'style="display:none;"';
                }
              ?>
              >
                <li><a class="nav-link" href="./createTask.php">Create Task</a></li>
                <li><a class="nav-link" href="./UpdateTask.php">Update Task</a></li>
                <li><a class="nav-link" href="./deleteTask.php">Delete Task</a></li>
              </ul>
            </li>

            <li class="dropdown"
            <?php
                if( $_SESSION['AdminAccess'] == 0) {
                  echo 'style="display:none;"';
                }
              ?>
            >
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="shopping-bag"></i><span>All Tasks</span></a>
              <ul class="dropdown-menu"
             
              <?php
                if( $_SESSION['AdminAccess'] == 0) {
                  echo 'style="display:none;"';
                }
              ?>
              
              >
                <li><a class="nav-link" href="./AllTasks.php">All Tasks</a></li>
                <li><a class="nav-link" href="./allOngoingTask.php">On Going Task</a></li>
                <li><a class="nav-link" href="./allCompletedTask.php">Completed Tasks</a></li>
              </ul>
            </li>

            <li class="menu-header"
            <?php
                if($_SESSION['AdminAccess'] == 2 || $_SESSION['AdminAccess'] == 0) {
                  echo 'style="display:none;"';
                }
              ?>
            >User Functions</li>
            <li class="dropdown"
            <?php
                if($_SESSION['AdminAccess'] == 2 || $_SESSION['AdminAccess'] == 0) {
                  echo 'style="display:none;"';
                }
              ?>
            >
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="copy"></i><span>Main Functions</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="./createUser.php">Create User</a></li>
                <li><a class="nav-link" href="badge.html">Update User</a></li>
                <li><a class="nav-link" href="./DeleteUser.php">Delete User</a></li>
              </ul>
            </li>

            <li class="dropdown"
            <?php
                if($_SESSION['AdminAccess'] == 2 || $_SESSION['AdminAccess'] == 0) {
                  echo 'style="display:none;"';
                }
              ?>
            >
              <a href="#" class="menu-toggle nav-link has-dropdown"
             
              ><i data-feather="copy"></i><span> All Users</span></a>
              <ul class="dropdown-menu"
             
              >
                <li><a class="nav-link" href="./allUsers.php">All Users</a></li>
                <li><a class="nav-link" href="./adminUsers.php">Admin Users</a></li>
                <li><a class="nav-link" href="./nonAdminUsers.php">Non Admin Users</a></li>
              </ul>
            </li>

            
            
            
          
            
          </ul>
        </aside>
      </div>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">

        <div class="row "
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

          <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Basic DataTables</h4>
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