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
        <p>Please Login</p>
        <form method="post">
            <table>
                <tr>
                    <td>Email</td>
                    <td><input type="text" size="40" name="email"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="text" size="40" name="password"></td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="Login" />
                    </td>
                    <td>
                        <a href="<?php echo ($_SERVER['PHP_SELF']); ?>">Refresh</a>
                        <a href="index.php">Home</a>
                        <a href="register.php">Register</a>
                    </td>

                </tr>
            </table>
        </form>
    </div>
</body>

</html>

<?php
require_once "pdo.php";

$email =  htmlentities($_POST['email']);
$password =  htmlentities($_POST['password']);

if ($email && $password) {
    if ($_POST['email'] == "" || $_POST['password'] = "") {
        echo "<h3 style='color:red;text-align:center'>Email and password are required.</h3>\n";
    } else {

        if (strpos($email, '@') !== false) {
            $sql = "SELECT * FROM users
            WHERE email = :em";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':em' => $_POST['email'],
            ));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row === FALSE) {
                echo "<h3 style='color:red;text-align:center'>Login incorrect.</h3>\n";
            } else {
                if (!password_verify($password, $row["password"])) {
                    error_log("Login fail " . $_POST['who'] . "$row");
                    echo "<h3 style='color:red;text-align:center'>Incorrect password.</h3>\n";
                } else {
                    error_log("Login success " . $row['name']);
                    header("Location: autos.php?name=" . urlencode($row['name']));
                }
            }
        } else {
            echo "<h3 style='color:red;text-align:center'>Email must have an at-sign (@)</h3>\n";
        }
    }
} else {
    echo "<h3 style='color:red;text-align:center'>All input are required.</h3>\n";
}
?>