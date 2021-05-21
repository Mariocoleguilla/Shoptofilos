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
    <title>Administración de alquileres | Shoptófilos</title>
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
            <h1 class="pageTitle">Administración de alquileres</h1>
        </div>
        <section class="container">
        <form id="form1" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" autocomplete="off">
            <label for="id_alquiler">ID Alquiler</label>
            <br/>
            <input type="number" id="id_alquiler" name="id_alquiler" placeholder="ID Alquiler" required="required"/>
            <br/>
            <br/>
            <button type="submit" id="query" name="query">Consultar</button>
        </form>
        <?php
        if (!empty($_POST)) {

            if (isset($_POST['edit'])) { //Comprobación del segundo formulario

                $dateRegExp = "/^(\d{4})-(\d{1,2})-(\d{1,2})$/";
                
                if (strlen($_POST['date']) < 1) {
                    $warnings = "<p class=\"advice warning\">Debes rellenar todos los campos</p>";
                } else {

                    if (!preg_match($dateRegExp, $_POST['date'])) {
                        $warnings = "<p class=\"advice warning\">Formato de fecha inválido</p>";
                    } else {

                        $sql = "UPDATE juegos_alquiler SET fecha = \"" . $_POST['date'] . "\" WHERE id_alquiler = " . $_POST['id_alquiler2'];
                        
                        if ($conn->query($sql) === true) {
                            $warnings = "<p class=\"advice notice\">Actualización realizada con éxito</p>";
                        } else {
                            $warnings = "<p class=\"advice warning\">Error en la actualización de la tabla</p>";
                            echo "
                            <script type='text/javascript'>
                                var error = '\$conn->error (Si deseas ver el error, modifica la variable error para mostrar \$conn->error)';
                                console.log(\"Error en la actualización de la tabla: \" + error);
                            </script>
                            ";
                        }
                    }
                }
            }

            if (isset($_POST['delete'])) {

                $sql = "UPDATE ejemplares SET estado = 'libre' WHERE id_ejemplar = (SELECT id_ejemplar FROM juegos_alquiler WHERE id_alquiler = " . $_POST['id_alquiler2'] . ");";
                
                if ($conn->query($sql) === true) {

                    $sql = "DELETE FROM juegos_alquiler WHERE id_alquiler = " . $_POST['id_alquiler2'];
                    
                        if ($conn->query($sql) === true) {
                            
                            $warnings = "<p class=\"advice notice\">Eliminación y actualización realizada con éxito</p>";
                        } else {
                            $warnings = "<p class=\"advice warning\">Error en la eliminación de la fila</p>";
                            echo "
                            <script type='text/javascript'>
                                var error = '\$conn->error (Si deseas ver el error, modifica la variable error para mostrar \$conn->error)';
                                console.log(\"Error en la eliminación de la fila: \" + error);
                            </script>
                            ";
                        }
                    
                } else {
                    $warnings = "<p class=\"advice warning\">Error en la actualización de la fila</p>";
                    echo "
                    <script type='text/javascript'>
                        var error = '\$conn->error (Si deseas ver el error, modifica la variable error para mostrar \$conn->error)';
                        console.log(\"Error en la actualización de la fila: \" + error);
                    </script>
                    ";
                }
            }

            if (isset($_POST['query'])) {
                $sql = "SELECT j.id_juego, j.titulo, j.plataforma, j.estudio, j.genero, a.fecha, a.dni, a.id_alquiler, a.id_ejemplar
                    FROM juegos j, juegos_alquiler a, ejemplares e
                    WHERE j.id_juego = e.id_juego
                    AND e.id_ejemplar = a.id_ejemplar
                    AND a.id_alquiler = " . $_POST['id_alquiler'] . "
                    ORDER BY id_alquiler";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    //PHP -HTML
                ?>
        
                <form id='form2' role='form' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method='POST' autocomplete='off'>
                    <br/>
                    <label for='id_alquiler2'>ID Alquiler</label>
                    <br/>
                    <input type='text' id='id_alquiler2' class="redInput" name='id_alquiler2' value="<?php echo $row['id_alquiler']; ?>" placeholder='ID Alquiler' required="required" readonly="readonly"/>
                    <br/>
                    <br/>
                    <label for='id_juego'>ID Juego</label>
                    <br/>
                    <input type='text' id='id_juego' class="redInput" name='id_juego' value="<?php echo $row['id_juego']; ?>" placeholder='ID Juego' required="required" readonly="readonly" />
                    <br/>
                    <br/>
                    <label for='titulo'>Titulo</label>
                    <br/>
                    <input type='text' id='title' class="redInput" name='title' value="<?php echo $row['titulo']; ?>" placeholder='Titulo' required="required" readonly="readonly" />
                    <br/>
                    <br/>
                    <label for='plataforma'>Plataforma</label>
                    <br/>
                    <input type='text' id='platform' class="redInput" name='platform' value="<?php echo $row['plataforma']; ?>" placeholder='Plataforma' required="required" readonly="readonly" />
                    <br/>
                    <br/>
                    <label for='estudio'>Estudio</label>
                    <br/>
                    <input type='text' id='studio' class="redInput" name='studio' value="<?php echo $row['estudio']; ?>" placeholder='Estudio' required="required" readonly="readonly" />
                    <br/>
                    <br/>
                    <label for='genero'>Género</label>
                    <br/>
                    <input type='text' id='genre' class="redInput" name='genre' value="<?php echo $row['genero']; ?>" placeholder='Género' required="required" readonly="readonly" />
                    <br/>
                    <br/>
                    <label for='date'>Fecha</label>
                    <br/>
                    <input type='date' id='date' name='date' value="<?php echo $row['fecha']; ?>" placeholder='Fecha' required="required" />
                    <br/>
                    <br/>
                    <label for='dni'>DNI</label>
                    <br/>
                    <input type='text' id='dni' class="redInput" name='dni' value="<?php echo $row['dni']; ?>" placeholder='DNI' required="required" readonly="readonly" />
                    <br/>
                    <br/>
                    <label for='id_ejemplar'>ID Ejemplar</label>
                    <br/>
                    <input type='text' id='id_ejemplar' class="redInput" name='id_ejemplar' value="<?php echo $row['id_ejemplar']; ?>" placeholder='ID Ejemplar' required="required" readonly="readonly" />
                    <br/>
                    <br/>
                    <button type='submit' id='edit' value='edit' name='edit'>Efectuar Cambios</button>
                    <button type='submit' id='delete' value='delete' name='delete'>Eliminar Alquiler</button>
                </form>

                <?php
                    //HTML - PHP
                } else {
                    $warnings = "<p class=\"advice warning\">No existe ningún alquiler con ese ID</p>";
                }
            }
        }

        $sql = "SELECT j.id_juego, j.titulo, j.plataforma, j.estudio, j.genero, a.fecha, a.dni, a.id_alquiler, a.id_ejemplar
                FROM juegos j, juegos_alquiler a, ejemplares e
                WHERE j.id_juego = e.id_juego
                AND e.id_ejemplar = a.id_ejemplar
                ORDER BY id_alquiler";
        $result = $conn->query($sql);
        $conn->close();

        if ($result->num_rows > 0) {
            //PHP-HTML
            ?>
            <table>
                <tr>
                    <th>ID Alquiler</th>
                    <th>ID Juego</th>
                    <th>Titulo</th>
                    <th>Plataforma</th>
                    <th>Estudio</th>
                    <th>Genero</th>
                    <th>Fecha</th>
                    <th>DNI</th>
                    <th>ID Ejemplar</th>
                </tr>
            <?php
            //HTML-PHP

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id_alquiler'] . "</td>";
                echo "<td>" . $row['id_juego'] . "</td>";
                echo "<td>" . $row['titulo'] . "</td>";
                echo "<td>" . $row['plataforma'] . "</td>";
                echo "<td>" . $row['estudio'] . "</td>";
                echo "<td>" . $row['genero'] . "</td>";
                echo "<td>" . $row['fecha'] . "</td>";
                echo "<td>" . $row['dni'] . "</td>";
                echo "<td>" . $row['id_ejemplar'] . "</td>";
                echo "</tr>";
            }
        } else {
            $warnings = "<p class=\"advice warning\">No hay ningún alquiler</p>";
        }

        echo $warnings;
        ?>
            </table>
        </section>
    </main>
    <footer>
        <?php require_once("src/funcs/footer.php"); ?> <!-- Require del footer -->
    </footer>
</body>
</html>
