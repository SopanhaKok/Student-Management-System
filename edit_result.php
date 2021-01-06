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
        $stmt = $conn->prepare('SELECT * FROM results WHERE student_id = :id LIMIT 1');
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            header('Location: manage_results.php');
        }
    }

    if(isset($_POST['submit'])){

    $rowid=$_POST['id'];
    $marks=$_POST['marks']; 

    foreach($_POST['id'] as $count => $id){
        $mrks=$marks[$count];
        $iid=$rowid[$count];
        for($i=0;$i<=$count;$i++) {

            $sql="update tblresult  set marks=:mrks where id=:iid ";
            $query = $dbh->prepare($sql);
            $query->bindParam(':mrks',$mrks,PDO::PARAM_STR);
            $query->bindParam(':iid',$iid,PDO::PARAM_STR);
            $query->execute();

            $msg="Result info updated successfully";
        }
    }
}


    if(isset($_POST['editResult'])){
        $classId = $_POST['class'];
        $studentId = $_POST['student'];
        $marks = $_POST['marks'];
        $date = date('Y-m-d');
        $time = date("H:m");
        $datetime = $date."T".$time;
        $sql = "SELECT distinct students.StudentName,students.StudentId,classes.ClassName,classes.Section,subjects.subjectId,subjects.SubjectName,results.marks,results.id as resultid from results join students on students.studentId=results.student_id join subjects on subjects.subjectId=results.subject_id join classes on classes.id=students.class_id where students.studentId = :student_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':student_id',$studentId);
        $stmt->execute();
        $subject_id = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            array_push($subject_id,$row['subjectId']);
        } 
        for($i=0;$i<count($marks);$i++){
            $mark = $marks[$i];
            $sid = $subject_id[$i];
            $sql = "UPDATE results SET marks = :marks,updated_at = :updated_at WHERE subject_id = :subject_id AND student_id = :studentid";
            $query = $conn->prepare($sql);
            $query->bindParam(':marks',$mark);
            $query->bindParam(':updated_at',$datetime);
            $query->bindParam(':subject_id',$sid);
            $query->bindParam(':studentid',$studentId);
            $query->execute();
            $lastInsertId = $conn->lastInsertId();
            if(!$lastInsertId){  
                $_SESSION['success'] = 'Results was updated successfully';
                header('Location: manage_results.php');
            }else {
                $_SESSION['error'] = 'Results was not updated';
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
                <li class="breadcrumb-item active">Edit a Result</li>
                </ol>
            </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
<div class="container">
    <div class="container col-lg-6 student-container bg-light p-4 mb-3">
        <div class="h4">Edit Results</div>
        <form class="mt-4" action="edit_result.php" method="POST">
            <div class="form-group row d-flex align-items-center mb-3">
                <label for="class" class="form-label col-lg-3">Class:</label>
                <div class="col-lg-9">
                    <?php
                        $stmt = $conn->query("SELECT * FROM classes");
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            if($row['id'] === $data['class_id']){
                                echo "<input type='hidden' name='class' value='".$row['id']."'>";
                                echo "<div>".$row['className'].' - '.$row['section']."</div>";
                            }
                        }
                    ?>
                </div>
            </div> 
            <div class="form-group row d-flex align-items-center mb-3">
                <label for="class" class="form-label col-lg-3">Student Name:</label>
                <div class="col-lg-9">
                        <?php
                            $sql = "SELECT * FROM students WHERE class_id = ".$data['class_id']." AND studentId = ".$data['student_id'];
                            $stmt = $conn->query($sql);
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo "<input type='hidden' name='student' value='".$row['studentId']."'>";
                            echo "<div>".$row['studentName']."</div>";
                        ?>
                </div>    
            </div> 
            <div class="form-group row d-flex mb-3">
                <label for="class" class="form-label col-lg-3">Subject:</label>
                <div class="col-lg-9">
                    <div id="subject">
                        <?php 
                            $sql = "SELECT *,subjects.subjectName FROM results INNER JOIN subjects ON subjects.subjectId = results.subject_id WHERE student_id = ".$data['student_id']." AND class_id = ".$data['class_id'];
                            $stmt = $conn->query($sql);
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                echo "<div>".$row['subjectName']."</div>";
                                echo "<input class='form-control' value=".$row['marks']." type='number' min='0' max='100' name='marks[]'  >";
                            }
                        ?>
                        <div></div>
                        
                    </div>
                </div>    
            </div>
            <div class="form-group d-flex justify-content-end">
                <input class="btn btn-primary" type="submit" name="editResult" value="Update">
            </div>
        </form>
    </div>
</div>

<?php include('includes/footer.inc.php');  ?>