<?php

class InventoryAPI extends API {

    /** SQL queries to fetch, insert, update, and delete data from database */
    private const INSERT_INVENTORY_SQL = "INSERT INTO `inventory` (`productID`, `stock`) VALUES ('%s', %d)";
    private const UPDATE_INVENTORY_SQL = "UPDATE `inventory` SET `%s` = `%s` WHERE `productID` = %d";
    private const REMOVE_INVENTORY_SQL = "DELETE FROM `inventory` WHERE `productID` = %d";
    private const GET_ALL_INVENTORY_SQL = "SELECT `productName`, `stock` FROM `inventory` JOIN `products` ON (inventory.productID = products.productID)";

    /** Success messages to be sent back */
    private const INSERT_SUCCESS = "Inventory inserted correctly";
    private const REMOVE_SUCCESS = "Inventory removed correctly";
    private const UPDATE_SUCCESS = "Inventory updated correctly";

    /** @throws Exception */
    public function execute(string $action, object $data): array
    {
        switch ($action) {
            case self::INSERT:
                return self::insertInventory($data);
            case self::REMOVE:
                return self::removeInventory($data);
            case self::UPDATE:
                return self::updateInventory($data);
            case self::GET:
                return self::getAllInventory();
            default:
                throw new Exception(self::ACTION_NOT_EXIST);
        }
    }

    private function insertInventory(object $data): array
    {
        $query = sprintf(self::INSERT_INVENTORY_SQL, $data->productID, $data->type, $data->discount);
        $message = self::INSERT_SUCCESS;
        return parent::executeQuery($query, $message);
    }

    private function removeInventory(object $data): array
    {
        $query = sprintf(self::REMOVE_INVENTORY_SQL, $data->offerID);
        $message = self::REMOVE_SUCCESS;
        return parent::executeQuery($query, $message);
    }

    private function updateInventory(object $data): array
    {
        $query = sprintf(self::UPDATE_INVENTORY_SQL, $data->updatedField, $data->offerID);
        $message = self::UPDATE_SUCCESS;
        return parent::executeQuery($query, $message);
    }

    private function getAllInventory(): array
    {
        return parent::getData(self::GET_ALL_INVENTORY_SQL);
    }
}