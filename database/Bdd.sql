/* =========================
BDD: bdd_quito
========================= */
    CREATE DATABASE IF NOT EXISTS `bdd_quito`
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;

    USE `bdd_quito`;

CREATE TABLE IF NOT EXISTS `ventas` (
    `id_ventas_quito` int(11) NOT NULL AUTO_INCREMENT,
    `ciudad` varchar(20) NOT NULL DEFAULT 'Quito',
    `fecha` date NOT NULL,
    `cliente` varchar(100) NOT NULL,
    `monto` decimal(10,2) NOT NULL,
    PRIMARY KEY (`id_ventas_quito`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


/* =========================
BDD: bdd_guayaquil
========================= */
    CREATE DATABASE IF NOT EXISTS `bdd_guayaquil`
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;

USE `bdd_guayaquil`;

CREATE TABLE IF NOT EXISTS `ventas` (
    `id_ventas_guayaquil` int(11) NOT NULL AUTO_INCREMENT,
    `ciudad` varchar(20) NOT NULL DEFAULT 'Guayaquil',
    `fecha` date NOT NULL,
    `cliente` varchar(100) NOT NULL,
    `monto` decimal(10,2) NOT NULL,
    PRIMARY KEY (`id_ventas_guayaquil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


/* =========================
BDD: bdd_cuenca
========================= */
    CREATE DATABASE IF NOT EXISTS `bdd_cuenca`
    DEFAULT CHARACTER SET latin1
    DEFAULT COLLATE latin1_swedish_ci;

USE `bdd_cuenca`;

CREATE TABLE IF NOT EXISTS `ventas` (
    `id_ventas_cuenca` int(11) NOT NULL AUTO_INCREMENT,
    `ciudad` varchar(20) NOT NULL DEFAULT 'Cuenca',
    `fecha` date NOT NULL,
    `cliente` varchar(100) NOT NULL,
    `monto` decimal(10,2) NOT NULL,
    PRIMARY KEY (`id_ventas_cuenca`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


/* =========================
BDD: bdd_central
========================= */
CREATE DATABASE IF NOT EXISTS `bdd_central`
DEFAULT CHARACTER SET utf8mb4
DEFAULT COLLATE utf8mb4_unicode_ci;

USE `bdd_central`;

CREATE TABLE IF NOT EXISTS `ventas` (
    `id_ventas` int(11) NOT NULL AUTO_INCREMENT,
    `ciudad` varchar(20) NOT NULL DEFAULT 'Central',
    `fecha` date NOT NULL,
    `cliente` varchar(100) NOT NULL,
    `monto` decimal(10,2) NOT NULL,
    PRIMARY KEY (`id_ventas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/* Vista global (según dump) */
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER
VIEW `vista_ventas_global` AS
    SELECT
        `q`.`id_ventas_quito` AS `id_ventas_quito`,
        `q`.`ciudad` AS `ciudad`,
        `q`.`fecha` AS `fecha`,
        `q`.`cliente` AS `cliente`,
        `q`.`monto` AS `monto`,
        'Quito' AS `origen_servidor`
    FROM `bdd_quito`.`ventas` AS `q`
UNION ALL
    SELECT
        `g`.`id_ventas_guayaquil` AS `id_ventas_guayaquil`,
        `g`.`ciudad` AS `ciudad`,
        `g`.`fecha` AS `fecha`,
        `g`.`cliente` AS `cliente`,
        `g`.`monto` AS `monto`,
        'Guayaquil' AS `origen_servidor`
    FROM `bdd_guayaquil`.`ventas` `g`
UNION ALL
    SELECT
        `c`.`id_ventas_cuenca` AS `id_ventas_cuenca`,
        `c`.`ciudad` AS `ciudad`,
        `c`.`fecha` AS `fecha`,
        `c`.`cliente` AS `cliente`,
        `c`.`monto` AS `monto`,
        'Cuenca' AS `origen_servidor`
    FROM `bdd_cuenca`.`ventas` `c`;
