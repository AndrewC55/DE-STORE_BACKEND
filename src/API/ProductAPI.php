<?php

include 'Enums/ActionEnum.php';

class ProductAPI implements APIInterface {

    /** SQL queries to fetch, insert, update, and delete data from database */
    private const INSERT_PRODUCT_SQL = "INSERT INTO `products` (`productName`, `price`, `stock`, `delivery`) VALUES ('%s', '%s', %d, '%s')";
    private const REMOVE_PRODUCT_SQL = "DELETE FROM `products` WHERE `productID` = '%s'";
    private const UPDATE_PRODUCT_SQL = "UPDATE `products` SET '`%s`' WHERE `productID` = '%s'";
    private const GET_ALL_PRODUCTS_SQL = "SELECT * FROM `products`";

    /** Success messages to be sent back */
    private const INSERT_SUCCESS = "Product inserted correctly";
    private const REMOVE_SUCCESS = "Product removed correctly";
    private const UPDATE_SUCCESS = "Product updated correctly";

    /** Database connection */
    private mysqli $database;

    public function execute(string $action, object $data): array
    {
        switch ($action) {
            case ActionEnum::INSERT:
                return self::insertProduct($data);
            case ActionEnum::REMOVE:
                return self::removeProduct($data);
            case ActionEnum::UPDATE:
                return self::updateProduct($data);
            case ActionEnum::GET:
                return self::getAllProducts();
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

    private function insertProduct(object $data): array
    {
        try {
            $query = sprintf(self::INSERT_PRODUCT_SQL, $data->productName, $data->price, $data->stock, $data->delivery);
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

    private function removeProduct(object $data): array
    {
        try {
            $query = sprintf(self::REMOVE_PRODUCT_SQL, $data->productID);

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

    private function updateProduct(Object $data): array
    {
        try {
            $query = sprintf(self::UPDATE_PRODUCT_SQL, $data->updatedField, $data->productID);

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

    private function getAllProducts(): array
    {
        try {
            $products = [];
            $result = $this->database->query(self::GET_ALL_PRODUCTS_SQL);

            while ($row = mysqli_fetch_assoc($result)) {
                $products[] = $row;
            }

            $success = true;
            $data = $products;

            /*foreach ($products as $array) {
                if (is_array($array)) {
                    echo "NEW PRODUCT \n";
                    foreach ($array as $key => $value) {
                        echo $key . " => " . $value . "\n";
                    }
                } else {
                    echo $array;
                }
            }*/
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