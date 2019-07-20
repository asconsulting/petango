<?php

/**
 * Petango Interface for Contao CMS 4.4+
 *
 * Copyright (C) 2018 Andrew Stevens Consulting
 *
 * @package    asconsulting/petango
 * @link       https://andrewstevens.consulting
 */


 
namespace Petango\Module;
 
use Petango\Model\Animal; 
use Petango\Model\Site; 
use Contao\Module;
use Contao\FrontendTemplate;
use Contao\StringUtil;

 
class AnimalList extends Module
{
 
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_animal_list';
 
    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
 
            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['petango_animal_list'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&table=tl_module&act=edit&id=' . $this->id;
 
            return $objTemplate->parse();
        }
 
        return parent::generate();
    }
 
 
    /**
     * Generate the module
     */
    protected function compile()
    {
		$arrColumns = array();
		$strOrder = '';

		$arrColumns[] = "tl_petango_animal.active ='1'";
		
		if ($this->filter_image) {
			$arrColumns[] = "(tl_petango_animal.remote_images NOT LIKE '%Photo-Not-Available%')";
		}
		
		$arrSites = \StringUtil::deserialize($this->sites);
		if (!empty($arrSites)) {$arrColumns[] = "tl_petango_animal.site IN ('". implode("','", $arrSites) ."')";}
		
		$arrLocations = \StringUtil::deserialize($filter_locations->sites);
		if (!empty($arrLocations)) {$arrColumns[] = "tl_petango_animal.location IN ('". implode("','", $arrLocations) ."')";}
		
		$arrStages = \StringUtil::deserialize($this->filter_stages);
		if (!empty($arrStages)) {$arrColumns[] = "tl_petango_animal.stage IN ('". implode("','", $arrStages) ."')";}
		
		if ($this->filter_on_hold) {$arrColumns[] = "tl_petango_animal.on_hold !='1'";}
		
		$arrSpecies = \StringUtil::deserialize($this->filter_species);
		if (!empty($arrSpecies)) {$arrColumns[] = "tl_petango_animal.species IN ('". implode("','", $arrSpecies) ."')";}

		$arrTypes = \StringUtil::deserialize($this->filter_types);
		if (!empty($arrTypes)) {$arrColumns[] = "tl_petango_animal.animal_type IN ('". implode("','", $arrTypes) ."')";}

		$arrBreeds = \StringUtil::deserialize($this->filter_breeds);
		if (!empty($arrBreeds)) {$arrColumns[] = "(tl_petango_animal.breed_primary IN ('". implode("','", $arrBreeds) ."') OR tl_petango_animal.breed_secondary IN ('". implode("','", $arrBreeds) ."'))";}

		$arrConfig = \StringUtil::deserialize($this->filter_configs);
		$arrColumns[] = "tl_petango_animal.source_config IN ('". implode("','", $arrConfig) ."')";

		if ($this->featured_animals == 'only') {
			$arrColumns[] = "tl_petango_animal.featured ='1'";
		} else if ($this->featured_animals == 'top') {
			$strOrder = 'tl_petango_animal.featured DESC, ';
		}
		
		switch ($this->animal_order) {
			
			case "date_added_desc":
				$strOrder .= "tl_petango_animal.date_added DESC";
			break;
			
			case "date_added_asc":
				$strOrder .= "tl_petango_animal.date_added ASC";
			break;
			
			case "age_desc":
				$strOrder .= "tl_petango_animal.age DESC";
			break;
			
			case "age_asc":
				$strOrder .= "tl_petango_animal.age ASC";
			break;
			
			case "name":
			default:
				$strOrder .= "tl_petango_animal.name";
			break;
			
		}
		
		$arrFind = array('column'=>$arrColumns, 'order'=>$strOrder);
		if ($this->result_limit) {
			$arrFind['limit'] = intval($this->result_limit);
		}
		$objAnimal = Animal::findAll($arrFind);
		
		$arrAnimals = array();
		
		if ($objAnimal) {
			while ($objAnimal->next()) {
				
				$strClass = '';
				if ($objAnimal->species == 2) {
					$strClass .= 'species_cat';
				} else if ($objAnimal->species == 3) {
					$strClass .= 'species_dog';
				} else {
					$strClass .= 'species_other';
				}
				
				if ($objAnimal->sex == 'male') {
					$strClass .= ' gender_male';
				} else if ($objAnimal->sex == 'female') {
					$strClass .= ' gender_female';
				} else {
					$strClass .= ' gender_unknown';
				}
				
				if ($objAnimal->site == 1) {
					$strClass .= ' location_springfield';
				} else if ($objAnimal->site == 2) {
					$strClass .= ' location_leverette';
				} else {
					$strClass .= ' location_unknown';
				}
				
				$objTemplate = new FrontendTemplate($this->customAnimalTpl ? $this->customAnimalTpl : 'petango_animal_list');
				$objTemplate->setData($objAnimal->row());
				$objTemplate->class = $strClass;
				$objTemplate->reader_link = 'adopt/' .$objAnimal->alias .'.html';
				
				$boolNoImage = false;
				$arrTemp = StringUtil::deserialize($objAnimal->remote_images);
				$arrImages = array();
				foreach($arrTemp as $strImage) {
					if (stristr($strImage, 'Photo-Not-Available') === false) {
						$strImage = str_replace('http://', '//', $strImage);
						if ($strImage != '') {
							$arrImages[] = $strImage;
						}	
					} else {
						$boolNoImage = true;
					}
				}
				
				if (!$boolNoImage) {
					$objTemplate->thumbnail = $arrImages[0];
					$objTemplate->image = $arrImages[1];
					array_shift($arrImages);
					$objTemplate->images = $arrImages;
				} else {
					$objTemplate->no_image = true;
					$objTemplate->images = array();
				}
				
				$strAge = '';
				if ($objAnimal->age > 1 && $objAnimal->age < 12) {
					$strAge = $objAnimal->age ." months";
				} else if ($objAnimal->age > 11) {
					$strAge = floor(intval($objAnimal->age) / 12) ." year";
				} else if ($objAnimal->age > 23) {
					$strAge = floor(intval($objAnimal->age) / 12) ." years";
				}
				$objTemplate->age = $strAge;
			
				$objSite = Site::findByPk($objAnimal->site);
				if ($objSite) {
					$objTemplate->site = $objSite->name;
				}
				
				$arrAnimals[] = $objTemplate->parse();
			}
		}
		$this->Template->animals = $arrAnimals;
		
		$GLOBALS['TL_HEAD'][] = '<script src="system/modules/petango/assets/js/animal_list.js"></script>';
		
	}

} 
