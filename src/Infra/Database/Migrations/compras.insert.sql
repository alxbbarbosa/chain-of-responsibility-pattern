INSERT INTO fornecedores (id, razao_social, fantasia, cnpj)
VALUES (1, 'SUPER LINHA BRANCA EXPRESS LTDA', 'SUPER LINHA BRANCA EXPRESS', '77.485.301/0001-87'),
       (2, 'MASTER REFRIGERADORES LTDA', 'MASTER REFRIGERADORES', '51.764.598/0001-26'),
       (3, 'FUTURA REFRIGERADORES E FOGÕES LTDA', 'FUTURA REFRIGERADORES E FOGÕES', '48.557.224/0001-25'),
       (4, 'ANTONIO S. B. A. MARQUES ME', 'ALL FOR COOKING LINHA BRANCA', '58.551.267/0001-57');

INSERT INTO fornecedor_telefones (id, fornecedor_id, ddd, numero, ramal, contato, descricao)
VALUES (1, 1, '11', '4321-1234', '1234', 'Fábio', 'contato principal'),
       (2, 2, '11', '3333-1111', '22', 'Maiara', 'Maiara ou Janaína'),
       (3, 3, '11', '2222-1111', '12', 'Sheila', 'atende também logística reversa'),
       (4, 4, '12', '5550-0001', '166', 'José Antônio', '');

INSERT INTO fornecedor_emails (id, fornecedor_id, email, contato, descricao)
VALUES (1, 1, 'superexpress@supervendas.xpto.com', 'Fábio', ''),
       (2, 2, 'vendas@master.xpto.com', 'Maiara', ''),
       (3, 3, 'vendas@furura.sp.xpto.com', 'Sheila', ''),
       (4, 4, 'jose_antonio@all.xpto.com', 'José Antônio', '');

INSERT INTO estados (id, sigla, nome)
VALUES (1, 'SP', 'São Paulo');

INSERT INTO cidades (id, estado_id, nome)
VALUES (1, 1, 'São José do Rio Preto'),
       (2, 1, 'Barueri'),
       (3, 1, 'Itapevi');

INSERT INTO bairros (id, estado_id, cidade_id, nome)
VALUES (1, 1, 1, 'Distrito Industrial Doutor Carlos Arnaldo e Silva'),
       (2, 1, 2, 'Centro Empresarial Tamboré'),
       (3, 1, 3, 'Polo Industrial');

INSERT INTO logradouro (id, estado_id, cidade_id, bairro_id, cep, logradouro)
VALUES (1, 1, 1, 1, '15052-710', 'Rua Herminio Facio'),
       (2, 1, 2, 2, '06460-915', 'Avenida Tamboré'),
       (3, 1, 3, 3, '06693-810', 'Rua João Dias Ribeiro');

INSERT INTO fornecedor_enderecos (id, fornecedor_id, logradouro_id, estado_id, cidade_id, bairro_id, numero, apartamento, complemento, descricao)
VALUES (1, 1, 1, 1, 1, 1,'123', '', '', ''),
       (2, 2, 2, 1, 2, 2, '4321', '', '', ''),
       (3, 3, 2, 1, 2, 2, '1234', '', '', ''),
       (4, 4, 3, 1, 3, 3, 'S/N', '', '', '');

-- AINDA Não
INSERT INTO orcamentos (status, func_solicitante_id, fornecedor_id, func_aprovador_id, data_atualizacao, data_criacao)
VALUES (1, 1, 1, NULL, '2022-08-25 22:23:15', '2022-08-25 22:23:15');

INSERT INTO orcamento_itens (orcamento_id, produto_id, quantidade)
VALUES (1, 2, 10),
       (1, 6, 8),
       (1, 7, 2),
       (1, 9, 4);

INSERT INTO orcamentos (status, func_solicitante_id, fornecedor_id, func_aprovador_id, data_atualizacao, data_criacao)
VALUES (1, 2, 1, NULL, '2022-08-25 22:23:15', '2022-08-25 22:23:15');

INSERT INTO orcamento_itens (orcamento_id, produto_id, quantidade)
VALUES (2, 2, 10),
       (2, 6, 8),
       (2, 7, 2),
       (2, 9, 4);

INSERT INTO orcamentos (status, func_solicitante_id, fornecedor_id, func_aprovador_id, data_atualizacao, data_criacao)
VALUES (1, 3, 3, NULL, '2022-08-26 17:33:25', '2022-08-26 17:33:25');

INSERT INTO orcamento_itens (orcamento_id, produto_id, quantidade)
VALUES (3, 1, 2),
       (3, 3, 5),
       (3, 4, 2),
       (3, 8, 5);

INSERT INTO orcamentos (status, func_solicitante_id, fornecedor_id, func_aprovador_id, data_atualizacao, data_criacao)
VALUES (1, 2, 1, NULL, '2022-08-25 22:23:15', '2022-08-25 22:23:15');

INSERT INTO orcamento_itens (orcamento_id, produto_id, quantidade)
VALUES (4, 5, 5);

INSERT INTO orcamentos (status, func_solicitante_id, fornecedor_id, func_aprovador_id, data_atualizacao, data_criacao)
VALUES (1, 2, 3, NULL, '2022-08-30 14:20:25', '2022-08-30 14:20:25');

INSERT INTO orcamento_itens (orcamento_id, produto_id, quantidade)
VALUES (4, 2, 10),
       (4, 6, 55),
       (4, 7, 60),
       (4, 9, 40);

INSERT INTO orcamentos (status, func_solicitante_id, fornecedor_id, func_aprovador_id, data_atualizacao, data_criacao)
VALUES (1, 3, 3, NULL, '2022-08-28 10:39:11', '2022-08-28 10:39:11');

INSERT INTO orcamento_itens (orcamento_id, produto_id, quantidade)
VALUES (5, 2, 10),
       (5, 6, 8),
       (5, 7, 2),
       (5, 9, 4);
