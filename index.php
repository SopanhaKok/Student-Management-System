<?php
    include('includes/config.php');
    session_start();

    if(isset($_POST['signin'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = 'SELECT * FROM admin WHERE username = :username';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username',$username);
        $stmt->execute();
        if($stmt->rowCount()){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result['Password'] == $password){
                $_SESSION['admin'] = true;
                header('Location: dashboard.php');
            }else{
                $_SESSION['unauthentication'] = 'Your Username or Password is incorrect';
            }
        }else{
            $_SESSION['unauthentication'] = 'Your Username or Password is incorrect';
        }
    }

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="css/home.css" rel="stylesheet" type="text/css">
    <title>Student Result Management System</title>
</head>
<body>
    <div class="wrapper">
        <div class="header bg-primary py-4">
            <h2 class="text-center text-white">Student Result Management System</h2>
        </div>
        <div class="container bg-niptict d-flex align-items-center">
            <div class="row w-100">
                <div class="container col-lg-4 student-container text-center bg-light p-3 mb-3">
                    <div class="h4">Student Results</div>
                    <span >Search your Result</span>
                    <?php 
                        if(isset($_SESSION['notFound']))
                            echo "<div class='text-white bg-danger py-2 mt-2'>".$_SESSION['notFound']."</div>";
                            unset($_SESSION['notFound']);
                    ?>
                    
                    <form class="mt-4" action="results.php" method="POST">
                        <div class="form-group row d-flex align-items-center mb-3">
                            <label for="id" class="form-label col-lg-3">Roll ID:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control " id="id" name="id">
                            </div>
                        </div>  
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
                        <div class="form-group d-flex justify-content-end"> 
                            <input class="btn btn-primary align-self-end" type="submit" name="search" value="Search">
                        </div>
                    </form>
                </div>
                <div class="container col-lg-5 bg-light text-center admin-container p-3 mb-3">
                    <div class="h4">Admin Login</div>
                    <span >Student management system</span>
                    <form class="mt-4" action="index.php" method="POST">
                        <?php 
                            if(isset($_SESSION['unauthentication'])) 
                                echo "<span class='text-danger'>". $_SESSION['unauthentication']."</span>";
                            unset($_SESSION['unauthentication']);
                        ?>
                        
                        <div class="form-group row d-flex align-items-center mb-3">
                            <label for="username" class="form-label col-lg-2">Username:</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control " id="username" name="username">
                            </div>
                        </div>  
                        <div class="form-group row d-flex align-items-center mb-3">
                            <label for="password" class="form-label col-lg-2">Password:</label>
                            <div class="col-lg-10">
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div> 
                        <div class="form-group d-flex justify-content-between"> 
                            <a class="text-decoration-none" href="#">Forget Password ?</a>
                            <input class="btn btn-primary align-self-end" type="submit" name="signin" value="Sign In">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>