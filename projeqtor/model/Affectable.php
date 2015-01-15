<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2014 Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/*
 * ============================================================================ User is a resource that can connect to the application.
 */
require_once ('_securityCheck.php');
class Affectable extends SqlElement {
	
	// extends SqlElement, so has $id
	public $_col_1_2_Description;
	public $id; // redefine $id to specify its visible place
	public $name;
	public $userName;
	public $isResource;
	public $isUser;
	public $isContact;
	public $email;
	public $idTeam;
	public $idle;
	public $_constructForName = true;
	public $_calculateForColumn = array (
			"name" => "coalesce(fullName,concat(name,' #'))",
			"userName" => "coalesce(name,concat(fullName,' *'))" 
	);
	private static $_fieldsAttributes = array (
			"name" => "required",
			"isContact" => "readonly",
			"isUser" => "readonly",
			"isResource" => "readonly",
			"idle" => "hidden" 
	);
	private static $_databaseTableName = 'resource';
	private static $_databaseColumnName = array (
			'name' => 'fullName',
			'userName' => 'name' 
	);
	private static $_databaseCriteria = array ();
	
	/**
	 * ==========================================================================
	 * Constructor
	 * 
	 * @param $id the
	 *        	id of the object in the database (null if not stored yet)
	 * @return void
	 */
	function __construct($id = NULL) {
		parent::__construct ( $id );
		if ($this->id and ! $this->name and $this->userName) {
			$this->name = $this->userName;
		}
	}
	
	/**
	 * ==========================================================================
	 * Destructor
	 * 
	 * @return void
	 */
	function __destruct() {
		parent::__destruct ();
	}
	
	// ============================================================================**********
	// GET STATIC DATA FUNCTIONS
	// ============================================================================**********
	
	/**
	 * ========================================================================
	 * Return the specific databaseTableName
	 * 
	 * @return the databaseTableName
	 */
	protected function getStaticDatabaseTableName() {
		$paramDbPrefix = Parameter::getGlobalParameter ( 'paramDbPrefix' );
		return $paramDbPrefix . self::$_databaseTableName;
	}
	
	/**
	 * ========================================================================
	 * Return the specific databaseTableName
	 * 
	 * @return the databaseTableName
	 */
	protected function getStaticDatabaseColumnName() {
		return self::$_databaseColumnName;
	}
	
	/**
	 * ========================================================================
	 * Return the specific database criteria
	 * 
	 * @return the databaseTableName
	 */
	protected function getStaticDatabaseCriteria() {
		return self::$_databaseCriteria;
	}
	
	/**
	 * ==========================================================================
	 * Return the specific fieldsAttributes
	 * 
	 * @return the fieldsAttributes
	 */
	protected function getStaticFieldsAttributes() {
		return self::$_fieldsAttributes;
	}
	public static function generateThumbs($classAffectable, $idAffectable, $fileFullName = null) {
		debugLog ( "generateThumbs($classAffectable, $idAffectable, $fileFullName)" );
		$sizes = array (
				16,
				22,
				32,
				48,
				80 
		); // sizes to generate, may be used somewhere
		$thumbLocation = '../files/thumbs';
		$attLoc = Parameter::getGlobalParameter ( 'paramAttachmentDirectory' );
		if (! $fileFullName) {
			$image = SqlElement::getSingleSqlElementFromCriteria ( 'Attachment', array (
					'refType' => 'Resource',
					'refId' => $this->id 
			) );
			if ($image->id) {
				$fileFullName = $image->subDirectory . $image->fileName;
			}
		}
		$fileFullName = str_replace ( '${attachmentDirectory}', $attLoc, $fileFullName );
		$fileFullName = str_replace ( '\\', '/', $fileFullName );
		debugLog ( $fileFullName );
		if ($fileFullName and isThumbable ( $fileFullName )) {
			debugLog ( count ( $sizes ) );
			foreach ( $sizes as $size ) {
				$thumbFile = $thumbLocation . "/Affectable_$idAffectable/thumb$size.png";
				debugLog ( $thumbFile );
				createThumb ( $fileFullName, $size, $thumbFile, true );
			}
		}
	}
	public static function generateAllThumbs() {
		$affList=SqlList::getList('Affectable',null,null,true);
		foreach ($affList as $id=>$name) {
			generateThumbs('Affectable',$id, null);
		}
	}
	
	public static function deleteThumbs($classAffectable, $idAffectable, $fileFullName = null) {
		$thumbLocation = '../files/thumbs/Affectable_'.$idAffectable;
		purgeFiles($thumbLocation, null);
	}
	
	public static function getThumbUrl($objectClass, $affId, $size) {
		$thumbLocation = '../files/thumbs';
		$file = "$thumbLocation/Affectable_$affId/thumb$size.png";
		if (file_exists ( $file )) {
			return "$file#$affId#&nbsp;#Affectable";
		} else {
			return "../view/img/Affectable/thumb$size.png#0#&nbsp;#Affectable";
		}
	}
}
?>