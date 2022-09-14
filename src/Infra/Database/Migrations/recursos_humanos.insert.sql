INSERT INTO departamentos (id, nome)
VALUES (1, 'compras'),
       (2, 'comercial'),
       (3, 'logística'),
       (4, 'contabilidade'),
       (5, 'fiscal'),
       (6, 'financeiro');

INSERT INTO funcoes (id, nome)
VALUES (1, 'analista'),
       (2, 'técnico'),
       (3, 'auxiliar administrativo'),
       (4, 'desenvolvedor'),
       (5, 'comprador'),
       (6, 'vendedor'),
       (7, 'supervisor'),
       (8, 'gerente'),
       (9, 'diretor'),
       (10, 'presidente');

INSERT INTO funcionarios (id, nome, email, funcao_id, departamento_id)
VALUES (1, 'João A. Silva', 'joao.silva@corporativo.xpto.com', 7, 1),
       (2, 'Marcelo S. Souza', 'marcelo.souza@corporativo.xpto.com', 5, 1),
       (3, 'William F. Silva', 'william.silva@corporativo.xpto.com', 5, 1),
       (4, 'Geraldo A. Machado', 'geraldo.machado@corporativo.xpto.com', 8, 1),
       (5, 'Felipe B. Vieira', 'felipe.vieira@corporativo.xpto.com', 9, 1),
       (6, 'Marcio A. Oliveira', 'marcio.oliveira@corporativo.xpto.com', 8, 6),
       (7, 'Marcos C. Lopes', 'marcos.lopes@corporativo.xpto.com', 7, 2),
       (8, 'Regina A. Silva', 'regina.silva@corporativo.xpto.com', 6, 2),
       (9, 'Márcia E. Batista', 'marcia.batista@corporativo.xpto.com', 6, 2),
       (10, 'João P. Machado', 'joao.machado@corporativo.xpto.com', 8, 2),
       (11, 'Flávio A. Martins', 'flavio.martins@corporativo.xpto.com', 9, 2),
       (12, 'José M. Souza', 'jose.souza@corporativo.xpto.com', 7, 3),
       (13, 'Paulo S. Filho', 'paulo.filho@corporativo.xpto.com', 8, 3),
       (14, 'Silvia F. Ferreira', 'silvia.ferreira@corporativo.xpto.com', 8, 5),
       (15, 'Elaine A. Miranda', 'elaine.miranda@corporativo.xpto.com', 7, 5),
       (16, 'Pablo N. Ferdinande', 'pablo.ferdinande@corporativo.xpto.com', 9, 5),
       (17, 'Aldair F. Costa', 'aldair.costa@corporativo.xpto.com', 1, 4),
       (18, 'Everaldo C. Carvalho', 'everaldo.carvalho@corporativo.xpto.com', 7, 4),
       (19, 'Armando P. Coelho', 'everaldo.carvalho@corporativo.xpto.com', 8, 4),
       (20, 'Juliana M. Castro', 'juliana.castro@corporativo.xpto.com', 9, 6),
       (21, 'Mariana M. Dias', 'mariana.dias@corporativo.xpto.com', 1, 6),
       (22, 'Augusto B. Gonçalves', 'augusto.goncalves@corporativo.xpto.com', 10, 6);