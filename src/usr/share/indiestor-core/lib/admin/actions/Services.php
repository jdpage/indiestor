<?php
/*
        Indiestor program
        Concept, requirements, specifications, and unit testing
        By Alex Gardiner, alex@indiestor.com
        Written by Erik Poupaert, erik@sankuru.biz
        Commissioned at peopleperhour.com 
        Licensed under the GPL
*/

class Services extends EntityType
{
	static function startSamba($commandAction)
	{
                self::initdServiceAction('samba','start');
	}

	static function stopSamba($commandAction)
	{
                self::initdServiceAction('samba','stop');
	}

	static function startIncron($commandAction)
	{
                self::initdServiceAction('incron','start');
	}

	static function stopIncron($commandAction)
	{
                self::initdServiceAction('incron','stop');
	}

        static function findSambaServiceName()
        {
                $stdout=ShellCommand::query("uname -a");
                if(preg_match('/Ubuntu/',$stdout)) return 'smbd';
                else return 'samba';
        }

        static function initdServiceAction($serviceName,$action)
        {
                if($serviceName=='samba')
                        $serviceName=self::findSambaServiceName();
                ShellCommand::exec("/etc/init.d/$serviceName $action");
        }

        static function upstartServiceStatus($serviceName)
        {
                if($serviceName=='samba')
                        $serviceName=self::findSambaServiceName();
                $stdout=ShellCommand::query("service $serviceName status");
                if(preg_match('/not|stop/',$stdout)) return false;
                else return true;
        }

        static function status()
        {
                $status=array();
                $status['samba']=self::upstartServiceStatus('samba');
                $status['incron']=self::upstartServiceStatus('incron');
                $countPids=InotifyWait::statusWatchingAll();
                if($countPids>0)
                        $status['watching']=true;
                else    $status['watching']=false;
                return $status;
        }

        static function show($commandAction)
        {
                if(ProgramActions::actionExists('json'))
                        self::showJSON();
                else
                        self::showCLI();
        }

        static function showCLI()
        {
                $status=self::status();
                foreach($status as $service=>$serviceStatus) 
                {
                        if($serviceStatus) $situation='running';
                        else $situation='not running';
                        echo "$service $situation\n";
                }                                
        }

        static function showJSON()
        {
                echo json_encode_legacy(self::status())."\n";
        }

        static function json($commandAction)
        {
                //handled by show command
                return;
        }
}

