<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Чайная лавка");
?>

<div class="hero">
    <h2>Добро пожаловать в «Чайную лавку»!</h2>
    <p>Мы — семейный магазин, который с 2010 года радует ценителей настоящего чая. У нас вы найдёте чай из высокогорных районов Китая, Индии, Цейлона, а также эксклюзивные сорта с ягодными и цветочными добавками.</p>
</div>

<div class="features">
    <div class="feature">
        <h3>🌿 Только свежий чай</h3>
        <p>Мы закупаем чай напрямую с плантаций, чтобы вы могли наслаждаться настоящим вкусом и ароматом.</p>
    </div>
    <div class="feature">
        <h3>🍵 Бесплатные дегустации</h3>
        <p>Каждую субботу в 16:00 проводим дегустации новых сортов. Приходите и выбирайте свой чай!</p>
    </div>
    <div class="feature">
        <h3>🎁 Подарочные наборы</h3>
        <p>Соберём индивидуальный подарок для ваших близких. Упаковка и открытка — бесплатно.</p>
    </div>
</div>

<div class="cta">
    <a href="/catalog.php" class="button">Перейти в каталог</a>
    <a href="/contacts.php" class="button button-outline">Связаться с нами</a>
</div>

<style>
.hero {
    background: #fff;
    border-radius: 24px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    text-align: center;
}
.hero h2 {
    margin-top: 0;
}
.features {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 30px;
}
.feature {
    flex: 1;
    background: #fff;
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: transform 0.2s;
}
.feature:hover {
    transform: translateY(-4px);
}
.feature h3 {
    margin-bottom: 10px;
    color: #2c5e2e;
}
.cta {
    text-align: center;
    margin-top: 20px;
}
.button {
    display: inline-block;
    background: #2c5e2e;
    color: #fff;
    padding: 12px 24px;
    border-radius: 40px;
    text-decoration: none;
    margin: 0 10px;
    font-weight: bold;
    transition: background 0.3s;
}
.button:hover {
    background: #1e401f;
}
.button-outline {
    background: transparent;
    border: 2px solid #2c5e2e;
    color: #2c5e2e;
}
.button-outline:hover {
    background: #2c5e2e;
    color: #fff;
}
@media (max-width: 768px) {
    .feature {
        flex: 1 1 100%;
    }
    .button {
        display: block;
        margin: 10px auto;
        width: 80%;
    }
}
</style>

<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>