CREATE DATABASE humanitae_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE humanitae_db;

-- Criação da tabela Coordenador
CREATE TABLE coordenador (
    cod_coordenador INT PRIMARY KEY AUTO_INCREMENT,
    nome_coordenador VARCHAR(50),
    sobrenome_coordenador VARCHAR(50),
    email_coordenador VARCHAR(60),
    senha_coordenador VARCHAR(255)
);

-- Criação da tabela Curso
CREATE TABLE curso (
    cod_curso INT PRIMARY KEY AUTO_INCREMENT,
    nome_curso VARCHAR(50),
    horas_complementares INT,
    coordenador_curso INT,
    FOREIGN KEY (coordenador_curso) REFERENCES coordenador(cod_coordenador)
);

-- Criação da tabela Aluno
CREATE TABLE aluno (
    RA_aluno INT PRIMARY KEY AUTO_INCREMENT,
    nome_aluno VARCHAR(50),
    sobrenome_aluno VARCHAR(50),
    email_aluno VARCHAR(60),
    senha_aluno VARCHAR(255),
    cod_curso INT,
    FOREIGN KEY (cod_curso) REFERENCES curso(cod_curso)
);

-- Criação da tabela Disciplina
CREATE TABLE disciplina (
    cod_disciplina INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(150),
    descricao TINYTEXT,
    cod_curso INT,
    FOREIGN KEY (cod_curso) REFERENCES curso(cod_curso)
);

-- Criação da tabela observação_atividade
CREATE TABLE observacao_atividade (
    cod_observacao INT PRIMARY KEY AUTO_INCREMENT,
    observacao TEXT
);

-- Criação da tabela Atividade_complementar
CREATE TABLE atividade_complementar (
    cod_atividade INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(150),
    descricao TINYTEXT,
    caminho_anexo VARCHAR(255),
    horas_solicitadas SMALLINT UNSIGNED,
    data DATE,
    status ENUM('Aprovado', 'Reprovado', 'Pendente') DEFAULT 'Pendente',
    horas_aprovadas SMALLINT DEFAULT 0,
    RA_aluno INT,
    cod_observacao_atividade INT,
    FOREIGN KEY (RA_aluno) REFERENCES aluno(RA_aluno),
    FOREIGN KEY (cod_observacao_atividade) REFERENCES observacao_atividade (cod_observacao)
);

-- Tabela de junção para Curso e Disciplina
CREATE TABLE curso_disciplina (
    cod_curso INT,
    cod_disciplina INT,
    PRIMARY KEY (cod_disciplina, cod_curso),
    FOREIGN KEY (cod_disciplina) REFERENCES disciplina(cod_disciplina),
    FOREIGN KEY (cod_curso) REFERENCES curso(cod_curso)
);

-- Tabela de junção para Curso e Aluno
CREATE TABLE curso_aluno (
    cod_curso INT,
    RA_aluno INT,
    PRIMARY KEY (cod_curso, RA_aluno),
    FOREIGN KEY (cod_curso) REFERENCES curso(cod_curso),
    FOREIGN KEY (RA_aluno) REFERENCES aluno(RA_aluno)
);