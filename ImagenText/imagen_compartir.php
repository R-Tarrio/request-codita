<?php

require_once('lib/textPainter/class.textPainter.php');
// $size = $_GET["size"];
$size = "20";
$text = $_GET["text"];

// $text = base64_decode($text);

// $img = new textPainter('img/fondo_compartir.png', $text_r, 'Roboto-Black.ttf', $size);
// $img->setPosition("center","165");
// $img->setQuality(10);
// if(isset($_GET['x']) && isset($_GET['y'])){
//     $img->setPosition($_GET['x'], $_GET['y']);
// }

// if(isset($_GET["r"]) && isset($_GET["g"]) && isset($_GET["b"])){
//     $img->setTextColor($_GET["r"], $_GET["g"], $_GET["b"]);
// }

// // header("Location:enpeso.com");
// // sleep(3);
// if($img->show()){
// }
require_once 'lib/gd-text-master/src/Box.php';
require_once 'lib/gd-text-master/src/Color.php';
require_once 'lib/gd-text-master/src/TextWrapping.php';
require_once 'lib/gd-text-master/src/VerticalAlignment.php';
require_once 'lib/gd-text-master/src/HorizontalAlignment.php';
require_once 'lib/gd-text-master/src/Struct/Point.php';
require_once 'lib/gd-text-master/src/Struct/Rectangle.php';

use GDText\Box;
use GDText\Color;


$file = './fondo_1.jpg';

$im = @imagecreatefromjpeg('./fondo_1.jpg');
// var_dump($im);
// return [];
$textbox = new Box($im);
$textbox->setFontSize(100);
$textbox->setFontFace(__DIR__.'/Roboto-Black.ttf');
$textbox->setFontColor(new Color(255, 255, 255)); // black
$textbox->setTextShadow(
    new Color(0, 0, 0, 80), // black color, but 60% transparent
    0,
    -1 // shadow shifted 1px to top
);
$textbox->setBox(
    10,  // distance from left edge
    0,  // distance from top edge
    imagesx($im), // textbox width, equal to image width
    imagesy($im)  // textbox height, equal to image height
);

$textbox->setTextAlign('center', 'center');
$textbox->draw($text);



$last_modified_time = filemtime($file); 
$etag = md5_file($file); 

header("Last-Modified: ".gmdate("D, d M Y H:i:s", $last_modified_time)." GMT"); 
header("Etag: $etag"); 

header("Content-type: image/PNG");
imagepng($im);
imagedestroy($im);