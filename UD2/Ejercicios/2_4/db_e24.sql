DROP  DATABASE IF EXISTS e_24;
CREATE DATABASE e_24;
USE e_24;

CREATE TABLE ROL(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(25) NOT NULL
);

CREATE TABLE USUARIO(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    contrasena CHAR(60) NOT NULL,
    rol_id INT NOT NULL,
    CONSTRAINT fk_usuario_rol FOREIGN KEY (rol_id) REFERENCES ROL(id)
);

CREATE TABLE PROYECTO(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(512),
    usuario_id INT NOT NULL,
    CONSTRAINT fk_proyecto_usuario FOREIGN KEY (usuario_id) REFERENCES USUARIO(id)
);

CREATE TABLE PROGRAMADOR_PROYECTO(
    usuario_id INT NOT NULL,
    proyecto_id INT NOT NULL,
    PRIMARY KEY(usuario_id, proyecto_id),
    CONSTRAINT fk_programador_proyecto_usuario FOREIGN KEY (usuario_id) REFERENCES USUARIO(id),
    CONSTRAINT fk_programador_proyecto_proyecto FOREIGN KEY (proyecto_id) REFERENCES PROYECTO(id)

);

CREATE TABLE PERMISO(
    id INT AUTO_INCREMENT PRIMARY KEY,
    pagina VARCHAR(100) NOT NULL
);

CREATE TABLE ROL_PERMISO(
    rol_id INT NOT NULL,
    permiso_id INT NOT NULL,
    PRIMARY KEY(rol_id, permiso_id),
    CONSTRAINT fk_rol_permiso_rol FOREIGN KEY(rol_id) REFERENCES ROL(id),
    CONSTRAINT fk_rol_permiso_permiso FOREIGN KEY(permiso_id) REFERENCES PERMISO(id)

);

INSERT INTO `ROL` (id, nombre) VALUES (NULL, 'Jefe');
INSERT INTO `ROL` (id, nombre) VALUES (NULL, 'Responsable');
INSERT INTO `ROL` (id, nombre) VALUES (NULL, 'Programador');

INSERT INTO `PERMISO`(`id`, `pagina`) VALUES (1,'ver_proyectos');
INSERT INTO `PERMISO`(`id`, `pagina`) VALUES (2,'editar_proyectos');
INSERT INTO `PERMISO`(`id`, `pagina`) VALUES (3,'administrar_proyectos');
INSERT INTO `PERMISO`(`id`, `pagina`) VALUES (4,'editar_proyecto');
INSERT INTO `PERMISO`(`id`, `pagina`) VALUES (5,'crear_proyecto');

INSERT INTO `ROL_PERMISO`(`rol_id`, `permiso_id`) VALUES (1, 3);
INSERT INTO `ROL_PERMISO`(`rol_id`, `permiso_id`) VALUES (1, 5);
INSERT INTO `ROL_PERMISO`(`rol_id`, `permiso_id`) VALUES (2, 2);
INSERT INTO `ROL_PERMISO`(`rol_id`, `permiso_id`) VALUES (2, 4);
INSERT INTO `ROL_PERMISO`(`rol_id`, `permiso_id`) VALUES (3, 1);