SELECT 
	`CustomerID`, 
	`CustomerNo`, 
	`CustomerName`,
	`ApplicationID`, 
	`ApplicationName`,
	`ContentID`, 
	`ContentName`,
	/*
	`Country`,
	`City`, 
	`District`, 
	*/
	(CASE `Country` WHEN '' THEN '!!!auth_failed' ELSE `Country` END) AS `Country`,
	(CASE `City` WHEN '' THEN '!!!auth_failed' ELSE `City` END) AS `City`,
	(CASE `District` WHEN '' THEN '!!!auth_failed' ELSE `District` END) AS `District`,
	(DownloadCount * 100 / ContentDownloadCount) AS Percent
FROM (
	SELECT *, (SELECT COUNT(*)	FROM `Statistic` WHERE `CustomerID`=t1.`CustomerID` AND `ApplicationID`=t1.`ApplicationID` AND `ContentID`=t1.`ContentID` AND `Type`='10' AND `Time` BETWEEN '{SD}' AND '{ED}' AND (`Country`={COUNTRY} OR {COUNTRY} IS NULL) AND (`City`={CITY} OR {CITY} IS NULL) AND (`District`={DISTRICT} OR {DISTRICT} IS NULL)) AS `ContentDownloadCount`
	FROM (
		SELECT *, COUNT(*) AS `DownloadCount`
		FROM (
			SELECT 
				cu.`CustomerID`, cu.`CustomerNo`, cu.`CustomerName`,
				ap.`ApplicationID`, ap.`Name` AS `ApplicationName`,
				cn.`ContentID`, cn.`Name` AS `ContentName`,
				IFNULL(st.`Country`, '') AS `Country`, IFNULL(st.`City`, '') AS `City`, IFNULL(st.`District`, '') AS `District`
			FROM `Customer` cu 
				INNER JOIN `Application` ap ON ap.`CustomerID`=cu.`CustomerID` AND ap.`StatusID`=1 
				INNER JOIN `Content` cn ON cn.`ApplicationID`=ap.`ApplicationID` AND cn.`StatusID`=1 
				INNER JOIN `Statistic` st ON st.`CustomerID`=cu.`CustomerID` AND st.`ApplicationID`=ap.`ApplicationID` AND st.`ContentID`=cn.`ContentID` AND st.`Type`='10' AND st.`Time` BETWEEN '{SD}' AND '{ED}' AND (st.`Country`={COUNTRY} OR {COUNTRY} IS NULL) AND (st.`City`={CITY} OR {CITY} IS NULL) AND (st.`District`={DISTRICT} OR {DISTRICT} IS NULL)
			WHERE 
				cu.`CustomerID`=COALESCE({CUSTOMERID}, cu.`CustomerID`) AND 
				ap.`ApplicationID`=COALESCE({APPLICATIONID}, ap.`ApplicationID`) AND 
				cn.`ContentID`=COALESCE({CONTENTID}, cn.`ContentID`) AND 
				cu.`StatusID`=1
		) t 
		GROUP BY `CustomerID`, `CustomerNo`, `CustomerName`, `ApplicationID`, `ApplicationName`, `ContentID`, `ContentName`, `Country`, `City`, `District`
	) t1
) t2