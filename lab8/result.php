<?php
// Устанавливаем правильный заголовок для кодировки UTF-8
header('Content-Type: text/html; charset=utf-8');

// -------------------------------------------------------------
// Вспомогательные функции для работы с текстом в кодировке CP1251
// -------------------------------------------------------------

/**
 * Проверяет, является ли символ (в кодировке CP1251) буквой (латиница или кириллица)
 */
function is_letter($ch)
{
    $ord = ord($ch);
    // латиница A-Z a-z
    if (($ord >= 65 && $ord <= 90) || ($ord >= 97 && $ord <= 122))
        return true;
    // кириллица: заглавные А-Я (192-223) и строчные а-я (224-255), а также Ё (184) и ё (168)
    if (($ord >= 192 && $ord <= 255) || $ord == 168 || $ord == 184)
        return true;
    return false;
}

/**
 * Проверяет, является ли символ (CP1251) заглавной буквой
 */
function is_upper_letter($ch)
{
    $ord = ord($ch);
    // латиница A-Z
    if ($ord >= 65 && $ord <= 90)
        return true;
    // кириллица А-Я и Ё
    if (($ord >= 192 && $ord <= 223) || $ord == 168)
        return true;
    return false;
}

/**
 * Проверяет, является ли символ (CP1251) знаком препинания
 * (используем коды ASCII и некоторые коды CP1251 для русских кавычек и тире)
 */
function is_punctuation($ch)
{
    $ord = ord($ch);
    // основные знаки препинания ASCII: . , ! ? : ; - ( ) [ ] { } " '
    $punct_ascii = [33, 34, 39, 40, 41, 44, 45, 46, 58, 59, 63, 91, 93, 123, 125];
    // русские кавычки « » (171 и 187) и тире — (151)
    $punct_rus = [171, 187, 151];
    return in_array($ord, $punct_ascii) || in_array($ord, $punct_rus);
}

/**
 * Преобразует строку в нижний регистр для кодировки CP1251.
 * Использует mb_strtolower если доступна, иначе собственную реализацию.
 */
function lower_cp1251($text)
{
    // если доступна multibyte-функция, используем её с указанием кодировки
    if (function_exists('mb_strtolower')) {
        return mb_strtolower($text, 'CP1251');
    }
    // иначе собственная реализация (только для латиницы и кириллицы CP1251)
    $len = strlen($text);
    $result = '';
    for ($i = 0; $i < $len; $i++) {
        $ch = $text[$i];
        $ord = ord($ch);
        // латиница заглавная -> строчная
        if ($ord >= 65 && $ord <= 90) {
            $result .= chr($ord + 32);
        }
        // кириллица заглавная А-Я -> а-я
        elseif ($ord >= 192 && $ord <= 223) {
            $result .= chr($ord + 32);
        }
        // Ё (184) -> ё (168)
        elseif ($ord == 168) {
            $result .= chr(184);
        }
        // остальные символы (включая строчные) без изменений
        else {
            $result .= $ch;
        }
    }
    return $result;
}

/**
 * Подсчёт частоты каждого символа в тексте (без учёта регистра)
 * Возвращает массив [символ_в_utf8 => количество]
 */
function get_char_frequencies($text_cp)
{
    // приводим к нижнему регистру (в CP1251)
    $low = lower_cp1251($text_cp);
    $freq = [];
    $len = strlen($low);
    for ($i = 0; $i < $len; $i++) {
        $ch = $low[$i];
        if (isset($freq[$ch])) {
            $freq[$ch]++;
        } else {
            $freq[$ch] = 1;
        }
    }
    // сортируем по символам (ключи в CP1251, но для вывода перекодируем)
    ksort($freq);
    return $freq;
}

/**
 * Разбиение текста на слова и подсчёт количества их вхождений.
 * Словами считаются последовательности букв (латиница/кириллица) и цифр.
 * Возвращает массив [слово_в_оригинале => количество]
 */
function get_word_counts($text_cp)
{
    $words = [];
    $current = '';
    $len = strlen($text_cp);
    for ($i = 0; $i < $len; $i++) {
        $ch = $text_cp[$i];
        // буква или цифра – часть слова
        if (is_letter($ch) || ctype_digit($ch)) {
            $current .= $ch;
        } else {
            // разделитель – слово закончилось
            if ($current !== '') {
                if (isset($words[$current])) {
                    $words[$current]++;
                } else {
                    $words[$current] = 1;
                }
                $current = '';
            }
        }
    }
    // последнее слово, если есть
    if ($current !== '') {
        if (isset($words[$current])) {
            $words[$current]++;
        } else {
            $words[$current] = 1;
        }
    }
    // сортируем по алфавиту (по ключам – оригинальные слова)
    ksort($words);
    return $words;
}

/**
 * Основная функция анализа текста.
 * Выводит всю статистику в виде таблиц.
 * Принимает текст уже в кодировке CP1251.
 */
function test_it($text_cp)
{
    // ---------------------------------------------------------
    // 1. Общая статистика (символы, буквы, регистры, знаки, цифры, слова)
    // ---------------------------------------------------------
    $total_chars = strlen($text_cp);          // символов (включая пробелы)
    $digit_count = 0;
    $letter_count = 0;
    $upper_count = 0;
    $lower_count = 0;
    $punct_count = 0;
    $current_word = '';
    $words_array = [];                         // для подсчёта уникальных слов и повторений

    $len = strlen($text_cp);
    for ($i = 0; $i < $len; $i++) {
        $ch = $text_cp[$i];
        $ord = ord($ch);

        // ---- цифры ----
        if (ctype_digit($ch)) {
            $digit_count++;
            // Будем считать, что слово может состоять из букв и цифр.
            $current_word .= $ch;
        }
        // ---- буквы ----
        elseif (is_letter($ch)) {
            $letter_count++;
            if (is_upper_letter($ch)) {
                $upper_count++;
            } else {
                $lower_count++;
            }
            $current_word .= $ch;
        }
        // ---- знаки препинания ----
        elseif (is_punctuation($ch)) {
            $punct_count++;
            // знак препинания – разделитель слов
            if ($current_word !== '') {
                if (isset($words_array[$current_word])) {
                    $words_array[$current_word]++;
                } else {
                    $words_array[$current_word] = 1;
                }
                $current_word = '';
            }
        }
        // ---- прочие разделители (пробел, табуляция, перевод строки) ----
        else {
            if ($current_word !== '') {
                if (isset($words_array[$current_word])) {
                    $words_array[$current_word]++;
                } else {
                    $words_array[$current_word] = 1;
                }
                $current_word = '';
            }
        }
    }
    // после цикла – последнее слово
    if ($current_word !== '') {
        if (isset($words_array[$current_word])) {
            $words_array[$current_word]++;
        } else {
            $words_array[$current_word] = 1;
        }
    }

    // общее количество слов (сумма всех вхождений)
    $total_words = array_sum($words_array);
    // количество уникальных слов
    $unique_words = count($words_array);

    // ---------------------------------------------------------
    // 2. Частота символов (без учёта регистра)
    // ---------------------------------------------------------
    $char_freq = get_char_frequencies($text_cp);

    // ---------------------------------------------------------
    // 3. ВЫВОД ВСЕХ РЕЗУЛЬТАТОВ В ВИДЕ ТАБЛИЦ
    // ---------------------------------------------------------
    ?>
    <h3>Результаты анализа</h3>

    <!-- Таблица с общей статистикой -->
    <table>
        <tr>
            <th colspan="2">Общая статистика</th>
        </tr>
        <tr>
            <td>Количество символов (с пробелами)</td>
            <td>
                <?= $total_chars ?>
            </td>
        </tr>
        <tr>
            <td>Количество букв</td>
            <td>
                <?= $letter_count ?>
            </td>
        </tr>
        <tr>
            <td> • из них строчных</td>
            <td>
                <?= $lower_count ?>
            </td>
        </tr>
        <tr>
            <td> • из них заглавных</td>
            <td>
                <?= $upper_count ?>
            </td>
        </tr>
        <tr>
            <td>Количество знаков препинания</td>
            <td>
                <?= $punct_count ?>
            </td>
        </tr>
        <tr>
            <td>Количество цифр</td>
            <td>
                <?= $digit_count ?>
            </td>
        </tr>
        <tr>
            <td>Общее количество слов (с повторениями)</td>
            <td>
                <?= $total_words ?>
            </td>
        </tr>
        <tr>
            <td>Количество уникальных слов</td>
            <td>
                <?= $unique_words ?>
            </td>
        </tr>
    </table>

    <!-- Таблица с частотой символов -->
    <table>
        <tr>
            <th colspan="2">Частота символов (без учёта регистра)</th>
        </tr>
        <tr>
            <th>Символ</th>
            <th>Количество</th>
        </tr>
        <?php foreach ($char_freq as $ch_cp => $count): ?>
            <tr>
                <!-- перекодируем символ из CP1251 в UTF-8 для корректного отображения -->
                <td>
                    <?= htmlspecialchars(iconv('CP1251', 'UTF-8', $ch_cp)) ?>
                </td>
                <td>
                    <?= $count ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Таблица со словами и их частотой -->
    <table>
        <tr>
            <th colspan="2">Слова и количество их вхождений (в алфавитном порядке)</th>
        </tr>
        <tr>
            <th>Слово</th>
            <th>Количество</th>
        </tr>
        <?php foreach ($words_array as $word_cp => $count): ?>
            <tr>
                <!-- слово перекодируем в UTF-8 -->
                <td>
                    <?= htmlspecialchars(iconv('CP1251', 'UTF-8', $word_cp)) ?>
                </td>
                <td>
                    <?= $count ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php
}

// -------------------------------------------------------------
// ОСНОВНАЯ ЛОГИКА СТРАНИЦЫ
// -------------------------------------------------------------
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Результат анализа | Цуканов К.Р., 241-352, вариант 27</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <div class="logo">Московский Политех</div>
        <div class="student-info">Цуканов Кирилл Русланович, группа 241-352, лабораторная работа № А-8, вариант 27</div>
    </header>
    <main>
        <?php
        // Проверяем, передан ли текст и не пустой ли он
        if (isset($_POST['data']) && $_POST['data'] !== '') {
            // Исходный текст (в UTF-8) выводим с оформлением
            $original_text = $_POST['data'];
            echo '<div class="src_text">' . nl2br(htmlspecialchars($original_text)) . '</div>';

            // Перекодируем текст из UTF-8 в CP1251 для анализа (как рекомендовано в методичке)
            $text_cp = iconv('UTF-8', 'CP1251//IGNORE', $original_text);

            // Вызываем функцию анализа (она сама выведет все таблицы)
            test_it($text_cp);
        } else {
            // Нет текста – выводим сообщение об ошибке
            echo '<div class="src_error">Нет текста для анализа</div>';
        }
        ?>

        <!-- Кнопка «Другой анализ» – ссылка на index.html -->
        <a href="index.html" class="another-link">Другой анализ</a>
    </main>
    <footer>
        <p>© 2025</p>
    </footer>
</body>

</html>