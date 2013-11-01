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

function CreateOneMoonRecord($Galaxy, $System, $Planet, $Owner, $MoonID, $MoonName, $Chance)
{
	global $lang, $user;

	$PlanetName            = "";

	$QryGetMoonPlanetData  = "SELECT * FROM `{{table}}` ";
	$QryGetMoonPlanetData .= "WHERE ";
	$QryGetMoonPlanetData .= "`galaxy` = '".$Galaxy."' && ";
	$QryGetMoonPlanetData .= "`system` = '".$System."' && ";
	$QryGetMoonPlanetData .= "`planet` = '".$Planet."';";
	$MoonPlanet = doquery($QryGetMoonPlanetData, 'planets', TRUE);

	$QryGetMoonGalaxyData  = "SELECT * FROM `{{table}}` ";
	$QryGetMoonGalaxyData .= "WHERE ";
	$QryGetMoonGalaxyData .= "`galaxy` = '".$Galaxy."' && ";
	$QryGetMoonGalaxyData .= "`system` = '".$System."' && ";
	$QryGetMoonGalaxyData .= "`planet` = '".$Planet."';";
	$MoonGalaxy = doquery($QryGetMoonGalaxyData, 'galaxy', TRUE);

	if ($MoonGalaxy['id_luna'] == 0)
	{
		if ($MoonPlanet['id'])
		{
			$SizeMin                = 2000 + ($Chance * 100);

			$SizeMax                = 6000 + ($Chance * 200);

			$PlanetName             = $MoonPlanet['name'];

			$maxtemp                = $MoonPlanet['temp_max'] - rand(10, 45);
			$mintemp                = $MoonPlanet['temp_min'] - rand(10, 45);
			$size                   = rand($SizeMin, $SizeMax);

			$QryInsertMoonInPlanet  = "INSERT INTO `{{table}}` SET ";
			$QryInsertMoonInPlanet .= "`name` = '".(($MoonName == '') ? $lang['fcm_moon'] : $MoonName)."', ";
			$QryInsertMoonInPlanet .= "`id_owner` = '".$Owner."', ";
			$QryInsertMoonInPlanet .= "`galaxy` = '".$Galaxy."', ";
			$QryInsertMoonInPlanet .= "`system` = '".$System."', ";
			$QryInsertMoonInPlanet .= "`planet` = '".$Planet."', ";
			$QryInsertMoonInPlanet .= "`last_update` = '".time()."', ";
			$QryInsertMoonInPlanet .= "`planet_type` = '3', ";
			$QryInsertMoonInPlanet .= "`image` = 'mond', ";
			$QryInsertMoonInPlanet .= "`diameter` = '".$size."', ";
			$QryInsertMoonInPlanet .= "`field_max` = '1', ";
			$QryInsertMoonInPlanet .= "`temp_min` = '".$mintemp."', ";
			$QryInsertMoonInPlanet .= "`temp_max` = '".$maxtemp."', ";
			$QryInsertMoonInPlanet .= "`metal` = '0', ";
			$QryInsertMoonInPlanet .= "`metal_perhour` = '0', ";
			$QryInsertMoonInPlanet .= "`metal_max` = '".BASE_STORAGE_SIZE."', ";
			$QryInsertMoonInPlanet .= "`crystal` = '0', ";
			$QryInsertMoonInPlanet .= "`crystal_perhour` = '0', ";
			$QryInsertMoonInPlanet .= "`crystal_max` = '".BASE_STORAGE_SIZE."', ";
			$QryInsertMoonInPlanet .= "`deuterium` = '0', ";
			$QryInsertMoonInPlanet .= "`deuterium_perhour` = '0', ";
			$QryInsertMoonInPlanet .= "`deuterium_max` = '".BASE_STORAGE_SIZE."';";
			doquery($QryInsertMoonInPlanet, 'planets');

			$QryGetMoonIdFromPlanet  = "SELECT * FROM `{{table}}` ";
			$QryGetMoonIdFromPlanet .= "WHERE ";
			$QryGetMoonIdFromPlanet .= "`galaxy` = '". $Galaxy."' && ";
			$QryGetMoonIdFromPlanet .= "`system` = '". $System."' && ";
			$QryGetMoonIdFromPlanet .= "`planet` = '". $Planet."' && ";
			$QryGetMoonIdFromPlanet .= "`planet_type` = '3';";
			$lunarow = doquery($QryGetMoonIdFromPlanet, 'planets', TRUE);

			$QryUpdateMoonInGalaxy  = "UPDATE `{{table}}` SET ";
			$QryUpdateMoonInGalaxy .= "`id_luna` = '".$lunarow['id']."', ";
			$QryUpdateMoonInGalaxy .= "`luna` = '0' ";
			$QryUpdateMoonInGalaxy .= "WHERE ";
			$QryUpdateMoonInGalaxy .= "`galaxy` = '".$Galaxy."' && ";
			$QryUpdateMoonInGalaxy .= "`system` = '".$System."' && ";
			$QryUpdateMoonInGalaxy .= "`planet` = '".$Planet."';";
			doquery($QryUpdateMoonInGalaxy, 'galaxy');

		}
	}

	return $PlanetName;
}

?>