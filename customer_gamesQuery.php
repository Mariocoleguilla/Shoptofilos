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
    <title>Adquirir Juegos | Shoptófilos</title>
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
            <h1 class="pageTitle">Adquirir Juegos</h1>
        </div>
        <section class="container">

<?php

if(!empty($_POST)) {
    if (isset($_POST['buy'])) {

        $_SESSION['operation'] = "buy";
        $sql = "SELECT * FROM ejemplares WHERE estado = \"libre\" AND id_juego = \"" . $_POST['buy'] . "\" LIMIT 1";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            echo "<p class=\"advice notice\">Hay un ejemplar con id " . $row['id_ejemplar'] . " disponible, ¿desea comprarlo?</p><br/>";
            //PHP-HTML
            ?>
            <form id="form2" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" autocomplete="off">
                <button type="submit" id="buyYes" value="<?php echo $row['id_ejemplar'] ?>" name="yes">Si</button>
                <button type="submit" id="buyNo" value="<?php echo $row['id_ejemplar'] ?>" name="no">No</button>
            </form>

            <?php
            //HTML-PHP
        } else {
            $warnings = "<p class=\"advice warning\">No hay ningún ejemplar de éste juego disponible para comprar</p>";
        }

    }

    if (isset($_POST['rent'])) {
        
        $_SESSION['operation'] = "rent";
        $sql = "SELECT * FROM ejemplares WHERE estado = \"libre\" AND id_juego = \"" . $_POST['rent'] . "\" LIMIT 1";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            echo "<p class=\"advice notice\">Hay un ejemplar con id " . $row['id_ejemplar'] . " disponible, ¿desea alquilarlo?</p><br/>";
            //PHP-HTML
            ?>
            <form id="form2" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" autocomplete="off">
                <button type="submit" id="buyYes" value="<?php echo $row['id_ejemplar'] ?>" name="yes">Si</button>
                <button type="submit" id="buyNo" value="<?php echo $row['id_ejemplar'] ?>" name="no">No</button>
            </form>

            <?php
            //HTML-PHP
        } else {
            $warnings = "<p class=\"advice warning\">No hay ningún ejemplar de éste juego disponible para alquilar</p>";
        }
    }

    if (isset($_SESSION['operation'])) {
        if ($_SESSION['operation'] == "buy") {
            if (isset($_POST['yes'])) {
                $warnings = sale($_POST['yes'], $_SESSION['dni']);
            }
            if (isset($_POST['no'])) {
                $warnings = "<p class=\"advice neutral\">Has cancelado la compra</p>";
            }
        }

        if ($_SESSION['operation'] == "rent") {
            if (isset($_POST['yes'])) {
                $warnings = rental($_POST['yes'], $_SESSION['dni']);
            }
            if (isset($_POST['no'])) {
                $warnings = "<p class=\"advice neutral\">Has cancelado el alquiler</p>";
            }
        }
    }
    echo $warnings;
}

?>

<form id="form" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" autocomplete="off">
    <table>
        <tr>
            <th>Título</th>
            <th>Plataforma</th>
            <th>Estudio</th>
            <th>Género</th>
            <th>Comprar</th>
            <th>Alquilar</th>
        </tr>
<?php
    //HTML - PHP

    $sql = "SELECT * FROM juegos";
    $result = $conn->query($sql);
    $conn->close();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['titulo'] . "</td>";
            echo "<td>" . $row['plataforma'] . "</td>";
            echo "<td>" . $row['estudio'] . "</td>";
            echo "<td>" . $row['genero'] . "</td>";
            echo "<td class=\"gamesQueryCells\"><button class=\"gamesQueryButtons\" type=\"submit\" id=\"comprar\" value=\"" . $row['id_juego'] . "\" name=\"buy\">Comprar</button></td>";
            echo "<td class=\"gamesQueryCells\"><button class=\"gamesQueryButtons\" type=\"submit\" id=\"alquilar\" value=\"" . $row['id_juego'] . "\" name=\"rent\">Alquilar</button></td>";
            echo "</tr>";
        }
    }
    //PHP -HTML
    ?>
                </table>
            </form>
        </section>
    </main>
    <footer>
        <?php require_once("src/funcs/footer.php"); ?> <!-- Require del footer -->
    </footer>
</body>

</html>