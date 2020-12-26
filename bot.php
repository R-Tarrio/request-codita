<?php
	include 'vendor/autoload.php';
	use Jajo\JSONDB;
	$json_db = new JSONDB( __DIR__ );
	

	// $users = $json_db->select('name')
	// 	->from( 'users.json' )
	// 	->where( [ 'id' => 'Thomas' ] )
	// 	->get();
	// var_dump( $users );
	// return [];

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

	$users = $json_db->select('*')
	->from( 'users.json' )
	->where( [ 'id' => $body->message->from->id ] )
	->get();

	if(count($users) > 0){
		$xml = file_get_contents("https://api.telegram.org/bot1328580552:AAEbPoW6GcDej7e6Q4RXo0s1x5Qee0piNrs/sendMessage?chat_id=".$body->message->chat->id."&parse_mode=html&text=".$users[0]["first_name"]);		
	}else{
		$json_db->insert( 'users.json', 
			[
				"id" => $body->message->from->id,
				"first_name" => $body->message->from->first_name,
				"last_name" => $body->message->from->last_name,
				"username" => $body->message->from->username,
				"language_code" => $body->message->from->language_code
			]
		);
	}


	$mensaje = "<a href='https://request-codita.herokuapp.com/ImagenText/imagen_compartir.php?text=".$body->message->text."' >Ver imagen</a> <b>:)</b>";

	$xml = file_get_contents("https://api.telegram.org/bot1328580552:AAEbPoW6GcDej7e6Q4RXo0s1x5Qee0piNrs/sendMessage?chat_id=".$body->message->chat->id."&parse_mode=html&text=".$mensaje);