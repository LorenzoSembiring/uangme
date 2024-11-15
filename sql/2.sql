SELECT 
    u.name AS Nama_Nasabah,
    a.account_type AS Jenis_Akun,
    a.balance AS Saldo,
    COALESCE(SUM(CASE WHEN t.type_transaction = 'Debit' THEN t.amount ELSE 0 END), 0) AS Debit,
    COALESCE(SUM(CASE WHEN t.type_transaction = 'Kredit' THEN t.amount ELSE 0 END), 0) AS Kredit
FROM 
    user u
JOIN 
    account a ON u.id = a.user_id
LEFT JOIN 
    transaction t ON a.id = t.account_id
GROUP BY 
    u.id, a.id;
