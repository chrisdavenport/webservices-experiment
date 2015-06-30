<?php
class ResourceLink extends Resource
{
	protected $uri = '';
	protected $templated = false;
	protected $title = '';

	/**
	 * Constructor.
	 *
	 * @param   string   $uri        A URI.
	 * @param   boolean  $templated  True if link is a URI template (see RFC6570).
	 * @param   string   $title      Optional title (human-readable label) for the link.
	 */
	public function __construct($uri, $templated = false, $title = '')
	{
		$this->uri = $uri;
		$this->templated = $templated;
		$this->title = $title;
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

	/**
	 * Get the title.
	 *
	 * @return  string
	 */
	public function getTitle()
	{
		return $this->title;
	}
}
