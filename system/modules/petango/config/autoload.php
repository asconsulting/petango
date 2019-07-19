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
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'Petango\Backend\Animal' 			=> 'system/modules/petango/library/Petango/Backend/Animal.php',
	'Petango\Backend\Config' 			=> 'system/modules/petango/library/Petango/Backend/Config.php',
	'Petango\Backend\Location' 			=> 'system/modules/petango/library/Petango/Backend/Location.php',
	'Petango\Backend\Site' 				=> 'system/modules/petango/library/Petango/Backend/Site.php',
	'Petango\Backend\Species' 			=> 'system/modules/petango/library/Petango/Backend/Species.php',
	'Petango\Backend\Module' 			=> 'system/modules/petango/library/Petango/Backend/Module.php',
	
	'Petango\Frontend\Animal' 			=> 'system/modules/petango/library/Petango/Frontend/Animal.php',
	'Petango\Frontend\Site' 			=> 'system/modules/petango/library/Petango/Frontend/Site.php',
	
	'Petango\Model\Animal' 				=> 'system/modules/petango/library/Petango/Model/Animal.php',
	'Petango\Model\Config' 				=> 'system/modules/petango/library/Petango/Model/Config.php',
	'Petango\Model\Site' 				=> 'system/modules/petango/library/Petango/Model/Site.php',
	'Petango\Model\Location' 			=> 'system/modules/petango/library/Petango/Model/Location.php',
	'Petango\Model\Species' 			=> 'system/modules/petango/library/Petango/Model/Species.php',
	
    'Petango\Module\AnimalList' 		=> 'system/modules/petango/library/Petango/Module/AnimalList.php',
    'Petango\Module\AnimalBuddies' 		=> 'system/modules/petango/library/Petango/Module/AnimalBuddies.php',
	'Petango\Module\AnimalReader' 		=> 'system/modules/petango/library/Petango/Module/AnimalReader.php',
	'Petango\Module\AnimalRandom' 		=> 'system/modules/petango/library/Petango/Module/AnimalRandom.php',
	'Petango\Module\AnimalSearch' 		=> 'system/modules/petango/library/Petango/Module/AnimalSearch.php',
    'Petango\Module\SiteList' 			=> 'system/modules/petango/library/Petango/Module/SiteList.php',
	'Petango\Module\SiteReader' 		=> 'system/modules/petango/library/Petango/Module/SiteReader.php',
	
	'Petango\Updater' 					=> 'system/modules/petango/library/Petango/Updater.php',	
	'Petango\Automator' 				=> 'system/modules/petango/library/Petango/Automator.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
    'mod_animal_list' 					=> 'system/modules/petango/templates/modules',
    'mod_animal_buddies' 				=> 'system/modules/petango/templates/modules',
    'mod_animal_reader' 				=> 'system/modules/petango/templates/modules',
    'mod_animal_random' 				=> 'system/modules/petango/templates/modules',
    'mod_animal_search' 				=> 'system/modules/petango/templates/modules',
    'mod_site_list' 					=> 'system/modules/petango/templates/modules',
    'mod_site_reader' 					=> 'system/modules/petango/templates/modules',
	
    'petango_animal' 					=> 'system/modules/petango/templates/items',
    'petango_animal_list' 				=> 'system/modules/petango/templates/items',
    'petango_animal_reader' 			=> 'system/modules/petango/templates/items',
    'petango_animal_random' 			=> 'system/modules/petango/templates/items',
    'petango_animal_full' 				=> 'system/modules/petango/templates/items',
    'petango_site' 						=> 'system/modules/petango/templates/items',
));
