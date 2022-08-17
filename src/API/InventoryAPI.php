<?php

include_once 'Services/Email.php';

class InventoryAPI extends API {

    /** SQL queries to fetch, insert, update, and delete data from database */
    private const UPDATE_INVENTORY_SQL = "UPDATE `inventory` SET `stock` = %d WHERE `inventoryID` = %d";
    private const GET_ALL_INVENTORY_SQL = "SELECT `inventoryID`, `productName`, `stock` FROM `inventory` JOIN `products` ON (inventory.productID = products.productID)";

    /** Success messages to be sent back */
    private const UPDATE_SUCCESS = "Inventory updated correctly";

    /** @throws Exception */
    public function execute(string $action, object $data): array
    {
        switch ($action) {
            case self::UPDATE:
                return self::updateInventory($data);
            case self::GET:
                return self::getAllInventory();
            default:
                throw new Exception(self::ACTION_NOT_EXIST);
        }
    }

    private function updateInventory(object $data): array
    {
        if ($data->stock < 5) {
            self::getMailer()->sendEmail('TEST', $data->stock);
        }
        $query = sprintf(self::UPDATE_INVENTORY_SQL, $data->stock, $data->inventoryID);
        $message = self::UPDATE_SUCCESS;
        return parent::executeQuery($query, $message);
    }

    private function getAllInventory(): array
    {
        return parent::getData(self::GET_ALL_INVENTORY_SQL);
    }

    private function getMailer(): Email
    {
        return new Email();
    }
}