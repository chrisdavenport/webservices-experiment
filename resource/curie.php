<?php
class ResourceCurie extends Resource
{
	protected $name = '';
	protected $uri = '';
	protected $templated = false;

	/**
	 * Constructor.
	 *
	 * @param   string   $name       Name of the curie
	 * @param   string   $uri        A URI.
	 * @param   boolean  $templated  True if link is a URI template (see RFC6570).
	 */
	public function __construct($name, $uri, $templated = false)
	{
		if ($name == '')
		{
			throw new UnexpectedValueException('Curie name must not be blank');
		}

		$this->name = $name;
		$this->uri = $uri;
		$this->templated = $templated;
	}

	/**
	 * Get the name.
	 *
	 * @return  string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Get the URI.
	 *
	 * @return  string
	 */
	public function getUri()
	{
		return $this->uri;
	}

	/**
	 * Is link a URI template (RFC6570)?
	 *
	 * @return  boolean
	 */
	public function isTemplated()
	{
		return $this->templated;
	}
}
