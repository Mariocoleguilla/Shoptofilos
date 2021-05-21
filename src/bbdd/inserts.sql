INSERT INTO `tienda`(`nombre`, `provincia`, `direccion`, `telefono`, `email`)
    VALUES("Shoptófilos", "Valladolid", "Calle del Triunfo Nº12", "983000000", "shoptofilos@softofilos.com");
INSERT INTO `usuarios`(`dni`, `nombre`, `apellido1`, `apellido2`, `telefono`, `rol`, `id_tienda`, `usuario`, `password`)
    VALUES("71188244R", "Mario", "Gañán", "Fuentes", "630616523", "Administrador", "1", "admin", "$2y$10$r9om5vSLbD.l25QlEiSL9OEYzp7yVjWaN3ZNTR8SJZgqejE10j15W"),
          ("78965412D", "Luis", "Fernández", "José", "654987321", "Cliente", "1", "luisito","$2y$10$GeMngrGRS.qh2GeS368DWuzoWY5ydVLw7JI2qlC0h2Zv8dDRaW7oa");
INSERT INTO `juegos`(`titulo`, `plataforma`, `estudio`, `genero`)
    VALUES("Bioshock: Infinite", "PC", "Irrational Games 2K", "Accion FPS"),
          ("The Last of Us", "PS4", "Naughty Dog", "Accion TPS"),
          ("Kingdom Hearts 1.5 HD ReMIX", "PS3", "SquareSoft", "Action RPG"),
          ("The Begginer's Guide", "PC", "William Pugh", "Narrativo"),
          ("Playerunknows's Battlegrounds", "PC", "Bluehole", "MMOFPS");
INSERT INTO `ejemplares` (`id_juego`, `estado`)
    VALUES("1", "libre"), ("1", "libre"), ("1", "libre"), ("1", "libre"), ("1", "libre"), ("2", "libre"), ("2", "libre"), ("2", "libre"), ("2", "libre"), ("2", "libre"),
    ("3", "libre"), ("3", "libre"), ("3", "libre"), ("3", "libre"), ("3", "libre"), ("4", "libre"), ("4", "libre"), ("4", "libre"), ("4", "libre"), ("4", "libre"),
    ("5", "libre"), ("5", "libre"), ("5", "libre"), ("5", "libre"), ("5", "libre");