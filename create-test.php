<?php
require "db.php"
?>

<?php if (isset($_SESSION['logged_user'])) : ?>

    <?php
    include_once  'db-tests.php';

    $do = trim(strip_tags($_GET['do']));
    if ($do == 'save') {
        $title = trim($_POST['title']);

        $res = $db->prepare("INSERT IGNORE INTO tests (`title`) VALUES (:title)");
        $res->execute([
            ':title' => $title,
        ]);
        $testId = $db->lastInsertId();

        $questionNum = 1;
        while (isset($_POST['question_' . $questionNum])) {
            $question = trim($_POST['question_' . $questionNum]);
            if (empty($question)) {
                continue;
            }

            $res = $db->prepare("INSERT IGNORE INTO questions (`test_id`, `question`) VALUES (:test_id, :question)");
            $res->execute([
                ':test_id' => $testId,
                ':question' => $question,
            ]);
            $questionId = $db->lastInsertId();

            $answerNum = 1;
            while (isset($_POST['answer_text_' . $questionNum . '_' . $answerNum])) {
                $answer = trim($_POST['answer_text_' . $questionNum . '_' . $answerNum]);
                $score = trim($_POST['answer_score_' . $questionNum . '_' . $answerNum]);
                if (empty($answer)) {
                    continue;
                }

                $res = $db->prepare("INSERT IGNORE INTO answers (`question_id`, `answer`, `score`) 
                                    VALUES (:question_id, :answer, :score)");
                $res->execute([
                    ':question_id' => $questionId,
                    ':answer' => $answer,
                    ':score' => $score,
                ]);

                $answerNum++;
            }
            $questionNum++;
        }

        $resultNum = 1;
        while (isset($_POST['result_' . $resultNum])) {
            $result = trim($_POST['result_' . $resultNum]);
            $scoreMin = trim($_POST['result_score_min_' . $resultNum]);
            $scoreMax = trim($_POST['result_score_max_' . $resultNum]);

            $res = $db->prepare("INSERT IGNORE INTO results (`test_id`, `score_min`, `score_max`, `result`) 
                                    VALUES (:test_id, :score_min, :score_max, :result)");
            $res->execute([
                ':test_id' => $testId,
                ':score_min' => $scoreMin,
                ':score_max' => $scoreMax,
                ':result' => $result,
            ]);

            $resultNum++;
        }

        echo '<meta http-equiv = "Refresh" content = "0; URL = index.php">';
    }

    if ($do != 'add') {
        $do = 'list';
    }
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Система тестирования</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
    <div class="container"> 
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="create-test.php?do=save" method="post">
                    <div class="card mt-4">
                        <div class="card-header">
                            <h2 class="text-center">Добавление теста</h2>
                        </div>

                        <div class="card-body">
                            <div>
                                <label for="title" class="form-label">Название теста</label>
                                <input type="text" name="title" id="title" class="form-control">
                            </div>
                            <div class="mt-5 text-center">
                                <h4>Добавление вопросов</h4>
                            </div>
                            <div class="questions">
                                <div class="question-items">
                                    <div class="mt-4">
                                        <label for="question_1" class="form-label">Вопрос #1</label>
                                        <input type="text" name="question_1" id="question_1" class="form-control">
                                        <div class="answers">
                                            <div class="answer-items">
                                                <div class="row">
                                                    <div class="col-10 col-md-10 col-lg-10 col-xl-10">
                                                        <label for="answer_text_1_1" class="form-label">Ответ #1</label>
                                                        <input type="text" name="answer_text_1_1" id="answer_text_1_1" class="form-control">
                                                    </div>
                                                    <div class="col-2 col-md-2 col-lg-2 col-xl-2">
                                                        <label for="answer_score_1_1" class="form-label">Балл</label>
                                                        <input type="text" name="answer_score_1_1" id="answer_score_1_1" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center mt-4">
                                                <button type="button" class="btn btn-light border addAnswer" data-question="1" data-answer="1">Добавить вариант ответа</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mt-4">
                                    <button type="button" class="btn btn-primary addQuestion">Добавить вопрос</button>
                                </div>
                            </div>

                            <div class="mt-5 text-center">
                                <h4>Добавление результатов</h4>
                            </div>
                            <div class="results">
                                <div class="result-items">
                                    <div class="mt-4">
                                        <div class="">
                                            <label for="result_1" class="form-label">Результат #1</label>
                                            <textarea name="result_1" id="result_1" class="form-control"></textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 col-md-6 col-lg-6 col-xl-6 mt-2">
                                                <label for="result_score_min_1" class="form-label">Балл (от)</label>
                                                <input type="text" name="result_score_min_1" id="result_score_min_1" class="form-control">
                                            </div>
                                            <div class="col-6 col-md-6 col-lg-6 col-xl-6 mt-2">
                                                <label for="result_score_max_1" class="form-label">Балл (до)</label>
                                                <input type="text" name="result_score_max_1" id="result_score_max_1" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mt-4">
                                    <button type="button" class="btn btn-primary addResult" >Добавить результат</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4 mb-4">
                        <div class="card-body text-center">
                            <button type="submit" class="btn btn-success">Сохранить</button>
                        </div>
                    </div>
                </form>
            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/app.js"></script>
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
        <title>Document</title>
    </head>
    <body>
    <?php echo '<meta http-equiv = "Refresh" content = "0; URL = reg.php">'; ?>
    </body>
    </html>
<?php endif; ?>