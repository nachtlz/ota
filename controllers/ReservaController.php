<?php

class ReservaController {

  public static function index(Router $router) {
    
    if($_SERVER["REQUEST_METHOD"] === "POST") {

      session_start();
      $type = $_POST["type"];
      $_SESSION["type"] = $type;

      if($type == 0) {
        $_SESSION["codigo"] = $_POST["codigo"];
        $_SESSION["idHotel"] = $_POST["idHotel"];
      } else if($type == 1) {
        $_SESSION["idDisponibilidad"] = $_POST["idDisponibilidad"];
      } else if($type == 2) {
        $_SESSION["tarifa"] = $_POST["tarifa"];
        $_SESSION["codigo"] = $_POST["codigo"];
      }

      header("Location: /ota/public/guardar");
    }
  }

  public static function guardar(Router $router) {

    $alertaR = "";
    $alertaB = "";
    
    if($_SERVER["REQUEST_METHOD"] === "POST") {

      $nombre = $_POST["nombre"];
      $apellido = $_POST["apellido"];
      $telefono = $_POST["telefono"];
      $email = $_POST["email"];
      $dni = $_POST["dni"];

      if($nombre && $apellido && $telefono && $email) {

        session_start();
        $type = $_SESSION["type"];

        $fechaInicio = $_SESSION["fechaInicio"];
        $fechaFin = $_SESSION["fechaFin"];
        $adultos = $_SESSION["adultos"];
        $menores = $_SESSION["menores"];

        if($type == 0) {
          $codigo = $_SESSION["codigo"];
          $idHotel = $_SESSION["idHotel"];

          $url = 'http://localhost:8080/apibd?comanda=cliente-addCliente&dades=%3Cclientes%3E%3Ccliente%3E%3Cnombre%3E'. $nombre .'%3C/nombre%3E%3Capellido%3E'. $apellido .
          '%3C/apellido%3E%3Ctelefono%3E'. $telefono .'%3C/telefono%3E%3Cid%3E%3C/id%3E%3Ctipoid%3E%3C/tipoid%3E%3Cnacionalidad%3E%3C/nacionalidad%3E%3Cedad%3E%3C/edad%3E%3Cemail%3E'. $email .'%3C/email%3E%3Cpassword%3E%3C/password%3E%3C/cliente%3E%3C/clientes%3E';
          
          //Leemos el json de la API
          $jsonData = file_get_contents($url);

          //Decodificar el json en un array php
          $cliente = json_decode($jsonData);

          $cliente = $cliente[0];

          $url = 'http://localhost:8080/apibd?comanda=reserva-addReserva&dades=%3Creservas%3E%3Creserva%3E%3CfechaInicio%3E'. $fechaInicio .
          '%3C/fechaInicio%3E%3CfechaFin%3E'. $fechaFin .'%3C/fechaFin%3E%3Cadultos%3E'. $adultos .'%3C/adultos%3E%3Cmenores%3E'. $menores .
          '%3C/menores%3E%3CidCliente%3E'. $cliente->idCliente .'%3C/idCliente%3E%3Ccodigo%3E'. $codigo .'%3C/codigo%3E%3CidHotel%3E'. $idHotel .'%3C/idHotel%3E%3C/reserva%3E%3C/reservas%3E';
          
          //Leemos el json de la API
          $jsonData = file_get_contents($url);
              
          //Decodificar el json en un array php
          $reserva = json_decode($jsonData);
          $alertaB = "Reserva realizada con éxito";

        } else if($type == 1) {
          $idDisponibilidad = $_SESSION["idDisponibilidad"];

          $db = mysqli_connect('localhost', 'root', '', 'channel');
          $query = "INSERT INTO cliente (nombre, apellido, telefono, email) VALUES ('$nombre', '$apellido', '$telefono', '$email');";
          $resultado = mysqli_query($db, $query);

          $query = "SELECT * FROM cliente WHERE email = '$email'";
          $cliente = mysqli_query($db, $query);
          $cliente = mysqli_fetch_assoc($cliente);

          $query = "INSERT INTO reserva (fechaInicio, fechaFin, adultos, menores, idCliente, idDisponibilidad) VALUES ('$fechaInicio', '$fechaFin', $adultos, $menores, ". $cliente["idCliente"] .", $idDisponibilidad)";
          $resultado = mysqli_query($db, $query);
          $alertaB = "Reserva realizada con éxito";
        } else if($type == 2) {

          $tarifa = $_SESSION["tarifa"];
          $codigo = $_SESSION["codigo"];

          $pax = $adultos + $menores;
          $url = "http://webdocsst.000webhostapp.com/ssthotel.php?accio=2&tipohab=". $tarifa ."&agencia=OTA&pax=". $pax ."&ent=". date('Ymd', strtotime($fechaInicio)) ."&sal=". date('Ymd', strtotime($fechaFin)) ."&dadesclient=". $dni ."&tarifa=". $tarifa;
          $resultado = file_get_contents($url);
          $mixml = new SimpleXMLElement($resultado);

          if($mixml->reservation->confirmation == "Y") {
            $alertaB = "Reserva realizada con éxito";
          } else {
            $alertaR = "Ha habido un problema";
          }
        }

        $_SESSION = [];
        header("refresh:3;url=/ota/public/");

      } else {
        $alertaR = "Rellena todos los campos";
      }
    }

    $router->render("reserva/index", [
      "titulo" => "Reservar",
      "alertaR" => $alertaR,
      "alertaB" => $alertaB
    ]);
  }
}