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
use Contao\Database;
 
class AnimalRandom extends Module
{
 
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_animal_random';
 
    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
 
            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['petango_animal_reader'][0]) . ' ###';
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
		$strOrder = 'name';

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
		}
		
		$objAnimal = Animal::findAll(array('column'=>$arrColumns, 'order'=>$strOrder));
		
		$arrModels = $objAnimal->getModels();
		$objAnimal = $arrModels[mt_rand(0, count($arrModels) - 1)];
		
		$arrAnimals = array();
		
		if ($objAnimal) {
			$objTemplate = new FrontendTemplate($this->customAnimalTpl ? $this->customAnimalTpl : 'petango_animal_random');
			$objTemplate->setData($objAnimal->row());
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
				
			$this->Template->animal = $objTemplate->parse();
		}

	}

} 
