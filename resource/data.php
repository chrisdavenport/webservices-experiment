<?php
class ResourceData extends Resource
{
	// Properties.
	protected $properties = array();

	/**
	 * Add a property to the data resource.
	 * If the property name already exists, this will overwrite it.
	 *
	 * @param   string  $name      Name of the property.
	 * @param   object  $property  Property object.
	 *
	 * @return  void
	 */
	public function addProperty($name, $property)
	{
		$this->properties[$name] = $property;
	}

	/**
	 * Get array of properties from the resource.
	 *
	 * @return  array
	 */
	public function getProperties()
	{
		return $this->properties;
	}
}
