<?php

// https://docs.kwentapay.io/integration/getting-started/

// Load the Kwenta PHP client
require_once(__DIR__ . '/vendor/autoload.php');

$kwentaConfig = new OpenAPI\Client\Configuration();

// TESTING: https://api.kwenta.st
// PRODUCTION: https://api.kwentapay.io
$kwentaConfig->setHost(getenv("KWENTA_API_URL") ?: "http://localhost:3000");

// https://docs.kwentapay.io/integration/auth
$kwentaConfig->setAccessToken(getenv("KWENTA_API_KEY"));

// This is the public URL of your frontend application.
// It is used below to redirect the user after the payment is completed.
$publicUrl = getenv("PUBLIC_URL") ?: "http://localhost:5100";

$kwenta = new OpenAPI\Client\Api\OrderApi(
  // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
  // This is optional, `GuzzleHttp\Client` will be used as default.
  new GuzzleHttp\Client(),
  $kwentaConfig
);

$orderType =  isset($_POST["many_payers"]) ? "many_payers" : "single_payer";

try {
  $body = new OpenAPI\Client\Model\CreateOrderBody([
    // Order type can be either :
    //  - "many_payers" for group payments
    //  - "single_payer" for multicard payments
    "type" => $orderType,

    // The amount of the order is expressed in the smallest unit of the
    // currency.
    // For example, 600 EUR is expressed as 60000 cents.
    "amount" => 600_00,

    // The currency of the order.
    // ISO 4217 currency codes are used.
    "currency" => OpenAPI\Client\Model\Currency::EUR,

    // The URL to which the payer will be redirected after the payment is
    // completed.
    "redirectUrl" => $publicUrl,

    // An optional custom identifier for the order which you can use to
    // identify it.
    "sellerOrderId" => "1234567890",
  ]);

  // Call the Kwenta API to create the order
  $response = $kwenta->createOrder($body);

  // Redirect the user to the Kwenta payment page
  header('Location: ' . $response->getUrl());

  die();
} catch (Exception $error) {
  error_log("Exception when calling OrderApi->createOrder: " . $error->getMessage());
}
