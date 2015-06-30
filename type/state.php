<?php
/**
 * State data type class.
 */
class TypeState
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
			case '0':
				$externalValue = 'unpublished';
				break;

			case '1':
				$externalValue = 'published';
				break;

			case '2':
				$externalValue = 'archived';
				break;

			case '-2':
				$externalValue = 'trashed';
				break;

			default:
				throw new UnexpectedValueException('Internal value must be "0", "1", "2" or "-2", ' . $externalValue . ' given');
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
			case 'unpublished':
				$internalValue = '0';
				break;

			case 'published':
				$internalValue = '1';
				break;

			case 'archived':
				$internalValue = '2';
				break;

			case 'trashed':
				$internalValue = '-2';
				break;

			default:
				throw new UnexpectedValueException('External value must be "unpublished", "published", "archived" or "trashed", ' . $externalValue . ' given');
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
		return ($internalValue == '0' || $internalValue == '1' || $internalValue == '2' || $internalValue == '-2');
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
		return ($externalValue == 'unpublished' || $externalValue == 'published' || $externalValue == 'archived' || $externalValue == 'trashed');
	}
}

