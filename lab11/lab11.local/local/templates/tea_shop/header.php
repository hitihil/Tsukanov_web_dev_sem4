<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?$APPLICATION->ShowTitle()?> | Чайная лавка</title>
    <?$APPLICATION->ShowHead()?>
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/styles.css">
</head>
<body>
    <?$APPLICATION->ShowPanel();?>
    <header class="header">
        <div class="logo">
            <a href="/">Чайная лавка</a>
        </div>
        <div class="auth-form">
            <?$APPLICATION->IncludeComponent(
                "bitrix:system.auth.form",
                "",
                array(
                    "REGISTER_URL" => "/auth/",
                    "PROFILE_URL" => "/personal/",
                    "SHOW_ERRORS" => "Y"
                )
            );?>
        </div>
        <nav class="main-menu">
            <?$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "",
                array(
                    "ROOT_MENU_TYPE" => "top",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_TIME" => "3600",
                    "MAX_LEVEL" => "1"
                )
            );?>
        </nav>
    </header>
    <main class="content">
        <?$APPLICATION->IncludeComponent(
            "bitrix:breadcrumb",
            "",
            array(
                "START_FROM" => "0",
                "PATH" => "",
                "SITE_ID" => SITE_ID
            )
        );?>
        <h1><?$APPLICATION->ShowTitle(false);?></h1>