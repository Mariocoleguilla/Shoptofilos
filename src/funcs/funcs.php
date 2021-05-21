<?php

function primaryConnection()
{

    $server = "localhost";
    $user = "root";
    $password = "";

    $conn = new mysqli($server, $user, $password);
        
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    echo "<script type='text/javascript'>console.log('Conexión realizada con éxito');</script>";

    return $conn;
}

function connection()
{

    $server = "localhost";
    $user = "root";
    $password = "";
    $dbname = "shoptofilos";

    $conn = new mysqli($server, $user, $password, $dbname);
        
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    echo "<script type='text/javascript'>console.log('Conexión realizada con éxito');</script>";

    return $conn;
}

function bbddCreation()
{

    $conn = primaryConnection();

    $sql = "CREATE DATABASE IF NOT EXISTS shoptofilos CHARACTER SET utf8 COLLATE utf8_spanish_ci;";
    if ($conn->query($sql) === true) {
        echo "<script type='text/javascript'>console.log('Base de datos creada con éxito');</script>";
    } else {
        echo "
        <script type='text/javascript'>
            var error = '\$conn->error (Si deseas ver el error, modifica la variable error para mostrar \$conn->error)';
            console.log(\"Error al crear la base de datos: \" + error);
        </script>
        ";
    }

    $conn->close();

    $conn = connection();

    $sql = array(
    "CREATE TABLE IF NOT EXISTS tienda (
            id_tienda INT(20) NOT NULL AUTO_INCREMENT,
            nombre VARCHAR(30) NOT NULL,
            provincia VARCHAR(30) NOT NULL,
            direccion VARCHAR(100) NOT NULL,
            telefono INT(9) NOT NULL,
            email VARCHAR(50) NOT NULL,
            PRIMARY KEY(id_tienda)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci",
    "CREATE TABLE IF NOT EXISTS usuarios (
            dni VARCHAR(9) NOT NULL,
            nombre VARCHAR(30) NOT NULL,
            apellido1 VARCHAR(30) NOT NULL,
            apellido2 VARCHAR(30) NOT NULL,
            telefono INT(9) NOT NULL,
            rol VARCHAR(50) NOT NULL,
            id_tienda INT(20) NOT NULL,
            usuario VARCHAR(30) NOT NULL,
            estado VARCHAR(20) NOT NULL,
            password VARCHAR(255) NOT NULL,
            PRIMARY KEY(dni),
            FOREIGN KEY(id_tienda)
                REFERENCES tienda(id_tienda)
                ON UPDATE CASCADE
                ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci",
    "CREATE TABLE IF NOT EXISTS juegos (
            id_juego INT(20) NOT NULL AUTO_INCREMENT,
            titulo VARCHAR(50) NOT NULL,
            plataforma VARCHAR(50) NOT NULL,
            estudio VARCHAR(50) NOT NULL,
            genero VARCHAR(50) NOT NULL,
            PRIMARY KEY (id_juego)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci",
    "CREATE TABLE IF NOT EXISTS ejemplares (
            id_ejemplar INT(20) NOT NULL AUTO_INCREMENT,
            estado VARCHAR(20) NOT NULL,
            id_juego INT(20) NOT NULL,
            PRIMARY KEY (id_ejemplar),
            FOREIGN KEY (id_juego)
                REFERENCES juegos(id_juego)
                ON UPDATE CASCADE
                ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci",
    "CREATE TABLE IF NOT EXISTS juegos_venta (
            id_venta INT(20) NOT NULL AUTO_INCREMENT,
            dni VARCHAR(9) NOT NULL,
            fecha DATE NOT NULL,
            id_ejemplar INT(10) NOT NULL,
            PRIMARY KEY(id_venta),
            FOREIGN KEY(dni)
                REFERENCES usuarios(dni)
                ON UPDATE CASCADE
                ON DELETE CASCADE,
            FOREIGN KEY(id_ejemplar)
                REFERENCES ejemplares(id_ejemplar)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci",
    "CREATE TABLE IF NOT EXISTS juegos_alquiler (
            id_alquiler INT(20) NOT NULL AUTO_INCREMENT,
            dni VARCHAR(9) NOT NULL,
            fecha DATE NOT NULL,
            id_ejemplar INT(10) NOT NULL,
            PRIMARY KEY(id_alquiler),
            FOREIGN KEY(dni)
                REFERENCES usuarios(dni)
                ON UPDATE CASCADE
                ON DELETE CASCADE,
            FOREIGN KEY(id_ejemplar)
                REFERENCES ejemplares(id_ejemplar)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci");

    for ($i = 0; $i < count($sql); $i++) {
        if ($conn->query($sql[$i]) === true) {
            echo "<script type='text/javascript'>console.log('Exito en la query');</script>";
        } else {
            echo "
            <script type='text/javascript'>
                var error = '\$conn->error (Si deseas ver el error, modifica la variable error para mostrar \$conn->error)';
                console.log(\"Error en la query: \" + error);
            </script>
            ";
        }
    }
    $conn->close();
}

function inserts()
{
    $conn = connection();

    $sql = "SELECT * FROM tienda";
    $result = $conn->query($sql);

    if ($result->num_rows < 1) {
        
        $sql = array(
        "INSERT INTO tienda(nombre, provincia, direccion, telefono, email)
            VALUES('Shoptófilos', 'Valladolid', 'Calle del Triunfo Nº12', '983000000', 'shoptofilos@softofilos.com')",
        "INSERT INTO usuarios(dni, nombre, apellido1, apellido2, telefono, rol, id_tienda, usuario, password, estado)
            VALUES('71188244R', 'Mario', 'Gañán', 'Fuentes', '630616523', 'Administrador', '1', 'admin', '$2y$10$.lch0tLhK4oh5YJ3iVzA2u2UmKbkIHlUMY5pSeqgHbt5tbwQFXGVW', 'Activo'),
              ('78965412D', 'Luis', 'Fernández', 'José', '654987321', 'Cliente', '1', 'luisito','$2y$10\$rxjw0FpbeVcVoFKUOxHOY.X9foZ2MJkYd05Zj/9F/KKTg.eutUNBm', 'Activo')",
        "INSERT INTO juegos(titulo, plataforma, estudio, genero)
            VALUES('Bioshock: Infinite', 'PC', 'Irrational Games/2K', 'Accion/Narrativo FPS'),
                  ('The Last of Us Remastered', 'PS4', 'Naughty Dog', 'Accion/Aventura TPS'),
                  ('Kingdom Hearts 1.5 HD ReMIX', 'PS3', 'SquareSoft', 'Action RPG'),
                  ('The Begginer\'s Guide', 'PC', 'William Pugh', 'Narrativo'),
                  ('Playerunknown\'s Battlegrounds', 'PC', 'Bluehole', 'MMOFPS'),
                  ('Super Mario Oddisey', 'Nintendo Switch', 'Nintendo', 'Plataformas 3D'),
                  ('Horizon Zero Dawn', 'PS4', 'Guerrilla Games', 'Aventura/Sandbox TPS'),
                  ('Minecraft Java Edition', 'PC', 'Mojang', 'Sandbox FP'),
                  ('FEZ', 'PS4', 'Phil Fish/Polytron', 'Plataformas/2D 3D'),
                  ('Dark Souls', 'PS3', 'From Software', 'Dark Souls/Accion TP'),
                  ('The Witcher 3', 'PC', 'CD Project Red', 'Aventura/Rol TP'),
                  ('Battlefield 1', 'PC', 'DICE/EA', 'Accion FPS'),
                  ('The Legend of Zelda: Breath of the Wild', 'Nintendo Switch', 'Nintendo', 'Aventura/Sandbox TPS')");
    
        for ($i = 0; $i < count($sql); $i++) {
            if ($conn->query($sql[$i]) === true) {
                echo "<script type='text/javascript'>console.log(\"Exito en la query\");</script>";
            } else {
                echo "
                <script type='text/javascript'>
                    var error = '\$conn->error (Si deseas ver el error, modifica la variable error para mostrar \$conn->error)';
                    console.log(\"Error en la query: \" + error);
                </script>
                ";
            }
        }

        for ($i = 1; $i < 14; $i++) {
            for ($j = 0; $j < 5; $j++) {
                $sql = "INSERT INTO ejemplares (id_juego, estado)
                            VALUES('$i', 'libre')";
                if ($conn->query($sql) === true) {
                    echo "<script type='text/javascript'>console.log(\"Exito en la query\");</script>";
                } else {
                    echo "
                    <script type='text/javascript'>
                        var error = '\$conn->error (Si deseas ver el error, modifica la variable error para mostrar \$conn->error)';
                        console.log(\"Error en la query: \" + error);
                    </script>
                    ";
                }
            }
        }

        $conn->close();
    }
}

function sale($id_ejemplar, $dni)
{
    $conn = connection();

    $sql = "UPDATE ejemplares SET estado='vendido' WHERE id_ejemplar = " . $id_ejemplar . "";
                
    if ($conn->query($sql) === true) {
        $sql = "INSERT INTO juegos_venta (dni, fecha, id_ejemplar)
                VALUES (\"" . $dni . "\", NOW(), \"" . $id_ejemplar . "\")";
        
        if ($conn->query($sql) === true) {
            $warnings = "<p class=\"advice notice\">Compra realizada con éxito</p>";
        } else {
            $warnings = "<p class=\"advice warning\">Error en la inserción de la fila</p>";
            echo "
                <script type='text/javascript'>
                    var error = '\$conn->error (Si deseas ver el error, modifica la variable error para mostrar \$conn->error)';
                    console.log(\"Error en la inserción de la fila: \" + error);
                </script>
            ";
        }
    } else {
        $warnings = "<p class=\"advice warning\">Error en la primera actualización</p>";
        echo "
        <script type='text/javascript'>
            var error = '\$conn->error (Si deseas ver el error, modifica la variable error para mostrar \$conn->error)';
            console.log(\"Error en la primera actualización: \" + error);
        </script>
    ";
    }
    $conn->close();
    return $warnings;
}

function rental($id_ejemplar, $dni)
{
    $conn = connection();
    $sql = "UPDATE ejemplares SET estado='alquilado' WHERE id_ejemplar = " . $id_ejemplar . "";
            
    if ($conn->query($sql) === true) {
        $sql = "INSERT INTO juegos_alquiler (dni, fecha, id_ejemplar)
                VALUES (\"" . $dni . "\", NOW(), \"" . $id_ejemplar . "\")";
    
        if ($conn->query($sql) === true) {
            $warnings = "<p class=\"advice notice\">Alquiler realizado con éxito</p>";
        } else {
            $warnings = "<p class=\"advice warning\">Error en la inserción de la fila</p>";
            echo "
            <script type='text/javascript'>
                var error = '\$conn->error (Si deseas ver el error, modifica la variable error para mostrar \$conn->error)';
                console.log(\"Error en la inserción de la fila: \" + error);
            </script>
            ";
        }
    } else {
        $warnings = "<p class=\"advice warning\">Error en la primera actualización</p>";
        echo "
        <script type='text/javascript'>
            var error = '\$conn->error (Si deseas ver el error, modifica la variable error para mostrar \$conn->error)';
            console.log(\"Error en la primera actualización: \" + error);
        </script>
        ";
    }
    $conn->close();
    return $warnings;
}

function login($user, $password, $dni) {

        $conn = connection();

        if (strlen($user) < 1 || strlen($password) < 1 || strlen($dni) < 1) {
            $warnings = "<p class=\"advice warning\">Rellena todos los campos</p>";
        } else {
            $sql = "SELECT * FROM usuarios WHERE usuario = '" . $user . "' AND dni = '" . $dni . "'";
            $result = $conn->query($sql);
            $conn->close();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                if ($row['estado'] == "Activo") {
    
                    if (password_verify($password, $row['password'])) {
                        $_SESSION['dni'] = $row['dni'];
                        $_SESSION['user'] = $row['usuario'];
                        $_SESSION['rol'] = $row['rol'];
                        header("location: user.php");
                    } else {
                        $warnings = "<p class=\"advice warning\">La contraseña no es correcta</p>";
                    }
                } else {

                    $warnings =  "<p class=\"advice warning\">Usuario eliminado</p>";
                }
            } else {
                $warnings =  "<p class=\"advice warning\">Ningún resultado</p>";
            }
        }
    
        return $warnings;
    }

function registry($name, $surname1, $surname2, $dni, $phone, $user, $password, $password2) {
    
        $conn = connection();
    
        $name_surnameRegExp = "/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ]+( [A-ZÁÉÍÓÚÑ][a-záéíóúñ]+)*$/";
        $dniRegExp = "/^[0-9]{8}[A-Z]{1}$/i";
        $homePhoneRegExp = "/^[9]{1}[0-9]{8}$/";
        $mobilePhoneRegExp = "/^[6,7]{1}[0-9]{8}$/";
        $passwordRegExp = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";
    
        if (strlen($name) < 1 ||
        strlen($surname1) < 1 ||
        strlen($surname2) < 1 ||
        strlen($dni) < 1 ||
        strlen($phone) < 1 ||
        strlen($user) < 1 ||
        strlen($password) < 1 ||
        strlen($password2) < 1) {
            $warnings = "<p style=\"color: red\">Debes de rellenar todos los campos</p>";
        } else {
            if (!preg_match($name_surnameRegExp, $name)) {
                $warnings = "<p class=\"advice warning\">Error en el nombre</p>";
            }
            if (!preg_match($name_surnameRegExp, $surname1)) {
                $warnings .= "<p class=\"advice warning\">Error en el primer apellido</p>";
            }
            if (!preg_match($name_surnameRegExp, $surname2)) {
                $warnings .= "<p class=\"advice warning\">Error en el segundo apellido</p>";
            }
            if (!preg_match($dniRegExp, $dni)) {
                $warnings .= "<p class=\"advice warning\">Error en el DNI</p>";
            }
            if (!preg_match($passwordRegExp, $password)) {
                $warnings .= "<p class=\"advice warning\">La contraseña debe de tener 8 caracteres y al menos 1 número</p>";
            } 
            if ($warnings == "") {
                if (preg_match($homePhoneRegExp, $phone) || preg_match($mobilePhoneRegExp, $phone)) {
                    if ($password != $password2) {
                        $warnings .= "<p class=\"advice warning\">Las contraseñas no coinciden</p>";
                    } else {
                        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    
                        $sql = "INSERT INTO usuarios (dni, nombre, apellido1, apellido2, telefono, rol, id_tienda, usuario, password, estado)
                                    VALUES (\"" . $dni . "\", \"" . $name . "\", \"" . $surname1 . "\", \"" . $surname2 . "\", \"" . $phone . "\", \"Cliente\", \"1\", \"" . $user . "\", \"$passwordHash\", \"Activo\")";
    
                        if ($conn->query($sql) === true) {
                            $warnings = "<p class=\"advice notice\">Usuario registrado con éxito</p>";
                        } else {
                            $warnings = "<p class=\"advice warning\">Error en la inserción</p>";
                            echo "
                            <script type='text/javascript'>
                                var error = '\$conn->error (Si deseas ver el error, modifica la variable error para mostrar \$conn->error)';
                                console.log(\"Error en la inserción: \" + error);
                            </script>
                            ";
                        }
    
                            $conn->close();
                    }
                } else {
                    $warnings .= "<p class=\"advice warning\">Formato de teléfono inválido</p>";
                }
            }
        }
    
    return $warnings;
}

function passwordChange($dni, $oldPassword, $newPassword, $verifyNewPassword) {
    
    $conn = connection();
    $passwordRegExp = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";

    if (strlen($oldPassword) < 1 ||
    strlen($newPassword) < 1 ||
    strlen($verifyNewPassword) < 1) {
        $warnings = "<p class=\"advice warning\">>Debes de rellenar todos los campos</p>";
    } else {
        
        if (!preg_match($passwordRegExp, $newPassword)) {
            $warnings = "<p class=\"advice warning\">La contraseña nueva no cumple los requisitos</p>";
        } elseif (!preg_match($passwordRegExp, $verifyNewPassword)) {
            $warnings = "<p class=\"advice warning\">La verificación de la contraseña nueva no cumple los requisitos</p>";
        } else {

            $sql = "SELECT * FROM usuarios WHERE dni = \"" . $dni . "\"";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($oldPassword, $row['password'])) {
                    if ($newPassword == $verifyNewPassword) {
                        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        
                        $sql = "UPDATE usuarios SET password = \"" . $passwordHash . "\" WHERE dni = \"" . $dni . "\"";
                        if ($conn->query($sql) === true) {
                            $warnings = "<p class=\"advice notice\">Contraseña cambiada con éxito</p>";
                        } else {
                            $warnings = "<p class=\"advice warning\">Error en la inserción</p>";
                            echo "
                            <script type='text/javascript'>
                                var error = '\$conn->error (Si deseas ver el error, modifica la variable error para mostrar \$conn->error)';
                                console.log(\"Error en la inserción: \" + error);
                            </script>
                            ";
                        }
            
                        $conn->close();
                    } else {
                        $warnings = "<p class=\"advice warning\">Las dos contraseñas no coinciden</p>";
                    }
                } else {
                    $warnings = "<p class=\"advice warning\">La contraseña antigüa no coincide</p>";
                }
            }
        }
    }
return $warnings;
}
?>