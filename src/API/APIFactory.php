<?php

include 'Enums/APIEnum.php';

class APIFactory {

    /**
     * @param string $api
     * @return APIInterface
     * @throws Exception
     */
    public function getAPI(string $api): APIInterface
    {
        switch($api) {
            case APIEnum::PRICE_CONTROL:
                return new PriceControlAPI();
            case APIEnum::INVENTORY:
                return new UserAPI();
            case APIEnum::CUSTOMERS:
                return new SalesAPI();
            case APIEnum::REPORTS:
                return new OffersAPI();
            default:
                throw new Exception(APIEnum::API_NOT_FOUND);
        }
    }
}