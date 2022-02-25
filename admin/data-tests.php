<?php
require "../db-tests-rb.php"
?>

<?php if (isset($_SESSION['logged_user'])) : ?>

    <?php
    include_once  '../db-tests.php';


    if ($_SESSION['logged_user']->adm == "1") {
        echo ('<a href="../admin.php">Назад</a><br>');
        echo ('<hr><form action="data-tests.php" method="post" name="form">
        <input name="id" type="text" placeholder="Введите логин пользователя"></p> 
        <input name="submit" type="submit" value="Удалить"></p>');
        $test = R::getAll('SELECT * FROM tests');
        foreach ($test as $row){
            echo '<hr>' . 'id: ' . $row['id'] . '<br>';
            echo 'title: ' . $row['title'] . '<br>';
        }
    } else  {
        echo '<meta http-equiv = "Refresh" content = "0; URL = ../index.php">';
    }
    
    if (isset($_POST[id])) {
        $id =$_POST[id];
    }

    if (isset($_POST[submit])) {
        $find = R::findOne('tests', 'id = ?',[$id]);
        if (empty($find)) {
            echo "<script>alert('Тест не найден')</script>";
        } else {
            $delete = R::load('tests', $find->id);
            R::trash($delete);
            echo "<script>alert('Тест удален')</script>";
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