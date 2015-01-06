SELECT t1.Year, t1.Month, IFNULL(t2.DownloadCount, 0) AS DownloadCount, t2.Param5 AS Param5
FROM (
		SELECT YEAR(DATE_ADD('{DATE}', INTERVAL(-1) MONTH)) AS Year, MONTH(DATE_ADD('{DATE}', INTERVAL(-1) MONTH)) AS Month
		UNION ALL
		SELECT YEAR(DATE_ADD('{DATE}', INTERVAL(-2) MONTH)) AS Year, MONTH(DATE_ADD('{DATE}', INTERVAL(-2) MONTH)) AS Month
		UNION ALL
		SELECT YEAR(DATE_ADD('{DATE}', INTERVAL(-3) MONTH)) AS Year, MONTH(DATE_ADD('{DATE}', INTERVAL(-3) MONTH)) AS Month
		UNION ALL
		SELECT YEAR(DATE_ADD('{DATE}', INTERVAL(-4) MONTH)) AS Year, MONTH(DATE_ADD('{DATE}', INTERVAL(-4) MONTH)) AS Month
		UNION ALL
		SELECT YEAR(DATE_ADD('{DATE}', INTERVAL(-5) MONTH)) AS Year, MONTH(DATE_ADD('{DATE}', INTERVAL(-5) MONTH)) AS Month
	) t1
	LEFT JOIN (
		SELECT YEAR(`Time`) AS Year, MONTH(`Time`) AS Month, `Param5`, COUNT(*) AS DownloadCount
		FROM (
			SELECT 
				st.`Time`, st.`Param5`
			FROM `Customer` cu 
				INNER JOIN `Application` ap ON ap.`CustomerID`=cu.`CustomerID` AND ap.`StatusID`=1 
				INNER JOIN `Content` cn ON cn.`ApplicationID`=ap.`ApplicationID` AND cn.`StatusID`=1 
				/*INNER JOIN `Log` rq ON rq.`ContentID`=cn.`ContentID` AND rq.`Url` LIKE '%?RequestTypeID=1001%' AND rq.`Date` BETWEEN CONCAT_WS('-', DATE_FORMAT(DATE_ADD('{DATE}', INTERVAL(-5) MONTH),'%Y-%m'), '01 00:00:00') AND CONCAT_WS(' ', LAST_DAY(DATE_ADD('{DATE}', INTERVAL(-1) MONTH)), '23:59:59')*/
				INNER JOIN `Statistic` st ON st.`ContentID`=cn.`ContentID` AND st.`Type`='10' AND st.`Time` BETWEEN CONCAT_WS('-', DATE_FORMAT(DATE_ADD('{DATE}', INTERVAL(-5) MONTH),'%Y-%m'), '01 00:00:00') AND CONCAT_WS(' ', LAST_DAY(DATE_ADD('{DATE}', INTERVAL(-1) MONTH)), '23:59:59')

			WHERE
				cu.`CustomerID`=COALESCE({CUSTOMERID}, cu.`CustomerID`) AND 
				ap.`ApplicationID`=COALESCE({APPLICATIONID}, ap.`ApplicationID`) AND 
				cn.`ContentID`=COALESCE({CONTENTID}, cn.`ContentID`) AND 
				cu.`StatusID`=1
		) t
		GROUP BY YEAR(`Time`), MONTH(`Time`), `Param5`
	) t2 ON t1.Year=t2.Year AND t1.Month=t2.Month
ORDER BY Year DESC, Month DESC