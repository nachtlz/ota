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
    
<body>
    <!-- Header Section Begin -->
    <header class="header-section header-normal">
        <div class="menu-item">
            <div class="container">
                    <div class="col-lg-10">
                        <div class="nav-menu">
                            <nav class="mainmenu">
                                <ul>
                                    <li><a href="/ota/public/">Busca ofertas</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="booking-form">
                        <div class="centrar">
                            <h3>Rellena los campos para asignarte la reserva</h3>
                        </div>
                        <?php
                            if ($alertaR != "") {
                                ?>
                                <div class="alert alert-danger" role="alert">
                                <?php echo $alertaR; ?>
                                </div>
                                <?php
                            } else if($alertaB != "") {
                                ?>
                                <div class="alert alert-success" role="alert">
                                <?php echo $alertaB; ?>
                                </div>
                                <?php
                            }
                        ?>
                        <form action="/ota/public/guardar" class="formulario" method="POST">
                            <div class="check-date">
                                <label for="date-out">Nombre:</label>
                                <input type="text" name="nombre">
                            </div>
                            <div class="check-date">
                                <label for="date-out">Apellido:</label>
                                <input type="text" name="apellido">
                            </div>
                            <div class="check-date">
                                <label for="date-out">DNI:</label>
                                <input type="text" name="dni">
                            </div>
                            <div class="check-date">
                                <label for="date-out">Teléfono:</label>
                                <input type="text" name="telefono">
                            </div>
                            <div class="check-date">
                                <label for="date-out">Email:</label>
                                <input type="email" name="email">
                            </div>
                            <input type="hidden" name="registrado" value="0">
                            <button class="booking_submit" type="submit">Hacer reserva</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>