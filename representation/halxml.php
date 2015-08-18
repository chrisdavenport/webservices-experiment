<?php
/**
 * Representation class for application/hal+xml representations.
 *
 * This class should be passed to the render() method of a resource.
 * The render method with then callback to methods in this class depending
 * on the context.
 */
class RepresentationHalXml extends Representation
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
		// NOT IMPLEMENTED YET.
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
		echo __METHOD__ . ' not implemented' . "\n";
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
		$xml = '';

		foreach ($resource->getProperties() as $name => $property)
		{
			$xml .= '<' . $name . '>' . $property->value->getExternal() . '</' . $name . '>';
		}

		return $xml;
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
		$xml = '';

		foreach ($resource->getResources() as $embeddedList)
		{
			foreach ($embeddedList as $embedded)
			{
				$xml .= $this->render($embedded);
			}
		}

		return $xml;
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
		// Initialise.
		$xml = '<resource>';
		$links = $resource->getLinks()->getLinks();

		// Does the resource have a self link?
		if (isset($links['self']))
		{
			$self = $links['self'];
			$xml = '<resource rel="self" href="' . $self->getUri() . '">';
			unset($links['self']);
		}

		// Iterate through the links and add them at the top.
		if (!empty($links))
		{
			$xml .= $this->render($resource->getLinks());
		}

		// Iterate through the metadata properties and add them to the top-level array.
		if (!empty($resource->getMetadata()))
		{
			$xml .= $this->render($resource->getMetadata());
		}

		// Iterate through the data properties and add them to the top-level array.
		if (!empty($resource->getData()))
		{
			$xml .= $this->render($resource->getData());
		}

		// Iterate through the embedded resources and add them to the _embedded element.
		if (!empty($resource->getEmbedded()))
		{
			$xml .= $this->render($resource->getEmbedded());
		}

		$xml .= '</resource>';

		return $xml;
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
		// Not used.
	}

	protected function renderLink($rel, Resource $link)
	{
		$xml = '<link';

		$xml .= ' rel="' . $rel . '"';
		$xml .= ' href="' . $link->getUri() . '"';

		if ($link->isTemplated())
		{
			$xml .= ' templated="true"';
		}

		$xml .= ' />';

		return $xml;
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
		$xml = '';

		foreach ($resource->getLinks() as $rel => $link)
		{
			if (is_array($link))
			{
				foreach ($link as $eachLink)
				{
					$xml .= $this->renderLink($rel, $eachLink);
				}
			}
			else
			{
				$xml .= $this->renderLink($rel, $link);
			}
		}

		return $xml;
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
		$xml = '';

		foreach ($resource->getProperties() as $name => $value)
		{
			$xml .= '<' . $name . '>' . $value . '</' . $name . '>';
		}

		return $xml;
	}
}

