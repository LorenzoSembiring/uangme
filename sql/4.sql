SELECT 
    u.name AS Nasabah,
    SUM(a.balance) AS Jumlah_asset,
    TIMESTAMPDIFF(YEAR, u.birthday, CURDATE()) AS Tahun,
    TIMESTAMPDIFF(MONTH, u.birthday, CURDATE()) % 12 AS Bulan
FROM 
    user u
JOIN 
    account a ON u.id = a.user_id
GROUP BY 
    u.id
ORDER BY 
    Age_Years DESC, Age_Months DESC;
