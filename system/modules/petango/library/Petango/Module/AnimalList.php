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

		$arrColumns[] = 'active ="1"';
		
		$arrSites = \StringUtil::deserialize($this->sites);
		if (!empty($arrSites)) {$arrColumns[] = 'site IN SET ("'. implode('","', $arrSites) .'")';}
		
		$arrLocations = \StringUtil::deserialize($filter_locations->sites);
		if (!empty($arrLocations)) {$arrColumns[] = 'location IN SET ("'. implode('","', $arrLocations) .'")';}
		
		$arrStages = \StringUtil::deserialize($this->filter_stages);
		if (!empty($arrStages)) {$arrColumns[] = 'stage IN SET ("'. implode('","', $arrStages) .'")';}
		
		if ($this->filter_on_hold) {$arrColumns[] = 'on_hold !="1"';}
		
		$arrSpecies = \StringUtil::deserialize($this->filter_species);
		if (!empty($arrSpecies)) {$arrColumns[] = 'species IN SET ("'. implode('","', $arrSpecies) .'")';}

		$arrTypes = \StringUtil::deserialize($this->filter_types);
		if (!empty($arrTypes)) {$arrColumns[] = 'animal_type IN SET ("'. implode('","', $arrTypes) .'")';}

		$arrBreeds = \StringUtil::deserialize($this->filter_breeds);
		if (!empty($arrBreeds)) {$arrColumns[] = '(breed_primary IN SET ("'. implode('","', $arrBreeds) .') OR breed_secondary IN SET ("'. implode('","', $arrBreeds) .'))';}

		$arrConfig = \StringUtil::deserialize($this->filter_configs);
		$arrColumns[] = 'source_config IN SET ("'. implode('","', $arrConfig) .'")';

		if ($this->featured_animals == 'only') {
			$arrColumns[] = 'featured ="1"';
		} else if ($this->featured_animals == 'top') {
			$strOrder = 'featured DESC, ';
		}
		
		switch ($this->animal_order) {
			
			case "date_added_desc":
				$strOrder .= "date_added DESC";
			break;
			
			case "date_added_asc":
				$strOrder .= "date_added ASC";
			break;
			
			case "age_desc":
				$strOrder .= "age DESC";
			break;
			
			case "age_asc":
				$strOrder .= "age ASC";
			break;
			
			case "name":
			default:
				$strOrder .= "name";
			break;
			
		}
		
		$objAnimal = Animal::findAll(array('columns'=>$arrColumns, 'order'=>$strOrder));
		
		$arrAnimals = array();
		
		if ($objAnimal) {
			while ($objAnimal->next()) {
				$objTemplate = new FrontendTemplate($this->customAnimalTpl ? $this->customAnimalTpl : 'petango_animal');
				$objTemplate->setData($objAnimal->row());
				$arrImages = StringUtil::deserialize($objAnimal->remote_images);
				$objTemplate->thumbnail = $arrImages[0];
				$objTemplate->image = $arrImages[1];
				$arrAnimals[] = $objTemplate->parse();
			}
		}
		$this->Template->animals = $arrAnimals;

	}

} 
