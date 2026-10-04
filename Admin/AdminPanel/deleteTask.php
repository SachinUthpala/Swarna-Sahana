<?php

require_once '../DbActions/Db.conn.php';
session_start();
error_reporting(0);

if(!$_SESSION['UserName'] && !$_SESSION['UserId']){
  header('Location: ../index.html');
}


$TotalTask = "SELECT * FROM task";
$result_total = $conn->query($TotalTask);
$AllTasks = $result_total->num_rows ; 

$sql_onGoing = "SELECT * FROM task WHERE `completion` = 0";
$result_ongoing = $conn->query($sql_onGoing);
$allOngoing = $result_ongoing->num_rows ; 

$sql_completed = "SELECT * FROM task WHERE `completion` = 2";
$result_completed = $conn->query($sql_completed);
$allCompleted = $result_completed->num_rows ; 

$n = 1;

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

          <div class="row ">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">All Users</h5>
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
        
          <!-- user create form -->
          <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Delete Task</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                        <tr>
                            <th class="text-center">
                              #
                            </th>
                            <th>Inquery Number</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Customer Name</th>
                            <th>Phone</th>
                            <th>Bank</th>
                            <th>Price</th>
                            <th>Delete</th>
                            <th>Update</th>
                          </tr>
                        </thead>
                        <tbody>

                        <?php while($rows = $result_total-> fetch_assoc()){ ?>
                          <tr>
                            <td>
                              <?php echo $n; ?>
                            </td>
                            <td><?php echo $rows['inqueryNumber']; ?></td>
                            <td><?php echo $rows['date']; ?></td>
                            <td><?php echo $rows['time']; ?></td>
                            <td><?php echo $rows['customerName']; ?></td>
                            <td><?php echo $rows['Phone']; ?></td>
                            <td><?php echo $rows['bank_shop']; ?></td>
                            <td><?php echo $rows['enterPrice']; ?></td>
                            <td
                            
                            <?php
                             if($rows['completion'] == 0){
                              echo 'style="display:block;"';
                             }else{
                              echo 'style="display:none;"';
                             }
                            ?>

                            >
                                <form id="<?php echo "deleteForm".$rows['task_id']; ?>" action="../DbActions/Tasks/deleteTask.php" method="post">
                                    <input type="hidden" name="delete_id" value="<?php echo $rows['task_id']; ?>">
                                    <button type="submit" name="delete" class="btn btn-danger" id="<?php echo "deletebutton".$rows['task_id']; ?>">Delete</button>
                               </form>

                               <script>
                                    document.getElementById('<?php echo "deletebutton".$rows['task_id']; ?>').addEventListener('click', function(event) {
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
                                                document.getElementById('<?php echo "deleteForm".$rows['task_id']; ?>').submit();
                                            }
                                        });
                                    });
                                </script>
                            </td>

                            <td
                            
                            <?php
                             if($rows['completion'] == 0){
                              echo 'style="display:none;"';
                             }else{
                              echo 'style="display:block;"';
                             }
                            ?>

                            >
                                <form action="" method="post">
                                    <input type="hidden" name="delete_id" value="<?php echo $rows['task_id']; ?>">
                                    <button type="submit" name="delete" class="btn btn-danger" disabled>Delete</button>
                               </form>
                            </td>
                            
                            <td>
                                <form action="./updateOngoing.php" method="post">
                                    <input type="hidden" name="delete_id" value="<?php echo $rows['task_id']; ?>">
                                    <button type="submit" name="Update" class="btn btn-danger"
                                    
                                    <?php
                             if($rows['completion'] == 0){
                              echo '';
                             }else{
                              echo 'disabled';
                             }
                            ?>
                                    
                                    >Update</button>
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

if($_SESSION['taskDeleted'] == 1){
    echo '<script>
            Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Task Deleted Sucessfully",
            showConfirmButton: false,
            timer: 1500
            });

        </script>' ;

        $_SESSION['taskDeleted'] = null;
}


    ?>



</body>


<!-- index.html  21 Nov 2019 03:47:04 GMT -->
</html>