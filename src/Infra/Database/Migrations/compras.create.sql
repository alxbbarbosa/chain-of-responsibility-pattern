CREATE TABLE IF NOT EXISTS fornecedores
(
    id           INTEGER PRIMARY KEY AUTOINCREMENT,
    razao_social TEXT NOT NULL,
    fantasia     TEXT DEFAULT NULL,
    cnpj         TEXT DEFAULT NULL
);
CREATE TABLE IF NOT EXISTS fornecedor_telefones
(
    id            INTEGER PRIMARY KEY AUTOINCREMENT,
    fornecedor_id INT  NOT NULL,
    descricao     TEXT NOT NULL,
    ddd           TEXT NOT NULL,
    numero        TEXT NOT NULL,
    ramal         TEXT NOT NULL,
    contato       TEXT NOT NULL,
    FOREIGN KEY (fornecedor_id)
        REFERENCES fornecedores (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS fornecedor_emails
(
    id            INTEGER PRIMARY KEY AUTOINCREMENT,
    fornecedor_id INT  NOT NULL,
    descricao     TEXT NOT NULL,
    email         TEXT NOT NULL,
    contato       TEXT NOT NULL,
    FOREIGN KEY (fornecedor_id)
        REFERENCES fornecedores (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS fornecedor_enderecos
(
    id            INTEGER PRIMARY KEY AUTOINCREMENT,
    fornecedor_id INT  NOT NULL,
    estado_id     INT  NOT NULL,
    cidade_id     INT  NOT NULL,
    bairro_id     INT  NOT NULL,
    logradouro_id INT  NOT NULL,
    descricao     TEXT NOT NULL,
    numero        TEXT NOT NULL,
    apartamento   TEXT NOT NULL,
    complemento   TEXT NOT NULL,
    FOREIGN KEY (fornecedor_id)
        REFERENCES fornecedores (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (estado_id)
        REFERENCES estados (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (cidade_id)
        REFERENCES cidades (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (bairro_id)
        REFERENCES bairros (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS aprovacoes
(
    id                INTEGER PRIMARY KEY AUTOINCREMENT,
    func_aprovador_id INTEGER DEFAULT NULL,
    orcamento_id      INTEGER DEFAULT NULL,
    data_criacao      TEXT NOT NULL,
    FOREIGN KEY (func_aprovador_id)
        REFERENCES funcionarios (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (orcamento_id)
        REFERENCES orcamentos (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS orcamentos
(
    id                    INTEGER PRIMARY KEY AUTOINCREMENT,
    status                INTEGER NOT NULL DEFAULT 0,
    func_solicitante_id   INTEGER          DEFAULT NULL,
    func_requisitante_id  INTEGER          DEFAULT NULL,
    fornecedor_id         INTEGER          DEFAULT NULL,
    func_aprovador_id     INTEGER          DEFAULT NULL,
    dias_previsto_entrega INTEGER          DEFAULT 0,
    condicoes_pagamento   TEXT             DEFAULT NULL,
    observacoes           TEXT             DEFAULT NULL,
    data_criacao          TEXT    NOT NULL,
    data_atualizacao      TEXT    NOT NULL,
    data_aprovacao        TEXT             DEFAULT NULL,
    data_reprovacao       TEXT             DEFAULT NULL,
    FOREIGN KEY (func_solicitante_id)
        REFERENCES funcionarios (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (fornecedor_id)
        REFERENCES fornecedores (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (func_aprovador_id)
        REFERENCES funcionarios (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (func_requisitante_id)
        REFERENCES funcionarios (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS orcamento_itens
(
    id             INTEGER PRIMARY KEY AUTOINCREMENT,
    orcamento_id   INTEGER          DEFAULT NULL,
    produto_id     INTEGER NOT NULL,
    quantidade     INTEGER NOT NULL DEFAULT 0,
    valor_unitario REAL             DEFAULT 0.0,
    FOREIGN KEY (produto_id)
        REFERENCES produtos (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (orcamento_id)
        REFERENCES orcamentos (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS orcamento_aprovadores
(
    id                INTEGER PRIMARY KEY AUTOINCREMENT,
    orcamento_id      INTEGER NOT NULL,
    func_aprovador_id INTEGER NOT NULL,
    status            INTEGER DEFAULT NULL,
    FOREIGN KEY (func_aprovador_id)
        REFERENCES funcionarios (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (orcamento_id)
        REFERENCES orcamentos (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS pedido_compras
(
    id                    INTEGER PRIMARY KEY AUTOINCREMENT,
    status                INTEGER NOT NULL DEFAULT 0,
    notafiscal            TEXT             DEFAULT NULL,
    func_solicitante_id   INTEGER          DEFAULT NULL,
    orcamento_id          INTEGER          DEFAULT NULL,
    fornecedor_id         INTEGER          DEFAULT NULL,
    dias_previsto_entrega INTEGER          DEFAULT 0,
    condicoes_pagamento   TEXT             DEFAULT NULL,
    observacoes           TEXT             DEFAULT NULL,
    data_criacao          TEXT    NOT NULL,
    data_atualizacao      TEXT    NOT NULL,
    FOREIGN KEY (func_solicitante_id)
        REFERENCES funcionarios (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (fornecedor_id)
        REFERENCES fornecedores (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (orcamento_id)
        REFERENCES orcamentos (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS pedido_compra_itens
(
    id                INTEGER PRIMARY KEY AUTOINCREMENT,
    pedido_compras_id INTEGER          DEFAULT NULL,
    produto_id        INTEGER NOT NULL,
    quantidade        INTEGER NOT NULL DEFAULT 0,
    valor_unitario    REAL             DEFAULT 0.0,
    FOREIGN KEY (produto_id)
        REFERENCES produtos (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (pedido_compras_id)
        REFERENCES pedido_compras (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);