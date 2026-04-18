CREATE TABLE product (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    price DECIMAL
);

INSERT INTO product (name, price) VALUES
('Basic Glasses', 50.0),
('Premium Glasses', 120.0),
('Contact Lenses', 30.0);