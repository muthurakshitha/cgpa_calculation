<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="firstpage.css">
</head>

<body>

    <div class="rak">
        <h2 class="head">Result</h2>
        <a class="view" href="thirdpage.php">View CGPA &#10095</a>
    </div>


    <?php
    session_start();
    // Retrieve user details from session
    $ureg = $_SESSION["ureg"];
    ?>
    <?php
    // Connect to the MySQL database
    $conn = mysqli_connect("localhost", "root", "", "results");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Execute the query to get the highest value from the column
    $query = "SELECT MAX(Semester) FROM ptudbtab_studentgrades where StudentId='$ureg'";
    $result = mysqli_query($conn, $query);

    // Fetch the result and get the highest value
    $row = mysqli_fetch_row($result);
    $highest_value = $row[0];

    // Loop from 1 to the highest value
    for ($i = 1; $i <= $highest_value; $i++) {
        $item = (string)$i;

        echo '<div class="cont">';
        echo '<div class="card">';
        echo '<div class="box">';
        echo '<div class="content">';
        echo '<h2>' . $item . '</h2>';
        echo '<h3>Semester ' . $item . '</h3>';
        echo '<form method="post" action="secondpage.php">';
        echo '<input type="hidden" name="cardID" value="' . (string)$i . '">';
        echo '<div class="outer button">';
        echo '<button type="submit">See Score</button>';
        echo '<span></span>';
        echo '</div>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    // Close the database connection
    mysqli_close($conn);
    ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>