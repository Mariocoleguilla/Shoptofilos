<?php

session_start(); //Inicio de la sesión
require_once("src/funcs/funcs.php"); //Se hace un require del archivo de funciones para utilizarlas en éste archivo
$conn = connection();

if (!isset($_SESSION["user"])) {
    header("Location: index.php");
}

if (isset($_POST['yes'])) {
    $sql = "UPDATE usuarios
            SET estado = 'Eliminado' WHERE dni = '" . $_SESSION['dni'] . "'";

    if ($conn->query($sql) === true) {
        header("Location: logout.php");
    } else {
        echo "
        <script type='text/javascript'>
            var error = '\$conn->error (Si deseas ver el error, modifica la variable error para mostrar \$conn->error)';
            console.log(\"Error al eliminar el usuario: \" + error);
        </script>
        ";
    }
}
if (isset($_POST['no'])) {
    header("Location: customer_accountManagement.php");
}

$conn->close();

?>
<!DOCTYPE html>
<html>

<head>
    <title>Eliminar Cuenta | Shoptófilos</title>
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
            <h1 class="pageTitle">Eliminar Cuenta</h1>
        </div>
        <section class="container">
        <p class="advice neutral">¿Estás seguro de que quieres eliminar tu cuenta?</p>
        <br/>
        <form id="form" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" autocomplete="off">
            <button type="submit" id="yes" value="yes" name="yes">Si</button>
            <button type="submit" id="no" value="no" name="no">No</button>
        </form>
        </section>
    </main>
    <footer>
        <?php require_once("src/funcs/footer.php"); ?> <!-- Require del footer -->
    </footer>
</body>

</html>
