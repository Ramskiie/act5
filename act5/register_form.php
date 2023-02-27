<?php

@include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'user already exist!';

   }else{

      if($pass != $cpass){
         $error[] = 'password not matched!';
      }else{
         $insert = "INSERT INTO user_form(name, email, password, user_type) VALUES('$name','$email','$pass','$user_type')";
         mysqli_query($conn, $insert);
         header('location:login_form.php');
      }
   }

};


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>

   <style>
     @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap');

html, body {
  height: 100%;
  margin: 0;
  padding: 0;
  font-family: 'Montserrat', sans-serif;
}

body {
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #f6f5f5;
}

.form-container {
  background-color: #fff;
  border-radius: 20px;
  box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.1);
  max-width: 400px;
  margin: 0 auto;
  padding: 40px;
}

h3 {
  color: #006400 ;
  font-size: 32px;
  font-weight: 600;
  margin-bottom: 30px;
  text-align: center;
}

   input[type="text"] {
      background-color: #f2f2f2;
  border: none;
  border-radius: 10px;
  color: #333;
  font-size: 16px;
  margin-bottom: 15px;
  padding: 15px;
  width: 100%;
   }
   input[type="email"],
input[type="password"] {
  background-color: #f2f2f2;
  border: none;
  border-radius: 10px;
  color: #333;
  font-size: 16px;
  margin-bottom: 15px;
  padding: 15px;
  width: 100%;
}
input[type="submit"] {
  background-color: #2c3e50;
  border: none;
  border-radius: 10px;
  box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
  color: #98ff98 ;
  cursor: pointer;
  font-size: 18px;
  font-weight: 600;
  margin-top: 20px;
  padding: 15px;
  transition: background-color 0.3s ease, box-shadow 0.3s ease;
  width: 100%;
}

input[type="submit"]:hover {
  background-color: #1a2533;
  box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.4);
}
select [type="user_type"] {
   background-color: #98ff98 ;
      border: none;
      border-radius: 5px;
      color: #000;
      font-size: 16px;
      margin-bottom: 15px;
      padding: 15px;
      width: 100%;
}
 .form-container form select {
   background-color: #f2f2f2;
  border: none;
  border-radius: 10px;
  color: #333;
  font-size: 16px;
  margin-bottom: 15px;
  padding: 15px;
  width: 100%;
 }
 .error-msg {
  color: #c0392b;
  font-size: 14px;
  margin-bottom: 10px;
  display: block;
  text-align: center;
}

p {
  text-align: center;
  margin-top: 20px;
  color: #555;
}

a {
  color: #2c3e50;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}
      </style>

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Register now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="name" required placeholder="enter your name">
      <input type="email" name="email" required placeholder="enter your email">
      <input type="password" name="password" required placeholder="enter your password">
      <input type="password" name="cpassword" required placeholder="confirm your password">
      <select name="user_type">
         <option value="user">user</option>
         <option value="admin">admin</option>
      </select>
      <input type="submit" name="submit" value="register now" class="form-btn">
      <p>already have an account? <a href="login_form.php">Login now</a></p>
   </form>

</div>

</body>
</html>