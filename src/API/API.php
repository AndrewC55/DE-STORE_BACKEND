<?php

abstract class API {

    /** action constants used in switch statements */
    protected const INSERT = 'insert';
    protected const REMOVE = 'remove';
    protected const UPDATE = 'update';
    protected const GET = 'get';
    protected const ACTION_NOT_EXIST = "Action not found";

    /** Database connection */
    private mysqli $database;

    // abstract function used for database queries
    /** @throws Exception */
    abstract function execute(string $action, object $data): array;

    public function setDatabaseConnection(mysqli $database): void
    {
        // instantiate database connection for all child classes
        $this->database = $database;
    }

    // function to execute queries
    protected function executeQuery(string $query, string $message): array
    {
        try {
            // if query is executed then success is true and data is returned
            if ($this->database->query($query)) {
                $success = true;
                $data = $message;
            } else {
                // if query is not executed then success is false and error message is returned
                $success = false;
                $data = mysqli_error($this->database);
            }

        } catch (Exception $e) {
            // if an exception occurs is not executed then success is false and error message is returned
            $success = false;
            $data = $e->getMessage();
        }

        // return the data to index.php
        return [
            'success' => $success,
            'data' => $data
        ];
    }

    // function for retrieving data
    protected function getData(string $sql): array
    {
        try {
            // array to hold return values
            $fetchedData = [];
            // fetch data from database
            $result = $this->database->query($sql);

            // loop through data, retrieve the object and add it to return array
            while ($row = mysqli_fetch_assoc($result)) {
                $fetchedData[] = $row;
            }

            $success = true;
            $data = $fetchedData;
        } catch (Exception $e) {
            // if an exception occurs is not executed then success is false and error message is returned
            $success = false;
            $data = $e->getMessage();
        }

        // return the data to index.php
        return [
            'success' => $success,
            'data' => $data
        ];
    }
}