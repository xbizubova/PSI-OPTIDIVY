CREATE TABLE frames (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    color VARCHAR(100),
    price DECIMAL,
    CONSTRAINT unique_frames UNIQUE (name, color)
);

CREATE TABLE wear_period_options (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    CONSTRAINT unique_wear_period_options UNIQUE (name)
);

CREATE TABLE contact_lenses (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    wear_period INTEGER REFERENCES wear_period_options(id),
    price DECIMAL,
    CONSTRAINT unique_contact_lenses UNIQUE (name, wear_period)
);

CREATE TABLE lenses (
    id SERIAL PRIMARY KEY,
    type VARCHAR(100),
    price DECIMAL,
    CONSTRAINT unique_lenses UNIQUE (type)
);

INSERT INTO frames (name, color, price) VALUES
('Základné Rámy', 'Červená', 50.0),
('Špeciálne Rámy', 'Hnedé', 120.0),
('Limitovaná Edícia Rámy', 'Tigrované', 150.0);

INSERT INTO lenses (type, price) VALUES
('Obyčajné', 5.0),
('Slnečné', 10.0),
('Modrý service.Filter', 15.0);

INSERT INTO wear_period_options (name) VALUES
('Jednodenné'),
('Týždenné/dvojtýždenné'),
('Mesačné'),
('Na dlhodobé nosenie');

INSERT INTO contact_lenses (name, wear_period, price) VALUES
('Jednodenné šošovky', 1, 50.0),
('Týždenné šošovky', 2, 50.0),
('Šošovky na dlhodobé nosenie', 4, 100.0);