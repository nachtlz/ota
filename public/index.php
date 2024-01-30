<?php 

require '../Router.php';
require '../controllers/DisponibilidadController.php';
require '../controllers/ReservaController.php';
require '../controllers/ClienteController.php';
require '../controllers/HotelController.php';
$url = "/ota/public";

$router = new Router();

//Hoteles
$router->get($url . "/", [DisponibilidadController::class, "index"]);
$router->post($url . "/", [DisponibilidadController::class, "index"]);

//Reserva
$router->get($url . "/reservar", [ReservaController::class, "index"]);
$router->post($url . "/reservar", [ReservaController::class, "index"]);

$router->get($url . "/guardar", [ReservaController::class, "guardar"]);
$router->post($url . "/guardar", [ReservaController::class, "guardar"]);

/* //Disponibilidad
$router->get($url . "/disponibilidad", [DisponibilidadController::class, "index"]);
$router->post($url . "/disponibilidad", [DisponibilidadController::class, "index"]);

//Cliente
$router->get($url . "/autenticacion", [ClienteController::class, "index"]);
$router->post($url . "/autenticacion", [ClienteController::class, "index"]);
$router->post($url . "/codigo", [ClienteController::class, "addCodigo"]); */

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();