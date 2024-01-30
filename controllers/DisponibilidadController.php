<?php 

class DisponibilidadController {

    public static function index(Router $router) {

        $disponibilidades = [];
        $disponibilidadesFiltradas = [];
        $hoteles = [];
        $fechaI = "";
        $fechaF = "";

        if($_SERVER["REQUEST_METHOD"] === "POST") {

            session_start();
            $fechaI = $_POST["fechaInicio"];
            $fechaF = $_POST["fechaFin"];
            $fechaInicio = date('Y-m-d', strtotime($_POST["fechaInicio"]));
            $fechaFin = date('Y-m-d', strtotime($_POST["fechaFin"]));
            $_SESSION["fechaInicio"] = $fechaInicio;
            $_SESSION["fechaFin"] = $fechaFin;
            $adultos = $_POST["adultos"];
            $menores = $_POST["menores"];
            $_SESSION["adultos"] = $adultos;
            $_SESSION["menores"] = $menores;

            $url = 'http://localhost:8080/apibd?comanda=hotel-getAll&dades=%3Call%3E';

            $jsonData = file_get_contents($url);
    
            $hoteles = json_decode($jsonData);
    
            foreach($hoteles as $hotel) {
                $url = 'http://localhost:8080/apibd?comanda=reserva-getHabitacionesDisponiblesByReserva&dades=%3Creservas%3E%3Creserva%3E%3CidHotel%3E' . $hotel->idHotel . '%3C/idHotel%3E%3CfechaInicio%3E'. $fechaInicio .'%3C/fechaInicio%3E%3CfechaFin%3E'. $fechaFin .'%3C/fechaFin%3E%3C/reserva%3E%3C/reservas%3E';
                $jsonData = file_get_contents($url);
                $disponibilidades[] = json_decode($jsonData, true);
            }

            foreach($disponibilidades as $dispos) {
                foreach($dispos as $dispo) {
                    // Verificar si las propiedades esperadas existen antes de acceder a ellas
                    if (isset($dispo["adultos"], $dispo["menores"], $dispo["disponibles"])) {
                        // Filtrar según las condiciones
                        if ($dispo["adultos"] >= $adultos && $dispo["menores"] >= $menores && $dispo["disponibles"] > 0) {
                            $dispo["type"] = 0;
                            $disponibilidadesFiltradas[] = $dispo;
                        }
                    } else {
                        // Alguna propiedad esperada no está presente en el objeto $dispo
                        echo "Error: Propiedades faltantes en el objeto dispo.";
                    }
                }
            }

            $db = mysqli_connect('localhost', 'root', '', 'channel');
            $query = "SELECT d.idHotel, d.habsDisponibles, d.idDisponibilidad, d.fechaInicio, d.fechaFin, d.precio, d.codigo, tipohabitacion.descripcion, tipohabitacion.adultos, tipohabitacion.menores, hotel.nombre, GREATEST(d.habsDisponibles - COALESCE(nr.ocupadas, 0), 0) AS disponibles
            FROM disponibilidad d
            LEFT JOIN (SELECT r.idDisponibilidad, COUNT(r.idDisponibilidad) as ocupadas
            FROM reserva r
            WHERE ((r.fechainicio >= '". $fechaInicio ."' AND r.fechafin <= '". $fechaFin ."') OR
                (r.fechainicio < '". $fechaInicio ."' AND r.fechafin > '". $fechaInicio ."') OR
                (r.fechainicio < '". $fechaFin ."' AND r.fechafin > '". $fechaFin ."'))
            GROUP BY r.idDisponibilidad) as nr
            ON d.idDisponibilidad = nr.idDisponibilidad
            JOIN tipohabitacion ON tipohabitacion.codigo = d.codigo
            JOIN hotel ON hotel.idHotel = d.idHotel
            WHERE d.fechainicio <= '". $fechaInicio ."' AND d.fechafin >= '". $fechaFin ."';";

            $disponibilidades = mysqli_query($db, $query);

            while ($dispo = mysqli_fetch_assoc($disponibilidades)) {
                // Verificar si las propiedades esperadas existen antes de acceder a ellas
                if (isset($dispo["adultos"], $dispo["menores"], $dispo["disponibles"])) {
                    // Filtrar según las condiciones
                    if ($dispo["adultos"] >= $adultos && $dispo["menores"] >= $menores && $dispo["disponibles"] > 0) {
                        $dispo["type"] = 1;
                        $disponibilidadesFiltradas[] = $dispo;
                    }
                } else {
                    // Alguna propiedad esperada no está presente en el objeto $dispo
                    echo "Error: Propiedades faltantes en el objeto dispo.";
                }
            }

            $pax = $adultos + $menores;

            $url = "http://webdocsst.000webhostapp.com/ssthotel.php?accio=1&agencia=OTA&pax=". $pax ."&ent=". date('Ymd', strtotime($fechaInicio)) ."&sal=". date('Ymd', strtotime($fechaFin));
            $resultado = file_get_contents($url);
            $mixml = new SimpleXMLElement($resultado);

            if($mixml->message != "er") {
                foreach($mixml->result->availibility as $dispo) {
                    if($dispo["quantity"] != "0") {
                        $d = [];
                        $d["codigo"] = $dispo->type;
                        $d["descripcion"] = $dispo->type;
                        $d["type"] = 2;
                        $d["precio"] = $dispo->rate;
                        $d["adultos"] = $adultos;
                        $d["menores"] = $menores;
                        $d["nombre"] = $mixml->hotel;
                        $disponibilidadesFiltradas[] = $d;
                    }
                }
            }

            shuffle($disponibilidadesFiltradas);
        }

        $router->render("principal/index", [
            "titulo" => "Disponibilidades",
            "disponibilidades" => $disponibilidadesFiltradas,
            "hoteles" => $hoteles,
            "fechaInicio" => $fechaI,
            "fechaFin" => $fechaF
        ]);
    }
}