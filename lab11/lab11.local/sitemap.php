<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Карта сайта");
?>

<div class="sitemap-container">
    <?$APPLICATION->IncludeComponent(
        "bitrix:main.map",
        "",
        array(
            "LEVEL" => "2",
            "COL_NUM" => "2",
            "SHOW_DESCRIPTION" => "N",
            "SET_TITLE" => "N",
            "CACHE_TIME" => "3600"
        )
    );?>
</div>

<style>
.sitemap-container {
    background: #fff;
    border-radius: 20px;
    padding: 25px 30px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}
.sitemap-container ul {
    list-style: none;
    padding-left: 0;
    display: flex;
    flex-wrap: wrap;
    gap: 25px;
}
.sitemap-container ul > li {
    flex: 1 1 calc(33.333% - 25px);
    min-width: 200px;
    background: #faf7f2;
    border-radius: 12px;
    padding: 15px;
    transition: transform 0.2s;
}
.sitemap-container ul > li:hover {
    transform: translateY(-2px);
    background: #f5efe6;
}
.sitemap-container a {
    color: #2c5e2e;
    text-decoration: none;
    font-weight: 500;
    display: block;
    padding: 5px 0;
}
.sitemap-container a:hover {
    text-decoration: underline;
}
.sitemap-container ul ul {
    margin-top: 8px;
    display: block;
}
.sitemap-container ul ul li {
    padding: 3px 0 3px 15px;
    background: none;
    flex: none;
}
@media (max-width: 768px) {
    .sitemap-container ul > li {
        flex: 1 1 100%;
    }
}
</style>

<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>