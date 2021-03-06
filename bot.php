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

	if(preg_match('/^(P:(\d+|\d\.\d{1,4}))$/', $body->message->text)){
		$precioCambio = explode(":", $body->message->text)[1];
		$precioCambio = $precioCambio * 1;
		$mensaje = "";
				
		$mensaje .= "Diamantes ร 110๐ = ".round($precioCambio*1, 1)." Bs.\n";
		$mensaje .= "Diamantes ร 341๐ = ".round($precioCambio*3, 1)." Bs.\n";
		$mensaje .= "Diamantes ร 572๐ = ".round($precioCambio*5, 1)." Bs.\n";
		$mensaje .= "Diamantes ร 1,166๐ = ".round($precioCambio*10, 1)." Bs.\n";
		$mensaje .= "Diamantes ร 2,398๐ = ".round($precioCambio*20, 1)." Bs.\n";
		$mensaje .= "Diamantes ร 6,160๐ = ".round($precioCambio*50, 1)."\n\n";
		$mensaje .= "Tarjetas\n";
		$mensaje .= "Tarjeta Semanal ๐ณ= ".round($precioCambio*2, 1)." Bs.\n";
		$mensaje .= "Es en total!ยก450 diamantes en total, mรกs la membresรญa de la tienda de descuentos y otros privilegios! (100 diamantes al instante, 50 diamantes diarios por 7 dรญas)\n\n";
		$mensaje .= "Tarjeta Mensual ๐ณ= ".round($precioCambio*10, 1)." Bs.\n";
		$mensaje .= "ยก2600 diamantes en total, mรกs la membresรญa de la tienda de descuentos y otros privilegios! (500 diamantes al instante, 70 diamantes diarios por 30 dรญas)\n\n";
		$mensaje .= "------------------------------------------------------\n";
		$mensaje .= "MรTODOS DE PAGOS\n";
		$mensaje .= "Pago mรณvil\n";
		$mensaje .= "04268925431\n";
		$mensaje .= "26.139.565\n";
		$mensaje .= "Provincial\n";


		$xml = file_get_contents("https://api.telegram.org/bot1328580552:AAEbPoW6GcDej7e6Q4RXo0s1x5Qee0piNrs/sendMessage?chat_id=".$body->message->chat->id."&parse_mode=html&text=".urlencode($mensaje));
		return true;
	}

	$mensaje = "<a href='https://request-codita.herokuapp.com/ImagenText/imagen_compartir.php?text=".$body->message->text."' >Ver imagen</a> <b>:)</b>";

	$xml = file_get_contents("https://api.telegram.org/bot1328580552:AAEbPoW6GcDej7e6Q4RXo0s1x5Qee0piNrs/sendMessage?chat_id=".$body->message->chat->id."&parse_mode=html&text=".$mensaje);
