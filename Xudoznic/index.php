<?php
session_start();

// имитация бд
$base_users = [
    'admin' => '12345',
    'maria' => 'qwerty'
];

// временное хранилище новых юзеров
if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = $base_users;
}

$users = $_SESSION['users'];
$error = '';

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// обработка вход
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $login = trim($_POST['login_email']);
    $pass = $_POST['login_pass'];
    if (isset($users[$login]) && $users[$login] == $pass) {
        $_SESSION['user'] = $login;
        header("Location: index.php");
        exit();
    } else {
        $error = 'Неверный логин или пароль';
    }
}

// обработка регистр
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $login = trim($_POST['reg_email']);
    $pass = $_POST['reg_pass'];
    if (isset($users[$login])) {
        $error = 'Пользователь с таким логином уже существует';
    } else {
        $users[$login] = $pass;
        $_SESSION['users'] = $users;
        $_SESSION['user'] = $login;
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impressio — мир импрессионизма</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="page-wrapper d-flex flex-column min-vh-100">

    <!-- ШАПКА -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="assets/logo.png" alt="Impressio" width="60" height="50" class="d-inline-block align-text-top me-2">
                Impressio
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Главная</a></li>
                    <li class="nav-item"><a class="nav-link" href="#artist">О художнике</a></li>
                </ul>
                <div class="ms-lg-4 mt-3 mt-lg-0">
                    <?php if (isset($_SESSION['user'])): ?>
                        <span class="text-white me-3">Привет, <?= htmlspecialchars($_SESSION['user']) ?></span>
                        <a href="index.php?logout=1" class="btn btn-outline-light btn-sm">Выйти</a>
                    <?php else: ?>
                        <button class="btn btn-outline-light btn-sm me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Войти</button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#registerModal">Регистрация</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <?php if (!isset($_SESSION['user'])): ?>
    <!-- ЭКРАН ПРИВЕТСТВИЯ -->
    <header class="masthead text-white d-flex align-items-center" style="background-image: url('assets/artist.jpg'); background-size: cover; background-position: center; min-height: 70vh; position: relative;">
        <div class="masthead-overlay"></div>
        <div class="container text-center py-5 position-relative">
            <h1 class="display-4 fw-bold">Погрузитесь в мир импрессионизма</h1>
            <p class="lead fw-normal mb-4">Изучайте работы великих мастеров.</p>
            <button class="btn btn-warning btn-lg px-4" data-bs-toggle="modal" data-bs-target="#registerModal">Начать путешествие</button>
        </div>
    </header>
    <?php endif; ?>

    <main class="container flex-grow-1 py-5">

        <!-- КАРУСЕЛЬ -->
        <section class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h2 class="fw-bold mb-4 section-title">Галерея работ</h2>
                <div id="squareCarousel" class="carousel slide carousel-fade mx-auto" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#squareCarousel" data-bs-slide-to="0" class="active"></button>
                        <button type="button" data-bs-target="#squareCarousel" data-bs-slide-to="1"></button>
                        <button type="button" data-bs-target="#squareCarousel" data-bs-slide-to="2"></button>
                        <button type="button" data-bs-target="#squareCarousel" data-bs-slide-to="3"></button>
                        <button type="button" data-bs-target="#squareCarousel" data-bs-slide-to="4"></button>
                        <button type="button" data-bs-target="#squareCarousel" data-bs-slide-to="5"></button>
                    </div>
                    <div class="carousel-inner rounded-4 shadow-lg">
                        <div class="carousel-item active"><img src="assets/1%20pic.png" alt="Картина 1"></div>
                        <div class="carousel-item"><img src="assets/2%20pic.png" alt="Картина 2"></div>
                        <div class="carousel-item"><img src="assets/3%20pic.png" alt="Картина 3"></div>
                        <div class="carousel-item"><img src="assets/4%20pic.png" alt="Картина 4"></div>
                        <div class="carousel-item"><img src="assets/5%20pic.png" alt="Картина 5"></div>
                        <div class="carousel-item"><img src="assets/6%20pic.png" alt="Картина 6"></div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#squareCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                        <span class="visually-hidden">Предыдущий</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#squareCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                        <span class="visually-hidden">Следующий</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- О ХУДОЖНИКЕ -->
        <section id="artist" class="row justify-content-center align-items-center mb-5 artist-section g-4">
            <div class="col-lg-5 text-center text-lg-start">
                <h2 class="display-6 fw-bold">Клод Дюбуа</h2>
                <p class="text-muted mb-3">1865 – 1932</p>
                <p>Малоизвестный, но гениальный французский мастер, чьи работы затерялись в архивах Лувра почти на столетие. Дюбуа не гнался за славой, предпочитая писать утренние туманы над Сеной и игру света на мокрой брусчатке Монмартра. Считается, что именно он первым применил технику «рваного мазка» для передачи вибрации воздуха.</p>
                <div class="d-flex gap-3 justify-content-center justify-content-lg-start mt-4">
                    <a href="#" class="btn btn-outline-primary">Виртуальная галерея</a>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <img src="assets/painter.jpg" alt="Клод Дюбуа" class="img-fluid rounded-4 shadow-lg artist-photo">
            </div>
        </section>
    </main>

    <!-- ПОДВАЛ -->
    <footer class="bg-dark text-white-50 mt-auto">
        <div class="container py-4">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div class="rounded overflow-hidden shadow-sm" style="height: 260px;">
                        <iframe src="https://yandex.ru/map-widget/v1/?ll=37.6176%2C55.7558&z=12&pt=37.6176,55.7558,pm2rdl"
                                width="100%" height="100%" frameborder="0" allowfullscreen="true"
                                style="filter: grayscale(0.3);"></iframe>
                    </div>
                    <p class="text-center mt-2 mb-0 small">
                        <a href="https://yandex.ru/maps/" class="text-white-50">Открыть в Яндекс Картах</a>
                    </p>
                </div>
                <div class="col-lg-6 text-center text-lg-start">
                    <h5 class="text-white mb-3">Impressio</h5>
                    <p class="mb-1">© 2026 Impressio. Все права защищены.</p>
                    <div class="mt-3">
                        <a href="#" class="text-white-50 me-3 fs-5"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-white-50 me-3 fs-5"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white-50 fs-5"><i class="bi bi-telegram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

<!-- МОДАЛКА ВХОД -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Вход в аккаунт</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <?php if ($error && isset($_POST['login'])): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <div class="mb-3">
                    <label class="form-label">Логин</label>
                    <input type="text" name="login_email" class="form-control form-control-lg" placeholder="Введите логин" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Пароль</label>
                    <input type="password" name="login_pass" class="form-control form-control-lg" placeholder="Введите пароль" required>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 px-4 pb-4">
                <button type="submit" name="login" class="btn btn-primary btn-lg w-100">Войти</button>
            </div>
        </form>
    </div>
</div>

<!-- МОДАЛКА РЕГИСТРАЦИЯ -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Создать аккаунт</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <?php if ($error && isset($_POST['register'])): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <div class="mb-3">
                    <label class="form-label">Придумайте логин</label>
                    <input type="text" name="reg_email" class="form-control form-control-lg" placeholder="Например: ivanov" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Придумайте пароль</label>
                    <input type="password" name="reg_pass" class="form-control form-control-lg" placeholder="Мин. 6 символов" required>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="termsCheck" required>
                    <label class="form-check-label" for="termsCheck">Я согласен с правилами использования</label>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0 px-4 pb-4">
                <button type="submit" name="register" class="btn btn-success btn-lg w-100">Зарегистрироваться</button>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>