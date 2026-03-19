<?php
date_default_timezone_set('Europe/Moscow');
$title = 'Цуканов Кирилл Русланович, группа 241-352. Лабораторная работа № А-1. Собаки';
$current_page = basename($_SERVER['PHP_SELF']); // page2.php
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
        <h1>Интересное о собаках</h1>
        <p>Собаки были первыми животными, приручёнными человеком. Они верные помощники на охоте, сторожа и просто
            компаньоны.</p>

        <h2>Особенности собак</h2>
        <p>Собаки обладают уникальным нюхом — в 10000 раз чувствительнее человеческого. Они различают ультразвук и
            способны понимать до 250 слов. Продолжительность жизни зависит от породы: мелкие живут дольше (до 16 лет),
            крупные — меньше (8–10 лет).</p>
        <p>Собаки социальны, им нужно общение и физические нагрузки. Без прогулок и игр они могут стать агрессивными или
            впасть в депрессию.</p>

        <h2>Породы собак</h2>
        <table>
            <tr>
                <th>Порода</th>
                <th>Происхождение</th>
                <th>Рост</th>
            </tr>
            <?php echo '<tr><td>Немецкая овчарка</td><td>Германия</td><td>55–65 см</td></tr>'; ?>
            <tr>
                <td><?php echo 'Йоркширский терьер'; ?></td>
                <td><?php echo 'Англия'; ?></td>
                <td><?php echo '15–20 см'; ?></td>
            </tr>
        </table>

        <h2>Фотографии</h2>
        <div class="image-row">
            <?php
            // Первое фото собак
            if (date('s') % 2 == 0) {
                $img1 = 'images/dog_a1.png';
            } else {
                $img1 = 'images/dog_a2.jpg';
            }
            ?>
            <img src="<?php echo $img1; ?>" alt="Собака 1" width="300">

            <?php
            // Второе фото собак
            if (date('s') % 2 == 0) {
                $img2 = 'images/dog_b1.jpg';
            } else {
                $img2 = 'images/dog_b2.avif';
            }
            ?>
            <img src="<?php echo $img2; ?>" alt="Собака 2" width="300">
        </div>
    </div>

    <div class="footer">
        <?php echo "Сформировано " . date('d.m.Y в H-i:s'); ?>
    </div>
</body>

</html>