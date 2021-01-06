<?php 
    session_start();
    include('includes/config.php');
    include('includes/head.inc.php'); 
    date_default_timezone_set('Asia/Phnom_Penh');
    if(!isset($_SESSION['admin'])){
        header('Location: index.php');
    }
    if(isset($_POST['addCombine'])){
        $classId = $_POST['class'];
        $studentId = $_POST['student'];
        $marks = $_POST['marks'];
        $date = date('Y-m-d');
        $time = date("H:m");
        $datetime = $date."T".$time;
        
         $sql = 'SELECT subjects.subjectName,subjects.subjectId FROM classes_has_subjects
                 INNER JOIN subjects ON classes_has_subjects.subject_id = subjects.subjectId
                 WHERE class_id = :classid ORDER BY subjects.subjectName';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':classid',$classId);
        $stmt->execute();
        $subject_id = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            array_push($subject_id,$row['subjectId']);
        } 
        for($i=0;$i<count($marks);$i++){
            $mark = $marks[$i];
            $sid = $subject_id[$i];
            $sql = "INSERT INTO results VALUES(null,:studentid,:subject_id,:class_id,:marks,:created_at,:updated_at)";
            $query = $conn->prepare($sql);
            $query->bindParam(':studentid',$studentId);
            $query->bindParam(':subject_id',$sid);
            $query->bindParam(':class_id',$classId);
            $query->bindParam(':marks',$mark);
            $query->bindParam(':created_at',$datetime);
            $query->bindParam(':updated_at',$datetime);
            $query->execute();
            $lastInsertId = $conn->lastInsertId();
            if($lastInsertId){  
                $_SESSION['success'] = 'Results was created successfully';
                header('Location: manage_results.php');
            }else {
                $_SESSION['error'] = 'Results was not created';
                header('Location: manage_results.php');
            }
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
            <li class="nav-item has-treeview menu-open">
                <a href="#" class="nav-link active">
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
                <li class="breadcrumb-item"><a href="manage_results.php">Results</a></li>
                <li class="breadcrumb-item active">Add a Result</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
<div class="container">
    <?php   
        if(isset($_SESSION['success'])){
            echo "<div class='bg-success text-center text-white py-3 mb-3 w-50 mx-auto'>".$_SESSION['success']."</div>";
            unset($_SESSION['success']);
        }else if(isset($_SESSION['error'])){
            echo "<div class='bg-danger text-center text-white py-3 mb-3 w-50 mx-auto'>".$_SESSION['error']."</div>";
            unset($_SESSION['error']);
        }
    ?>
    <div class="container col-lg-6 student-container bg-light p-4 mb-3">
        <div class="h4">Create Results</div>
        <form class="mt-4" action="add_result.php" method="POST">
            <div class="form-group row d-flex align-items-center mb-3">
                <label for="class" class="form-label col-lg-3">Class:</label>
                <div class="col-lg-9">
                    <select class="form-select" id="class" name="class">
                        <option selected hidden disabled="disabled">Class</option>
                        <?php
                            $stmt = $conn->query("SELECT * FROM classes");
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                echo "<option value=".$row['id'].">".$row['className'].'-'.$row['section']."</option>";
                            }
                        ?>
                    </select>
                </div>
            </div> 
            <div class="form-group row d-flex align-items-center mb-3">
                <label for="class" class="form-label col-lg-3">Student Name:</label>
                <div class="col-lg-9">
                    <select class="form-select" id="student" name="student">
                        
                    </select>
                </div>    
            </div> 
            <div class="form-group row d-flex mb-3">
                <label for="class" class="form-label col-lg-3">Subject:</label>
                <div class="col-lg-9">
                    <div id="subject">

                    </div>
                </div>    
            </div>
            <div class="form-group d-flex justify-content-end">
                <input class="btn btn-primary" type="submit" name="addCombine" value="Add">
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#class').change(function(){
            var class_id = $(this).val();
            $.ajax({
            url:'get_student.php',
            method: "POST",
            data:{classId: class_id},
            dataType: "text",
            success:function(data){
                $('#student').html(data);
            }
            });
            $.ajax({
                url: 'get_subject.php',
                method: "POST",
                data:{classId: class_id},
                dataType: "text",
                success:function(data){
                $('#subject').html(data);
            }
            });
        });
        
    });
</script>
<?php include('includes/footer.inc.php');  ?>