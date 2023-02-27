<?php
@include 'config.php';
session_start();

if(!isset($_SESSION['user_name'])){
   header('location:login_form.php');
}
if (isset($_POST['logout'])) {
    session_destroy();
    header('location:login_form.php');
}
if (isset($_POST['content'])) {
    $group_name = isset($_POST['group_name']) ? $_POST['group_name'] : '';
    $content = $_POST['content'];
    $content_accuracy = $_POST['content_accuracy'];
    // Get the values for the other categories
    $layout = $_POST['layout'];
    $navigation = $_POST['navigation'];
    $links = isset($_POST['links_content']) ? $_POST['links_content'] : '';
    $background = $_POST['background'];
    $color_choices = $_POST['color_choices'];
    $fonts = $_POST['fonts'];
    $graphics = $_POST['graphics'];
    $images = $_POST['images_accessibility'];
    $spelling_and_grammar = $_POST['spelling_grammar'];
    $copyright = $_POST['copyright'];

    $sname= "localhost";
    $unmae= "root";
    $password = "";
    $db_name = "user_db";
    // Connect to the database
    $conn = mysqli_connect($sname, $unmae, $password, $db_name);

    // Insert the grades into the database
    $sql = "INSERT INTO grades (group_name, content, content_accuracy, layout, navigation, links, background, color_choices, fonts, graphics, images, spelling_and_grammar, copyright) VALUES ('$group_name', '$content', '$content_accuracy', '$layout', '$navigation', '$links', '$background', '$color_choices', '$fonts', '$graphics', '$images', '$spelling_and_grammar', '$copyright')";
    mysqli_query($conn, $sql);

    // Close the database connection
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html>
<head>
    <title >NUFV WEBPROG TABULATION</title>
    <form method="post">
    <input id="new" type="submit" name="logout" value="Logout">
</form>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
     body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
        }
        h1 {
            text-align: center;
            margin-top: 50px;
        }
        table {
            margin: 50px auto;
            border-collapse: collapse;
            width: 80%;
            max-width: 800px;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e6e6e6;
        }
        th {
            background-color: #f5f5f5;
        }
        select {
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: none;
            font-size: 16px;
            line-height: 1.3;
            width: 100%;
            max-width: 300px;
            margin: 0;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='%23000'%3E%3Cpath d='M30.415 7.585c-1.172-1.172-3.072-1.172-4.243 0L16 17.757l-10.172-10.17c-1.172-1.172-3.072-1.172-4.243 0s-1.172 3.072 0 4.243L12.757 22.3c0.586 0.586 1.354 0.879 2.121 0.879s1.536-0.293 2.121-0.879L30.415 11.828c1.172-1.171 1.172-3.071 0-4.243z'/%3E%3C/svg%3E") no-repeat right 10px center/15px auto;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 12px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 4px;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
        }
        input[type="submit"]:hover {
            background-color: #3e8e41;
        }
        #new {
      width: 8rem;
      position: absolute;
      top: -0px;
      right: -500px;
      left: 900px;
      background-color: #1abc9c;
      color: white;
      border: none;
      border-radius: 0.5rem;
      padding: .5rem .5rem;
      margin-top: .5rem;
      margin-bottom: .5rem;
      font-size: 1rem;
      box-shadow: 0 0.2rem 0.5rem rgba(0, 0, 0, 0.2);
    }

    </style>

</head>
<body>
    <h1>NUFV WEBPROG TABULATION</h1>
    <form action="" method="post">
        <table>
            <tr>
            <td>Group Name:</td>
            <td>
                <input type="text" name="group_name">
            </td>
            </tr>

            <tr>
                <td>Content:</td>
                <td>
                    <select name="content">
                        <option value="5">Excellent</option>
                        <option value="3.75">Very Good</option>
                        <option value="2.5">Good</option>
                        <option value="1.25">Fair</option>
                        <option value="0">Fail</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Content Accuracy:</td>
                <td>
                    <select name="content_accuracy">
                        <option value="5">Excellent</option>
                        <option value="3.75">Very Good</option>
                        <option value="2.5">Good</option>
                        <option value="1.25">Fair</option>
                        <option value="0">Fail</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Layout:</td>
                <td>
                    <select name="layout">
                        <option value="5">Excellent</option>
                        <option value="3.75">Very Good</option>
                        <option value="2.5">Good</option>
                        <option value="1.25">Fair</option>
                        <option value="0">Fail</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Navigation:</td>
                <td>
                    <select name="navigation">
                        <option value="5">Excellent</option>
                        <option value="3.75">Very Good</option>
                        <option value="2.5">Good</option>
                        <option value="1.25">Fair</option>
                        <option value="0">Fail</option>
                    </select>
                </td>
            </tr>
            <tr>
             <td>Links(Content):</td>
            <td>
                     <select name="links_content">
                        <option value="5">Excellent</option>
                        <option value="3.75">Very Good</option>
                        <option value="2.5">Good</option>
                        <option value="1.25">Fair</option>
                        <option value="0">Fail</option>
                     </select>
            </td>

            </tr>
            <tr>
                <td>Background:</td>
                <td>
                    <select name="background">
                        <option value="5">Excellent</option>
                        <option value="3.75">Very Good</option>
                        <option value="2.5">Good</option>
                        <option value="1.25">Fair</option>
                        <option value="0">Fail</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Color Choices:</td>
                <td>
                    <select name="color_choices">
                        <option value="5">Excellent</option>
                        <option value="3.75">Very Good</option>
                        <option value="2.5">Good</option>
                        <option value="1.25">Fair</option>
                        <option value="0">Fail</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Fonts:</td>
                <td>
                    <select name="fonts">
                        <option value="5">Excellent</option>
                        <option value="3.75">Very Good</option>
                        <option value="2.5">Good</option>
                        <option value="1.25">Fair</option>
                        <option value="0">Fail</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Graphics:</td>
                <td>
                    <select name="graphics">
                        <option value="5">Excellent</option>
                        <option value="3.75">Very Good</option>
                        <option value="2.5">Good</option>
                        <option value="1.25">Fair</option>
                        <option value="0">Fail</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Images(Accessibility):</td>
                <td>
                    <select name="images_accessibility">
                        <option value="5">Excellent</option>
                        <option value="3.75">Very Good</option>
                        <option value="2.5">Good</option>
                        <option value="1.25">Fair</option>
                        <option value="0">Fail</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Spelling and Grammar:</td>
                <td>
                    <select name="spelling_grammar">
                        <option value="5">Excellent</option>
                        <option value="3.75">Very Good</option>
                        <option value="2.5">Good</option>
                        <option value="1.25">Fair</option>
                        <option value="0">Fail</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Copyright:</td>
                <td>
                    <select name="copyright">
                        <option value="5">Excellent</option>
                        <option value="3.75">Very Good</option>
                        <option value="2.5">Good</option>
                        <option value="1.25">Fair</option>
                        <option value="0">Fail</option>
                    </select>
                </td>
            </tr>
        </table>
        <input type="submit" value="Submit">
    </form>
</body>
</html>