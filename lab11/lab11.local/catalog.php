<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Каталог чая");

// Проверяем, загружен ли модуль инфоблоков
if (!CModule::IncludeModule("iblock")) {
    echo "Модуль инфоблоков не установлен";
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
    return;
}

$arSelect = array("ID", "NAME", "DETAIL_TEXT", "PROPERTY_PRICE");
$arFilter = array("IBLOCK_ID" => 2, "ACTIVE" => "Y");
$res = CIBlockElement::GetList(array("SORT" => "ASC"), $arFilter, false, false, $arSelect);
?>

<div class="custom-catalog">
    <?php while ($ob = $res->GetNextElement()):
        $arFields = $ob->GetFields();
        $price = $arFields["PROPERTY_PRICE_VALUE"];
        ?>
        <div class="catalog-item">
            <h3><?= htmlspecialchars($arFields["NAME"]) ?></h3>
            <?php if ($price): ?>
                <div class="price"><?= $price ?> руб. / 100 г</div>
            <?php endif; ?>
            <?php if ($arFields["DETAIL_TEXT"]): ?>
                <div class="description"><?= $arFields["DETAIL_TEXT"] ?></div>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</div>

<style>
.custom-catalog {
    max-width: 800px;
    margin: 0 auto;
}
.catalog-item {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: transform 0.2s;
}
.catalog-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.catalog-item h3 {
    margin-bottom: 8px;
    color: #2c5e2e;
}
.catalog-item .price {
    font-weight: bold;
    color: #e6b422;
    font-size: 1.2em;
    margin: 10px 0;
}
.catalog-item .description {
    color: #555;
    font-size: 0.95em;
    line-height: 1.4;
}
</style>

<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>