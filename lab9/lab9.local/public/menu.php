<?php
if (!defined('_SITE_ACCESS'))
    die('Доступ запрещен');

// если нет параметра меню - добавляем его
if (!isset($_GET['p']))
    $_GET['p'] = 'viewer';

echo '<div id="menu">';

echo '<a href="?p=viewer"';
if ($_GET['p'] == 'viewer')
    echo ' class="selected"';
echo '>Просмотр</a>';

echo '<a href="?p=add"';
if ($_GET['p'] == 'add')
    echo ' class="selected"';
echo '>Добавление записи</a>';

echo '<a href="?p=edit"';
if ($_GET['p'] == 'edit')
    echo ' class="selected"';
echo '>Редактирование записи</a>';

echo '<a href="?p=delete"';
if ($_GET['p'] == 'delete')
    echo ' class="selected"';
echo '>Удаление записи</a>';

echo '</div>';

if ($_GET['p'] == 'viewer') {
    echo '<div id="submenu">';

    echo '<a href="?p=viewer&sort=byid"';
    if (!isset($_GET['sort']) || $_GET['sort'] == 'byid')
        echo ' class="selected"';
    echo '>По умолчанию</a>';

    echo '<a href="?p=viewer&sort=fam"';
    if (isset($_GET['sort']) && $_GET['sort'] == 'fam')
        echo ' class="selected"';
    echo '>По фамилии</a>';

    echo '<a href="?p=viewer&sort=birth"';
    if (isset($_GET['sort']) && $_GET['sort'] == 'birth')
        echo ' class="selected"';
    echo '>По дате рождения</a>';

    echo '</div>';
}
?>