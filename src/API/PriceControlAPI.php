<?php

class PriceControlAPI extends API {

    /** SQL queries to fetch, insert, update, and delete data from database */
    private const INSERT_PRODUCT_SQL = "INSERT INTO `products` (`productName`, `price`, `delivery`, `buyOneGetOneFree`, `threeForTwo`, `freeDelivery`) VALUES ('%s', %d, %d, %d, %d, %d)";
    private const REMOVE_PRODUCT_SQL = "DELETE FROM `products` WHERE `productID` = %d";
    private const UPDATE_PRODUCT_SQL = "UPDATE `products` SET `productName` = '%s', 
                      `price` = %d, 
                      `delivery` = %d, 
                      `buyOneGetOneFree` = %d, 
                      `threeForTwo` = %d,
                      `freeDelivery` = %d WHERE `productID` = %d";
    private const GET_ALL_PRODUCTS_SQL = "SELECT * FROM `products`";

    /** Success messages to be sent back */
    private const INSERT_SUCCESS = "Product inserted correctly";
    private const REMOVE_SUCCESS = "Product removed correctly";
    private const UPDATE_SUCCESS = "Product updated correctly";

    /** @throws Exception */
    public function execute(string $action, object $data): array
    {
        // switch statement to call correct function based on action
        switch ($action) {
            case self::INSERT:
                return self::insertProduct($data);
            case self::REMOVE:
                return self::removeProduct($data);
            case self::UPDATE:
                return self::updateProduct($data);
            case self::GET:
                return self::getAllProducts();
            default:
                throw new Exception(self::ACTION_NOT_EXIST);
        }
    }

    private function insertProduct(object $data): array
    {
        // creates insert query and returns executeQuery function
        $query = sprintf(self::INSERT_PRODUCT_SQL, $data->productName, $data->price, $data->delivery, $data->buyOneGetOneFree, $data->threeForTwo, $data->freeDelivery);
        $message = self::INSERT_SUCCESS;
        return parent::executeQuery($query, $message);
    }

    private function removeProduct(object $data): array
    {
        // creates remove query and returns executeQuery function
        $query = sprintf(self::REMOVE_PRODUCT_SQL, $data->productID);
        $message = self::REMOVE_SUCCESS;
        return parent::executeQuery($query, $message);
    }

    private function updateProduct(Object $data): array
    {
        // creates update query and returns executeQuery function
        $query = sprintf(self::UPDATE_PRODUCT_SQL, $data->productName, $data->price, $data->delivery, $data->buyOneGetOneFree, $data->threeForTwo, $data->productID, $data->freeDelivery);
        $message = self::UPDATE_SUCCESS;
        return parent::executeQuery($query, $message);
    }

    private function getAllProducts(): array
    {
        // returns getData function in parent
        return parent::getData(self::GET_ALL_PRODUCTS_SQL);
    }
}