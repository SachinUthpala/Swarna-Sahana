<?php

require_once '../DbActions/Db.conn.php';
session_start();
error_reporting(0);
date_default_timezone_set("Asia/Colombo");

if (!$_SESSION['UserName'] && !$_SESSION['UserId']) {
  header('Location: ../index.html');
}


if (isset($_POST['task_id'])) {
  $taskId = (int)$_POST['task_id'];
}


$sql = "SELECT * FROM `pending_complete_task` WHERE taskID = $taskId";

$result = mysqli_query($conn, $sql);

$row = $result->fetch_assoc();

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
      

      <!-- navigation -->
      <?php require './Components/Nav.php'; ?>
      <!-- end of navigation -->

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">

          <div class="row">
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


          <div class="row">
  <div class="col-12 col-md-12 col-lg-8">
    <div class="card">
      <div class="p-4"> <!-- replaced padding-20 with Bootstrap p-4 -->
        <ul class="nav nav-tabs" id="myTab2" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"
              aria-selected="true">Complete Task Details</a>
          </li>
        </ul>

        <div class="tab-content tab-bordered" id="myTab3Content">
          <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
            
            <!-- Task Info -->
            <div class="row mb-4">
              <div class="col-md-3 col-6">
                <strong>ID Number</strong>
                <p class="text-muted mb-0"><?php echo $row['IdNumber']; ?></p>
              </div>
              <div class="col-md-3 col-6">
                <strong>Weight</strong>
                <p class="text-muted mb-0"><?php echo $row['weight']; ?></p>
              </div>
              <div class="col-md-3 col-6">
                <strong>Completed Date</strong>
                <p class="text-muted mb-0"><?php echo $row['compteled_date']; ?></p>
              </div>
              <div class="col-md-3 col-6">
                <strong>Completed Time</strong>
                <p class="text-muted mb-0"><?php echo $row['completedTime']; ?></p>
              </div>
              <div class="col-md-3 col-6">
                <strong>Price</strong>
                <p class="text-muted mb-0"><?php echo 'Rs. ' . number_format($row['price'], 2, '.', ','); ?></p>
              </div>
              <div class="col-md-3 col-6">
                <strong>Commission</strong>
                <p class="text-muted mb-0"><?php echo $row['commition']; ?></p>
              </div>
            </div>

            <!-- Jewelry Images -->
            <div class="row mb-4">
              <?php
              $jewelryImages = [
                $row['jewelryImg'],
                $row['jewelryImg_1'],
                $row['jewelryImg_2'],
                $row['jewelryImg_3'],
                $row['jewelryImg_4']
              ];
              foreach ($jewelryImages as $img) {
                if (!empty($img)) {
                  echo '
                    <div class="col-md-4 col-6 mb-3">
                      <div class="section-title">Jewelry Photo</div>
                      <img src="../' . $img . '" alt="Jewelry Photo" class="img-fluid rounded shadow-sm">
                    </div>';
                }
              }
              ?>
            </div>

            <!-- ID Images -->
            <div class="row mb-4">
              <div class="col-md-6 col-6 mb-3">
                <div class="section-title">ID Photo Front</div>
                <img src="<?php echo '../' . $row['Id_image']; ?>" alt="ID Front" class="img-fluid rounded shadow-sm">
              </div>
              <div class="col-md-6 col-6 mb-3">
                <div class="section-title">ID Photo Back</div>
                <img src="<?php echo '../' . $row['Id_image1']; ?>" alt="ID Back" class="img-fluid rounded shadow-sm">
              </div>
            </div>

            <!-- Receipt Images -->
            <div class="row mb-4">
              <?php
              $receiptImages = [
                $row['receipt_img'],
                $row['receipt_img1'],
                $row['receipt_img2'],
                $row['receipt_img3'],
                $row['receipt_img4']
              ];
              foreach ($receiptImages as $img) {
                if (!empty($img)) {
                  echo '
                    <div class="col-md-4 col-6 mb-3">
                      <div class="section-title">Receipt Photo</div>
                      <img src="../' . $img . '" alt="Receipt Photo" class="img-fluid rounded shadow-sm">
                    </div>';
                }
              }
              ?>
            </div>

            <hr>

            <div class="text-center mt-3">
    <form action="../DbActions/TaskComplete/VerifyCompletion.php" method="post" >
      <input type="hidden" name="completeId" value="<?php echo $row['cid']; ?>">
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-chalkboard-teacher"></i> Verify This Task
      </button>
    </form>
  </div>

  <div class="text-center mt-3">
    <form action="../DbActions/TaskComplete/VerifyCompletionError.php" method="post" >
      <input type="hidden" name="completeId" value="<?php echo $row['cid']; ?>">
      <button type="submit" class="btn btn-danger">
        <i class="fas fa-crosshairs"></i> Need A ReSubmition
      </button>
    </form>
  </div>
          </div>
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

  if ($_SESSION['userCreated'] == 1) {
    echo '<script>
            Swal.fire({
            position: "top-end",
            icon: "success",
            title: "User Created Sucessfully",
            showConfirmButton: false,
            timer: 1500
            });

        </script>';

    $_SESSION['userCreated'] = null;
  }


  ?>



</body>


<!-- index.html  21 Nov 2019 03:47:04 GMT -->

</html>