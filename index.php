<?php
require "db.php"
?>

<?php if (isset($_SESSION['logged_user'])) : ?>
<?php
    include_once  'db-tests.php';
    session_start();

    $id = (int) $_GET['id'];

    $testId = $id;
    if (!isset($_SESSION['test_id']) || $_SESSION['test_id'] != $testId) {
        $_SESSION['test_id'] = $testId;
        $_SESSION['test_score'] = 0;
    }

    $res = $db->query("SELECT * FROM tests WHERE id = {$testId}");
    $row = $res->fetch();
    $testTitle = $row['title'];

    $questionNum = (int) $_POST['q'];
    if (empty($questionNum)) {
        $questionNum = 0;
    }
    $questionNum++;
    $questionStart = $questionNum - 1;

    $res = $db->query("SELECT count(*) AS count FROM questions WHERE test_id = {$testId}");
    $row = $res->fetch();
    $questionCount = $row['count'];

    $answerId = (int) $_POST['answer_id'];
    if (!empty($answerId)) {
        $res = $db->query("SELECT * FROM answers WHERE id = {$answerId}");
        $row = $res->fetch();
        $score = $row['score'];
        $_SESSION['test_score'] += $score;
    }

    $showForm = 0;
    if ($questionCount >= $questionNum) {
        $showForm = 1;

        $res = $db->query("SELECT * FROM questions WHERE test_id = {$testId} LIMIT {$questionStart}, 1");
        $row = $res->fetch();
        $question = $row['question'];
        $questionId = $row['id'];

        $res = $db->query("SELECT * FROM answers WHERE question_id = {$questionId}");
        $answers = $res->fetchAll();
    } else {
        $score = $_SESSION['test_score'];

        $res = $db->query("SELECT * FROM results WHERE test_id = {$testId} AND score_min <= {$score} AND score_max >= {$score}");
        $row = $res->fetch();
        $result = $row['result'];
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyTestSite</title>
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>
</head>
<body>
    <div class="box">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
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
                            <a class="nav-link" href="contacts.php" style="margin-right: 80px">Контакты</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="account.php" id="navbarDropdown" role="button"
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
        <div class="main-hi">
            <section class="vh-100">
                <div class="mask d-flex align-items-center h-100 gradient-custom-3">
                    <div class="container h-100">
                        <div class="row d-flex justify-content-center align-items-center h-100">
                            <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                                <div class="card" style="border-radius: 50px;">
                                    <div class="card-body p-5">
                                        <h3 class="text-center mb-3">Приветствую!</h2>
                                        <div class="form-outline mb-4">
                                            <div class="spinner-grow spinner-grow-sm" role="status">
                                                <span class="visually-hidden">Загрузка...</span>
                                            </div>
                                            <span>Рад тебя приветствовать на нашем сайте!</span>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <div class="spinner-grow spinner-grow-sm" role="status">
                                                <span class="visually-hidden">Загрузка...</span>
                                            </div>
                                            <span>На сайте вы можете пройти тесты</span>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <div class="spinner-grow spinner-grow-sm" role="status">
                                                <span class="visually-hidden">Загрузка...</span>
                                            </div>
                                            <span>При условии регистрации, Вы сможете их создавать!</span>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <div class="spinner-grow spinner-grow-sm" role="status">
                                                <span class="visually-hidden">Загрузка...</span>
                                            </div>
                                            <span>Если готов, жми "Поехали!"</span>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-success btn-block btn-lg text-body"
                                                name="reg"
                                                onclick="window.location.href='#content'">Поехали!</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
    <div class="page" id="content">
        <br><br>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="serviceBox">
                        <div class="service-icon">
                            <i class="fa fa-globe"></i>
                        </div>
                        <div class="service-content">
                            <h3 class="title">MySite</h3>
                            <p class="description">
                                Какая-нибудь инфа о сайте + Какая-нибудь инфа о сайте + Какая-нибудь инфа о сайте + Какая-нибудь инфа о сайте
                            </p>
                        </div>
                        <a href="index.php" class="read">Подробнее</a>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="serviceBox">
                        <div class="service-icon">
                            <i class="fa fa-rocket"></i>
                        </div>
                        <div class="service-content">
                            <h3 class="title">Прохождение тестов</h3>
                            <p class="description">
                                На нашем сайте вы можете проверить свои знания по какой-либо тематике. Чтобы приступить к выполнению тестов нажмите "Вперед!"
                            </p>
                        </div>
                        <a href="tests.php" class="read">Вперед!</a>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="serviceBox">
                        <div class="service-icon">
                            <i class="fa fa-briefcase"></i>
                        </div>
                        <div class="service-content">
                            <h3 class="title">Конструктор тестов</h3>
                            <p class="description">
                            На нашем сайте вы можете проверить свои знания по какой-либо тематике. Чтобы приступить к выполнению тестов нажмите "Вперед!"
                            </p>
                        </div>
                        <a href="create-test.php" class="read">Вперед!</a>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="serviceBox">
                        <div class="service-icon">
                            <i class="fa fa-mobile"></i>
                        </div>
                        <div class="service-content">
                            <h3 class="title">Контакты</h3>
                            <p class="description">
                             г. Москва <br>
                            yung-donil@yandex.ru <br>
                            +7 (977) 718-04-02 <br>
                            Нажмите "Подробнее"
                            </p>
                        </div>
                        <a href="contacts.php" class="read">Подробнее</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row align-items-center text-center info-row mt-5">
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 info-box">
                    Пользователей
                    <br>
                    <span>#</span>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 info-box">
                    Тестов
                    <br>
                    <span>
                        <?php
                        $res = $db->query("SELECT count(id) FROM tests");
                        $row = $res->fetch();
                        $count = $row[0];
                        echo $count
                    ?>
                    </span>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 info-box">
                    Что-то еще
                    <br>
                    <span>#</span>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 info-box">
                    Что-то еще
                    <br>
                    <span>#</span>
                </div>
            </div>
        </div>
        <div class="container card">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur, perferendis! Dolorem voluptate earum
            similique iste, molestiae officia accusamus beatae voluptatibus sint rem eius consequatur et nostrum totam
            eaque maiores unde tempore at dignissimos quisquam placeat culpa dolores nihil sequi? Tempore sequi totam,
            temporibus ipsam reprehenderit quod vero laudantium iusto mollitia ullam cupiditate, reiciendis facere
            nulla! Accusantium assumenda ea incidunt tempore quos reprehenderit unde aperiam voluptas soluta ad cum
            porro, labore architecto a repellendus quidem quas voluptatum ipsam animi? Culpa rem reiciendis animi, ut
            saepe nisi laudantium aliquam repellat, fuga ipsa ipsam. Iste ut fugiat pariatur reiciendis dicta vitae
            nobis maxime. Iure assumenda doloribus adipisci enim non illum nemo quod sapiente voluptatum? Corporis nisi
            quod necessitatibus veritatis ut accusamus placeat nulla molestiae velit corrupti magnam a cum asperiores
            nobis error sequi temporibus porro nam quisquam iusto, adipisci ipsa inventore consequatur. Incidunt aperiam
            fugiat inventore mollitia vero nam perspiciatis autem! Obcaecati totam esse cumque consectetur quasi
            accusamus voluptatibus, necessitatibus vel deleniti officia optio sequi dolores aspernatur ipsam pariatur
            quibusdam dicta nobis. Quisquam cupiditate excepturi vero maiores reprehenderit repellat voluptate a
            doloribus aperiam dolores accusantium sunt libero totam voluptates quas quidem dolorem, optio fugit adipisci
            hic sit ullam! Quis nostrum inventore dolorem id fugit exercitationem quae alias minus corrupti repellat hic
            molestias consequuntur architecto aut quod veritatis maxime dignissimos, vero enim illum. Provident corrupti
            sunt aspernatur vel quibusdam, officiis est iste. Possimus minus asperiores natus, cumque eum facilis vel
            repellendus labore, laborum esse libero aspernatur repudiandae incidunt unde, optio mollitia veritatis
            ratione. Accusamus aliquid sed, officiis distinctio rem eaque nobis pariatur vero id tempora fuga a dolore
            dolores adipisci alias hic optio consectetur beatae minima saepe ut officia! Quaerat, veniam. Deleniti
            magnam sunt deserunt nulla adipisci voluptatibus et molestias quam? Nesciunt doloribus assumenda eum
            repellat eligendi perferendis. Ducimus, corrupti ut tenetur reprehenderit enim ipsam hic laboriosam
            molestias, placeat facere, nemo voluptate qui exercitationem sapiente dolorem explicabo expedita obcaecati.
            Ipsam consequatur, labore molestias corporis sequi quo provident quas fugit recusandae aperiam, quasi
            repellat sint? Sit perspiciatis nobis voluptatem, iste nisi rerum enim similique quo quod voluptatum at
            maxime velit mollitia! Beatae quaerat nisi accusantium laboriosam perferendis dolores nesciunt harum
            asperiores reprehenderit natus ipsum odio eius, porro obcaecati quibusdam quasi neque tenetur mollitia
            assumenda suscipit minima voluptatum. Ea facilis fugiat minus veniam ipsum fuga vero sapiente animi
            aspernatur rem modi illum dolores neque eum, hic accusamus voluptas omnis. Vel aliquid, eius asperiores
            vitae eveniet culpa odit quam sit deserunt doloribus, tempore, itaque minima delectus praesentium! Expedita,
            natus pariatur. Quam eligendi nisi ratione. Natus harum nisi minima minus voluptatem ratione, soluta,
            suscipit sunt rerum maxime et ipsam labore, temporibus dignissimos architecto! Quo laudantium voluptatibus
            nobis porro voluptates, non hic at dolor dignissimos, quam eum id deserunt fugit optio ducimus quasi
            repellendus? Error qui perferendis doloribus tempore et quod aperiam, nostrum saepe optio quasi libero rerum
            magni exercitationem unde velit numquam dolorum deleniti ullam architecto quam. Vitae soluta perferendis id
            eius, iure perspiciatis qui, sunt non recusandae aspernatur consequuntur at excepturi sequi corrupti quas
            accusamus modi ratione.
        </div>
        <br><br>
    </div>
    <footer class="text-center text-lg-start text-white" style="background-color: #1c2331">
        <section class="mt-0 p-1">
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
                        <p><i class="fas mr-3"></i> г. Москва</p>
                        <p><i class="fas mr-3"></i> yung-donil@yandex.ru</p>
                        <p><i class="fas mr-3"></i> +7 (977) 718-04-02</p>
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"
        integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"
        crossorigin="anonymous"></script>
</body>

</html>


<?php else : ?>
    <?php
    include_once  'db-tests.php';
    session_start();

    $id = (int) $_GET['id'];

    $testId = $id;
    if (!isset($_SESSION['test_id']) || $_SESSION['test_id'] != $testId) {
        $_SESSION['test_id'] = $testId;
        $_SESSION['test_score'] = 0;
    }

    $res = $db->query("SELECT * FROM tests WHERE id = {$testId}");
    $row = $res->fetch();
    $testTitle = $row['title'];

    $questionNum = (int) $_POST['q'];
    if (empty($questionNum)) {
        $questionNum = 0;
    }
    $questionNum++;
    $questionStart = $questionNum - 1;

    $res = $db->query("SELECT count(*) AS count FROM questions WHERE test_id = {$testId}");
    $row = $res->fetch();
    $questionCount = $row['count'];

    $answerId = (int) $_POST['answer_id'];
    if (!empty($answerId)) {
        $res = $db->query("SELECT * FROM answers WHERE id = {$answerId}");
        $row = $res->fetch();
        $score = $row['score'];
        $_SESSION['test_score'] += $score;
    }

    $showForm = 0;
    if ($questionCount >= $questionNum) {
        $showForm = 1;

        $res = $db->query("SELECT * FROM questions WHERE test_id = {$testId} LIMIT {$questionStart}, 1");
        $row = $res->fetch();
        $question = $row['question'];
        $questionId = $row['id'];

        $res = $db->query("SELECT * FROM answers WHERE question_id = {$questionId}");
        $answers = $res->fetchAll();
    } else {
        $score = $_SESSION['test_score'];

        $res = $db->query("SELECT * FROM results WHERE test_id = {$testId} AND score_min <= {$score} AND score_max >= {$score}");
        $row = $res->fetch();
        $result = $row['result'];
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyTestSite</title>
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>
</head>
<body>
    <div class="box">
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
        <div class="main-hi">
            <section class="vh-100">
                <div class="mask d-flex align-items-center h-100 gradient-custom-3">
                    <div class="container h-100">
                        <div class="row d-flex justify-content-center align-items-center h-100">
                            <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                                <div class="card" style="border-radius: 50px;">
                                    <div class="card-body p-5">
                                        <h3 class="text-center mb-3">Приветствую!</h2>
                                        <div class="form-outline mb-4">
                                            <div class="spinner-grow spinner-grow-sm" role="status">
                                                <span class="visually-hidden">Загрузка...</span>
                                            </div>
                                            <span>Рад тебя приветствовать на нашем сайте!</span>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <div class="spinner-grow spinner-grow-sm" role="status">
                                                <span class="visually-hidden">Загрузка...</span>
                                            </div>
                                            <span>На сайте вы можете пройти тесты</span>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <div class="spinner-grow spinner-grow-sm" role="status">
                                                <span class="visually-hidden">Загрузка...</span>
                                            </div>
                                            <span>При условии регистрации, Вы сможете их создавать!</span>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <div class="spinner-grow spinner-grow-sm" role="status">
                                                <span class="visually-hidden">Загрузка...</span>
                                            </div>
                                            <span>Если готов, жми "Поехали!"</span>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-success btn-block btn-lg text-body"
                                                name="reg"
                                                onclick="window.location.href='#content'">Поехали!</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
    <div class="page" id="content">
        <br><br>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="serviceBox">
                        <div class="service-icon">
                            <i class="fa fa-globe"></i>
                        </div>
                        <div class="service-content">
                            <h3 class="title">MySite</h3>
                            <p class="description">
                                Какая-нибудь инфа о сайте + Какая-нибудь инфа о сайте + Какая-нибудь инфа о сайте + Какая-нибудь инфа о сайте
                            </p>
                        </div>
                        <a href="index.php" class="read">Подробнее</a>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="serviceBox">
                        <div class="service-icon">
                            <i class="fa fa-rocket"></i>
                        </div>
                        <div class="service-content">
                            <h3 class="title">Прохождение тестов</h3>
                            <p class="description">
                                На нашем сайте вы можете проверить свои знания по какой-либо тематике. Чтобы приступить к выполнению тестов нажмите "Вперед!"
                            </p>
                        </div>
                        <a href="tests.php" class="read">Вперед!</a>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="serviceBox">
                        <div class="service-icon">
                            <i class="fa fa-briefcase"></i>
                        </div>
                        <div class="service-content">
                            <h3 class="title">Конструктор тестов</h3>
                            <p class="description">
                            На нашем сайте вы можете проверить свои знания по какой-либо тематике. Чтобы приступить к выполнению тестов нажмите "Вперед!"
                            </p>
                        </div>
                        <a href="create-test.php" class="read">Вперед!</a>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="serviceBox">
                        <div class="service-icon">
                            <i class="fa fa-mobile"></i>
                        </div>
                        <div class="service-content">
                            <h3 class="title">Контакты</h3>
                            <p class="description">
                             г. Москва <br>
                            yung-donil@yandex.ru <br>
                            +7 (977) 718-04-02 <br>
                            Нажмите "Подробнее"
                            </p>
                        </div>
                        <a href="contacts.php" class="read">Подробнее</a>
                    </div>
                </div>

            </div>
        </div>
        <div class="container-fluid">
            <div class="row align-items-center text-center info-row mt-5">
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 info-box">
                    Пользователей
                    <br>
                    <span>#
                    </span>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 info-box">
                    Тестов
                    <br>
                    <span>
                        <?php
                        $res = $db->query("SELECT count(id) FROM tests");
                        $row = $res->fetch();
                        $count = $row[0];
                        echo $count
                    ?>
                    </span>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 info-box">
                    Что-то еще
                    <br>
                    <span>#</span>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 info-box">
                    Что-то еще
                    <br>
                    <span>#</span>
                </div>
            </div>
        </div>
        <div class="container card">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Pariatur, perferendis! Dolorem voluptate earum
            similique iste, molestiae officia accusamus beatae voluptatibus sint rem eius consequatur et nostrum totam
            eaque maiores unde tempore at dignissimos quisquam placeat culpa dolores nihil sequi? Tempore sequi totam,
            temporibus ipsam reprehenderit quod vero laudantium iusto mollitia ullam cupiditate, reiciendis facere
            nulla! Accusantium assumenda ea incidunt tempore quos reprehenderit unde aperiam voluptas soluta ad cum
            porro, labore architecto a repellendus quidem quas voluptatum ipsam animi? Culpa rem reiciendis animi, ut
            saepe nisi laudantium aliquam repellat, fuga ipsa ipsam. Iste ut fugiat pariatur reiciendis dicta vitae
            nobis maxime. Iure assumenda doloribus adipisci enim non illum nemo quod sapiente voluptatum? Corporis nisi
            quod necessitatibus veritatis ut accusamus placeat nulla molestiae velit corrupti magnam a cum asperiores
            nobis error sequi temporibus porro nam quisquam iusto, adipisci ipsa inventore consequatur. Incidunt aperiam
            fugiat inventore mollitia vero nam perspiciatis autem! Obcaecati totam esse cumque consectetur quasi
            accusamus voluptatibus, necessitatibus vel deleniti officia optio sequi dolores aspernatur ipsam pariatur
            quibusdam dicta nobis. Quisquam cupiditate excepturi vero maiores reprehenderit repellat voluptate a
            doloribus aperiam dolores accusantium sunt libero totam voluptates quas quidem dolorem, optio fugit adipisci
            hic sit ullam! Quis nostrum inventore dolorem id fugit exercitationem quae alias minus corrupti repellat hic
            molestias consequuntur architecto aut quod veritatis maxime dignissimos, vero enim illum. Provident corrupti
            sunt aspernatur vel quibusdam, officiis est iste. Possimus minus asperiores natus, cumque eum facilis vel
            repellendus labore, laborum esse libero aspernatur repudiandae incidunt unde, optio mollitia veritatis
            ratione. Accusamus aliquid sed, officiis distinctio rem eaque nobis pariatur vero id tempora fuga a dolore
            dolores adipisci alias hic optio consectetur beatae minima saepe ut officia! Quaerat, veniam. Deleniti
            magnam sunt deserunt nulla adipisci voluptatibus et molestias quam? Nesciunt doloribus assumenda eum
            repellat eligendi perferendis. Ducimus, corrupti ut tenetur reprehenderit enim ipsam hic laboriosam
            molestias, placeat facere, nemo voluptate qui exercitationem sapiente dolorem explicabo expedita obcaecati.
            Ipsam consequatur, labore molestias corporis sequi quo provident quas fugit recusandae aperiam, quasi
            repellat sint? Sit perspiciatis nobis voluptatem, iste nisi rerum enim similique quo quod voluptatum at
            maxime velit mollitia! Beatae quaerat nisi accusantium laboriosam perferendis dolores nesciunt harum
            asperiores reprehenderit natus ipsum odio eius, porro obcaecati quibusdam quasi neque tenetur mollitia
            assumenda suscipit minima voluptatum. Ea facilis fugiat minus veniam ipsum fuga vero sapiente animi
            aspernatur rem modi illum dolores neque eum, hic accusamus voluptas omnis. Vel aliquid, eius asperiores
            vitae eveniet culpa odit quam sit deserunt doloribus, tempore, itaque minima delectus praesentium! Expedita,
            natus pariatur. Quam eligendi nisi ratione. Natus harum nisi minima minus voluptatem ratione, soluta,
            suscipit sunt rerum maxime et ipsam labore, temporibus dignissimos architecto! Quo laudantium voluptatibus
            nobis porro voluptates, non hic at dolor dignissimos, quam eum id deserunt fugit optio ducimus quasi
            repellendus? Error qui perferendis doloribus tempore et quod aperiam, nostrum saepe optio quasi libero rerum
            magni exercitationem unde velit numquam dolorum deleniti ullam architecto quam. Vitae soluta perferendis id
            eius, iure perspiciatis qui, sunt non recusandae aspernatur consequuntur at excepturi sequi corrupti quas
            accusamus modi ratione.
        </div>
        <br><br>
    </div>
    <footer class="text-center text-lg-start text-white" style="background-color: #1c2331">
        <section class="mt-0 p-1">
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
                        <p><i class="fas mr-3"></i> г. Москва</p>
                        <p><i class="fas mr-3"></i> yung-donil@yandex.ru</p>
                        <p><i class="fas mr-3"></i> +7 (977) 718-04-02</p>
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"
        integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"
        crossorigin="anonymous"></script>
</body>

</html>


<?php endif; ?>