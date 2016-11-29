<?php
require_once './include/DBOperation.php';
require './libs/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->post('/post', function () use ($app)
{
	verifyRequiredParams(array('pulsaciones', 'fecha'));
	$response = array();
	$pulsaciones = $app->request->post('pulsaciones');
	$fecha = $app->request->post('fecha');
	$db = new DBOperation();

	$res = $db->createCorazon($pulsaciones, $fecha);
	if($res == 0)
	{
		$response["error"] = false;
		$response["message"] = "You are successfully registered";
		echoResponse(201, $response);
	}
	else if ($res == 1)
	{
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while registereing ";
        echoResponse(200, $response);
	}
});

$app->get('/get', function() use ($app){
    $db = new DBOperation();
    $result = $db->getCorazon();
    $response = array();
    $response['error'] = false;
    $response['assignments'] = array();
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['id']=$row['id'];
        $temp['pulsaciones'] = $row['pulsaciones'];
        $temp['fecha'] = $row['fecha'];
        array_push($response['assignments'],$temp);
    }
    echoResponse(200,$response);
});

$app->get('/get/:id', function($id) use ($app){
    $db = new DBOperation();
    $result = $db->getCorazon($id);
    $response = array();
    $response['error'] = false;
    $response['assignments'] = array();
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['id']=$row['id'];
        $temp['pulsaciones'] = $row['Pulsaciones'];
        $temp['fecha'] = $row['Fecha'];
        array_push($response['assignments'],$temp);
    }
    echoResponse(200,$response);
});

function authenticate(\Slim\Route $route)
{
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
 
    if (isset($headers['Authorization'])) {
        $db = new DBOperation();
        $api_key = $headers['Authorization'];
        if (!$db->isValidUser($api_key)) {
            $response["error"] = true;
            $response["message"] = "Access Denied. Invalid Api key";
            echoResponse(401, $response);
            $app->stop();
        }
    } else {
        $response["error"] = true;
        $response["message"] = "Api key is misssing";
        echoResponse(400, $response);
        $app->stop();
    }
}
if( !function_exists('apache_request_headers') ) {
function apache_request_headers() {
  $arh = array();
  $rx_http = '/\AHTTP_/';
  foreach($_SERVER as $key => $val) {
    if( preg_match($rx_http, $key) ) {
      $arh_key = preg_replace($rx_http, '', $key);
      $rx_matches = array();
      // do some nasty string manipulations to restore the original letter case
      // this should work in most cases
      $rx_matches = explode('_', $arh_key);
      if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
        foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
        $arh_key = implode('-', $rx_matches);
      }
      $arh[$arh_key] = $val;
    }
  }
  return( $arh );
}
}

function echoResponse($status_code, $response)
{
	$app = \Slim\Slim::getInstance();
	$app->status($status_code);
	$app->contentType('application/json');
	echo json_encode($response);
}

function verifyRequiredParams($required_fields)
{
	$error = false;
	$error_fields = "";
	$request_params = $_REQUEST;
	if($_SERVER['REQUEST_METHOD'] == 'PUT')
	{
		$app = \Slim\Slim::getInstance();
		parse_str($app->request()->getBody(), $request_params);
	}
	foreach ($required_fields as $field) 
	{
		if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
	}
	if ($error) {
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoResponse(400, $response);
        $app->stop();
    }
}

function authenticateStudent(\Slim\Route $route)
{
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
    if (isset($headers['Authorization'])) 
    {
        $db = new DBOperation();
        $api_key = $headers['Authorization'];
        if (!$db->isValidCorazon($api_key)) 
        {
            $response["error"] = true;
            $response["message"] = "Access Denied. Invalid Api key";
            echoResponse(401, $response);
            $app->stop();
        }
    } 
    else 
    {
        $response["error"] = true;
        $response["message"] = "Api key is misssing";
        echoResponse(400, $response);
        $app->stop();
    }
}
$app->run();

?>