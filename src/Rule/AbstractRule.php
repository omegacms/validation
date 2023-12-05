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
 * Abstract rule class.
 *
 * The `AbstractRule` class provides a foundation for implementing custom validation
 * rules in Omega. It implements the RuleInterface, which defines the contract for
 * all validation rules.
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
abstract class AbstractRule implements RuleInterface
{
    /**
     * @inheritdoc
     *
     * @param  array  $data   Holdsn array of data.
     * @param  string $field  Holds the name of the field being validated.
     * @param  array  $params Holds an array of parameters (not used for this rule).
     * @return string|bool Returns `true` if validation is successful (valid integer format), or an error message if the validation fails.
     */
    abstract public function validate( array $data, string $field, array $params ) : string|bool;

    /**
     * @inheritdoc
     *
     * @param  array  $data   Holds an array of data.
     * @param  string $field  Holds the name of the field that failed validation.
     * @param  array  $params Holds an array of parameters (not used for this rule).
     * @return string Returns the error message indicating that the field should be in a valid integer format.
     */
    abstract public function getMessage( array $data, string $field, array $params ) : string;
}
