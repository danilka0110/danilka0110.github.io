<?php
require "../db.php";
?>

<?php if (isset($_SESSION['logged_user'])) : ?>

<?php 
if ($_SESSION['logged_user']->adm == "1") {
    echo ('<a href="../admin.php">Назад</a><br>');
    echo ('<hr><form action="data-users.php" method="post" name="form">
    <input name="login" type="text" placeholder="Введите логин пользователя"></p> 
    <input name="submit" type="submit" value="Удалить"></p>');
    $user = R::getAll('SELECT * FROM users');
    foreach ($user as $row){
    echo '<hr>' . 'id: ' . $row['id'] . '<br>';
    echo 'login: ' . $row['login'] . '<br>';
    echo 'email: ' . $row['email'] . '<br>';
    echo 'adm: ' . $row['adm'] . '<br><br>';
}
} else  {
    echo '<meta http-equiv = "Refresh" content = "0; URL = ../index.php">';
}

if (isset($_POST[login])) {
    $login =$_POST[login];
}
if (isset($_POST[submit])) {
    $find = R::findOne('users', 'login = ?',[$login]);
    if (empty($find)) {
        echo "<script>alert('Пользователь не найден')</script>";
    } else {
        $delete = R::load('users', $find->id);
        R::trash($delete);
        echo "<script>alert('Пользователь удален')</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
</body>
</html>

<?php else : ?>

    <?php 
        echo '<meta http-equiv = "Refresh" content = "0; URL = ../index.php">';
        ?>
    
<?php endif; ?>