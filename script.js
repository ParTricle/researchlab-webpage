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
document.addEventListener('DOMContentLoaded', () => {
    const catButton = document.getElementById('cat-button');
    const wrapper = document.querySelector('.photo-wrapper');

    console.log('✅ Скрипт загружен');
    console.log('🐱 Кнопка котика:', catButton);
    console.log('📦 Контейнер:', wrapper);

    if (!catButton || !wrapper) {
        console.error('❌ Ошибка: не найдены элементы');
        return;
    }

    // Вспомогательная функция для случайного числа в диапазоне
    function getRandomNumber(min, max) {
        return Math.random() * (max - min) + min;
    }

    catButton.addEventListener('click', () => {
        console.log('🖱️ Клик по котику! Создаем новое окошко...');

        // 1. Создаем новый элемент окошка
        const popup = document.createElement('div');
        popup.className = 'click-popup';
        popup.textContent = 'клац';

        // 2. Генерируем случайные значения
        const randomX = getRandomNumber(-20, 20);   // Смещение по X: -20..20 px
        const randomRot = getRandomNumber(-10, 10); // Поворот: -10..10 градусов

        console.log('📍 Смещение X:', randomX, 'px');
        console.log('🔄 Поворот:', randomRot, 'градусов');

        // 3. Применяем случайные значения через inline-стили
        //    Заменяем базовый transform на новый с учетом случайных значений
        popup.style.transform = `translateX(calc(-50% + ${randomX}px)) rotate(${randomRot}deg)`;

        // 4. Добавляем окошко в контейнер
        wrapper.appendChild(popup);
        console.log('✨ Окошко добавлено в DOM:', popup);

        // 5. Запускаем анимацию появления (через микро-задержку, чтобы transition сработал)
        requestAnimationFrame(() => {
            popup.classList.add('show');
        });

        // 6. Через 2 секунды плавно скрываем и удаляем элемент
        setTimeout(() => {
            popup.classList.remove('show');
            // Ждем окончания анимации исчезновения (0.3 сек), затем удаляем из DOM
            setTimeout(() => {
                if (popup.parentNode) {
                    popup.parentNode.removeChild(popup);
                    console.log('🗑️ Окошко удалено из DOM');
                }
            }, 300);
        }, 2000);
    });
});