<?php
/*
        Indiestor program

	Written by Erik Poupaert, erik@sankuru.biz
        Commissioned at peopleperhour.com 
        By Alex Gardiner, alex.gardiner@canterbury.ac.uk
*/

define('ERRNUM_NO_ACTIONS_JUST_OPTIONS_SPECIFIED',10);
define('ERRNUM_USER_EXISTS_ALREADY',50);
define('ERRNUM_GROUP_EXISTS_ALREADY',51);
define('ERRNUM_GROUP_DOES_NOT_EXISTS',52);
define('ERRNUM_USER_DOES_NOT_EXIST',53);
define('ERRNUM_GROUP_DOES_NOT_EXIST',54);
define('ERRNUM_CANNOT_ADD_INDIESTOR_SYSUSER',56);
define('ERRNUM_USERNAME_INVALID_CHARACTERS',57);
define('ERRNUM_GROUPNAME_INVALID_CHARACTERS',58);
define('ERRNUM_MOVE_HOME_CONTENT_WITHOUT_SET_HOME',59);
define('ERRNUM_CANNOT_MOVE_HOME_CONTENT_TO_EXISTING_FOLDER',60);
define('ERRNUM_CANNOT_MOVE_HOME_TO_NON_FOLDER',61);
define('ERRNUM_HOME_FOLDER_MUST_BE_ABSOLUTE_PATH',62);
define('ERRNUM_REMOVE_HOME_CONTENT_WITHOUT_DELETE',63);
define('ERRNUM_HOME_FOLDER_ALREADY_BELONGS_TO_USER',64);
define('ERRNUM_VOLUME_DEVICE_CANNOT_FIND_UUID',65);
define('ERRNUM_VOLUME_CANNOT_FIND_DEVICE_NOR_UUID',66);
define('ERRNUM_CANNOT_FIND_BLOCKSIZE_FOR_DEVICE',69);
define('ERRNUM_QUOTA_NOT_NUMERIC',70);
define('ERRNUM_INVALID_MOUNT_POINT_FOLDER',73);
define('ERRNUM_VOLUMENAME_INVALID_CHARACTERS',75);
define('ERRNUM_FOLDERNAME_INVALID_CHARACTERS',76);
define('ERRNUM_CANNOT_SWITCH_ON_QUOTA_FOR_DEVICE',77);
define('ERRNUM_PARENT_OF_HOME_NOT_FOLDER',78);

define('WARNING_USER_ALREADY_LOCKED',500);
define('WARNING_QUOTA_ALREADY_ON_FOR_DEVICE',501);
define('WARNING_QUOTA_ALREADY_OFF_FOR_DEVICE',502);
define('WARNING_REMOVE_USER_QUOTA_ON_DEVICE_QUOTA_NOT_ENABLED',503);
define('WARNING_QUOTA_ALREADY_REMOVED_FOR_DEVICE',504);
define('WARNING_USER_NOT_MEMBER_OF_ANY_GROUP',505);
