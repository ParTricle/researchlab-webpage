<?php
// Имитация успешного входа: устанавливаем куки на 1 час
setcookie('User', 'AuthorizedUser', time() + 3600, "/");

// Перенаправляем на главную страницу
header("Location: /");
exit();
?>
