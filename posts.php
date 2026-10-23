<?php
require_once('db.php');
$link = mysqli_connect('127.0.0.1', 'root', 'Qwe123123', 'first');

// УЯЗВИМОСТЬ SQLi через GET id
$id = $_GET['id'];

$sql = "SELECT * FROM posts WHERE id=$id";
$res = mysqli_query($link, $sql);

$rows = mysqli_fetch_array($res);
$title     = $rows['title'];
$main_text = $rows['main_text'];
$filename  = $rows['filename'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
    <a href="/" class="btn btn-secondary mb-3">← На главную</a>
    <h1><?php echo $title; ?></h1>
    <!-- УЯЗВИМОСТЬ Stored XSS — вывод без htmlspecialchars -->
    <p><?php echo $main_text; ?></p>
    <?php if (!empty($filename)): ?>
        <img src="/upload/<?php echo $filename; ?>" style="max-width:500px;">
    <?php endif; ?>
</div>
</body>
</html>