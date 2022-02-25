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
                    <h2 class="text-uppercase text-center mb-5">Регистрация</h2>
                    <form action="reg.php" method="POST">

                        <div class="form-outline mb-4">
                        <input type="login" class="form-control form-control-lg" placeholder = "Логин" name="login" value="<?php echo @$data['login'] ?>">
                        </div>

                        <div class="form-outline mb-4">
                        <input type="email" class="form-control form-control-lg" placeholder = "Email" name="email" value="<?php echo @$data['email'] ?>">
                        </div>

                        <div class="form-outline mb-4">
                        <input type="password" class="form-control form-control-lg" placeholder = "Пароль" name="password" value="<?php echo @$data['password'] ?>">
                        </div>

                        <div class="form-outline mb-4">
                        <input type="password" class="form-control form-control-lg" placeholder = "Введите пароль еще раз" name="password_2" value="<?php echo @$data['password_2'] ?>">
                        </div>
                            <?php
                                $data = $_POST;
                                if(isset($data['reg']))
                                {
                                    $errors = array();
                                    if(trim($data['login']) == '') {
                                        $errors[] = 'Введите логин!';
                                    }
                                    
                                    if(trim($data['email']) == '') {
                                        $errors[] = 'Введите Email!';
                                    }
                            
                                    if(($data['password']) == '') {
                                        $errors[] = 'Введите пароль!';
                                    }
                            
                                    if($data['password_2'] != $data['password'])
                                    {
                                        $errors[] = 'Пароли не совпадают';
                                    }
                            
                                    if(R::count('users', "login = ?", array($data['login'])) > 0 )
                                    {
                                        $errors[] = 'Пользователь с таким логином уже зарегистрирован!';
                                    }
                            
                                    if(R::count('users', "email = ?", array($data['email'])) > 0 )
                                    {
                                        $errors[] = 'Пользователь с таким Email уже зарегистрирован!';
                                    }
                                    
                            
                                    if(empty($errors))
                                    {
                                        $user = R::dispense('users');
                                        $user->login = $data['login'];
                                        $user->email = $data['email'];
                                        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
                                        R::store($user);
                                        echo '<div style="color: green;">Вы успешно зарегистрировались!</div><hr>';
                                        echo '<meta http-equiv = "Refresh" content = "0; URL = index.php">'; // redirect
                                    } else
                                    {
                                        echo '<div style="color: red;">'.array_shift($errors).'</div><br>';
                                    }
                                }               
                            ?>
                        <div class="form-check d-flex justify-content-center mb-4">
                        <input
                            class="form-check-input me-2"
                            type="checkbox"
                            value=""
                            id="form2Example3cg"
                        />
                        <label class="form-check-label">
                            Я соглашаюсь с <a href="#!" class="text-body"><u>правилами пользования</u></a> сайта
                        </label>
                        </div>

                        <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body" name="reg">Зарегистрироваться</button>
                        </div>

                        <p class="text-center text-muted mt-4 mb-0">Уже зарегистрированы? <a href="login.php" class="fw-bold text-body"><u>Войти</u></a></p>

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