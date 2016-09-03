<?php

namespace Keruald\DockerHub\Tests;

use Keruald\DockerHub\DockerHubImage;
use Keruald\DockerHub\Build\TriggerBuild;

class DockerHubImageTest extends \PHPUnit_Framework_TestCase {

    use WithMockHttpClient;

    /**
     * @var Keruald\DockerHub\DockerHubImage
     */
    private $image;

    public function setUp () {
        $this->image = new DockerHubImage("acme", "foo");
    }

    public function testLoadFromSlashNotation () {
        $slashNotationImage = DockerHubImage::loadFromSlashNotation("acme/foo");
        $this->assertEquals($slashNotationImage, $this->image);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLoadFromSlashNotationWithInvalidArgument () {
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
