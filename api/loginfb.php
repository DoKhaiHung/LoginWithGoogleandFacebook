<?php
//initialize facebook sdk
require '../vendor/autoload.php';
require '../var.php';

session_start();
$fb = new Facebook\Facebook([
 'app_id' => $idAppFB,
 'app_secret' => $idSecretFB,
 'default_graph_version' => 'v13.0',
]);
$helper = $fb->getRedirectLoginHelper();
$accessToken = $_POST['token'];
if (isset($accessToken)) {
  // OAuth 2.0 client handler
$oAuth2Client = $fb->getOAuth2Client();
// Exchanges a short-lived access token for a long-lived one
$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
$accessToken = (string) $longLivedAccessToken;
$fb->setDefaultAccessToken($accessToken);
}

// getting basic info about user
try {
    $profile_request = $fb->get('/me?fields=name,first_name,last_name,email');
    $requestPicture = $fb->get('/me/picture?redirect=false&height=200'); //getting user picture
    $picture = $requestPicture->getGraphUser();
    $profile = $profile_request->getGraphUser();
    //$fbid = $profile->getProperty('id');           // To Get Facebook ID
    $fbfullname = $profile->getProperty('name');   // To Get Facebook full name
    $fbemail = $profile->getProperty('email');    //  To Get Facebook email
    $fbpic = $picture['url'];
    require './insertSql.php';
    insertData($fbfullname,$fbpic,$fbemail,'facebook');
    $res=['name'=>$fbfullname,
            'email'=>$fbemail,
            'photo'=>$fbpic
    ];
    echo json_encode($res);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    session_destroy();
    exit;
}
?>