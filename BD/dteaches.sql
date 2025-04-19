-- Criação da base de dados
CREATE DATABASE dteaches;
USE dteaches;

-- Tabela de utilizadores
CREATE TABLE users (
    username VARCHAR(20) UNIQUE NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    pass VARCHAR(30) NOT NULL,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de categorias
CREATE TABLE categoria (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(50) NOT NULL
);

-- Tabela de expressões (frases para aprender)
CREATE TABLE expressoes (
    id_expressao INT PRIMARY KEY AUTO_INCREMENT,
    versao_ingles TEXT NOT NULL,
    traducao_portugues TEXT NOT NULL,
    explicacao TEXT NOT NULL, -- Explicação obrigatória para todos os tipos de exercício
    id_categoria INT NOT NULL,
    tipo_exercicio ENUM('traducao', 'preenchimento', 'associacao') DEFAULT 'traducao',
    FOREIGN KEY (id_categoria) REFERENCES categoria(id_categoria)
);

-- Tabela de exemplos de uso
CREATE TABLE exemplos (
    id_exemplo INT PRIMARY KEY AUTO_INCREMENT,
    id_expressao INT NOT NULL,
    exemplo TEXT NOT NULL,
    FOREIGN KEY (id_expressao) REFERENCES expressoes(id_expressao)
);

-- Tabela de progresso do utilizador
CREATE TABLE progresso (
    username VARCHAR(20),
    id_expressao INT,
    completo BOOLEAN DEFAULT FALSE,
    data_conclusao DATETIME DEFAULT NULL,
    PRIMARY KEY (username, id_expressao),
    FOREIGN KEY (username) REFERENCES users(username),
    FOREIGN KEY (id_expressao) REFERENCES expressoes(id_expressao)
);

-- Tabela para exercícios de preenchimento de lacunas
CREATE TABLE exercicio_preenchimento (
    id_exercicio INT PRIMARY KEY AUTO_INCREMENT,
    id_expressao INT NOT NULL,
    texto_com_lacunas TEXT NOT NULL,
    palavras_chave TEXT NOT NULL, -- JSON array com palavras para preencher
    FOREIGN KEY (id_expressao) REFERENCES expressoes(id_expressao)
);

-- Tabela para exercícios de associação
CREATE TABLE exercicio_associacao (
    id_exercicio INT PRIMARY KEY AUTO_INCREMENT,
    id_expressao INT NOT NULL,
    itens_ingles TEXT NOT NULL, -- JSON array com itens em inglês
    itens_portugues TEXT NOT NULL, -- JSON array com itens em português
    FOREIGN KEY (id_expressao) REFERENCES expressoes(id_expressao)
);