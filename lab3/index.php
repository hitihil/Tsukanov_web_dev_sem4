<?php
// Лабораторная работа А-3: Виртуальная клавиатура
// Студент: Цуканов Кирилл Русланович, группа 241-352, вариант 27

// Получаем текущее состояние из GET-параметров
$store = isset($_GET['store']) ? $_GET['store'] : '';   // строка цифр
$count = isset($_GET['count']) ? (int) $_GET['count'] : 0; // счётчик нажатий

// Обработка нажатия кнопки (параметр key)
if (isset($_GET['key'])) {
    $key = $_GET['key'];
    if ($key === 'reset') {
        $store = '';          // сброс
    } else {
        $store .= $key;       // добавление цифры
    }
    $count++;                 // увеличиваем счётчик
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Лабораторная работа А-3 | Цуканов К.Р., 241-352, вариант 27</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <div class="logo">Московский Политех</div>
        <div class="student-info">Цуканов Кирилл Русланович, группа 241-352, лабораторная работа № А-3, вариант 27</div>
    </header>
    <main>
        <!-- Окно просмотра результата: прямоугольник с прямыми углами -->
        <div class="result"><?php echo htmlspecialchars($store); ?></div>

        <!-- Контейнер для кнопок, расположенных в 2 ряда по 5 штук -->
        <div class="buttons">
            <!-- Первый ряд: 1, 2, 3, 4, 5 -->
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <a class="button"
                    href="?key=<?php echo $i; ?>&store=<?php echo urlencode($store); ?>&count=<?php echo $count; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>

            <!-- Второй ряд: 6, 7, 8, 9, 0 -->
            <?php for ($i = 6; $i <= 9; $i++): ?>
                <a class="button"
                    href="?key=<?php echo $i; ?>&store=<?php echo urlencode($store); ?>&count=<?php echo $count; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
            <a class="button" href="?key=0&store=<?php echo urlencode($store); ?>&count=<?php echo $count; ?>">0</a>

            <!-- Кнопка сброса -->
            <a class="button reset"
                href="?key=reset&store=<?php echo urlencode($store); ?>&count=<?php echo $count; ?>">СБРОС</a>
        </div>
    </main>
    <footer>
        <p>© 2025 | Всего нажатий: <?php echo $count; ?></p>
    </footer>
</body>

</html>