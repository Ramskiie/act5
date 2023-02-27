<?php
$sname = "localhost";
$unmae = "root";
$password = "";
$db_name = "user_db";

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "user_db");

// Retrieve the number of grades for each category
$result = mysqli_query($conn, "SELECT COUNT(*) AS count, content FROM grades GROUP BY content ORDER BY content DESC");
$num_grades = mysqli_num_rows($result);
$num_excellent = $num_very_good = $num_good = $num_fair = $num_fail = 0;

if ($num_grades > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        switch ($row['content']) {
            case '5':
                $num_excellent = $row['count'];
                break;
            case '3.75':
                $num_very_good = $row['count'];
                break;
            case '2.5':
                $num_good = $row['count'];
                break;
            case '1.25':
                $num_fair = $row['count'];
                break;
            case '0':
                $num_fail = $row['count'];
                break;
        }
    }
}

// Close the database connection
mysqli_close($conn);

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

<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "user_db");

// Get the number of grades for each category
$sql = "SELECT 
    SUM(CASE WHEN content = 'Excellent' THEN 1 ELSE 0 END) AS excellent,
    SUM(CASE WHEN content_accuracy = 'Very Good' THEN 1 ELSE 0 END) AS very_good,
    SUM(CASE WHEN layout = 'Fair' THEN 1 ELSE 0 END) AS fair,
    SUM(CASE WHEN navigation = 'Good' THEN 1 ELSE 0 END) AS good,
    SUM(CASE WHEN links = 'Fail' THEN 1 ELSE 0 END) AS fail,
    SUM(CASE WHEN background = 'Good' THEN 1 ELSE 0 END) AS background_good,
    SUM(CASE WHEN color_choices = 'Excellent' THEN 1 ELSE 0 END) AS color_choices_excellent,
    SUM(CASE WHEN fonts = 'Good' THEN 1 ELSE 0 END) AS fonts_good,
    SUM(CASE WHEN graphics = 'Very Good' THEN 1 ELSE 0 END) AS graphics_very_good,
    SUM(CASE WHEN images = 'Fail' THEN 1 ELSE 0 END) AS images_accessibility_fail,
    SUM(CASE WHEN spelling_and_grammar = 'Good' THEN 1 ELSE 0 END) AS spelling_and_grammar_good,
    SUM(CASE WHEN copyright = 'Excellent' THEN 1 ELSE 0 END) AS copyright_excellent
FROM grades";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$num_excellent = $row['excellent'];
$num_very_good = $row['very_good'];
$num_good = $row['good'];
$num_fair = $row['fair'];
$num_fail = $row['fail'];

$total = $num_excellent + $num_very_good + $num_good + $num_fair + $num_fail;

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Category', 'Number of Grades', { role: 'style' }, { role: 'annotation' }],
            ['Excellent', <?php echo $row['excellent']; ?>, '#4682B4', '<?php echo $row['excellent']; ?>'],
            ['Very Good', <?php echo $row['very_good']; ?>, '#00CED1', '<?php echo $row['very_good']; ?>'],
            ['Good', <?php echo $row['good']; ?>, '#32CD32', '<?php echo $row['good']; ?>'],
            ['Fair', <?php echo $row['fair']; ?>, '#FFA500', '<?php echo $row['fair']; ?>'],
            ['Fail', <?php echo $row['fail']; ?>, '#DC143C', '<?php echo $row['fail']; ?>']
            ]);


        var options = {
            title: 'Overall Grades',
            legend: { position: 'none' },
vAxis: {
title: 'Number of Grades'
},
hAxis: {
title: 'Grade'
}
};
var chart = new google.visualization.ColumnChart(document.getElementById('columnchart'));

chart.draw(data, options);
}
</script>
</head>
<body>
    <center>
    <h1>NUFV WEBPROG TABULATION</h1>
    <div id="columnchart" style="width: 900px; height: 500px;"></div>
</center>
</body>
</html>
