CREATE DATABASE IF NOT EXISTS crud_php DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE crud_php;

-- Tabela Perfil
CREATE TABLE IF NOT EXISTS perfil (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
);

-- Tabela Usuario
CREATE TABLE IF NOT EXISTS usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil_id INT NOT NULL,
    FOREIGN KEY (perfil_id) REFERENCES perfil(id) ON DELETE RESTRICT
);

-- Tabela Categoria
CREATE TABLE IF NOT EXISTS categoria (
    cod INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

-- Tabela Produto
CREATE TABLE IF NOT EXISTS produto (
    cod INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    descricao TEXT,
    categoria INT NOT NULL,
    foto VARCHAR(255),
    FOREIGN KEY (categoria) REFERENCES categoria(cod) ON DELETE RESTRICT
);

-- Inserindo perfis básicos
INSERT INTO perfil (nome) VALUES ('Administrador'), ('Comum');

-- Inserindo usuário admin padrão (senha: admin123)
-- MD5 ou password_hash. No PHP usaremos password_hash, então vou inserir um hash real para "admin123" 
-- Usando bcrypt gerado previamente
INSERT INTO usuario (nome, email, senha, perfil_id) VALUES 
('Admin Default', 'admin@admin.com', '$2y$10$RliHQboi4DOelxZB7FEn2eNVTSKDq66apodwfit.l2vz3LjzVH3Qu', 1);
