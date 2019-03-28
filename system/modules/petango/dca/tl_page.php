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
$GLOBALS['TL_DCA']['tl_page']['palettes']['regular'] = str_replace('{publish_legend}', '{petango_legend},petango_animal_reader,petango_site_reader;{publish_legend}', $GLOBALS['TL_DCA']['tl_page']['palettes']['regular']);


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_page']['fields']['petango_animal_reader'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['petango_animal_reader'],
    'inputType'               => 'checkbox',
    'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'clr m12 w50'),
    'sql'                     => "char(1) NOT NULL default ''",
);
 
$GLOBALS['TL_DCA']['tl_page']['fields']['petango_site_reader'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['petango_site_reader'],
    'inputType'               => 'checkbox',
    'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'m12 w50'),
    'sql'                     => "char(1) NOT NULL default ''",
);
