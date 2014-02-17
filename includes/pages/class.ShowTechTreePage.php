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

class ShowTechTreePage
{
	function __construct($CurrentUser, $CurrentPlanet)
	{
		global $resource, $requeriments, $lang;

		$parse = $lang;

		$TechTreeHeadTPL	= gettemplate('techtree/techtree_head');
		$TechTreeRowTPL 	= gettemplate('techtree/techtree_row');
		$page				= '';

		foreach ($lang['tech'] as $Element => $ElementName)
		{
			if ($Element < 600)
			{
				$parse            = array();
				$parse['tt_name'] = $ElementName;

				if ( ! isset($resource[$Element]))
				{
					$parse['Requirements']  = $lang['tt_requirements'];
					$page                  .= parsetemplate($TechTreeHeadTPL, $parse);
				}
				else
				{
					if (isset($requeriments[$Element]))
					{
						$parse['required_list'] = "";
						foreach ($requeriments[$Element] as $ResClass => $Level)
						{
							if (isset($CurrentUser[$resource[$ResClass]]) && $CurrentUser[$resource[$ResClass]] >= $Level)
								$parse['required_list'] .= "<font color=\"#00ff00\">";
							elseif (isset($CurrentPlanet[$resource[$ResClass]]) && $CurrentPlanet[$resource[$ResClass]] >= $Level)
								$parse['required_list'] .= "<font color=\"#00ff00\">";
							else
								$parse['required_list'] .= "<font color=\"#ff0000\">";

							$parse['required_list'] .= $lang['tech'][$ResClass]." (".$lang['tt_lvl'].$Level.")";
							$parse['required_list'] .= "</font><br>";
						};
					}
					else
					{
						$parse['required_list'] = "";
					}
					$parse['tt_info']   = $Element;
					$page              .= parsetemplate($TechTreeRowTPL, $parse);
				}
			}
		}

		$parse['techtree_list'] = $page;

		return display(parsetemplate(gettemplate('techtree/techtree_body'), $parse));
	}
}
?>