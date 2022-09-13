CREATE TABLE IF NOT EXISTS clientes
(
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    fantasia   TEXT NOT NULL,
    nome_razao TEXT NOT NULL,
    cnpj_cpf   TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS estados
(
    id    INTEGER PRIMARY KEY AUTOINCREMENT,
    sigla TEXT NOT NULL,
    nome  TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS cidades
(
    id        INTEGER PRIMARY KEY AUTOINCREMENT,
    estado_id INT  NOT NULL,
    nome      TEXT NOT NULL,
    FOREIGN KEY (estado_id)
        REFERENCES estados (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS bairros
(
    id        INTEGER PRIMARY KEY AUTOINCREMENT,
    estado_id INT  NOT NULL,
    cidade_id INT  NOT NULL,
    nome      TEXT NOT NULL,
    FOREIGN KEY (estado_id)
        REFERENCES estados (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (cidade_id)
        REFERENCES cidades (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS logradouro
(
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    estado_id  INT  NOT NULL,
    cidade_id  INT  NOT NULL,
    bairro_id  INT  NOT NULL,
    cep        TEXT NOT NULL,
    logradouro TEXT NOT NULL,
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

CREATE TABLE IF NOT EXISTS cliente_enderecos
(
    id            INTEGER PRIMARY KEY AUTOINCREMENT,
    cliente_id    INT  NOT NULL,
    estado_id     INT  NOT NULL,
    cidade_id     INT  NOT NULL,
    bairro_id     INT  NOT NULL,
    logradouro_id INT  NOT NULL,
    descricao     TEXT NOT NULL,
    numero        TEXT NOT NULL,
    apartamento   TEXT NOT NULL,
    complemento   TEXT NOT NULL,
    FOREIGN KEY (cliente_id)
        REFERENCES clientes (id)
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

CREATE TABLE IF NOT EXISTS clientes_telefones
(
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    cliente_id INT  NOT NULL,
    descricao  TEXT NOT NULL,
    ddd        TEXT NOT NULL,
    numero     TEXT NOT NULL,
    ramal      TEXT NOT NULL,
    contato    TEXT NOT NULL,
    FOREIGN KEY (cliente_id)
        REFERENCES clientes (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS clientes_emails
(
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    cliente_id INT  NOT NULL,
    descricao  TEXT NOT NULL,
    email      TEXT NOT NULL,
    contato    TEXT NOT NULL,
    FOREIGN KEY (cliente_id)
        REFERENCES clientes (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS pedido_vendas
(
    id                    INTEGER PRIMARY KEY AUTOINCREMENT,
    status                INTEGER NOT NULL DEFAULT 0,
    notafiscal            TEXT             DEFAULT NULL,
    func_vendedor_id      INTEGER          DEFAULT NULL,
    cliente_id            INTEGER          DEFAULT NULL,
    dias_previsto_entrega INTEGER          DEFAULT 0,
    condicoes_pagamento   TEXT             DEFAULT NULL,
    observacoes           TEXT             DEFAULT NULL,
    data_criacao          TEXT    NOT NULL,
    data_atualizacao      TEXT    NOT NULL,
    FOREIGN KEY (func_vendedor_id)
        REFERENCES funcionarios (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (cliente_id)
        REFERENCES clientes (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS pedido_venda_itens
(
    id               INTEGER PRIMARY KEY AUTOINCREMENT,
    pedido_vendas_id INTEGER          DEFAULT NULL,
    produto_id       INTEGER NOT NULL,
    quantidade       INTEGER NOT NULL DEFAULT 0,
    valor_unitario   REAL             DEFAULT 0.0,
    FOREIGN KEY (produto_id)
        REFERENCES produtos (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (pedido_vendas_id)
        REFERENCES pedido_vendas (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);
