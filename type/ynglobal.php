<?php
/**
 * Ynglobal value object class.
 *
 * Implemented as an immutable object with a pair of named constructors.
 */
final class TypeYnglobal extends Type
{
	/**
	 * Public named constructor to create a new object from an internal value.
	 *
	 * @param   string  $internalValue  Internal value.
	 *
	 * @return  TypeYnglobal object.
	 * @throws  \BadMethodCallException
	 */
	public static function fromInternal($internalValue)
	{
		$ynglobal = new TypeYnglobal;
		$ynglobal->internal = $internalValue;

		switch ($internalValue)
		{
			case '1':
				$ynglobal->external = 'yes';
				break;

			case '0':
				$ynglobal->external = 'no';
				break;

			case '':
				$ynglobal->external = 'global';
				break;

			default:
				$message = 'Internal value must be "0", "1" or an empty string, ' . $internalValue . ' given';
				throw new \BadMethodCallException($message);
		}

		return $ynglobal;
	}

	/**
	 * Public named constructor to create a new object from an external value.
	 *
	 * @param   string  $externalValue  External value.
	 *
	 * @return  TypeYnglobal object.
	 * @throws  \BadMethodCallException
	 */
	public static function fromExternal($externalValue)
	{
		$ynglobal = new TypeYnglobal;
		$ynglobal->external = $externalValue;
		$ynglobal->internal = '';

		switch ($externalValue)
		{
			case 'yes':
				$ynglobal->internal = '1';
				break;

			case 'no':
				$ynglobal->internal = '0';
				break;

			case 'global':
				$ynglobal->internal = '';
				break;

			default:
				$message = 'External value must be "yes", "no" or "global", ' . $externalValue . ' given';
				throw new \BadMethodCallException($message);
		}

		return $ynglobal;
	}
}

