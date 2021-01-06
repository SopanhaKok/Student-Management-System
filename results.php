<?php
    include('includes/config.php');
    session_start();
    if(isset($_POST['search'])){
        $rollId = $_POST['id'];
        $classId = $_POST['class'];
        $sql = "SELECT students.studentName,students.rollId,classes.className,subjects.subjectName,classes.section,marks FROM results 
                INNER JOIN students ON students.studentId = results.student_id 
                INNER JOIN classes ON classes.id = results.class_id
                INNER JOIN subjects ON subjects.subjectId = results.subject_id
                WHERE rollId = :rollId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':rollId',$rollId);
        $stmt->execute();
        if(!$stmt->rowCount()){
            $_SESSION['notFound'] = "Student Not Found";
            header('Location:index.php');
        }else{
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }else{
        header('Location:index.php');
    }


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="css/index.css" rel="stylesheet">
    <title>Student Result Management System</title>
</head>
<body>
    <div class="wrapper">
        <div class="header bg-primary py-4">
            <h2 class="text-center text-white">Student Result Management System</h2>
        </div>
        <div class="container bg-light mt-5 pb-5 px-0">
            <div class="text-center border-bottom py-4">
                <h3>Student Result Details</h3>
            </div>
            <div class="info-container p-4">
                <div class="student-info">
                    <span class="fw-bold fs-5">Student Name: </span>
                    <span  class="fs-6"><?php echo $result[0]['studentName'] ?></span>
                </div>
                <div class="student-info">
                    <span class="fw-bold fs-5">Student Roll Id: </span>
                    <span  class="fs-6"><?php echo $result[0]['rollId'] ?></span>
                </div>
                <div class="student-info">
                    <span class="fw-bold fs-5">Student Class: </span>
                    <span class="fs-6"><?php echo $result[0]['className']."(".$result[0]['section'].")" ?></span>
                </div>
            </div>
            <div class="result-container p-4">
                <table class="table table-hover table-bordered border-2 table-primary text-center">
                <thead class="table-dark border-2">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Marks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $score = 0;
                        $total_score = 0;
                        $id = 1;
                        foreach($result as $row){
                            echo "<tr>";
                            echo "<td>".$id."</td>";
                            echo "<td>".$row['subjectName']."</td>";
                            echo "<td>".$row['marks']."</td>";
                            $score += $row['marks'];
                            echo "</tr>";
                            $id++;
                        }
                        $total_score = ($id-1) * 100;
                    ?>
                    <tr>
                        <th colspan="2">Total Marks</th>
                        <td><?php echo $score." out of ".$total_score ?></td>
                    </tr>
                    <tr>
                        <th colspan="2">Percentage</th>
                        <td><?php echo round((($score/$total_score) * 100))." %" ?></td>
                    </tr>
                </tbody>
                </table>
            </div>
            <a class="text-primary ms-4" href="index.php">Back To Home</a>
        </div>
    </div>
</body>
</html>