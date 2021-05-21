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
        <title>Administración de juegos | Shoptófilos</title>
        <?php require_once("src/funcs/head_meta.php"); ?> <!-- Require de los link, meta y script -->
    </head>

    <body>
        <header>
            <h1 class="mainTitle">Shoptófilos<span class="company">A Softófilos™ Company</span></h1>
            <p class="right">
                <label>Bienvenido
                    <?php echo $_SESSION['user'] ?>
                </label>
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
                <h1 class="pageTitle">Administración de juegos</h1>
            </div>
            <section class="container">
            <form id="form1" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" autocomplete="off">
                <button type="submit" id="edit1" name="edit1">Editar</button>
                <button type="submit" id="add" name="add">Añadir Juego</button>
            </form>
        <?php

if (!empty($_POST)) {

        if (isset($_POST['edit1'])) {

            ?>
            
            <form id="form2" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" autocomplete="off">
                <label for="id_juego">ID Juego</label>
                <br/>
                <input type="number" id="id_juego" name="id_juego" placeholder="ID Juego" required="required" />
                <br/>
                <br/>
                <button type="submit" id="query" name="query">Consultar</button>
            </form>

            <?php
        }

        if (isset($_POST['query'])) {

        $sql = "SELECT * FROM juegos WHERE id_juego = " . $_POST['id_juego'];
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            //PHP -HTML
            ?>
            <form id='form3' role='form' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method='POST' autocomplete='off'>
                <br/>
                <label for='id_juego2'>ID Juego</label>
                <br/>
                <input type='text' id='id_juego2' class="redInput" name='id_juego2' value="<?php echo $row['id_juego']; ?>" placeholder='ID Juego' required="required"
                    readonly="readonly" />
                <br/>
                <br/>
                <label for='titulo'>Titulo</label>
                <br/>
                <input type='text' id='title' name='title' value="<?php echo $row['titulo']; ?>" placeholder='Titulo' required="required"
                />
                <br/>
                <br/>
                <label for='plataforma'>Plataforma</label>
                <br/>
                <input type='text' id='platform' name='platform' value="<?php echo $row['plataforma']; ?>" placeholder='Plataforma' required="required"
                />
                <br/>
                <br/>
                <label for='estudio'>Estudio</label>
                <br/>
                <input type='text' id='studio' name='studio' value="<?php echo $row['estudio']; ?>" placeholder='Estudio' required="required"
                />
                <br/>
                <br/>
                <label for='genero'>Género</label>
                <br/>
                <input type='text' id='genre' name='genre' value="<?php echo $row['genero']; ?>" placeholder='Género' required="required"
                />
                <br/>
                <br/>
                <button type='submit' id='edit' value='edit' name='edit'>Efectuar Cambios</button>
            </form>
            <?php
    //HTML - PHP
        } else {
            $warnings = "<p class=\"advice warning\">No existe ningún juego con ése ID</p>";
        }
    }

    if (isset($_POST['edit'])) { //Comprobación del segundo formulario

        $title_platform_studio_genre_RegExp = "/^[A-Za-z0-9\s\-_'&\/,\.;:()]+$/";

        if (strlen($_POST['title']) < 1 ||
        strlen($_POST['platform']) < 1 ||
        strlen($_POST['studio']) < 1 ||
        strlen($_POST['genre']) < 1) {
            $warnings = "<p style=\"color: red\">Debes rellenar todos los campos</p>";
        } else {

            if (!preg_match($title_platform_studio_genre_RegExp, $_POST['title'])) {
                $warnings = "<p class=\"advice warning\">Título inválido</p>";
            } else if (!preg_match($title_platform_studio_genre_RegExp, $_POST['platform'])) {
                $warnings = "<p class=\"advice warning\">Nombre de plataforma inválido</p>";
            } else if (!preg_match($title_platform_studio_genre_RegExp, $_POST['studio'])) {
                $warnings = "<p class=\"advice warning\">Nombre de estudio inválido</p>";
            } else if (!preg_match($title_platform_studio_genre_RegExp, $_POST['genre'])) {
                $warnings = "<p class=\"advice warning\">Nombre de género inválido</p>";
            } else {
        
                $sql = "UPDATE juegos SET titulo = \"" . $_POST['title'] . "\", plataforma = \"" . $_POST['platform'] . "\", estudio = \"" . $_POST['studio'] . "\", genero = \"" . $_POST['genre'] . "\"
                WHERE id_juego = " . $_POST['id_juego2'];
            
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
    
    if (isset($_POST['remove'])) {
        $sql = "DELETE FROM juegos WHERE id_juego = " . $_POST['id_juego2'];
        
        if ($conn->query($sql) === true) {
            $warnings = "<p class=\"advice notice\">Registro eliminado con éxito</p>";
        } else {
            $warnings = "<p class=\"advice warning\">Error en la eliminación</p>";
            echo "
            <script type='text/javascript'>
                var error = '\$conn->error (Si deseas ver el error, modifica la variable error para mostrar \$conn->error)';
                console.log(\"Error en la eliminación: \" + error);
            </script>
            ";
        }
    }

    if (isset($_POST['add'])) {

        //PHP - HTML
        ?>

        <form id='form4' role='form' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method='POST' autocomplete='off'>
            <br/>
            <label for='titulo'>Titulo</label>
            <br/>
            <input type='text' id='title' name='title' placeholder='Titulo' required="required" />
            <br/>
            <br/>
            <label for='plataforma'>Plataforma</label>
            <br/>
            <input type='text' id='platform' name='platform' placeholder='Plataforma' required="required" />
            <br/>
            <br/>
            <label for='estudio'>Estudio</label>
            <br/>
            <input type='text' id='studio' name='studio' placeholder='Estudio' required="required" />
            <br/>
            <br/>
            <label for='genero'>Género</label>
            <br/>
            <input type='text' id='genre' name='genre' placeholder='Género' required="required" />
            <br/>
            <br/>
            <label for='copies'>Número de ejemplares a añadir</label>
            <br/>
            <input type='number' id='copies' name='copies' value="0" placeholder='Ejemplares' required="required" />
            <br/>
            <br/>
            <button type='submit' id='addGame' value='addGame' name='addGame'>Añadir Registro</button>
        </form>

        <?php
    }
    //HTML - PHP

    if (isset($_POST['addGame'])) {

        $title_platform_studio_genre_RegExp = "/^[A-Za-z0-9\s\-_'&\/,\.;:()]+$/";
        
        if (strlen($_POST['title']) < 1 ||
        strlen($_POST['platform']) < 1 ||
        strlen($_POST['studio']) < 1 ||
        strlen($_POST['genre']) < 1) {
            $warnings = "<p class=\"advice warning\">Debes de rellenar todos los campos</p>";
        } else {

            if (!preg_match($title_platform_studio_genre_RegExp, $_POST['title'])) {
                $warnings .= "<p class=\"advice warning\">Título inválido</p>";
            }
            if (!preg_match($title_platform_studio_genre_RegExp, $_POST['platform'])) {
                $warnings .= "<p class=\"advice warning\">Nombre de plataforma inválido</p>";
            }
            if (!preg_match($title_platform_studio_genre_RegExp, $_POST['studio'])) {
                $warnings .= "<p class=\"advice warning\">Nombre de estudio inválido</p>";
            }
            if (!preg_match($title_platform_studio_genre_RegExp, $_POST['genre'])) {
                $warnings .= "<p class=\"advice warning\">Nombre de género inválido</p>";
            } 
            if ($warnings == "") {

                $sql = "INSERT INTO juegos (titulo, plataforma, estudio, genero)
                            VALUES (\"" . $_POST['title'] . "\", \"" . $_POST['platform'] . "\", \"" . $_POST['studio'] . "\", \"" . $_POST['genre'] . "\")";
                if ($conn->query($sql) === true) {

                    $warnings .= "<p class=\"advice notice\">Registro añadido con éxito</p>";

                    $sql = "SELECT id_juego FROM juegos WHERE titulo = '" . $_POST['title'] . "' AND plataforma = '" . $_POST['platform'] . "'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                    
                        for ($i = 0; $i < $_POST['copies']; $i++) {
                            $sql = "INSERT INTO ejemplares (id_juego, estado)
                                    VALUES (". $row['id_juego'] . ", \"libre\")";
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
                    }

                    } else {
                        $warnings =  "<p class=\"advice warning\">Error en la inserción</p>";
                        echo "
                        <script type='text/javascript'>
                            var error = '\$conn->error (Si deseas ver el error, modifica la variable error para mostrar \$conn->error)';
                            console.log(\"Error en la inserción: \" + error);
                        </script>
                        ";
                    }
                }
            }
        }
        echo $warnings;
    }

$sql = "SELECT * FROM juegos";
$result = $conn->query($sql);
$conn->close();

if ($result->num_rows > 0) {
        //PHP-HTML
        ?>
        <table>
            <tr>
                <th>ID Juego</th>
                <th>Título</th>
                <th>Plataforma</th>
                <th>Estudio</th>
                <th>Género</th>
            </tr>
            <?php
        //HTML-PHP

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
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
                echo "<p class=\"advice warning\"No hay juegos</p>";
            }

    ?>
    </section>
    </main>
    <footer>
        <?php require_once("src/funcs/footer.php"); ?> <!-- Require del footer -->
    </footer>
</body>

</html>