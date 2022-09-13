INSERT INTO categorias (id, descricao)
VALUES (1, 'Linha Branca');

INSERT INTO produtos (id, categoria_id, sku, estoque_atual, estoque_minimo, valor_compra, valor_venda, criacao_funcionario_id, atualizacao_funcionario_id, data_criacao, data_atualizacao)
VALUES (1, 1, 6, 2, '103456001', '2000.0', '2199.0', 7, 7, '2022-08-22 17:15:21', '2022-08-22 17:15:21'),
       (2, 1, 12, 2, '1023456002', '1600.0', '1799.0', 7, 7, '2022-08-22 18:12:33', '2022-08-22 18:12:33'),
       (3, 1, 16, 4, '1023456010', '760.0', '899.0', 7, 7, '2022-08-22 18:20:47', '2022-08-22 18:20:47'),
       (4, 1, 10, 4, '1023456021', '3099.0', '3599.0', 8, 7, '2022-08-23 16:10:11', '2022-08-23 16:10:11'),
       (5, 1, 12, 2, '1023456022', '6450.05', '6649.05', 8, 7, '2022-08-23 10:15:21', '2022-08-23 10:15:21'),
       (6, 1, 8, 2, '1023456023', '9100.0', '9499.0', 8, 7, '2022-08-23 11:15:21', '2022-08-23 11:15:21'),
       (7, 1, 12, 2, '1023456041', '8298.00', '8798.00', 7, 7, '2022-08-24 09:31:56', '2022-08-24 09:31:56'),
       (8, 1, 10, 4, '1023456042', '1730.00', '1989.00', 8, 7, '2022-08-24 10:01:13', '2022-08-24 10:01:13'),
       (9, 1, 5, 2, '1023456061', '9000.99', '9315.81', 9, 7, '2022-08-24 12:10:09', '2022-08-24 12:10:09'),
       (10, 1, 7, 1, '1023456066', '9100.20', '9393.20', 9, 7, '2022-08-25 14:29:47', '2022-08-25 14:29:47');

INSERT INTO produto_detalhes (produto_id, descricao, fabricante, codigo_barras, unidade_medida)
VALUES (1, 'Lavadora Brastemp BWK12AB', 'Brastemp', '10123456890178', 'Un'),
       (2, 'Lavadora de Roupas Electrolux 11Kg LES11 Essencial Care', 'Electrolux', '10123456890166', 'Un'),
       (3, 'Forno de Micro-ondas Electrolux MI41S - 31L', 'Electrolux', '0123456890156', 'Un'),
       (4, 'Refrigerador Electrolux Frost Free TF55 com Prateleira Reversível Branco', 'Electrolux', '10123456890131', 'Un'),
       (5, 'Refrigerador Electrolux Multidoor DM84X Frost Free com Ice Twister 579L', 'Electrolux', '10123456890156', 'Un'),
       (6, 'Refrigerador Samsung Inverter Frost Free RS50N Side by Side', 'Samsung', '10123456890112', 'Un'),
       (7, 'Refrigerador LG Side by Side Inverter GC-L257SLP Frost Free', 'LG', '10123456890141', 'Un'),
       (8, 'Fogão Brastemp 6 Bocas BFS6NCB', 'Brastemp', '10123456890133', 'Un'),
       (9, 'Fogão Don Bidone 6 Bocas Venâncio com Forno Baixa Pressão Fdb6f', 'Don Bidone', '10123456890111', 'Un'),
       (10, 'Refrigerador Brastemp Frost Free BRO80AB Side Inverse – 540L', 'Brastemp', '10123456890112', 'Un');