<?php

session_start(); //Inicio de la sesión
require_once("src/funcs/funcs.php"); //Se hace un require del archivo de funciones para utilizarlas en éste archivo

if (!isset($_SESSION["user"])) { //Se comprueba si hay una sesión iniciada, en cuyo caso contrario se envía al index
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Área del usuario | Shoptófilos</title>
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
            <a id="logOut" class="menuButton" href="logout.php">Cerrar Sesión</a>
        </div>
    </header>
    <main>
        <div class="pageTitleContainer">
            <h1 class="pageTitle">Área del usuario</h1>
        </div>
        <section class="container-links container-user off-white">
            <?php
            if ($_SESSION['rol'] == 'Administrador') { //Se evalúa si la variable de sesión rol propagada es administrador o usuario
                //PHP -HTML
                ?>

                <a href="admin_gamesManagement.php">
                    <h2>Gestionar Juegos</h2>
                </a>
                <a href="admin_salesManagement.php">
                    <h2>Gestionar Ventas</h2>
                </a>
                <a href="admin_rentsManagement.php">
                    <h2>Gestionar Alquileres</h2>
                </a>
                <a href="admin_copiesManagement.php">
                    <h2>Gestionar Ejemplares</h2>
                </a>
                <a href="admin_accountManagement.php">
                    <h2>Gestionar Usuarios</h2>
                </a>
                <?php
                //HTML - PHP
            } else {
                //PHP -HTML
                ?>

                <a href="customer_gamesQuery.php">
                    <h2>Adquirir Juegos</h2>
                </a>
                <a href="customer_sales.php">
                    <h2>Ver mis Compras</h2>
                </a>
                <a href="customer_rents.php">
                    <h2>Ver mis Alquileres</h2>
                </a>
                <a href="customer_accountManagement.php">
                    <h2>Editar datos de cuenta</h2>
                </a>
                <?php
                //HTML - PHP
            }
            ?>
        </section>
    </main>
    <footer>
        <?php require_once("src/funcs/footer.php"); ?> <!-- Require del footer -->
    </footer>
</body>

</html>
