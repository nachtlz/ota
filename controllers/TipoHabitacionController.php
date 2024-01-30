CONSULTA QUE HAY QUE HACERLE AL WEBSERVICE
SELECT d.idHotel, d.habsDisponibles, d.precio, th.*, GREATEST(d.habsDisponibles - COALESCE(nr.ocupadas, 0), 0) AS disponibles
FROM disponibilidad d
LEFT JOIN
    (SELECT r.codigo, COUNT(r.idReserva) AS ocupadas
    FROM reserva r
    WHERE r.idHotel = 1 
    AND ((r.fechainicio >= '2023-12-03' AND r.fechafin <= '2023-12-30') OR
    (r.fechainicio < '2023-12-03' AND r.fechafin > '2023-12-03') OR
    (r.fechainicio < '2023-12-30' AND r.fechafin > '2023-12-30'))
    GROUP BY r.codigo) AS nr
ON d.codigo = nr.codigo
JOIN tipohabitacion th ON th.codigo = d.codigo
WHERE d.idHotel = 1

hacer esta consulta para cada hotel

CONSULTA QUE HAY QUE HACERLE AL CHANNEL

SELECT d.idHotel, d.habsDisponibles, d.idDisponibilidad, d.fechaInicio, d.fechaFin, d.precio, d.codigo, tipohabitacion.descripcion, tipohabitacion.adultos, tipohabitacion.menores, hotel.nombre, hotel.imagen, GREATEST(d.habsDisponibles - COALESCE(nr.ocupadas, 0), 0) AS disponibles
FROM disponibilidad d
LEFT JOIN (SELECT r.idDisponibilidad, COUNT(r.idDisponibilidad) as ocupadas
        FROM reserva r
        WHERE ((r.fechainicio >= '2023-12-23' AND r.fechafin <= '2023-12-27') OR
		(r.fechainicio < '2023-12-23' AND r.fechafin > '2023-12-23') OR
		(r.fechainicio < '2023-12-27' AND r.fechafin > '2023-12-27'))
        GROUP BY r.idDisponibilidad) as nr
ON d.idDisponibilidad = nr.idDisponibilidad
JOIN tipohabitacion ON tipohabitacion.codigo = d.codigo
JOIN hotel ON hotel.idHotel = d.idHotel
WHERE d.fechainicio <= '2023-12-23' AND d.fechafin >= '2023-12-27'


---------------------



SELECT *
FROM tipohabitacion th
JOIN disponibilidad d ON d.codigo = th.codigo
LEFT JOIN
    (SELECT r.codigo, COUNT(r.idReserva) AS ocupadas
    FROM reserva r
    WHERE
        ((r.fechainicio >= '2023-12-03' AND r.fechaFin <= '2023-12-30') 
        OR(r.fechainicio < '2023-12-03' AND r.fechaFin <= '2023-12-30') 
        OR(r.fechainicio >= '2023-12-03' AND r.fechaFin > '2023-12-30'))
    GROUP BY r.idHotel, r.codigo) AS nr
ON d.codigo = nr.codigo

SELECT d.idHotel, d.habsDisponibles, d.precio, th.*, GREATEST(d.habsDisponibles - COALESCE(nr.ocupadas, 0), 0) AS disponibles
FROM disponibilidad d
LEFT JOIN
    (SELECT r.codigo, COUNT(r.idReserva) AS ocupadas
    FROM reserva r
    WHERE r.idHotel = 1 
    AND ((r.fechainicio >= '2023-12-03' AND r.fechafin <= '2023-12-30') OR
    (r.fechainicio < '2023-12-03' AND r.fechafin > '2023-12-03') OR
    (r.fechainicio < '2023-12-30' AND r.fechafin > '2023-12-30'))
    GROUP BY r.codigo) AS nr
ON d.codigo = nr.codigo
JOIN tipohabitacion th ON th.codigo = d.codigo
WHERE d.idHotel = 1

SELECT r.idHotel, r.codigo, COUNT(r.idReserva) AS ocupadas
    FROM reserva r
    WHERE ((r.fechainicio >= '2023-12-03' AND r.fechafin <= '2023-12-30') OR
           (r.fechainicio < '2023-12-03' AND r.fechafin > '2023-12-03') OR
           (r.fechainicio < '2023-12-30' AND r.fechafin > '2023-12-30'))
    GROUP BY r.idHotel, r.codigo

    SELECT *
FROM disponibilidad
LEFT JOIN reserva r ON r.idDisponibilidad = disponibilidad.idDisponibilidad
WHERE disponibilidad.idHotel = 1 AND disponibilidad.fechainicio <= '2023-12-23' AND disponibilidad.fechafin >= '2023-12-27'
    AND ((r.fechainicio >= '2023-12-23' AND r.fechafin <= '2023-12-27') OR
(r.fechainicio < '2023-12-23' AND r.fechafin > '2023-12-23') OR
(r.fechainicio < '2023-12-27' AND r.fechafin > '2023-12-27'))



<h3 style="margin-bottom: 25px">Disponibilidad total en <?php echo $hotel["nombre"]; ?></h3>
            <div class="row">
                <?php
                    if(mysqli_num_rows($disponibilidades) == 0) {
                        ?>
                        <h3>No hay disponibilidades registradas para este hotel.</h3>
                        <?php
                    } else {
                ?>
                <?php while($dispo = mysqli_fetch_assoc($disponibilidades)) {?>
                    <div class="col-lg-4 col-md-6">
                        <div class="room-item">
                            <img src="img/<?php echo $hotel["imagen"]; ?>.jpg" alt="">
                            <div class="ri-text">
                                <h4><?php echo $dispo["descripcion"]; ?></h4>
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
                                        <tr>
                                            <td class="r-o">Fecha Inicio:</td>
                                            <td><?php echo $dispo["fechaInicio"]; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Fecha Fin:</td>
                                            <td><?php echo $dispo["fechaFin"]; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php 
                    }
                
                }
                ?>
            </div>