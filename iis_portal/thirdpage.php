<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="thirdpage.css">
</head>

<body>

<div class="rak">
        <a class="view" href="firstpage.php">&#10094 Back </a>
    </div>



    <div class="dp1">
        <div class="table_header">
            <p>Grade Sheet: </p>
        </div>
        <main class="table">

            <section class="table_body">
                <table>
                    <thead>
                        <tr>
                            <th>Sl.no</th>
                            <th>YEAR</th>
                            <th>SEMESTER</th>
                            <th>GPA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

session_start();
$ureg = $_SESSION["ureg"];

?>
                        <?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "results";

$conn = mysqli_connect($servername, $username, $password, $database);

$query = "SELECT MAX(Semester),Batch FROM ptudbtab_studentgrades where StudentId='$ureg'";
$result = mysqli_query($conn, $query);

// Fetch the result and get the highest value
$row = mysqli_fetch_row($result);
$highest_value = $row[0];
$year = (int) $row[1];
$slno = 0;
$a = 0;
$sgpa = 0;
$y = $year;
$y += 1;
$tc = 0;
$tce = 0;
$tb = 0;
$d = 0;
$p = 1;
$gpa = 0;
$hoa = 0;

for ($i = 1; $i <= $highest_value; $i++) {
    $item = (string) $i;
    $c = 0;
    $ce = 0;
    $b = 0;
    $g = 0;

    $sql = "SELECT cst.Credit, sg.Grade FROM ptudbtab_studentgrades sg join result_subject cst on sg.SubjectCode = cst.SubjectCode where sg.StudentId='$ureg' and sg.Semester='$item' GROUP BY sg.SubjectCode";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $c += $row['Credit'];
        }
    }

    $sql = "SELECT cst.Credit, sg.Grade FROM ptudbtab_studentgrades sg join result_subject cst on sg.SubjectCode = cst.SubjectCode where sg.StudentId='$ureg' and sg.Semester='$item' and sg.Grade!='F' and sg.Grade!='Z' GROUP BY sg.SubjectCode";
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

    $sql = "SELECT SubjectCode, REPLACE( CASE WHEN COUNT(*) > 1 THEN GROUP_CONCAT(Grade) ELSE MAX(Grade) END, ',', '') AS Grades FROM ptudbtab_studentgrades WHERE StudentId='$ureg' and Semester='$item' GROUP BY SubjectCode";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $constr = $row['Grades'];
            for ($z = 0; $z < strlen($constr); $z++) {
                $char = substr($constr, $z, 1);
                if ($char != "F" && $char != "Z") {
                    break;
                }if ($z == strlen($constr) - 1) {
                    $b += 1;

                }
            }
        }
        $tb += $b;
    }

    if ($i % 2 == 1) {
        $slno++;
    }
    $tc += $c;
    $tce += $ce;

    $sgpa += (float) number_format($g / $ce, 3, '.', "");
    echo "<tr>";?>
                            <td data-title="Sl.no" class="raks"><?php if ($i % 2 == 1) {
        echo $slno . '.';
    }?></td>
                            <td data-title="Year" class="raks"><?php if ($i % 2 == 1 && $a == 0) {
        echo $year . ' - ' . $y;
        $a++;
    } else {
        $a--;
        $year += 1;
        $y += 1;
    }?> </td>
                            <td data-title="Semester"><?php echo $item ?>
                            </td>


                            <td data-title="GPA"><?php echo number_format($g / $ce, 3, '.', "") ?></td>
                            </tr>
                    </tbody>

                <?php
}

?>

                </table>
            </section>
        </main>

        <div class="box">
            <h2>Overall</h2>
            <ul>
                <li>TOTAL CREDITS : <span><?php echo $tc; ?></span></li>
                <li>CREDITS EARNED :<span> <?php echo $tce; ?></span></li>
                <li>CGPA : <span><?php echo number_format($sgpa / $highest_value, 3, '.', ""); ?></span> </li>
                <li>PERCENTAGE : <span><?php echo number_format($sgpa / $highest_value, 3, '.', "") * 9.5; ?> %</span></li>
                <li>BACKLOGS :<span> <?php echo $tb ?></span></li>
                
            </ul>
        </div>

        <?php
$sl = 0;
if ($tb > 0) {
    echo "<div class='table_header'>
            <p>Present Backlogs: <p>
        </div>";
    echo " <section class='table_body'><table>
                <thead>
                    <tr>
                        <th>Sl.no</th>
                        <th>Semester</th>
                        <th>Subject</th>
                        <th>Subject code</th>
                        <th>Theory/Lab</th>
                    </tr>
                </thead><tbody class='arrear'>";

    $sql = "SELECT cst.SubjectName,cst.ThLab,sg.Semester,sg.SubjectCode,REPLACE( CASE WHEN COUNT(*) > 1 THEN GROUP_CONCAT(Grade) ELSE MAX(Grade) END, ',', '') AS Grades FROM ptudbtab_studentgrades sg join result_subject cst on sg.SubjectCode=cst.SubjectCode WHERE sg.StudentId='$ureg' GROUP BY sg.SubjectCode";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            $constr = $row['Grades'];

            for ($z = 0; $z < strlen($constr); $z++) {
                $char = substr($constr, $z, 1);
                if ($char != "F" && $char != "Z") {
                    break;
                }if ($z == strlen($constr) - 1) {
                    $sl++;
                    echo "
                                        <tr><td>{$sl}.</td>
                                        <td>{$row['Semester']}</td>
                                        <td>{$row['SubjectName']}</td>
                                        <td>{$row['SubjectCode']}</td>
                                        <td>{$row['ThLab']}</td></tr>";
                }
            }
        }
    }
    echo "</tbody>
                            </table></section>";


echo "<div class='table_header'>
            <p>History of Arrears: <p>
        </div>";
    echo " <section class='table_body'><table>
                <thead>
                    <tr>
                        <th>Sl.no</th>
                        <th>Semester</th>
                        <th>Subject</th>
                        <th>Subject code</th>
                        <th>Theory/Lab</th>
                    </tr>
                </thead><tbody class='arrear'>";
                
    $sql = "SELECT cst.SubjectName, cst.ThLab, sg.Semester, sg.SubjectCode, sg.Grade
    FROM ptudbtab_studentgrades sg
    JOIN result_subject cst ON sg.SubjectCode = cst.SubjectCode
    WHERE sg.StudentId = '$ureg' AND sg.Grade IN ('F', 'Z')
    GROUP BY sg.SubjectCode;
    ";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
                    $hoa++;
           
                    echo "
                                        <tr><td>{$hoa}.</td>
                                        <td>{$row['Semester']}</td>
                                        <td>{$row['SubjectName']}</td>
                                        <td>{$row['SubjectCode']}</td>
                                        <td>{$row['ThLab']}</td></tr>";
                }
            }
        
    
    echo "</tbody>
                            </table></section>";

}
?>
    
    </div>
    <div class="viewreport">
        <a href="report.php"><span></span><span></span><span></span><span></span>View Report</a>
    </div>
</body>
</html>