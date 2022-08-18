<?php

class ReportsAPI extends API {

    /** SQL queries to fetch, and insert from database */
    private const INSERT_SALE_SQL = "INSERT INTO `sales` (`productID`, `user`, `address`, `price`) VALUES (%d, '%s', '%s', '%s')";
    private const GET_ALL_SALES_SQL = "SELECT * FROM `sales`";

    /** Success message to be sent back */
    private const INSERT_SUCCESS = "Sale inserted correctly";

    /** @throws Exception */
    public function execute(string $action, object $data): array
    {
        // switch statement to call correct function based on action
        switch ($action) {
            case self::INSERT:
                return self::insertSale($data);
            case self::GET:
                return self::getAllSales();
            default:
                throw new Exception(self::ACTION_NOT_EXIST);
        }
    }

    private function insertSale(object $data): array
    {
        // switch statement to call correct function based on action
        $query = sprintf(self::INSERT_SALE_SQL, $data->user, $data->address, $data->productID, $data->price);
        $message = self::INSERT_SUCCESS;
        return parent::executeQuery($query, $message);
    }

    private function getAllSales(): array
    {
        // returns getData function in parent
        return parent::getData(self::GET_ALL_SALES_SQL);
    }
}