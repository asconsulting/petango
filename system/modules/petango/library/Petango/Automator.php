<?php

/**
 * Petango Interface for Contao CMS 4.4+
 *
 * Copyright (C) 2018 Andrew Stevens Consulting
 *
 * @package    asconsulting/petango
 * @link       https://andrewstevens.consulting
 */


 
namespace Petango;

use Petango\Updater;
use Petango\Model\Config as ConfigModel;
use Contao\Controller;


class Automator extends Controller
{
	
	public function updateConfigs() {
		$objConfig = ConfigModel::findBy('active', '1', array('order' => 'last_update ASC'));
		if ($objConfig) {
			while($objConfig->next()) {
				if ($objConfig->update_freq >= 5 && ($objConfig->last_update < (time() - (60 * $objConfig->update_freq)))) {
					$objUpdater = new Updater($objConfig);
					$varResult = $objUpdater->updateAll();
					if ($varResult) {
						$this->log('Updating petango config "tl_petango_config.id='.$objConfig->id.'"', __METHOD__, TL_GENERAL);
					} else {
						$this->log('Unable to update petango config "tl_petango_config.id='.$objConfig->id.'"', __METHOD__, TL_GENERAL);
					}
					break 1;
				}
			}
		}
	}
	
}
