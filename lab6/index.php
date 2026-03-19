<?php
// Лабораторная работа № А-6
// Цуканов Кирилл Русланович, группа 241-352, вариант 27
// Тест математических знаний. Использование форм для передачи данных в программу PHP

// Инициализация переменных для значений полей формы (при первом запуске или повторном тесте)
$default_fio = '';
$default_group = '';
// Генерация случайных десятичных чисел от 0 до 100 с одним знаком после запятой
$default_a = mt_rand(0, 1000) / 10;
$default_b = mt_rand(0, 1000) / 10;
$default_c = mt_rand(0, 1000) / 10;
$default_about = '';
$default_email = '';
$default_task = 'mean';          // значение по умолчанию для первого селектора
$default_view = 'browser';        // значение по умолчанию для второго селектора

// Если есть GET-параметры (пришли по ссылке "Повторить тест"), заполняем ФИО и группу из них
if (isset($_GET['FIO']) || isset($_GET['GROUP'])) {
    $default_fio = isset($_GET['FIO']) ? htmlspecialchars($_GET['FIO']) : '';
    $default_group = isset($_GET['GROUP']) ? htmlspecialchars($_GET['GROUP']) : '';
}

// Переменные для отчёта
$out_text = '';
$result_computed = null;
$show_report = false;
$error_empty_answer = false;
$mail_sent_message = '';

// Обработка POST-запроса (форма отправлена)
if (isset($_POST['A'])) {
    // Получаем и очищаем входные данные
    $fio = htmlspecialchars(trim($_POST['FIO'] ?? ''));
    $group = htmlspecialchars(trim($_POST['GROUP'] ?? ''));
    $about = htmlspecialchars(trim($_POST['ABOUT'] ?? ''));
    $user_answer_raw = trim($_POST['result'] ?? '');
    $email = htmlspecialchars(trim($_POST['MAIL'] ?? ''));
    $task = $_POST['TASK'] ?? 'mean';
    $view = $_POST['VIEW'] ?? 'browser';
    $send_mail = isset($_POST['send_mail']);

    // Преобразуем A, B, C в числа с заменой запятой на точку
    $a = (float) str_replace(',', '.', $_POST['A'] ?? 0);
    $b = (float) str_replace(',', '.', $_POST['B'] ?? 0);
    $c = (float) str_replace(',', '.', $_POST['C'] ?? 0);

    // Вычисляем результат в зависимости от выбранной задачи
    switch ($task) {
        case 'triangle_perimeter':
            $result_computed = $a + $b + $c;
            $task_name = 'Периметр треугольника';
            break;
        case 'triangle_area':
            // Площадь треугольника по формуле Герона
            if ($a <= 0 || $b <= 0 || $c <= 0 || $a + $b <= $c || $a + $c <= $b || $b + $c <= $a) {
                $result_computed = null;
                $task_name = 'Площадь треугольника (невозможный треугольник)';
            } else {
                $p = ($a + $b + $c) / 2;                // полупериметр
                $area = sqrt($p * ($p - $a) * ($p - $b) * ($p - $c));
                $result_computed = $area;                // сохраняем без округления
                $task_name = 'Площадь треугольника';
            }
            break;
        case 'parallelepiped_volume':
            $result_computed = $a * $b * $c;
            $task_name = 'Объём параллелепипеда';
            break;
        case 'mean':
            $result_computed = ($a + $b + $c) / 3;
            $task_name = 'Среднее арифметическое';
            break;
        case 'sum_squares':
            $result_computed = $a * $a + $b * $b + $c * $c;
            $task_name = 'Сумма квадратов';
            break;
        case 'max_of_three':
            $result_computed = max($a, $b, $c);
            $task_name = 'Максимальное из трёх';
            break;
        case 'geometric_mean':
            $result_computed = pow($a * $b * $c, 1 / 3);
            $task_name = 'Среднее геометрическое';
            break;
        default:
            $result_computed = 0;
            $task_name = 'Неизвестная задача';
    }

    if ($result_computed !== null) {
        $result_computed = round($result_computed, 2);
    }

    // Подготовка отчёта
    $out_text = 'ФИО: ' . $fio . '<br>';
    $out_text .= 'Группа: ' . $group . '<br>';
    if (!empty($about)) {
        $out_text .= '<br>' . $about . '<br>';
    }
    $out_text .= 'Решаемая задача: ' . $task_name . '<br>';
    $out_text .= 'Входные данные: A = ' . $a . ', B = ' . $b . ', C = ' . $c . '<br>';

    if ($user_answer_raw === '') {
        $error_empty_answer = true;
        $out_text .= 'Предполагаемый результат: <i>Задача самостоятельно решена не была</i><br>';
    } else {
        $user_answer = (float) str_replace(',', '.', $user_answer_raw);
        $out_text .= 'Предполагаемый результат: ' . $user_answer . '<br>';
    }

    $out_text .= 'Вычисленный результат: ' . $result_computed . '<br>';

    if (!$error_empty_answer) {
        if (abs($result_computed - $user_answer) < 0.01) {
            $out_text .= '<br><b>ТЕСТ ПРОЙДЕН</b><br>';
        } else {
            $out_text .= '<br><b>ОШИБКА: ТЕСТ НЕ ПРОЙДЕН!</b><br>';
        }
    } else {
        $out_text .= '<br><b>ОШИБКА: ТЕСТ НЕ ПРОЙДЕН (пустой ответ)</b><br>';
    }

    // Отправка письма
    if ($send_mail && !empty($email)) {
        $text_mail = str_replace('<br>', "\r\n", $out_text);
        $subject = 'Результат тестирования';
        $headers = "From: auto@polytech.ru\r\nContent-Type: text/plain; charset=utf-8\r\n";
        if (mail($email, $subject, $text_mail, $headers)) {
            $mail_sent_message = 'Результаты теста были автоматически отправлены на e-mail ' . htmlspecialchars($email);
        } else {
            $mail_sent_message = 'Ошибка при отправке письма.';
        }
    }

    $show_report = true;
    $default_fio = $fio;
    $default_group = $group;
}

// Определяем класс для печатной версии
$body_class = '';
if ($show_report && isset($view) && $view === 'print') {
    $body_class = 'print-version';
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Лабораторная работа А-6 | Цуканов К.Р., 241-352, вариант 27</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="<?php echo $body_class; ?>">
    <header>
        <div class="logo">Московский Политех</div>
        <div class="student-info">Цуканов Кирилл Русланович, группа 241-352, лабораторная работа № А-6, вариант 27</div>
    </header>
    <main>
        <?php if ($show_report): ?>
            <!-- Отчёт -->
            <div class="report">
                <?php echo $out_text; ?>
                <?php if (!empty($mail_sent_message)): ?>
                    <p><strong><?php echo $mail_sent_message; ?></strong></p>
                <?php endif; ?>

                <?php if ($view === 'browser'): ?>
                    <a href="?FIO=<?php echo urlencode($default_fio); ?>&GROUP=<?php echo urlencode($default_group); ?>"
                        id="back_button">Повторить тест</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <!-- Форма -->
            <form name="form" method="post" action="/" class="test-form">
                <div class="form-row">
                    <label for="fio">ФИО:</label>
                    <input type="text" id="fio" name="FIO" value="<?php echo $default_fio; ?>" required>
                </div>
                <div class="form-row">
                    <label for="group">Номер группы:</label>
                    <input type="text" id="group" name="GROUP" value="<?php echo $default_group; ?>" required>
                </div>
                <div class="form-row">
                    <label for="a">Значение А:</label>
                    <input type="text" id="a" name="A" value="<?php echo $default_a; ?>" required>
                </div>
                <div class="form-row">
                    <label for="b">Значение В:</label>
                    <input type="text" id="b" name="B" value="<?php echo $default_b; ?>" required>
                </div>
                <div class="form-row">
                    <label for="c">Значение С:</label>
                    <input type="text" id="c" name="C" value="<?php echo $default_c; ?>" required>
                </div>
                <div class="form-row">
                    <label for="result">Ваш ответ:</label>
                    <input type="text" id="result" name="result">
                </div>
                <div class="form-row">
                    <label for="about">Немного о себе:</label>
                    <textarea id="about" name="ABOUT" rows="4"><?php echo $default_about; ?></textarea>
                </div>

                <!-- Селектор задач с добавленной опцией "Площадь треугольника" -->
                <div class="form-row">
                    <label for="task">Задача:</label>
                    <select id="task" name="TASK">
                        <option value="triangle_perimeter">Периметр треугольника</option>
                        <option value="triangle_area">Площадь треугольника</option> <!-- новая опция -->
                        <option value="parallelepiped_volume">Объём параллелепипеда</option>
                        <option value="mean" selected>Среднее арифметическое</option>
                        <option value="sum_squares">Сумма квадратов</option>
                        <option value="max_of_three">Максимальное из трёх</option>
                        <option value="geometric_mean">Среднее геометрическое</option>
                    </select>
                </div>

                <!-- Флажок отправки на e-mail -->
                <div class="form-row">
                    <label for="send_mail">Отправить результат по e-mail:</label>
                    <input type="checkbox" id="send_mail" name="send_mail" onclick="toggleEmailField()">
                </div>
                <div class="form-row" id="email_row" style="display: none;">
                    <label for="mail">Ваш e-mail:</label>
                    <input type="email" id="mail" name="MAIL" value="<?php echo $default_email; ?>">
                </div>

                <!-- Селектор версии -->
                <div class="form-row">
                    <label for="view">Версия:</label>
                    <select id="view" name="VIEW">
                        <option value="browser" selected>Для просмотра в браузере</option>
                        <option value="print">Для печати</option>
                    </select>
                </div>

                <!-- Кнопка "Проверить" -->
                <div class="form-row">
                    <label></label>
                    <button type="submit">Проверить</button>
                </div>
            </form>

            <script>
                function toggleEmailField() {
                    var chk = document.getElementById('send_mail');
                    var emailRow = document.getElementById('email_row');
                    if (chk.checked) {
                        emailRow.style.display = 'flex';
                    } else {
                        emailRow.style.display = 'none';
                    }
                }
            </script>
        <?php endif; ?>
    </main>
    <footer>
        <p>© 2025</p>
    </footer>
</body>

</html>