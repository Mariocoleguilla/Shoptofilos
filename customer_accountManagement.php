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
        <section class="container-links container-edit off-white">
            <a href="customer_Edit.php">
                <h2>Editar datos</h2>
            </a>
            <a href="customer_passwordChange.php">
                <h2>Cambiar contraseña</h2>
            </a>
            <a href="customer_accountDelete.php">
                <h2>Eliminar cuenta</h2>
            </a>
            <?php echo $warnings; ?>
        </section>
    </main>
    <footer>
        <?php require_once("src/funcs/footer.php"); ?> <!-- Require del footer -->
    </footer>
</body>

</html>