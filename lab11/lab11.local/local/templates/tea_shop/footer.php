    </main>
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-sitemap">
                <h3>Карта сайта</h3>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.map",
                    "",
                    array(
                        "LEVEL" => "2",
                        "COL_NUM" => "1",
                        "SHOW_DESCRIPTION" => "N",
                        "SET_TITLE" => "N",
                        "CACHE_TIME" => "3600"
                    )
                );?>
            </div>
            <div class="footer-contacts">
                <h3>Контакты</h3>
                <p>📍 Адрес: г. Москва, ул. Чайная, д. 1</p>
                <p>📞 Телефон: +7 (495) 123-45-67</p>
                <p>✉️ Email: info@tea-shop.ru</p>
                <p>⏰ Режим работы: пн-пт 10:00–20:00, сб 11:00–18:00</p>
            </div>
        </div>
        <div class="copyright">
            © 2025 Чайная лавка. Все права защищены.
        </div>
    </footer>
</body>
</html>