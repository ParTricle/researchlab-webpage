<?php
require_once('db.php'); // $link уже здесь

// Защита от SQLi: приводим ID к целому числу
$id = isset($_GET['id']) ? $_GET['id'] : 0;
settype($id, 'integer');

$sql = "SELECT * FROM posts WHERE id=$id";
$res = mysqli_query($link, $sql);

if (!$res || mysqli_num_rows($res) === 0) {
    die("Пост не найден");
}

$rows = mysqli_fetch_array($res);

// Защита от Stored XSS: экранируем вывод (?? '' защищает от null)
$title_safe    = htmlspecialchars($rows['title'] ?? '', ENT_QUOTES, 'UTF-8');
$main_text_safe = htmlspecialchars($rows['main_text'] ?? '', ENT_QUOTES, 'UTF-8');
$filename_safe  = htmlspecialchars($rows['filename'] ?? '', ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<title><?php echo $title_safe; ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
<a href="/" class="btn btn-secondary mb-3">← На главную</a>
<h1><?php echo $title_safe; ?></h1>
<p><?php echo $main_text_safe; ?></p>
<?php if (!empty($filename_safe)): ?>
<img src="/upload/<?php echo $filename_safe; ?>" style="max-width:500px;">
<?php endif; ?>
</div>
</body>
</html>
