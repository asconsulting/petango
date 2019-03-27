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

use Petango\Model\Animal;
use Petango\Model\Config;
use Petango\Model\Site;
use Petango\Model\Location;
use Petango\Model\Species;
use Contao\StringUtil;
use Contao\FilesModel;
use Contao\File;
use Contao\Files;
use Contao\Folder;

class Updater 
{
	
	var $strAllUrl = "https://ws.petango.com/webservices/wsadoption.asmx/AdoptableSearch?authkey=%s&speciesID=&sex=&ageGroup=&location=&site=&onHold=&orderBy=&primaryBreed=&secondaryBreed=&specialNeeds=&noDogs=&noCats=&noKids=&stageID=";

	var $strAnimalUrl = "https://ws.petango.com/webservices/wsadoption.asmx/AdoptableDetails?animalID=%s&authkey=%s";
	
	var $objConfig = null;

	var $arrAnimals = array();
	var $arrSites = array();
	var $arrLocations = array();
	var $arrSpecies = array();
	
	var $arrAnimalIds = array();
	
	var $objAllXml = null;
	var $arrAnimalXml = array();
	
	function __construct($objConfig = null) {
		$this->loadConfig($objConfig);
		
		if (!$this->objConfig && \Input::get('do') == 'petango_config' && \Input::get('key') == 'update') {
			$objConfig = Config::findByPk(\Input::get('id'));
			if ($objConfig) {
				$this->objConfig = $objConfig;
			}
		}
	}
	
	public function loadConfig($objConfig = null) {
		if (is_a($objConfig, 'Petango\Model\Config')) {
			$this->objConfig = $objConfig;
		}
		if (intval($objConfig)) {
			$intConfig = $objConfig;
			$objConfig = Config::findByPk($intConfig);
			if ($objConfig) {
				$this->objConfig = $objConfig;
			}
		}
	}
	
	private function getAllXml() {
		if (!$this->objConfig) {
			return false;
		}
		
		$strUrl = sprintf($this->strAllUrl, $this->objConfig->auth_key);
		$objXml = simplexml_load_file($strUrl);
		
		if (!$objXml) {
			return false;
		}
		
		$this->objAllXml = $objXml;
	}
	
	private function getAnimalXml($strAnimalId) {
		if (!$this->objConfig) {
			return false;
		}
		
		$strUrl = sprintf($this->strAnimalUrl, $strAnimalId, $this->objConfig->auth_key);
		$objXml = simplexml_load_file($strUrl);
		
		if (!$objXml) {
			return false;
		}
		$this->arrAnimalXml[$strAnimalId] = $objXml;
	}
	
	private function loadAll() {
		
		$this->getAllXml();
		
		foreach($this->objAllXml->XmlNode as $objNode) {

			$arrAnimal = array();
			$arrAnimal['petango_id'] 				= trim($objNode->adoptableSearch->ID);
			$arrAnimal['name'] 						= trim($objNode->adoptableSearch->Name);
			$arrAnimal['species'] 					= trim($objNode->adoptableSearch->Species);
			$arrAnimal['breed_primary'] 			= trim($objNode->adoptableSearch->PrimaryBreed);
			$arrAnimal['breed_secondary'] 			= trim($objNode->adoptableSearch->SecondaryBreed);
			$arrAnimal['memo_list'] 				= trim($objNode->adoptableSearch->MemoList);
			$arrAnimal['reference_num'] 			= trim($objNode->adoptableSearch->ARN);
			$arrAnimal['behavior_test_list'] 		= trim($objNode->adoptableSearch->BehaviorTestList);
			$arrAnimal['stage'] 					= trim($objNode->adoptableSearch->Stage);
			$arrAnimal['animal_type'] 				= trim($objNode->adoptableSearch->AnimalType);
			$arrAnimal['age'] 						= intval(trim($objNode->adoptableSearch->Age));
			$arrAnimal['wildlife_intake_injury'] 	= trim($objNode->adoptableSearch->WildlifeIntakeInjury);
			$arrAnimal['wildlife_intake_cause'] 	= trim($objNode->adoptableSearch->WildlifeIntakeCause);
			$arrAnimal['sublocation'] 				= trim($objNode->adoptableSearch->Sublocation);
			$arrAnimal['microchip_id'] 				= trim($objNode->adoptableSearch->ChipNumber);
			
			// Special Field Handling
			$strSex = strtolower(trim($objNode->adoptableSearch->Sex));
			if ($strSex == "female" || $strSex == "f") {$arrAnimal['sex'] = 'female';} 
			elseif ($strSex == "male" || $strSex == "m") {$arrAnimal['sex'] = 'male';}

			$strSpayNeuter = strtolower(trim($objNode->adoptableSearch->SN));
			if ($strSpayNeuter == "spay" || $strSpayNeuter == "spayed") {$arrAnimal['spayed_neutered'] = 'spayed';} 
			elseif ($strSpayNeuter == "neuter" || $strSpayNeuter == "neutered") {$arrAnimal['spayed_neutered'] = 'neutered';}
			
			$strAgeGroup = strtolower(trim($objNode->adoptableSearch->AgeGroup));
			if ($strAgeGroup == "adult") {$arrAnimal['age_group'] = 'adult';} 
			elseif ($strAgeGroup == "baby") {$arrAnimal['age_group'] = 'baby';}
			
			$strOnHold = strtolower(trim($objNode->adoptableSearch->OnHold));
			if ($strOnHold == "yes" || $strOnHold == "y") {$arrAnimal['on_hold'] = '1';}
			else {$arrAnimal['on_hold'] = '';}
			
			$strSpecialNeeds = strtolower(trim($objNode->adoptableSearch->SpecialNeeds));
			if ($strSpecialNeeds == "yes" || $strSpecialNeeds == "y") {$arrAnimal['special_needs'] = '1';}
			else {$arrAnimal['special_needs'] = '';}
			
			$strNoDogs = strtolower(trim($objNode->adoptableSearch->NoDogs));
			if ($strNoDogs == "yes" || $strNoDogs == "y") {$arrAnimal['no_dogs'] = '1';}
			else {$arrAnimal['no_dogs'] = '';}
			
			$strNoCats = strtolower(trim($objNode->adoptableSearch->NoCats));
			if ($strNoCats == "yes" || $strNoCats == "y") {$arrAnimal['no_cats'] = '1';}
			else {$arrAnimal['no_cats'] = '';}
			
			$strNoKids = strtolower(trim($objNode->adoptableSearch->NoKids));
			if ($strNoKids == "yes" || $strNoKids == "y") {$arrAnimal['no_kids'] = '1';}
			else {$arrAnimal['no_kids'] = '';}

			$strFeatured = strtolower(trim($objNode->adoptableSearch->Featured));
			if ($strFeatured == "yes" || $strFeatured == "y") {$arrAnimal['featured'] = '1';}
			else {$arrAnimal['featured'] = '';}
			
			// Subtable Fields
			$arrAnimal['lookup___buddy_animal'] 	= trim($objNode->adoptableSearch->BuddyID);
			$arrAnimal['lookup___location'] 		= trim($objNode->adoptableSearch->Location);
		
			// Media
			$strPhoto = trim($objNode->adoptableSearch->Photo);
			if ($strPhoto) {$arrAnimal['remote_images'][] = $strPhoto;}
			
			$this->arrAnimals[$arrAnimal['petango_id']] = $arrAnimal;
			
		}
	}
	
	private function loadAnimal($strAnimalId) {
		$this->getAnimalXml($strAnimalId);
		
		$objAnimal = $this->arrAnimalXml[$strAnimalId];
		$arrAnimal = $this->arrAnimalXml[$strAnimalId];
		
		$arrAnimal['company_id'] 					= trim($objAnimal->CompanyID);
		$arrAnimal['petango_id'] 					= trim($objAnimal->ID);
		$arrAnimal['name'] 							= trim($objAnimal->AnimalName);
		$arrAnimal['altered'] 						= trim($objAnimal->Altered);
		$arrAnimal['breed_primary'] 				= trim($objAnimal->PrimaryBreed);
		$arrAnimal['breed_secondary'] 				= trim($objAnimal->SecondaryBreed);
		$arrAnimal['color_primary'] 				= trim($objAnimal->PrimaryColor);
		$arrAnimal['color_secondary'] 				= trim($objAnimal->SecondaryColor);
		$arrAnimal['age'] 							= intval(trim($objAnimal->Age));			
		$arrAnimal['size'] 							= trim($objAnimal->Size);
		$arrAnimal['adoption_cost']	 				= trim($objAnimal->Price);
		$arrAnimal['description'] 					= trim($objAnimal->Dsc);
		$arrAnimal['behavior_result'] 				= trim($objAnimal->BehaviorResult);
		$arrAnimal['memo_list'] 					= trim($objAnimal->MemoList);
		$arrAnimal['time_in_former_home'] 			= trim($objAnimal->TimeInFormerHome);	
		$arrAnimal['surrender_reason'] 				= trim($objAnimal->ReasonForSurrender);	
		$arrAnimal['previous_env'] 					= trim($objAnimal->PrevEnvironment);
		$arrAnimal['lived_with_types'] 				= trim($objAnimal->LivedWithAnimalTypes);
		$arrAnimal['weight'] 						= trim($objAnimal->BodyWeight);
		$arrAnimal['reference_num'] 				= trim($objAnimal->ARN);
		$arrAnimal['video_id'] 						= trim($objAnimal->VideoID);
		$arrAnimal['behavior_test_list'] 			= trim($objAnimal->BehaviorTestList);
		$arrAnimal['stage'] 						= trim($objAnimal->Stage);
		$arrAnimal['animal_type'] 					= trim($objAnimal->AnimalType);
		$arrAnimal['wildlife_intake_injury'] 		= trim($objAnimal->WildlifeIntakeInjury);
		$arrAnimal['wildlife_intake_cause'] 		= trim($objAnimal->WildlifeIntakeCause);
		$arrAnimal['sublocation'] 					= trim($objAnimal->Sublocation);
		$arrAnimal['microchip_id'] 					= trim($objAnimal->ChipNumber);
		$arrAnimal['color_pattern'] 				= trim($objAnimal->ColorPattern);
		$arrAnimal['adoption_url'] 					= trim($objAnimal->AdoptionApplicationUrl);
		
		// Special Field Handling
		$strSex = strtolower(trim($objAnimal->Sex));
		if ($strSex == "female" || $strSex == "f") {$arrAnimal['sex'] = 'female';} 
		elseif ($strSex == "male" || $strSex == "m") {$arrAnimal['sex'] = 'male';}
		
		$strAgeGroup = strtolower(trim($objNode->adoptableSearch->AgeGroup));
		if ($strAgeGroup == "adult") {$arrAnimal['age_group'] = 'adult';} 
		elseif ($strAgeGroup == "baby") {$arrAnimal['age_group'] = 'baby';}
		
		$strOnHold = strtolower(trim($objNode->adoptableSearch->OnHold));
		if ($strOnHold == "yes" || $strOnHold == "y") {$arrAnimal['on_hold'] = '1';}
		else {$arrAnimal['lived_with_animals'] = '';}

		$strSpecialNeeds = strtolower(trim($objNode->adoptableSearch->SpecialNeeds));
		if ($strSpecialNeeds == "yes" || $strSpecialNeeds == "y") {$arrAnimal['special_needs'] = '1';}
		else {$arrAnimal['special_needs'] = '';}
		
		$strNoDogs = strtolower(trim($objNode->adoptableSearch->NoDogs));
		if ($strNoDogs == "yes" || $strNoDogs == "y") {$arrAnimal['no_dogs'] = '1';}
		else {$arrAnimal['no_dogs'] = '';}
		
		$strNoCats = strtolower(trim($objNode->adoptableSearch->NoCats));
		if ($strNoCats == "yes" || $strNoCats == "y") {$arrAnimal['no_cats'] = '1';}
		else {$arrAnimal['no_cats'] = '';}
		
		$strNoKids = strtolower(trim($objNode->adoptableSearch->NoKids));
		if ($strNoKids == "yes" || $strNoKids == "y") {$arrAnimal['no_kids'] = '1';}
		else {$arrAnimal['no_kids'] = '';}

		$strFeatured = strtolower(trim($objNode->adoptableSearch->Featured));
		if ($strFeatured == "yes" || $strFeatured == "y") {$arrAnimal['featured'] = '1';}
		else {$arrAnimal['featured'] = '';}
		
		$strDeclawed = strtolower(trim($objNode->adoptableSearch->Declawed));
		if ($strDeclawed == "yes" || $strDeclawed == "y") {$arrAnimal['declawed'] = '1';}
		else {$arrAnimal['declawed'] = '';}

		$strHouseTrained = strtolower(trim($objNode->adoptableSearch->Housetrained));
		if ($strHouseTrained == "yes" || $strHouseTrained == "y") {$arrAnimal['house_trained'] = '1';}
		else {$arrAnimal['house_trained'] = '';}

		$strLivedChildren = strtolower(trim($objNode->adoptableSearch->LivedWithChildren));
		if ($strLivedChildren == "yes" || $strLivedChildren == "y") {$arrAnimal['lived_with_children'] = '1';}
		else {$arrAnimal['lived_with_children'] = '';}

		$strLivedAnimals = strtolower(trim($objNode->adoptableSearch->LivedWithAnimals));
		if ($strLivedAnimals == "yes" || $strLivedAnimals == "y") {$arrAnimal['lived_with_animals'] = '1';} 
		else {$arrAnimal['lived_with_animals'] = '';}

		// Process Date Fields
		$objDate = DateTime::createFromFormat('Y-m-d H:i:s', trim($objAnimal->DateOfBirth));
		if ($objDate) {$arrAnimal['date_of_birth'] = $objDate->getTimestamp();}
		
		$objDate = DateTime::createFromFormat('Y-m-d H:i:s', trim($objAnimal->LastIntakeDate));
		if ($objDate) {$arrAnimal['last_intake_date'] = $objDate->getTimestamp();}
		
		$objDate = DateTime::createFromFormat('Y-m-d H:i:s', trim($objAnimal->DateOfSurrender));
		if ($objDate) {$arrAnimal['date_surrendered'] = $objDate->getTimestamp();}
			
		// Subtable Fields
		$arrAnimal['lookup___species'] 				= trim($objAnimal->Species);		
		$arrAnimal['lookup___location'] 			= trim($objAnimal->Location);
		$arrAnimal['lookup___site'] 				= trim($objAnimal->Site);	
		$arrAnimal['lookup___buddy_animal'] 		= trim($objAnimal->BuddyID);
	
		$strPhoto = trim($objAnimal->Photo1);
		if ($strPhoto && !in_array($arrAnimal['remote_images'])) {$arrAnimal['remote_images'][] = $strPhoto;}
		$strPhoto = trim($objAnimal->Photo2);
		if ($strPhoto && !in_array($arrAnimal['remote_images'])) {$arrAnimal['remote_images'][] = $strPhoto;}
		$strPhoto = trim($objAnimal->Photo3);
		if ($strPhoto && !in_array($arrAnimal['remote_images'])) {$arrAnimal['remote_images'][] = $strPhoto;}
		$strPhoto = trim($objAnimal->Photo4);
		if ($strPhoto && !in_array($arrAnimal['remote_images'])) {$arrAnimal['remote_images'][] = $strPhoto;}
		$strPhoto = trim($objAnimal->Photo5);
		if ($strPhoto && !in_array($arrAnimal['remote_images'])) {$arrAnimal['remote_images'][] = $strPhoto;}
		$strPhoto = trim($objAnimal->Photo6);
		if ($strPhoto && !in_array($arrAnimal['remote_images'])) {$arrAnimal['remote_images'][] = $strPhoto;}
		$strPhoto = trim($objAnimal->Photo7);
		if ($strPhoto && !in_array($arrAnimal['remote_images'])) {$arrAnimal['remote_images'][] = $strPhoto;}
		$strPhoto = trim($objAnimal->Photo8);
		if ($strPhoto && !in_array($arrAnimal['remote_images'])) {$arrAnimal['remote_images'][] = $strPhoto;}
		$strPhoto = trim($objAnimal->Photo9);
		if ($strPhoto && !in_array($arrAnimal['remote_images'])) {$arrAnimal['remote_images'][] = $strPhoto;}
			
		$this->arrAnimals[$strAnimalId] = $arrAnimal;
		return $arrAnimal;
	}
	
	public function updateAll() {
		if (!$this->objConfig) {
			return false;
		}
var_dump($this->objConfig);		
		if ($this->loadAll()) {

			// Load First Pass
			foreach($this->arrAnimals as $arrCache) {
				$arrAnimal = $this->loadAnimal($arrCache['petango_id']);
	die($this->arrAnimals);		
				$objAnimal = Animal::findBy('petango_id', $arrAnimal['petango_id']);
				if (!$objAnimal) {
					$objAnimal = new Animal;
					$objAnimal->tstamp = time();
					$objAnimal->date_added = time();
				}
				$objAnimal->name 					= $arrAnimal['name'];
				$objAnimal->source_config 			= $this->objConfig->id;
				$objAnimal->petango_id 				= $arrAnimal['petango_id'];
				$objAnimal->animal_type 			= $arrAnimal['animal_type'];
				$objAnimal->description 			= $arrAnimal['description'];
				$objAnimal->sex 					= $arrAnimal['sex'];
				
				$objAnimal->spayed_neutered 		= $arrAnimal['spayed_neutered'];
				$objAnimal->age_group 				= $arrAnimal['age_group'];
				$objAnimal->age 					= $arrAnimal['age'];
				$objAnimal->date_of_birth 			= $arrAnimal['date_of_birth'];
				$objAnimal->microchip_id 			= $arrAnimal['microchip_id'];
				$objAnimal->breed_primary 			= $arrAnimal['breed_primary'];
				$objAnimal->breed_secondary 		= $arrAnimal['breed_secondary'];
				$objAnimal->color_primary 			= $arrAnimal['color_primary'];
				$objAnimal->color_secondary 		= $arrAnimal['color_secondary'];
				$objAnimal->color_pattern 			= $arrAnimal['color_pattern'];
				$objAnimal->size 					= $arrAnimal['size'];
				$objAnimal->weight 					= $arrAnimal['weight'];
				$objAnimal->altered 				= $arrAnimal['altered'];
				$objAnimal->declawed 				= $arrAnimal['declawed'];
				
				$objAnimal->application_url 		= $arrAnimal['application_url'];
				$objAnimal->adoption_cost 			= $arrAnimal['adoption_cost'];
				
				$objAnimal->remote_images 			= serialize($arrAnimal['remote_images']);

				$objAnimal->reference_num 			= $arrAnimal['reference_num'];
				$objAnimal->buddy_animal 			= $arrAnimal['buddy_animal'];
				$objAnimal->site 					= $arrAnimal['site'];
				$objAnimal->location 				= $arrAnimal['location'];
				$objAnimal->sublocation 			= $arrAnimal['sublocation'];
				$objAnimal->stage 					= $arrAnimal['stage'];
				$objAnimal->on_hold 				= $arrAnimal['on_hold'];
				$objAnimal->featured 				= $arrAnimal['featured'];
				$objAnimal->date_deactivated 		= $arrAnimal['date_deactivated'];
				$objAnimal->last_intake_date 		= $arrAnimal['last_intake_date'];

				$objAnimal->surrender_reason 		= $arrAnimal['surrender_reason'];
				$objAnimal->previous_env 			= $arrAnimal['previous_env'];
				$objAnimal->time_in_former_home 	= $arrAnimal['time_in_former_home'];
				$objAnimal->house_trained 			= $arrAnimal['house_trained'];
				$objAnimal->lived_with_children 	= $arrAnimal['lived_with_children'];
				$objAnimal->lived_with_animals 		= $arrAnimal['lived_with_animals'];
				$objAnimal->lived_with_types 		= $arrAnimal['lived_with_types'];
				
				$objAnimal->no_dogs 				= $arrAnimal['no_dogs'];
				$objAnimal->no_cats 				= $arrAnimal['no_cats'];
				$objAnimal->no_kids 				= $arrAnimal['no_kids'];
				$objAnimal->special_needs 			= $arrAnimal['special_needs'];
				$objAnimal->memo_list 				= $arrAnimal['memo_list'];
				$objAnimal->behavior_result 		= $arrAnimal['behavior_result'];
				$objAnimal->behavior_test_list 		= $arrAnimal['behavior_test_list'];
				$objAnimal->wildlife_intake_injury 	= $arrAnimal['date_deactivated'];
				$objAnimal->wildlife_intake_cause 	= $arrAnimal['last_intake_date'];

				$objSpecies = Species::findBy('name', $arrAnimal['lookup___species']);
				if (!$objSpecies) {
					$objSpecies = new Species;
					$objSpecies->tstamp = time();
					$objSpecies->name = $arrAnimal['lookup___species'];
					$objSpecies->source_config = $this->objConfig->id;
					$objSpecies->save();
				}
				$objAnimal->species 				= $objSpecies->id;
				
				$objSite = Site::findBy('petango_id', $arrAnimal['lookup___site']);
				if (!$objSite) {
					$objSite = new Site;
					$objSite->tstamp = time();
					$objSite->name = $arrAnimal['lookup___site'];
					$objSite->petango_id = $arrAnimal['lookup___site'];
					$objSite->source_config = $this->objConfig->id;
					$objSite->save();
				}
				$objAnimal->site					= $objSite->id;
				
				$objLocation = Location::findBy('petango_id', $arrAnimal['lookup___location']);
				if ($objLocation) {
					$boolMatch = false;
					while ($objLocation->next()) {
						if ($objLocation->pid == $objSite->id) {
							$objLocation = $objLocation->current();
							$boolMatch = true;
							break 1;
						}
					}
					
					if (!$boolMatch) {
						$objLocation = false;
					}
				}
		
				if (!$objLocation) {
					$objLocation = new Site;
					$objLocation->pid = $objSite->id;
					$objLocation->tstamp = time();
					$objLocation->name = $arrAnimal['lookup___location'];
					$objLocation->petango_id = $arrAnimal['lookup___location'];
					$objLocation->source_config = $this->objConfig->id;
					$objLocation->save();
				}
				$objAnimal->location					= $objLocation->id;
				
				$objAnimal->last_update 			= time();
				$objAnimal->active 					= '1';
				$objAnimal->save();

				$this->arrAnimalIds[] = $objAnimal->id;
			}
			
			// Link Buddies
			foreach($this->arrAnimals as $arrCache) {
				$arrAnimal['lookup___buddy_animal'];
				$arrTemp = explode(',', $arrAnimal['lookup___buddy_animal']);
				$arrBuddies = array();
				foreach ($arrTemp as $strBuddy) {
					$strBuddy = trim($strBuddy);
					if ($strBuddy != '') {
						$objBuddyAnimal = Animal::findBy('petango_id', $strBuddy);
						if ($objBuddyAnimal) {
							$arrBuddies[] = $objBuddyAnimal->id;
						}
					}
				}
				$objAnimal = Animal::findBy('petango_id', $arrAnimal['petango_id']);
				if ($objAnimal) {
					$objAnimal->buddy_animals = serialize($arrBuddies);
					$objAnimal->save();
				}
			}
			
			if (!empty($this->arrAnimalIds)) {
				Database::getInstance()->execute("UPDATE tl_petango_animal SET active='' WHERE id NOT IN ('" .implode("','", $this->arrAnimalIds) ."')");
			}
			
			
			if ($this->objConfig->local_images) {
				$objAnimal = Animal::findBy('active', '1');
				$objFolderModel = FilesModel::findByUuid($this->objConfig->image_folder);
				
				$objFolder = new Folder($objFolderModel ? $objFolderModel->path : 'files/petango');
				$objFolder->unprotect();
				
				if ($objAnimal) {
					while ($objAnimals->next()) {
						$arrImages = StringUtil::deserialize($objAnimal->images);
						$arrRemoteImages = StringUtil::deserialize($objAnimal->remote_images);
						
						foreach($arrRemoteImages as $strImageUrl) {
							$strFilename = basename($strImageUrl);
							$objFile = new File($objFolder->path ."/" .$strFilename);
							if (!$objFile->exists()) {
								$fh = fopen(TL_ROOT .'/' .$objFolder->path ."/" .$strFilename, 'wb');
								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL, $strImageUrl); 
								curl_setopt($ch, CURLOPT_FILE, $fh); 
								curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); 
								curl_exec($ch);
								curl_close($ch);
								fclose($fh);
								
								$objFile = new File($objFolder->path ."/" .$strFilename);
							}
							
							if ($objFile->exists()) {
								$objFileModel = $objFile->getModel();
								if (!in_array($objFileModel->uuid, $arrImages)) {
									$arrImages[] = $objFileModel->uuid;
								}
							}
						}
						$objAnimal->images = serialize($arrImages);
						$objAnimal->save();
					}
				}
			}
		} else {
			return false;
		}
		return true;
	}
	
}
