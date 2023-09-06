
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="report.css">

</head>

<body>
  <?php
session_start();
$ureg = $_SESSION["ureg"];
$servername = "localhost";
$username = "root";
$password = "";
$database = "results";

$conn = mysqli_connect($servername, $username, $password, $database);

$dep = substr($ureg, 2, 2);



$deptMap = array(
    'CS' => 'Computer Science And Engineering',
    'EC' => 'Electronics And Communication Engineering',
    'ME' => 'Mechanical Engineering',
    'EE' => 'Electrical And Electronics Engineering',
    'CE' => 'Civil Engineering',
    'CH' => 'Chemical Engineering',
    'EI' => 'Electrical And Instrumentation Engineering',
    'IT' => 'Information Technology',
    'MT' => 'Mechatronics Engineering',
);

$dept = isset($deptMap[$dep]) ? $deptMap[$dep] : '';

$sql = "SELECT * FROM `ptudbtab_studentgrades` where StudentId='$ureg'";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);

if ($num > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $name = $row['StudentName'];
        $reg = $row['StudentId'];
        $pro = $row['Programme'];

    }
}
?>



  <main class="table" id="customers_table">
    <div class="dptime">
      <?php
date_default_timezone_set('UTC');
$currentDateTime = date('Y-m-d H:i:s');
echo " <span id='datetime'>$currentDateTime</span>";
echo "<script>setInterval(function() {
    var datetime = new Date();
    document.getElementById('datetime').innerHTML = datetime.toLocaleString();
}, 1000);</script>";
?>
    </div>

    <div class="con">
      <div class="heading">
        <img class="logo" src="Images/PTUlogo.png">
        <div class="con1">
          <h2 class="dp1">PUDUCHERRY TECHNOLOGICAL UNIVERSITY IIS PORTAL</h2>
          <h3 class="dp2">DEPARTMENT OF <span style="text-transform:uppercase;"> <?php echo $dept; ?></span></h3>
        </div>
      </div>



      <div class="export__file">
        <p class="printdata">Download Report</p>
        <label for="export-file" class="export__file-btn" title="Export File"></label>
        <input type="checkbox" id="export-file">
        <div class="export__file-options">
          <label>Export As &nbsp; &#10140;</label>
          <label for="export-file" id="toPDF">PDF <img src="Images/pdf.png" alt=""></label>
          <label for="export-file" id="toJSON">JSON <img src="Images/json.png" alt=""></label>
          <label for="export-file" id="toCSV">CSV <img src="Images/csv.png" alt=""></label>
          <label for="export-file" id="toEXCEL">EXCEL <img src="Images/excel.png" alt=""></label>
        </div>
      </div>




      <section class="table__header">
        <table style="width:100%">
          <tr>
            <th>Register number</th>
            <td><?php echo $reg; ?></td>
          </tr>
          <tr>
            <th>Name</th>
            <td><?php echo $name; ?></td>
          </tr>
          <tr>
            <th>Programme</th>
            <td><?php echo $pro; ?></td>
          </tr>
          <tr>
            <th>Department</th>
            <td><?php echo $dept; ?></td>
          </tr>
        </table>



      </section>
      <main class="table" id="json_table">

        <?php
$query = "SELECT MAX(Semester),Batch FROM ptudbtab_studentgrades where StudentId='$ureg'";
$result = mysqli_query($conn, $query);

// Fetch the result and get the highest value
$row = mysqli_fetch_row($result);
$highest_value = $row[0];
$batch = (int) $row[1];
$batch2 = $batch;
$slno = 0;
$a = 0;
$y = $batch2;
$y += 1;
$tc = 0;
$tce = 0;
$tb = 0;
$d = 0;
$p = 1;
$sgpa = 0;

for ($i = 1; $i <= $highest_value; $i++) {
    $item = (string) $i;
    echo " ";?>
          <div class="cl">
            <p>
              <?php if ($i % 2 == 1 && $a == 0) {
        echo 'ACADEMIC YEAR: ' . $batch2 . ' - ' . $y;
        $a++;
    } else {
        echo 'ACADEMIC YEAR: ' . $batch2 . ' - ' . $y;
        $a--;
        $batch2 += 1;
        $y += 1;
    }?>
                 </p>
            <p><?php echo 'SEMESTER: ' . $item ?></p>
          </div>
          <?php
echo "<div class='hi'><table class='table1'>

                      <thead>
                      <tr>
                        <th>Sl.no</th>
                        <th>Subject Code</th>
                        <th>Subject Name</th>

                        <th>Credits</th>
                        <th>Grade</th>
                        <th>Regular/Arrear</th>
                        <th>Status</th>
                      </tr>
                      </thead>
                      <tbody>";

    if ($item % 2 == 0) {
        $month = 'MAY ';
    } else {
        $month = 'DECEMBER ';
    }
    $year = (int) $item / 2;
    $fin = (int) $year + (int) $batch;
    $finsearch = $month . $fin;
    $sql = "SELECT sg.*, cst.Credit, cst.SubjectName FROM ptudbtab_studentgrades sg
                                         JOIN result_subject cst ON sg.SubjectCode = cst.SubjectCode
                                        WHERE sg.StudentId = '$ureg' AND sg.Session = '$finsearch' group by sg.SubjectCode";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    $sl = 1;
    $c = 0;
    $b = 0;
    $g = 0;

    if ($num > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr class='ra'><td>{$sl}.</td>
                                    <td>{$row['SubjectCode']}</td>
                                    <td>{$row['SubjectName']}</td>

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
            $sl++;
        }

    }

    $ce = 0;
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
    $hoa=0;
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
        }
      }

    $sql = "SELECT SubjectCode, REPLACE( CASE WHEN COUNT(*) > 1 THEN GROUP_CONCAT(Grade) ELSE MAX(Grade) END, ',', '') AS Grades FROM ptudbtab_studentgrades WHERE StudentId='$ureg' and `Semester`='$item' GROUP BY SubjectCode";
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

    $sgpa += (float) number_format($g / $ce, 3, '.', "");
    echo "</tr></tbody></table> ";
    $tc += $c;
    $tce += $ce; ?>



          <div class="hi2">
            <p>TOTAL CREDITS : <?php echo $c; ?></p>
            <p>CREDITS EARNED : <?php echo $ce; ?></p>
            <p>GPA : <?php echo number_format($g / $ce, 3, '.', "") ?></p>
            <p>PERCENTAGE : <?php echo (number_format($g / $ce, 3, '.', "")) * 9.5 ?> %</p>
            <p>BACKLOGS : <?php echo $b; ?></p>
            
          </div>
        <?php echo "</div>";
}
?>

      </main>


      <section class="table__header">
        <h3>Overall:</h3>
        <table style="width:100%">
          <tr>
            <th>Total Credits</th>
            <td><?php echo $tc; ?></td>
          </tr>
          <tr>
            <th>Credits Earned</th>
            <td><?php echo $tce; ?></td>
          </tr>
          <tr>
            <th>CGPA</th>
            <td><?php echo number_format($sgpa / $highest_value, 3, '.', ""); ?></td>
          </tr>
          <tr>
            <th>Percentage</th>
            <td><?php echo number_format($sgpa / $highest_value, 3, '.', "") * 9.5; ?> </td>
          </tr>
          <tr>
            <th>Backlogs</th>
            <td><?php echo $tb ?></td>
          </tr>
          <tr>
            <th>History of Arrears</th>
            <td><?php echo $hoa ?></td>
          </tr>
        </table>
      </section>
  </main>
  </div>

  <script src="report.js"></script>
</body>

</html>