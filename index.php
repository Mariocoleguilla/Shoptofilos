<?php

session_start(); //Inicio de la sesión
require_once("src/funcs/funcs.php"); //Se hace un require del archivo de funciones para utilizarlas en éste archivo
bbddCreation(); //Llamada a la función de la construcción de la base de datos
inserts(); //Llamada a la función de las inserciones en la base de datos

if (isset($_SESSION["user"])) { //Si existe un inicio de sesión, se monstrará el botón del área de usuario y una bienvenida personalizada
    $button = "<a id=\"user\" class=\"menuButton\" href=\"user.php\">Área del usuario</a>";
    $welcome = $_SESSION['user'];
} else { //En el caso contrario se muestra el botón para iniciar sesión o registrarse, y la bienvenida como Invitado
    $button = "<a id=\"login\" class=\"menuButton\" href=\"login.php\">Iniciar Sesión/Registrarse</a>";
    $welcome = "Invitado";
}

?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Index | Shoptófilos</title>
        <?php require_once("src/funcs/head_meta.php"); ?> <!-- Require de los link, meta y script -->
    </head>

    <body>
        <header>
        <h1 class="mainTitle">Shoptófilos<span class="company">A Softófilos™ Company</span></h1>
            <p class="right">
                <label>Bienvenido
                    <?php echo $welcome ?> <!-- Impresión del mensaje de bienvenida -->
                </label>
            </p>
            <div class="menuButtonContainer">
                <a href="index.php" class="menuButton">Inicio</a>
            </div>
            <div class="menuButtonContainer">
                <?php echo $button ?>
            </div>
        </header>
        <main>
            <div class="pageTitleContainer">
                <h1 class="pageTitle">Index</h1>
            </div>
        </main>
        <footer>
            <?php require_once("src/funcs/footer.php"); ?> <!-- Require del footer -->
        </footer>
    </body>

    </html>