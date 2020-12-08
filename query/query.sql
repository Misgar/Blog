#create database blog;
use blog;

CREATE TABLE usuarios(
	id int not null primary key auto_increment,
    nome varchar(50) not null,
    email varchar(250) not null,
    senha varchar(255) not null
    );
CREATE TABLE post(
	id int not null auto_increment,
    titulo varchar(255) not null,
    usuario_id int(11) not null,
    data_criacao datetime not null default now(),
    data_postagem datetime not null,
    primary key (id),
		INDEX fk_post_1_idx (usuario_id ASC),
		CONSTRAINT fk_post_1 FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id)
        # -- RESTRIÇÕES CASO TENTE APAGAR OU ATUALIZAR IDS
        ON DELETE RESTRICT
        ON UPDATE RESTRICT
	);
    
    # --	--	--
    ALTER TABLE usuarios ADD COLUMN data_criacao datetime default now() NOT NULL;
    ALTER TABLE usuarios ADD COLUMN ativo boolean NOT NULL DEFAULT 0;
    ALTER TABLE usuarios ADD COLUMN adm boolean NOT NULL DEFAULT 0;
    
        

