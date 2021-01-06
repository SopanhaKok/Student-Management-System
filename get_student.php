<?php
    include('includes/config.php');
    $output = '';
    $sql = "SELECT * FROM students WHERE class_id = ".$_POST['classId']." ORDER BY studentName";
    $output = '<option selected hidden disabled="disabled">Student Name</option>';
    $result = $conn->query($sql);
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
       $output .= "<option value=".$row['studentId'].">".$row['studentName']."</option>";
    }
    echo $output;
?>