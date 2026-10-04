<?php

require_once '../DbActions/Db.conn.php';
session_start();
error_reporting(0);
date_default_timezone_set("Asia/Colombo");

if (!$_SESSION['UserName'] && !$_SESSION['UserId']) {
  header('Location: ../index.html');
  exit();
}

$userId = (int)$_SESSION['UserId'];

$sql = "
SELECT 
    expencess.*, 
    users.UserName 
FROM 
    expencess 
LEFT JOIN 
    users 
ON 
    expencess.user_id = users.UserId
WHERE 
    expencess.user_id = $userId";

$result = mysqli_query($conn, $sql);

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
                          <th>Expencess Type</th>
                          <th>UserName</th>
                          <th>Distance</th>
                          <th>Amount</th>
                          <th>Date</th>
                          <th>Approved</th>
                          <th>Remove</th>
                          <th>Update</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while ($rows = $result->fetch_assoc()) { ?>
                          <tr>
                            <td><?php echo $rows['expencess_type']; ?></td>
                            <td><?php echo $rows['UserName']; ?></td>
                            <td><?php echo $rows['distance']." Km"; ?></td>
                            <td><?php echo "Rs ." . $rows['amount'] . ".00"; ?></td>
                            <td><?php echo $rows['date']; ?></td>
                            <td><?php

                                if ($rows['approved_exp'] == 0) {
                                  echo '<p style="color:orange;font-weight:bold;font-size:14px;">Pending</p>';
                                } else {
                                  echo '<p style="color:green;font-weight:bold;font-size:14px;">Approved</p>';
                                }

                                ?></td>
                            <td
                              <?php
                              if ($rows['approved_exp'] != 0) {
                                echo 'style="display:none"';
                              }
                              ?>>
                              <form id="<?php echo "deleteForm" . $rows['expenxess_id']; ?>" action="../DbActions/expencess/remove.exp.php" method="post">
                                <input type="hidden" name="expID" value="<?php echo $rows['expenxess_id']; ?>">
                                <button type="submit" class="btn btn-danger" id="<?php echo "deletebutton" . $rows['expenxess_id']; ?>">Remove</button>
                              </form>

                              <script>
                                document.getElementById('<?php echo "deletebutton" . $rows['expenxess_id']; ?>').addEventListener('click', function(event) {
                                  event.preventDefault(); // Prevent the form from submitting immediately

                                  Swal.fire({
                                    title: 'Are you sure?',
                                    text: "Do you want to Remove this?",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, Remove it!',
                                    cancelButtonText: 'No, cancel!'
                                  }).then((result) => {
                                    if (result.isConfirmed) {
                                      // If confirmed, submit the form
                                      document.getElementById('<?php echo "deleteForm" . $rows['expenxess_id']; ?>').submit();
                                    }
                                  });
                                });
                              </script>
                            </td>
                            <td <?php if ($rows['approved_exp'] == 0) { ?>>
                              <form id="" action="../DbActions/expencess/.php" method="post">
                                <input type="hidden" name="expId" value="<?php echo $rows['expenxess_id']; ?>">
                                <input type="submit" value="Update" name="Update" class="btn btn-success" id="approveBtn">
                              </form>
                            </td <?php } ?>>
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

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Scripts -->
  <script src="assets/js/app.min.js"></script>
  <script src="assets/bundles/datatables/datatables.min.js"></script>
  <script src="assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/js/page/datatables.js"></script>
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>

</body>

</html>