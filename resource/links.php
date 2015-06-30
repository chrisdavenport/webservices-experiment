<?php
class ResourceLinks extends Resource
{
	// Array of Link objects.
	protected $links = array();

	/**
	 * Add an array of link objects to the links array.
	 * If the link rel already exists, this will overwrite it.
	 *
	 * @param   string  $rel   Link relation.
	 * @param   array   $link  Array of Link objects.
	 *
	 * @return  This object for method chaining.
	 */
	public function addLinks($rel, $links)
	{
		if (is_array($links))
		{
			foreach ($links as $link)
			{
				$this->links[$rel][] = $link;
			}
		}
		else
		{
			$this->links[$rel] = $links;
		}

		return $this;
	}

	/**
	 * Get array of links from the resource.
	 *
	 * @return  array
	 */
	public function getLinks()
	{
		return $this->links;
	}
}
