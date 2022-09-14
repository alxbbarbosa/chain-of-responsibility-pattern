CREATE TABLE IF NOT EXISTS departamentos
(
    id   INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS funcoes
(
    id   INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS funcionarios
(
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    nome            TEXT NOT NULL,
    email           TEXT NOT NULL,
    departamento_id INTEGER DEFAULT NULL,
    funcao_id       INTEGER DEFAULT NULL,
    FOREIGN KEY (departamento_id)
        REFERENCES departamentos (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION,
    FOREIGN KEY (funcao_id)
        REFERENCES funcoes (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);