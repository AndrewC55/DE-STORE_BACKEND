<?php

include 'API/APIInterface.php';
include 'API/APIFactory.php';

try {
    $connection = new mysqli('mysql_db', 'root', 'root', 'DE_STORE');
} catch (Exception $e) {
    getFalseResponse($e);
}

// FHfQJI28l^IHTrUXM3crV?Mw

try {
    $contents = file_get_contents("php://input");
    $request = json_decode($contents);
    $api = $request->api;
    $action = $request->action;
    $data = $request->data;
} catch (Exception $e) {
    getFalseResponse($e);
}

try {
    $apiFactory = new APIFactory();
    $api = $apiFactory->getAPI($api);
    $api->setDatabaseConnection($connection);;

    return json_encode($api->execute($action, $data));
} catch (Exception $e) {
    getFalseResponse($e);
}

function getFalseResponse(Exception $e): array
{
    return [
        'success' => false,
        'data' => $e->getMessage()
    ];
}