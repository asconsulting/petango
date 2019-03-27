<?php

/**
 * Peerless Products
 *
 * Copyright (C) 2018 Andrew Stevens Consulting
 *
 * @package    asconsulting/peerless_products
 * @link       https://andrewstevens.consulting
 */


 
/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['petango_animal_list'] 		= '{title_legend},name,headline,type;{redirect_legend},jumpTo;{template_legend:hide},customTpl,customAnimalTpl;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['petango_animal_reader'] 	= '{title_legend},name,headline,type;{template_legend:hide},customAnimalTpl;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['petango_animal_search'] 	= '{title_legend},name,headline,type;{template_legend:hide},customTpl,customAnimalTpl;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['petango_site_list'] 		= '{title_legend},name,headline,type;{template_legend:hide},customTpl,customSiteTpl;{expert_legend:hide},guests,cssID,space';
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