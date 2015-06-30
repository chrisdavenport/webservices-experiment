<?php
/**
 * Abstract base class for representations.
 *
 * Representation classes are passed to the render() method of a resource.
 * The render method with then callback to the visit* methods in this class
 * depending on the context.
 */
abstract class Representation implements RepresentationInterface
{
	/**
	 * Build a resource from a representation.
	 *
	 * @param   Resource  $resource       A resource object to build.
	 * @param   string    $serialisation  A serialisation for parsing.
	 *
	 * @return  string
	 */
	public function build(Resource $resource, $serialisation)
	{
		$className = 'parse' . get_class($resource);

		return $this->$className($resource, $serialisation);
	}

	/**
	 * Render a representation of a resource.
	 *
	 * @param   Resource  $resource  A resource object to render.
	 *
	 * @return  string
	 */
	public function render(Resource $resource)
	{
		$className = 'render' . get_class($resource);

		return $this->$className($resource);
	}
}

