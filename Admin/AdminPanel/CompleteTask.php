<?php


require_once '../DbActions/Db.conn.php';
session_start();
error_reporting(0);
date_default_timezone_set("Asia/Colombo");

if(!$_SESSION['UserName'] && !$_SESSION['UserId']){
  header('Location: ../index.html');
}

if(isset($_POST['complete'])){
    $taskId = $_POST['task_id'];
}else{
    header('Location: ../index.html');
}

$UserNames = $_SESSION['UserName'];




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

          <!-- user create form -->
          <div class="card">
                  <div class="card-header">
                    <h4>Complete Task</h4>
                  </div>
                  <form action="../DbActions/TaskComplete/completeTask.php" enctype="multipart/form-data" method="post">
                  <div class="card-body">
                    <div class="form-row">

                    <input type="hidden" class="form-control"  name="taskId" value="<?php echo $taskId; ?>">

                    <div class="form-group col-md-6">
                        <label for="inputEmail4">ID Number</label>
                        <input type="text" class="form-control"  name="ID_Number" placeholder="ID Number">
                      </div>

                      <div class="form-group col-md-6">
                        <label for="inputEmail4">Weight</label>
                        <input type="text" class="form-control"  name="weight" placeholder="Weight">
                      </div>

                      <div class="form-group col-md-6">
                        <label for="inputEmail4">Price</label>
                        <input type="text" class="form-control"  name="price" placeholder="price">
                      </div>

                      <div class="form-group col-md-6">
                        <label for="inputEmail4">Date</label>
                        <input type="date" class="form-control"  name="date" placeholder="date" value="<?php echo date('Y-m-d'); ?>">
                      </div>

                      <div class="form-group col-md-6">
                        <label for="inputEmail4">Time</label>
                        <input type="time" class="form-control"  name="time" placeholder="date" value="<?php echo date('H:i:s'); ?>">
                      </div>

                      <div class="form-group col-md-6">
                        <label for="inputEmail4">Jewelry Image 1</label>
                        <input type="file" class="form-control"  name="jewelry" placeholder="jewelry">
                      </div>

                      <div class="form-group col-md-6">
                        <label for="inputEmail4">Jewelry Image 2</label>
                        <label for="inputEmail4">Jewelry Image</label>

                        <input type="file" class="form-control"  name="jewelry1" placeholder="jewelry">
                      </div>

                      <div class="form-group col-md-6">

                        <label for="inputEmail4">Jewelry Image 3</label>

                        <label for="inputEmail4">Jewelry Image</label>

                        <input type="file" class="form-control"  name="jewelry2" placeholder="jewelry">
                      </div>

                      <div class="form-group col-md-6">

                        <label for="inputEmail4">Jewelry Image 4</label>

                        <label for="inputEmail4">Jewelry Image</label>

                        <input type="file" class="form-control"  name="jewelry3" placeholder="jewelry">
                      </div>

                      <div class="form-group col-md-6">

                        <label for="inputEmail4">Jewelry Image 5</label>

                        <label for="inputEmail4">Jewelry Image</label>

                        <input type="file" class="form-control"  name="jewelry4" placeholder="jewelry">
                      </div>


                      <div class="form-group col-md-6">
                        <label for="inputEmail4">ID Image Front</label>
                        <input type="file" class="form-control"  name="id_image" placeholder="ID Image">
                      </div>

                      <div class="form-group col-md-6">
                        <label for="inputEmail4">ID Image Back</label>
                        <input type="file" class="form-control"  name="id_image1" placeholder="ID Image">
                      </div>

                      <div class="form-group col-md-6">
                        <label for="inputEmail4">Recipt Image 1</label>
                        <label for="inputEmail4">Recipt Image</label>
                        <input type="file" class="form-control"  name="recipt_image" placeholder="Recipt Image">
                      </div>
                      
                      <div class="form-group col-md-6">
                        <label for="inputEmail4">Recipt Image 2</label>
                        <input type="file" class="form-control"  name="recipt_image1" placeholder="Recipt Image">
                      </div>
                      
                      <div class="form-group col-md-6">
                        <label for="inputEmail4">Recipt Image 3</label>
                        <input type="file" class="form-control"  name="recipt_image2" placeholder="Recipt Image">
                      </div>
                      
                      <div class="form-group col-md-6">
                        <label for="inputEmail4">Recipt Image 4</label>
                        <input type="file" class="form-control"  name="recipt_image3" placeholder="Recipt Image">
                      </div>
                      
                      <div class="form-group col-md-6">
                        <label for="inputEmail4">Recipt Image 5</label>
                        <input type="file" class="form-control"  name="recipt_image4" placeholder="Recipt Image">
                      </div>

                      <div class="form-group col-md-6">
                        <label for="inputEmail4">Completed By</label>
                        <input type="text" class="form-control"  name="completedBy" value="<?php echo $UserNames; ?>"">
                      </div>

                    </div>
                    <div class="form-group mb-0">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck">
                        <label class="form-check-label" for="gridCheck">
                          I will agree with conditions
                        </label>
                      </div>
                    </div>
                    <input type="hidden" name="userName" value="<?php echo $_SESSION['UserName']; ?>">
                  </div>
                  <div class="card-footer">
                    <button class="btn btn-primary " name="completeTask" id="submitBtn">Submit</button>
                    <button class="btn disabled btn-primary btn-progress" name="completeTask" id="progressBtn" style="display: none;">Progress</button>
                  </div>
                  </form>
                </div>
                
                
          <script>
            document.getElementById('submitBtn').addEventListener('click', function() {
              this.style.display = 'none'; // Hide Submit button
              document.getElementById('progressBtn').style.display = 'inline-block'; // Show Progress button
            });
          </script>
          
        
          
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

  <?php

if($_SESSION['TaskCreated'] == 1){
    echo '<script>
            Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Task Created Sucessfully",
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