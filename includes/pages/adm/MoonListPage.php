<?php

/**
 * @package	xNova
 * @version	1.0.x
 * @since	1.0.0
 * @license	http://creativecommons.org/licenses/by-sa/3.0/ CC-BY-SA
 * @link	http://www.razican.com
 * @author	Razican <admin@razican.com>
 */

define('INSIDE' , TRUE);
define('INSTALL', FALSE);
define('IN_ADMIN', TRUE);
define('XN_ROOT', './../');

require(XN_ROOT.'global.php');
require('AdminFunctions/Autorization.php');

if ($Observation != 1) die();

	$parse	= $lang;
	$query 	= doquery("SELECT * FROM `{{table}}` WHERE `planet_type` = '3'", "planets");
	$i 		= 0;

	while ($u = $query->fetch_array())
	{
		$parse['moon'] .= "<tr>"
		."<th>".$u[0]."</th>"
		."<th>".$u[1]."</th>"
		."<th>".$u[2]."</th>"
		."<th>".$u[4]."</th>"
		."<th>".$u[5]."</th>"
		."<th>".$u[6]."</th>"
		."</tr>";
		$i++;
	}

	if ($i == "1")
		$parse['moon'] .= "<tr><th class=b colspan=6>".$lang['mt_only_one_moon']."</th></tr>";
	else
		$parse['moon'] .= "<tr><th class=b colspan=6>".$lang['mt_there_are'].$i.$lang['mt_moons']."</th></tr>";

	display(parsetemplate(gettemplate('adm/MoonListBody'), $parse), FALSE, '', TRUE, FALSE);
?>