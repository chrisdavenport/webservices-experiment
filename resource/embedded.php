<?php
class ResourceEmbedded extends Resource
{
	// Array of resource objects.
	protected $resources = array();

	/**
	 * Add an array of resource objects to the resources array.
	 *
	 * @param   string  $rel        Link relation.
	 * @param   array   $resources  Array of resource objects.
	 *
	 * @return  This object for method chaining.
	 */
	public function addResources($rel, array $resources)
	{
		foreach ($resources as $resource)
		{
			$this->resources[$rel][] = $resource;
		}

		return $this;
	}

	/**
	 * Get array of embedded resources from the resource.
	 *
	 * @return  array
	 */
	public function getResources()
	{
		return $this->resources;
	}
}
