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
    const fullscreenGif = document.getElementById('fullscreen-gif');

    console.log('✅ Скрипт загружен');

    if (!catButton || !wrapper || !fullscreenGif) {
        console.error('❌ Ошибка: не найдены элементы');
        return;
    }

    // === ПЕРЕМЕННЫЕ ДЛЯ ОТСЛЕЖИВАНИЯ КЛИКОВ ===
    let clickTimestamps = []; // Массив временных меток кликов
    let currentCatImage = 1; // Текущая картинка котика (1 или 2)

    // Пути к картинкам котика (замените на ваши реальные имена)
    const catImages = {
        1: 'cat1.png',
        2: 'cat2.png'
    };

    // Вспомогательная функция для случайного числа
    function getRandomNumber(min, max) {
        return Math.random() * (max - min) + min;
    }

    // === ФУНКЦИЯ ПЕРЕКЛЮЧЕНИЯ КАРТИНКИ КОТИКА ===
    function toggleCatImage() {
        currentCatImage = currentCatImage === 1 ? 2 : 1;
        catButton.style.backgroundImage = `url('${catImages[currentCatImage]}')`;
        console.log(`🐱 Котик сменил лапы: картинка ${currentCatImage}`);
    }

    // === ФУНКЦИЯ ПРОВЕРКИ 10 КЛИКОВ ЗА 2 СЕКУНДЫ ===
    function checkRapidClicks() {
        const now = Date.now();
        
        // Удаляем старые клики (старше 2 секунд)
        clickTimestamps = clickTimestamps.filter(timestamp => now - timestamp < 2000);
        
        console.log(`⏱️ Кликов за последние 2 секунды: ${clickTimestamps.length}`);

        // Если за 2 секунды было 10+ кликов - показываем гифку
        if (clickTimestamps.length >= 10) {
            console.log('🎉 10 кликов за 2 секунды! Показываем гифку!');
            showFullscreenGif();
            clickTimestamps = []; // Сбрасываем счетчик
        }
    }

    // === ФУНКЦИЯ ПОКАЗА ПОЛНОЭКРАННОЙ ГИФКИ ===
    function showFullscreenGif() {
        fullscreenGif.classList.add('show');
        
        // Скрываем гифку через 3 секунды
        setTimeout(() => {
            fullscreenGif.classList.remove('show');
            console.log('🎬 Гифка скрыта');
        }, 4800);
    }

    // === ОБРАБОТЧИК КЛИКА ПО КОТИКУ ===
    catButton.addEventListener('click', () => {
        console.log('🖱️ Клик по котику!');

        // 1. Добавляем временную метку клика
        clickTimestamps.push(Date.now());

        // 2. Переключаем картинку котика
        toggleCatImage();

        // 3. Проверяем, не было ли 10 кликов за 2 секунды
        checkRapidClicks();

        // 4. Создаем всплывающее окошко "клац"
        const popup = document.createElement('div');
        popup.className = 'click-popup';
        popup.textContent = 'клац';

        const randomX = getRandomNumber(-20, 20);
        const randomRot = getRandomNumber(-10, 10);

        console.log('📍 Смещение X:', randomX, 'px');
        console.log('🔄 Поворот:', randomRot, 'градусов');

        popup.style.transform = `translateX(calc(-50% + ${randomX}px)) rotate(${randomRot}deg)`;

        wrapper.appendChild(popup);

        requestAnimationFrame(() => {
            popup.classList.add('show');
        });

        setTimeout(() => {
            popup.classList.remove('show');
            setTimeout(() => {
                if (popup.parentNode) {
                    popup.parentNode.removeChild(popup);
                }
            }, 300);
        }, 2000);
    });

});
