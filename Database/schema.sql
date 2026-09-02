CREATE TABLE IF NOT EXISTS copies_examens (
    id SERIAL PRIMARY KEY,
    date_depot TIMESTAMP NOT NULL,
    note_brute NUMERIC(4,2) NOT NULL,
    note_finale NUMERIC(4,2) NOT NULL,
    penalite_appliquee NUMERIC(4,2) NOT NULL DEFAULT 0,
    date_limite TIMESTAMP NOT NULL,

);