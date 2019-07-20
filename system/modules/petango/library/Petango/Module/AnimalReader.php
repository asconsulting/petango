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
		$arrBase = explode('?', \Environment::get('request'));
		
		$strPageAlias = basename($arrBase[0], '.html');

		$objAnimal = Animal::findBy('alias', $strPageAlias);
		
		if ($objAnimal) {
			$arrAnimal = $objAnimal->row();
			$arrAnimal['reader_link'] = 'adopt/' .$objAnimal->alias .'.html';
			
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
				$arrAnimal['thumbnail'] = $arrImages[0];
				$arrAnimal['image'] = $arrImages[1];
				array_shift($arrImages);
				$arrAnimal['images'] = $arrImages;
			} else {
				$arrAnimal['no_image'] = true;
				$arrAnimal['images'] = array();
			}
			
			$strAge = '';
			if ($objAnimal->age > 1 && $objAnimal->age < 12) {
				$strAge = $objAnimal->age ." months";
			} else if ($objAnimal->age > 11) {
				$strAge = floor(intval($objAnimal->age) / 12) ." year";
			} else if ($objAnimal->age > 23) {
				$strAge = floor(intval($objAnimal->age) / 12) ." years";
			}
			$arrAnimal['age'] = $strAge;
			
			$objSite = Site::findByPk($objAnimal->site);
			if ($objSite) {
				$arrAnimal['site'] = $objSite->name;
			}
			
			$objTemplate = new \FrontendTemplate($this->customAnimalTpl ? $this->customAnimalTpl : 'petango_animal_reader');
			$objTemplate->setData($arrAnimal);
			
			$this->Template->animal = $objTemplate->parse();
			
			$objMetaTemplate = new \FrontendTemplate('meta_petango_animal');
			$objMetaTemplate->setData($arrAnimal);
			
			$GLOBALS['TL_HEAD'][] = $objMetaTemplate->parse();
		}
	}

} 
