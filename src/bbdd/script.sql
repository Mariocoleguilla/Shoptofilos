CREATE DATABASE IF NOT EXISTS `shoptofilos` CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `shoptofilos`;

CREATE TABLE `tienda` (
    `id_tienda` INT(20) NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(30) NOT NULL,
    `provincia` VARCHAR(30) NOT NULL,
    `direccion` VARCHAR(100) NOT NULL,
    `telefono` INT(9) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    PRIMARY KEY(`id_tienda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `usuarios` (
    `dni` VARCHAR(9) NOT NULL,
    `nombre` VARCHAR(30) NOT NULL,
    `apellido1` VARCHAR(30) NOT NULL,
    `apellido2` VARCHAR(30) NOT NULL,
    `telefono` INT(9) NOT NULL,
    `rol` VARCHAR(50) NOT NULL,
    `id_tienda` INT(20) NOT NULL,
    `usuario` VARCHAR(30) NOT NULL,
    `password` VARCHAR(50) NOT NULL,
    PRIMARY KEY(`dni`,`usuario`),
    FOREIGN KEY(`id_tienda`)
        REFERENCES `tienda`(`id_tienda`)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `juegos` (
    `id_juego` INT(20) NOT NULL AUTO_INCREMENT,
    `titulo` VARCHAR(50) NOT NULL,
    `plataforma` VARCHAR(50) NOT NULL,
    `estudio` VARCHAR(50) NOT NULL,
    `genero` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id_juego`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `ejemplares` (
    `id_ejemplar` INT(20) NOT NULL AUTO_INCREMENT,
    `estado` VARCHAR(20) NOT NULL,
    `id_juego` INT(20) NOT NULL,
    PRIMARY KEY (`id_ejemplar`),
    FOREIGN KEY (`id_juego`)
        REFERENCES `juegos`(`id_juego`)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `juegos_venta` (
    `id_venta` INT(20) NOT NULL AUTO_INCREMENT,
    `dni` VARCHAR(9) NOT NULL,
    `fecha` DATE NOT NULL,
    `id_ejemplar` INT(10) NOT NULL,
    PRIMARY KEY(`id_venta`),
    FOREIGN KEY(`dni`)
        REFERENCES `usuarios`(`dni`)
        ON DELETE CASCADE,
    FOREIGN KEY(`id_ejemplar`)
        REFERENCES `ejemplares`(`id_ejemplar`)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `juegos_alquiler` (
    `id_alquiler` INT(20) NOT NULL AUTO_INCREMENT,
    `dni` VARCHAR(9) NOT NULL,
    `fecha` DATE NOT NULL,
    `id_ejemplar` INT(10) NOT NULL,
    PRIMARY KEY(`id_alquiler`),
    FOREIGN KEY(`dni`)
        REFERENCES `usuarios`(`dni`)
        ON DELETE CASCADE,
    FOREIGN KEY(`id_ejemplar`)
        REFERENCES `ejemplares`(`id_ejemplar`)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;