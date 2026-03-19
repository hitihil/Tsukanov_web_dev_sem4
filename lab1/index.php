<?php
date_default_timezone_set('Europe/Moscow');
// Заголовок страницы (выводится через переменную)
$title = 'Цуканов Кирилл Русланович, группа 241-352. Лабораторная работа № А-1. Главная';

// Определяем текущую страницу для подсветки меню
$current_page = basename($_SERVER['PHP_SELF']);

// Пункты меню: адрес и текст
$menu_items = [
    ['link' => 'index.php', 'name' => 'Главная'],
    ['link' => 'page1.php', 'name' => 'Кошки'],
    ['link' => 'page2.php', 'name' => 'Собаки'],
];
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <style>
        /* Сброс отступов */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding-top: 70px;
            /* место для фиксированной шапки */
            padding-bottom: 50px;
            /* место для фиксированного подвала */
        }

        /* Шапка */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background-color: #006400;
            /* тёмно-зелёный */
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 100;
        }

        .header .logo {
            font-size: 1.2em;
            font-weight: bold;
        }

        .header .menu {
            display: flex;
            gap: 20px;
        }

        .header .menu a {
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .header .menu a:hover {
            background-color: #228B22;
        }

        .header .menu a.selected {
            background-color: #2E8B57;
            /* выделение текущей страницы */
            font-weight: bold;
        }

        /* Подвал */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 40px;
            background-color: #333;
            /* тёмно-серый */
            color: #ccc;
            /* светло-серый */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9em;
        }

        /* Контентная область */
        .content {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        h2 {
            margin: 30px 0 10px;
            color: #555;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 100%;
            height: auto;
            margin: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .image-row {
            display: flex;
            gap: 20px;
            justify-content: center;
        }
    </style>
</head>

<body>
    <!-- Шапка (фиксированная) -->
    <div class="header">
        <div class="logo">Мир животных</div>
        <div class="menu">
            <?php foreach ($menu_items as $item):
                $link = $item['link'];
                $name = $item['name'];
                $current = ($link == $current_page);
                ?>
                <?php echo '<a href="' . $link . '"'; ?>
                <?php if ($current)
                    echo ' class="selected"';
                echo '>' . $name . '</a>'; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Основной контент -->
    <div class="content">
        <h1>Добро пожаловать на сайт о животных!</h1>
        <p>Здесь вы найдёте интересную информацию о кошках и собаках — самых популярных домашних питомцах.</p>

        <h2>Почему мы любим животных?</h2>
        <p>Кошки и собаки дарят нам радость, тепло и преданность. Они помогают снять стресс, учат ответственности и
            просто делают нашу жизнь ярче. В этой статье мы рассмотрим основные различия в содержании, повадках и
            интересные факты.</p>
        <p>Кошки – независимые и грациозные. Они могут долго обходиться без внимания, но при этом сильно привязываются к
            хозяину. Собаки – настоящие друзья, готовые всегда защитить и составить компанию на прогулке.</p>
        <p>С точки зрения биологии, кошки относятся к семейству кошачьих, а собаки – к псовым. У них разное строение
            зубов, пищеварение и поведение. Однако и те, и другие легко обучаются простым правилам.</p>
        <p>Породы поражают разнообразием: от британских кошек до немецких овчарок. Каждая порода имеет свои особенности
            ухода и характера.</p>
        <p>При выборе питомца важно учитывать условия проживания. Для квартиры лучше подходят кошки или небольшие
            собаки. В частном доме можно завести крупную собаку.</p>
        <p>Кормление должно быть сбалансированным. Сухие корма удобны, но натуральное питание считается более полезным.
            Не забывайте про витамины и регулярные визиты к ветеринару.</p>
        <p>Интересный факт: кошки могут издавать около 100 различных звуков, а собаки – всего 10. Зато собаки лучше
            понимают человеческую речь.</p>
        <p>В мире множество приютов для бездомных животных. Если вы решили завести питомца, подумайте о том, чтобы взять
            его из приюта – это спасёт жизнь.</p>
        <p>Таким образом, выбор между кошкой и собакой зависит от вашего образа жизни. Главное – любовь и забота, и
            питомец ответит вам взаимностью.</p>

        <h2>Сравнение популярных пород</h2>
        <table>
            <tr>
                <th>Порода</th>
                <th>Происхождение</th>
                <th>Размер</th>
            </tr>
            <?php
            // Первая строка таблицы – полностью через PHP
            echo '<tr><td>Сиамская кошка</td><td>Таиланд</td><td>Средний</td></tr>';
            ?>
            <!-- Вторая строка: теги <td> статические, содержимое динамическое (без промежуточных переменных) -->
            <tr>
                <td><?php echo 'Мейн-кун'; ?></td>
                <td><?php echo 'США'; ?></td>
                <td><?php echo 'Крупный'; ?></td>
            </tr>
        </table>

        <h2>Фотографии</h2>
        <div class="image-row">
            <?php
            // Первое фото – выбор в зависимости от чётности секунды
            if (date('s') % 2 == 0) {
                $img1 = 'images/cat1.jpg';
            } else {
                $img1 = 'images/cat2.jpg';
            }
            ?>
            <img src="<?php echo $img1; ?>" alt="Кошка" width="300">

            <?php
            // Второе фото
            if (date('s') % 2 == 0) {
                $img2 = 'images/dog1.jpg';
            } else {
                $img2 = 'images/dog2.jpg';
            }
            ?>
            <img src="<?php echo $img2; ?>" alt="Собака" width="300">
        </div>
    </div>

    <!-- Подвал (фиксированный) с актуальной датой -->
    <div class="footer">
        <?php
        $date = date('d.m.Y в H-i:s');
        echo "Сформировано $date";
        ?>
    </div>
</body>

</html>