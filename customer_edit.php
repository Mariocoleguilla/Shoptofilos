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
    <title>Editar datos de cuenta | Shoptófilos</title>
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
            <h1 class="pageTitle">Editar datos de cuenta</h1>
        </div>            
        <section class="container">
            
            <?php

            if (!empty($_POST)) {

                    $dniRegExp = "/^[0-9]{8}[A-Z]{1}$/i";
                    $name_surnameRegExp = "/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]+( [A-ZÁÉÍÓÚÑ][a-záéíóúñ]+)*$/";
                    $homePhoneRegExp = "/^[9]{1}[0-9]{8}$/";
                    $mobilePhoneRegExp = "/^[6,7]{1}[0-9]{8}$/";
                
                    if (strlen($_POST['dni']) < 1 ||
                        strlen($_POST['name']) < 1 ||
                        strlen($_POST['surname1']) < 1 ||
                        strlen($_POST['surname2']) < 1 ||
                        strlen($_POST['phone']) < 1 ||
                        strlen($_POST['user']) < 1) {
                        $warnings = "<p class=\"advice warning\">Debes de rellenar todos los campos</p>";
                    } else {
                        if (!preg_match($dniRegExp, $_POST['dni'])) {
                            $warnings .= "<p class=\"advice warning\">Error en el DNI</p>";
                        }
                        if (!preg_match($name_surnameRegExp, $_POST['name'])) {
                            $warnings .= "<p class=\"advice warning\">Error en el nombre</p>";
                        }
                        if (!preg_match($name_surnameRegExp, $_POST['surname1'])) {
                            $warnings .= "<p class=\"advice warning\">Error en el primer apellido</p>";
                        }
                        if (!preg_match($name_surnameRegExp, $_POST['surname2'])) {
                            $warnings .= "<p class=\"advice warning\">Error en el segundo apellido</p>";
                        }
                        if ($warnings == "") {

                            if (preg_match($homePhoneRegExp, $_POST['phone']) || preg_match($mobilePhoneRegExp, $_POST['phone'])) {

                                $sql = "UPDATE usuarios SET dni = \"" . $_POST['dni'] . "\", nombre = \"" . $_POST['name'] . "\", apellido1 = \"" . $_POST['surname1'] . "\", apellido2 = \"" . $_POST['surname2'] . "\", telefono = \"" . $_POST['phone'] . "\", usuario = \"" . $_POST['user'] . "\" 
                                WHERE dni = \"" . $_SESSION['dni'] . "\"";
                                
                                if ($conn->query($sql) === true) {
                                    $warnings = "<p class=\"advice notice\">Actualización realizada con éxito</p>";
                                    $_SESSION['dni'] = $_POST['dni'];
                                } else {
                                    $warnings = "<p class=\"advice warning\">Formato de teléfono inválido</p>";
                                    echo "
                                    <script type='text/javascript'>
                                        var error = '\$conn->error (Si deseas ver el error, modifica la variable error para mostrar \$conn->error)';
                                        console.log(\"Error en la actualización de la tabla: \" + error);
                                    </script>
                                    ";
                                }

                        } else {
                            $warnings .= "<p class=\"advice warning\">Formato de teléfono inválido</p>";
                        }
                    }
                }

            echo $warnings;
        }

            $sql = "SELECT * FROM usuarios WHERE dni = \"" . $_SESSION['dni'] . "\"";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            }

            ?>

            <form id='form1' role='form' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method='POST' autocomplete='off'>
                <br/>
                <label for='dni'>DNI</label>
                <br/>
                <input type='text' id='dni' name='dni' value="<?php echo $row['dni']; ?>" placeholder='DNI' required="required"/>
                <br/>
                <br/>
                <label for='name'>Nombre</label>
                <br/>
                <input type='text' id='name' name='name' value="<?php echo $row['nombre']; ?>" placeholder='Nombre' required="required"/>
                <br/>
                <br/>
                <label for='surname1'>Apellido 1</label>
                <br/>
                <input type='text' id='surname1' name='surname1' value="<?php echo $row['apellido1']; ?>" placeholder='Apellido 1' required="required"/>
                <br/>
                <br/>
                <label for='surname2'>Apellido2</label>
                <br/>
                <input type='text' id='surname2' name='surname2' value="<?php echo $row['apellido2']; ?>" placeholder='Apellido 2' required="required"/>
                <br/>
                <br/>
                <label for='phone'>Teléfono</label>
                <br/>
                <input type='text' id='phone' name='phone' value="<?php echo $row['telefono']; ?>" placeholder='Teléfono' required="required"/>
                <br/>
                <br/>
                <label for='rol'>Rol</label>
                <br/>
                <input type='text' id='rol' class="redInput" name='rol' value="<?php echo $row['rol']; ?>" placeholder='Rol' required="required" readonly="readonly"/>
                <br/>
                <br/>
                <label for='id_tienda'>ID Tienda</label>
                <br/>
                <input type='text' id='id_tienda' class="redInput" name='id_tienda' value="<?php echo $row['id_tienda']; ?>" placeholder='ID Tienda' required="required" readonly="readonly" />
                <br/>
                <br/>
                <label for='user'>Usuario</label>
                <br/>
                <input type='text' id='user' name='user' value="<?php echo $row['usuario']; ?>" placeholder='Usuario' required="required"/>
                <br/>
                <br/>
                <label for='password'>Password (Encriptada)</label>
                <br/>
                <input type='text' id='passwordEdit' class="passwordInput redInput" name='password' value="<?php echo $row['password']; ?>" placeholder='Password' required="required" readonly="readonly"/>
                <br/>
                <br/>
                <button type='submit' id='edit' value='edit' name='edit'>Efectuar Cambios</button>
            </form>
        </section>
    </main>
    <footer>
        <?php require_once("src/funcs/footer.php"); ?> <!-- Require del footer -->
    </footer>
</body>

</html>