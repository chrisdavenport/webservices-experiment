<?php
/**
 * Ynglobal data type class.
 */
class TypeYnglobal
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
		$externalValue = '';

		switch ($internalValue)
		{
			case '1':
				$externalValue = 'yes';
				break;

			case '0':
				$externalValue = 'no';
				break;

			case '':
				$externalValue = 'global';
				break;

			default:
				throw new UnexpectedValueException('Internal value must be "0", "1" or an empty string, ' . $externalValue . ' given');
		}

		return $externalValue;
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
		$internalValue = '';

		switch ($externalValue)
		{
			case 'yes':
				$internalValue = '1';
				break;

			case 'no':
				$internalValue = '0';
				break;

			case 'global':
				$internalValue = '';
				break;

			default:
				throw new UnexpectedValueException('External value must be "yes", "no" or "global", ' . $externalValue . ' given');
		}

		return $internalValue;
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
		return ($internalValue == '0' || $internalValue == '1' || $internalValue == '');
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
		return ($externalValue == 'yes' || $externalValue == 'no' || $externalValue == 'global');
	}
}

