<?php
// Лабораторная работа В-2: Преобразование типов. Сессии. Калькулятор
// Студент: Цуканов Кирилл Русланович, группа 241-352, вариант 27

// --- Подключение механизма сессий ---
session_start();

// Если запрошен favicon.ico или другой статический файл — завершаем работу, не увеличивая счётчик
if (strpos($_SERVER['REQUEST_URI'], 'favicon.ico') !== false) {
    exit;
}

// --- Инициализация данных сессии ---
if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = array();   // массив для истории
    $_SESSION['iteration'] = 0;       // счётчик загрузок
}
$_SESSION['iteration']++;

// --- Функция проверки, является ли значение числом (работает и со строками, и с числами) ---
function isnum($x)
{
    // Приводим к строке, чтобы избежать предупреждений при обращении по индексу
    $x = (string) $x;

    // Пустая строка — не число
    if ($x === '')
        return false;

    // Обработка отрицательного числа (ведущий минус)
    if ($x[0] === '-') {
        // Если минус и больше ничего нет — не число
        if (strlen($x) == 1)
            return false;
        // Убираем минус и проверяем оставшуюся часть как положительное число
        $x = substr($x, 1);
    }

    // Далее проверяем строку $x на корректность положительного числа
    // Ведущий ноль допускается только если число состоит из одного нуля или после нуля сразу идёт точка
    if ($x[0] == '0' && strlen($x) > 1 && $x[1] != '.')
        return false;

    // Число не может начинаться с точки
    if ($x[0] == '.')
        return false;
    // Число не может заканчиваться точкой
    if ($x[strlen($x) - 1] == '.')
        return false;

    $point_count = 0;
    for ($i = 0; $i < strlen($x); $i++) {
        $ch = $x[$i];
        // Разрешены только цифры и точка
        if (!($ch >= '0' && $ch <= '9') && $ch != '.')
            return false;
        if ($ch == '.') {
            $point_count++;
            if ($point_count > 1)
                return false;
        }
    }
    return true;
}

// --- Вычисление выражения без скобок ---
function calculate($val)
{
    if ($val === '')
        return 'Выражение не задано!';
    if (isnum($val))
        return $val;   // база рекурсии

    $val = str_replace(':', '/', $val); // поддержка ":"

    // Сложение
    $args = explode('+', $val);
    if (count($args) > 1) {
        $sum = 0;
        foreach ($args as $arg) {
            $sub = calculate($arg);
            if (!isnum($sub))
                return $sub;
            $sum += $sub;
        }
        return $sum;
    }

    // Вычитание
    $args = explode('-', $val);
    if (count($args) > 1) {
        $first = calculate($args[0]);
        if (!isnum($first))
            return $first;
        $result = $first;
        for ($i = 1; $i < count($args); $i++) {
            $sub = calculate($args[$i]);
            if (!isnum($sub))
                return $sub;
            $result -= $sub;
        }
        return $result;
    }

    // Умножение
    $args = explode('*', $val);
    if (count($args) > 1) {
        $product = 1;
        foreach ($args as $arg) {
            $sub = calculate($arg);
            if (!isnum($sub))
                return $sub;
            $product *= $sub;
        }
        return $product;
    }

    // Деление
    $args = explode('/', $val);
    if (count($args) > 1) {
        $first = calculate($args[0]);
        if (!isnum($first))
            return $first;
        $result = $first;
        for ($i = 1; $i < count($args); $i++) {
            $sub = calculate($args[$i]);
            if (!isnum($sub))
                return $sub;
            if ($sub == 0)
                return 'Деление на ноль!';
            $result /= $sub;
        }
        return $result;
    }

    return 'Недопустимые символы в выражении';
}

// --- Проверка скобок ---
function SqValidator($val)
{
    $val = (string) $val;   // на всякий случай
    $open = 0;
    for ($i = 0; $i < strlen($val); $i++) {
        if ($val[$i] == '(') {
            $open++;
        } elseif ($val[$i] == ')') {
            $open--;
            if ($open < 0)
                return false;
        }
    }
    return $open == 0;
}

// --- Вычисление выражения со скобками ---
function calculateSq($val)
{
    $val = str_replace(' ', '', $val); // удаляем пробелы

    if (!SqValidator($val))
        return 'Неправильная расстановка скобок';

    $start = strpos($val, '(');
    if ($start === false) {
        return calculate($val);
    }

    // Поиск парной закрывающей скобки
    $end = $start + 1;
    $open = 1;
    while ($open > 0 && $end < strlen($val)) {
        if ($val[$end] == '(')
            $open++;
        if ($val[$end] == ')')
            $open--;
        $end++;
    }

    $left = substr($val, 0, $start);
    $inner = substr($val, $start + 1, $end - $start - 2);
    $right = substr($val, $end);

    $innerRes = calculateSq($inner);
    if (!isnum($innerRes))
        return $innerRes;   // ошибка внутри скобок

    $newExpr = $left . $innerRes . $right;
    return calculateSq($newExpr);
}

// --- Обработка POST-запроса ---
$res = null;
$needSave = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['val'])) {
    $formIter = isset($_POST['iteration']) ? (int) $_POST['iteration'] : 0;
    if ($formIter + 1 == $_SESSION['iteration']) {
        $res = calculateSq($_POST['val']);
        $needSave = true;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Лабораторная работа В-2 | Цуканов К.Р., 241-352, вариант 27</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <div class="logo">Московский Политех</div>
        <div class="student-info">Цуканов Кирилл Русланович, группа 241-352, лабораторная работа № В-2, вариант 27</div>
    </header>

    <main>
        <?php if ($res !== null): ?>
            <div class="result">
                <?php if (isnum($res)): ?>
                    Значение выражения:
                    <?= $res ?>
                <?php else: ?>
                    Ошибка вычисления выражения:
                    <?= htmlspecialchars($res) ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <label for="val">Введите выражение:</label>
            <input type="text" name="val" id="val" required>
            <input type="hidden" name="iteration" value="<?= $_SESSION['iteration'] ?>">
            <button type="submit">Вычислить</button>
        </form>
    </main>

    <footer>
        <?php
        if (!empty($_SESSION['history'])) {
            foreach ($_SESSION['history'] as $entry) {
                echo htmlspecialchars($entry) . '<br>';
            }
        }

        if ($needSave && $res !== null) {
            $_SESSION['history'][] = $_POST['val'] . ' = ' . $res;
        }
        ?>
    </footer>
</body>

</html>