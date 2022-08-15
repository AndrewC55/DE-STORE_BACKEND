<?php

include 'Enums/ActionEnum.php';

class UserAPI implements APIInterface {

    /** SQL queries to fetch, insert, update, and delete data from database */
    private const INSERT_USER_SQL = "INSERT INTO `users` (`firstName`, `lastName`, `email`, `type`, `address`) VALUES ('%s', '%s', %d, '%s', '%s')";
    private const UPDATE_USER_SQL = "UPDATE `users` SET `%s` WHERE `userID` = '%s'";
    private const REMOVE_USER_SQL = "DELETE FROM `users` WHERE `userID` = '%s'";
    private const GET_ALL_USERS_SQL = "SELECT * FROM `users`";

    /** Success messages to be sent back */
    private const INSERT_SUCCESS = "User inserted correctly";
    private const REMOVE_SUCCESS = "User removed correctly";
    private const UPDATE_SUCCESS = "User updated correctly";

    private mysqli $database;

    public function execute(string $action, object $data): array
    {
        switch ($action) {
            case ActionEnum::INSERT:
                return self::insertUser($data);
            case ActionEnum::REMOVE:
                return self::removeUser($data);
            case ActionEnum::UPDATE:
                return self::updateUser($data);
            case ActionEnum::GET:
                return self::getAllUsers();
            default:
                return [
                    'success' => false,
                    'data' => ActionEnum::ACTION_NOT_EXIST
                ];
        }
    }

    public function setDatabaseConnection(mysqli $database): void
    {
        $this->database = $database;
    }

    private function insertUser(object $data): array
    {
        try {
            $query = sprintf(self::INSERT_USER_SQL, $data->productName, $data->price, $data->stock, $data->delivery);

            if ($this->database->query($query)) {
                $success = true;
                $data = self::INSERT_SUCCESS;
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

    private function removeUser(object $data): array
    {
        try {
            $query = sprintf(self::REMOVE_USER_SQL, $data->userID);

            if ($this->database->query($query)) {
                $success = true;
                $data = self::REMOVE_SUCCESS;
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

    private function updateUser(object $data): array
    {
        try {
            $query = sprintf(self::UPDATE_USER_SQL, $data->updatedField, $data->userID);

            if ($this->database->query($query)) {
                $success = true;
                $data = self::UPDATE_SUCCESS;
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

    private function getAllUsers(): array
    {
        try {
            $result = $this->database->query(self::GET_ALL_USERS_SQL);
            $success = true;
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
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