SELECT t1.`indx` AS indx, t1.`Date`, IFNULL(t2.DownloadCount, 0) AS DownloadCount
FROM (
		SELECT 7 AS indx, DATE_ADD(DATE_FORMAT('{DATE}','%Y-%m-%d'), INTERVAL(-1) DAY) AS `Date`
		UNION ALL
		SELECT 6 AS indx, DATE_ADD(DATE_FORMAT('{DATE}','%Y-%m-%d'), INTERVAL(-2) DAY) AS `Date`
		UNION ALL
		SELECT 5 AS indx, DATE_ADD(DATE_FORMAT('{DATE}','%Y-%m-%d'), INTERVAL(-3) DAY) AS `Date`
		UNION ALL
		SELECT 4 AS indx, DATE_ADD(DATE_FORMAT('{DATE}','%Y-%m-%d'), INTERVAL(-4) DAY) AS `Date`
		UNION ALL
		SELECT 3 AS indx, DATE_ADD(DATE_FORMAT('{DATE}','%Y-%m-%d'), INTERVAL(-5) DAY) AS `Date`
		UNION ALL
		SELECT 2 AS indx, DATE_ADD(DATE_FORMAT('{DATE}','%Y-%m-%d'), INTERVAL(-6) DAY) AS `Date`
		UNION ALL
		SELECT 1 AS indx, DATE_ADD(DATE_FORMAT('{DATE}','%Y-%m-%d'), INTERVAL(-7) DAY) AS `Date`
	) t1
	LEFT JOIN (
		SELECT DATE_FORMAT(`Date`,'%Y-%m-%d') AS `Date`, COUNT(*) AS DownloadCount
		FROM (
			SELECT 
				cu.`CustomerID`, cu.`CustomerNo`, cu.`CustomerName`, 
				ap.`ApplicationID`, ap.`Name` AS `ApplicationName`, ap.`ExpirationDate`, ap.`ApplicationStatusID`, IFNULL(ap.`Blocked`, 0) AS `ApplicationBlocked`, 
				cn.`ContentID`, cn.`Name` AS `ContentName`, IFNULL(cn.`Approval`, 0) AS `ContentApproval`, IFNULL(cn.`Blocked`, 0) AS `ContentBlocked`, 
				rq.`Date`, rq.`UserAgent`, rq.`Size` 
			FROM `Customer` cu 
				INNER JOIN `Application` ap ON ap.`CustomerID`=cu.`CustomerID` AND ap.`StatusID`=1 
				INNER JOIN `Content` cn ON cn.`ApplicationID`=ap.`ApplicationID` AND cn.`StatusID`=1 
				INNER JOIN `Log` rq ON rq.`ContentID`=cn.`ContentID` AND rq.`Url` LIKE '%?RequestTypeID=1001%' AND rq.`Date` BETWEEN CONCAT(DATE_ADD(DATE_FORMAT('{DATE}','%Y-%m-%d'), INTERVAL -7 DAY), ' 00:00:00') AND CONCAT(DATE_ADD(DATE_FORMAT('{DATE}','%Y-%m-%d'), INTERVAL -1 DAY), ' 23:59:59')
			WHERE
				cu.`CustomerID`=COALESCE({CUSTOMERID}, cu.`CustomerID`) AND 
				ap.`ApplicationID`=COALESCE({APPLICATIONID}, ap.`ApplicationID`) AND 
				cn.`ContentID`=COALESCE({CONTENTID}, cn.`ContentID`) AND 
				cu.`StatusID`=1
		) t
		GROUP BY DATE_FORMAT(`Date`,'%Y-%m-%d')
) t2 ON t1.`Date`=t2.`Date`

UNION ALL 

SELECT 199 AS indx, CURRENT_DATE AS `Date`, COUNT(*) AS DownloadCount
FROM (
	SELECT
		cu.`CustomerID`, cu.`CustomerNo`, cu.`CustomerName`, 
		ap.`ApplicationID`, ap.`Name` AS `ApplicationName`, ap.`ExpirationDate`, ap.`ApplicationStatusID`, IFNULL(ap.`Blocked`, 0) AS `ApplicationBlocked`, 
		cn.`ContentID`, cn.`Name` AS `ContentName`, IFNULL(cn.`Approval`, 0) AS `ContentApproval`, IFNULL(cn.`Blocked`, 0) AS `ContentBlocked`, 
		rq.`Date`, rq.`UserAgent`, rq.`Size` 
	FROM `Customer` cu 
		INNER JOIN `Application` ap ON ap.`CustomerID`=cu.`CustomerID` AND ap.`StatusID`=1 
		INNER JOIN `Content` cn ON cn.`ApplicationID`=ap.`ApplicationID` AND cn.`StatusID`=1 
		INNER JOIN `Log` rq ON rq.`ContentID`=cn.`ContentID` AND rq.`Url` LIKE '%?RequestTypeID=1001%' AND DATE_FORMAT(rq.`Date`,'%Y-%m-%d')=DATE_ADD(CURRENT_DATE, INTERVAL -1 DAY) 
	WHERE
		cu.`CustomerID`=COALESCE({CUSTOMERID}, cu.`CustomerID`) AND 
		ap.`ApplicationID`=COALESCE({APPLICATIONID}, ap.`ApplicationID`) AND 
		cn.`ContentID`=COALESCE({CONTENTID}, cn.`ContentID`) AND 
		cu.`StatusID`=1
) k

UNION ALL 

SELECT 299 AS indx, CURRENT_DATE AS `Date`, COUNT(*) AS DownloadCount
FROM (
	SELECT
		cu.`CustomerID`, cu.`CustomerNo`, cu.`CustomerName`, 
		ap.`ApplicationID`, ap.`Name` AS `ApplicationName`, ap.`ExpirationDate`, ap.`ApplicationStatusID`, IFNULL(ap.`Blocked`, 0) AS `ApplicationBlocked`, 
		cn.`ContentID`, cn.`Name` AS `ContentName`, IFNULL(cn.`Approval`, 0) AS `ContentApproval`, IFNULL(cn.`Blocked`, 0) AS `ContentBlocked`, 
		rq.`Date`, rq.`UserAgent`, rq.`Size` 
	FROM `Customer` cu 
		INNER JOIN `Application` ap ON ap.`CustomerID`=cu.`CustomerID` AND ap.`StatusID`=1 
		INNER JOIN `Content` cn ON cn.`ApplicationID`=ap.`ApplicationID` AND cn.`StatusID`=1 
		INNER JOIN `Log` rq ON rq.`ContentID`=cn.`ContentID` AND rq.`Url` LIKE '%?RequestTypeID=1001%' AND DATE_FORMAT(rq.`Date`,'%Y-%m')=DATE_FORMAT(CURRENT_DATE,'%Y-%m')
	WHERE
		cu.`CustomerID`=COALESCE({CUSTOMERID}, cu.`CustomerID`) AND 
		ap.`ApplicationID`=COALESCE({APPLICATIONID}, ap.`ApplicationID`) AND 
		cn.`ContentID`=COALESCE({CONTENTID}, cn.`ContentID`) AND 
		cu.`StatusID`=1
) k