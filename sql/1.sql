CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    address VARCHAR(255),
    phone VARCHAR(15),
    birthday DATE,
    email VARCHAR(100)
);

INSERT INTO user (name, address, phone, birthday, email) VALUES
('Budi', 'Jl. Merdeka', '081234567890', '1985-07-15', 'budi@email.com'),
('Siti', 'Jl. Sudirman', '081234567891', '1990-11-25', 'siti@email.com'),
('Andi', 'Jl. Penjuang', '081234567892', '1978-03-10', 'andi@email.com');

CREATE TABLE account (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    account_type VARCHAR(50),
    balance DECIMAL(15, 2),
    opening_date DATE,
    FOREIGN KEY (user_id) REFERENCES user(id)
);

INSERT INTO account (user_id, account_type, balance, opening_date) VALUES
(1, 'Tabungan', 5000000.00, '2020-01-10'),
(1, 'Giro', 1200000.50, '2021-05-15'),
(2, 'Tabungan', 750000.00, '2019-12-20'),
(3, 'Tabungan', 300000.00, '2022-03-01');

CREATE TABLE transaction (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account_id INT,
    type_transaction VARCHAR(50),
    amount DECIMAL(15, 2),
    transaction_date DATETIME,
    remark VARCHAR(255),
    FOREIGN KEY (account_id) REFERENCES account(id)
);

INSERT INTO transaction (account_id, type_transaction, amount, transaction_date, remark) VALUES
(1, 'Kredit', 1000000.00, '2023-07-01 10:00:00', 'Setoran tunai'),
(1, 'Debit', 500000.00, '2023-07-02 14:00:00', 'Penarikan ATM'),
(2, 'Kredit', 2000000.00, '2023-07-05 09:30:00', 'Transfer masuk'),
(3, 'Debit', 250000.00, '2023-07-07 12:45:00', 'Belanja online'),
(4, 'Kredit', 150000.00, '2023-07-10 16:20:00', 'Setoran tunai');
