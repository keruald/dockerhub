<?php

namespace Keruald\DockerHub\Tests\Build;

use Keruald\DockerHub\DockerHubImage;
use Keruald\DockerHub\Build\TriggerBuild;
use Keruald\DockerHub\Build\TriggerBuildFactory;

use Keruald\DockerHub\Tests\WithMockHttpClient;

use PHPUnit\Framework\TestCase;

class TriggerBuildFactoryTest extends TestCase {

    use WithMockHttpClient;

    /**
     * @var Keruald\DockerHub\Build\TriggerBuildFactory
     */
    protected $factory;

    public function setUp () : void {
        $client = self::mockHttpClient();
        $tokens = self::mockTokens();
        $this->factory = new TriggerBuildFactory($client, $tokens);
    }

    /**
     * @return array
     */
    private static function mockTokens () {
        return [
            "acme/foo" => "0000",
        ];
    }

    public function testGetForImage () {
        $this->assertInstanceOf(
            TriggerBuild::class,
            $this->factory->getForImage("acme/foo")
        );
    }

    public function testGetForImageWithoutToken () {
        $this->expectException(\Exception::class);
        $this->factory->getForImage("acme/bar");
    }

    public function testBuild () {
        // That returns void.
        // We don't need to test the sendPayloadForAll method.
        // So, we only need to check there is no exception or error.
        $this->factory->build("acme/foo");
        $this->expectNotToPerformAssertions();
    }

    public function testHasToken () {
        $this->assertTrue($this->factory->hasToken("acme/foo"));
    }

    public function testHasTokenWhenWeDoNot () {
        $this->assertFalse($this->factory->hasToken("acme/bar"));
    }

}
