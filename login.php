<?php
    require "db.php";
?>

<?php if (isset($_SESSION['logged_user'])) : ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<meta http-equiv = "Refresh" content = "0; URL = index.php">
</body>
</html>

<?php else : ?>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
    integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" /> 
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Авторизация</title>
</head>
<body>
<div class="box">
    <section class="vh-100">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                <div class="card" style="border-radius: 50px;">
                    <div class="card-body p-5">
                    <h2 class="text-uppercase text-center mb-5">Авторизация</h2>
                    <form action="login.php" method="POST">
                        <div class="form-outline mb-4">
                        <input type="login" class="form-control form-control-lg" placeholder = "Логин" name="login" value="<?php echo @$data['login'] ?>">
                        </div>
                        <div class="form-outline mb-4">
                        <input type="password" class="form-control form-control-lg" placeholder = "Пароль" name="password" value="<?php echo @$data['password'] ?>">
                        </div>
                        <?php
                            $data = $_POST;

                            if(isset($data['log']))
                            {
                                $errors = array();
                                $user = R::findOne('users', 'login = ?', array($data['login']));

                                if($user)
                                {                           
                                    //логин существует, проверяем пароль
                                    if(password_verify($data['password'], $user->password))
                                    {
                                        $_SESSION['logged_user'] = $user;
                                        echo '<div style="color: green;">Вы успешно авторизовались!</div><hr>';

                                        echo '<meta http-equiv = "Refresh" content = "0; URL = index.php">'; // redirect
                                        exit();

                                    } else 
                                    {
                                        $errors[] = 'Пароль введен неверно!';
                                    }
                                } else
                                {
                                    $errors[] = 'Пользователь с таким логином не найден!';
                                }

                                if(!empty($errors))
                                {
                                    echo '<div style="color: red;">'.array_shift($errors).'</div>';
                                }
                            }
                            ?>
                        <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body" name="log">Войти</button>
                        </div>

                        <p class="text-center text-muted mt-4 mb-0" >Еще не зарегистрированы? <a href="reg.php" class="fw-bold text-body"><u>Зарегистрироваться</u></a></p>

                    </form>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </section>
</div>
</body>
</html>

<?php endif; ?>