<?php

include 'Enums/ActionEnum.php';

class OffersAPI implements APIInterface {

    /** SQL queries to fetch, insert, update, and delete data from database */
    private const INSERT_OFFER_SQL = "INSERT INTO `products` (`productID`, `type`, `discount`) VALUES ('%s', '%s', '%s')";
    private const UPDATE_OFFER_SQL = "UPDATE `products` SET `%s` WHERE `productID` = '%s'";
    private const REMOVE_OFFER_SQL = "DELETE FROM `products` WHERE `productID` = '%s'";
    private const GET_ALL_OFFERS_SQL = "SELECT * FROM `products`";

    /** Success messages to be sent back */
    private const INSERT_SUCCESS = "Offer inserted correctly";
    private const REMOVE_SUCCESS = "Offer removed correctly";
    private const UPDATE_SUCCESS = "Offer updated correctly";

    /** Database connection */
    private mysqli $database;

    public function execute(string $action, object $data): array
    {
        switch ($action) {
            case ActionEnum::INSERT:
                return self::insertOffer($data);
            case ActionEnum::REMOVE:
                return self::removeOffer($data);
            case ActionEnum::UPDATE:
                return self::updateOffer($data);
            case ActionEnum::GET:
                return self::getAllOffers();
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

    private function insertOffer(object $data): array
    {
        try {
            $query = sprintf(self::INSERT_OFFER_SQL, $data->productID, $data->type, $data->discount);

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

    private function removeOffer(object $data): array
    {
        try {
            $query = sprintf(self::REMOVE_OFFER_SQL, $data->offerID);

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

    private function updateOffer(object $data): array
    {
        try {
            $query = sprintf(self::UPDATE_OFFER_SQL, $data->updatedField, $data->offerID);

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

    private function getAllOffers(): array
    {
        try {
            $result = $this->database->query(self::GET_ALL_OFFERS_SQL);
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