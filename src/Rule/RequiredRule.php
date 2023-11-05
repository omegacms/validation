<?php
/**
 * Part of Omega CMS - Validation Package
 *
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2022 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 */

/**
 * @declare
 */
declare( strict_types = 1 );

/**
 * @namespace
 */
namespace Omega\Validation\Rule;

/**
 * Required rule class.
 *
 * The `RequiredRule` class is responsible for validating whether a given input field 
 * is required and not empty. It checks if the input is empty and returns `true` if it's 
 * not, indicating that the input is valid.
 *
 * @category    Omega
 * @package     Omega\Validation
 * @subpackage  Omega\Validation\Rule
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2022 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
class RequiredRule extends AbstractRule
{
    /**
     * @inheritdoc
     *
     * @param  array  $data   Holds an array of data.
     * @param  string $field  Holds the field name.
     * @param  array  $params Holds an array of parameters.
     * @return string|bool Return true if validation is correct, error message otherwise.
     */
    public function validate( array $data, string $field, array $params ) : string|bool
    {
        return ! empty( $data[ $field ] );
    }

    /**
     * @inheritdoc
     *
     * @param  array  $data   Holds an array of data.
     * @param  string $field  Holds the field name.
     * @param  array  $params Holds an array of parameters.
     * @return string Return the error message.
     */
    public function getMessage( array $data, string $field, array $params ) : string
    {
        return "{$field} is required";
    }
}