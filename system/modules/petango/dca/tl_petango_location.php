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
 * Table tl_petango_location
 */
$GLOBALS['TL_DCA']['tl_petango_location'] = array
(
 
    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
		'ptable'					  => 'tl_petango_site',
        'enableVersioning'            => true,
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
				'pid' => 'index',
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
                'label'               => &$GLOBALS['TL_LANG']['tl_petango_location']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_petango_location']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.gif'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_petango_location']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_petango_location']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('Petango\Backend\Location', 'toggleIcon')
			),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_petango_location']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            )
        )
    ),
 
    // Palettes
    'palettes' => array
    (
        'default'                     => '{location_legend},name,alias,source_config,petango_id;{active_legend},active;'
    ),
 
    // Fields
    'fields' => array
    (
	
        'id' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_location']['alias'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'search'                  => true,
			'eval'                    => array('unique'=>true, 'rgxp'=>'alias', 'doNotCopy'=>true, 'maxlength'=>64, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('Petango\Backend\Location', 'generateAlias')
			),
			'sql'                     => "varchar(64) COLLATE utf8_bin NOT NULL default ''"

		),
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_location']['name'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('tl_class'=>'clr w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'source_config' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_location']['source_config'],
			'filter'                  => true,
			'inputType'               => 'select',
			'eval'                    => array('tl_class'=>'clr w50'),
			'foreignKey'              => 'tl_petango_config.name',
			'relation'                => array('type'=>'hasOne', 'load'=>'lazy'),	
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),		
		'petango_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_location']['petango_id'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>64, 'tl_class'=>'clr w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		
		// Active Fields
		'active' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_location']['active'],
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true, 'doNotCopy'=>true, 'tl_class'=>'clr m12'),
			'sql'                     => "char(1) NOT NULL default ''"
		)	
		
    )
);
