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
namespace Omega\Validation;

/**
 * @use
 */
use function array_intersect_key;
use function explode;
use function str_contains;
use Omega\Validation\Rule\RuleInterface;
use Omega\Validation\Exception\ValidationException;

/**
 * Validation manager class.
 *
 * The `ValidationManager` class provides a flexible and extensible way to perform data
 * validation. This class allows you to define validation rules and validate data against
 * those rules.
 *
 * @category    Omega
 * @package     Omega\Validation
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2022 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
class Validation extends AbstractValidation
{
    /**
     * @inheritdoc
     *
     * @param  string        $alias Holds the rule alias.
     * @param  RuleInterface $rule  Holds an instance of RuleInterface.
     * @return $this
     */
    public function addRule( string $alias, RuleInterface $rule ) : static
    {
        $this->rules[ $alias ] = $rule;

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @param  array  $data        Holds an array of data.
     * @param  array  $rules       Holds an array of rules.
     * @param  string $sessionName Holds the session name.
     * @return array Return an array of valid rule.
     * @thrpws ValidationException if validation fails.
     */
    public function validate( array $data, array $rules, string $sessionName = 'errors' ) : array
    {
        $errors = [];

        foreach ( $rules as $field => $rulesForField ) {
            foreach ( $rulesForField as $rule ) {
                $name   = $rule;
                $params = [];

                if ( str_contains( $rule, ':' ) ) {
                    [ $name, $params ] = explode( ':', $rule );
                    $params            = explode( ',', $params );
                }

                $processor = $this->rules[ $name ];

                if ( ! $processor->validate( $data, $field, $params ) ) {
                    if ( ! isset( $errors[ $field ] ) ) {
                        $errors[ $field ] = [];
                    }

                    $errors[ $field ][] = $processor->getMessage( $data, $field, $params );
                }
            }
        }

        if ( count( $errors ) ) {
            $exception = new ValidationException();
            $exception->setErrors( $errors );
            $exception->setSessionName( $sessionName );
            throw $exception;
        } else {
            // this is here until we have a better session system...
            unset( $_SESSION[ $sessionName ] );
        }

        return array_intersect_key( $data, $rules );
    }
}
