<?php
// Устанавливаем часовой пояс для Москвы
date_default_timezone_set('Europe/Moscow');

// ===== ПОЛЬЗОВАТЕЛЬСКИЕ ФУНКЦИИ =====

/**
 * Преобразует число в ссылку на таблицу умножения (только для цифр 2..9)
 * @param int $x число для преобразования
 * @return string HTML-код ссылки или просто число
 */
function outNumAsLink($x)
{
    // Ссылкой становится только однозначное число (цифра) от 2 до 9
    if ($x <= 9) {
        // Ссылка всегда сбрасывает тип вёрстки (не передаём html_type)
        return '<a href="?content=' . $x . '">' . $x . '</a>';
    } else {
        return (string) $x;
    }
}

/**
 * Выводит содержимое столбца таблицы умножения для заданного числа
 * @param int $n число, на которое умножаем (от 2 до 9)
 */
function outRow($n)
{
    for ($i = 2; $i <= 9; $i++) {
        // Формируем строку вида "2 x 3 = 6" с ссылками на цифры
        echo outNumAsLink($n) . ' x ' . outNumAsLink($i) . ' = ' . outNumAsLink($n * $i) . '<br>';
    }
}

// ===== ПОЛУЧЕНИЕ ПАРАМЕТРОВ ИЗ URL =====
// html_type – тип вёрстки (TABLE или DIV), может отсутствовать
// content – выбранная цифра (2..9) или отсутствует (полная таблица)
$html_type = isset($_GET['html_type']) ? $_GET['html_type'] : null;
$content = isset($_GET['content']) ? $_GET['content'] : null;
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Лабораторная работа А-5 | Цуканов К.Р., 241-352, вариант 27</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- ШАПКА СТРАНИЦЫ (информация о студенте) -->
    <header>
        <div class="logo">Московский Политех</div>
        <div class="student-info">
            Цуканов Кирилл Русланович, группа 241-352, лабораторная работа № А-5, вариант 27
        </div>
    </header>

    <!-- ГЛАВНОЕ МЕНЮ (горизонтальное) – определяет тип вёрстки -->
    <nav id="main-menu">
        <?php
        // Ссылка на ТАБЛИЧНУЮ вёрстку
        echo '<a href="?html_type=TABLE';
        // Сохраняем текущий параметр content, если он есть
        if ($content !== null) {
            echo '&content=' . $content;
        }
        echo '"';
        // Выделяем пункт, если передан html_type и он равен TABLE
        if ($html_type !== null && $html_type === 'TABLE') {
            echo ' class="selected"';
        }
        echo '>Табличная верстка</a>';

        // Ссылка на БЛОЧНУЮ вёрстку
        echo '<a href="?html_type=DIV';
        if ($content !== null) {
            echo '&content=' . $content;
        }
        echo '"';
        if ($html_type !== null && $html_type === 'DIV') {
            echo ' class="selected"';
        }
        echo '>Блочная верстка</a>';
        ?>
    </nav>

    <!-- КОНТЕЙНЕР ДЛЯ ОСНОВНОГО МЕНЮ И КОНТЕНТА -->
    <div id="content-wrapper">
        <!-- ОСНОВНОЕ МЕНЮ (вертикальное) – выбирает цифру или всю таблицу -->
        <nav id="side-menu">
            <?php
            // Пункт "Всё" (без параметра content)
            echo '<a href="?';
            // Сохраняем тип вёрстки, если он задан
            if ($html_type !== null) {
                echo 'html_type=' . $html_type;
            }
            echo '"';
            // Выделяем, если content отсутствует (по умолчанию при первой загрузке)
            if ($content === null) {
                echo ' class="selected"';
            }
            echo '>Всё</a>';

            // Пункты для цифр 2..9
            for ($i = 2; $i <= 9; $i++) {
                echo '<a href="?content=' . $i;
                // Сохраняем тип вёрстки
                if ($html_type !== null) {
                    echo '&html_type=' . $html_type;
                }
                echo '"';
                // Выделяем, если content совпадает с текущей цифрой
                if ($content !== null && $content == $i) {
                    echo ' class="selected"';
                }
                echo '>' . $i . '</a>';
            }
            ?>
        </nav>

        <!-- ОСНОВНАЯ ЧАСТЬ – ТАБЛИЦА УМНОЖЕНИЯ -->
        <main>
            <?php
            // Определяем тип вёрстки: по умолчанию (если параметр не задан или равен TABLE) – табличная
            $render_type = ($html_type !== null && $html_type === 'DIV') ? 'DIV' : 'TABLE';

            if ($render_type === 'TABLE') {
                // ===== ТАБЛИЧНАЯ ВЁРСТКА =====
                echo '<table class="multiplication-table">';
                // Вся таблица помещается в одну строку (горизонтальные ячейки-столбцы)
                echo '<tr>';

                if ($content === null) {
                    // Полная таблица: восемь столбцов (для чисел 2..9)
                    for ($col = 2; $col <= 9; $col++) {
                        echo '<td>';
                        outRow($col);        // выводим содержимое столбца
                        echo '</td>';
                    }
                } else {
                    // Один столбец для выбранной цифры – выводим крупнее (класс single-column)
                    echo '<td class="single-column">';
                    outRow($content);
                    echo '</td>';
                }

                echo '</tr>';
                echo '</table>';
            } else {
                // ===== БЛОЧНАЯ ВЁРСТКА (согласно листингу А‑5.6) =====
                if ($content === null) {
                    // Полная таблица: каждый столбец в отдельном блоке ttRow
                    for ($col = 2; $col <= 9; $col++) {
                        echo '<div class="ttRow">';
                        outRow($col);
                        echo '</div>';
                    }
                } else {
                    // Один столбец в блоке ttSingleRow (увеличенный шрифт)
                    echo '<div class="ttSingleRow">';
                    outRow($content);
                    echo '</div>';
                }
            }
            ?>
        </main>
    </div>

    <!-- ПОДВАЛ – информация о текущем состоянии (листинг А‑5.9) -->
    <footer>
        <?php
        // Определяем тип вёрстки для текста
        if (!isset($_GET['html_type']) || $_GET['html_type'] == 'TABLE') {
            $s = 'Табличная верстка. ';
        } else {
            $s = 'Блочная верстка. ';
        }

        // Определяем содержание таблицы
        if (!isset($_GET['content'])) {
            $s .= 'Таблица умножения полностью. ';
        } else {
            $s .= 'Столбец таблицы умножения на ' . $_GET['content'] . '. ';
        }

        // Добавляем текущую дату и время (уже по Москве)
        echo $s . date('d.m.Y H:i:s');
        ?>
    </footer>
</body>

</html>