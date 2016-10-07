<?php

/**
 * Entity model for use with our DataMapper, though it could be used by any model.
 * 
 * This is an implementation of the Active Record pattern.
 * With such entities, their persistence could be managed by the container
 * or by the entity itself.
 * 
 * When an ActiveRecord object is created, we store a reference to its container.
 * 
 * @todo Save original key(s) to know if an update should delete the original record
 *
 * @author		JLP
 * @copyright   Copyright (c) 2016, James L. Parry
 */
class ActiveRecord extends Entity implements ActiveRecordInterface {

	protected static $_boss = null; // the DataMapper (container) for this entity
	protected $_exists = false; // is this an existing record

	/**
	 * Constructor.
	 * 
	 * Guess at the entity's container.
	 * 
	 * @param array $fields	Associative array of initial properties & their values
	 * @param boolean exists Flag to direct add or updating when saved
	 */

	public function __construct($fields = null, $exists = false)
	{
		parent::__construct($fields);
		self::$_CI = &get_instance();

		// guess at our container
		if (self::$_boss == null)
		{
			$guess = get_class() . 's'; // assume plural
			if (class_exists($guess))
			{
				$guessed = new $guess;
				if ($guessed instanceof DataMapperInterface)
					self::$_boss = $guessed;
			}
		}
		$this->_exists = $exists;
	}

	/**
	 * Set the entity's DataMapper, if it cannot be reasonably guessed in the constructor.
	 * 
	 * @param DataMapper $mapper	The manager for such entities
	 */
	function setMapper($mapper = null)
	{
		if ($mapper instanceof DataMapper)
			$this->_boss = $mapper;
		else
			$this->_mapper = null;
	}

	/**
	 * Create a new record.
	 * 
	 * @param array $fields Associative array with any initial properties
	 * @param boolean exists True if this is an existing record
	 * 
	 * @return ActiveRecord an instance
	 */
	static function create($fields = null, $exists = false)
	{
		$entity = new ActiveRecord();
		if ($fields != null)
			$entity->merge($fields);
		$entity->_exists = $exists;
		return $entity;
	}

	/**
	 * Save this entity.
	 * 
	 * Add or update as appropriate.
	 */
	function save()
	{
		if ($this->_exists)
			self::$_boss->update($this);
		else
			self::$_boss->add($this);
		$this->_exists = true;
	}

	/**
	 * Delete this entity.
	 */
	function delete()
	{
		if ($this->_exists)
			self::$_boss->delete($this);
	}

}
