<?php

include 'Enums/ActionEnum.php';

class CustomersAPI implements APIInterface {

    /** SQL queries to fetch, insert, update, and delete data from database */
    private const INSERT_CUSTOMER_SQL = "INSERT INTO `customers` (`firstName`, `lastName`, `email`, `address`, `loyaltyCard`, `finance`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')";
    private const UPDATE_CUSTOMER_SQL = "UPDATE `customers` SET `%s` WHERE `customerID` = %d";
    private const REMOVE_CUSTOMER_SQL = "DELETE FROM `customers` WHERE `customerID` = %d";
    private const GET_ALL_CUSTOMER_SQL = "SELECT * FROM `customers`";

    /** Success messages to be sent back */
    private const INSERT_SUCCESS = "Customer inserted correctly";
    private const REMOVE_SUCCESS = "Customer removed correctly";
    private const UPDATE_SUCCESS = "Customer updated correctly";

    private mysqli $database;

    /** @throws Exception */
    public function execute(string $action, object $data): array
    {
        switch ($action) {
            case ActionEnum::INSERT:
                return self::insertCustomer($data);
            case ActionEnum::REMOVE:
                return self::removeCustomer($data);
            case ActionEnum::UPDATE:
                return self::updateCustomer($data);
            case ActionEnum::GET:
                return self::getAllCustomers();
            default:
                throw new Exception(ActionEnum::ACTION_NOT_EXIST);
        }
    }

    public function setDatabaseConnection(mysqli $database): void
    {
        $this->database = $database;
    }

    private function insertCustomer(object $data): array
    {
        try {
            $query = sprintf(self::INSERT_CUSTOMER_SQL, $data->productName, $data->price, $data->stock, $data->delivery);

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

    private function removeCustomer(object $data): array
    {
        try {
            $query = sprintf(self::REMOVE_CUSTOMER_SQL, $data->userID);

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

    private function updateCustomer(object $data): array
    {
        try {
            $query = sprintf(self::UPDATE_CUSTOMER_SQL, $data->updatedField, $data->userID);

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

    private function getAllCustomers(): array
    {
        try {
            $result = $this->database->query(self::GET_ALL_CUSTOMER_SQL);
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