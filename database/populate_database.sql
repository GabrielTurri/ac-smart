USE `humanitae_db`;

-- Inserir dados na tabela coordenador
INSERT INTO `coordenador` (`nome_coordenador`, `sobrenome_coordenador`, `email_coordenador`, `senha_coordenador`) VALUES
('João', 'Silva', 'joao.silva@humanitae.br', 'senhavazia'),
('Maria', 'Oliveira', 'maria.oliveira@humanitae.br', 'senhavazia'),
('Carlos', 'Santos', 'carlos.santos@humanitae.br', 'senhavazia'),
('Fernanda', 'Almeida', 'fernanda.almeida@humanitae.br', 'senhavazia'),
('Ricardo', 'Pereira', 'ricardo.pereira@humanitae.br', 'senhavazia'),
('Patrícia', 'Lima', 'patricia.lima@humanitae.br', 'senhavazia'),
('Roberto', 'Gomes', 'roberto.gomes@humanitae.br', 'senhavazia'),
('Juliana', 'Ferreira', 'juliana.ferreira@humanitae.br', 'senhavazia'),
('Marcelo', 'Rodrigues', 'marcelo.rodrigues@humanitae.br', 'senhavazia'),
('Luciana', 'Martins', 'luciana.martins@humanitae.br', 'senhavazia');

-- Inserir dados na tabela curso
INSERT INTO `curso` (`nome_curso`, `horas_complementares`, `coordenador_curso`) VALUES
('História', 200, 1),
('Filosofia', 180, 2),
('Sociologia', 160, 3),
('Psicologia', 220, 4),
('Letras', 200, 5),
('Pedagogia', 180, 6),
('Geografia', 160, 7),
('Antropologia', 200, 8),
('Ciências Sociais', 180, 9),
('Serviço Social', 160, 10);

-- Inserir dados na tabela aluno
INSERT INTO `aluno` (`nome_aluno`, `sobrenome_aluno`, `email_aluno`, `cod_curso`, `senha_aluno`) VALUES
('Ana', 'Pereira', 'ana.pereira@humanitae.br', 1, 'senhavazia'),
('Bruno', 'Costa', 'bruno.costa@humanitae.br', 2, 'senhavazia'),
('Carla', 'Mendes', 'carla.mendes@humanitae.br', 3, 'senhavazia'),
('Daniel', 'Souza', 'daniel.souza@humanitae.br', 4, 'senhavazia'),
('Eduarda', 'Silva', 'eduarda.silva@humanitae.br', 5, 'senhavazia'),
('Felipe', 'Oliveira', 'felipe.oliveira@humanitae.br', 6, 'senhavazia'),
('Gabriela', 'Santos', 'gabriela.santos@humanitae.br', 7, 'senhavazia'),
('Henrique', 'Lima', 'henrique.lima@humanitae.br', 8, 'senhavazia'),
('Isabela', 'Gomes', 'isabela.gomes@humanitae.br', 9, 'senhavazia'),
('João', 'Ferreira', 'joao.ferreira@humanitae.br', 10, 'senhavazia');

-- Inserir dados na tabela atividade_complementar
INSERT INTO `atividade_complementar` (`titulo`, `descricao`, `caminho_anexo`, `horas_solicitadas`, `data`, `status`, `horas_aprovadas`, `RA_aluno`) VALUES
('Participação em Workshop', 'Participação em workshop sobre novas metodologias de ensino na área de História.', '/uploads/workshop_historia.pdf', 10, '2023-05-01', 'Aprovado', 10, 1),
('Projeto de Pesquisa', 'Desenvolvimento de pesquisa sobre a influência da filosofia grega na sociedade contemporânea.', '/uploads/pesquisa_filosofia.pdf', 20, '2023-06-15', 'Pendente', 0, 2),
('Curso Online', 'Curso online sobre técnicas de análise sociológica.', '/uploads/curso_sociologia.pdf', 15, '2023-07-20', 'Reprovado', 0, 3),
('Seminário Internacional', 'Participação em seminário internacional sobre psicologia comportamental.', '/uploads/seminario_psicologia.pdf', 25, '2023-08-10', 'Aprovado', 25, 4),
('Publicação de Artigo', 'Publicação de artigo sobre a importância da literatura na formação crítica.', '/uploads/artigo_letras.pdf', 30, '2023-09-05', 'Pendente', 0, 5),
('Voluntariado', 'Atuação como voluntário em projeto de alfabetização de adultos.', '/uploads/voluntariado_pedagogia.pdf', 20, '2023-10-12', 'Aprovado', 20, 6),
('Pesquisa de Campo', 'Pesquisa de campo sobre a geografia urbana e seus impactos sociais.', '/uploads/pesquisa_geografia.pdf', 15, '2023-11-18', 'Reprovado', 0, 7),
('Estágio', 'Estágio em instituição de pesquisa antropológica.', '/uploads/estagio_antropologia.pdf', 40, '2023-12-01', 'Aprovado', 40, 8),
('Participação em Congresso', 'Participação em congresso sobre ciências sociais e políticas públicas.', '/uploads/congresso_ciencias_sociais.pdf', 20, '2024-01-15', 'Pendente', 0, 9),
('Projeto Comunitário', 'Desenvolvimento de projeto comunitário voltado ao serviço social.', '/uploads/projeto_servico_social.pdf', 25, '2024-02-20', 'Aprovado', 25, 10);

-- Inserir dados na tabela curso_aluno
INSERT INTO `curso_aluno` (`cod_curso`, `RA_aluno`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10);

-- Inserir dados na tabela disciplina
INSERT INTO `disciplina` (`nome`, `descricao`, `cod_curso`) VALUES
('História Antiga', 'Estudo das civilizações antigas e suas contribuições para o mundo moderno.', 1),
('Filosofia Moderna', 'Análise das principais correntes filosóficas modernas e seus pensadores.', 2),
('Teoria Sociológica', 'Exploração das teorias sociológicas clássicas e contemporâneas.', 3),
('Psicologia do Desenvolvimento', 'Estudo dos processos de desenvolvimento humano ao longo da vida.', 4),
('Literatura Brasileira', 'Análise das obras e autores mais importantes da literatura brasileira.', 5),
('Didática', 'Estudo das metodologias e práticas de ensino.', 6),
('Geografia Humana', 'Análise das interações entre sociedade e espaço geográfico.', 7),
('Antropologia Cultural', 'Estudo das culturas humanas e suas manifestações.', 8),
('Política e Sociedade', 'Análise das relações entre política e sociedade.', 9),
('Serviço Social e Políticas Públicas', 'Estudo das políticas públicas e sua relação com o serviço social.', 10);

-- Inserir dados na tabela curso_disciplina
INSERT INTO `curso_disciplina` (`cod_curso`, `cod_disciplina`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10);

-- Inserir dados na tabela observacao_atividade
INSERT INTO `observacao_atividade` (`observacao`, `cod_atividade`) VALUES
('Atividade bem executada, com participação ativa e relevante.', 1),
('Necessita de revisão para maior aprofundamento teórico.', 2),
('Documentação incompleta, faltam anexos importantes.', 3),
('Excelente participação, contribuiu significativamente para o evento.', 4),
('Artigo bem escrito, mas precisa de revisão gramatical.', 5),
('Voluntariado realizado com sucesso, atingiu todos os objetivos.', 6),
('Pesquisa de campo não apresentou resultados conclusivos.', 7),
('Estágio bem avaliado, com feedback positivo da instituição.', 8),
('Participação ativa no congresso, com apresentação de trabalho.', 9),
('Projeto comunitário bem desenvolvido, com impacto positivo na comunidade.', 10);