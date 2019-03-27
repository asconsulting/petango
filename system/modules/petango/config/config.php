<?php

/**
 * Petango Interface for Contao CMS 4.4+
 *
 * Copyright (C) 2018 Andrew Stevens Consulting
 *
 * @package    asconsulting/petango
 * @link       https://andrewstevens.consulting
 */

 

/**
* Back end modules
*/
if (!array_key_exists('petango', $GLOBALS['BE_MOD'])) {
	$GLOBALS['BE_MOD'] = array_merge(array('petango' => array()), $GLOBALS['BE_MOD']);
}

$GLOBALS['BE_MOD']['petango'] = array(
	'petango_config' => array (
		'tables' => array('tl_petango_config'),
		'update' => array('Petango\Updater', 'updateConfig')
	),
	'petango_animal' => array(
		'tables' => array('tl_petango_animal')
	),
	'petango_site' => array(
		'tables' => array('tl_petango_site', 'tl_petango_location')
	),
	'petango_species' => array(
		'tables' => array('tl_petango_species')
	)
);


/**
* Front end modules
*/
$GLOBALS['FE_MOD']['peerless']['petango_animal_list'] 		= 'Petango\Module\AnimalList';
$GLOBALS['FE_MOD']['peerless']['petango_animal_buddies'] 	= 'Petango\Module\AnimalBuddies';
$GLOBALS['FE_MOD']['peerless']['petango_animal_reader'] 	= 'Petango\Module\AnimalReader';
$GLOBALS['FE_MOD']['peerless']['petango_animal_search'] 	= 'Petango\Module\AnimalSearch';
$GLOBALS['FE_MOD']['peerless']['petango_site_list'] 		= 'Petango\Module\SiteList';
$GLOBALS['FE_MOD']['peerless']['petango_site_reader'] 		= 'Petango\Module\SiteReader';


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['getPageIdFromUrl'][] 					= array('Petango\Frontend\Animal', 'loadReaderPageFromUrl');
$GLOBALS['TL_HOOKS']['getPageIdFromUrl'][] 					= array('Petango\Frontend\Site', 'loadReaderPageFromUrl');


/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_petango_animal'] 					= 'Petango\Model\Animal';
$GLOBALS['TL_MODELS']['tl_petango_config'] 					= 'Petango\Model\Config';
$GLOBALS['TL_MODELS']['tl_petango_site'] 					= 'Petango\Model\Site';
$GLOBALS['TL_MODELS']['tl_petango_species'] 				= 'Petango\Model\Species';
$GLOBALS['TL_MODELS']['tl_petango_location'] 				= 'Petango\Model\Location';


/**
 * Cron Jobs
 */
//$GLOBALS['TL_CRON']['minutely'][] = array('Petango\Automator', 'updateConfigs');


/**
 * Styles
 */
 if (version_compare(VERSION, '4.4', '>=')) {
	$GLOBALS['TL_CSS'][] = 'system/modules/petango/assets/css/backend-contao4.css|static';
}
