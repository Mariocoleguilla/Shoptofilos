<?php

session_start(); //Inicio de la sesión //Inicio de la sesión
require_once("src/funcs/funcs.php"); //Se hace un require del archivo de funciones para utilizarlas en éste archivo //Se hace un require del archivo de funciones para utilizarlas en éste archivo

if (isset($_SESSION["user"])) { //Si ya hay un usuario que ha iniciado sesión, se le redirige al área de usuario
    header("Location: user.php");
} //else innecesario, porque si no hay un usuario iniciado, directamente se ejecutará todo el archivo

$warnings = ""; //Se inicia la variable de los avisos para que sea global y todos los "isset" la puedan ver

if (!empty($_POST)) { //Se evalúa el envío del primer (y único) formulario
    
    $warnings = login($_POST['user'], $_POST['password'], $_POST['dni']); //Llamada a la función login, que devuelve avisos
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Login | Shoptófilos</title>
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
            <a id="registerButton" class="menuButton" href="registry.php">Registrarse</a>
        </div>
    </header>
    <main>
        <div class="pageTitleContainer">
            <h1 class="pageTitle">Inicio de sesión</h1>
        </div>
        <fieldset>
            <legend>Inicio de sesión</legend>
            <form id="form" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" autocomplete="off">
                <br/>
                <input type="text" id="user" name="user" placeholder="Nombre de Usuario" required="required"/>
                <br/>
                <br/>
                <input type="text" id="dni" name="dni" placeholder="DNI" required="required"/>
                <br/>
                <br/>
                <input type="password" id="password" name="password" placeholder="Contraseña"required="required" />
                <br/>
                <br/>
                <br/>
                <div class="fullWidthButton">
                    <button type="submit" id="login" name="login">Iniciar Sesión</button>
                </div>
            </form>
            <?php echo $warnings ?> <!-- Se muestran los avisos -->
            <p class="fieldsetParagraph">¿No tienes cuenta? Regístrate
                <a href="registry.php">aquí</a>
            </p>
        </fieldset>
    </main>
    <footer>
        <?php require_once("src/funcs/footer.php"); ?> <!-- Require del footer -->
    </footer>
</body>

</html>
