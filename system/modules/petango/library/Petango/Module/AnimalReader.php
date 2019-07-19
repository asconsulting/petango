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
		$strPageAlias = \Environment::get('request');
		if (substr($strPageAlias, -5) == '.html') {
			$strPageAlias = substr($strPageAlias, 0, -5);
		}
		
		$objAnimal = Animal::findBy('alias', $strPageAlias);
		
		var_dump($objAnimal);
		
		if ($objAnimal) {
			$objTemplate = new \FrontendTemplate($this->customAnimalTpl ? $this->customAnimalTpl : 'petango_animal');
			$objTemplate->setData($objAnimal->row());
			$this->Template->animal = $objTemplate->parse();
			
		}
	}

} 
