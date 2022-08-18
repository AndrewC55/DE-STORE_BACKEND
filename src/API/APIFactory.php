<?php

include_once 'Enums/APIEnum.php';
include_once 'PriceControlAPI.php';
include_once 'InventoryAPI.php';
include_once 'CustomersAPI.php';
include_once 'ReportsAPI.php';

class APIFactory {

    /**
     * @param string $api
     * @return API
     * @throws Exception
     */
    public function getAPI(string $api): API
    {
        // switch statement to return correct API based on API type
        switch($api) {
            case APIEnum::PRICE_CONTROL:
                return new PriceControlAPI();
            case APIEnum::INVENTORY:
                return new InventoryAPI();
            case APIEnum::CUSTOMERS:
                return new CustomersAPI();
            case APIEnum::REPORTS:
                return new ReportsAPI();
            default:
                throw new Exception(APIEnum::API_NOT_FOUND);
        }
    }
}