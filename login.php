<?php
//this will be used for login


session_start();//starting a new session

//check if user is already logged in
if(isset($_SESSION['username']))//if the username is set for this session
{
    header("location: welcome.php");//if true stay on /or goto welcome page
    exit;
}


require_once "config.php";//making connection with the database

$username = $password = "";//new variables
$err = "";

//if request method is post              //request - used to collect data 
if($_SERVER['REQUEST_METHOD'] == "POST"){//post - to collect value of input field
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])))//if both the username and password are empty
    {
        $err = "Please enter username + password";
    }
    elseif(strlen(trim($_POST['password'])) < 5){//if the length of password entered is less than 5
      $err = "password less than 5 character";

    }
    else{
        $username = trim($_POST['username']);//enter the username
        $password = trim($_POST['password']);//password

    }
   
    if(empty($err))//if no error is there
    {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";//to get the username
        $stmt = mysqli_prepare($conn, $sql);//used to prepare sql statement for execution
        mysqli_stmt_bind_param($stmt, "s", $param_username);//creating new parameter to bind variables in it
        $param_username = $username;
        //try to execute the statement
        if(mysqli_stmt_execute($stmt)){//if the mysql statement is executed
          mysqli_stmt_store_result($stmt);//then store the result
          if(mysqli_stmt_num_rows($stmt) == 1){//if that username matches to one in the table 
            
            mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);//to bind the result that has come from sql with the stmt
            if(mysqli_stmt_fetch($stmt))//if the statement is returning something like the username is already present in it
            {
                if(password_verify($password,$hashed_password))
                //this means the password is correct.and allow user to login
                session_start();//starting the new session with the following session variables
                $_SESSION["username"] = $username;
                $_SESSION["id"] = $id;
                $_SESSION["loggedin"] = true;

                //Redirect user to welcome page
                header("location: welcome.php");
            }
        }
        }
    }

}
?>







<!-- nav bar -->
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>PHP login system!</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Php Login System</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
  <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="register.php">Register</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
</li> 
    </ul>
  </div>
</nav>
<!-- login page  -->
<div class="container mt-4">
<h3>Please Login Here:</h3>
<hr>

<form action="" method="post"><!--action-Where to send the form-data when the form is submitted.-->
                               <!--POST is used to send data to a server to create/update a resource. -->

  <div class="form-group">
    <label for="exampleInputEmail1">Email</label>
    <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email">
    <!--form-control for size , aria-describedby used to indicate the IDs of the elements that describe the object -->
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Password">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>