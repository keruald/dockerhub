<?php

namespace Keruald\DockerHub\Tests;

use Keruald\DockerHub\DockerHubImage;
use Keruald\DockerHub\Build\TriggerBuild;

class DockerHubImageTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Keruald\DockerHub\DockerHubImage
     */
    private $image;

    public function setUp () {
        $this->image = new DockerHubImage("acme", "foo");
    }

    public function testGetRegistryUrl () {
        $this->assertSame(
            "https://registry.hub.docker.com/u/acme/foo",
            $this->image->getRegistryUrl()
        );
    }

    public function testGetTriggerBuild () {
        $this->assertInstanceOf(
            TriggerBuild::class,
            $this->image->getTriggerBuild('0000')
        );
    }

}
