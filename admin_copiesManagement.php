<?php

session_start(); //Inicio de la sesión
require_once("src/funcs/funcs.php"); //Se hace un require del archivo de funciones para utilizarlas en éste archivo
$conn = connection();

if (!isset($_SESSION["user"]) || $_SESSION['rol'] != "Administrador") {
    header("Location: index.php");
}

$warnings = "";
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Administración de ejemplares | Shoptófilos</title>
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
                <h1 class="pageTitle">Administración de ejemplares</h1>
            </div>
            <section class="container">
                <form id="form1" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" autocomplete="off">
                    <button type="submit" id="queryAll" name="queryAll">Consular todos los ejemplares</button>
                    <button type="submit" id="querySales" name="querySales">Consular los ejemplares vendidos</button>
                    <button type="submit" id="queryRents" name="queryRents">Consultar los ejemplares alquilados</button>
                    <button type="submit" id="queryAvailableCopies" name="queryAvailableCopies">Consultar los ejemplares disponibles</button>
                    <button type="submit" id="addCopies" name="addCopies">Añadir ejemplares</button>
                </form>
                <?php

        if (empty($_POST)) {
            $sql = "SELECT e.id_ejemplar, e.estado, e.id_juego, j.titulo, j.plataforma, j.estudio, j.genero
                    FROM ejemplares e, juegos j
                    WHERE e.id_juego = j.id_juego
                    ORDER BY id_ejemplar, titulo";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                //PHP-HTML
                ?>
                <table>
                    <tr>
                        <th>ID Ejemplar</th>
                        <th>Estado</th>
                        <th>ID Juego</th>
                        <th>Titulo</th>
                        <th>Plataforma</th>
                        <th>Estudio</th>
                        <th>Genero</th>
                    </tr>
                    <?php
                //HTML-PHP

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id_ejemplar'] . "</td>";
                    echo "<td>" . $row['estado'] . "</td>";
                    echo "<td>" . $row['id_juego'] . "</td>";
                    echo "<td>" . $row['titulo'] . "</td>";
                    echo "<td>" . $row['plataforma'] . "</td>";
                    echo "<td>" . $row['estudio'] . "</td>";
                    echo "<td>" . $row['genero'] . "</td>";
                    echo "</tr>";
                }
                //PHP-HTML
                ?>
        
                </table>
        
                <?php
                //HTML-PHP
            } else {
                $warnings = "<p class=\"advice warning\">No hay ejemplares</p>";
            }
        } else {
            if (isset($_POST['queryAll'])) {
                $sql = "SELECT e.id_ejemplar, e.estado, e.id_juego, j.titulo, j.plataforma, j.estudio, j.genero
                        FROM ejemplares e, juegos j
                        WHERE e.id_juego = j.id_juego
                        ORDER BY id_ejemplar, titulo";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    //PHP-HTML
                    ?>
                    <table>
                        <tr>
                            <th>ID Ejemplar</th>
                            <th>Estado</th>
                            <th>ID Juego</th>
                            <th>Titulo</th>
                            <th>Plataforma</th>
                            <th>Estudio</th>
                            <th>Genero</th>
                        </tr>
                        <?php
                    //HTML-PHP
    
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id_ejemplar'] . "</td>";
                        echo "<td>" . $row['estado'] . "</td>";
                        echo "<td>" . $row['id_juego'] . "</td>";
                        echo "<td>" . $row['titulo'] . "</td>";
                        echo "<td>" . $row['plataforma'] . "</td>";
                        echo "<td>" . $row['estudio'] . "</td>";
                        echo "<td>" . $row['genero'] . "</td>";
                        echo "</tr>";
                    }
                    //PHP-HTML
                    ?>
            
                    </table>
            
                    <?php
                    //HTML-PHP
                } else {
                    $warnings = "<p class=\"advice warning\">No hay ejemplares</p>";
                }
            }
            if (isset($_POST['querySales'])) {
                $sql = "SELECT e.id_ejemplar, e.estado, e.id_juego, j.titulo, j.plataforma, j.estudio, j.genero
                        FROM ejemplares e, juegos j
                        WHERE e.estado = 'vendido'
                        AND e.id_juego = j.id_juego
                        ORDER BY id_ejemplar, titulo";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    //PHP-HTML
                    ?>
                    <table>
                        <tr>
                            <th>ID Ejemplar</th>
                            <th>Estado</th>
                            <th>ID Juego</th>
                            <th>Titulo</th>
                            <th>Plataforma</th>
                            <th>Estudio</th>
                            <th>Genero</th>
                        </tr>
                        <?php
                    //HTML-PHP
    
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id_ejemplar'] . "</td>";
                        echo "<td>" . $row['estado'] . "</td>";
                        echo "<td>" . $row['id_juego'] . "</td>";
                        echo "<td>" . $row['titulo'] . "</td>";
                        echo "<td>" . $row['plataforma'] . "</td>";
                        echo "<td>" . $row['estudio'] . "</td>";
                        echo "<td>" . $row['genero'] . "</td>";
                        echo "</tr>";
                    }
                    //PHP-HTML
                    ?>
            
                    </table>
            
                    <?php
                    //HTML-PHP
                } else {
                    $warnings = "<p class=\"advice warning\">No hay ejemplares vendidos</p>";
                }
            }
            if (isset($_POST['queryRents'])) {
                $sql = "SELECT e.id_ejemplar, e.estado, e.id_juego, j.titulo, j.plataforma, j.estudio, j.genero
                        FROM ejemplares e, juegos j
                        WHERE e.estado = 'alquilado'
                        AND e.id_juego = j.id_juego
                        ORDER BY id_ejemplar, titulo";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    //PHP-HTML
                    ?>
                    <table>
                        <tr>
                            <th>ID Ejemplar</th>
                            <th>Estado</th>
                            <th>ID Juego</th>
                            <th>Titulo</th>
                            <th>Plataforma</th>
                            <th>Estudio</th>
                            <th>Genero</th>
                        </tr>
                        <?php
                    //HTML-PHP
    
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id_ejemplar'] . "</td>";
                        echo "<td>" . $row['estado'] . "</td>";
                        echo "<td>" . $row['id_juego'] . "</td>";
                        echo "<td>" . $row['titulo'] . "</td>";
                        echo "<td>" . $row['plataforma'] . "</td>";
                        echo "<td>" . $row['estudio'] . "</td>";
                        echo "<td>" . $row['genero'] . "</td>";
                        echo "</tr>";
                    }
                    //PHP-HTML
                    ?>
            
                    </table>
            
                    <?php
                    //HTML-PHP
                } else {
                    $warnings = "<p class=\"advice warning\">No hay ejemplares alquilados</p>";
                }
            }
            if (isset($_POST['queryAvailableCopies'])) {
                $sql = "SELECT e.id_ejemplar, e.estado, e.id_juego, j.titulo, j.plataforma, j.estudio, j.genero
                        FROM ejemplares e, juegos j
                        WHERE e.estado = 'libre'
                        AND e.id_juego = j.id_juego
                        ORDER BY id_ejemplar, titulo";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    //PHP-HTML
                    ?>
                    <table>
                        <tr>
                            <th>ID Ejemplar</th>
                            <th>Estado</th>
                            <th>ID Juego</th>
                            <th>Titulo</th>
                            <th>Plataforma</th>
                            <th>Estudio</th>
                            <th>Genero</th>
                        </tr>
                        <?php
                    //HTML-PHP
    
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id_ejemplar'] . "</td>";
                        echo "<td>" . $row['estado'] . "</td>";
                        echo "<td>" . $row['id_juego'] . "</td>";
                        echo "<td>" . $row['titulo'] . "</td>";
                        echo "<td>" . $row['plataforma'] . "</td>";
                        echo "<td>" . $row['estudio'] . "</td>";
                        echo "<td>" . $row['genero'] . "</td>";
                        echo "</tr>";
                    }
                    //PHP-HTML
                    ?>
            
                    </table>
            
                    <?php
                    //HTML-PHP
                } else {
                    echo "<p class=\"advice warning\">No hay ejemplares disponibles</p>";
                }
            }
            if (isset($_POST['addCopies'])) {
            //PHP -HTML
            ?>

            <form id='form2' role='form' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method='POST' autocomplete='off'>
                <label for="id_juego">ID de Juego a añadir ejemplares</label>
                <br/>
                <input type="number" id="id_juego" name="id_juego" placeholder="ID Juego" required="required" />
                <br/>
                <br/>
                <label for="copies">Número de ejemplares a añadir</label>
                <br/>
                <input type="number" id="copies" name="copies" placeholder="Número de ejemplares" required="required" />
                <br/>
                <br/>
                <button type="submit" id="add" name="add">Añadir</button>
            </form>

            <?php
            }
            //HTML - PHP

            if(isset($_POST['add'])) {

                $sql = "SELECT id_juego FROM juegos where id_juego = " . $_POST['id_juego'];
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
            
                    for ($i = 0; $i < $_POST['copies']; $i++) {
                        $sql = "INSERT INTO ejemplares (id_juego, estado)
                                VALUES (". $_POST['id_juego'] . ", \"libre\")";
                        if ($conn->query($sql) === true) {
                            $warnings = "<p class=\"advice notice\">Se han añadido los ejemplares</p>";
                        } else {
                            $warnings = "<p class=\"advice warning\">Error en la inserción de la fila</p>";
                            echo "
                            <script type='text/javascript'>
                                var error = '\$conn->error (Si deseas ver el error, modifica la variable error para mostrar \$conn->error)';
                                console.log(\"Error en la inserción de la fila: \" + error);
                            </script>
                            ";
                        }
                    }
                } else {
                    $warnings = "<p class=\"advice warning\">No existe ningún juego con ese ID</p>";
                }
            }
            echo $warnings;
        }

$conn->close();
?>

    </section>
</main>
<footer>
    <?php require_once("src/funcs/footer.php"); ?> <!-- Require del footer -->
</footer>
</body>

</html>