<?php
if (!defined('_SITE_ACCESS'))
    die('Доступ запрещен');
?>
<form name="form_add" method="post" action="?p=add">
    <label>Фамилия: <input type="text" name="lastname" required></label>
    <label>Имя: <input type="text" name="firstname" required></label>
    <label>Отчество: <input type="text" name="middlename"></label>
    <label>Пол:
        <input type="radio" name="gender" value="male" checked> Мужской
        <input type="radio" name="gender" value="female"> Женский
    </label>
    <label>Дата рождения: <input type="date" name="birthdate"></label>
    <label>Телефон: <input type="text" name="phone"></label>
    <label>Адрес: <textarea name="address"></textarea></label>
    <label>Email: <input type="email" name="email"></label>
    <label>Комментарий: <textarea name="comment"></textarea></label>
    <input type="submit" name="button" value="Добавить запись">
</form>
<?php
if (isset($_POST['button']) && $_POST['button'] == 'Добавить запись') {
    // Проверка обязательных полей
    if (empty($_POST['lastname']) || empty($_POST['firstname']) || empty($_POST['gender'])) {
        echo '<div class="error">Ошибка: форма заполнена неверно</div>';
        return;
    }

    $mysqli = mysqli_connect('MySQL-8.0', 'root', '', 'friends');
    if (mysqli_connect_errno()) {
        echo '<div class="error">Ошибка подключения к БД: ' . mysqli_connect_error() . '</div>';
        return;
    }

    $lastname = htmlspecialchars($_POST['lastname']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $middlename = htmlspecialchars($_POST['middlename']);
    $gender = htmlspecialchars($_POST['gender']);
    $birthdate = htmlspecialchars($_POST['birthdate']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);
    $email = htmlspecialchars($_POST['email']);
    $comment = htmlspecialchars($_POST['comment']);

    // Пустые необязательные поля заменяем на NULL
    $birthdate_sql = ($birthdate === '') ? 'NULL' : "'$birthdate'";
    $phone_sql = ($phone === '') ? 'NULL' : "'$phone'";
    $address_sql = ($address === '') ? 'NULL' : "'$address'";
    $email_sql = ($email === '') ? 'NULL' : "'$email'";
    $comment_sql = ($comment === '') ? 'NULL' : "'$comment'";

    $sql = "INSERT INTO friends (lastname, firstname, middlename, gender, birthdate, phone, address, email, comment)
            VALUES ('$lastname', '$firstname', '$middlename', '$gender', $birthdate_sql, $phone_sql, $address_sql, $email_sql, $comment_sql)";

    $res = mysqli_query($mysqli, $sql);
    if ($res) {
        echo '<div class="ok">Запись добавлена</div>';
    } else {
        echo '<div class="error">Ошибка: форма заполнена неверно</div>';
    }
    mysqli_close($mysqli);
}
?>