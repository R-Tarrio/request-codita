<?php
	include 'vendor/autoload.php';
	use Jajo\JSONDB;
	$json_db = new JSONDB( __DIR__ );

	header('Content-Type: application/json');
	try {
		// $data = file_get_contents("php://input");
	    $bruto = file_get_contents('php://input');
	} catch (Exception $e) {
	    $bruto = false;
	}

	if($bruto){
		$data = $bruto;
	}else{
		$data = $_REQUEST;
	}

	$body = json_decode($data);
	// mail("xxx@xx.com","Información recibida", $_REQUEST);

	$mensaje = "<a href='https://request-codita.herokuapp.com/ImagenText/imagen_compartir.php?text=".$body->message->text."' >Ver imagen</a> <b>:)</b>";
	$xml = file_get_contents("https://api.telegram.org/bot1328580552:AAEbPoW6GcDej7e6Q4RXo0s1x5Qee0piNrs/sendMessage?chat_id=".$body->message->chat->id."&parse_mode=html&text=".$mensaje);

	// curl_setopt($handler, CURLOPT_URL, "'https://mail.google.com/mail/feed/atom?parametro1=p¶metro2=a¶metro3=r"); 

	// var_dump($body->push->changes[0]->commits);

	// echo json_encode(json_decode($data));
	// echo json_encode($_REQUEST);
	// $msg = json_encode($data);
