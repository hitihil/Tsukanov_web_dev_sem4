<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Лабораторная работа А‑7 | Цуканов К.Р., 241‑352, вариант 27</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .element_row {
            padding: 5px;
        }

        .element_row input {
            margin-left: 10px;
        }

        .num_col {
            font-weight: bold;
            padding-right: 10px;
        }

        table {
            border-collapse: collapse;
            margin: 15px 0;
        }

        td {
            padding: 3px 10px;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">Московский Политех</div>
        <div class="student-info">Цуканов Кирилл Русланович, группа 241‑352, лабораторная работа № А‑7, вариант 27</div>
    </header>
    <main>
        <h2>Ввод массива чисел и выбор алгоритма сортировки</h2>
        <form action="sort.php" method="post" target="_blank">
            <table id="elements">
                <tr>
                    <td class="num_col">1:</td> <!-- нумерация с 1 -->
                    <td class="element_row"><input type="text" name="element0"></td>
                </tr>
            </table>
            <input type="hidden" name="arrLength" id="arrLength" value="1">

            <label for="algoritm">Выберите алгоритм сортировки:</label>
            <select name="algoritm" id="algoritm">
                <option value="choice">Сортировка выбором</option>
                <option value="bubble">Пузырьковый алгоритм</option>
                <option value="shell">Алгоритм Шелла</option>
                <option value="gnome">Алгоритм садового гнома</option>
                <option value="quick">Быстрая сортировка</option>
                <option value="php_sort">Встроенная функция PHP (sort)</option>
            </select>

            <p>
                <input type="button" value="Добавить ещё один элемент" onclick="addElement()">
                <input type="submit" value="Сортировать массив">
            </p>
        </form>
    </main>
    <footer>
        <p>© 2025</p>
    </footer>

    <script>
        function setHTML(element, txt) {
            if (element.innerHTML !== undefined) {
                element.innerHTML = txt;
            } else {
                var range = document.createRange();
                range.selectNodeContents(element);
                range.deleteContents();
                var fragment = range.createContextualFragment(txt);
                element.appendChild(fragment);
            }
        }

        function addElement() {
            var table = document.getElementById('elements');
            var rowCount = table.rows.length;          // текущее количество строк до добавления
            var newRow = table.insertRow(rowCount);     // добавляем строку в конец

            var cellNum = newRow.insertCell(0);
            cellNum.className = 'num_col';
            setHTML(cellNum, (rowCount + 1) + ':');       // номер = rowCount+1

            var cellInput = newRow.insertCell(1);
            cellInput.className = 'element_row';
            var inputHtml = '<input type="text" name="element' + rowCount + '">';
            setHTML(cellInput, inputHtml);

            document.getElementById('arrLength').value = table.rows.length;
        }
    </script>
</body>

</html>