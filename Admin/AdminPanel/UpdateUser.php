<?php

require_once '../DbActions/Db.conn.php';
session_start();
error_reporting(0);

if(!$_SESSION['UserName'] && !$_SESSION['UserId']){
  header('Location: ../index.html');
}


$TotalUsers = "SELECT * FROM users WHERE `AdminAccess` != 2";
$result_total = $conn->query($TotalUsers);
$AllUsers = $result_total->num_rows ; 

$sql_admin = "SELECT * FROM users WHERE `AdminAccess` = 1";
$result_admin = $conn->query($sql_admin);
$adminUsers = $result_admin->num_rows ; 

$sql_nonAdmin = "SELECT * FROM users WHERE `AdminAccess` = 1";
$result_nonAdmin = $conn->query($sql_nonAdmin);
$nonadminUsers = $result_nonAdmin->num_rows ; 

$n = 1;

$TaskCreatorsQuery = "SELECT * FROM users WHERE `AdminAccess` = 2";
$result_task_creators = $conn->query($TaskCreatorsQuery);
$c_n = 1;

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

          </div>
        
          <!-- user create form -->
          <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>All Users Without Task Creators</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                        <tr>
                            <th class="text-center">
                              #
                            </th>
                            <th>User Name</th>
                            <th>User Mail</th>
                            <th>User Img</th>
                            <th>Verfied Status</th>
                            <th>Admin Status</th>
                            <th>Promotion Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>

                        <?php while($rows = $result_total-> fetch_assoc()){ ?>
                          <tr>
                            <td>
                              <?php echo $n; ?>
                            </td>
                            <td><?php echo $rows['UserName']; ?></td>
                            <td><?php echo $rows['UserMail']; ?></td>
                            <td>
                              <img alt="image" src="<?php echo $rows['userImage']; ?>" width="35">
                            </td>
                            <td >
                                <?php
                                    if((int)$rows['idVerification'] === 1){
                                        echo "<p style='color:green;font-weight:bold;'>Verified</p>";

                                    }else{
                                        echo "<p style='color:red;font-weight:bold;'>Not Verified</p>";
                                    }
                                ?>
                            </td>
                            <td>
                                    
                            <?php
                                    if((int)$rows['AdminAccess'] === 1){
                                        echo "<p style='color:green;font-weight:bold;'>Admin</p>";

                                    }else if((int)$rows['AdminAccess'] === 2) {
                                        echo "<p style='color:blue;font-weight:bold;'>Task Creator</p>";
                                    }else{
                                      echo "<p style='color:red;font-weight:bold;'>Team Member</p>";
                                    }
                                ?>
                            </td>

                            <td>
                                    
                            <?php
                                    if((int)$rows['promotionLevel'] === 0){
                                        echo "<p style='color:red;font-weight:bold;'>Probation</p>";

                                    }else if((int)$rows['promotionLevel'] === 1) {
                                        echo "<p style='color:blue;font-weight:bold;'>Confirmed</p>";
                                    }else if((int)$rows['promotionLevel'] === 2) {
                                      echo "<p style='color:green;font-weight:bold;'>Manager</p>";
                                    }
                                ?>
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm update-btn"
                                    data-userid="<?php echo $rows['UserId']; ?>"
                                    data-username="<?php echo $rows['UserName']; ?>"
                                    data-usermail="<?php echo $rows['UserMail']; ?>"
                                    data-idver="<?php echo $rows['idVerification']; ?>"
                                    data-admin="<?php echo $rows['AdminAccess']; ?>"
                                    data-promo="<?php echo $rows['promotionLevel']; ?>">
                                    Update
                                </button>
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
          
          <!-- task creator table -->
          <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Task Creators</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-2">
                        <thead>
                        <tr>
                            <th class="text-center">
                              #
                            </th>
                            <th>User Name</th>
                            <th>User Mail</th>
                            <th>User Img</th>
                            <th>Verfied Status</th>
                            <th>Admin Status</th>
                            <th>Promotion Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>

                        <?php while($rows_c = $result_task_creators-> fetch_assoc()){ ?>
                          <tr>
                            <td>
                              <?php echo $c_n; ?>
                            </td>
                            <td><?php echo $rows_c['UserName']; ?></td>
                            <td><?php echo $rows_c['UserMail']; ?></td>
                            <td>
                              <img alt="image" src="<?php echo $rows_c['userImage']; ?>" width="35">
                            </td>
                            <td >
                                <?php
                                    if((int)$rows_c['idVerification'] === 1){
                                        echo "<p style='color:green;font-weight:bold;'>Verified</p>";

                                    }else{
                                        echo "<p style='color:red;font-weight:bold;'>Not Verified</p>";
                                    }
                                ?>
                            </td>
                            <td>
                                    
                            <?php
                                    if((int)$rows_c['AdminAccess'] === 1){
                                        echo "<p style='color:green;font-weight:bold;'>Admin</p>";

                                    }else if((int)$rows_c['AdminAccess'] === 2) {
                                        echo "<p style='color:blue;font-weight:bold;'>Task Creator</p>";
                                    }else{
                                      echo "<p style='color:red;font-weight:bold;'>Team Member</p>";
                                    }
                                ?>
                            </td>

                            <td>
                                    
                            <?php
                                    if((int)$rows_c['promotionLevel'] === 0){
                                        echo "<p style='color:red;font-weight:bold;'>Task Creator</p>";

                                    }else if((int)$rows_c['promotionLevel'] === 1) {
                                        echo "<p style='color:blue;font-weight:bold;'>Task Creator level one</p>";
                                    }else if((int)$rows_c['promotionLevel'] === 2) {
                                      echo "<p style='color:green;font-weight:bold;'>Team Leader</p>";
                                    }else if((int)$rows_c['promotionLevel'] === 3) {
                                      echo "<p style='color:green;font-weight:bold;'>Manager Level One</p>";
                                    }else if((int)$rows_c['promotionLevel'] === 4) {
                                      echo "<p style='color:green;font-weight:bold;'>Manager Level Two</p>";
                                    }else if((int)$rows_c['promotionLevel'] === 5) {
                                      echo "<p style='color:green;font-weight:bold;'>Manager Level Three</p>";
                                    }else if((int)$rows_c['promotionLevel'] === 6) {
                                      echo "<p style='color:green;font-weight:bold;'>Manager Level Four</p>";
                                    }
                                ?>
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm update-btn"
                                    data-userid="<?php echo $rows_c['UserId']; ?>"
                                    data-username="<?php echo $rows_c['UserName']; ?>"
                                    data-usermail="<?php echo $rows_c['UserMail']; ?>"
                                    data-idver="<?php echo $rows_c['idVerification']; ?>"
                                    data-admin="<?php echo $rows_c['AdminAccess']; ?>"
                                    data-promo="<?php echo $rows_c['promotionLevel']; ?>">
                                    Update
                                </button>
                            </td>
                            
                           
                          </tr>
                          <?php 
                            $c_n++;
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

if($_SESSION['userUpdated'] == 1){
    echo '<script>
            Swal.fire({
            position: "top-end",
            icon: "success",
            title: "User Updated Sucessfully",
            showConfirmButton: false,
            timer: 1500
            });

        </script>' ;

        $_SESSION['userUpdated'] = null;
}
    ?>

  <!-- Update User Modal (for regular users) -->
  <div class="modal fade" id="updateUserModal" tabindex="-1" role="dialog" aria-labelledby="updateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="../DbActions/UserFunctions/updateUserDetails.php" method="POST">
          <div class="modal-header">
            <h5 class="modal-title" id="updateUserModalLabel">Update User Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="update_userid" id="update_userid">
            
            <div class="form-group">
              <label>User Name</label>
              <input type="text" class="form-control" name="update_username" id="update_username" required>
            </div>
            
            <div class="form-group">
              <label>User Mail</label>
              <input type="email" class="form-control" name="update_usermail" id="update_usermail" required>
            </div>
            
            <div class="form-group">
              <label>Verified Status</label>
              <select class="form-control" name="update_idver" id="update_idver">
                <option value="1">Verified</option>
                <option value="0">Not Verified</option>
              </select>
            </div>
            
            <div class="form-group">
              <label>Admin Status</label>
              <select class="form-control" name="update_admin" id="update_admin">
                <option value="1">Admin</option>
                <option value="2">Task Creator</option>
                <option value="0">Team Member</option>
              </select>
            </div>
            
            <div class="form-group">
              <label>Promotion Status</label>
              <select class="form-control" name="update_promo" id="update_promo">
                <option value="0">Probation</option>
                <option value="1">Confirmed</option>
                <option value="2">Manager</option>
              </select>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <!-- Update Task Creator Modal (for task creators) -->
  <div class="modal fade" id="updateTaskCreatorModal" tabindex="-1" role="dialog" aria-labelledby="updateTaskCreatorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="../DbActions/UserFunctions/updateUserDetails.php" method="POST">
          <div class="modal-header">
            <h5 class="modal-title" id="updateTaskCreatorModalLabel">Update Task Creator Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="update_userid" id="update_userid_tc">
            
            <div class="form-group">
              <label>User Name</label>
              <input type="text" class="form-control" name="update_username" id="update_username_tc" required>
            </div>
            
            <div class="form-group">
              <label>User Mail</label>
              <input type="email" class="form-control" name="update_usermail" id="update_usermail_tc" required>
            </div>
            
            <div class="form-group">
              <label>Verified Status</label>
              <select class="form-control" name="update_idver" id="update_idver_tc">
                <option value="1">Verified</option>
                <option value="0">Not Verified</option>
              </select>
            </div>
            
            <div class="form-group">
              <label>Admin Status</label>
              <select class="form-control" name="update_admin" id="update_admin_tc">
                <option value="1">Admin</option>
                <option value="2">Task Creator</option>
                <option value="0">Team Member</option>
              </select>
            </div>
            
            <div class="form-group">
              <label>Promotion Status</label>
              <select class="form-control" name="update_promo" id="update_promo_tc">
                <option value="0">Task Creator</option>
                <option value="1">Task Creator Level One</option>
                <option value="2">Team Leader</option>
                <option value="3">Manager Level One (Intensitive : Rs 500 /=)</option>
                <option value="4">Manager Level Two (Intensitive : Rs 1000 /=)</option>
                <option value="5">Manager Level Three (Intensitive : Rs 1500 /=)</option>
                <option value="6">Manager Level Four (Intensitive : Rs 2000 /=)</option>
              </select>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
  $(document).ready(function() {
    // Handle update button clicks for regular users (table-1)
    $('#table-1 tbody').on('click', '.update-btn', function() {
      var userId = $(this).data('userid');
      var userName = $(this).data('username');
      var userMail = $(this).data('usermail');
      var idVer = $(this).data('idver');
      var adminAccess = $(this).data('admin');
      var promoLevel = $(this).data('promo');
      
      $('#update_userid').val(userId);
      $('#update_username').val(userName);
      $('#update_usermail').val(userMail);
      $('#update_idver').val(idVer);
      $('#update_admin').val(adminAccess);
      $('#update_promo').val(promoLevel);
      
      $('#updateUserModal').modal('show');
    });

    // Handle update button clicks for task creators (table-2)
    $('#table-2 tbody').on('click', '.update-btn', function() {
      var userId = $(this).data('userid');
      var userName = $(this).data('username');
      var userMail = $(this).data('usermail');
      var idVer = $(this).data('idver');
      var adminAccess = $(this).data('admin');
      var promoLevel = $(this).data('promo');
      
      $('#update_userid_tc').val(userId);
      $('#update_username_tc').val(userName);
      $('#update_usermail_tc').val(userMail);
      $('#update_idver_tc').val(idVer);
      $('#update_admin_tc').val(adminAccess);
      $('#update_promo_tc').val(promoLevel);
      
      $('#updateTaskCreatorModal').modal('show');
    });
  });
  </script>

</body>


<!-- index.html  21 Nov 2019 03:47:04 GMT -->
</html>