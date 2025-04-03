CREATE DATABASE dteaches;

CREATE TABLE users (
    username VARCHAR(20) UNIQUE NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    pass VARCHAR(30) NOT NULL,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categoria (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(50) NOT NULL,
    conteudo TEXT NOT NULL
);

CREATE TABLE expressoes (
    id_expressao INT PRIMARY KEY AUTO_INCREMENT,
    versao_ingles TEXT NOT NULL,
    traducao_portugues TEXT NOT NULL,
    id_categoria INT NOT NULL,
    FOREIGN KEY (id_categoria) REFERENCES categoria(id_categoria)
);

CREATE TABLE progresso (
    username VARCHAR(20),
    id_expressao INT,
    completo BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (username, id_expressao),
    FOREIGN KEY (username) REFERENCES users(username),
    FOREIGN KEY (id_expressao) REFERENCES expressoes(id_expressao)
);