<?php

session_start(); //Inicio de la sesión
require_once("src/funcs/funcs.php"); //Se hace un require del archivo de funciones para utilizarlas en éste archivo

$warnings = "";

if (!isset($_SESSION["user"])) {
    header("Location: index.php");
}

if (!empty($_POST)) {
    $warnings = passwordChange($_SESSION['dni'], $_POST['oldPassword'], $_POST['newPassword'], $_POST['verifyNewPassword']);
}


?>
<!DOCTYPE html>
<html>

<head>
    <title>Cambiar Contraseña | Shoptófilos</title>
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
        <h1 class="pageTitle">Cambiar Contraseña</h1>
    </div>
    <fieldset>
        <legend>Cambiar Contraseña</legend>
            <form id='form' role='form' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method='POST' autocomplete='off'>
                <br/>
                <input type='password' id='oldPassword' name='oldPassword' placeholder='Contraseña actual' required="required"/>
                <br/>
                <br/>
                <input type='password' id='newPassword' name='newPassword' placeholder='Nueva contraseña' required="required"/>
                <br/>
                <br/>
                <input type='password' id='verifyNewPassword' name='verifyNewPassword' placeholder='Repite la nueva contraseña' required="required"/>
                <br/>
                <br/>
                <div class="fullWidthButton">
                    <button type="submit" id="modify" value="modify" name="modify">Cambiar contraseña</button>
                </div>
            </form>
    <?php echo $warnings; ?>
    </fieldset
    </main>
    <footer>
        <?php require_once("src/funcs/footer.php"); ?> <!-- Require del footer -->
    </footer>
</body>

</html>
