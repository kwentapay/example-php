<?php
require_once("../../api-client-php/build/vendor/autoload.php");

$apiConfig = new OpenAPI\Client\Configuration();

$apiConfig->setHost(getenv("KWENTA_API_URL") ?: "http://localhost:3000");

$apiConfig->setAccessToken(getenv("KWENTA_API_KEY"));

$publicUrl = getenv("PUBLIC_URL") ?: "http://localhost:5100";

$apiInstance = new OpenAPI\Client\Api\OrderApi(
  // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
  // This is optional, `GuzzleHttp\Client` will be used as default.
  new GuzzleHttp\Client(),
  $apiConfig
);

$orderType =  isset($_POST["many_payers"]) ? "many_payers" : "single_payer";

try {
  $body = new OpenAPI\Client\Model\CreateOrderBody([
    "type" => $orderType,
    "amount" => 600_00,
    "currency" => OpenAPI\Client\Model\Currency::EUR,
    "redirectUrl" => $publicUrl,
  ]);

  $response = $apiInstance->createOrder($body);

  header('Location: ' . $response->getUrl());
  die();
} catch (Exception $error) {
  error_log("Exception when calling OrderApi->createOrder: " . $error->getMessage());
}
