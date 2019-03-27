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
 * Table tl_petango_species
 */
$GLOBALS['TL_DCA']['tl_petango_species'] = array
(
 
    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'enableVersioning'            => true,
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
                'alias' => 'index'
            )
        )
    ),
 
    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 1,
            'fields'                  => array('name'),
            'flag'                    => 11,
            'panelLayout'             => 'sort,filter;search,limit'
        ),
        'label' => array
        (
            'fields'                  => array('name'),
            'showColumns'             => true,
            'format'                  => '%s'
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_petango_species']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_petango_species']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.gif'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_petango_species']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_petango_species']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            )
        )
    ),
 
    // Palettes
    'palettes' => array
    (
        'default'                     => '{species_legend},name,alias,source_config,petango_id;'
    ),
 
    // Fields
    'fields' => array
    (
	
        'id' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_species']['alias'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'search'                  => true,
			'eval'                    => array('unique'=>true, 'rgxp'=>'alias', 'doNotCopy'=>true, 'maxlength'=>64, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('Petango\Backend\Species', 'generateAlias')
			),
			'sql'                     => "varchar(64) COLLATE utf8_bin NOT NULL default ''"

		),
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_species']['name'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('tl_class'=>'clr w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'source_config' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_species']['source_config'],
			'filter'                  => true,
			'inputType'               => 'select',
			'eval'                    => array('tl_class'=>'clr w50'),
			'foreignKey'              => 'tl_petango_config.name',
			'relation'                => array('type'=>'hasOne', 'load'=>'lazy'),	
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),		
		'petango_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_species']['petango_id'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>64, 'tl_class'=>'clr w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		)
    )
);
