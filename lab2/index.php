<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Лабораторная работа А-2 | Цуканов К.Р., 241-352, вариант 7</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">Московский Политех</div>
        <div class="student-info">
            Цуканов Кирилл Русланович, группа 241-352, лабораторная работа № А-2, вариант 7
        </div>
    </header>

    <main>
        <?php
        // ===== ИНИЦИАЛИЗАЦИЯ ПЕРЕМЕННЫХ =====
        $x_start = -5;                 // начальное значение аргумента
        $num = 50;                      // максимальное количество вычисляемых значений
        $step = 0.5;                     // шаг изменения аргумента
        $min_value = -10000;             // минимальное значение функции для остановки
        $max_value = 10000;              // максимальное значение функции для остановки
        $type = 'A';                      // тип вёрстки (A, B, C, D, E)
        $loop_type = 'for';                // тип цикла: 'for', 'while', 'dowhile'

        // Массив для сбора числовых значений функции (статистика)
        $values = [];
        $x = $x_start;

        // ===== ОТКРЫВАЮЩИЕ ТЕГИ В ЗАВИСИМОСТИ ОТ ТИПА ВЁРСТКИ =====
        switch ($type) {
            case 'B':
                echo '<ul>';
                break;
            case 'C':
                echo '<ol>';
                break;
            case 'D':
                echo '<table class="result-table">';
                echo '<tr><th>№</th><th>x</th><th>f(x)</th></tr>';
                break;
            case 'E':
                echo '<div class="blocks-container">';
                break;
        }

        /* ==========================================================================
           ИССЛЕДОВАНИЕ ТИПОВ ЦИКЛОВ
           --------------------------------------------------------------------------
           1. Цикл for (счётчик) – самый компактный и удобный, когда заранее известно
              максимальное количество итераций. Все управляющие выражения собраны
              в одном месте, легко читается. Досрочный выход – через break.

           2. Цикл while – условие проверяется перед каждой итерацией. Требуется
              ручная инициализация и инкремент переменных. Подходит, если число шагов
              заранее неизвестно и зависит от вычислений.

           3. Цикл do...while – гарантирует хотя бы одно выполнение тела. В данной
              задаче первая итерация всегда нужна, поэтому он также применим, но
              постпроверка делает код чуть менее прозрачным.

           ОПТИМАЛЬНЫЙ ВЫБОР: for, так как он наиболее нагляден и требует меньше
           служебного кода. Далее реализованы все три варианта; переключение
           производится переменной $loop_type.
         ========================================================================== */

        // В зависимости от выбранного типа цикла выполняем соответствующий блок
        switch ($loop_type) {
            // -------------------- Цикл for --------------------
            case 'for':
                for ($i = 0; $i < $num; $i++, $x += $step) {
                    // Вычисление функции
                    if ($x <= 10) {
                        if (($x - 5) == 0) {
                            $f = 'error';
                        } else {
                            $f = (6 * $x / ($x - 5)) - 5;
                        }
                    } elseif ($x < 20) {
                        $f = ($x * $x - 1) * $x + 7;          // (x²-1)·x + 7
                    } else {
                        $f = 4 * $x + 5;                       // 4·x + 5
                    }

                    // Округление, проверка пределов, накопление статистики, вывод
                    if (is_numeric($f)) {
                        $f = round($f, 3);
                    }

                    if (is_numeric($f) && ($f >= $max_value || $f < $min_value)) {
                        break;  // остановка по пределу
                    }

                    if (is_numeric($f)) {
                        $values[] = $f;
                    }

                    $x_display = round($x, 3);
                    // Вывод согласно типу вёрстки
                    renderResult($type, $i, $x_display, $f);
                }
                break;

            // -------------------- Цикл while --------------------
            case 'while':
                $i = 0;
                $x = $x_start;  // сбрасываем на случай, если уже менялся
                while ($i < $num) {
                    // Вычисление функции (аналогично)
                    if ($x <= 10) {
                        if (($x - 5) == 0) {
                            $f = 'error';
                        } else {
                            $f = (6 * $x / ($x - 5)) - 5;
                        }
                    } elseif ($x < 20) {
                        $f = ($x * $x - 1) * $x + 7;
                    } else {
                        $f = 4 * $x + 5;
                    }

                    if (is_numeric($f)) {
                        $f = round($f, 3);
                    }

                    // Проверка пределов – если достигнут, выходим из цикла
                    if (is_numeric($f) && ($f >= $max_value || $f < $min_value)) {
                        break;
                    }

                    if (is_numeric($f)) {
                        $values[] = $f;
                    }

                    $x_display = round($x, 3);
                    renderResult($type, $i, $x_display, $f);

                    // Обновляем счётчик и аргумент
                    $i++;
                    $x += $step;
                }
                break;

            // -------------------- Цикл do...while --------------------
            case 'dowhile':
                $i = 0;
                $x = $x_start;
                do {
                    if ($x <= 10) {
                        if (($x - 5) == 0) {
                            $f = 'error';
                        } else {
                            $f = (6 * $x / ($x - 5)) - 5;
                        }
                    } elseif ($x < 20) {
                        $f = ($x * $x - 1) * $x + 7;
                    } else {
                        $f = 4 * $x + 5;
                    }

                    if (is_numeric($f)) {
                        $f = round($f, 3);
                    }

                    if (is_numeric($f) && ($f >= $max_value || $f < $min_value)) {
                        // Всё равно выведем это значение (оно уже вычислено), а затем выйдем
                        if (is_numeric($f)) {
                            $values[] = $f;
                        }
                        $x_display = round($x, 3);
                        renderResult($type, $i, $x_display, $f);
                        break;
                    }

                    if (is_numeric($f)) {
                        $values[] = $f;
                    }

                    $x_display = round($x, 3);
                    renderResult($type, $i, $x_display, $f);

                    $i++;
                    $x += $step;
                } while ($i < $num);
                break;

            default:
                echo '<p>Неизвестный тип цикла.</p>';
        }

        // ===== ЗАКРЫВАЮЩИЕ ТЕГИ =====
        switch ($type) {
            case 'B':
                echo '</ul>';
                break;
            case 'C':
                echo '</ol>';
                break;
            case 'D':
                echo '</table>';
                break;
            case 'E':
                echo '</div>';
                break;
        }

        // ===== СТАТИСТИКА =====
        if (!empty($values)) {
            $min_val = min($values);
            $max_val = max($values);
            $sum_val = array_sum($values);
            $avg_val = $sum_val / count($values);

            $min_val = round($min_val, 3);
            $max_val = round($max_val, 3);
            $sum_val = round($sum_val, 3);
            $avg_val = round($avg_val, 3);

            echo '<div class="statistics">';
            echo "<p>Минимальное значение функции: $min_val</p>";
            echo "<p>Максимальное значение функции: $max_val</p>";
            echo "<p>Сумма значений функции: $sum_val</p>";
            echo "<p>Среднее арифметическое: $avg_val</p>";
            echo '</div>';
        } else {
            echo '<p>Нет вычисленных значений функции.</p>';
        }

        /**
         * Вспомогательная функция для вывода результата в зависимости от типа вёрстки
         */
        function renderResult($type, $i, $x_display, $f) {
            switch ($type) {
                case 'A':
                    if ($i > 0) echo '<br>';
                    echo "f($x_display)=$f";
                    break;
                case 'B':
                case 'C':
                    echo "<li>f($x_display)=$f</li>";
                    break;
                case 'D':
                    echo "<tr><td>" . ($i + 1) . "</td><td>$x_display</td><td>$f</td></tr>";
                    break;
                case 'E':
                    echo "<div class=\"result-block\">f($x_display)=$f</div>";
                    break;
            }
        }
        ?>
    </main>

    <footer>
        <p>Тип вёрстки: <?php echo $type; ?> | Тип цикла: <?php echo $loop_type; ?></p>
        <p>&copy; 2025</p>
    </footer>
</body>
</html>