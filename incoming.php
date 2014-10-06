<?php
  require 'vendor/autoload.php';

  $filepreview_url = "https://api.filepreviews.io/v1/";
  $media = $_POST['MediaUrl0'];
  $from = $_POST['From'];

  $data = array(
            "url"=>$media,
            "metadata"=>Array("ocr"),
            "api_key"=>"[API_KEY]",
            "data"=>Array("From"=>$from)
          );

  $ch = curl_init($filepreview_url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

  $response = json_decode(curl_exec($ch));

  header('Content-type: text/xml');
  $TwiML = new Services_Twilio_Twiml();
  if($response->error){
    $TwiML->message('Something went wrong. Get outta there!');
  } else {
    $TwiML->message('Thanks! Our supercomputers are working hard to crack the code now.');
  }
  print $TwiML;

