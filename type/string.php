<?php
/**
 * String data type class.
 */
class TypeString
{
	/**
	 * Convert an internal value to external format.
	 *
	 * @param   string  $internalValue  Internal value.
	 *
	 * @return  string
	 */
	public function toExternal($internalValue)
	{
		return $internalValue;
	}

	/**
	 * Convert an external value to internal format.
	 *
	 * @param   string  $externalValue  External value.
	 *
	 * @return  string
	 */
	public function toInternal($externalValue)
	{
		return $externalValue;
	}

	/**
	 * Validate an internal value.
	 *
	 * @param   string  $internalValue  Internal value.
	 *
	 * @return  boolean
	 */
	public function validateInternal($internalValue)
	{
		return is_string($internalValue);
	}

	/**
	 * Validate an external value.
	 *
	 * @param   string  $externalValue  External value.
	 *
	 * @return  boolean
	 */
	public function validateExternal($externalValue)
	{
		return is_string($externalValue);
	}
}

