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
use Omega\Validation\ValidationManager;
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
        $application->bind( 'validator', function ( $application ) {
            $validationManager = new ValidationManager();

            $this->bindRules( $application, $validationManager );

            return $validationManager;
        } );
    }

    /**
     * Bind rules.
     *
     * Registers predefined validation rules in the ValidationManager.
     *
     * @param  Application       $application       Holds an instance of Application.
     * @param  ValidationManager $validationManager Holds an instance of ValidationManager.
     * @return void
     */
    private function bindRules( Application $application, ValidationManager $validationManager ) : void
    {
        $application->bind( 'validation.rule.required', fn() => new RequiredRule() );
        $application->bind( 'validation.rule.email', fn() => new EmailRule() );
        $application->bind( 'validation.rule.min', fn() => new MinRule() );
        $application->bind( 'validation.rule.integer', fn() => new IntegerRule() );

        $validationManager->addRule( 'required', $application->resolve( 'validation.rule.required' ) );
        $validationManager->addRule( 'email', $application->resolve( 'validation.rule.email' ) );
        $validationManager->addRule( 'min', $application->resolve( 'validation.rule.min' ) );
        $validationManager->addRule( 'integer', $application->resolve( 'validation.rule.integer' ) );
    }
}
