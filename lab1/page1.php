<?php
date_default_timezone_set('Europe/Moscow');
$title = 'Цуканов Кирилл Русланович, группа 241-352. Лабораторная работа № А-1. Кошки';
$current_page = basename($_SERVER['PHP_SELF']); // page1.php
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

    <div class="content">
        <h1>Всё о кошках</h1>
        <p>Кошки — одни из самых популярных домашних животных. Они живут рядом с человеком уже тысячи лет, но сохранили
            независимый характер.</p>

        <h2>Особенности кошек</h2>
        <p>Кошки — хищники, отличные охотники. Они видят в темноте в 6 раз лучше человека, слышат ультразвук и всегда
            приземляются на лапы. Средняя продолжительность жизни домашней кошки — 12–15 лет.</p>
        <p>Кошки очень чистоплотны: умываются после еды, спят до 16 часов в сутки. Они метят территорию, поэтому важно
            приучить котёнка к лотку с детства.</p>
        <p>Существует более 200 пород кошек, от бесшёрстных сфинксов до пушистых персов. Каждая порода имеет свой
            темперамент и требования к уходу.</p>

        <h2>Популярные породы</h2>
        <table>
            <tr>
                <th>Порода</th>
                <th>Страна</th>
                <th>Вес</th>
            </tr>
            <?php echo '<tr><td>Британская короткошёрстная</td><td>Великобритания</td><td>4–8 кг</td></tr>'; ?>
            <tr>
                <td><?php echo 'Шотландская вислоухая'; ?></td>
                <td><?php echo 'Шотландия'; ?></td>
                <td><?php echo '3–6 кг'; ?></td>
            </tr>
        </table>

        <h2>Галерея</h2>
        <div class="image-row">
            <?php
            // Первое фото кошек
            if (date('s') % 2 == 0) {
                $img1 = 'images/cat_a1.jpg';
            } else {
                $img1 = 'images/cat_a2.jpg';
            }
            ?>
            <img src="<?php echo $img1; ?>" alt="Кошка 1" width="300">

            <?php
            // Второе фото кошек
            if (date('s') % 2 == 0) {
                $img2 = 'images/cat_b1.jpg';
            } else {
                $img2 = 'images/cat_b2.webp';
            }
            ?>
            <img src="<?php echo $img2; ?>" alt="Кошка 2" width="300">
        </div>
    </div>

    <div class="footer">
        <?php echo "Сформировано " . date('d.m.Y в H-i:s'); ?>
    </div>
</body>

</html>