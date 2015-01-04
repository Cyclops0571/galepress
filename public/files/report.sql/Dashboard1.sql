SELECT t1.`indx` AS indx, t1.`Time`, IFNULL(t2.DownloadCount, 0) AS DownloadCount
FROM (
		SELECT 7 AS indx, DATE_ADD(DATE_FORMAT('{DATE}','%Y-%m-%d'), INTERVAL(-1) DAY) AS `Time`
		UNION ALL
		SELECT 6 AS indx, DATE_ADD(DATE_FORMAT('{DATE}','%Y-%m-%d'), INTERVAL(-2) DAY) AS `Time`
		UNION ALL
		SELECT 5 AS indx, DATE_ADD(DATE_FORMAT('{DATE}','%Y-%m-%d'), INTERVAL(-3) DAY) AS `Time`
		UNION ALL
		SELECT 4 AS indx, DATE_ADD(DATE_FORMAT('{DATE}','%Y-%m-%d'), INTERVAL(-4) DAY) AS `Time`
		UNION ALL
		SELECT 3 AS indx, DATE_ADD(DATE_FORMAT('{DATE}','%Y-%m-%d'), INTERVAL(-5) DAY) AS `Time`
		UNION ALL
		SELECT 2 AS indx, DATE_ADD(DATE_FORMAT('{DATE}','%Y-%m-%d'), INTERVAL(-6) DAY) AS `Time`
		UNION ALL
		SELECT 1 AS indx, DATE_ADD(DATE_FORMAT('{DATE}','%Y-%m-%d'), INTERVAL(-7) DAY) AS `Time`
	) t1
	LEFT JOIN (
		SELECT DATE_FORMAT(`Time`,'%Y-%m-%d') AS `Time`, COUNT(*) AS DownloadCount
		FROM (
			SELECT 
				st.`Time` 
			FROM `Customer` cu 
				INNER JOIN `Application` ap ON ap.`CustomerID`=cu.`CustomerID` AND ap.`StatusID`=1 
				INNER JOIN `Content` cn ON cn.`ApplicationID`=ap.`ApplicationID` AND cn.`StatusID`=1 
				/*INNER JOIN `Log` rq ON rq.`ContentID`=cn.`ContentID` AND rq.`Url` LIKE '%?RequestTypeID=1001%' AND rq.`Date` BETWEEN CONCAT(DATE_ADD(DATE_FORMAT('{DATE}','%Y-%m-%d'), INTERVAL -7 DAY), ' 00:00:00') AND CONCAT(DATE_ADD(DATE_FORMAT('{DATE}','%Y-%m-%d'), INTERVAL -1 DAY), ' 23:59:59')*/
				INNER JOIN `Statistic` st ON st.`ContentID`=cn.`ContentID` AND st.`Type`='10' AND st.`Time` BETWEEN CONCAT(DATE_ADD(DATE_FORMAT('{DATE}','%Y-%m-%d'), INTERVAL -7 DAY), ' 00:00:00') AND CONCAT(DATE_ADD(DATE_FORMAT('{DATE}','%Y-%m-%d'), INTERVAL -1 DAY), ' 23:59:59')
			WHERE
				cu.`CustomerID`=COALESCE({CUSTOMERID}, cu.`CustomerID`) AND 
				ap.`ApplicationID`=COALESCE({APPLICATIONID}, ap.`ApplicationID`) AND 
				cn.`ContentID`=COALESCE({CONTENTID}, cn.`ContentID`) AND 
				cu.`StatusID`=1
		) t
		GROUP BY DATE_FORMAT(`Time`,'%Y-%m-%d')
) t2 ON t1.`Time`=t2.`Time`

UNION ALL 

SELECT 199 AS indx, CURRENT_DATE AS `Time`, COUNT(*) AS DownloadCount
FROM (
	SELECT
		st.`Time` 
	FROM `Customer` cu 
		INNER JOIN `Application` ap ON ap.`CustomerID`=cu.`CustomerID` AND ap.`StatusID`=1 
		INNER JOIN `Content` cn ON cn.`ApplicationID`=ap.`ApplicationID` AND cn.`StatusID`=1 
		/*INNER JOIN `Log` rq ON rq.`ContentID`=cn.`ContentID` AND rq.`Url` LIKE '%?RequestTypeID=1001%' AND DATE_FORMAT(rq.`Date`,'%Y-%m-%d')=DATE_ADD(CURRENT_DATE, INTERVAL -1 DAY) */
		INNER JOIN `Statistic` st ON st.`ContentID`=cn.`ContentID` AND st.`Type`='10' AND DATE_FORMAT(st.`Time`,'%Y-%m-%d')=DATE_ADD(CURRENT_DATE, INTERVAL -1 DAY)
	WHERE
		cu.`CustomerID`=COALESCE({CUSTOMERID}, cu.`CustomerID`) AND 
		ap.`ApplicationID`=COALESCE({APPLICATIONID}, ap.`ApplicationID`) AND 
		cn.`ContentID`=COALESCE({CONTENTID}, cn.`ContentID`) AND 
		cu.`StatusID`=1
) k

UNION ALL 

SELECT 299 AS indx, CURRENT_DATE AS `Time`, COUNT(*) AS DownloadCount
FROM (
	SELECT
		st.`Time` 
	FROM `Customer` cu 
		INNER JOIN `Application` ap ON ap.`CustomerID`=cu.`CustomerID` AND ap.`StatusID`=1 
		INNER JOIN `Content` cn ON cn.`ApplicationID`=ap.`ApplicationID` AND cn.`StatusID`=1 
		/*INNER JOIN `Log` rq ON rq.`ContentID`=cn.`ContentID` AND rq.`Url` LIKE '%?RequestTypeID=1001%' AND DATE_FORMAT(rq.`Date`,'%Y-%m')=DATE_FORMAT(CURRENT_DATE,'%Y-%m')*/
		INNER JOIN `Statistic` st ON st.`ContentID`=cn.`ContentID` AND st.`Type`='10' AND DATE_FORMAT(st.`Time`,'%Y-%m')=DATE_FORMAT(CURRENT_DATE,'%Y-%m')
	WHERE
		cu.`CustomerID`=COALESCE({CUSTOMERID}, cu.`CustomerID`) AND 
		ap.`ApplicationID`=COALESCE({APPLICATIONID}, ap.`ApplicationID`) AND 
		cn.`ContentID`=COALESCE({CONTENTID}, cn.`ContentID`) AND 
		cu.`StatusID`=1
) k