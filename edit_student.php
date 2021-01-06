<?php 
    session_start();
    include('includes/config.php');
    include('includes/head.inc.php'); 
    date_default_timezone_set('Asia/Phnom_Penh');
    if(!isset($_SESSION['admin'])){
        header('Location: index.php');
    }
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $stmt = $conn->prepare('SELECT * FROM students WHERE studentId = :id');
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            header('Location: manage_students.php');
        }
    }

    if(isset($_POST['updateStudent'])){
        $id = $_POST['id'];
        $fullname = $_POST['fullname'];
        $rollId = $_POST['rollId'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $registered = $_POST['registered'];
        $date = date('Y-m-d');
        $time = date("H:m");
        $datetime = $date."T".$time;
        $sql = 'UPDATE students SET studentName = :studentName,
                rollId = :rollId,
                studentEmail = :email,
                gender = :gender,
                DOB = :dob,
                registered_at = :registered,
                updated_at = :updated 
                WHERE studentId = :id ';
        try{
            $update = $conn->prepare($sql);
            $update->bindParam(':studentName',$fullname);
            $update->bindParam(':rollId',$rollId);
            $update->bindParam(':email',$email);
            $update->bindParam(':gender',$gender);
            $update->bindParam(':dob',$dob);
            $update->bindParam(':registered',$registered);
            $update->bindParam(':updated',$datetime);
            $update->bindParam(':id',$id);
            $update->execute();
            $_SESSION['success'] = 'Student was updated successfully';
            header('Location: manage_students.php');
        }catch(PDOException $e){
            $_SESSION['error'] = 'Student was not updated';
            header('Location: manage_students.php');
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
            <li class="nav-item has-treeview menu-open">
                <a href="#" class="nav-link active ">
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
                <a href="#" class="nav-link ">
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
                <h1 class="m-0 text-dark">Edit a Student</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item"><a href="manage_students.php">Students</a></li>
                <li class="breadcrumb-item active">Edit student</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="container">
        
        <div class="container col-lg-6 student-container bg-light p-4 mb-3">
            <div class="h4">Fill Student Info</div>
            <form class="mt-4" action="edit_student.php" method="POST">
                <div class="form-group row d-flex align-items-center mb-3">
                    <label for="fullname" class="form-label col-lg-2">Fullname:</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control " id="fullname" name="fullname" value="<?php echo $data['studentName'] ?>">
                    </div>
                </div>  
                <div class="form-group row d-flex align-items-center mb-3">
                    <label for="fullname" class="form-label col-lg-2">Roll-ID:</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control " id="id" name="rollId" value="<?php echo $data['rollId'] ?>">
                    </div>
                </div>  
                <div class="form-group row d-flex align-items-center mb-3">
                    <label for="fullname" class="form-label col-lg-2">Email:</label>
                    <div class="col-lg-10">
                        <input type="email" class="form-control " id="email" name="email" value="<?php echo $data['studentEmail'] ?>">
                    </div>
                </div>  
                <div class="form-group row d-flex align-items-center mb-3">
                    <label for="gender" class="form-label col-lg-2">Gender:</label>
                    <div class="col-lg-10">
                        
                        <?php 
                            if($data['gender'] == 'male'){
                                echo "<input type='radio'  id='male' value='male' name='gender' checked>";
                                echo "<label for='male'>Male</label>";
                                echo "<input type='radio' class='ml-2'  id='female' value='female' name='gender'>";
                                echo "<label for='female'>Female</label>";
                            }else{
                                echo "<input type='radio'  id='male' value='male' name='gender'>";
                                echo "<label for='male'>Male</label>";
                                echo "<input type='radio' class='ml-2'  id='female' value='female' name='gender' checked>";
                                echo "<label for='female'>Female</label>";
                            }
                        ?>
                    </div>
                </div>  
                <div class="form-group row d-flex align-items-center mb-3">
                    <label for="dob" class="form-label col-lg-2">DOB:</label>
                    <div class="col-lg-10">
                        <input type="date" class="form-control " id="dob" name="dob" value="<?php echo date("Y-m-d",strtotime($data['DOB'])); ?>">
                    </div>
                </div>  
                <div class="form-group d-flex justify-content-end">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <input type="hidden" name="registered" value="<?php echo $data['registered_at'] ?>">
                    <input class="btn btn-primary" type="submit" name="updateStudent" value="Update">
                </div>
            </form>
        </div>
    </div>
    <?php include('includes/footer.inc.php');  ?>