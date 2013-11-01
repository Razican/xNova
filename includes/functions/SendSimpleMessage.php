<?php

/**
 * @package	xNova
 * @version	1.0.x
 * @since	1.0.0
 * @license	http://creativecommons.org/licenses/by-sa/3.0/ CC-BY-SA
 * @link	http://www.razican.com
 * @author	Razican <admin@razican.com>
 */

if ( ! defined('INSIDE')) die(header("Location:../../"));

	function SendSimpleMessage($Owner, $Sender, $Time, $Type, $From, $Subject, $Message)
	{

		if ($Time == '')
		{
			$Time = time();
		}

		$Message = ! strpos($Message, "/adm/") ? $Message : "";

		$QryInsertMessage  = "INSERT INTO `{{table}}` SET ";
		$QryInsertMessage .= "`message_owner` 	= '".$Owner 	."', ";
		$QryInsertMessage .= "`message_sender` 	= '".$Sender 	."', ";
		$QryInsertMessage .= "`message_time` 	= '".$Time 	."', ";
		$QryInsertMessage .= "`message_type` 	= '".$Type 	."', ";
		$QryInsertMessage .= "`message_from` 	= '".$From 	."', ";
		$QryInsertMessage .= "`message_subject` = '". $Subject."', ";
		$QryInsertMessage .= "`message_text` 	= '".$Message 	."';";

		doquery($QryInsertMessage, 'messages');

		$QryUpdateUser  = "UPDATE `{{table}}` SET ";
		$QryUpdateUser .= "`new_message` = `new_message` + 1 ";
		$QryUpdateUser .= "WHERE ";
		$QryUpdateUser .= "`id` = '".$Owner."';";
		doquery($QryUpdateUser, "users");
	}

?>