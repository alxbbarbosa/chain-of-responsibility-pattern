CREATE TABLE IF NOT EXISTS usuarios
(
    id               INTEGER PRIMARY KEY AUTOINCREMENT,
    login            TEXT NOT NULL,
    senha            TEXT NOT NULL,
    funcionario_id   INTEGER DEFAULT NULL,
    data_criacao     TEXT NOT NULL,
    data_atualizacao TEXT NOT NULL,
    FOREIGN KEY (funcionario_id)
        REFERENCES funcionarios (id)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
);