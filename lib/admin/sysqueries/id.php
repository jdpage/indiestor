<?php
/*
        Indiestor program

	Written by Erik Poupaert, erik@sankuru.biz
        Commissioned at peopleperhour.com 
        By Alex Gardiner, alex.gardiner@canterbury.ac.uk
*/

/*

Returns all groups in which a user is member. Example:

$ id -nG erik
erik adm dialout cdrom plugdev lpadmin admin sambashare

*/

function sysquery_id_nG($userName)
{
	//group names for user name
	$groupNamesForUserName=ShellCommand::query_fail_if_error("id -nG $userName");
        if($groupNamesForUserName==null) return array();
	return explode(' ',$groupNamesForUserName);
}

