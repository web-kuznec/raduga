<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?= $title; ?></title>
        <link rel="stylesheet" href="/public/css/normalize.css">
        <link rel="stylesheet" href="/public/css/bootstrap.min.css">
        <link rel="stylesheet" href="/public/css/main.css" media="screen" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/public/css/font-awesome.min.css" rel="stylesheet">
        <!---<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">-->
        <meta name="description" content="<?= $description; ?>">
        <meta name="keywords" content="<?= $keywords; ?>">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body style="background-color:#<?= $color; ?>">
        <div class="container"><?= $content; ?></div>
    </body>
</html>