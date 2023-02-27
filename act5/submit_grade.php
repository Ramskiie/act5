<?php
@include 'config.php';

session_start();

if(!isset($_SESSION['user_name'])){
   header('location:login_form.php');
   exit(); // Added exit to stop script execution after redirect
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['group_name'])) {
    $group_name = $_POST['group_name'];
    $content = $_POST['content'];

    // You may want to add some kind of authentication or session handling here to ensure that only valid groups can submit grades

    // Insert the grade into the database
    $stmt = $pdo->prepare('INSERT INTO grades (group_name, content) VALUES (?, ?)');
    $stmt->execute([$group_name, $content]);

    echo 'Grade saved!';
} else {
    echo 'Invalid request.';
}
?>
