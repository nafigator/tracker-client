<?php

namespace linkprofit\AmoCRM\tests\request;

use linkprofit\Tracker\AccessLevel;
use linkprofit\Tracker\request\ConnectionQuery;
use linkprofit\Tracker\tests\providers\ConnectionProvider;
use PHPUnit\Framework\TestCase;

class ConnectionQueryTest extends TestCase
{
    /**
     * @var ConnectionProvider
     */
    public $connection;

    public function testAccess()
    {
        $content = new ConnectionQuery($this->connection->getUser());

        $this->assertEquals($content->getAccessLevel(), AccessLevel::USER);
        $this->assertEquals($content->getUrl(), '/authorization/user');

        $content = new ConnectionQuery($this->connection->getAdmin());

        $this->assertEquals($content->getAccessLevel(), AccessLevel::ADMIN);
        $this->assertEquals($content->getUrl(), '/authorization/employer');
    }

    public function testRequiredCheck()
    {
        $content = new ConnectionQuery($this->connection->getUser());
        $this->assertTrue($this->invokeMethod($content, 'checkRequired'));

        $content = new ConnectionQuery($this->connection->getEmpty());
        $this->assertFalse($this->invokeMethod($content, 'checkRequired'));
    }

    public function testGetMethod()
    {
        $content = new ConnectionQuery($this->connection->getUser());
        $this->assertEquals('PUT', $content->getMethod());
    }

    public function testGetBody()
    {
        $rightBody = [
            'userName' => 'user',
            'userPassword' => 'password'
        ];

        $content = new ConnectionQuery($this->connection->getUser());
        $this->assertEquals(json_encode($rightBody), $content->getBody());

        $content = new ConnectionQuery($this->connection->getEmpty());
        $this->assertNull($content->getBody());
    }

    public function setUp()
    {
        $this->connection = new ConnectionProvider();
    }

    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
