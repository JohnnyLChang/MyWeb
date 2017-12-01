<?php
  define('__ROOT__', dirname(dirname(__FILE__)));
  require __ROOT__ .'/vendor/autoload.php';
  if(session_id() == '' || !isset($_SESSION)) {
    session_start();
}

  $fb = new Facebook\Facebook([
    'app_id' => '352202661917819', // Replace {app-id} with your app id
    'app_secret' => '43256e658beaa56fb457de176599e728',
    'default_graph_version' => 'v2.2',
    ]);
  
  $helper = $fb->getRedirectLoginHelper();
  if (isset($_GET['state'])) {
      $helper->getPersistentDataHandler()->set('state', $_GET['state']);
  }
  
  if(isset($_GET['action']) && $_GET['action'] == 'logout'){
    $_SESSION['fb_access_token'] = NULL;
    session_destroy();
  }
  
  if(isset($_SESSION['fb_access_token'])){
    try {
        $accessToken = $_SESSION['fb_access_token'];
        $response = $fb->get('/me?fields=id,name,email', $accessToken);
    } catch (Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
    $me = $response->getGraphUser();
    $name = $me['name'];
    $email = $me['email'];
    echo $name . '<BR>';
    echo $email . '<BR>';
    $logoutUrl = $helper->getLogoutUrl($accessToken, 'https://jlcdemo.herokuapp.com/login/login.php?action=logout');
    echo '<a href="' . htmlspecialchars($logoutUrl) . '">Logout Facebook!</a>';
  }
  else{
    $permissions = ['email']; // Optional permissions
    $loginUrl = $helper->getLoginUrl('https://jlcdemo.herokuapp.com/login/fb-callback.php', $permissions);
  
    echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
  }
?>