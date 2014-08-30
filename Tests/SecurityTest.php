<?php
/**
 * Webiny Framework (http://www.webiny.com/framework)
 *
 * @copyright Copyright Webiny LTD
 */

namespace Webiny\Component\Security\Tests;

use Webiny\Component\Security\Security;

class SecurityTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @param Security $security
     *
     * @dataProvider dataProvider
     */
    public function testConstructor($security)
    {
        $this->assertInstanceOf('\Webiny\Component\Security\Security', $security);
    }

    /**
     * @param Security $security
     *
     * @dataProvider dataProvider
     */
    public function testFirewall($security)
    {
        $this->assertInstanceOf('\Webiny\Component\Security\Authentication\Firewall', $security->firewall('Admin'));
    }

    /**
     * @param Security $security
     *
     * @dataProvider             dataProvider
     * @expectedException \Webiny\Component\Security\SecurityException
     * @expectedExceptionMessage Firewall 'test' is not defined
     */
    public function testFirewallException($security)
    {
        $this->assertInstanceOf('\Webiny\Component\Security\Authentication\Firewall', $security->firewall('test'));
    }

    public function dataProvider()
    {
        Security::setConfig(__DIR__ . '/ExampleConfig.yaml');
        $security = Security::getInstance();

        return [[$security]];
    }
}