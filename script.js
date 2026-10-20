// Ждем полной загрузки HTML-документа
document.addEventListener('DOMContentLoaded', () => {
    const themeBtn = document.getElementById('theme-toggle');
    const body = document.body;

    // 1. Проверяем, сохранял ли пользователь тему ранее
    const savedTheme = localStorage.getItem('theme');
    
    // Если сохранена темная тема, применяем её сразу при загрузке
    if (savedTheme === 'dark') {
        body.classList.add('dark-theme');
        themeBtn.textContent = '☀️'; // Меняем иконку на солнце
    }

    // 2. Добавляем обработчик клика на кнопку
    themeBtn.addEventListener('click', () => {
        // Переключаем класс dark-theme у body
        body.classList.toggle('dark-theme');
        
        // Проверяем, какая тема стала активной, и обновляем иконку + сохранение
        if (body.classList.contains('dark-theme')) {
            themeBtn.textContent = '☀️';
            localStorage.setItem('theme', 'dark');
        } else {
            themeBtn.textContent = '🌙';
            localStorage.setItem('theme', 'light');
        }
    });
});