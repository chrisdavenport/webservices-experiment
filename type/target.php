<?php
/**
 * Target value object class.
 *
 * Implemented as an immutable object with a pair of named constructors.
 */
final class TypeTarget extends Type
{
	/**
	 * Public named constructor to create a new object from an internal value.
	 *
	 * @param   string  $internalValue  Internal value.
	 *
	 * @return  TypeTarget object.
	 * @throws  \BadMethodCallException
	 */
	public static function fromInternal($internalValue)
	{
		$target = new TypeTarget;
		$target->internal = $internalValue;

		switch ($internalValue)
		{
			case '0':
				$target->external = 'parent';
				break;

			case '1':
				$target->external = 'new';
				break;

			case '2':
				$target->external = 'popup';
				break;

			case '3':
				$target->external = 'modal';
				break;

			case '':
				$target->external = 'global';
				break;

			default:
				$message = 'Internal value must be "0", "1", "2", "3" or an empty string, ' . $internalValue . ' given';
				throw new \BadMethodCallException($message);
		}

		return $target;
	}

	/**
	 * Public named constructor to create a new object from an external value.
	 *
	 * @param   string  $externalValue  External value.
	 *
	 * @return  TypeTarget object.
	 * @throws  \BadMethodCallException
	 */
	public static function fromExternal($externalValue)
	{
		$target = new TypeTarget;
		$target->external = $externalValue;

		switch ($externalValue)
		{
			case 'parent':
				$target->internal = '0';
				break;

			case 'new':
				$target->internal = '1';
				break;

			case 'popup':
				$target->internal = '2';
				break;

			case 'modal':
				$target->internal = '3';
				break;

			case 'global':
				$target->internal = '';
				break;

			default:
				$message = 'External value must be "parent", "new", "popup", "modal" or "global", ' . $externalValue . ' given';
				throw new \BadMethodCallException($message);
		}

		return $target;
	}
}

