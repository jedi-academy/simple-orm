<?php

/**
 * Very simple Active Record abstraction.
 *
 * @author		JLP
 * @copyright   Copyright (c) 2016, James L. Parry
 * ------------------------------------------------------------------------
 */
interface ActiveRecord {

	/**
	 * Set the entity's DataMapper
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
