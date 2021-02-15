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
        <p>Registeration</p>
        <form method="post">
            <table>
                <tr>
                    <td>Name</td>
                    <td><input type="text" size="40" name="name"></td>
                </tr>
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
                        <input type="submit" value="Register" />
                    </td>
                    <td>
                        <a href="<?php echo ($_SERVER['PHP_SELF']); ?>">Refresh</a>
                        <a href="index.php">Home</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>

<?php
require_once "pdo.php";

$name = htmlentities($_POST['name']);
$email =  htmlentities($_POST['email']);
$password =  htmlentities($_POST['password']);

if ($email  && $password && $name) {
    $sql = "SELECT name FROM users
        WHERE email = :em";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':em' => $email
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row === FALSE) {
        if (strpos($email, '@') !== false) {
            $sql = "INSERT INTO users (name, email, password)
            VALUES (:name, :email, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':name' => $name,
                ':email' => $email,
                ':password' => password_hash($password, PASSWORD_DEFAULT)
            ));
            error_log("Register success " . $name);
            echo "<h3 style='color:green;text-align:center'>registeration done, now you can login from <a href='login.php'>her.</a></h3>\n";
        } else {
            echo "<h3 style='color:red;text-align:center'>Email must have an at-sign (@)</h3>\n";
        }
    } else {
        echo "<h3 style='color:red;text-align:center'>Entered email already exists.</h3>\n";
    }
} else {
    echo "<h3 style='color:red;text-align:center'>All input are required.</h3>\n";
}
?>