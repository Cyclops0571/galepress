SELECT `Device`, COUNT(*) AS `DownloadCount` 
FROM (
	SELECT 
		`Param5`, 
		(
		CASE  
			WHEN INSTR(`Param5`, 'ios') > 0 THEN 'iOS' 
			WHEN INSTR(`Param5`, 'android') > 0 THEN 'Android'
			ELSE 'iOS'
		END
		) AS `Device` 
	FROM ( 
		SELECT 
			cu.`CustomerID`, cu.`CustomerNo`, cu.`CustomerName`, 
			ap.`ApplicationID`, ap.`Name` AS `ApplicationName`, ap.`ExpirationDate`, ap.`ApplicationStatusID`, IFNULL(ap.`Blocked`, 0) AS `ApplicationBlocked`, 
			cn.`ContentID`, cn.`Name` AS `ContentName`, IFNULL(cn.`Approval`, 0) AS `ContentApproval`, IFNULL(cn.`Blocked`, 0) AS `ContentBlocked`, 
			st.`Param5`
		FROM `Customer` cu 
			INNER JOIN `Application` ap ON ap.`CustomerID`=cu.`CustomerID` AND ap.`StatusID`=1 
			INNER JOIN `Content` cn ON cn.`ApplicationID`=ap.`ApplicationID` AND cn.`StatusID`=1 
			INNER JOIN `Statistic` st ON st.`ContentID`=cn.`ContentID` AND st.`Type`='10' AND st.`Time` BETWEEN '{SD}' AND '{ED}'
		WHERE
			cu.`CustomerID`=COALESCE({CUSTOMERID}, cu.`CustomerID`) AND 
			ap.`ApplicationID`=COALESCE({APPLICATIONID}, ap.`ApplicationID`) AND 
			cn.`ContentID`=COALESCE({CONTENTID}, cn.`ContentID`) AND 
			cu.`StatusID`=1
	) t
) y 
WHERE `Device` IN ('iOS', 'Android')
GROUP BY `Device`