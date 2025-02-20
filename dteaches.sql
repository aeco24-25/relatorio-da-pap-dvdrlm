CREATE DATABASE dteaches;

CREATE TABLE users (
    username VARCHAR(10) UNIQUE NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    pass VARCHAR(20) NOT NULL,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE licoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(50) NOT NULL,
    conteudo VARCHAR(100) NOT NULL,
);

CREATE TABLE expressoes (
    id_expressao INT PRIMARY KEY AUTO_INCREMENT,
    id_categoria INT,
    ingles VARCHAR(255),
    traducao VARCHAR(255),
    arquivo_audio VARCHAR(255),
    FOREIGN KEY (id_categoria) REFERENCES Categorias(id_categoria)
);

CREATE TABLE Aulas (
    id_aula INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(255),
    id_categoria INT,
    conteudo TEXT,
    FOREIGN KEY (id_categoria) REFERENCES Categorias(id_categoria)
);

CREATE TABLE progresso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aula_id INT,
    status ENUM('não iniciado', 'em andamento', 'concluído') NOT NULL,
    FOREIGN KEY(aula_id) REFERENCES licoes(id)
);
