<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Sona Template">
    <meta name="keywords" content="Sona, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sona | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/flaticon.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/estilos.css" type="text/css">
</head>

<body>

    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>¡Reservas de todos los hoteles!</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Rooms Section Begin -->
    <section class="rooms-section spad">
        <div class="container">
            <div class="col-md-12">
                <div class="booking-form">
                    <div class="centrar">
                        <h3>Inserta la información y busca la mejor reserva</h3>
                    </div>
                    <form action="/ota/public/" class="formulario" method="POST">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="check-date">
                                    <label for="date-in">Fecha Inicio:</label>
                                    <input type="text" class="date-input" id="date-in" name="fechaInicio">
                                    <i class="icon_calendar"></i>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="check-date">
                                    <label for="date-out">Fecha Fin:</label>
                                    <input type="text" class="date-input" id="date-out" name="fechaFin">
                                    <i class="icon_calendar"></i>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="check-date">
                                    <label>Adultos:</label>
                                    <input type="number" id="adultos" name="adultos">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="check-date">
                                    <label>Menores:</label>
                                    <input type="number" id="menores" name="menores">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="booking_submit" type="submit">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <h3 style="margin-bottom: 25px">Escoge tu oferta:</h3>
            <div class="row">
                <?php
                    if(empty(($disponibilidades))) {
                        ?>
                        <h3>No hay ofertas con esas condiciones.</h3>
                        <?php
                    } else {
                ?>
                <h4>Ofertas entre <?php echo $fechaInicio; ?> - <?php echo $fechaFin; ?></h4>
                <?php foreach($disponibilidades as $dispo) {
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="room-item">
                            <div class="ri-text booking-form">
                                <form action="/ota/public/reservar" class="formulario" method="POST">
                                    <h4><?php echo $dispo["descripcion"]; ?> en <?php echo $dispo["nombre"]; ?></h4>
                                    <h3><?php echo $dispo["precio"]; ?>€<span>/Pernight</span></h3>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td class="r-o">Codigo:</td>
                                                <td><?php echo $dispo["codigo"]; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="r-o">Adultos:</td>
                                                <td><?php echo $dispo["adultos"]; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="r-o">Menores:</td>
                                                <td><?php echo $dispo["menores"]; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <input type="hidden" name="type" value="<?php echo $dispo["type"]; ?>">
                                    <?php
                                        if($dispo["type"] == 0) {
                                            ?>
                                                <input type="hidden" name="codigo" value="<?php echo $dispo["codigo"]; ?>">
                                                <input type="hidden" name="idHotel" value="<?php echo $dispo["idHotel"]; ?>">
                                            <?php
                                        } else if($dispo["type"] == 1){
                                            ?>
                                                <input type="hidden" name="idDisponibilidad" value="<?php echo $dispo["idDisponibilidad"]; ?>">
                                            <?php
                                        } else if ($dispo["type"] == 2){
                                            ?>
                                                <input type="hidden" name="codigo" value="<?php echo $dispo["codigo"]; ?>">
                                                <input type="hidden" name="tarifa" value="<?php echo $dispo["precio"]; ?>">
                                            <?php
                                        }
                                    ?>
                                    <button class="booking_submit" type="submit">Reservar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php 
                    }
                
                }
                ?>
            </div>
        </div>
    </section>
    <!-- Rooms Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>