<?php
  $current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg main-navbar sticky">
  <div class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn"> 
        <i data-feather="align-justify"></i></a></li>
      <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
        <i data-feather="maximize"></i></a></li>
      <li>
        <form class="form-inline mr-auto">
          <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
          </div>
        </form>
      </li>
    </ul>
  </div>

  <ul class="navbar-nav navbar-right">
    <li class="dropdown">
      <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="<?php echo $_SESSION['userImage']; ?>" class="user-img-radious-style"> 
        <span class="d-sm-none d-lg-inline-block"></span>
      </a>
      <div class="dropdown-menu dropdown-menu-right pullDown">
        <div class="dropdown-title">Hello <?php echo $_SESSION['UserName']; ?></div>
        
        <div class="dropdown-divider"></div>
        <a href="../DbActions/logOut/logout.php" class="dropdown-item has-icon text-danger">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </div>
    </li>
  </ul>
</nav>

<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="admin.php">
      <img src="../../assets/images/logo-removebg-preview.png" alt="" width="45px" height="45px">  
      <span class="logo-name" style="color: #ff9900 !important;">
        Admin Panel
      </span></a>
    </div>

    <ul class="sidebar-menu">
      <li class="menu-header">Main</li>

      <!-- Dashboard -->
      <li class="dropdown <?php echo ($current_page == 'admin.php') ? 'active' : ''; ?>">
        <a href="admin.php" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
      </li>

      <!-- My Tasks -->
      <li class="dropdown <?php echo in_array($current_page, ['MyAllTask.php','myCompletedTasks.php','myOngoing.php' , 'MyResubmitions.php' , 'myVerifyingtasks.php']) ? 'active' : ''; ?>"
        <?php if($_SESSION['AdminAccess'] == 2) echo 'style="display:none;"'; ?>>
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="briefcase"></i><span>My Tasks</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link <?php echo ($current_page == 'MyAllTask.php') ? 'active' : ''; ?>" href="./MyAllTask.php">All Tasks</a></li>
          <li><a class="nav-link <?php echo ($current_page == 'myCompletedTasks.php') ? 'active' : ''; ?>" href="./myCompletedTasks.php">Completed Tasks</a></li>
          <li><a class="nav-link <?php echo ($current_page == 'myOngoing.php') ? 'active' : ''; ?>" href="./myOngoing.php">On Going Task</a></li>
          <li><a class="nav-link <?php echo ($current_page == 'myVerifyingtasks.php') ? 'active' : ''; ?>" href="./myVerifyingtasks.php">My Verify Ongoing</a></li>
          <li><a class="nav-link <?php echo ($current_page == 'MyResubmitions.php') ? 'active' : ''; ?>" href="./MyResubmitions.php">ReSubmitions</a></li>
        </ul>
      </li>

      <!-- Expenses -->
      <li class="dropdown <?php echo in_array($current_page, ['CreateExpencess.php','MyallExpencess.php','MyRejected.php']) ? 'active' : ''; ?>">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Expenses</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link <?php echo ($current_page == 'CreateExpencess.php') ? 'active' : ''; ?>" href="./CreateExpencess.php">Your Expenses</a></li>
          <li><a class="nav-link <?php echo ($current_page == 'MyallExpencess.php') ? 'active' : ''; ?>" href="./MyallExpencess.php">My All Expenses</a></li>
          <li><a class="nav-link <?php echo ($current_page == 'MyRejected.php') ? 'active' : ''; ?>" href="./MyRejected.php">My Rejected Expenses</a></li>
        </ul>
      </li>

      <!-- Commotions -->
      <li class="dropdown <?php echo in_array($current_page, ['MyPendingComitions.php','myAllCommitions.php']) ? 'active' : ''; ?>">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Commotions</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link <?php echo ($current_page == 'myAllCommitions.php') ? 'active' : ''; ?>" href="./myAllCommitions.php">My All Commotions</a></li>
          <li><a class="nav-link <?php echo ($current_page == 'MyPendingComitions.php') ? 'active' : ''; ?>" href="./MyPendingComitions.php">Pending Commitions</a></li>
        </ul>
      </li>

      <!-- Task Functions -->
      <li class="menu-header" <?php if($_SESSION['AdminAccess'] == 0) echo 'style="display:none;"'; ?>>Task Functions</li>

      <li class="dropdown <?php echo in_array($current_page, ['createTask.php','deleteTask.php']) ? 'active' : ''; ?>"
        <?php if($_SESSION['AdminAccess'] == 0) echo 'style="display:none;"'; ?>>
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="copy"></i><span>Main Functions</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link <?php echo ($current_page == 'createTask.php') ? 'active' : ''; ?>" href="./createTask.php">Create Task</a></li>
          <li><a class="nav-link <?php echo ($current_page == 'deleteTask.php') ? 'active' : ''; ?>" href="./deleteTask.php">Delete Task</a></li>
        </ul>
      </li>

      <!-- All Tasks -->
      <li class="dropdown <?php echo in_array($current_page, ['AllTasks.php','allOngoingTask.php' ,'AllVerifyPending.php','allCompletedTask.php']) ? 'active' : ''; ?>"
        <?php if($_SESSION['AdminAccess'] == 0) echo 'style="display:none;"'; ?>>
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="shopping-bag"></i><span>All Tasks</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link <?php echo ($current_page == 'AllTasks.php') ? 'active' : ''; ?>" href="./AllTasks.php">All Tasks</a></li>
          <li><a class="nav-link <?php echo ($current_page == 'allOngoingTask.php') ? 'active' : ''; ?>" href="./allOngoingTask.php">On Going Task</a></li>
          <li><a class="nav-link <?php echo ($current_page == 'AllVerifyPending.php') ? 'active' : ''; ?>" href="./AllVerifyPending.php">Verify Pending</a></li>
          <li><a class="nav-link <?php echo ($current_page == 'allCompletedTask.php') ? 'active' : ''; ?>" href="./allCompletedTask.php">Completed Tasks</a></li>
        </ul>
      </li>

      <!-- User Functions -->
      <li class="menu-header" <?php if($_SESSION['AdminAccess'] == 2 || $_SESSION['AdminAccess'] == 0) echo 'style="display:none;"'; ?>>User Functions</li>

      <li class="dropdown <?php echo in_array($current_page, ['createUser.php','DeleteUser.php']) ? 'active' : ''; ?>"
        <?php if($_SESSION['AdminAccess'] == 2 || $_SESSION['AdminAccess'] == 0) echo 'style="display:none;"'; ?>>
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="copy"></i><span>Main Functions</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link <?php echo ($current_page == 'createUser.php') ? 'active' : ''; ?>" href="./createUser.php">Create User</a></li>
          <li><a class="nav-link" <?php echo ($current_page == 'UpdateUser.php') ? 'active' : ''; ?>" href="./UpdateUser.php" >Update User</a></li>
          <li><a class="nav-link <?php echo ($current_page == 'DeleteUser.php') ? 'active' : ''; ?>" href="./DeleteUser.php">Delete User</a></li>
        </ul>
      </li>
      
       <li class="dropdown <?php echo in_array($current_page, ['allUsers.php','adminUsers.php','nonAdminUsers.php']) ? 'active' : ''; ?>"
        <?php if($_SESSION['AdminAccess'] == 2 || $_SESSION['AdminAccess'] == 0) echo 'style="display:none;"'; ?>>
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="copy"></i><span>All Users</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link <?php echo ($current_page == 'allUsers.php') ? 'active' : ''; ?>" href="./allUsers.php">All Users</a></li>
          <li><a class="nav-link <?php echo ($current_page == 'adminUsers.php') ? 'active' : ''; ?>" href="./adminUsers.php">Admin Users</a></li>
          <li><a class="nav-link <?php echo ($current_page == 'nonAdminUsers.php') ? 'active' : ''; ?>" href="./nonAdminUsers.php">Non Admin Users</a></li>
        </ul>
      </li>


      <li class="menu-header"
            <?php
                if( $_SESSION['AdminAccess'] == 0 ) {
                  echo 'style="display:none;"';
                }
              ?>
            >Expensess & Commitions</li>

            <li class="dropdown"
            <?php
                if( $_SESSION['AdminAccess'] == 0) {
                  echo 'style="display:none;"';
                }
              ?>
            >
              <a href="#" class="menu-toggle nav-link has-dropdown"
             
              ><i data-feather="copy"></i><span> All Expencess</span></a>
              <ul class="dropdown-menu"
             
              >
                <li><a class="nav-link" href="./ExpencessSummery.php">Expencess Summery</a></li>
                <li><a class="nav-link" href="./AllExpencess.php">All Expencess</a></li>
              </ul>
            </li>
            
            
            <li class="dropdown"
            <?php
                if( $_SESSION['AdminAccess'] == 0) {
                  echo 'style="display:none;"';
                }
              ?>
            >
              <a href="#" class="menu-toggle nav-link has-dropdown"
             
              ><i data-feather="copy"></i><span> All Commitions</span></a>
              <ul class="dropdown-menu"
             
              >
                <li><a class="nav-link" href="./AllCommitions.php">Commition Summary</a></li>
                <li><a class="nav-link" href="./taskCreatorCommition.php">Task Creator Commition</a></li>
              </ul>
            </li>

      <!-- All Users -->
     

       <li class="menu-header"
            <?php
                if( $_SESSION['AdminAccess'] == 0 ) {
                  echo 'style="display:none;"';
                }
              ?>
            >Summary Settings (Daily)</li>
             <!-- end of summery settings -->
             <li class="dropdown"
            <?php
                if($_SESSION['AdminAccess'] == 2 || $_SESSION['AdminAccess'] == 0) {
                  echo 'style="display:none;"';
                }
              ?>
            >
              <a href="#" class="menu-toggle nav-link has-dropdown"
             
              ><i data-feather="copy"></i><span> Summary (Daily Buisness)</span></a>
              <ul class="dropdown-menu"
             
              >
                <li><a class="nav-link" href="./CreateDailyBuisness.php" style="cursor: pointer;">Add Daily Buisness</a></li>
                <li><a class="nav-link" href="./AllDailyBuisness.php" style="cursor: pointer;">All Daily Buisness</a></li>
              </ul>
            </li>

            <li class="dropdown"
            <?php
                if($_SESSION['AdminAccess'] == 0) {
                  echo 'style="display:none;"';
                }
              ?>
            >
              <a href="#" class="menu-toggle nav-link has-dropdown"
             
              ><i data-feather="copy"></i><span>Other Cost (Daily)</span></a>
              <ul class="dropdown-menu"
             
              >
                <li><a class="nav-link" href="./createDailyOtherCost.php" style="cursor: pointer;">Add Other Cost</a></li>
                <li><a class="nav-link" href="./AllDailyOtherCost.php" style="cursor: pointer;">All Other Costs</a></li>
              </ul>
            </li>

            <li class="dropdown"
            <?php
                if($_SESSION['AdminAccess'] == 0) {
                  echo 'style="display:none;"';
                }
              ?>
            >
              <a href="#" class="menu-toggle nav-link has-dropdown"
             
              ><i data-feather="copy"></i><span>Board Camping (Daily)</span></a>
              <ul class="dropdown-menu"
             
              >
                <li><a class="nav-link" href="./CreateDailyBoardCamping.php" style="cursor: pointer;">Add Board Cost</a></li>
                <li><a class="nav-link" href="./AllDailyBoardCampingCost.php" style="cursor: pointer;">All Board Costs</a></li>
                <li><a class="nav-link" href="./campinglocations.php" style="cursor: pointer;">Camping Locations</a></li>
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
             
              ><i data-feather="copy"></i><span> Reports </span></a>
              <ul class="dropdown-menu"
             
              >
                <li><a class="nav-link" href="./DailyReport.php" style="cursor: pointer;">Daily Report</a></li>
                <li><a class="nav-link" href="./MonthlyReport.php" style="cursor: pointer;">Monthly Report</a></li>
              </ul>
            </li>

      <!-- Advance Settings -->
      <li class="menu-header" <?php if($_SESSION['AdminAccess'] == 0 || $_SESSION['AdminAccess'] == 2) echo 'style="display:none;"'; ?>>Advance Settings</li>

      <li class="dropdown" <?php if($_SESSION['AdminAccess'] == 0 || $_SESSION['AdminAccess'] == 2) echo 'style="display:none;"'; ?>>
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="copy"></i><span>Advance Settings</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" onclick="ClearExp()" style="cursor:pointer;">Clear Expenses</a></li>
          <li><a class="nav-link" onclick="ClearCommi()" style="cursor:pointer;">Clear Commissions</a></li>
        </ul>
      </li>
    </ul>
  </aside>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
async function ClearExp(){
  const { value: password } = await Swal.fire({
    title: "Enter your password",
    input: "password",
    inputLabel: "Password",
    inputPlaceholder: "Enter your password"
  });
  if(password === "admin@2024"){
    location.href="../DbActions/Advance/clearExpencess.php";
  } else {
    Swal.fire({ icon:"error", title:"Oops...", text:"Provide correct password!" });
  }
}

async function ClearCommi(){
  const { value: password } = await Swal.fire({
    title: "Enter your password",
    input: "password",
    inputLabel: "Password",
    inputPlaceholder: "Enter your password"
  });
  if(password === "admin@2024"){
    location.href="../DbActions/Advance/clearExpencess.php";
  } else {
    Swal.fire({ icon:"error", title:"Oops...", text:"Provide correct password!" });
  }
}
</script>
