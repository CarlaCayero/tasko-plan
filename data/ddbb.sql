create database taskoplan;
use taskoplan;

create table usuario (
	id_usuario int primary key auto_increment,
    nombre varchar (50) not null,
    contrasenya varchar (255) not null,
    mail varchar (50) not null
);
create table proyecto (
	id_proyecto int primary key auto_increment,
    nombre varchar (50) not null,
    descripcion varchar (255) not null
);
create table rol (
	id_rol int primary key auto_increment,
    nombre varchar (50) not null
);
create table tipo (
	id_tipo int primary key auto_increment,
    nombre varchar (50) not null
);
create table estado (
	id_estado int primary key auto_increment,
    nombre varchar (50) not null
);
create table tarea (
	id_tarea int primary key auto_increment,
    titulo varchar (50) not null,
    fecha_inicio date,
    fecha_fin date,
    descripcion varchar (255) not null,
    id_usuario int,
    id_proyecto int,
    id_tipo int,
    id_estado int,
    
	constraint fk_tarea_usuario foreign key (id_usuario) references usuario (id_usuario),
    constraint fk_tarea_proyecto foreign key (id_proyecto) references proyecto (id_proyecto),
    constraint fk_tarea_tipo foreign key (id_tipo) references tipo (id_tipo),
    constraint fk_tarea_estado foreign key (id_estado) references estado (id_estado)
);

create table participar (
	id_usuario int,
    id_proyecto int,
    id_rol int,
    
    constraint pk_usuarios_proyecto primary key (id_usuario, id_proyecto),
    constraint fk_participar_usuario foreign key (id_usuario) references usuario (id_usuario),
    constraint fk_participar_proyecto foreign key (id_proyecto) references proyecto (id_proyecto),
	constraint fk_participar_rol foreign key (id_rol) references rol (id_rol)
);



