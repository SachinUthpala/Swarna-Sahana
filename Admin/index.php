<!DOCTYPE html>
<html lang="en">


<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Swarana Sahana Team Member Login</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="AdminPanel/assets/css/app.min.css">
  <link rel="stylesheet" href="AdminPanel/assets/bundles/bootstrap-social/bootstrap-social.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="AdminPanel/assets/css/style.css">
  <link rel="stylesheet" href="AdminPanel/assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="AdminPanel/assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='AdminPanel/assets/img/favicon.ico' />
</head>

<body style="background: linear-gradient(#ffffff69 , #ffffff71) , url(./images/bg-01.jpg);background-size: cover;" >
  

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
session_start();
if (isset($_SESSION['login_error']) && $_SESSION['login_error'] == 1) {
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Credentials',
                text: 'Please check your username and password!',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Try Again'
            });
        });
    </script>
    ";
    unset($_SESSION['login_error']); // Reset after showing
}
?>


<div class="loader"></div>
  <div id="app">
    <section class="section" >
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
				<br>
				<div class="text-center">
					<img src="../assets/images/logo-removebg-preview.png" width="60" height="60" alt="">
				</div>
				<br>
              <div class="card-header">
				
                <h4>Swarna Sahana Team Member Login</h4>
              </div>
              <div class="card-body">
                <form method="post" action="./DbActions/LoginAndSignUp/signIn.php" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                      <div class="float-right">
                        <a href="auth-forgot-password.html" class="text-small">
                          Forgot Password?
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control"  name="pass" tabindex="2" required>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="logIn" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
              
                </div>
              </div>
            </div>
           
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script src="AdminPanel/assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="AdminPanel/assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="AdminPanel/assets/js/custom.js"></script>
</body>


<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->
</html>