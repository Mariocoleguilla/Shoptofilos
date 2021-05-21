<?php

session_start(); //Inicio de la sesión
require_once("src/funcs/funcs.php"); //Se hace un require del archivo de funciones para utilizarlas en éste archivo

if (isset($_SESSION["user"])) {
    header("Location: user.php");
} //else innecesario

$warnings = "";

if (!empty($_POST)) { //Si se ha mandado el formulario se llama al método registry, almacenando las advertencias
    $warnings = registry($_POST['name'], $_POST['surname1'], $_POST['surname2'], $_POST['dni'], $_POST['phone'], $_POST['user'], $_POST['password'], $_POST['password2']);
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Registros | Shoptófilos</title>
    <?php require_once("src/funcs/head_meta.php"); ?> <!-- Require de los link, meta y script -->
</head>

<body>
    <header>
        <h1 class="mainTitle">Shoptófilos<span class="company">A Softófilos™ Company</span></h1>
        <p class="right">
            <label>Bienvenido Invitado</label>
        </p>
        <div class="menuButtonContainer">
            <a id="indexButton" class="menuButton" href="index.php">Inicio</a>
        </div>
        <div class="menuButtonContainer">
            <a id="login" class="menuButton" href="login.php">Iniciar Sesión</a>
        </div>
    </header>
    <main>
        <div class="pageTitleContainer">
            <h1 class="pageTitle">Registro</h1>
        </div>
        <fieldset> <!-- Formulario de registro -->
            <legend>Registro de usuario</legend>
            <form id="formRegistro" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" autocomplete="off">
                <br/>
                <input type="text" id="name" name="name" placeholder="Nombre" required="required" />
                <br/>
                <br/>
                <input type="text" id="surname1" name="surname1" placeholder="Primer Apellido" required="required" />
                <br/>
                <br/>
                <input type="text" id="surname2" name="surname2" placeholder="Segundo Apellido" required="required" />
                <br/>
                <br/>
                <input type="text" id="dni" name="dni" placeholder="DNI" required="required" />
                <br/>
                <br/>
                <input type="number" id="phone" name="phone" placeholder="Teléfono" required="required" />
                <br/>
                <br/>
                <input type="text" id="user" name="user" placeholder="Nombre de Usuario" required="required" />
                <br/>
                <br/>
                <input type="password" id="password" name="password" placeholder="Contraseña" required="required" />
                <br/>
                <br/>
                <input type="password" id="password2" name="password2" placeholder="Verifica la contraseña" required="required" />
                <br/>
                <br/>
                <br/>
                <div class="fullWidthButton">
                    <button type="submit" id="register" name="register">Registrarse</button>
                </div>
            </form>
            <?php echo $warnings ?>
            <p class="fieldsetParagraph">¿Ya tienes cuenta? Inicia sesión
                <a href="login.php">aquí</a>
            </p>
        </fieldset>
    </main>
    <footer>
        <?php require_once("src/funcs/footer.php"); ?> <!-- Require del footer -->
    </footer>
</body>

</html>