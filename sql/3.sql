SELECT 
    u.name AS Nasabah,
    a.account_type AS Jenis_Akun,
    CASE 
        WHEN a.account_type = 'Tabungan' THEN a.balance
        ELSE NULL
    END AS Saldo
FROM 
    user u
LEFT JOIN 
    account a ON u.id = a.user_id
ORDER BY 
    u.name;
