<?php
/*
        Indiestor program

	Written by Erik Poupaert, erik@sankuru.biz
        Commissioned at peopleperhour.com 
        By Alex Gardiner, alex.gardiner@canterbury.ac.uk
*/

/*
Returns all device-hosted filesystems on the system. Example:

$ df -T -BG | grep -v tmpfs | tail -n +2
/dev/sda1      ext4          147G   12G      129G   8% /

All filesystems with 'tmpfs' mentioned in the type are eliminated.
The first header line is eliminated too.
*/

class DFFileSystem
{
	var $device=null;
	var $type=null;
	var $quotaYN=null;
	var $storageGB=null;
	var $usedGB=null;
	var $availableGB=null;
	var $percUse=null;
	var $mountedOn=null;
}

function sysquery_df()
{
	$dfFileSystems=array();
	$fileSystemLines=ShellCommand::query_fail_if_error('df -T -BG | grep -v tmpfs | tail -n +2');
	$fileSystemArray=explode("\n",$fileSystemLines);
	foreach($fileSystemArray as $fileSystemLine)
	{
		if($fileSystemLine!='')
		{
			$fileSystemLine=preg_replace('/ +/',' ',$fileSystemLine);
			$fileSystemLineFields=explode(' ',$fileSystemLine);
			$dfFileSystem=new DFFileSystem();
			$dfFileSystem->device=$fileSystemLineFields[0];
			$dfFileSystem->type=$fileSystemLineFields[1];
			$dfFileSystem->storageGB=strip_last_char($fileSystemLineFields[2]);
			$dfFileSystem->usedGB=strip_last_char($fileSystemLineFields[3]);
			$dfFileSystem->availableGB=strip_last_char($fileSystemLineFields[4]);
			$dfFileSystem->percUse=strip_last_char($fileSystemLineFields[5]);
			$dfFileSystem->mountedOn=$fileSystemLineFields[6];

			//check quota
			$quotaEnabled=sysquery_quotaon_p($dfFileSystem->device);
			if($quotaEnabled===true) $dfFileSystem->quotaYN='Y'; 
			else if($quotaEnabled===false) $dfFileSystem->quotaYN='N';
			else $dfFileSystem->quotaYN='?'; 

			$dfFileSystems[]=$dfFileSystem;
		}
	}
	return $dfFileSystems;
}

function strip_last_char($string)
{
	if(strlen($string)==0) return '';
	return substr($string,0,-1);
}

function sysquery_df_device_for_folder($folder)
{
	$fileSystemLine=ShellCommand::query_fail_if_error('df $folder | tail -n +2');	
	$fileSystemLine=preg_replace('/ +/',' ',$fileSystemLine);
	$fileSystemLineFields=explode(' ',$fileSystemLine);
	$device=$fileSystemLineFields[0];
	return $device;
}


