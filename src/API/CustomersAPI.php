<?php

class CustomersAPI extends API {

    /** SQL queries to fetch, insert, update, and delete data from database */
    private const INSERT_CUSTOMER_SQL = "INSERT INTO `customers` (`firstName`, `lastName`, `email`, `address`, `loyaltyCard`, `finance`) VALUES ('%s', '%s', '%s', '%s', %d, '%s')";
    private const UPDATE_CUSTOMER_SQL = "UPDATE `customers` SET `%s` WHERE `customerID` = %d";
    private const REMOVE_CUSTOMER_SQL = "DELETE FROM `customers` WHERE `customerID` = %d";
    private const GET_ALL_CUSTOMER_SQL = "SELECT * FROM `customers`";

    /** Success messages to be sent back */
    private const INSERT_SUCCESS = "Customer inserted correctly";
    private const REMOVE_SUCCESS = "Customer removed correctly";
    private const UPDATE_SUCCESS = "Customer updated correctly";

    /** @throws Exception */
    public function execute(string $action, object $data): array
    {
        switch ($action) {
            case 'insert':
                return self::insertCustomer($data);
            case 'remove':
                return self::removeCustomer($data);
            case 'update':
                return self::updateCustomer($data);
            case 'get':
                return self::getAllCustomers();
            default:
                throw new Exception(ActionEnum::ACTION_NOT_EXIST);
        }
    }

    private function insertCustomer(object $data): array
    {
        $query = sprintf(self::INSERT_CUSTOMER_SQL, $data->productName, $data->price, $data->stock, $data->delivery);
        $message = self::INSERT_SUCCESS;
        return parent::executeQuery($query, $message);
    }

    private function removeCustomer(object $data): array
    {
        $query = sprintf(self::REMOVE_CUSTOMER_SQL, $data->userID);
        $message = self::REMOVE_SUCCESS;
        return parent::executeQuery($query, $message);
    }

    private function updateCustomer(object $data): array
    {
        $query = sprintf(self::UPDATE_CUSTOMER_SQL, $data->updatedField, $data->userID);
        $message = self::UPDATE_SUCCESS;
        return parent::executeQuery($query, $message);
    }

    private function getAllCustomers(): array
    {
        return parent::getData(self::GET_ALL_CUSTOMER_SQL);
    }
}