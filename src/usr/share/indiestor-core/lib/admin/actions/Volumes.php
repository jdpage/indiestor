<?php
/*
        Indiestor program
        Concept, requirements, specifications, and unit testing
        By Alex Gardiner, alex@indiestor.com
        Written by Erik Poupaert, erik@sankuru.biz
        Commissioned at peopleperhour.com 
        Licensed under the GPL
*/

class Volumes extends EntityType
{

        static function json($commandAction)
        {
                //handled by show command
                return;
        }

	static function noVolumes()
	{
		echo "no volumes\n";
	}

        static function show($commandAction)
        {
                if(ProgramActions::actionExists('json'))
                        self::showJSON();
                else
                        self::showCLI();
        }

        static function findFileSystems()
        {
                $fileSystems=array();
		$dfFileSystems=sysquery_df();
		$zpools=sysquery_zpool_list();
		foreach($dfFileSystems as $dfFileSystem)
			//for zfs only show pools, not user-level quota
			if($dfFileSystem->type=='zfs')
                        {
				if(array_key_exists($dfFileSystem->device,$zpools))
                                        $fileSystems[]=$dfFileSystem;
                        }
			else $fileSystems[]=$dfFileSystem;
                return $fileSystems;
        }

        static function showCLI()
        {
		$format1="%-55s %-10s %-5s %7s %7s %10s %5s  %-s\n";
		printf($format1,'device (in GB)','type','quota','total','used','avail','%used','mounted on');
                $fileSystems=self::findFileSystems();
		if(count($fileSystems>0))
			foreach($fileSystems as $fileSystem)
				self::showCLILine($fileSystem);
		else
			self::noVolumes();
        }

	static function showCLILine($dfFileSystem)
	{
		$format2="%-55s %-10s %-5s %7d %7d %10d %5d  %-s\n";
		printf($format2,$dfFileSystem->device,
				$dfFileSystem->type,
				$dfFileSystem->quotaYN,
				$dfFileSystem->storageGB,
				$dfFileSystem->usedGB,
				$dfFileSystem->availableGB,
				$dfFileSystem->percUse,
				$dfFileSystem->mountedOn);
	}

        static function showJSON()
        {
                echo json_encode(self::findFileSystems(),JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES)."\n";
        }

	static function purgeFstabBackups($commandAction)
	{
		$glob='/etc/fstab.ba*';
		echo "purging ...\n";
		syscommand_ls($glob);
		syscommand_rm($glob);
	}
}

