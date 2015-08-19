<?php
/**
 * Float value object class.
 *
 * Implemented as an immutable object with a pair of named constructors.
 */
final class TypeFloat extends Type
{
	/**
	 * Public named constructor to create a new object from an internal value.
	 *
	 * @param   float  $internalValue  Internal value.
	 *
	 * @return  TypeFloat object.
	 * @throws  \BadMethodCallException
	 */
	public static function fromInternal($internalValue)
	{
		if (!is_float($internalValue))
		{
			throw new \BadMethodCallException('Float expected');
		}

		$float = new TypeFloat;
		$float->internal = $internalValue;
		$float->external = $internalValue;

		return $float;
	}

	/**
	 * Public named constructor to create a new object from an external value.
	 *
	 * @param   float  $externalValue  External value.
	 *
	 * @return  TypeFloat object.
	 * @throws  \BadMethodCallException
	 */
	public static function fromExternal($externalValue)
	{
		if (!is_float($externalValue))
		{
			throw new \BadMethodCallException('Float expected');
		}

		$float = new TypeFloat;
		$float->external = $externalValue;
		$float->internal = $externalValue;

		return $float;
	}
}

