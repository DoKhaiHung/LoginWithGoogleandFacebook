<?php
if (empty($_POST['type']) ||empty($_POST['token']) ) {
  echo json_encode(0);
  exit;
}
require_once '../vendor/autoload.php';
require '../var.php';
$id_token=$_POST['token'];
$type=$_POST['type'];
switch($type){
  case 'google':
    $CLIENT_ID=$idAppGG;
    $SecretId=$idSecretGG;
    $client = new Google_Client();
    $client->setClientId($CLIENT_ID);  // Specify the CLIENT_ID of the app that accesses the backend
    $payload = $client->verifyIdToken($id_token);
    if ($payload) {
      $username=addslashes($payload['name']);
      $photo=addslashes($payload['picture']);
      $email=$payload['email'];
    } else {
      // Invalid ID token
      echo json_encode(0);
      exit;
    }
    break;
    case 'facebook':
}
      //type Google
      require './insertSql.php';
      insertData($username,$photo,$email,'google');
      echo json_encode(1);
?>