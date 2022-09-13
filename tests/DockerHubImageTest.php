<?php

namespace Keruald\DockerHub\Tests;

use Keruald\DockerHub\DockerHubImage;
use Keruald\DockerHub\Build\TriggerBuild;

use PHPUnit\Framework\TestCase;

class DockerHubImageTest extends TestCase {

    use WithMockHttpClient;

    /**
     * @var Keruald\DockerHub\DockerHubImage
     */
    private $image;

    public function setUp () : void {
        $this->image = new DockerHubImage("acme", "foo");
    }

    public function testLoadFromSlashNotation () {
        $slashNotationImage = DockerHubImage::loadFromSlashNotation("acme/foo");
        $this->assertEquals($slashNotationImage, $this->image);
    }

    public function testLoadFromSlashNotationWithInvalidArgument () {
        $this->expectException(\Exception::class);
        DockerHubImage::loadFromSlashNotation("foo");
    }

    public function testGetRegistryUrl () {
        $this->assertSame(
            "https://registry.hub.docker.com/u/acme/foo",
            $this->image->getRegistryUrl()
        );
    }

    public function testGetTriggerBuild () {
        $client = self::mockHttpClient(200);
        $this->assertInstanceOf(
            TriggerBuild::class,
            $this->image->getTriggerBuild($client, '0000')
        );
    }

}
