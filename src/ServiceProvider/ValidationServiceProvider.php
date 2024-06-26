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
namespace Omega\Validation\ServiceProvider;

/**
 * @use
 */
use Omega\Application\Application;
use Omega\Validation\Validation;
use Omega\Validation\Rule\EmailRule;
use Omega\Validation\Rule\IntegerRule;
use Omega\Validation\Rule\MinRule;
use Omega\Validation\Rule\RequiredRule;

/**
 * Validation service provider class.
 *
 * The `ValidationServiceProvider` class binds validation-related components to the
 * application container. It registers validation rules and a ValidationManager instance
 * for handling validation.
 *
 * @category    Omega
 * @package     Omega\Validation
 * @subpackage  Omega\Validation\ServiceProvider
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2022 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
class ValidationServiceProvider
{
    /**
     * Bind all method.
     *
     * @param  Application $application Holds an instance of Application.
     * @return void
     */
    public function bind( Application $application ) : void
    {
        $application->alias( 'validator', function ( $application ) {
            $validation = new Validation();

            $this->bindRules( $application, $validation );

            return $validation;
        } );
    }

    /**
     * Bind rules.
     *
     * Registers predefined validation rules in the ValidationManager.
     *
     * @param  Application $application Holds an instance of Application.
     * @param  Validation  $validation  Holds an instance of ValidationManager.
     * @return void
     */
    private function bindRules( Application $application, Validation $validation ) : void
    {
        $application->alias( 'validation.rule.required', fn() => new RequiredRule() );
        $application->alias( 'validation.rule.email', fn() => new EmailRule() );
        $application->alias( 'validation.rule.min', fn() => new MinRule() );
        $application->alias( 'validation.rule.integer', fn() => new IntegerRule() );

        $validation->addRule( 'required', $application->resolve( 'validation.rule.required' ) );
        $validation->addRule( 'email', $application->resolve( 'validation.rule.email' ) );
        $validation->addRule( 'min', $application->resolve( 'validation.rule.min' ) );
        $validation->addRule( 'integer', $application->resolve( 'validation.rule.integer' ) );
    }
}
