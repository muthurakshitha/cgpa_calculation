<!DOCTYPE html>
<html>

<head>
    <title>Timetable</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Timetable</h1>

    <?php
    // Establish database connection
    $servername = "localhost";
    $username = "root";
    $password = "dpreddy";
    $dbname = "miniproject";

    $conn = new mysqli($servername, $username, $password, $dbname, 3308);
    if (isset($_GET['dept'])) {
        $dept = $_GET['dept'];
    }

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve timetable data from the database
    $sql = "SELECT Day, Period_1, Period_2, Period_3, Period_4, Period_5, Period_6, Period_7, Period_8
        FROM timetable
        WHERE Dept_name = '$dept'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>
                <th>Day</th>
                <th>Period 1</th>
                <th>Period 2</th>
                <th>Period 3</th>
                <th>Period 4</th>
                <th>Period 5</th>
                <th>Period 6</th>
                <th>Period 7</th>
                <th>Period 8</th>
              </tr>";

        // Output timetable data
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['Day'] . "</td>
                    <td>" . $row['Period_1'] . "</td>
                    <td>" . $row['Period_2'] . "</td>
                    <td>" . $row['Period_3'] . "</td>
                    <td>" . $row['Period_4'] . "</td>
                    <td>" . $row['Period_5'] . "</td>
                    <td>" . $row['Period_6'] . "</td>
                    <td>" . $row['Period_7'] . "</td>
                    <td>" . $row['Period_8'] . "</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "No data found.";
    }

    $conn->close();
    ?>

</body>

</html>