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
        $stmt = $conn->prepare('SELECT * FROM classes_has_subjects WHERE id = :id');
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            header('Location: manage_combine.php');
        }
    }

    if(isset($_POST['editCombine'])){
        $id = $_POST['id'];
        $class = $_POST['class'];
        $subject = $_POST['subject'];
        $date = date('Y-m-d');
        $time = date("H:m");
        $datetime = $date."T".$time;
        $sql = 'UPDATE classes_has_subjects SET class_id = :class,
                subject_id = :subject,
                updated_at = :updated_at
                WHERE id = :id';
        try{
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':class',$class);
            $stmt->bindParam(':subject',$subject);
            $stmt->bindParam(':updated_at',$datetime);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            $_SESSION['success'] = 'Class Combine Subject was updated successfully';
            header('Location: manage_combine.php');
        }catch(PDOException $e){
            $_SESSION['error'] = 'Class Combine Subject was not updated';
            header('Location: manage_combine.php');
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
            <li class="nav-item has-treeview menu-open">
                <a href="#" class="nav-link active">
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
                <a href="change_password.php" class="nav-link">
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
                <li class="breadcrumb-item"><a href="manage_combine.php">Subjects and Classes</a></li>
                <li class="breadcrumb-item active">Edit Subjects and Classes</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
<div class="container">
    <div class="container col-lg-6 student-container bg-light p-4 mb-3">
        <div class="h4">Edit Class and Subject</div>
        <form class="mt-4" action="edit_combine.php" method="POST">
            <div class="form-group row d-flex align-items-center mb-3">
                <label for="class" class="form-label col-lg-2">Class:</label>
                <div class="col-lg-10">
                    <select class="form-select" id="class" name="class">
                        <option selected hidden disabled="disabled">Class</option>
                        <?php
                            $stmt = $conn->query("SELECT * FROM classes");
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                if($row['id'] === $data['class_id']){
                                    echo "<option value=".$row['id']." selected>".$row['className'].'-'.$row['section']."</option>";
                                }else{
                                    echo "<option value=".$row['id'].">".$row['className'].'-'.$row['section']."</option>";
                                }
                                
                            }
                        ?>
                    </select>
                </div>
            </div> 
            <div class="form-group row d-flex align-items-center mb-3">
                <label for="class" class="form-label col-lg-2">Subject:</label>
                <div class="col-lg-10">
                    <select class="form-select" id="subject" name="subject">
                        <?php
                            $stmt = $conn->query("SELECT * FROM subjects");
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                if($row['subjectId'] === $data['subject_id']){
                                    echo "<option value=".$row['subjectId']." selected>".$row['subjectName']."</option>";
                                }else{
                                    echo "<option value=".$row['subjectId'].">".$row['subjectName']."</option>";
                                }
                                
                            }
                        ?>
                    </select>
                </div>    
            </div> 
            <div class="form-group d-flex justify-content-between">
                <a class="btn btn-primary" href="manage_combine.php">Back</a>
                <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                <input class="btn btn-primary" type="submit" name="editCombine" value="Update">
            </div>
        </form>
    </div>
</div>

<?php include('includes/footer.inc.php');  ?>