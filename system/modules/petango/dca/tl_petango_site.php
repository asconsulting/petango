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
 * Table tl_petango_site
 */
$GLOBALS['TL_DCA']['tl_petango_site'] = array
(
 
    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
		'ctable'					  => array('tl_petango_location'),
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
			'locations' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_petango_site']['locations'],
				'href'                => 'table=tl_petango_location',
				'icon'                => 'modules.svg'
			),
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_petango_site']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_petango_site']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.gif'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_petango_site']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_petango_site']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('Petango\Backend\Site', 'toggleIcon')
			),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_petango_site']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            )
        )
    ),
 
    // Palettes
    'palettes' => array
    (
        'default'                     => '{location_legend},name,alias,source_config,petango_id;{address_legend},address_1,address_2,address_3,city,state,zip,country,latitude,longitude;{contact_legend},phone,fax,email,website;{active_legend},active;'
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
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_site']['alias'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'search'                  => true,
			'eval'                    => array('unique'=>true, 'rgxp'=>'alias', 'doNotCopy'=>true, 'maxlength'=>64, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('Petango\Backend\Site', 'generateAlias')
			),
			'sql'                     => "varchar(64) COLLATE utf8_bin NOT NULL default ''"

		),
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_site']['name'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('tl_class'=>'clr w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'source_config' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_site']['source_config'],
			'filter'                  => true,
			'inputType'               => 'select',
			'eval'                    => array('tl_class'=>'clr w50'),
			'foreignKey'              => 'tl_petango_config.name',
			'relation'                => array('type'=>'hasOne', 'load'=>'lazy'),	
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),		
		'petango_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_site']['petango_id'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>64, 'tl_class'=>'clr w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'address_1' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_petango_site']['address_1'],
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>128, 'tl_class'=>'clr w50'),
            'sql'                     => "varchar(128) NOT NULL default ''"
        ),
		'address_2' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_petango_site']['address_2'],
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>128, 'tl_class'=>'w50'),
            'sql'                     => "varchar(128) NOT NULL default ''"
        ),
		'address_3' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_petango_site']['address_3'],
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>128, 'tl_class'=>'clr w50'),
            'sql'                     => "varchar(128) NOT NULL default ''"
        ),
		'city' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_petango_site']['city'],
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>128, 'tl_class'=>'clr w50'),
            'sql'                     => "varchar(128) NOT NULL default ''"
        ),
		'state' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_petango_site']['state'],
			'filter'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
		'zip' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_petango_site']['zip'],
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>128, 'tl_class'=>'clr w50'),
            'sql'                     => "varchar(10) NOT NULL default ''"
        ),
		'country' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_site']['country'],
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'select',
			'options'                 => System::getCountries(),
			'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
			'sql'                     => "varchar(2) NOT NULL default ''"
		),
		'latitude' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_petango_site']['latitude'],
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50', 'rgxp'=>'digit', 'tl_class'=>'clr w50'),
            'sql'                     => "varchar(32) NOT NULL default ''"
        ),
		'longitude' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_petango_site']['longitude'],
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50', 'rgxp'=>'digit', 'tl_class'=>'w50'),
            'sql'                     => "varchar(32) NOT NULL default ''"
        ),
		'phone' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_site']['phone'],
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'clr w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'fax' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_site']['fax'],
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'email' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_site']['email'],
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'rgxp'=>'email', 'unique'=>true, 'decodeEntities'=>true, 'tl_class'=>'clr w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'website' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_site']['website'],
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'url', 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		
		// Active Fields
		'active' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_site']['active'],
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true, 'doNotCopy'=>true, 'tl_class'=>'clr m12'),
			'sql'                     => "char(1) NOT NULL default ''"
		)	
		
    )
);
