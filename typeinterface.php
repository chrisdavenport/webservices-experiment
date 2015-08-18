<?php
/**
 * Type interface.
 */
interface TypeInterface
{
	/**
	 * Get the external value of the type.
	 *
	 * @return  mixed
	 */
	public function getExternal();

	/**
	 * Get the internal value of the type.
	 *
	 * @return  mixed
	 */
	public function getInternal();
}

