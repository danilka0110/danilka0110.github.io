<?php
require "../db.php"
?>

<?php if (isset($_SESSION['logged_user'])) : ?>
<?php
    include_once  '../db-tests.php';
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
    <title>Тесты</title>
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../css/style.css">
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
                        <a class="nav-link" href="../index.php" style="margin-right: 130px">MySite</a>
                    </li>
                    <li class=" nav-item">
                        <a class="nav-link" href="../tests.php">Тесты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../surveys.php">Опросы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../contacts.php" style="margin-right: 80px">Контакты</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-expanded="false">Профиль</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="../account.php"><span style="color: #000; margin-right: 20px;">
                                        <?php echo $_SESSION['logged_user']->login; ?>
                                    </span></a></li>
                            <li><a class="dropdown-item" href="../create-test.php">Создать тест</a></li>
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
    <div class="page-test">
        <div class="container" id="content">
            <div>
                <?php if ($showForm) { ?>
                <form action="test.php?id=<?php echo $testId; ?>" method="post">
                    <input type="hidden" name="q" value="<?php echo $questionNum; ?>">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="text-center">
                                    <p>Вопрос
                                        <?php echo $questionNum . ' из ' . $questionCount; ?>
                                    </p>
                                </div>
                                <div class="card-header">
                                    <h3>
                                        <?php echo $question; ?>
                                    </h3>
                                </div>
                                <div class="card-body">

                                    <?php foreach ($answers AS $answer) { ?>
                                    <div>
                                        <input type="radio" name="answer_id" required
                                            value="<?php echo $answer['id']; ?>">
                                        <?php echo $answer['answer']; ?>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="text-center">
                                <?php if ($questionCount == $questionNum) { ?>
                                <button type="submit" class="btn btn-success">Получить результат</button>
                                <?php } else { ?>
                                <button type="submit" class="btn btn-primary">Дальше</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </form>
                <?php } else { ?>
                <div class="row justify-content-center result">
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header">
                                <h3>Результат</h3>
                            </div>
                            <div class="card-body">
                                <div class="result-print">
                                    <?php echo $result; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
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
    include_once  '../db-tests.php';
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
    <title>Тесты</title>
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../css/style.css">
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
                            <a class="nav-link" href="../index.php" style="margin-right: 130px">MySite</a>
                        </li>
                        <li class=" nav-item">
                            <a class="nav-link" href="../tests.php">Тесты</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../surveys.php">Опросы</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../contacts.php" style="margin-right: 130px">Контакты</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../login.php">Войти</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../reg.php">Зарегистрироваться</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    <div class="page-test">
        <div class="container" id="content">
            <div>
                <?php if ($showForm) { ?>
                <form action="test.php?id=<?php echo $testId; ?>" method="post">
                    <input type="hidden" name="q" value="<?php echo $questionNum; ?>">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="text-center">
                                    <p>Вопрос
                                        <?php echo $questionNum . ' из ' . $questionCount; ?>
                                    </p>
                                </div>
                                <div class="card-header">
                                    <h3>
                                        <?php echo $question; ?>
                                    </h3>
                                </div>
                                <div class="card-body">

                                    <?php foreach ($answers AS $answer) { ?>
                                    <div>
                                        <input type="radio" name="answer_id" required
                                            value="<?php echo $answer['id']; ?>">
                                        <?php echo $answer['answer']; ?>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="text-center">
                                <?php if ($questionCount == $questionNum) { ?>
                                <button type="submit" class="btn btn-success">Получить результат</button>
                                <?php } else { ?>
                                <button type="submit" class="btn btn-primary">Дальше</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </form>
                <?php } else { ?>
                <div class="row justify-content-center result">
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header">
                                <h3>Результат</h3>
                            </div>
                            <div class="card-body">
                                <div class="result-print">
                                    <?php echo $result; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
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