<?php
/**
 * Integer data type class.
 */
class TypeInteger
{
	/**
	 * Convert an internal value to external format.
	 *
	 * @param   integer  $internalValue  Internal value.
	 *
	 * @return  integer
	 */
	public function toExternal($internalValue)
	{
		return $internalValue;
	}

	/**
	 * Convert an external value to internal format.
	 *
	 * @param   integer  $externalValue  External value.
	 *
	 * @return  integer
	 */
	public function toInternal($externalValue)
	{
		return $externalValue;
	}

	/**
	 * Validate an internal value.
	 *
	 * @param   integer  $internalValue  Internal value.
	 *
	 * @return  boolean
	 */
	public function validateInternal($internalValue)
	{
		return is_integer($internalValue);
	}

	/**
	 * Validate an external value.
	 *
	 * @param   integer  $externalValue  External value.
	 *
	 * @return  boolean
	 */
	public function validateExternal($externalValue)
	{
		return is_integer($externalValue);
	}
}

