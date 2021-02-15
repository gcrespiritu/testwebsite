<?php
if (!isset($_REQUEST["name"])) {
    die("Name parameter missing");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Abdelrahman Saeed</title>
</head>

<body>
    <div align="center">
        <h1>Auto Database Screen</h1>
        <a href="logout.php">Logout</a>
        <br>
        <br>
        <br>
        <?php
        require_once "pdo.php";
        $stmt = $pdo->query("SELECT make, year, mileage,auto_id FROM autos");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div style="width: auto;text-align: center;
  list-style-position: inside;">
            <h1>vehicles in the list</h1>
            <ol>
                <?php
                foreach ($rows as $row) {
                    echo '<li style="text-wight:bold"><b>' . $row['make'] . '</b></li>';
                }
                ?>
            </ol>
        </div>

        <table border="1">
            <?php
            $ctr = 1;
            foreach ($rows as $row) {
                echo "<tr><td>";
                echo ($ctr);
                echo "</td><td>";
                echo ($row['make']);
                echo ("</td><td>");
                echo ($row['year']);
                echo ("</td><td>");
                echo ($row['mileage']);
                echo ("</td><td>");
                echo ('<form method="post"><input type="hidden" ');
                echo ('name="auto_id" value="' . $row['auto_id'] . '">' . "\n");
                echo ('<input type="submit" value="Del" name="delete">');
                echo ("\n</form>\n");
                echo ("</td></tr>\n");
                $ctr++;
            }
            ?>
        </table>
        <p>Add A New User</p>
        <form method="post">
            <table>
                <tr>
                    <td>
                        Make
                    </td>
                    <td>
                        <input type="text" name="make" size="40">
                    </td>
                </tr>
                <tr>
                    <td>
                        Year
                    </td>
                    <td>
                        <input type="text" name="year">
                    </td>
                </tr>
                <tr>
                    <td>
                        Mileage
                    </td>
                    <td>
                        <input type="text" name="mileage">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="Add New" />
                    </td>
                    <td>

                    </td>
                </tr>
            </table>
        </form>



        <?php

        if (isset($_POST['delete']) && isset($_POST['auto_id'])) {
            $sql = "DELETE FROM autos WHERE auto_id = :zip";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(':zip' => $_POST['auto_id']));
            echo "<h3 style='color:green;text-align:center'>Record deleted.</h3>\n";
        } else {
            $make =  htmlentities($_POST['make']);
            $year =  htmlentities($_POST['year']);
            $mileage =  htmlentities($_POST['mileage']);
            if (is_numeric($year) && is_numeric($mileage)) {
                if ($make) {
                    $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)');
                    $stmt->execute(
                        array(
                            ':mk' => $make,
                            ':yr' => $year,
                            ':mi' => $mileage
                        )
                    );
                    echo "<h3 style='color:green;text-align:center'>Record inserted.</h3>\n";
                } else {
                    echo "<h3 style='color:red;text-align:center'>Make is required.</h3>\n";
                }
            } else {
                echo "<h3 style='color:red;text-align:center'>Mileage and Year must be numeric.</h3>\n";
            }
        }
        ?>
    </div>
</body>

</html>