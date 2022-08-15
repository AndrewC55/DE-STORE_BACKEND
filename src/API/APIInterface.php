<?php

interface APIInterface {
    public function execute(string $action, object $data): array;

    public function setDatabaseConnection(mysqli $database): void;
}