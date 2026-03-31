<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?>

<h2>Наши контакты</h2>

<div class="contacts-block">
    <h3>Адрес</h3>
    <p>г. Москва, ул. Чайная, д. 1</p>
    <p>м. Чайковская, выход №3, 5 минут пешком</p>
</div>

<div class="contacts-block">
    <h3>Телефоны</h3>
    <p>+7 (495) 123-45-67</p>
    <p>+7 (926) 765-43-21</p>
</div>

<div class="contacts-block">
    <h3>Email</h3>
    <p>info@tea-shop.ru</p>
    <p>zakaz@tea-shop.ru</p>
</div>

<div class="contacts-block">
    <h3>Режим работы</h3>
    <p>Понедельник — пятница: 10:00–20:00</p>
    <p>Суббота: 11:00–18:00</p>
    <p>Воскресенье: выходной</p>
</div>

<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>