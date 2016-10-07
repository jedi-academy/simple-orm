<?php

/**
 * Very simple Active Record abstraction.
 * 
 * This *is* an example of the "Active Record" design pattern, and one way
 * or aspect of building an Object-Relational Mapping.
 * 
 * Yes, the word Interface in the name is redundant, but that is the "PHP way"
 *
 * @author		JLP
 * @copyright   Copyright (c) 2016, James L. Parry
 * ------------------------------------------------------------------------
 */
interface ActiveRecordInterface {

	/**
	 * Set the entity's DataMapper, i.e. the table/collection/repository 
	 * manager for objects such as this
	 * 
	 * @param DataMapper $mapper	The manager for such entities
	 */
	function setMapper($mapper = null);

	/**
	 * Create a new record.
	 * 
	 * @param array $fields Associative array with any initial properties
	 * @param boolean $exists Is this an existing record?
	 * @return ActiveRecord an instance
	 */
	static function create($fields = null, $exists = false);

	/**
	 * Save this entity.
	 * 
	 * Add or update as appropriate.
	 */
	function save();

	/**
	 * Delete this entity.
	 */
	function delete();

	/**
	 * Merge field values with those in the entity
	 * 
	 * @param array $fields Associative array with updated properties
	 */
	function merge($fields = null);

	/**
	 * Extract the entity's properties as an associative array
	 */
	function fields();
}
