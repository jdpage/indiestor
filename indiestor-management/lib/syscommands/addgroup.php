<?php
/*
        Indiestor program

	Written by Erik Poupaert, erik@sankuru.biz
        Commissioned at peopleperhour.com 
        By Alex Gardiner, alex.gardiner@canterbury.ac.uk
*/

<<<<<<< HEAD
require_once('ShellCommand.php');

=======
>>>>>>> added --volume -quota-remove --volumes -purge-fstab-backups
/*

Adds a group to the system. Example:

$ addgroup myfriends

*/

function syscommand_addgroup($groupName)
{
	ShellCommand::exec("addgroup $groupName");
}

