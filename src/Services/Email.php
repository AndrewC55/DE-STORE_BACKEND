<?php

class Email {
    private const RECIPIENT = "Management@DE-STORE.com";
    private const MAILER = "WareHouse@DE-STORE.com";
    private const SUBJECT = "Stock low";
    private const MESSAGE = "Warning item '%s' is low on stock, currently there are %d left";

    public function sendEmail(string $product, int $stock) {
        $message = sprintf(self::MESSAGE, $product, $stock);
        mail(self::RECIPIENT, self::MAILER, $message, self::SUBJECT);
    }
}