<?php
class ResourceItem extends Resource
{
	// Profile.
	protected $profile = null;

	// ResourceData object.
	protected $data = null;

	// ResourceMetadata object.
	protected $metadata = null;

	// ResourceLinks object.
	protected $links = null;

	// ResourceEmbedded object.
	protected $embedded = null;

	/**
	 * Constructor.
	 *
	 * @param   Profile  $profile  Profile of the resource.
	 */
	public function __construct(Profile $profile)
	{
		$this->profile = $profile;
	}

	/**
	 * Bind an array of data items to the resource.
	 * This is the way to load internal data into the resource object.
	 *
	 * @param   array    $data      Array of properties to be added.
	 * @param   boolean  $internal  True if values are internal; false if values are external.
	 *
	 * @return  This object for method chaining.
	 */
	public function addData(array $data, $internal = true)
	{
		foreach ($data as $name => $datum)
		{
			// If the datum is not in the profile, silently ignore it.
			if (!$propertyType = $this->profile->getProperty($name))
			{
				continue;
			}

			// If we don't have a ResourceData object, create one.
			if (is_null($this->data))
			{
				$this->data = new ResourceData();
			}

			// Create a simple object with the property type.
			$resourceProperty = new stdClass;
			$resourceProperty->type = $propertyType;
			$propertyClassName = 'Type' . ucfirst($propertyType);

			// Add the value.
			$resourceProperty->value = $internal ? $propertyClassName::fromInternal($datum) : $propertyClassName::fromExternal($datum);

			// Add the object to the resource properties array.
			$this->data->addProperty($name, $resourceProperty);
		}

		return $this;
	}

	/**
	 * Add an array of curies to the resource.
	 *
	 * @param   array  $curies  Array of Link objects to be added as curies.
	 *
	 * @return  This object for method chaining.
	 */
	public function addCuries(array $curies)
	{
		foreach ($curies as $name => $curie)
		{
			// If we don't have a ResourceLinks object, create one.
			if (is_null($this->links))
			{
				$this->links = new ResourceLinks();
			}

			// Add the curie objects to the ResourceLinks object.
			// Note that we force the curies to always be in an array.
			$this->links->addLinks('curies', array($curie));
		}

		return $this;
	}

	/**
	 * Add an array of link items to the resource.
	 *
	 * @param   array  $links  Array of Link objects to be added.
	 *
	 * @return  This object for method chaining.
	 */
	public function addLinks(array $links)
	{
		foreach ($links as $rel => $link)
		{
			// If we don't have a ResourceLinks object, create one.
			if (is_null($this->links))
			{
				$this->links = new ResourceLinks();
			}

			// Add the link objects to the ResourceLinks object.
			// Note that a single rel might be an array of links.
			$this->links->addLinks($rel, $link);
		}

		return $this;
	}

	/**
	 * Add an array of embedded resource items to the resource.
	 *
	 * @param   array  $embedded  Array of resource objects to be added.
	 *
	 * @return  This object for method chaining.
	 */
	public function addEmbedded(array $resources)
	{
		foreach ($resources as $rel => $resource)
		{
			// If we don't have a ResourceEmbedded object, create one.
			if (is_null($this->embedded))
			{
				$this->embedded = new ResourceEmbedded();
			}

			// Add the resource objects to the ResourceEmbedded object.
			// Note that a single rel might be an array of resources.
			$this->embedded->addResources($rel, array($resource));
		}

		return $this;
	}

	/**
	 * Add an array of metadata items to the resource.
	 * If any item names already exists, this will overwrite them.
	 *
	 * @param   array  $metadata  Array of name-value pairs to be added.
	 *
	 * @return  This object for method chaining.
	 */
	public function addMetadata(array $metadata)
	{
		foreach ($metadata as $name => $value)
		{
			// If we don't have a ResourceMetadata object, create one.
			if (is_null($this->metadata))
			{
				$this->metadata = new ResourceMetadata();
			}

			// Add the property to the ResourceMetadata object.
			$this->metadata->addProperty($name, $value);
		}

		return $this;
	}

	/**
	 * Get the profile associated with this resource.
	 *
	 * @return  Profile object.
	 */
	public function getProfile()
	{
		return $this->profile;
	}

	/**
	 * Get the resource metadata array.
	 *
	 * @return  Array of resource metadata items.
	 */
	public function getMetadata()
	{
		return $this->metadata;
	}

	/**
	 * Get the resource data.
	 *
	 * @return  ResourceData object.
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Get the resource links.
	 *
	 * @return  ResourceLinks object.
	 */
	public function getLinks()
	{
		return $this->links;
	}

	/**
	 * Get the embedded resources.
	 *
	 * @return  ResourceEmbedded object.
	 */
	public function getEmbedded()
	{
		return $this->embedded;
	}

	/**
	 * Get the resource data as a simple array of name-value pairs.
	 *
	 * @return  array of resource data items.
	 */
	public function getInternalData()
	{
		$data = array();

		foreach ($this->getData()->getProperties() as $name => $property)
		{
			$data[$name] = $property->value->getInternal();
		}

		return $data;
	}
}
