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
 * Table tl_petango_config
 */
$GLOBALS['TL_DCA']['tl_petango_config'] = array
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
            'update' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_petango_config']['update'],
                'href'                => 'key=update',
                'icon'                => 'modules.svg'
            ),
			'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_petango_config']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_petango_config']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.gif'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_petango_config']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_petango_config']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('Petango\Backend\Config', 'toggleIcon')
			),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_petango_config']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            )
        )
    ),
 
    // Palettes
    'palettes' => array
    (		
		'__selector__'                => array('local_images'),
        'default'                     => '{petango_legend},name,alias,auth_key,local_images,update_freq,last_update;{active_legend},active;'
    ),
	
	// Subpalettes
	'subpalettes' => array
	(
		'local_images'                    => 'image_folder'
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
		'sorting' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_config']['alias'],
			'inputType'               => 'text',
			'search'                  => true,
			'eval'                    => array('unique'=>true, 'rgxp'=>'alias', 'doNotCopy'=>true, 'maxlength'=>64, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('Petango\Backend\Config', 'generateAlias')
			),
			'sql'                     => "varchar(64) COLLATE utf8_bin NOT NULL default ''"

		),
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_config']['name'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('tl_class'=>'clr w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),		
		'auth_key' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_config']['auth_key'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('tl_class'=>'clr long'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'local_images' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_config']['local_images'],
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true, 'doNotCopy'=>true, 'tl_class'=>'clr m12'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'image_folder' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_config']['image_folder'],
			'inputType'               => 'fileTree',
			'eval'                    => array('files'=>false, 'fieldType'=>'radio', 'class'=>'clr w50'),
			'sql'                     => "blob NULL"
		),
		'update_freq' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_config']['update_freq'],
			'inputType'               => 'text',
			'default'				  => '60',
			'search'				  => true,
			'eval'                    => array('maxlength'=>8, 'tl_class'=>'clr w50', 'rgxp'=>'natural', 'minval'=>5, 'maxval'=>600000),
			'sql'                     => "varchar(6) NOT NULL default ''"
		),
		'last_update' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_config']['last_update'],
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'readonly'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'active' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_config']['active'],
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true, 'doNotCopy'=>true, 'tl_class'=>'clr m12'),
			'sql'                     => "char(1) NOT NULL default ''"
		)
    )
);
