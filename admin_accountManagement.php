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
        <title>Administración de Usuarios | Shoptófilos</title>
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
                <h1 class="pageTitle">Administración de Usuarios</h1>
            </div>
            <section class="container">
                <form id="form1" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" autocomplete="off">
                    <label for="dni">DNI</label>
                    <br/>
                    <input type="text" id="dni" name="dni" placeholder="DNI" required="required" />
                    <br/>
                    <br/>
                    <button type="submit" id="remove" name="remove">Eliminar</button>
                    <button type="submit" id="reactivate" name="reactivate">Reactivar</button>
                    <br/>
                    <button type="submit" id="delete" name="delete">Eliminar de la Base de Datos</button>
                </form>

                <?php

        if (!empty($_POST)) {
            if (isset($_POST['remove'])) {

                $sql = "SELECT * FROM usuarios where dni = \"" . $_POST['dni'] . "\"";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    if ($row['estado'] == "Eliminado") {
                        $warnings = "<p class=\"advice warning\">El usuario ya está eliminado</p>";
                    } else {

                        $sql = "UPDATE usuarios SET estado = 'Eliminado' WHERE dni = '" . $_POST['dni'] . "'";
                        
                        if ($conn->query($sql) === true) {
                            
                            if ($_SESSION['dni'] == $_POST['dni']) {
                                
                                header("Location: logout.php");
                            } else {

                                $warnings = "<p class=\"advice notice\">Eliminación realizada con éxito</p>";
                            }
                        } else {
                            $warnings = "<p class=\"advice warning\">Error en la eliminación de la fila</p>";
                            echo "
                            <script type='text/javascript'>
                                var error = '\$conn->error (Si deseas ver el error, modifica la variable error para mostrar \$conn->error)';
                                console.log(\"Error en la eliminación de la fila: \" + error);
                            </script>
                            ";
                        }
                    }
                } else {
                    $warnings = "<p class=\"advice warning\">No existe ningún usuario con ese DNI</p>";
                }
            }

            if (isset($_POST['reactivate'])) {

                $sql = "SELECT * FROM usuarios where dni = \"" . $_POST['dni'] . "\"";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    if ($row['estado'] == "Activo") {
                        $warnings = "<p class=\"advice warning\">El usuario ya activo</p>";
                    } else {

                        $sql = "UPDATE usuarios SET estado = 'Activo' WHERE dni = '" . $_POST['dni'] . "'";
                        
                        if ($conn->query($sql) === true) {
                            $warnings = "<p class=\"advice notice\">Reactivación realizada con éxito</p>";
                        } else {
                            $warnings = "<p class=\"advice warning\">Error en la reactivación de la fila</p>";
                            echo "
                            <script type='text/javascript'>
                                var error = '\$conn->error (Si deseas ver el error, modifica la variable error para mostrar \$conn->error)';
                                console.log(\"Error en la reactivación: \" + error);
                            </script>
                            ";
                        }
                    }
                } else {
                    $warnings = "<p class=\"advice warning\">No existe ningún usuario con ese DNI</p>";
                }
            }

            if(isset($_POST['delete'])) {

            //PHP - HTML
            ?>
            <p class="advice neutral">!ATENCIÓN¡ Ésta acción eliminará el usuario y todas sus compras y alquileres de la base de datos de forma permanente, ¿está seguro?</p>
            <br/>
            <form id="form2" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" autocomplete="off">
                <button type="submit" id="yes" name="yes" value="<?php echo $_POST['dni'];?>">Si</button>
                <button type="submit" id="no" name="no">No</button>
            </form>

            <?php
            //HTML - PHP
            }

            if(isset($_POST['yes'])) {

                $sql = "SELECT * FROM usuarios where dni = \"" . $_POST['yes'] . "\"";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {

                    $sql = "DELETE FROM usuarios WHERE dni = \"" . $_POST['yes'] . "\"";
                        
                    if ($conn->query($sql) === true) {
                        
                        if ($_SESSION['dni'] == $_POST['yes']) {
                            
                            header("Location: logout.php");
                        } else {

                            $warnings = "<p class=\"advice notice\">Eliminación permanente realizada con éxito</p>";
                        }
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
                    $warnings = "<p class=\"advice warning\">No existe ningún usuario con ese DNI</p>";
                }
            }

            if(isset($_POST['no'])) {

                $warnings = "<p class=\"advice neutral\">Has cancelado la operación</p>";
            }

            echo $warnings;
        }
        //PHP - HTML
        ?>
            <table>
                <tr>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Apellido 1</th>
                    <th>Apellido 2</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th>ID Tienda</th>
                    <th>Usuario</th>
                    <th>Password (Encriptada)</th>
                    <th>Estado</th>
                </tr>
                <?php
        //HTML - PHP

        $sql = "SELECT * FROM usuarios";
        $result = $conn->query($sql);
        $conn->close();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['dni'] . "</td>";
                echo "<td>" . $row['nombre'] . "</td>";
                echo "<td>" . $row['apellido1'] . "</td>";
                echo "<td>" . $row['apellido2'] . "</td>";
                echo "<td>" . $row['telefono'] . "</td>";
                echo "<td>" . $row['rol'] . "</td>";
                echo "<td>" . $row['id_tienda'] . "</td>";
                echo "<td>" . $row['usuario'] . "</td>";
                echo "<td>" . $row['password'] . "</td>";
                echo "<td>" . $row['estado'] . "</td>";
                echo "</tr>";
            }
        } else {
            $warnings = "<p class=\"advice warning\">No existe ningún usuario con ese ID</p>";
        }
        //PHP -HTML
        ?>
            </table>
            </section>
        </main>
        <footer>
            <?php require_once("src/funcs/footer.php"); ?> <!-- Require del footer -->
        </footer>
    </body>

    </html>