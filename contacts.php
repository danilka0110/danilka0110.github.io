<?php
require "db.php"
?>
<?php if (isset($_SESSION['logged_user'])) : ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тесты</title>
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php" style="margin-right: 130px">MySite</a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link" href="tests.php">Тесты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="surveys.php">Опросы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacts.php" style="margin-right: 80px">Контакты</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-expanded="false">Профиль</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="account.php"><span style="color: #000; margin-right: 20px;">
                                        <?php echo $_SESSION['logged_user']->login; ?>
                                    </span></a></li>
                            <li><a class="dropdown-item" href="create-test.php">Создать тест</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/logout.php" style="color: #000">Выйти</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<div class="page">
    <div class="container text-center">
        <br>
        <div class="card mt-0">
        <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A2c90f656f3e41b93082a78e693846616d550615c015d3188fc37e8eb2b4ab846&amp;width=100%&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>
        <br><br>
            <div class="row">
                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                    <p>г. Москва, ул. 800-летия Москвы, 28к1</p>
                    <p>yung-donil@yandex.ru</p>
                    <p>+7 (977) 718-04-02</p>
                </div>
                <br><br><br><br><br><br>
                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                    <p>Lorem, ipsum dolor.</p>
                    <p>Lorem, ipsum dolor.</p>
                    <p>Lorem, ipsum dolor.</p>
                </div>
                <br><br><br><br><br><br>
                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                    <p>Lorem, ipsum dolor.</p>
                    <p>Lorem, ipsum dolor.</p>
                    <p>Lorem, ipsum dolor.</p>
                </div>
            </div>
        </div>
        <br>
    </div>
</div>

<footer class="text-center text-lg-start text-white" style="background-color: #1c2331">
        <section class="p-1">
            <div class="container text-center text-md-start mt-5">
                <div class="row mt-3">
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold">MyTestSite</h6>
                        <hr class="mb-4 mt-0 d-inline-block mx-auto"
                            style="width: 60px; background-color: #7c4dff; height: 2px" />
                        <p>
                            Здесь информация о сайте
                        </p>
                    </div>
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold">Навигация</h6>
                        <hr class="mb-4 mt-0 d-inline-block mx-auto"
                            style="width: 60px; background-color: #7c4dff; height: 2px" />
                        <p>
                            <a href="#!" class="text-white">MySite</a>
                        </p>
                        <p>
                            <a href="#!" class="text-white">Тесты</a>
                        </p>
                        <p>
                            <a href="#!" class="text-white">Опросы</a>
                        </p>
                        <p>
                        <a href="#!" class="text-white">Контакты</a>
                        </p>
                    </div>
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold">Контакты</h6>
                        <hr class="mb-4 mt-0 d-inline-block mx-auto"
                            style="width: 60px; background-color: #7c4dff; height: 2px" />
                        <p><i class="fas fa-home mr-3"></i> г. Москва</p>
                        <p><i class="fas fa-envelope mr-3"></i> yung-donil@yandex.ru</p>
                        <p><i class="fas fa-phone mr-3"></i> +7 (977) 718-04-02</p>
                    </div>
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <h6 class="text-uppercase fw-bold">Наши соц. сети</h6>
                        <hr class="mb-4 mt-0 d-inline-block mx-auto"
                            style="width: 60px; background-color: #7c4dff; height: 2px" />
                        <p>
                            <a href="#!" class="text-white">VK</a>
                        </p>
                        <p>
                            <a href="#!" class="text-white">Instagram</a>
                        </p>
                        <p>
                            <a href="#!" class="text-white">Facebook</a>
                        </p>
                        <p>
                            <a href="#!" class="text-white">Twitter</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
            © 2022 Copyright
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</body>
</html>

<?php else : ?>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тесты</title>
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item" style="margin-left: 220px">
                    
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php" style="margin-right: 130px">MySite</a>
                </li>
                <li class=" nav-item">
                    <a class="nav-link" href="tests.php">Тесты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="surveys.php">Опросы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contacts.php" style="margin-right: 130px">Контакты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Войти</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reg.php">Зарегистрироваться</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="page">
    <div class="container text-center">
        <br>
        <div class="card mt-0">
        <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A2c90f656f3e41b93082a78e693846616d550615c015d3188fc37e8eb2b4ab846&amp;width=100%&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>
        <br><br>
            <div class="row">
                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                    <p>г. Москва, ул. 800-летия Москвы, 28к1</p>
                    <p>yung-donil@yandex.ru</p>
                    <p>+7 (977) 718-04-02</p>
                </div>
                <br><br><br><br><br><br>
                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                    <p>Lorem, ipsum dolor.</p>
                    <p>Lorem, ipsum dolor.</p>
                    <p>Lorem, ipsum dolor.</p>
                </div>
                <br><br><br><br><br><br>
                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                    <p>Lorem, ipsum dolor.</p>
                    <p>Lorem, ipsum dolor.</p>
                    <p>Lorem, ipsum dolor.</p>
                </div>
            </div>
        </div>
        <br>
    </div>
</div>

<footer class="text-center text-lg-start text-white" style="background-color: #1c2331">
        <section class="p-1">
            <div class="container text-center text-md-start mt-5">
                <div class="row mt-3">
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold">MyTestSite</h6>
                        <hr class="mb-4 mt-0 d-inline-block mx-auto"
                            style="width: 60px; background-color: #7c4dff; height: 2px" />
                        <p>
                            Здесь информация о сайте
                        </p>
                    </div>
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold">Навигация</h6>
                        <hr class="mb-4 mt-0 d-inline-block mx-auto"
                            style="width: 60px; background-color: #7c4dff; height: 2px" />
                        <p>
                            <a href="#!" class="text-white">MySite</a>
                        </p>
                        <p>
                            <a href="#!" class="text-white">Тесты</a>
                        </p>
                        <p>
                            <a href="#!" class="text-white">Опросы</a>
                        </p>
                        <p>
                        <a href="#!" class="text-white">Контакты</a>
                        </p>
                    </div>
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold">Контакты</h6>
                        <hr class="mb-4 mt-0 d-inline-block mx-auto"
                            style="width: 60px; background-color: #7c4dff; height: 2px" />
                        <p><i class="fas fa-home mr-3"></i> г. Москва</p>
                        <p><i class="fas fa-envelope mr-3"></i> yung-donil@yandex.ru</p>
                        <p><i class="fas fa-phone mr-3"></i> +7 (977) 718-04-02</p>
                    </div>
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <h6 class="text-uppercase fw-bold">Наши соц. сети</h6>
                        <hr class="mb-4 mt-0 d-inline-block mx-auto"
                            style="width: 60px; background-color: #7c4dff; height: 2px" />
                        <p>
                            <a href="#!" class="text-white">VK</a>
                        </p>
                        <p>
                            <a href="#!" class="text-white">Instagram</a>
                        </p>
                        <p>
                            <a href="#!" class="text-white">Facebook</a>
                        </p>
                        <p>
                            <a href="#!" class="text-white">Twitter</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
            © 2022 Copyright
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
</body>
</html>

    
<?php endif; ?>
