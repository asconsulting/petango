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
 * Table tl_petango_animal
 */
$GLOBALS['TL_DCA']['tl_petango_animal'] = array
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
                'label'               => &$GLOBALS['TL_LANG']['tl_petango_animal']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_petango_animal']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.gif'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_petango_animal']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_petango_animal']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('Petango\Backend\Animal', 'toggleIcon')
			),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_petango_animal']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            )
        )
    ),
 
    // Palettes
    'palettes' => array
    (
        'default'                     => '{animal_legend},name,alias,source_config,petango_id,species,animal_type;{detail_legend},description,sex,spayed_neutered,age_group,age,date_of_birth,microchip_id,breed_primary,breed_secondary,color_primary,color_secondary,color_pattern,size,weight,altered,declawed;{adoption_legend},application_url,adoption_cost;{media_legend},images,remote_images,additional_media;{petango_legend},reference_num,buddy_animals,site,location,sublocation,stage,on_hold,featured,date_added,date_deactivated,last_update;{intake_legend},surrender_reason,previous_env,time_in_former_home,house_trained,lived_with_children,lived_with_animals,lived_with_types,surrender_date,last_intake_date;{evaluations_legend},no_dogs,no_cats,no_kids,special_needs,memo_list,behavior_result,behavior_test_list,wildlife_intake_injury,wildlife_intake_cause;{active_legend},active;'
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
		
		// Animal Fields
		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['alias'],
			'inputType'               => 'text',
			'search'                  => true,
			'eval'                    => array('unique'=>true, 'rgxp'=>'alias', 'doNotCopy'=>true, 'maxlength'=>64, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('Petango\Backend\Animal', 'generateAlias')
			),
			'sql'                     => "varchar(64) COLLATE utf8_bin NOT NULL default ''"

		),
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['name'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>64, 'tl_class'=>'clr w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),		
		'source_config' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['source_config'],
			'filter'                  => true,
			'inputType'               => 'select',
			'eval'                    => array('tl_class'=>'clr w50'),
			'foreignKey'              => 'tl_petango_config.name',
			'relation'                => array('type'=>'hasOne', 'load'=>'lazy'),	
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'petango_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['petango_id'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'species' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['species'],
			'filter'                  => true,
			'inputType'               => 'select',
			'eval'                    => array('tl_class'=>'clr w50'),
			'foreignKey'              => 'tl_petango_species.name',
			'relation'                => array('type'=>'hasOne', 'load'=>'lazy'),	
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'animal_type' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['breed_primary'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		
		// Detail Fields
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['description'],
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('class'=>'clr long'),
			'sql'                     => "mediumtext NULL"
		),
		'sex' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['sex'],
			'filter'                  => true,
			'inputType'               => 'select',
			'options'				  => array('female'=>'Female', 'male'=>'Male', 'unknown'=>'Unknown'),
			'eval'                    => array('tl_class'=>'clr w50', 'includeBlankOption'=>true),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'spayed_neutered' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['spayed_neutered'],
			'filter'                  => true,
			'inputType'               => 'select',
			'options'				  => array('spayed'=>'Spayed', 'neutered'=>'Neutered'),
			'eval'                    => array('tl_class'=>'w50', 'includeBlankOption'=>true),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'age_group' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['age_group'],
			'filter'                  => true,
			'inputType'               => 'select',
			'options'				  => array('adult'=>'Adult', 'baby'=>'Baby'),
			'eval'                    => array('tl_class'=>'clr w50', 'includeBlankOption'=>true),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'age' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['age'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>4, 'tl_class'=>'w50', 'rgxp'=>'natural', 'minval'=>0, 'maxval'=>100),
			'sql'                     => "varchar(4) NOT NULL default ''"
		),	
		'date_of_birth' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['date_of_birth'],
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'clr w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),		
		'microchip_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['microchip_id'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>64, 'tl_class'=>'clr w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),		
		'breed_primary' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['breed_primary'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>64, 'tl_class'=>'clr w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'breed_secondary' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['breed_secondary'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'color_primary' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['color_primary'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>64, 'tl_class'=>'clr w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'color_secondary' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['color_secondary'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),	
		'color_pattern' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['color_pattern'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>64, 'tl_class'=>'clr w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),	
		'size' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['size'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>32, 'tl_class'=>'clr w50'),
			'sql'                     => "varchar(32) NOT NULL default ''"
		),	
		'weight' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['age'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>4, 'tl_class'=>'w50', 'rgxp'=>'digit', 'minval'=>0, 'maxval'=>9999),
			'sql'                     => "varchar(4) NOT NULL default ''"
		),
		'altered' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['altered'],
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('class'=>'clr long'),
			'sql'                     => "mediumtext NULL"
		),
		'declawed' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['declawed'],
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'clr w50 m12'),
			'sql'                     => "char(1) NOT NULL default ''"
		),	
		
		// Adoption Fields
		'application_url' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['application_url'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('tl_class'=>'clr w50', 'rgxp'=>'url'),
			'sql'                     => "varchar(32) NOT NULL default ''"
		),
		'adoption_cost' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['adoption_cost'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('tl_class'=>'w50', 'rgxp'=>'digit'),
			'sql'                     => "varchar(32) NOT NULL default ''"
		),
		
		// Media Fields
		'images' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['images'],
			'inputType'               => 'fileTree',
			'eval'                    => array('filesOnly'=>true, 'multiple'=>true, 'extensions'=>Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'class'=>'clr w50'),
			'sql'                     => "blob NULL"
		),
		'remote_images' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['remote_images'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('multiple'=>true, 'tl_class'=>'clr w50', 'rgxp'=>'url'),
			'sql'                     => "mediumtext NULL"
		),
		'additional_media' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['additional_media'],
			'inputType'               => 'fileTree',
			'eval'                    => array('filesOnly'=>true, 'multiple'=>'true', 'extensions'=>Config::get('validImageTypes'), 'fieldType'=>'checkbox', 'class'=>'clr w50'),
			'sql'                     => "blob NULL"
		),
		'video_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['video_id'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),	
		
		// Petango Fields
		'reference_num' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['reference_num'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>64, 'tl_class'=>'clr w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'buddy_animals' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['buddy_animals'],
			'filter'                  => true,
			'inputType'               => 'select',
			'eval'                    => array('tl_class'=>'w50', 'chosen'=>true, 'multiple'=>true, 'includeBlankOption'=>true),
			'foreignKey'              => 'tl_petango_animal.CONCAT(name, " [", petango_id, "]")',
			'relation'                => array('type'=>'hasMany', 'load'=>'lazy'),	
			'sql'                     => "mediumtext NULL"
		),
		'site' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['site'],
			'filter'                  => true,
			'inputType'               => 'select',
			'eval'                    => array('tl_class'=>'clr long'),
			'foreignKey'              => 'tl_petango_site.name',
			'relation'                => array('type'=>'hasOne', 'load'=>'lazy'),	
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'location' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['location'],
			'filter'                  => true,
			'inputType'               => 'select',
			'eval'                    => array('tl_class'=>'clr w50'),
			'foreignKey'              => 'tl_petango_location.name',
			'relation'                => array('type'=>'hasOne', 'load'=>'lazy'),	
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'sublocation' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['sublocation'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'stage' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['stage'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'clr long'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'on_hold' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['on_hold'],
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'clr w50 m12'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'featured' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['featured'],
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50 m12'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'date_added' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['date_added'],
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'clr w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'date_deactivated' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['date_deactivated'],
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'last_update' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['last_update'],
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'readonly'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		
		//Intake Fields
		'surrender_reason' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['surrender_reason'],
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('class'=>'clr long'),
			'sql'                     => "mediumtext NULL"
		),
		'previous_env' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['previous_env'],
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('class'=>'clr long'),
			'sql'                     => "mediumtext NULL"
		),
		'time_in_former_home' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['time_in_former_home'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>64, 'tl_class'=>'clr w50'),
			'sql'                     => "varchar(64) NOT NULL default ''"
		),
		'house_trained' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['house_trained'],
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50 m12'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'lived_with_children' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['lived_with_children'],
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'clr w50 m12'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'lived_with_animals' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['lived_with_animals'],
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50 m12'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'lived_with_types' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['lived_with_types'],
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('class'=>'clr long'),
			'sql'                     => "mediumtext NULL"
		),
		'surrender_date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['surrender_date'],
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'clr w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'last_intake_date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['last_intake_date'],
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		
		
		// Evaluation Fields
		'no_dogs' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['no_dogs'],
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'clr w50 m12'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'no_cats' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['no_cats'],
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50 m12'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'no_kids' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['no_kids'],
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'clr w50 m12'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'special_needs' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['special_needs'],
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'w50 m12'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'memo_list' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['memo_list'],
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('class'=>'clr long'),
			'sql'                     => "mediumtext NULL"
		),
		'behavior_result' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['behavior_result'],
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('class'=>'clr long'),
			'sql'                     => "mediumtext NULL"
		),
		'behavior_test_list' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['behavior_test_list'],
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('class'=>'clr long'),
			'sql'                     => "mediumtext NULL"
		),
		'wildlife_intake_injury' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['wildlife_intake_injury'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'clr long'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'wildlife_intake_cause' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['wildlife_intake_cause'],
			'inputType'               => 'text',
			'default'				  => '',
			'search'				  => true,
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'clr long'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		
		// Active Fields
		'active' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_petango_animal']['active'],
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true, 'doNotCopy'=>true, 'tl_class'=>'clr m12'),
			'sql'                     => "char(1) NOT NULL default ''"
		)		
    )
);
