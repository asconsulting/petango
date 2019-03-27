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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_petango_config']['name'] 					= array('Name', 'Please enter the name');
$GLOBALS['TL_LANG']['tl_petango_config']['alias'] 					= array('Alias', 'Please enter an alias');
$GLOBALS['TL_LANG']['tl_petango_config']['source_config'] 			= array('Source Configuration', 'Please select the parent configuration');
$GLOBALS['TL_LANG']['tl_petango_config']['petango_id'] 				= array('Petango', 'Petango ID of the animal');
$GLOBALS['TL_LANG']['tl_petango_config']['species'] 				= array('Species', 'Species of the animal');
$GLOBALS['TL_LANG']['tl_petango_config']['animal_type'] 			= array('Animal Type', 'Type of animal');

$GLOBALS['TL_LANG']['tl_petango_config']['description'] 			= array('Description', 'Description of animal');
$GLOBALS['TL_LANG']['tl_petango_config']['sex'] 					= array('Sex', 'Sex/gender of animal');
$GLOBALS['TL_LANG']['tl_petango_config']['spayed_neutered'] 		= array('Spayed/Neutered', 'Indicate if the animal is spayed or neutered');
$GLOBALS['TL_LANG']['tl_petango_config']['age_group'] 				= array('Age Group', 'Age group of the animal');
$GLOBALS['TL_LANG']['tl_petango_config']['age'] 					= array('Age', 'Age of the animal');
$GLOBALS['TL_LANG']['tl_petango_config']['date_of_birth'] 			= array('Date of Birth', 'Date of birth of the animal');
$GLOBALS['TL_LANG']['tl_petango_config']['microchip_id'] 			= array('Microchip ID', 'ID number of animal\'s microchip');
$GLOBALS['TL_LANG']['tl_petango_config']['breed_primary'] 			= array('Primary Breed', 'Primary breed of the animal');
$GLOBALS['TL_LANG']['tl_petango_config']['breed_secondary']			= array('Secondary Breed', 'Secondary breed of the animal');
$GLOBALS['TL_LANG']['tl_petango_config']['color_primary'] 			= array('Primary Color', 'Primary color of animal');
$GLOBALS['TL_LANG']['tl_petango_config']['color_secondary'] 		= array('Secondary Color', 'Secondary color of animal');
$GLOBALS['TL_LANG']['tl_petango_config']['color_pattern'] 			= array('Color Pattern', 'Color pattern of animal');
$GLOBALS['TL_LANG']['tl_petango_config']['size'] 					= array('Size', 'Size of animal');
$GLOBALS['TL_LANG']['tl_petango_config']['weight'] 					= array('Weight', 'Animal\'s weight');
$GLOBALS['TL_LANG']['tl_petango_config']['altered']					= array('Altered', 'Is animal altered');
$GLOBALS['TL_LANG']['tl_petango_config']['declawed'] 				= array('Declawed', 'Animal is declawed');

$GLOBALS['TL_LANG']['tl_petango_config']['images']					= array('Images', 'Image of the animal');
$GLOBALS['TL_LANG']['tl_petango_config']['remote_images'] 			= array('Remote Images', 'URLs for image of the animal');
$GLOBALS['TL_LANG']['tl_petango_config']['additional_media'] 		= array('Additional Media', 'Additional media for animal');
$GLOBALS['TL_LANG']['tl_petango_config']['video_id'] 				= array('Video ID', 'Petango video ID for animal');

$GLOBALS['TL_LANG']['tl_petango_config']['reference_num'] 			= array('Reference #', 'Reference (ARN) number for animal');
$GLOBALS['TL_LANG']['tl_petango_config']['buddy_animals']		 	= array('Buddy Animal(s)', 'Indicate if this animal has a buddy animal(s)');
$GLOBALS['TL_LANG']['tl_petango_config']['site'] 					= array('Site', 'Site animal is located at');
$GLOBALS['TL_LANG']['tl_petango_config']['location'] 				= array('Location', 'Location of the animal');
$GLOBALS['TL_LANG']['tl_petango_config']['sublocation'] 			= array('Sub-Location', 'Sub location of the animal');
$GLOBALS['TL_LANG']['tl_petango_config']['stage'] 					= array('Stage', 'Stage of adoption process');
$GLOBALS['TL_LANG']['tl_petango_config']['on_hold'] 				= array('On Hold', 'On Hold');
$GLOBALS['TL_LANG']['tl_petango_config']['featured'] 				= array('Featured', 'Featured animal');
$GLOBALS['TL_LANG']['tl_petango_config']['date_added'] 				= array('Date Added', 'Date animal was added');
$GLOBALS['TL_LANG']['tl_petango_config']['date_deactivated'] 		= array('Date Deactivated', 'Date animal was deactivated');
$GLOBALS['TL_LANG']['tl_petango_config']['last_update'] 			= array('Last Update', 'Date animal was last syncronized');

$GLOBALS['TL_LANG']['tl_petango_config']['adoption_url'] 			= array('Adoption URL', 'Url to adoption form');
$GLOBALS['TL_LANG']['tl_petango_config']['adoption_cost'] 			= array('Adoption Cost', 'Cost to adopt this animal');

$GLOBALS['TL_LANG']['tl_petango_config']['surrender_reason'] 		= array('Reason Surrendered', 'Reason for animal surrender');
$GLOBALS['TL_LANG']['tl_petango_config']['previous_env'] 			= array('Previous Environment', 'Previous living environment of animal');
$GLOBALS['TL_LANG']['tl_petango_config']['time_in_former_home'] 	= array('Time in Former Home', 'Time animal lived in former home');
$GLOBALS['TL_LANG']['tl_petango_config']['house_trained'] 			= array('House Trained', 'Animal is house trained');
$GLOBALS['TL_LANG']['tl_petango_config']['lived_with_children'] 	= array('Lived with Children', 'Animal has lived with children');
$GLOBALS['TL_LANG']['tl_petango_config']['lived_with_animals'] 		= array('Lived with Animals', 'Animal has lived with other animals');
$GLOBALS['TL_LANG']['tl_petango_config']['lived_with_types'] 		= array('Lived with Animal Types', 'Animal has lived with other indicated animal types');
$GLOBALS['TL_LANG']['tl_petango_config']['last_intake_date'] 		= array('Last Intake Date', 'Date animal was last taken in');
$GLOBALS['TL_LANG']['tl_petango_config']['surrender_date'] 			= array('Surrender Date', 'Date animal was surrendered in');

$GLOBALS['TL_LANG']['tl_petango_config']['no_dogs'] 				= array('No Dogs', 'Animal can not live with dogs');
$GLOBALS['TL_LANG']['tl_petango_config']['no_cats'] 				= array('No Cats', 'Animal can not live with cats');
$GLOBALS['TL_LANG']['tl_petango_config']['no_kids'] 				= array('No Kids', 'Animal can not live with kids');
$GLOBALS['TL_LANG']['tl_petango_config']['special_needs'] 			= array('Special Needs', 'Animal has special needs');
$GLOBALS['TL_LANG']['tl_petango_config']['memo_list'] 				= array('Memo List', 'Memo list');
$GLOBALS['TL_LANG']['tl_petango_config']['behavior_result'] 		= array('Behavior Result', 'Result of behavior test');
$GLOBALS['TL_LANG']['tl_petango_config']['behavior_test_list'] 		= array('Behavior Test List', 'Behavior test list');
$GLOBALS['TL_LANG']['tl_petango_config']['wildlife_intake_injury'] 	= array('Wildlife Intake Injury', 'Featured animal');
$GLOBALS['TL_LANG']['tl_petango_config']['wildlife_intake_cause'] 	= array('Wildlife Intake Cause', 'Featured animal');

$GLOBALS['TL_LANG']['tl_petango_config']['active'] 					= array('Active', 'Show this animal on the frontend');


/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_petango_config']['animal_legend'] 			= 'Animal Information';
$GLOBALS['TL_LANG']['tl_petango_config']['detail_legend'] 			= 'Animal Details';
$GLOBALS['TL_LANG']['tl_petango_config']['adoption_legend'] 		= 'Adoption Details';
$GLOBALS['TL_LANG']['tl_petango_config']['media_legend'] 			= 'Animal Media';
$GLOBALS['TL_LANG']['tl_petango_config']['petango_legend'] 			= 'Petango Details';
$GLOBALS['TL_LANG']['tl_petango_config']['intake_legend'] 			= 'Intake Details';
$GLOBALS['TL_LANG']['tl_petango_config']['evaluations_legend'] 		= 'Evaluations';
$GLOBALS['TL_LANG']['tl_petango_config']['publish_legend'] 			= 'Publish';
 
 
/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_petango_config']['update'] 					= array('Update Data', 'Manually update data for this configuration');
$GLOBALS['TL_LANG']['tl_petango_config']['new'] 					= array('New configuration', 'Add a new configuration');
$GLOBALS['TL_LANG']['tl_petango_config']['show'] 					= array('Configuration details', 'Show the details of configuration ID %s');
$GLOBALS['TL_LANG']['tl_petango_config']['edit'] 					= array('Edit configuration', 'Edit configuration ID %s');
$GLOBALS['TL_LANG']['tl_petango_config']['copy'] 					= array('Copy configuration', 'Copy configuration ID %s');
$GLOBALS['TL_LANG']['tl_petango_config']['delete'] 					= array('Delete configuration', 'Delete configuration ID %s');
$GLOBALS['TL_LANG']['tl_petango_config']['toggle'] 					= array('Toggle configuration', 'Toggle configuration ID %s');
