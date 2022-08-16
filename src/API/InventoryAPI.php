<?php

include 'Enums/ActionEnum.php';

class InventoryAPI implements APIInterface {

    /** SQL queries to fetch, insert, update, and delete data from database */
    private const INSERT_INVENTORY_SQL = "INSERT INTO `inventory` (`productID`, `productName`, `stock`) VALUES ('%s', '%s', %d)";
    private const UPDATE_INVENTORY_SQL = "UPDATE `inventory` SET `%s` = `%s` WHERE `productID` = %d";
    private const REMOVE_INVENTORY_SQL = "DELETE FROM `inventory` WHERE `productID` = %d";
    private const GET_ALL_INVENTORY_SQL = "SELECT * FROM `inventory`";

    /** Success messages to be sent back */
    private const INSERT_SUCCESS = "Inventory inserted correctly";
    private const REMOVE_SUCCESS = "Inventory removed correctly";
    private const UPDATE_SUCCESS = "Inventory updated correctly";

    /** Database connection */
    private mysqli $database;

    /** @throws Exception */
    public function execute(string $action, object $data): array
    {
        switch ($action) {
            case ActionEnum::INSERT:
                return self::insertInventory($data);
            case ActionEnum::REMOVE:
                return self::removeInventory($data);
            case ActionEnum::UPDATE:
                return self::updateInventory($data);
            case ActionEnum::GET:
                return self::getAllInventory();
            default:
                throw new Exception(ActionEnum::ACTION_NOT_EXIST);
        }
    }

    public function setDatabaseConnection(mysqli $database): void
    {
        $this->database = $database;
    }

    private function insertInventory(object $data): array
    {
        try {
            $query = sprintf(self::INSERT_INVENTORY_SQL, $data->productID, $data->type, $data->discount);

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

    private function removeInventory(object $data): array
    {
        try {
            $query = sprintf(self::REMOVE_INVENTORY_SQL, $data->offerID);

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

    private function updateInventory(object $data): array
    {
        try {
            $query = sprintf(self::UPDATE_INVENTORY_SQL, $data->updatedField, $data->offerID);

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

    private function getAllInventory(): array
    {
        try {
            $result = $this->database->query(self::GET_ALL_INVENTORY_SQL);
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