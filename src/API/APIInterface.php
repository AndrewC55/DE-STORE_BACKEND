<?php

interface APIInterface {
    public function execute(string $action, Object $data): array;

    public function setDatabaseConnection(mysqli $database): void;
}