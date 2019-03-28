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
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['petango_animal_list'] 		= '{title_legend},name,headline,type;{petango_legend},animal_order,featured_animals,filter_sites,filter_locations,filter_stages,filter_on_hold,filter_species,filter_types,filter_breeds,filter_configs;{redirect_legend},jumpTo;{template_legend:hide},customTpl,customAnimalTpl;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['petango_animal_reader'] 	= '{title_legend},name,headline,type;{template_legend:hide},customAnimalTpl;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['petango_animal_search'] 	= '{title_legend},name,headline,type;{petango_legend},animal_order,featured_animals,filter_sites,filter_locations,filter_stages,filter_on_hold,filter_species,filter_types,filter_breeds,filter_configs;{redirect_legend},jumpTo;{template_legend:hide},customTpl,customAnimalTpl;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['petango_site_list'] 		= '{title_legend},name,headline,type;{petango_legend},filter_configs;{template_legend:hide},customTpl,customSiteTpl;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['petango_site_reader'] 		= '{title_legend},name,headline,type;{template_legend:hide},customSiteTpl;{expert_legend:hide},guests,cssID,space';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['customAnimalTpl'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['customAnimalTpl'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('Petango\Backend\Animal', 'getAnimalTemplates'),
	'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['customSiteTpl'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['customSiteTpl'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('Petango\Backend\Site', 'getSiteTemplates'),
	'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['animal_order'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['animal_order'],
	'filter'                  => true,
	'inputType'               => 'select',
	'options'				  => array('name'=>'Name', 'date_added_desc'=>'Date Added - Newest First', 'date_added_asc'=>'Date Added - Oldest First', 'age_desc'=>'Age - Oldest First', 'age_desc'=>'Age - Youngest First'),
	'eval'                    => array('tl_class'=>'clr w50', 'includeBlankOption'=>true),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['featured_animals'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['featured_animals'],
	'filter'                  => true,
	'inputType'               => 'select',
	'options'				  => array('mixed'=>'Mixed with other Animals', 'top'=>'Featured on Top', 'only'=>' Show Featured Only'),
	'eval'                    => array('mandatory'=>true, 'tl_class'=>'clr w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['filter_sites'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['filter_sites'],
	'filter'                  => true,
	'inputType'               => 'select',
	'foreignKey'              => 'tl_petango_site.name',
	'relation'                => array('type'=>'hasMany', 'load'=>'lazy'),	
	'eval'                    => array('multiple'=>true, 'chosen'=>true, 'tl_class'=>'clr w50', 'includeBlankOption'=>true),
	'sql'                     => "mediumtext NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['filter_locations'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['filter_locations'],
	'filter'                  => true,
	'inputType'               => 'select',
	'foreignKey'              => 'tl_petango_location.name',
	'relation'                => array('type'=>'hasMany', 'load'=>'lazy'),	
	'eval'                    => array('multiple'=>true, 'chosen'=>true, 'tl_class'=>'clr w50', 'includeBlankOption'=>true),
	'sql'                     => "mediumtext NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['filter_stages'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['filter_stages'],
	'filter'                  => true,
	'inputType'               => 'select',
	'options_callback'		  => array('Petango\Backend\Module', 'getStages'),
	'eval'                    => array('multiple'=>true, 'chosen'=>true, 'tl_class'=>'clr w50', 'includeBlankOption'=>true),
	'sql'                     => "mediumtext NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['filter_on_hold'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['filter_on_hold'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'clr'),
    'sql'                     => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['filter_species'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['filter_species'],
	'filter'                  => true,
	'inputType'               => 'select',
	'foreignKey'              => 'tl_petango_species.name',
	'relation'                => array('type'=>'hasMany', 'load'=>'lazy'),	
	'eval'                    => array('multiple'=>true, 'chosen'=>true, 'multiple'=>true, 'chosen'=>true, 'tl_class'=>'clr w50', 'includeBlankOption'=>true),
	'sql'                     => "mediumtext NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['filter_types'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['filter_types'],
	'filter'                  => true,
	'inputType'               => 'select',
	'options_callback'		  => array('Petango\Backend\Module', 'getTypes'),
	'eval'                    => array('multiple'=>true, 'chosen'=>true, 'tl_class'=>'clr w50', 'includeBlankOption'=>true),
	'sql'                     => "mediumtext NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['filter_breeds'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['filter_breeds'],
	'filter'                  => true,
	'inputType'               => 'select',
	'options_callback'		  => array('Petango\Backend\Module', 'getBreeds'),
	'eval'                    => array('multiple'=>true, 'chosen'=>true, 'tl_class'=>'clr w50', 'includeBlankOption'=>true),
	'sql'                     => "mediumtext NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['filter_configs'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['filter_configs'],
	'filter'                  => true,
	'inputType'               => 'select',
	'eval'                    => array('mandatory'=>true, 'multiple'=>true, 'chosen'=>true, 'tl_class'=>'clr w50'),
	'foreignKey'              => 'tl_petango_config.name',
	'relation'                => array('type'=>'hasMany', 'load'=>'lazy'),	
	'sql'                     => "mediumtext NULL"
);
