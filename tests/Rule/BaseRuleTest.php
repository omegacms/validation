<?php
/**
 * Part of Omega CMS -  Validation Test Package
 *
 * @link       https://omegacms.github.io
 * @author     Adriano Giovannini <omegacms@outlook.com>
 * @copyright  Copyright (c) 2024 Adriano Giovannini. (https://omegacms.github.io)
 * @license    https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 */

/**
 * @declare
 */
declare( strict_types = 1 );

/**
 * @namespace
 */
namespace Omega\Validation\Tests\Rule;

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

/**
 * @use
 */
use Omega\Validation\Validation;
use Omega\Validation\Rule\EmailRule;
use Omega\Validation\Rule\IntegerRule;
use Omega\Validation\Rule\MinRule;
use Omega\Validation\Rule\RequiredRule;
use Omega\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;

/**
 * Validation test class.
 * 
 * The `ValidationTest` class extends the `TestCase` class provided by the Omega CMS testing 
 * framework. It contains several test methods to verify the functionality of the Omega CMS 
 * validation library.
 *
 * @category    Omega
 * @package     Omega\Validation
 * @subpackage  Omega\Validation\Tests
 * @link        https://omegacms.github.io
 * @author      Adriano Giovannini <omegacms@outlook.com>
 * @copyright   Copyright (c) 2024 Adriano Giovannini. (https://omegacms.github.io)
 * @license     https://www.gnu.org/licenses/gpl-3.0-standalone.html     GPL V3.0+
 * @version     1.0.0
 */
class BaseRuleTest extends TestCase
{
    /**
     * Validation instance.
     * 
     * @var Validation $validation Holds the current Validation instance.
     */
    protected Validation $validation;

    /**
     * Setup.
     * 
     * This method is inherited from the parent class and is presumably used 
     * for common test setup procedures. In this specific case, it creates a 
     * new `Validation` instance, adds various validation rules to it (`EmailRule`, 
     * `IntegerRule`, `MinRule`, and `RequiredRule`), and assigns it to the 
     * `$validation` property.
     * 
     * @return void
     */
    public function setUp() : void
    {
        parent::setUp();
    
        $this->validation = new Validation();

        $this->validation->addRule('email', new EmailRule());
        $this->validation->addRule('integer', new IntegerRule());
        $this->validation->addRule('min', new MinRule());
        $this->validation->addRule('required', new RequiredRule());
    }


    /**
     * Placeholder test method to avoid PHPUnit warning.
     * 
     * Verifies that the $validation object is correctly initialized.
     *
     * @return void
     */
    #[Test]
    public function validationObjectIsInitialized(): void
    {
        $this->assertInstanceOf(Validation::class, $this->validation);
    }
}