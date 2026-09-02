CREATE TABLE IF NOT EXISTS copies_examens (
    id SERIAL PRIMARY KEY,
    date_depot TIMESTAMP NOT NULL,
    note_brute NUMERIC(4,2) NOT NULL,
    note_finale NUMERIC(4,2) NOT NULL,
    penalite_appliquee NUMERIC(4,2) NOT NULL DEFAULT 0,
    date_limite TIMESTAMP NOT NULL,

    CONSTRAINT note_brute_valide
        CHECK (note_brute >= 0 AND note_brute <= 20),

    CONSTRAINT note_finale_valide
        CHECK (note_finale >= 0 AND note_finale <= 20),

    CONSTRAINT penalite_valide
        CHECK (penalite_appliquee >= 0)
);