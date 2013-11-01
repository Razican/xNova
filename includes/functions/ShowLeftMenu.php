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

function ShowLeftMenu ()
{
	global $lang, $user;

	$parse					= $lang;
	$parse['year']			= date("Y");
	$parse['dpath']			= DPATH;
	$parse['version']   	= VERSION;
	$parse['servername']	= read_config('game_name');
	$parse['forum_url']     = read_config('forum_url');
	$parse['user_rank']     = $user['total_rank'];

	if (AUTHLEVEL > 0)
	{
		$parse['admin_link']	="<tr><td><div align=\"center\"><a href=\"admin.php\" target=\"_top\"> <font color=\"lime\">".$lang['lm_administration']."</font></a></div></td></tr>";
	}
	else
	{
		$parse['admin_link']  	= "";
	}

	return parsetemplate(gettemplate('general/left_menu'), $parse);
}


/* End of file ShowLeftMenu.php */
/* Location: ./includes/functions/ShowLeftMenu.php */
