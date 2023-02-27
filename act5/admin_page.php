<?php
$sname = "localhost";
$unmae = "root";
$password = "";
$db_name = "user_db";
session_start();

if (isset($_POST['logout'])) {
   session_destroy();
   header('location:login_form.php');
}
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "user_db");

$sql = "SELECT * FROM grades WHERE content + content_accuracy + layout + navigation + links + background + color_choices + fonts + graphics + images + spelling_and_grammar + copyright >= 60";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Calculate the total grades
$total_grades = 0;
foreach ($data as $row) {
    $total_grades += $row['content'] + $row['content_accuracy'] + $row['layout'] + $row['navigation'] + $row['links'] + $row['background'] + $row['color_choices'] + $row['fonts'] + $row['graphics'] + $row['images'] + $row['spelling_and_grammar'] + $row['copyright'];
}

// Create the data for the pie chart
$grades_data = array(
    array('Category', 'Percentage')
);
if (isset($_GET['group_name'])) {
    $group_name = mysqli_real_escape_string($conn, $_GET['group_name']);
    $sql = "SELECT * FROM grades WHERE group_name='$group_name'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Calculate the total grades
    $total_grades = 0;
    foreach ($data as $row) {
        $total_grades += $row['content'] + $row['content_accuracy'] + $row['layout'] + $row['navigation'] + $row['links'] + $row['background'] + $row['color_choices'] + $row['fonts'] + $row['graphics'] + $row['images'] + $row['spelling_and_grammar'] + $row['copyright'];
    }

    // Create the data for the pie chart
    $grades_data = array(
        array('Category', 'Percentage')
    );
}
  foreach ($data as $row) {
    $total_grade = $row['content'] + $row['content_accuracy'] + $row['layout'] + $row['navigation'] + $row['links'] + $row['background'] + $row['color_choices'] + $row['fonts'] + $row['graphics'] + $row['images'] + $row['spelling_and_grammar'] + $row['copyright'];
    if ($total_grade <= 60) {
      $grades_data[] = array('Content', $row['content'] / $total_grade);
      $grades_data[] = array('Content Accuracy', $row['content_accuracy'] / $total_grade);
      $grades_data[] = array('Layout', $row['layout'] / $total_grade);
      $grades_data[] = array('Navigation', $row['navigation'] / $total_grade);
      $grades_data[] = array('Links (Content)', $row['links'] / $total_grade);
      $grades_data[] = array('Background', $row['background'] / $total_grade);
      $grades_data[] = array('Color Choices', $row['color_choices'] / $total_grade);
      $grades_data[] = array('Graphics', $row['graphics'] / $total_grade);
$grades_data[] = array('Images', $row['images'] / $total_grade);
$grades_data[] = array('Spelling and Grammar', $row['spelling_and_grammar'] / $total_grade);
$grades_data[] = array('Copyright', $row['copyright'] / $total_grade);
} else {
$grades_data[] = array('Content', 0);
$grades_data[] = array('Content Accuracy', 0);
$grades_data[] = array('Layout', 0);
$grades_data[] = array('Navigation', 0);
$grades_data[] = array('Links (Content)', 0);
$grades_data[] = array('Background', 0);
$grades_data[] = array('Color Choices', 0);
$grades_data[] = array('Fonts', 0);
$grades_data[] = array('Graphics', 0);
$grades_data[] = array('Images', 0);
$grades_data[] = array('Spelling and Grammar', 0);
$grades_data[] = array('Copyright', 0);
}
} // Add this closing brace
$num_grades_over_60 = 0;
foreach ($data as $row) {
if ($row['content'] + $row['content_accuracy'] + $row['layout'] + $row['navigation'] + $row['links'] + $row['background'] + $row['color_choices'] + $row['fonts'] + $row['graphics'] + $row['images'] + $row['spelling_and_grammar'] + $row['copyright'] > 60) {
$num_grades_over_60++;
}
}

?>

<html>
<head>
    <title>Admin Page</title>
    <form method="post">
    <input id="new" type="submit" name="logout" value="Logout">
</form>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
       google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
    var data = google.visualization.arrayToDataTable(<?php echo json_encode($grades_data); ?>);
    var options = {
        title: 'Grades',
        legend: { position: 'none' },
        bars: 'vertical',
        bar: { groupWidth: '70%' },
        hAxis: {
            title: 'Percentage',
            minValue: 0
        }
    };
    var chart = new google.visualization.BarChart(document.getElementById('barchart'));
    chart.draw(data, options);
}

        // Add an event listener to handle clicks on the chart slices
        google.visualization.events.addListener(chart, 'select', selectHandler);

        chart.draw(data, options);

        function selectHandler() {
            // Get the selected item(s) from the chart
            var selection = chart.getSelection();

            // Create an array to hold the selected category names and grades
            var selected_items = [];

            // Loop through each selected item
            for (var i = 0; i < selection.length; i++) {
                // Get the category name and grade for the selected item
                var category = data.getValue(selection[i].row, 0);
                var grade = data.getValue(selection[i].row, 1);

                // Add the category name and grade to the selected items array
                selected_items.push({ category: category, grade: grade });
            }

            // Send the selected items to the server via AJAX
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert(this.responseText);
                }
            };
            xhttp.open("POST", "process_selection.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("selected_items=" + JSON.stringify(selected_items));
        }
    </script>
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      font-size: 16px;
      background-image: url('background.jpg');
      background-repeat: repeat;
      background-size: cover;
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

    #piechart {
      border: 2px solid #ccc;
      box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.2);
    }

    var options = {
      title: 'Grades',
      is3D: true,
      pieSliceText: 'value',
      sliceColors: ['#FFA07A', '#87CEEB', '#90EE90', '#FFD700', '#FF69B4', '#9370DB', '#808080', '#8B008B', '#1E90FF', '#FF6347', '#00CED1', '#FFC0CB']
    };
  </style>
</head>
<body>
    <form method="get">
        <label for="group_name">Search for group name:</label>
        <input type="text" id="group_name" name="group_name">
        <button type="submit">Search</button>
    </form>
    <center>
    <?php
    echo "<h2>Group Name: " . (isset($group_name) ? $group_name : "All Groups")."</h2>";
    echo "<h2>Total Grades: $total_grades</h2>";
    echo "<div id='barchart' style='width: 1000px; height: 500px;'></div>";
    ?>
    <center>
</body>

</html>

