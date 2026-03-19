<?php
define('_SITE_ACCESS', true);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Лабораторная работа В-1 | Цуканов К.Р., 241-352, вариант 27</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <div class="logo">Московский Политех</div>
        <div class="student-info">Цуканов Кирилл Русланович, группа 241-352, лабораторная работа № В-1, вариант 27</div>
    </header>
    <main>
        <?php
        require 'menu.php';

        if ($_GET['p'] == 'viewer') {
            include 'viewer.php';
            if (!isset($_GET['pg']) || !is_numeric($_GET['pg']) || $_GET['pg'] < 0) {
                $_GET['pg'] = 0;
            }
            if (!isset($_GET['sort']) || !in_array($_GET['sort'], ['byid', 'fam', 'birth'])) {
                $_GET['sort'] = 'byid';
            }
            echo getFriendsList($_GET['sort'], (int) $_GET['pg']);
        } else {
            $module = $_GET['p'] . '.php';
            if (file_exists($module)) {
                include $module;
            } else {
                echo '<p class="error">Модуль не найден</p>';
            }
        }
        ?>
    </main>
    <footer>
        <p>© 2025</p>
    </footer>
</body>

</html>