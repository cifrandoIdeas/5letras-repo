<?php

header("Access-Control-Allow-Orgin: *");
header("Access-Control-Allow-Methods: *");
header("Content-Type: application/json");

require_once '../lib/mercadopago.php';

if (isset($_GET['titulo']) &&
        isset($_GET['cupon']) &&
        isset($_GET['precio']) &&
        isset($_GET['motel']) &&
        isset($_GET['success']) &&
        isset($_GET['failure']) &&
        isset($_GET['pending'])) {

    $titulo = filter_input(INPUT_GET, 'titulo');
    $cupon = filter_input(INPUT_GET, 'cupon');
    $precio = filter_input(INPUT_GET, 'precio', FILTER_VALIDATE_INT);
    $motel = filter_input(INPUT_GET, 'motel');
    $success = filter_input(INPUT_GET, 'success');
    $failure = filter_input(INPUT_GET, 'failure');
    $pending = filter_input(INPUT_GET, 'pending');

    $mp = new MP('881760152202564', 'VGByJC3a15GE4OytQsLme8821BMtQJzy');

    $preference_data = array(
        "items" => array(
            array(
                "id" => $cupon,
                "title" => $titulo,
                "quantity" => 1,
                "currency_id" => "MXN", // Available currencies at: https://api.mercadopago.com/currencies
                "unit_price" => $precio
            )
        ),
        "back_urls" => array(
            "success" => $success,
            "failure" => $failure,
            "pending" => $pending
        )
    );

    $preference = $mp->create_preference($preference_data);

    if (is_array($preference)) {
        header("HTTP/1.1 200 OK");
        echo json_encode($preference);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
} else {
    header("HTTP/1.1 500 Internal Server Error");
}
?>