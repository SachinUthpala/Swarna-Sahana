<?php

require_once '../DbActions/Db.conn.php';
session_start();
error_reporting(0);
date_default_timezone_set("Asia/Colombo");

if(!$_SESSION['UserName'] && !$_SESSION['UserId']){
  header('Location: ../index.php');
}


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
ORDER BY 
    task.date DESC";

$result = mysqli_query($conn, $sql);

$n = 0;


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
  
   <!-- General CSS Files -->

  <link rel="stylesheet" href="assets/bundles/datatables/datatables.min.css">
  <link rel="stylesheet" href="assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
  <
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
            
          <div class="row ">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Date</h5>
                          <h2 class="mb-3 font-18"><?php echo  date('Y-m-d'); ?></h2>
                          <p class="mb-0"><span class="col-green">Have a good Day</span></p>
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
                          <h5 class="font-15"> Time</h5>
                          <h2 class="mb-3 font-18"><?php echo date('H:i:s'); ?></h2>
                          <p class="mb-0"><span class="col-orange">
                          
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

            

          </div>
        
          <!-- user create form -->
          <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>All Task Table</h4>
                  </div>
                  <div class="card-body">
                    <input type="text" id="customSearchInput" class="form-control mb-3" placeholder="Search tasks...">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover" id="customSearchTable" style="width:100%;">
                        <thead>
                        <tr>
                            <th class="text-center">
                              #
                            </th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Customer Name</th>
                            <th>Pnone</th>
                            <th>Bank/Shop</th>
                            <th>City</th>
                            <th>Price</th>
                            <th>Location</th>
                            <th>Completed By</th>
                            <th>Completion</th>
                            <th>More Details</th>
     
                          </tr>
                        </thead>
                        <tbody>

                        <?php while($rows = $result-> fetch_assoc()){ ?>
                          <tr>
                            <td>
                              <?php echo $n; ?>
                            </td>
                            <td><?php echo $rows['date']; ?></td>
                            <td><?php echo $rows['time']; ?></td>
                            <td><?php echo $rows['customerName']; ?></td>
                            <td><?php echo $rows['Phone']; ?></td>
                            <td><?php echo $rows['bank_shop']; ?></td>
                            <td><?php echo $rows['city']; ?></td>
                            <td><?php echo $rows['enterPrice']; ?></td>
                            <td><a href="<?php echo $rows['location']; ?>" target=" ">Map</a></td>
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
                            
                            <td 
                            <?php
                              if($rows['completion'] == 0){
                                echo "style='display:block;'";
                              }else{
                                echo "style='display:none;'";
                              }
                            ?>
                            >
                            <p style='color:red;font-weight:bold;'>Not Completed</p>
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
                                    <input type="submit" name="details" value="More Details" class="btn btn-success">
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
            
            <br>
            
           
          
        
          
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
          <a href="#">Sachin Gunasekara</a></a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>

  <?php


    ?>
    
    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>



<!-- General JS Scripts -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <script src="assets/bundles/datatables/datatables.min.js"></script>
  <script src="assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/bundles/jquery-ui/jquery-ui.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="assets/js/page/datatables.js"></script>
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>
  
  
  <script>
  $(document).ready(function() {
    // Custom search functionality
    $("#customSearchInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#customSearchTable tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
  </script>



  <?php

if($_SESSION['userCreated'] == 1){
    echo '<script>
            Swal.fire({
            position: "top-end",
            icon: "success",
            title: "User Created Sucessfully",
            showConfirmButton: false,
            timer: 1500
            });

        </script>' ;

        $_SESSION['userCreated'] = null;
}


    ?>



</body>


<!-- index.html  21 Nov 2019 03:47:04 GMT -->
</html>