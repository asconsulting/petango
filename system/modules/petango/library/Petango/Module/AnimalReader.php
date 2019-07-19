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
use Contao\StringUtil;
 
class AnimalReader extends Module
{
 
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_animal_reader';
 
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
		$strPageAlias = basename(\Environment::get('request'), '.html');
		
		
		$objAnimal = Animal::findBy('alias', $strPageAlias);
		
		if ($objAnimal) {
			$objTemplate = new \FrontendTemplate($this->customAnimalTpl ? $this->customAnimalTpl : 'petango_animal');
			$objTemplate->setData($objAnimal->row());
			$objTemplate->reader_link = 'adopt/' .$objAnimal->alias .'.html';
			$arrImages = StringUtil::deserialize($objAnimal->remote_images);
			$objTemplate->thumbnail = str_replace('http://', '//', $arrImages[0]);
			$objTemplate->image = str_replace('http://', '//', $arrImages[1]);
			$objTemplate->images = $arrImages;
			
			$strAge = '';
			if ($objAnimal->age > 1 && $objAnimal->age < 12) {
				$strAge = $objAnimal->age ." months";
			} else if ($objAnimal->age > 11) {
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
