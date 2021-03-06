<?php 
    session_start();
    include('includes/config.php');
    include('includes/head.inc.php'); 
    date_default_timezone_set('Asia/Phnom_Penh');
    if(!isset($_SESSION['admin'])){
        header('Location: index.php');
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
                <h1 class="m-0 text-dark">Manage Results</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item active">Results</li>
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
        }
    ?>
    <div class="container">
        <div class="container col-lg-12 manage-student-container bg-light p-4 mb-3">
            <div class="d-flex justify-content-between mb-5">
                <div class="h4">Results Details</div>
                <a class="btn btn-success" href="add_result.php">Add New Result</a>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Student Name</th>
                    <th scope="col">Roll Id</th>
                    <th scope="col">Class</th>
                    <th scope="col">Register Date</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $stmt = $conn->query("SELECT distinct students.studentName AS studentName,students.studentId,students.rollId AS rollId,students.registered_at AS regDate,classes.className AS className, classes.section AS section FROM results 
                                                INNER JOIN classes ON results.class_id = classes.id
                                                INNER JOIN students ON results.student_id = students.studentId ");
                        if($stmt->rowCount() > 0){
                            $id = 1;
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                echo "<tr>";
                                echo "<th scope='row'>".$id."</th>";
                                echo "<td>".$row['studentName']."</td>";
                                echo "<td>".$row['rollId']."</td>";
                                echo "<td>".$row['className'].'('.$row['section'].")</td>";
                                echo "<td>".$row['regDate']."</td>";
                                echo "<td>
                                    <a class='mr-2' href='edit_result.php?id=".$row['studentId']."'><i class='fas  fa-pencil-alt'></i></a>
                                    <a class='mr-2' href='delete_result.php?id=".$row['studentId']."'><i class='fas fa-trash-alt'></i></a>
                                </td>";
                                $id++;
                            }
                        }
                        
                    ?>
                </tbody>
            </table>
        </div>
    </div>

<?php include('includes/footer.inc.php');  ?>