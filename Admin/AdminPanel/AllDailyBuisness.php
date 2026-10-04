<?php

require_once '../DbActions/Db.conn.php';
session_start();
error_reporting(0);
date_default_timezone_set("Asia/Colombo");

if(!$_SESSION['UserName'] && !$_SESSION['UserId']){
  header('Location: ../index.html');
}



$n = 0;


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
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
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

            <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15"> Time</h5>
                          <h2 class="mb-3 font-18"><?php echo date('H:i'); ?></h2>
                          <p class="mb-0"><span class="col-orange">
                          
                          </span> Time</p>
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
                $sql2 = "SELECT * FROM dailybuisness";
                $result2 = mysqli_query($conn , $sql2);
                $totalProfit = 0.00;

                while($rows2 = $result2-> fetch_assoc()){
                    $rowProfit  = $rows2['sellingPrice'] - $rows2['buyingPrice'] ; 
                    $totalProfit = $totalProfit + $rowProfit ;
                } 
          ?>

            <div class="col-xl-5 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15"> Profit</h5>
                          <h2 class="mb-3 font-18"><?php 
                                if($totalProfit > 0){
                                    echo '<span style= "color:green;">Rs.'.$totalProfit.'.00</span>';
                                } else {
                                    echo '<span style= "color:red;">Rs.'.$totalProfit.'.00</span>';
                                }
                          ?></h2>
                          <p class="mb-0"><span class="col-orange">
                          
                          </span>Total Profit</p>
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
                $sql4 = "SELECT * FROM dailybuisness WHERE YEAR(date) = YEAR(CURDATE())";
                $result4 = mysqli_query($conn , $sql4);
                $totalProfit3 = 0.00;

                while($rows4 = $result4-> fetch_assoc()){
                    $rowProfit3  = $rows4['sellingPrice'] - $rows4['buyingPrice'] ; 
                    $totalProfit3 = $totalProfit3 + $rowProfit3 ;
                } 
            ?>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Current Year</h5>
                          <h2 class="mb-3 font-18"><?php 
                                if($totalProfit3 > 0){
                                    echo '<span style= "color:green;">Rs.'.$totalProfit3.'.00</span>';
                                } else {
                                    echo '<span style= "color:red;">Rs.'.$totalProfit3.'.00</span>';
                                }
                          ?></h2>
                          <p class="mb-0"><span class="col-orange">
                          
                          </span>Total Current Year Profit</p>
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
                $sql5 = "SELECT * FROM dailybuisness WHERE date = CURDATE()";
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
                          
                          </span>Total Current Day Profit</p>
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

          <?php
          $sql = "SELECT * FROM dailybuisness";
          $result = mysqli_query($conn , $sql);
          ?>
        
          <!-- user create form -->
          <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>All Daily Buisness</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                        <tr>
                            <th class="text-center">
                              #
                            </th>
                            <th>Buisness ID</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Weight</th>
                            <th>Buying Price</th>
                            <th>Selling Price</th>
                            <th>Daily Profit</th>
                            <th>Remove</th>
                          </tr>
                        </thead>
                        <tbody>

                        <?php while($rows = $result-> fetch_assoc()){ ?>
                          <tr>
                            <td>
                              <?php echo $n; ?>
                            </td>
                            <td><?php echo $rows['bId']; ?></td>
                            <td><?php echo $rows['date']; ?></td>
                            <td><?php echo $rows['time']; ?></td>
                            
                            <td><?php echo $rows['weight']; ?></td>
                            <td><?php echo "Rs.".$rows['buyingPrice'].".00"; ?></td>
                            <td><?php echo "Rs.".$rows['sellingPrice'].".00"; ?></td>
                            <td><?php 
                                $profit = $rows['sellingPrice'] - $rows['buyingPrice'] ;

                                if($profit > 0){
                                    echo '<span style= "color:green;">Rs.'.$profit.'.00</span>';
                                } else {
                                    echo '<span style= "color:red;">Rs.'.$profit.'.00</span>';
                                }
                            ?></td>
                            <td>
                              <form id="<?php echo "deleteForm".$rows['bId']; ?>" action="../DbActions/DailyBuisness/DeleteDailyBuisness.php" method="post">
                                    <input type="hidden" name="delete_id" value="<?php echo $rows['bId']; ?>">
                                    <button type="submit" name="delete" class="btn btn-danger" id="<?php echo "deletebutton".$rows['bId']; ?>">Delete</button>
                               </form>

                               <script>
                                    document.getElementById('<?php echo "deletebutton".$rows['bId']; ?>').addEventListener('click', function(event) {
                                        event.preventDefault(); // Prevent the form from submitting immediately

                                        Swal.fire({
                                            title: 'Are you sure?',
                                            text: "Do you want to Delete this?",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'Yes, Delete it!',
                                            cancelButtonText: 'No, cancel!'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                // If confirmed, submit the form
                                                document.getElementById('<?php echo "deleteForm".$rows['bId']; ?>').submit();
                                            }
                                        });
                                    });
                                </script>
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
          <a href="#">Sachin Gunasekara</a></a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>

  <?php


    ?>


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
  <!-- sweet alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <!-- JS Libraies -->
  <script src="assets/bundles/datatables/datatables.min.js"></script>
  <script src="assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/bundles/jquery-ui/jquery-ui.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="assets/js/page/datatables.js"></script>



  <?php

if($_SESSION['TaskCreated'] == 1){
    echo '<script>
            Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Inform Deleted Sucessfully",
            showConfirmButton: false,
            timer: 1500
            });

        </script>' ;

        $_SESSION['TaskCreated'] = null;
}


    ?>



</body>


<!-- index.html  21 Nov 2019 03:47:04 GMT -->
</html>