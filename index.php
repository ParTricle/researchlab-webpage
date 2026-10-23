<?php
if (!isset($_COOKIE['User'])) {
    // блок авторизации оставляем как был у тебя
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Требуется авторизация</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#2c2c2c; color:#fff; min-height:100vh; display:flex; align-items:center; justify-content:center; margin:0; font-family:'Montserrat',sans-serif; }
        .auth-container { background:#1a1a1a; border-radius:20px; padding:60px 40px; text-align:center; max-width:500px; border:2px solid #3a3a3a; }
        .auth-container a { color:#6cb4ff; text-decoration:none; font-weight:700; padding:12px 30px; border:2px solid #6cb4ff; border-radius:10px; display:inline-block; margin:10px; }
        .auth-container a:hover { background:#6cb4ff; color:#1a1a1a; }
    </style>
</head>
<body>
    <div class="auth-container">
        <h1>Доступ ограничен</h1>
        <p>
            <a href="/registration.php">Зарегистрируйтесь</a> или
            <a href="/login.php">войдите</a>, чтобы просматривать контент!
        </p>
    </div>
</body>
</html>
<?php
} else {
    // === ПОКАЗЫВАЕМ СПИСОК ПОСТОВ ===
    require_once('db.php');
    $link = mysqli_connect('127.0.0.1', 'root', 'password', 'first');
    $sql = "SELECT * FROM posts";
    $res = mysqli_query($link, $sql);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная — посты</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
    <h1>Посты пользователей</h1>
    <p><a href="/profile.php" class="btn btn-secondary">← В профиль</a></p>
    <?php
    if (mysqli_num_rows($res) > 0) {
        while ($post = mysqli_fetch_array($res)) {
            echo "<a href='/posts.php?id=" . $post['id'] . "'>" . $post['title'] . "</a><br>";
        }
    } else {
        echo "Записей пока нет";
    }
    ?>
</div>
</body>
</html>
<?php } ?>