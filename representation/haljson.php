<?php
/**
 * Representation class for application/hal+json representations.
 *
 * This class should be passed to the render() method of a resource.
 * The render method with then callback to methods in this class depending
 * on the context.
 */
class RepresentationHalJson extends Representation
{
	/**
	 * Parse a serialisation into a ResourceItem object.
	 *
	 * @param   Resource  $resource       A resource object to build.
	 * @param   string    $serialisation  A serialisation for parsing.
	 *
	 * @return  void
	 */
	public function parseResourceItem(ResourceItem $resource, $serialisation)
	{
		$properties = array();
		$data = json_decode($serialisation);

		foreach ($data as $name => $value)
		{
			$properties[$name] = $value;
		}

		// Add the data to the resource.
		$resource->addData($properties, false);
	}

	/**
	 * Render a representation of a ResourceCurie object.
	 *
	 * @param   ResourceCurie  $resource  A resource curie object.
	 *
	 * @return  A representation of the object.
	 */
	public function renderResourceCurie(ResourceCurie $resource)
	{
		$link = new stdClass;
		$link->name = $resource->getName();
		$link->href = $resource->getUri();

		if ($resource->isTemplated())
		{
			$link->templated = $resource->isTemplated();
		}

		return $link;
	}

	/**
	 * Render a representation of a ResourceData object.
	 *
	 * @param   ResourceData  $resource  A resource data object.
	 *
	 * @return  A representation of the object.
	 */
	public function renderResourceData(ResourceData $resource)
	{
		$data = array();

		foreach ($resource->getProperties() as $name => $property)
		{
			$data[$name] = $property->type->toExternal($property->internal);
		}

		return $data;
	}

	/**
	 * Render a representation of a ResourceEmbedded object.
	 *
	 * @param   ResourceEmbedded  $resource  An embedded resources object.
	 *
	 * @return  A representation of the object.
	 */
	public function renderResourceEmbedded(ResourceEmbedded $resource)
	{
		$data = array();

		foreach ($resource->getResources() as $rel => $resources)
		{
			if (is_array($resources))
			{
				foreach ($resources as $resource)
				{
					$data[$rel][] = json_decode($this->render($resource));
				}
			}
			else
			{
				$data[$rel] = $this->render($resources);
			}
		}

		return $data;
	}

	/**
	 * Render a representation of a ResourceItem object.
	 *
	 * @param   ResourceItem  $resource  A resource item object.
	 *
	 * @return  A representation of the object.
	 */
	public function renderResourceItem(ResourceItem $resource)
	{
		$properties = array();

		// Iterate through the metadata properties and add them to the top-level array.
		if (!empty($resource->getMetadata()))
		{
			foreach ($this->render($resource->getMetadata()) as $name => $property)
			{
				$properties[$name] = $property;
			}
		}

		// Iterate through the links and add them to the _links element.
		if (!empty($resource->getLinks()))
		{
			foreach ($this->render($resource->getLinks()) as $rel => $link)
			{
				$properties['_links'][$rel] = $link;
			}
		}

		// Iterate through the data properties and add them to the top-level array.
		if (!empty($resource->getData()))
		{
			foreach ($this->render($resource->getData()) as $name => $property)
			{
				$properties[$name] = $property;
			}
		}

		// Iterate through the embedded resources and add them to the _embedded element.
		if (!empty($resource->getEmbedded()))
		{
			foreach ($this->render($resource->getEmbedded()) as $rel => $embedded)
			{
				$properties['_embedded'][$rel] = $embedded;
			}
		}

		return json_encode($properties, JSON_PRETTY_PRINT);
	}

	/**
	 * Render a representation of a ResourceLink object.
	 *
	 * @param   ResourceLink  $resource  A resource link object.
	 *
	 * @return  A representation of the object.
	 */
	public function renderResourceLink(ResourceLink $resource)
	{
		$link = new stdClass;
		$link->href = $resource->getUri();

		if ($resource->isTemplated())
		{
			$link->templated = $resource->isTemplated();
		}

		if ($resource->getTitle() != '')
		{
			$link->title = $resource->getTitle();
		}

		return $link;
	}

	/**
	 * Render a representation of a ResourceLinks object.
	 *
	 * @param   ResourceLinks  $resource  A resource links object.
	 *
	 * @return  A representation of the object.
	 */
	public function renderResourceLinks(ResourceLinks $resource)
	{
		$data = array();

		foreach ($resource->getLinks() as $rel => $link)
		{
			if (is_array($link))
			{
				foreach ($link as $eachLink)
				{
					$data[$rel][] = $this->render($eachLink);
				}
			}
			else
			{
				$data[$rel] = $this->render($link);
			}
		}

		return $data;
	}

	/**
	 * Render a representation of a ResourceMetadata object.
	 *
	 * @param   ResourceMetadata  $resource  A resource metadata object.
	 *
	 * @return  A representation of the object.
	 */
	public function renderResourceMetadata(ResourceMetadata $resource)
	{
		$data = array();

		foreach ($resource->getProperties() as $name => $value)
		{
			$data[$name] = $value;
		}

		return $data;
	}
}

