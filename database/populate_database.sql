USE humanitae_db;

-- Populando tabela coordenador
INSERT INTO coordenador (nome_coordenador, sobrenome_coordenador, email_coordenador) VALUES
('Ana', 'Silva', 'ana.silva@humanitae.edu.br'),
('Carlos', 'Oliveira', 'carlos.oliveira@humanitae.edu.br'),
('Mariana', 'Costa', 'mariana.costa@humanitae.edu.br');

-- Populando tabela curso
INSERT INTO curso (nome_curso, horas_complementares, coordenador_curso) VALUES
('Engenharia de Software', 200, 1),
('Ciência da Computação', 180, 2),
('Sistemas de Informação', 150, 3);

-- Populando tabela aluno
INSERT INTO aluno (nome_aluno, sobrenome_aluno, email_aluno, cod_curso) VALUES
('João', 'Pereira', 'joao.pereira@aluno.humanitae.edu.br', 1),
('Lucas', 'Martins', 'lucas.martins@aluno.humanitae.edu.br', 2),
('Clara', 'Barbosa', 'clara.barbosa@aluno.humanitae.edu.br', 3);

-- Populando tabela disciplina
INSERT INTO disciplina (nome, descricao, cod_curso) VALUES
('Programação Orientada a Objetos', 'Aprenda os conceitos de POO', 1),
('Estruturas de Dados', 'Estudo de estruturas de dados avançadas', 2),
('Banco de Dados', 'Conceitos e práticas sobre bancos de dados', 3);

-- Populando tabela atividade_complementar
INSERT INTO atividade_complementar (titulo, descricao, caminho_anexo, horas_solicitadas, data, RA_aluno) VALUES
('Curso de Python', 'Curso online de Python para iniciantes', '/anexos/curso_python.pdf', 20, '2023-01-15', 1),
('Workshop de IA', 'Participação no workshop de Inteligência Artificial', '/anexos/workshop_ia.pdf', 15, '2023-02-20', 2),
('Seminário de TI', 'Seminário sobre novas tecnologias em TI', '/anexos/seminario_ti.pdf', 10, '2023-03-10', 3);

-- Populando curso_disciplina
INSERT INTO curso_disciplina (cod_curso, cod_disciplina) VALUES
(1, 1),
(2, 2),
(3, 3);

-- Populando curso_aluno
INSERT INTO curso_aluno (cod_curso, RA_aluno) VALUES
(1, 1),
(2, 2),
(3, 3);
