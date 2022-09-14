CREATE TABLE IF NOT EXISTS categorias
(
    id        INTEGER PRIMARY KEY AUTOINCREMENT,
    descricao TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS produtos
(
    id                         INTEGER PRIMARY KEY AUTOINCREMENT,
    sku                        TEXT NOT NULL,
    categoria_id               INT  NOT NULL,
    valor_compra               REAL    DEFAULT 0.0,
    valor_venda                REAL    DEFAULT 0.0,
    estoque_atual              INTEGER DEFAULT 0,
    estoque_minimo             INTEGER DEFAULT 0,
    data_criacao               TEXT NOT NULL,
    data_atualizacao           TEXT NOT NULL,
    criacao_funcionario_id     INT  NOT NULL,
    atualizacao_funcionario_id INT  NOT NULL,
    FOREIGN KEY (criacao_funcionario_id)
        REFERENCES funcionarios (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (atualizacao_funcionario_id)
        REFERENCES funcionarios (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (categoria_id)
        REFERENCES categorias (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS produto_detalhes
(
    id                              INTEGER PRIMARY KEY AUTOINCREMENT,
    produto_id                      INT  NOT NULL,
    descricao                       TEXT NOT NULL,
    fabricante                      TEXT NOT NULL,
    codigo_barras                   TEXT NOT NULL,
    unidade_medida                  TEXT NOT NULL,
    peso                            REAL DEFAULT 0.0,
    embalagem_dimensao_atura        REAL DEFAULT 0.0,
    embalagem_dimensao_largura      REAL DEFAULT 0.0,
    embalagem_dimensao_profundidade REAL DEFAULT 0.0,
    FOREIGN KEY (produto_id)
        REFERENCES produtos (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS bloqueio_previsao_saida
(
    id             INTEGER PRIMARY KEY AUTOINCREMENT,
    produto_id     INT  NOT NULL,
    quantidade     INT DEFAULT 0,
    data_prevista  TEXT NOT NULL,
    data_criacao   TEXT NOT NULL,
    funcionario_id INT  NOT NULL,
    FOREIGN KEY (produto_id)
        REFERENCES produtos (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (funcionario_id)
        REFERENCES funcionarios (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS bloqueio_previsao_entrada
(
    id             INTEGER PRIMARY KEY AUTOINCREMENT,
    produto_id     INT  NOT NULL,
    quantidade     INT DEFAULT 0,
    data_prevista  TEXT NOT NULL,
    data_criacao   TEXT NOT NULL,
    funcionario_id INT  NOT NULL,
    FOREIGN KEY (produto_id)
        REFERENCES produtos (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (funcionario_id)
        REFERENCES funcionarios (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS notasfiscais_entrada
(
    id               INTEGER PRIMARY KEY AUTOINCREMENT,
    notafiscal_id    INT NOT NULL,
    fornecedor_id    INT NOT NULL,
    pedido_compra_id INT NOT NULL,
    FOREIGN KEY (notafiscal_id)
        REFERENCES notasfiscais (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (fornecedor_id)
        REFERENCES fornecedores (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (pedido_compra_id)
        REFERENCES pedido_compras (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS notasfiscais_saida
(
    id               INTEGER PRIMARY KEY AUTOINCREMENT,
    notafiscal_id    INT NOT NULL,
    cliente_id       INT NOT NULL,
    pedido_vendas_id INT NOT NULL,
    FOREIGN KEY (notafiscal_id)
        REFERENCES notasfiscais (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (cliente_id)
        REFERENCES clientes (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (pedido_vendas_id)
        REFERENCES pedido_vendas (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS notasfiscais
(
    id                         INTEGER PRIMARY KEY AUTOINCREMENT,
    codigo_operacao            INT  NOT NULL,
    data_emissao               TEXT NOT NULL,
    valor_total                REAL DEFAULT 0.0,
    data_criacao               TEXT NOT NULL,
    data_atualizacao           TEXT NOT NULL,
    criacao_funcionario_id     INT  NOT NULL,
    atualizacao_funcionario_id INT  NOT NULL,
    FOREIGN KEY (criacao_funcionario_id)
        REFERENCES funcionarios (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (atualizacao_funcionario_id)
        REFERENCES funcionarios (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS notafiscal_itens
(
    id                          INTEGER PRIMARY KEY AUTOINCREMENT,
    notafiscal_id               TEXT DEFAULT NULL,
    produto_id                  INT  NOT NULL,
    quantidade                  INT  DEFAULT 0,
    valor_unitario              REAL DEFAULT 0.0,
    imposto                     REAL DEFAULT 0.0,
    data_criacao                TEXT NOT NULL,
    data_atualizacao            TEXT NOT NULL,
    criacao_funcionario_id      INT  NOT NULL,
    atualizacao__funcionario_id INT  NOT NULL,
    FOREIGN KEY (produto_id)
        REFERENCES produtos (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (criacao_funcionario_id)
        REFERENCES funcionarios (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (atualizacao__funcionario_id)
        REFERENCES funcionarios (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS estoque_movimento_entrada
(
    id             INTEGER PRIMARY KEY AUTOINCREMENT,
    produto_id     INT  NOT NULL,
    quantidade     INT  NOT NULL,
    unidade        TEXT DEFAULT NULL,
    valor          REAL DEFAULT 0.0,
    data_criacao   TEXT NOT NULL,
    funcionario_id INT  NOT NULL,
    notafiscal_id  TEXT DEFAULT NULL,
    FOREIGN KEY (produto_id)
        REFERENCES produtos (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (funcionario_id)
        REFERENCES funcionarios (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (notafiscal_id)
        REFERENCES notasfiscais (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS estoque_movimento_saida
(
    id             INTEGER PRIMARY KEY AUTOINCREMENT,
    produto_id     INT  NOT NULL,
    quantidade     INT  NOT NULL,
    unidade        TEXT DEFAULT NULL,
    valor          REAL DEFAULT 0.0,
    data_criacao   TEXT NOT NULL,
    funcionario_id INT  NOT NULL,
    notafiscal_id  INT  NOT NULL,
    FOREIGN KEY (produto_id)
        REFERENCES produtos (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (funcionario_id)
        REFERENCES funcionarios (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (notafiscal_id)
        REFERENCES notasfiscais (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);
