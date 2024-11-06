create database tarefas;

create table usuarios(
       usu_codigo int primary key auto_increment,
       usu_nome varchar(255),
       usu_email varchar(255)
);

create table tarefas(
       tar_codigo int primary key auto_increment,
       tar_setor varchar(255),
       tar_prioridade varchar(255),
       tar_status varchar(255)
);

alter table tarefas add column usu_codigo int,
add constraint fk_usu_codigo foreign key (usu_codigo) references usuarios(usu_codigo)