<?php
if (!defined('_SITE_ACCESS'))
    die('Доступ запрещен');

function getFriendsList($type, $page)
{
    $mysqli = mysqli_connect('MySQL-8.0', 'root', '', 'friends');
    if (mysqli_connect_errno()) {
        return '<p class="error">Ошибка подключения к БД: ' . mysqli_connect_error() . '</p>';
    }

    $sql_res = mysqli_query($mysqli, 'SELECT COUNT(*) FROM friends');
    if (!$sql_res) {
        $error = mysqli_error($mysqli);
        mysqli_close($mysqli);
        return '<p class="error">Ошибка запроса: ' . $error . '</p>';
    }
    $row = mysqli_fetch_row($sql_res);
    if (!$row) {
        mysqli_close($mysqli);
        return '<p class="error">Не удалось получить количество записей</p>';
    }
    $total = $row[0];
    if ($total == 0) {
        mysqli_close($mysqli);
        return '<p>В таблице нет данных</p>';
    }

    $per_page = 10;
    $pages = ceil($total / $per_page);
    if ($page >= $pages) {
        $page = $pages - 1;
    }
    if ($page < 0)
        $page = 0;
    $offset = $page * $per_page;

    $sql = "SELECT * FROM friends";
    switch ($type) {
        case 'fam':
            $sql .= " ORDER BY lastname, firstname";
            break;
        case 'birth':
            $sql .= " ORDER BY birthdate";
            break;
        default:
            $sql .= " ORDER BY id";
    }
    $sql .= " LIMIT $offset, $per_page";
    $data_res = mysqli_query($mysqli, $sql);
    if (!$data_res) {
        $error = mysqli_error($mysqli);
        mysqli_close($mysqli);
        return '<p class="error">Ошибка выборки: ' . $error . '</p>';
    }

    $ret = '<table>' . "\n";
    $ret .= '<tr><th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Пол</th><th>Дата рождения</th><th>Телефон</th><th>Адрес</th><th>Email</th><th>Комментарий</th></tr>';
    while ($row = mysqli_fetch_assoc($data_res)) {
        // Пол на русском
        $gender_display = ($row['gender'] == 'male') ? 'Мужской' : 'Женский';
        // Дата в формате дд.мм.гггг
        $birthdate_display = '';
        if (!empty($row['birthdate'])) {
            $date = DateTime::createFromFormat('Y-m-d', $row['birthdate']);
            $birthdate_display = $date ? $date->format('d.m.Y') : htmlspecialchars($row['birthdate']);
        }
        $ret .= '<tr>';
        $ret .= '<td>' . htmlspecialchars($row['lastname']) . '</td>';
        $ret .= '<td>' . htmlspecialchars($row['firstname']) . '</td>';
        $ret .= '<td>' . htmlspecialchars($row['middlename']) . '</td>';
        $ret .= '<td>' . $gender_display . '</td>';
        $ret .= '<td>' . $birthdate_display . '</td>';
        $ret .= '<td>' . htmlspecialchars($row['phone']) . '</td>';
        $ret .= '<td>' . htmlspecialchars($row['address']) . '</td>';
        $ret .= '<td>' . htmlspecialchars($row['email']) . '</td>';
        $ret .= '<td>' . htmlspecialchars($row['comment']) . '</td>';
        $ret .= '</tr>' . "\n";
    }
    $ret .= '</table>' . "\n";

    if ($pages > 1) {
        $ret .= '<div id="pages">' . "\n";
        for ($i = 0; $i < $pages; $i++) {
            if ($i != $page) {
                $ret .= '<a href="?p=viewer&sort=' . urlencode($type) . '&pg=' . $i . '">' . ($i + 1) . '</a>' . "\n";
            } else {
                $ret .= '<span>' . ($i + 1) . '</span>' . "\n";
            }
        }
        $ret .= '</div>' . "\n";
    }

    mysqli_close($mysqli);
    return $ret;
}
?>