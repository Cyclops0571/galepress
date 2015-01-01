SELECT `Device`, COUNT(*) AS `DeviceCount` 
FROM (
	SELECT 
		`UserAgent`, 
		(
		CASE 
			WHEN INSTR(`UserAgent`, 'iPhone') > 0 THEN 'iOS' 
			WHEN INSTR(`UserAgent`, 'iPad') > 0 THEN 'iOS' 
			WHEN INSTR(`UserAgent`, 'iPod') > 0 THEN 'iOS' 
			WHEN INSTR(`UserAgent`, 'BlackBerry') > 0 THEN 'BlackBerry' 
			WHEN INSTR(`UserAgent`, 'Android') > 0 THEN 'Android' 
			WHEN INSTR(`UserAgent`, 'Windows') > 0 THEN 'Windows' 
			WHEN INSTR(`UserAgent`, 'Linux') > 0 THEN 'Linux' 
			ELSE 'Other' 
		END
		) AS `Device` 
	FROM ( 
		SELECT 
			cu.`CustomerID`, cu.`CustomerNo`, cu.`CustomerName`, 
			ap.`ApplicationID`, ap.`Name` AS `ApplicationName`, ap.`ExpirationDate`, ap.`ApplicationStatusID`, IFNULL(ap.`Blocked`, 0) AS `ApplicationBlocked`, 
			cn.`ContentID`, cn.`Name` AS `ContentName`, IFNULL(cn.`Approval`, 0) AS `ContentApproval`, IFNULL(cn.`Blocked`, 0) AS `ContentBlocked`, 
			rq.`UserAgent`, rq.`Size` 
		FROM `Customer` cu 
			INNER JOIN `Application` ap ON ap.`CustomerID`=cu.`CustomerID` AND ap.`StatusID`=1 
			INNER JOIN `Content` cn ON cn.`ApplicationID`=ap.`ApplicationID` AND cn.`StatusID`=1 
			INNER JOIN `Log` rq ON rq.`ContentID`=cn.`ContentID` AND rq.`Url` LIKE '%?RequestTypeID=1001%' AND rq.`Date` BETWEEN '{SD}' AND '{ED}'
		WHERE
			cu.`CustomerID`=COALESCE({CUSTOMERID}, cu.`CustomerID`) AND 
			ap.`ApplicationID`=COALESCE({APPLICATIONID}, ap.`ApplicationID`) AND 
			cn.`ContentID`=COALESCE({CONTENTID}, cn.`ContentID`) AND 
			cu.`StatusID`=1
	) t
) y 
WHERE `Device` IN ('iOS', 'Android')
GROUP BY `Device`