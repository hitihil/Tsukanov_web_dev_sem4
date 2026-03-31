<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новости");
?>

<?php
$APPLICATION->IncludeComponent(
    "bitrix:news",
    "",
    array(
        "PREVIEW_PICTURE" => "N",
        "DETAIL_PICTURE" => "N",
        "IBLOCK_ID" => 1,               // ID инфоблока "Новости" (у вас 1)
        "NEWS_COUNT" => "10",
        "SEF_MODE" => "Y",
        "SEF_FOLDER" => "/news/",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
        "SET_TITLE" => "Y"
    )
);
?>

<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>