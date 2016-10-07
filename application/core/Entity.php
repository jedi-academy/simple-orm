<?php

/**
 * Entity model for use with our DataMapper, though it could be used by any model.
 * 
 * This is just an entity model, to which you would add
 * business logic methods when you extend it.
 * 
 * There are no private properties, and public accessors/mutators, unlike
 * a JavaBean - those are implied/injected by PHP/CodeIgniter automatically.
 * 
 * @todo Save original key(s) to know if an update should delete the original record
 *
 * @author		JLP
 * @copyright   Copyright (c) 2016, James L. Parry
 */
class Entity {

	protected static $_CI = null; // handle to CI, for convenience

	/**
	 * Constructor.
	 * 
	 * @param array $fields	Associative array of initial properties & their values
	 * @param boolean exists Ignored here
	 */

	public function __construct($fields = null, $exists = false)
	{
		self::$_CI = &get_instance();
		if ($fields != null) $this->merge($fields);
	}

	//----------------------------------------------------------------
	// Convenience methods to extract or merge properties using
	// associative arrays, for convenient form handling.
	//----------------------------------------------------------------

	/**
	 * Merge field values with those in the entity
	 * 
	 * @param array $fields Associative array with updated properties
	 */
	function merge($fields = null)
	{
		if ($fields != null)
			foreach ($fields as $prop => $value)
			{
				// add or replace the entity's property
				$this->$prop = $value;
			}
	}

	/**
	 * Extract the entity's properties as an associative array
	 * @return array Associative array with property names as keys and their values as array values
	 */
	function fields()
	{
		$result = get_object_vars($record);
		foreach ($result as $prop => $value)
		{
			// omit internal only properties
			if (substr($prop, 0, 1) == '_')
				unset($result[$prop]);
		}
		return $result;
	}

}
