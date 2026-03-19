<?php
// [!] Функция проверки, является ли аргумент не числом (теперь работает с дробными и отрицательными)
function arg_is_not_Num($arg) {
    if ($arg === '') return true;
    // Используем is_numeric – поддерживает целые, дробные, отрицательные, экспоненту
    return !is_numeric($arg);
}

// ---------- АЛГОРИТМЫ СОРТИРОВКИ (с выводом каждой итерации) ----------

// Сортировка выбором - ищем наименьшее и меняем с первым, вторым и т.д. элементами
function selectionSort(&$arr, &$iter)
{
    $n = count($arr);
    for ($i = 0; $i < $n - 1; $i++) {
        $minIdx = $i;
        // внутренний цикл поиска минимума
        for ($j = $i + 1; $j < $n; $j++) {
            $iter++; // каждая итерация внутреннего цикла - шаг
            if ($arr[$j] < $arr[$minIdx]) {
                $minIdx = $j;
            }
            // выводим состояние после сравнения (даже если не меняли)
            echo "Итерация $iter: [" . implode(', ', $arr) . "]<br>";
        }
        if ($minIdx != $i) {
            $temp = $arr[$i];
            $arr[$i] = $arr[$minIdx];
            $arr[$minIdx] = $temp;
            $iter++; // ещё одна итерация - обмен
            echo "Итерация $iter: [" . implode(', ', $arr) . "]<br>";
        }
    }
}

// Пузырьковая сортировка - идем от первого к последнему и меняем элементы между собой местами
function bubbleSort(&$arr, &$iter)
{
    $n = count($arr);
    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = 0; $j < $n - $i - 1; $j++) {
            $iter++; // каждый проход внутреннего цикла
            if ($arr[$j] > $arr[$j + 1]) {
                $temp = $arr[$j];
                $arr[$j] = $arr[$j + 1];
                $arr[$j + 1] = $temp;
            }
            echo "Итерация $iter: [" . implode(', ', $arr) . "]<br>";
        }
    }
}

// Сортировка Шелла (с исправлением приращений на floor) - улучшеная сортировка вставками, сперва сортировка на определенном шаге, потом уменьшение шага и вставка элементов
function shellSort(&$arr, &$iter)
{
    $n = count($arr);
    // [!] Заменено на ceil для соответствия методичке (листинг А-7.12)
    for ($k = ceil($n / 2); $k >= 1; $k = ceil($k / 2)) {
        for ($i = $k; $i < $n; $i++) {
            $val = $arr[$i];
            $j = $i - $k;
            // сдвигаем элементы, пока не найдём место для вставки
            while ($j >= 0 && $arr[$j] > $val) {
                $arr[$j + $k] = $arr[$j];
                $j -= $k;
                $iter++; // итерация при сдвиге
                echo "Итерация $iter: [" . implode(', ', $arr) . "]<br>";
            }
            // если позиция изменилась, вставляем значение
            if ($j + $k != $i) {
                $arr[$j + $k] = $val;
                $iter++; // итерация при вставке
                echo "Итерация $iter: [" . implode(', ', $arr) . "]<br>";
            }
        }
    }
}

// Сортировка гномья - идем по массива, сравниваем текущий элемент с предыдущим, если нужно, то меняем и возвращаемся на шаг назад
function gnomeSort(&$arr, &$iter)
{
    $i = 1;
    $n = count($arr);
    while ($i < $n) {
        $iter++; // каждая итерация while
        if ($i == 0 || $arr[$i - 1] <= $arr[$i]) {
            $i++;
        } else {
            $temp = $arr[$i];
            $arr[$i] = $arr[$i - 1];
            $arr[$i - 1] = $temp;
            $i--;
        }
        echo "Итерация $iter: [" . implode(', ', $arr) . "]<br>";
    }
}

// Быстрая сортировка (рекурсивная) - разбиваем на 2 части (1 - меньше опорной части, больше или равные опорной части),
// после чего действие повторяется, в конце идет склеивание по принципу наименьшего значения слева направо
function quickSort(&$arr, $left, $right, &$iter)
{
    $l = $left;
    $r = $right;
    $pivot = $arr[floor(($left + $right) / 2)];
    do {
        while ($arr[$l] < $pivot)
            $l++;
        while ($arr[$r] > $pivot)
            $r--;
        if ($l <= $r) {
            if ($arr[$l] != $arr[$r]) {
                $temp = $arr[$l];
                $arr[$l] = $arr[$r];
                $arr[$r] = $temp;
                $iter++; // итерация при обмене
                echo "Итерация $iter: [" . implode(', ', $arr) . "]<br>";
            }
            $l++;
            $r--;
        }
    } while ($l <= $r);

    if ($left < $r)
        quickSort($arr, $left, $r, $iter);
    if ($l < $right)
        quickSort($arr, $l, $right, $iter);
}

function quickSortWrapper(&$arr, &$iter)
{
    quickSort($arr, 0, count($arr) - 1, $iter);
}

// ---------- ОСНОВНАЯ ПРОГРАММА ----------
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Результат сортировки | Цуканов К.Р., 241‑352, вариант 27</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* дополнительные стили для вывода итераций */
        .arr_element {
            display: inline-block;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 5px 10px;
            margin: 3px;
            border-radius: 3px;
            float: left;
        }

        br {
            clear: left;
        }

        .iteration {
            margin: 5px 0;
            font-family: monospace;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">Московский Политех</div>
        <div class="student-info">Цуканов Кирилл Русланович, группа 241‑352, лабораторная работа № А‑7, вариант 27</div>
    </header>
    <main>
        <?php
        // 1. Проверка наличия данных
        if (!isset($_POST['element0'])) {
            echo '<p>Массив не задан, сортировка невозможна</p>';
            exit();
        }

        // 2. Валидация чисел
        $length = $_POST['arrLength'];
        for ($i = 0; $i < $length; $i++) {
            $elem = $_POST['element' . $i];
            if (arg_is_not_Num($elem)) {
                echo '<p>Элемент массива "' . htmlspecialchars($elem) . '" - не число</p>';
                exit();
            }
        }

        // 3. Определяем алгоритм
        $algo = $_POST['algoritm'];
        $algoName = '';
        switch ($algo) {
            case 'choice':
                $algoName = 'Сортировка выбором';
                break;
            case 'bubble':
                $algoName = 'Пузырьковая сортировка';
                break;
            case 'shell':
                $algoName = 'Сортировка Шелла';
                break;
            case 'gnome':
                $algoName = 'Сортировка садового гнома';
                break;
            case 'quick':
                $algoName = 'Быстрая сортировка';
                break;
            case 'php_sort':
                $algoName = 'Встроенная функция PHP (sort)';
                break;
            default:
                $algoName = 'Неизвестный алгоритм';
        }
        echo '<h1>' . $algoName . '</h1>';

        // 4. Вывод исходного массива и формирование числового массива
        $arr = array();
        echo '<p>Исходный массив<br>---&gt; <br>';

        // Первый вариант – с номерами элементов (от 1)
        for ($i = 0; $i < $length; $i++) {
            $val = $_POST['element' . $i];
            echo '<div class="arr_element">' . ($i + 1) . ': ' . htmlspecialchars($val) . '</div>';
            // [!] Преобразуем строку в число (float), чтобы сортировка была числовой
            $arr[] = (float)$val;
        }
        echo "<br>";

        // Второй вариант – в квадратных скобках (как на итерациях)
        echo '[' . implode(', ', $arr) . ']<br>';

        echo '---&gt; <br>Массив проверен, сортировка возможна</p>';

        // 5. Засекаем время
        $timeStart = microtime(true);
        $iterations = 0;

        // 6. Сортировка
        switch ($algo) {
            case 'choice':
                selectionSort($arr, $iterations);
                break;
            case 'bubble':
                bubbleSort($arr, $iterations);
                break;
            case 'shell':
                shellSort($arr, $iterations);
                break;
            case 'gnome':
                gnomeSort($arr, $iterations);
                break;
            case 'quick':
                quickSortWrapper($arr, $iterations);
                break;
            case 'php_sort':
                // [!] Явно указываем числовую сортировку
                sort($arr, SORT_NUMERIC);
                echo '<p>Результат сортировки: [' . implode(', ', $arr) . ']</p>';
                // для встроенной функции итерации не считаем
                break;
        }

        $timeEnd = microtime(true);
        $timeDiff = $timeEnd - $timeStart;

        // 7. Вывод завершающей информации
        echo '<p>Сортировка завершена, проведено ' . $iterations . ' итераций. ';
        echo 'Затрачено ' . number_format($timeDiff, 6) . ' секунд.</p>';
        ?>
    </main>
    <footer>
        <p>© 2025</p>
    </footer>
</body>

</html>