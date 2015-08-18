<?php
/**
 * Profile class.
 *
 * Profiles are like schemas and define a kind of template which is used to construct a resource
 * object in memory.  Representations can then be derived from the resource object.  A profile
 * defines the name and type of each property and could be extended with other information.
 * An automatic process could be written to generate machine-readable profile documents, such as
 * ALPS or JSON-LD contexts from the profile.
 *
 * New data types can be added by adding a class file in the type directory.  The new type can
 * then be referenced in the profile.
 */
class Profile
{
	// Name of the profile.
	private $name = '';

	// Array of property definitions.
	private $properties = array();

	/**
	 * Constructor.
	 *
	 * @param   string  $schemaFile  A file containing a JSON-encoded schema.
	 */
	public function __construct($schemaFile)
	{
		if (!file_exists($schemaFile))
		{
			throw new RuntimeException('Schema file not found: ' . $schemaFile);
		}

		// Read the file and decode the schema.
		$schema = json_decode(file_get_contents($schemaFile));

		// Save the name of the profile.
		$this->name = $schema->name;

		// Match each property to a data type.
		foreach ($schema->properties as $property)
		{
			$this->properties[$property->name] = $property->type;
		}
	}

	/**
	 * Get the array of property definition objects.
	 *
	 * @return  array of property definition objects.
	 */
	public function getProperties()
	{
		return $this->properties;
	}

	/**
	 * Get an individual property definition.
	 *
	 * @param   string  $name  Name of the property.
	 *
	 * @return  Property definition object or false if it doesn't exist.
	 */
	public function getProperty($name)
	{
		if (!isset($this->properties[$name]))
		{
			return false;
		}

		return $this->properties[$name];
	}
}
