<?php

class PriceControlAPI extends API {

    /** SQL queries to fetch, insert, update, and delete data from database */
    private const INSERT_PRODUCT_SQL = "INSERT INTO `products` (`productName`, `price`, `delivery`, `discount`, `threeForTwo`) VALUES ('%s', %d, %d, %d, '%s')";
    private const REMOVE_PRODUCT_SQL = "DELETE FROM `products` WHERE `productID` = %d";
    private const UPDATE_PRODUCT_SQL = "UPDATE `products` SET `%s` = `%s` WHERE `productID` = %d";
    private const GET_ALL_PRODUCTS_SQL = "SELECT * FROM `products`";

    /** Success messages to be sent back */
    private const INSERT_SUCCESS = "Product inserted correctly";
    private const REMOVE_SUCCESS = "Product removed correctly";
    private const UPDATE_SUCCESS = "Product updated correctly";

    /** @throws Exception */
    public function execute(string $action, object $data): array
    {
        switch ($action) {
            case 'insert':
                return self::insertProduct($data);
            case 'remove':
                return self::removeProduct($data);
            case 'update':
                return self::updateProduct($data);
            case 'get':
                return self::getAllProducts();
            default:
                throw new Exception(ActionEnum::ACTION_NOT_EXIST);
        }
    }

    private function insertProduct(object $data): array
    {
        $query = sprintf(self::INSERT_PRODUCT_SQL, $data->productName, $data->price, $data->stock, $data->delivery);
        $message = self::INSERT_SUCCESS;
        return parent::executeQuery($query, $message);
    }

    private function removeProduct(object $data): array
    {
        $query = sprintf(self::REMOVE_PRODUCT_SQL, $data->productID);
        $message = self::REMOVE_SUCCESS;
        return parent::executeQuery($query, $message);
    }

    private function updateProduct(Object $data): array
    {
        $query = sprintf(self::UPDATE_PRODUCT_SQL, $data->updatedField, $data->productID);
        $message = self::UPDATE_SUCCESS;
        return parent::executeQuery($query, $message);
    }

    private function getAllProducts(): array
    {
        return parent::getData(self::GET_ALL_PRODUCTS_SQL);
    }
}