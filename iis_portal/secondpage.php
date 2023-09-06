<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .view {
            text-decoration: none;
            color: #008080;
            display: inline;
            font-size: 1.8rem;
        }

        .view:hover {
            font-weight: 600;
            font-size: 2.1rem;
            color: #008080;
        }
    </style>
    <link rel="stylesheet" href="secondpage.css">

</head>

<body>
    <div>
        <div class="gan">
            <a class="view" href="firstpage.php">&#10094 Back </a>
        </div>



        <?php
// Start the session
session_start();
$ureg = $_SESSION["ureg"];
// Get the card ID from the session

$cardID = $_POST['cardID'];

$servername = "localhost";
$username = "root";
$password = "";
$database = "results";
$conn = mysqli_connect($servername, $username, $password, $database);
$sql = "SELECT Batch FROM `ptudbtab_studentgrades` group by StudentId='$ureg' ";
$result = mysqli_query($conn, $sql);
// $num = mysqli_num_rows($result);
// if ($num > 0) {
//     while ($row = mysqli_fetch_assoc($result)) {
//         $batch = $row['Batch'];
//     }
// }

$row = mysqli_fetch_assoc($result);
$batch = $row['Batch'];

?>
        <div class="rowwise">

            <div class="flex-container">
                <div class="dp">

                    <main class="table">
                        <section class="table_header">
                            <h2><?php if ($cardID % 2 == 0) {
    echo 'Even Semester';
    $month = 'MAY ';
} else {
    echo 'Odd Semester';
    $month = 'DECEMBER ';
}?></h2>
                            <div class="search-wrapper">
                                <input class="search-input" placeholder="Search..." type="text" value="" name="search" id="search" />
                                <img class="search-pic" src="Images/search.png" />
                            </div>
                        </section>
                        <section class="table_body">
                            <div class="fixTableHead">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Sl.no<span class="icon-arrow">&UpArrow;</span></th>
                                            <th>Subject code<span class="icon-arrow">&UpArrow;</span></th>
                                            <th>Subject<span class="icon-arrow">&UpArrow;</span></th>
                                            <th>Semester<span class="icon-arrow">&UpArrow;</span></th>
                                            <th>Credits<span class="icon-arrow">&UpArrow;</span></th>
                                            <th>Grade<span class="icon-arrow">&UpArrow;</span></th>
                                            <th>Reg/Arr<span class="icon-arrow">&UpArrow;</span></th>
                                            <th>Status<span class="icon-arrow">&UpArrow;</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
$year = (int) $cardID / 2;
$fin = (int) $year + (int) $batch;
$finsearch = $month . $fin;
$sql = "SELECT sg.*, cst.Credit, cst.SubjectName FROM ptudbtab_studentgrades sg
                                         JOIN result_subject cst ON sg.SubjectCode = cst.SubjectCode
                                        WHERE sg.StudentId = '$ureg' AND sg.Session = '$finsearch' group by sg.SubjectCode";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);

$i = 1;
$c = 0;
$b = 0;
$g = 0;

if ($num > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr class='ra'><td>{$i}.</td>
                                                  <td>{$row['SubjectCode']}</td>
                                                  <td>{$row['SubjectName']}</td>
                                                  <td>{$row['Semester']}</td>
                                                  <td>{$row['Credit']}</td>
                                                  <td>{$row['Grade']}</td>
                                                  <td>{$row['RegArr']}</td>";
        if ($row['Grade'] == 'F') {
            echo "<td><p class='status failed'>Fail</p></td></tr>";
        } elseif ($row['Grade'] == 'Z') {
            echo "<td><p class='status absent'>Absent</p></td></tr>";

        } else {
            echo "<td><p class='status passed'>Pass</p></td></tr>";

        }
        $i++;
    }
}
?>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </main>
                </div>
                <?php

$ce = 0;
$sql = "SELECT cst.Credit, sg.Grade FROM ptudbtab_studentgrades sg join result_subject cst on sg.SubjectCode = cst.SubjectCode where sg.StudentId='$ureg' and sg.Semester='$cardID' GROUP BY sg.SubjectCode";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $c += $row['Credit'];
    }
}

$sql = "SELECT cst.Credit, sg.Grade FROM ptudbtab_studentgrades sg join result_subject cst on sg.SubjectCode = cst.SubjectCode where sg.StudentId='$ureg' and sg.Semester='$cardID' and sg.Grade!='F' and sg.Grade!='Z' GROUP BY sg.SubjectCode";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);

if ($num > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $grade = $row['Grade'];

        switch ($grade) {
            case "S":
                $gradepoint = 10;
                break;
            case "A":
                $gradepoint = 9;
                break;
            case "B":
                $gradepoint = 8;
                break;
            case "C":
                $gradepoint = 7;
                break;
            case "D":
                $gradepoint = 6;
                break;
            case "E":
                $gradepoint = 5;
                break;
            case "F":
                $gradepoint = 0;
                break;
            case "Z":
                $gradepoint = 0;
                break;
            case "P":
                $gradepoint = 0;
                break;
        }

        // echo $num;

        $g += ((float) $gradepoint * (float) $row['Credit']);
        $ce += $row['Credit'];
    }
}

$sql = "SELECT SubjectCode, REPLACE( CASE WHEN COUNT(*) > 1 THEN GROUP_CONCAT(Grade) ELSE MAX(Grade) END, ',', '') AS Grades FROM ptudbtab_studentgrades WHERE StudentId='$ureg' and `Semester`='$cardID' GROUP BY SubjectCode";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);
if ($num > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $constr = $row['Grades'];

        for ($z = 0; $z < strlen($constr); $z++) {
            $char = substr($constr, $z, 1);
            if ($char != "F" && $char != "Z") {
                break;
            }
            if ($z == strlen($constr) - 1) {
                $b += 1;
            }
        }
    }
}
?>
                <div class="dp2">
                    <section>
                        <div class="box">
                            <h4>Overall</h4>
                            <p>TOTAL CREDITS : <?php echo $c; ?></p><br>
                            <p>CREDITS EARNED : <?php echo $ce; ?></p><br>
                            <p>GPA : <?php echo number_format($g / $ce, 3, '.', "") ?></p><br>
                            <p>PERCENTAGE : <?php echo (number_format($g / $ce, 3, '.', "")) * 9.5 ?> %</p><br>
                            <p>BACKLOGS : <?php echo $b; ?></p>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <?php

?>
    <script src="secondpage.js"></script>
</body>

</html>