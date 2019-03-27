<?php

/**
 * Petango Interface for Contao CMS 4.4+
 *
 * Copyright (C) 2018 Andrew Stevens Consulting
 *
 * @package    asconsulting/petango
 * @link       https://andrewstevens.consulting
 */
 
 
 
namespace Petango\Model;

use Contao\Model as Contao_Model;


class Species extends Contao_Model
{
	
	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_petango_species';

	public function generateAlias()
	{
		$autoAlias = false;
		
		// Generate an alias if there is none
		if ($this->alias == '')
		{
			$autoAlias = true;
			$this->alias = standardize(\StringUtil::restoreBasicEntities($this->name));
		}

		$objAlias = \Database::getInstance()->prepare("SELECT id FROM tl_petango_species WHERE id=? OR alias=?")
								   ->execute($this->id, $this->alias);

		// Check whether the alias exists
		if ($objAlias->numRows > 1)
		{
			if (!$autoAlias)
			{
				throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $this->alias));
			}

			$this->alias .= '-' . $this->id;
		}
	}
	
	public function save()
	{
		$this->generateAlias();
		parent::save();
	}
	
}
