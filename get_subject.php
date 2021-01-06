<?php
    include('includes/config.php');
    $output = '';
    $sql = "SELECT *,subjects.subjectName AS subjectName FROM classes_has_subjects 
            INNER JOIN subjects ON classes_has_subjects.subject_id = subjects.subjectId 
            WHERE class_id = ".$_POST['classId']." ORDER BY subjects.subjectName";
    $result = $conn->query($sql);
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
       $output .= " <div>".$row['subjectName']."</div>
                    <input class='form-control' placeholder='Enter marks out of 100' type='number' min='0' max='100' name='marks[]'  >";
    }
    echo $output;
?>