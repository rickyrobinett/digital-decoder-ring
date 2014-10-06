<?php
  require 'vendor/autoload.php';

  $body = @file_get_contents('php://input');
  $filepreviews_secret_key = "SECRET_KEY";
  $decoded = JWT::decode($body, $filepreviews_secret_key);
  $text = $decoded->results->metadata->ocr[0]->text;

  $cipher = new CaesarCipher\CaesarCipher();
  $decoded_text = $cipher->crack($text);

  $sid = "ACXXXXXXXXXXXXXXXX"; // Your Account SID from www.twilio.com/user/account
  $token = "YYYYYYYYYYYYYYYY"; // Your Auth Token from www.twilio.com/user/account
  $client = new Services_Twilio($sid, $token);
  $message = $client->account->messages->sendMessage(
    '555-555-5555', // From your Twilio Number
    $decoded->data->From, // Text this number
    $decoded_text
  );

