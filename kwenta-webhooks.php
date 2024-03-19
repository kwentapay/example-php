<?php

// https://docs.kwentapay.io/integration/webhooks/

// Get the request body
$requestBody = file_get_contents("php://input");

// Get the signature from the request headers
$signature = $_SERVER["HTTP_KWENTA_SIGNATURE"];

// Must be set to your secret key for HMAC verification
$secretKey = getenv("KWENTA_WEBHOOK_SECRET");

// Calculate the expected signature
$expectedSignature = hash_hmac("sha256", $requestBody, $secretKey);

// Verify the signature and return 401 (unauthorized) if it's invalid
if ($signature !== $expectedSignature) {
  http_response_code(401);
  exit;
}

// Process the webhook payload
$payload = json_decode($requestBody, false);

// Filter the event type to process only the ones you need
if ($payload->event === "order.paid") {
  // The order has been paid
  // You can update your database or trigger other actions here
  error_log("Order paid: " . $payload->orderId);
}

// Return a 200 status code
http_response_code(200);
