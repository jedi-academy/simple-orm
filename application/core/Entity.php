<?php

/**
 * Entity model for use with our DataMapper.
 * 
 * This is an implementation of the Active Record pattern.
 * 
 * @todo Save original key(s) to know if an update should delete the original record
 *
 * @author		JLP
 * @copyright   Copyright (c) 2016, James L. Parry
 */
class Entity implements ActiveRecord {

	protected static $_boss = null; // the DataMapper for this entity
	protected static $_CI = null; // handle to CI
	protected $_exists = false; // is this an existing record

	/**
	 * Constructor
	 */

	public function __construct()
	{
		self::$_CI = &get_instance();
	}

	/**
	 * Set the entity's DataMapper
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
	 * @param array $fields Associateive array with any initial properties
	 * @return ActiveRecord an instance
	 */
	static function create($fields = null, $exists = false)
	{
		$entity = new Entity();
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

	/**
	 * Merge field values with those in the entity
	 * 
	 * @param array $fields Associative array with updated properties
	 */
	function merge($fields = null)
	{
		foreach ($fields as $prop => $value)
		{
			$this->$prop = $value;
		}
	}

	/**
	 * Extract the entity's properties as an associative array
	 */
	function fields()
	{
		$result = get_object_vars($record);
		foreach ($result as $prop => $value)
		{
			if (substr($prop, 0, 1) == '_')
				unset($result[$prop]);
		}
		return $result;
	}

}
