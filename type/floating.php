<?php
/**
 * Floating value object class.
 *
 * Implemented as an immutable object with a pair of named constructors.
 */
final class TypeFloating extends Type
{
	/**
	 * Public named constructor to create a new object from an internal value.
	 *
	 * @param   string  $internalValue  Internal value.
	 *
	 * @return  TypeFloating object.
	 * @throws  \BadMethodCallException
	 */
	public static function fromInternal($internalValue)
	{
		$floating = new TypeFloating;
		$floating->internal = $internalValue;

		switch ($internalValue)
		{
			case 'left':
			case 'right':
			case 'none':
				$floating->external = $internalValue;
				break;

			case '':
			case 'global':
				$floating->external = 'global';
				break;

			default:
				$message = 'Internal value must be "left", "right", "none", "global" or an empty string, ' . $internalValue . ' given';
				throw new \BadMethodCallException($message);
		}

		return $floating;
	}

	/**
	 * Public named constructor to create a new object from an external value.
	 *
	 * @param   string  $externalValue  External value.
	 *
	 * @return  TypeFloating object.
	 * @throws  \BadMethodCallException
	 */
	public static function fromExternal($externalValue)
	{
		$floating = new TypeFloating;
		$floating->external = $externalValue;

		switch ($externalValue)
		{
			case 'left':
			case 'right':
			case 'none':
				$floating->internal = $externalValue;
				break;

			case '':
			case 'global':
				$floating->internal = 'global';
				break;

			default:
				$message = 'External value must be "left", "right", "none", "global" or an empty string, ' . $externalValue . ' given';
				throw new \BadMethodCallException($message);
		}

		return $floating;
	}
}

