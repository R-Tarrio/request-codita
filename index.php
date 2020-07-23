<?php

	// $data = [
	// 	"success" => true,
	// 	"data" => $_REQUEST
	// ];

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

	$mensaje = "Se ha realizado push:\n";
	$mensaje .= "----------------------Informacion------------------\n";
	foreach ($body->push->changes[0]->commits as $key) {
		// var_dump($key);
		if($key->author->type == "author"){
			$mensaje .= "Autor: ".$key->author->raw."\n";
			$mensaje .= "Commit: ".$key->hash."\n";
			$mensaje .= "Mensaje: ".$key->message."\n";
			$mensaje .= "Link: ".$key->links->html->href."\n";
			$mensaje .= "Fecha: ".$key->date."\n";
		}
	}

	// echo "https://api.telegram.org/bot1158898854:AAHSQ1Cp925v3TAwZu8CC4LzZ5SIiTm3vHA/sendMessage?chat_id=1034535475&text".urlencode($mensaje);
	$xml = file_get_contents("https://api.telegram.org/bot1158898854:AAHSQ1Cp925v3TAwZu8CC4LzZ5SIiTm3vHA/sendMessage?chat_id=1034535475&text=".urlencode($mensaje));

	// curl_setopt($handler, CURLOPT_URL, "'https://mail.google.com/mail/feed/atom?parametro1=p¶metro2=a¶metro3=r"); 

	// var_dump($body->push->changes[0]->commits);

	// echo json_encode(json_decode($data));
	// echo json_encode($_REQUEST);
	// $msg = json_encode($data);

	// mail("xxx@xx.com","Información recibida", $mensaje);