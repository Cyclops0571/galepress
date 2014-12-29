SELECT t1.Year, t1.Month, IFNULL(t2.DownloadCount, 0) AS DownloadCount
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
		SELECT YEAR(`Date`) AS Year, MONTH(`Date`) AS Month, COUNT(*) AS DownloadCount
		FROM (
			SELECT 
				cu.`CustomerID`, cu.`CustomerNo`, cu.`CustomerName`, 
				ap.`ApplicationID`, ap.`Name` AS `ApplicationName`, ap.`ExpirationDate`, ap.`ApplicationStatusID`, IFNULL(ap.`Blocked`, 0) AS `ApplicationBlocked`, 
				cn.`ContentID`, cn.`Name` AS `ContentName`, IFNULL(cn.`Approval`, 0) AS `ContentApproval`, IFNULL(cn.`Blocked`, 0) AS `ContentBlocked`, 
				rq.`Date`, rq.`UserAgent`, rq.`Size` 
			FROM `Customer` cu 
				INNER JOIN `Application` ap ON ap.`CustomerID`=cu.`CustomerID` AND ap.`StatusID`=1 
				INNER JOIN `Content` cn ON cn.`ApplicationID`=ap.`ApplicationID` AND cn.`StatusID`=1 
				INNER JOIN `Log` rq ON rq.`ContentID`=cn.`ContentID` AND rq.`Url` LIKE '%?RequestTypeID=1001%' AND rq.`Date` BETWEEN CONCAT_WS('-', DATE_FORMAT(DATE_ADD('{DATE}', INTERVAL(-5) MONTH),'%Y-%m'), '01 00:00:00') AND CONCAT_WS(' ', LAST_DAY(DATE_ADD('{DATE}', INTERVAL(-1) MONTH)), '23:59:59')
			WHERE
				cu.`CustomerID`=COALESCE({CUSTOMERID}, cu.`CustomerID`) AND 
				ap.`ApplicationID`=COALESCE({APPLICATIONID}, ap.`ApplicationID`) AND 
				cn.`ContentID`=COALESCE({CONTENTID}, cn.`ContentID`) AND 
				cu.`StatusID`=1
		) t
		GROUP BY YEAR(`Date`), MONTH(`Date`)
) t2 ON t1.Year=t2.Year AND t1.Month=t2.Month
ORDER BY Year DESC, Month DESC