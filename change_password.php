<?php 
    session_start();
    include('includes/config.php');
    include('includes/head.inc.php'); 
    date_default_timezone_set('Asia/Phnom_Penh');
    if(!isset($_SESSION['admin'])){
        header('Location: index.php');
    }
    if(isset($_POST['changePassword'])){
        $id = $_SESSION['admin'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        if($password !== $confirmPassword){
            $_SESSION['passwordNotMatch'] = 'Password don\'t match';
            return;
        }
        $date = date('Y-m-d');
        $time = date("H:m");
        $datetime = $date."T".$time;
        $sql = 'UPDATE admin SET Password = :password WHERE id = :id';
        try{
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':password',$password);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            $_SESSION['success'] = 'Password changed successfully]';
        }catch(PDOException $e){
            $_SESSION['error'] = 'Password changed failed';
        }
    }
?>
<!-- Sidebar -->
<div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                </p>
                </a>
            </li>
            <li class="nav-item has-treeview ">
                <a href="#" class="nav-link  ">
                <i class="nav-icon fa fa-users"></i>
                <p>
                    Students
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="manage_students.php" class="nav-link">
                    <p>Manage Students</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="add_student.php" class="nav-link">
                    <p>Add Student</p>
                    </a>
                </li>
                </ul>
            </li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link ">
                <i class="nav-icon far fa-file-alt"></i>
                <p>
                    Classes
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="manage_classes.php" class="nav-link">
                    <p>Manage Class</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="add_class.php" class="nav-link">
                    <p>Add Class</p>
                    </a>
                </li>
                </ul>
            </li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>
                    Subjects
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="manage_subjects.php" class="nav-link">
                    <p>Manage Subject</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="add_subject.php" class="nav-link">
                    <p>Add Subject</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="manage_combine.php" class="nav-link">
                    <p>Manage Subject with Class</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="add_combine.php" class="nav-link">
                    <p>Add Subject with Class</p>
                    </a>
                </li>
                </ul>
            </li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link ">
                <i class="nav-icon fa fa-info-circle"></i>
                <p>
                    Results
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="manage_results.php" class="nav-link">
                    <p>Manage Result</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="add_result.php" class="nav-link">
                    <p>Add Result</p>
                    </a>
                </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="change_password.php" class="nav-link active">
                <i class="nav-icon fas fa-key"></i>
                <p>
                    Change Password
                </p>
                </a>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Change Password</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <?php 
            if(isset($_SESSION['success'])){
                echo "<div class='bg-success text-center text-white py-3 mb-3 w-50 mx-auto'>".$_SESSION['success']."</div>";
                unset($_SESSION['success']);
            }else if(isset($_SESSION['error'])){
                echo "<div class='bg-danger text-center text-white py-3 mb-3 w-50 mx-auto'>".$_SESSION['error']."</div>";
                unset($_SESSION['error']);
            }else if(isset($_SESSION['passwordNotMatch'])){
                echo "<div class='bg-danger text-center text-white py-3 mb-3 w-50 mx-auto'>".$_SESSION['passwordNotMatch']."</div>";
                unset($_SESSION['passwordNotMatch']);
            }
        ?>
    <div class="container">
        <div class="container col-lg-8 student-container bg-light p-4 mb-3">
            <div class="h4">Change Password</div>
            <form class="mt-4" action="change_password.php" method="POST">
                <div class="form-group row d-flex align-items-center mb-3">
                    <label for="subjectname" class="form-label col-lg-3">New Password:</label>
                    <div class="col-lg-9">
                        <input type="password" class="form-control " id="password" name="password">
                    </div>
                </div>  
                <div class="form-group row d-flex align-items-center mb-3">
                    <label for="subjectCode" class="form-label col-lg-3">Confirm Password:</label>
                    <div class="col-lg-9">
                        <input type="password" class="form-control " id="confirmPassword" name="confirmPassword">
                    </div>
                </div>  
                <div class="form-group d-flex justify-content-end">
                    <input class="btn btn-primary" type="submit" name="changePassword" value="Change">
                </div>
            </form>
        </div>
    </div>
    <?php include('includes/footer.inc.php');  ?>