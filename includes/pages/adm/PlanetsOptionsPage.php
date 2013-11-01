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

if ($EditUsers != 1) die();

$parse	=	$lang;


$mode      = $_POST['mode'];

if ($mode == 'agregar')
{
	$id            = $_POST['id'];
	$galaxy        = $_POST['galaxy'];
	$system        = $_POST['system'];
	$planet        = $_POST['planet'];

	$i	=	0;
	$QueryS	=	doquery("SELECT * FROM `{{table}}` WHERE `galaxy` = '".$galaxy."' && `system` = '".$system."' && `planet` = '".$planet."'", "galaxy", TRUE);
	$QueryS2	=	doquery("SELECT * FROM `{{table}}` WHERE `id` = '".$id."'", "users", TRUE);
	if (is_numeric($_POST['id']) && isset($_POST['id']) && ! $QueryS && $QueryS2)
	{
		if ($galaxy < 1 OR $system < 1 OR $planet < 1 OR ! is_numeric($galaxy) OR ! is_numeric($system) OR ! is_numeric($planet)){
			$Error	.=	'<tr><th colspan="2"><font color=red>'.$lang['po_complete_all'].'</font></th></tr>';
			$i++;}


		if ($galaxy > MAX_GALAXY_IN_WORLD OR $system > MAX_SYSTEM_IN_GALAXY OR $planet > MAX_PLANET_IN_SYSTEM){
			$Error	.=	'<tr><th colspan="2"><font color=red>'.$lang['po_complete_all2'].'</font></th></tr>';
			$i++;}

		if ($i	==	0)
		{
			CreateOnePlanetRecord ($galaxy, $system, $planet, $id, '', '', FALSE) ;
			$QueryS3	=	doquery("SELECT * FROM `{{table}}` WHERE `id_owner` = '".$id."'", "planets", TRUE);
			doquery("UPDATE `{{table}}` SET `id_level` = '".$QueryS3['id_level']."' WHERE
			`galaxy` = '".$galaxy."' && `system` = '".$system."' && `planet` = '".$planet."' && `planet_type` = '1'", "planets");
			$parse['display']	=	'<tr><th colspan="2"><font color=lime>'.$lang['po_complete_succes'].'</font></th></tr>';
		}
		else
		{
			$parse['display']	=	$Error;
		}
	}
	else
	{
		$parse['display']	=	'<tr><th colspan="2"><font color=red>'.$lang['po_complete_all'].'</font></th></tr>';
	}
}
elseif ($mode == 'borrar')
{
	$id	=	$_POST['id'];
	if (is_numeric($id) && isset($id))
	{
		$QueryS	=	doquery("SELECT * FROM `{{table}}` WHERE `id` = '".$id."'", "planets", TRUE);

		if ($QueryS)
		{
			if ($QueryS['planet_type'] == '1')
			{
				$QueryS2	=	doquery("SELECT * FROM `{{table}}` WHERE `id_planet` = '".$id."'", "galaxy", TRUE);
				if ($QueryS2['id_luna'] > 0)
				{
					doquery("DELETE FROM `{{table}}` WHERE `galaxy` = '".$QueryS['galaxy']."' && `system` = '".$QueryS['system']."' &&
						`planet` = '".$QueryS['planet']."' && `planet_type` = '3'", "planets");
				}
				doquery("DELETE FROM `{{table}}` WHERE `id` = '".$id."'", 'planets');
				doquery("DELETE FROM `{{table}}` WHERE `id_planet` ='".$id."'", 'galaxy');
				$Error	.=	'<tr><th colspan="2"><font color=lime>'.$lang['po_complete_succes2'].'</font></th></tr>';
			}
			else
			{
				$Error	.=	'<tr><th colspan="2"><font color=red>'.$lang['po_complete_invalid3'].'</font></th></tr>';
			}
		}
		else
		{
			$Error	.=	'<tr><th colspan="2"><font color=red>'.$lang['po_complete_invalid2'].'</font></th></tr>';
		}
	}
	else
	{
		$Error	.=	'<tr><th colspan="2"><font color=red>'.$lang['po_complete_invalid'].'</font></th></tr>';
	}

	$parse['display2']	=	$Error;
}


display(parsetemplate(gettemplate('adm/PlanetOptionsBody'),  $parse), FALSE, '', TRUE, FALSE);
?>