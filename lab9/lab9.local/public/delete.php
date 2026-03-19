<?php
if (!defined('_SITE_ACCESS'))
    die('Доступ запрещен');

$mysqli = mysqli_connect('MySQL-8.0', 'root', '', 'friends');
if (mysqli_connect_errno()) {
    echo '<p class="error">Ошибка подключения к БД: ' . mysqli_connect_error() . '</p>';
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];
    $res = mysqli_query($mysqli, "SELECT lastname FROM friends WHERE id=$id");
    if ($res && $row = mysqli_fetch_assoc($res)) {
        $lastname = htmlspecialchars($row['lastname']);
        $del_res = mysqli_query($mysqli, "DELETE FROM friends WHERE id=$id");
        if ($del_res) {
            echo '<div class="ok">Запись с фамилией ' . $lastname . ' удалена</div>';
        } else {
            echo '<div class="error">Ошибка удаления</div>';
        }
    } else {
        echo '<div class="error">Запись не найдена</div>';
    }
}

$res = mysqli_query($mysqli, "SELECT id, lastname, firstname, middlename FROM friends ORDER BY lastname, firstname");
if ($res) {
    echo '<div id="delete_links">';
    while ($row = mysqli_fetch_assoc($res)) {
        $initials = '';
        if (!empty($row['firstname'])) {
            $initials .= mb_substr($row['firstname'], 0, 1, 'UTF-8') . '.';
        }
        if (!empty($row['middlename'])) {
            $initials .= mb_substr($row['middlename'], 0, 1, 'UTF-8') . '.';
        }
        $fullname = htmlspecialchars($row['lastname'] . ' ' . $initials);
        echo '<a href="?p=delete&id=' . $row['id'] . '">' . $fullname . '</a><br>';
    }
    echo '</div>';
} else {
    echo '<p class="error">Ошибка получения списка</p>';
}

mysqli_close($mysqli);
?>