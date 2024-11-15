SELECT 
    u.name AS   Nama_Nasabah,
    SUM(a.balance) AS Jumlah_Saldo
FROM 
    user u
JOIN 
    account a ON u.id = a.user_id
GROUP BY 
    u.id
HAVING 
    TIMESTAMPDIFF(YEAR, u.birthday, CURDATE()) < 40 
    AND SUM(a.balance) < 1000000
