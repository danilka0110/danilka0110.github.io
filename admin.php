<?php
require "db.php";
?>

<?php if (isset($_SESSION['logged_user'])) : ?>

<?php 

if ($_SESSION['logged_user']->adm == "1") {
    echo ('<a href="../index.php">Главная</a><br>
    <a href="admin/data-users.php">Пользователи</a><br>
    <a href="admin/data-tests.php">Тесты</a>');
} else  {
    echo '<meta http-equiv = "Refresh" content = "0; URL = index.php">';
}

?>

<?php else : ?>

    <?php 
        echo '<meta http-equiv = "Refresh" content = "0; URL = index.php">';
        ?>
    
<?php endif; ?>





