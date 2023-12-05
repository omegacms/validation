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
 * @use
 */
use function strlen;
use InvalidArgumentException;

/**
 * Min rule class.
 *
 * The `MinRule` class is responsible for validating whether a given input string
 * has a minimum length. It checks if the input is empty and, if not, compares its
 * length with the specified minimum length parameter. If the input is empty, it is
 * considered valid.
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
class MinRule extends AbstractRule
{
    /**
     * @inheritdoc
     *
     * @param  array  $data   Holds an array of data.
     * @param  string $field  Holds the field name.
     * @param  array  $params Holds an array of parameters.
     * @return string|bool Return true if validation is correct, error message otherwise.
     * @throws InvalidArgumentException If the minimum length parameter is not specified.
     */
    public function validate( array $data, string $field, array $params ) : string|bool
    {
        if ( empty( $data[ $field ] ) ) {
            return true;
        }

        if ( empty( $params[ 0 ] ) ) {
            throw new InvalidArgumentException(
                'Specify a min length.'
            );
        }

        $length = (int)$params[ 0 ];

        return strlen( $data[ $field ] ) >= $length;
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
        $length = (int)$params[ 0 ];

        return "{$field} should be at least {$length} characters.";
    }
}
