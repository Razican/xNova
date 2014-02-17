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

	function IsElementBuyable($CurrentUser, $CurrentPlanet, $Element, $Incremental = TRUE, $ForDestroy = FALSE)
	{
		global $pricelist, $resource;

		require_once(XN_ROOT.'includes/functions/IsVacationMode.php');

		if (IsVacationMode($CurrentUser))
		   return FALSE;

		if ($Incremental)
			$level  = (isset($CurrentPlanet[$resource[$Element]])) ? $CurrentPlanet[$resource[$Element]] : $CurrentUser[$resource[$Element]];

		$RetValue = TRUE;
		$array    = array('metal', 'crystal', 'deuterium', 'energy_max');

		foreach ($array as $ResType)
		{
			if (isset($pricelist[$Element][$ResType]) && $pricelist[$Element][$ResType] != 0)
			{
				if ($Incremental)
					$cost[$ResType]  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
				else
					$cost[$ResType]  = floor($pricelist[$Element][$ResType]);

				if ($ForDestroy)
					$cost[$ResType]  = floor($cost[$ResType] / 4);

				if ($cost[$ResType] > $CurrentPlanet[$ResType])
					$RetValue = FALSE;
			}
		}
		return $RetValue;
	}

?>