<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Панель управления</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $styles; ?>
        <?= $scripts; ?>
        <script src="<?= URL::base('http', TRUE); ?>public/js/jquery-3.1.1.min.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="auth">
            <div class="auth-container">
                <div class="card">
                    <header class="auth-header">
                        <h1 class="auth-title">
                            <div class="logo">
                                <span class="l l1"></span>
                                <span class="l l2"></span>
                                <span class="l l3"></span>
                                <span class="l l4"></span>
                                <span class="l l5"></span>
                            </div> Авторизация
                        </h1>
                    </header>
                    <div class="auth-content">
                        <p class="text-xs-center">Аторизуйтесь для продолжения</p>
                        <form id="login-form" novalidate="">
                            <div class="form-group">
                                <label for="username">Ваш логин</label>
                                <input type="text" class="form-control underlined" name="username" id="username" placeholder="Введите ваш логин" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Ваш пароль</label>
                                <input type="password" class="form-control underlined" name="password" id="password" placeholder="Введите ваш пароль" required>
                            </div>
                            <div class="form-group">
                                <label for="remember">
                                    <input class="checkbox" id="remember" type="checkbox"> 
                                    <span>Запомнить меня</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary">Войти</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-xs-center">
                    <a href="<?= URL::base('http', TRUE); ?>" class="btn btn-secondary rounded btn-sm"> <i class="fa fa-arrow-left"></i> Вернуться назад </a>
                </div>
            </div>
        </div>
        <!-- Reference block for JS -->
        <div class="ref" id="ref">
            <div class="color-primary"></div>
            <div class="chart">
                <div class="color-primary"></div>
                <div class="color-secondary"></div>
            </div>
        </div>
        <?= $scripts_bottom; ?>
    </body>
</html>