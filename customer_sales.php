<?php

session_start(); //Inicio de la sesión
require_once("src/funcs/funcs.php"); //Se hace un require del archivo de funciones para utilizarlas en éste archivo
$conn = connection();

if (!isset($_SESSION["user"])) {
    header("Location: index.php");
}

$warnings = "";

?>

<!DOCTYPE html>
<html>

<head>
    <title>Mis compras | Shoptófilos</title>
    <?php require_once("src/funcs/head_meta.php"); ?> <!-- Require de los link, meta y script -->
</head>

<body>
    <header>
        <h1 class="mainTitle">Shoptófilos<span class="company">A Softófilos™ Company</span></h1>
        <p class="right">
            <label>Bienvenido <?php echo $_SESSION['user'] ?></label>
        </p>
        <div class="menuButtonContainer">
            <a id="indexButton" class="menuButton" href="index.php">Inicio</a>
        </div>
        <div class="menuButtonContainer">
            <a id="user" class="menuButton" href="user.php">Área del usuario</a>
        </div>
    </header>
    <main>
        <div class="pageTitleContainer">
            <h1 class="pageTitle">Mis compras</h1>
        </div>
        <section class="container">
        <?php

        $sql = "SELECT j.titulo, j.plataforma, j.estudio, j.genero, v.fecha, v.id_ejemplar
                FROM juegos j, juegos_venta v, ejemplares e
                WHERE j.id_juego = e.id_juego
                AND e.id_ejemplar = v.id_ejemplar
                AND v.dni = \"" . $_SESSION['dni'] . "\" ORDER BY v.fecha";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            //PHP-HTML
            ?>
            <table>
                <tr>
                    <th>Titulo</th>
                    <th>Plataforma</th>
                    <th>Estudio</th>
                    <th>Género</th>
                    <th>Fecha</th>
                    <th>ID Ejemplar</th>
                </tr>
            <?php
            //HTML-PHP

            while ($row = $result->fetch_assoc()) {

                echo "<tr>";
                echo "<td>" . $row['titulo'] . "</td>";
                echo "<td>" . $row['plataforma'] . "</td>";
                echo "<td>" . $row['estudio'] . "</td>";
                echo "<td>" . $row['genero'] . "</td>";
                echo "<td>" . $row['fecha'] . "</td>";
                echo "<td>" . $row['id_ejemplar'] . "</td>";
                echo "</tr>";
            }
            //PHP-HTML
            ?>
            
            </table>

            <?php
            //HTML-PHP
        } else {
            $warnings = "<p class=\"advice warning\">No has hecho ninguna compra todavía<p>";
        }
        echo $warnings;
        ?>
        </section>
    </main>
    <footer>
        <?php require_once("src/funcs/footer.php"); ?> <!-- Require del footer -->
    </footer>
</body>

</html>
