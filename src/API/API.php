<?php

abstract class API {

    protected const INSERT = 'insert';
    protected const REMOVE = 'remove';
    protected const UPDATE = 'update';
    protected const GET = 'get';
    protected const ACTION_NOT_EXIST = "Action not found";

    /** Database connection */
    private mysqli $database;

    /** @throws Exception */
    abstract function execute(string $action, object $data): array;

    public function setDatabaseConnection(mysqli $database): void
    {
        $this->database = $database;
    }

    protected function executeQuery(string $query, string $message): array
    {
        try {
            if ($this->database->query($query)) {
                $success = true;
                $data = $message;
            } else {
                $success = false;
                $data = mysqli_error($this->database);
            }

        } catch (Exception $e) {
            $success = false;
            $data = $e->getMessage();
        }

        return [
            'success' => $success,
            'data' => $data
        ];
    }

    protected function getData(string $sql): array
    {
        try {
            $products = [];
            $result = $this->database->query($sql);

            while ($row = mysqli_fetch_assoc($result)) {
                $products[] = $row;
            }

            $success = true;
            $data = $products;
        } catch (Exception $e) {
            $success = false;
            $data = $e->getMessage();
        }

        return [
            'success' => $success,
            'data' => $data
        ];
    }
}