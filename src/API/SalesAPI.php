<?php

include 'Enums/ActionEnum.php';

class SalesAPI implements APIInterface {

    /** SQL queries to fetch, and insert from database */
    private const INSERT_SALE_SQL = "INSERT INTO `sales` (`user`, `address`, `productID`, `price`) VALUES ('%s', '%s', %d, '%s')";
    private const SELECT_SALE_SQL = "SELECT * FROM `sales`";

    /** Success message to be sent back */
    private const INSERT_SUCCESS = "Sale inserted correctly";

    /** Database connection */
    private mysqli $database;

    public function execute(string $action, object $data): array
    {
        switch ($action) {
            case ActionEnum::INSERT:
                return self::insertSale($data);
            case ActionEnum::GET:
                return self::getAllSales();
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

    private function insertSale(object $data): array
    {
        try {
            $query = sprintf(self::INSERT_SALE_SQL, $data->user, $data->address, $data->productID, $data->price);

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

    private function getAllSales(): array
    {
        try {
            $result = $this->database->query(self::SELECT_SALE_SQL);
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