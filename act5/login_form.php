<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         header('location:admin_page.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         header('location:user_page.php');

      }
     
   }else{
      $error[] = 'incorrect email or password!';
   }

};
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>
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
  color: #98ff98;
  font-size: 32px;
  font-weight: 600;
  margin-bottom: 30px;
  text-align: center;
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
  background-color: #98ff98;
  border: none;
  border-radius: 10px;
  box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
  color: #fff;
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
      <h3>Login now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="email" name="email" required placeholder="enter your email">
      <input type="password" name="password" required placeholder="enter your password">
      <input type="submit" name="submit" value="Login now" class="form-btn">
      <p>don't have an account? <a href="register_form.php">register now</a></p>
   </form>

</div>

</body>
</html>