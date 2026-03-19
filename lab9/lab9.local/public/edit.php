<?php
if (!defined('_SITE_ACCESS'))
    die('Доступ запрещен');

$mysqli = mysqli_connect('MySQL-8.0', 'root', '', 'friends');
if (mysqli_connect_errno()) {
    echo '<p class="error">Ошибка подключения к БД: ' . mysqli_connect_error() . '</p>';
    exit();
}

if (isset($_POST['button']) && $_POST['button'] == 'Изменить запись') {
    if (empty($_POST['lastname']) || empty($_POST['firstname']) || empty($_POST['gender'])) {
        echo '<div class="error">Ошибка: форма заполнена неверно</div>';
    } else {
        $id = (int) $_GET['id'];
        $lastname = mysqli_real_escape_string($mysqli, $_POST['lastname']);
        $firstname = mysqli_real_escape_string($mysqli, $_POST['firstname']);
        $middlename = mysqli_real_escape_string($mysqli, $_POST['middlename']);
        $gender = mysqli_real_escape_string($mysqli, $_POST['gender']);
        $birthdate = mysqli_real_escape_string($mysqli, $_POST['birthdate']);
        $phone = mysqli_real_escape_string($mysqli, $_POST['phone']);
        $address = mysqli_real_escape_string($mysqli, $_POST['address']);
        $email = mysqli_real_escape_string($mysqli, $_POST['email']);
        $comment = mysqli_real_escape_string($mysqli, $_POST['comment']);

        $birthdate_sql = ($birthdate === '') ? 'NULL' : "'$birthdate'";
        $phone_sql = ($phone === '') ? 'NULL' : "'$phone'";
        $address_sql = ($address === '') ? 'NULL' : "'$address'";
        $email_sql = ($email === '') ? 'NULL' : "'$email'";
        $comment_sql = ($comment === '') ? 'NULL' : "'$comment'";

        $sql = "UPDATE friends SET
                lastname='$lastname', firstname='$firstname', middlename='$middlename',
                gender='$gender', birthdate=$birthdate_sql, phone=$phone_sql,
                address=$address_sql, email=$email_sql, comment=$comment_sql
                WHERE id=$id";
        $res = mysqli_query($mysqli, $sql);
        if ($res) {
            echo '<div class="ok">Данные изменены</div>';
        } else {
            echo '<div class="error">Ошибка: форма заполнена неверно</div>';
        }
    }
}

// Определяем текущую запись
$current_row = null;
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $res = mysqli_query($mysqli, "SELECT * FROM friends WHERE id=$id LIMIT 1");
    $current_row = mysqli_fetch_assoc($res);
}
if (!$current_row) {
    $res = mysqli_query($mysqli, "SELECT * FROM friends ORDER BY id LIMIT 1");
    $current_row = mysqli_fetch_assoc($res);
}

// Список ссылок
$res = mysqli_query($mysqli, "SELECT id, lastname, firstname FROM friends ORDER BY lastname, firstname");
if (!mysqli_errno($mysqli)) {
    echo '<div id="edit_links">';
    while ($row = mysqli_fetch_assoc($res)) {
        if ($current_row && $row['id'] == $current_row['id']) {
            echo '<div class="current">' . htmlspecialchars($row['lastname'] . ' ' . $row['firstname']) . '</div>';
        } else {
            echo '<a href="?p=edit&id=' . $row['id'] . '">' . htmlspecialchars($row['lastname'] . ' ' . $row['firstname']) . '</a>';
        }
    }
    echo '</div>';
} else {
    echo '<p class="error">Ошибка получения списка</p>';
}

// Форма
if ($current_row) {
    $lastname = htmlspecialchars($current_row['lastname']);
    $firstname = htmlspecialchars($current_row['firstname']);
    $middlename = htmlspecialchars($current_row['middlename']);
    $gender = $current_row['gender'];
    $birthdate = htmlspecialchars($current_row['birthdate']);
    $phone = htmlspecialchars($current_row['phone']);
    $address = htmlspecialchars($current_row['address']);
    $email = htmlspecialchars($current_row['email']);
    $comment = htmlspecialchars($current_row['comment']);
    $id = $current_row['id'];

    echo '<form name="form_edit" method="post" action="?p=edit&id=' . $id . '">';
    echo '<label>Фамилия: <input type="text" name="lastname" value="' . $lastname . '" required></label>';
    echo '<label>Имя: <input type="text" name="firstname" value="' . $firstname . '" required></label>';
    echo '<label>Отчество: <input type="text" name="middlename" value="' . $middlename . '"></label>';
    echo '<label>Пол: ';
    echo '<input type="radio" name="gender" value="male"' . ($gender == 'male' ? ' checked' : '') . '> Мужской ';
    echo '<input type="radio" name="gender" value="female"' . ($gender == 'female' ? ' checked' : '') . '> Женский';
    echo '</label>';
    echo '<label>Дата рождения: <input type="date" name="birthdate" value="' . $birthdate . '"></label>';
    echo '<label>Телефон: <input type="text" name="phone" value="' . $phone . '"></label>';
    echo '<label>Адрес: <textarea name="address">' . $address . '</textarea></label>';
    echo '<label>Email: <input type="email" name="email" value="' . $email . '"></label>';
    echo '<label>Комментарий: <textarea name="comment">' . $comment . '</textarea></label>';
    echo '<input type="submit" name="button" value="Изменить запись">';
    echo '</form>';
} else {
    echo '<p>Записей пока нет</p>';
}

mysqli_close($mysqli);
?>