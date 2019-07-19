<?php

/**
 * Petango Interface for Contao CMS 4.4+
 *
 * Copyright (C) 2018 Andrew Stevens Consulting
 *
 * @package    asconsulting/petango
 * @link       https://andrewstevens.consulting
 */
 


namespace Petango\Frontend;

use Contao\Frontend as Contao_Frontend;
use Contao\PageModel;
use Petango\Model\Animal as Animal_Model;


class Animal extends Contao_Frontend {
	
	public function loadReaderPageFromUrl($arrFragments)
    {

		if ($objPage = PageModel::findPublishedByIdOrAlias($arrFragments[0])) {
			return $arrFragments;
		}
		
		if ($arrFragments[0] == 'adopt' && $arrFragments[2] != '') {
			$objPage = PageModel::findBy('petango_animal_reader', '1');
			
			$strPageAlias = $arrFragments[2];
			if (substr($strPageAlias, -5) == '.html') {
				$strPageAlias = substr($strPageAlias, 0, -5);
			}
			
			$objAnimal = Animal::findBy('alias', $strPageAlias);
			
			if ($objPage && $objAnimal) {
				return array($objPage->alias);
			}
		}
		
        return $arrFragments;
    }
}