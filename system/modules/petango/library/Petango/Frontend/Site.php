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

use Petango\Model\Site as Site_Model;
use Contao\Frontend as Contao_Frontend;


class Site extends Contao_Frontend {
	
	public function loadReaderPageFromUrl($arrFragments)
    {

		if ($objPage = \PageModel::findPublishedByIdOrAlias($arrFragments[0])) {
			return $arrFragments;
		}
		
        return $arrFragments;
    }
}