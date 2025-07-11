CREATE DATABASE dteaches;
USE dteaches;

CREATE TABLE users (
    username VARCHAR(20) UNIQUE NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    pass VARCHAR(30) NOT NULL,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    is_admin BOOLEAN DEFAULT FALSE  
);

CREATE TABLE categoria (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(50) NOT NULL
);

CREATE TABLE expressoes (
    id_expressao INT PRIMARY KEY AUTO_INCREMENT,
    versao_ingles TEXT NOT NULL,
    traducao_portugues TEXT NOT NULL,
    explicacao TEXT NOT NULL, 
    id_categoria INT NOT NULL,
    tipo_exercicio ENUM('traducao', 'preenchimento', 'associacao') DEFAULT 'traducao',
    FOREIGN KEY (id_categoria) REFERENCES categoria(id_categoria)
);

CREATE TABLE exemplos (
    id_exemplo INT PRIMARY KEY AUTO_INCREMENT,
    id_expressao INT NOT NULL,
    exemplo TEXT NOT NULL,
    FOREIGN KEY (id_expressao) REFERENCES expressoes(id_expressao)
);

CREATE TABLE progresso (
    username VARCHAR(20),
    id_expressao INT,
    completo BOOLEAN DEFAULT FALSE,
    data_conclusao DATETIME DEFAULT NULL,
    PRIMARY KEY (username, id_expressao),
    FOREIGN KEY (username) REFERENCES users(username),
    FOREIGN KEY (id_expressao) REFERENCES expressoes(id_expressao)
);

CREATE TABLE exercicio_preenchimento (
    id_exercicio INT PRIMARY KEY AUTO_INCREMENT,
    id_expressao INT NOT NULL,
    texto_com_lacunas TEXT NOT NULL,
    palavras_chave TEXT NOT NULL, 
    FOREIGN KEY (id_expressao) REFERENCES expressoes(id_expressao)
);

CREATE TABLE exercicio_associacao (
    id_exercicio INT PRIMARY KEY AUTO_INCREMENT,
    id_expressao INT NOT NULL,
    itens_ingles TEXT NOT NULL,
    itens_portugues TEXT NOT NULL, 
    FOREIGN KEY (id_expressao) REFERENCES expressoes(id_expressao)
);