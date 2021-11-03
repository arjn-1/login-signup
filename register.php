<?php
require_once "config.php";
$username = $password = $confirm_password = "";//new empty variables 
$username_err = $password_err = $confirm_password_err = "";//new variable 

if($_SERVER['REQUEST_METHOD'] == "POST"){// collect the value of input field
    //check if username is empty
    if(empty(trim($_POST["username"]))){//after removing white space from both side of the string to check if it is empty
        $username_err = "username cannot be blank";
    }
    else{
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);//returns a statement object or false if it is not created
        if($stmt){//if it is created
            mysqli_stmt_bind_param($stmt, "s", $param_username);//function is used to bind variables to the parameter markers of a prepared statement
            
            //set value of param  username
            $param_username = trim($_POST['username']);

            //try to execute the statement
            if(mysqli_stmt_execute($stmt)){//Executes previously prepared statement.that has been prepared at 13line
             mysqli_stmt_store_result($stmt);//stores the result
                if(mysqli_stmt_num_rows($stmt) == 1){//if that username matches to one in the table 
                    $username_err = "This username is already taken";
                }
                else{
                    $username = trim($_POST['username']);//store that name clearing the white spaces from the string
                }
            }
            else{
                echo "something went wrong";
            }
        }
    }
    mysqli_stmt_close($stmt);


//check for password
if(empty(trim($_POST['password']))){//collect the value of password and if it is empty
    $password_err = "Password cant be blank";
}
elseif(strlen(trim($_POST['password'])) < 5){//if the password is not empty but less than 5 char
    $password_err = "Password cannot be less tahan 5 chars";
}
else{
    $password = trim($_POST['password']);//input the password after clearing white spaces
}

//check for confirm passsword
if(trim($_POST['password']) != trim($_POST['confirm_password'])){//if the confirm password and password does not match
    $password_err = "Passwords should match";
}

//if there were no errors, go ahead and insert into the database
if(empty($username_err) && empty($password_err) && empty($confirm_password_err))//no errors were there
{
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if($stmt)
    {
        mysqli_stmt_bind_param($stmt, "ss",$param_username ,$param_password);//to create two new parameter to store string
        //set these parameters
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);//to hash the password using by default algorithm
        //try to execute the query
        if(mysqli_stmt_execute($stmt))//if the execution is successful got to login.php
        {
            header("location: login.php");
        }
        else{
            echo "SOmething went wrong ... cannot redirect";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}

?>







<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">   <!-- responsive-->

   <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>php login system</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark"><!--expand for resp collapsing and color schemes -->
  <a class="navbar-brand" href="#">Php Login System</a><!--for your company, product, or project name. -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown"><!--for grouping and hiding navbar contents by a parent breakpoint. -->
  <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home </a>
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
<div class="container mt-4">
<h3>Please Register Here:</h3>
<hr>
<form action="" method="post">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Email</label>
      <input type="text" class="form-control" name="username" id="inputEmail4" placeholder="Email">
    </div>
    <div class="form-group">
    <label for="inputPhone">Phone No.</label>
    <input type="text" class="form-control" id="inputPhone" placeholder="Phone/Mobile/telephone No.">
  </div>
  <div class="form-group">
    <label for="inputAddress2">Address 2</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">City</label>
      <input type="text" class="form-control" id="inputCity" placeholder="new delhi, bombay, chennai ...">
    </div>
    <div class="form-group col-md-4">
      <label for="inputState">State</label>
      <select id="inputState" class="form-control">
        <option selected>Choose...</option>
        <option>Andhra Pradesh</option>
        <option>Arunachal Pradesh</option>
        <option>Assam</option>
        <option>Bihar</option>
        <option>Chhattisgarh</option>
        <option>Delhi</option>
        <option>Goa</option>
        <option>Gujarat</option>
        <option>Haryana</option>
        <option>Himachal Pradesh</option>
        <option>Jharkhand</option>
        <option>Karnataka</option>
        <option>Kerala</option>
        <option>Madhya Pradesh</option>
        <option>Maharashtra</option>
        <option>Manipur</option>
        <option>Meghalaya</option>
        <option>Mizoram</option>
        <option>Nagaland</option>
        <option>Odisha</option>
        <option>Punjab</option>
        <option>Rajasthan</option>
        <option>Sikkim</option>
        <option>Tamil Nadu</option>
        <option>Telangana</option>
        <option>Tripura</option>
        <option>Uttar Pradesh</option>
        <option>Uttarakhand</option>
        <option>West Bengal</option>
      </select>
    </div>
    <div class="form-group col-md-2">
      <label for="inputZip">Zip</label>
      <input type="text" class="form-control" id="inputZip">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Password</label>
      <input type="password" class="form-control" name ="password" id="inputPassword4" placeholder="Password">
    </div>
  </div>
  <div class="form-group col-md-6">
      <label for="inputPassword4">Confirm Password</label>
      <input type="password" class="form-control" name ="confirm_password" id="inputPassword" placeholder="Confirm Password">
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Sign in</button>
</form>
</div>
  </body>
</html>