<?php

include "ProductAPI.php";

class APIFactory {

    /**
     * @param string $api
     * @return APIInterface
     * @throws Exception
     */
    public function getAPI(string $api): APIInterface
    {
        switch($api) {
            case 'products':
                return new ProductAPI();
            case 'users':
                return new UserAPI();
            case 'sales':
                return new SalesAPI();
            case 'offers':
                return new OffersAPI();
            default:
                throw new Exception("API unavailable at this time");
        }
    }
}