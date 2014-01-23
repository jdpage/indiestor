<?php
/*
        Indiestor program
        Concept, requirements, specifications, and unit testing
        By Alex Gardiner, alex@indiestor.com
        Written by Erik Poupaert, erik@sankuru.biz
        Commissioned at peopleperhour.com 
        Licensed under the GPL
*/

class UserReportRecords
{
	var $records=null;

	function __construct($userNames)
	{
		$this->records=array();
		if($userNames==null) return;
                foreach($userNames as $userName)
                {
			$userRecord=new UserReportRecord($userName);
			$this->records[]=$userRecord;
                }
	}

        function findFormattedUserRecords()
        {
                $formattedUserRecords=array();
		$sambaUsers=sysquery_pdbedit_list();
		$sambaConnectedUsers=sysquery_smbstatus_processes();
		foreach($this->records as $userReportRecord)
		{
                        $formattedUserRecord=array();

			//locked
			if($userReportRecord->locked) $formattedUserRecord['locked']='Y';
			else $formattedUserRecord['locked']='N';

			//groupName
			if($userReportRecord->groupName==null) $formattedUserRecord['groupName']='(none)';
			else $formattedUserRecord['groupName']=$userReportRecord->groupName;

			//quota
			if($userReportRecord->hasQuotaRecord)
			{
				$formattedUserRecord['quotaTotalGB']=floor($userReportRecord->quotaTotalGB).'G';
				$formattedUserRecord['quotaUsedGB']=number_format($userReportRecord->quotaUsedGB,1).'G';
				$formattedUserRecord['quotaUsedPerc']=floor($userReportRecord->quotaUsedPerc).'%';
			}
			else
			{
				$formattedUserRecord['quotaTotalGB']='-';
				$formattedUserRecord['quotaUsedGB']='-';
				$formattedUserRecord['quotaUsedPerc']='-';
			}

			if(array_key_exists($userReportRecord->userName,$sambaUsers))
			{                                
				$sambaUser=$sambaUsers[$userReportRecord->userName];
				$formattedUserRecord['samba']='Y';
				$formattedUserRecord['sambaFlags']=implode('',$sambaUser['sambaFlagArray']);
			}
			else
			{
				$formattedUserRecord['samba']='N';
				$formattedUserRecord['sambaFlags']='-';
			}

			if(array_key_exists($userReportRecord->userName,$sambaConnectedUsers))
				$formattedUserRecord['sambaConnected']='Y';
			else $formattedUserRecord['sambaConnected']='N';

			$formattedUserRecord['userName']=$userReportRecord->userName;
			$formattedUserRecord['homeFolder']=$userReportRecord->homeFolder;

                        $formattedUserRecords[]=$formattedUserRecord;
		}

                return $formattedUserRecords;
        }

	function outputCLI()
	{
                $formattedUserRecords=self::findformattedUserRecords();

		if(count($formattedUserRecords)==0) 
		{
			echo "no users\n";
			return;
		}

		$format1="%-10s %-20s %-6s %-10s %5s %5s %5s %-5s %-5s %-5s\n";
		$format2="%-10s %-20s %-6s %-10s %5s %5s %5s %-5s %-5s %-5s\n";
		printf($format1,'user','home','locked','group','quota','used','%used','samba','flags','conn.');
		foreach($formattedUserRecords as $formattedUserRecord)
		{
			printf($format2,
				$formattedUserRecord['userName'],
				$formattedUserRecord['homeFolder'],
				$formattedUserRecord['locked'],
				$formattedUserRecord['groupName'],
				$formattedUserRecord['quotaTotalGB'],
				$formattedUserRecord['quotaUsedGB'],
				$formattedUserRecord['quotaUsedPerc'],
				$formattedUserRecord['samba'],
				$formattedUserRecord['sambaFlags'],
				$formattedUserRecord['sambaConnected']);  
		}
	}

	function outputJSON()
	{
                echo json_encode_legacy(self::findformattedUserRecords())."\n";
        }
}

