<?php
/**
 * String value object class.
 *
 * Implemented as an immutable object with a pair of named constructors.
 */
final class TypeString extends Type
{
	/**
	 * Public named constructor to create a new object from an internal value.
	 *
	 * @param   string  $internalValue  Internal value.
	 *
	 * @return  TypeString object.
	 */
	public static function fromInternal($internalValue)
	{
		if (!is_string($internalValue))
		{
			throw new BadMethodCallException('String expected');
		}

		$string = new TypeString;
		$string->internal = $internalValue;
		$string->external = $internalValue;

		return $string;
	}

	/**
	 * Public named constructor to create a new object from an external value.
	 *
	 * @param   string  $externalValue  External value.
	 *
	 * @return  TypeString object.
	 */
	public static function fromExternal($externalValue)
	{
		if (!is_string($externalValue))
		{
			throw new BadMethodCallException('String expected');
		}

		$string = new TypeString;
		$string->internal = $externalValue;
		$string->external = $externalValue;

		return $string;
	}
}

