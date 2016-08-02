<?php

namespace Keruald\DockerHub\Tests;

use Keruald\DockerHub\DockerHubImage;

class DockerHubImageTest extends \PHPUnit_Framework_TestCase {

    public function testGetRegistryUrl () {
        $image = new DockerHubImage("acme", "foo");
        $this->assertSame(
            "https://registry.hub.docker.com/u/acme/foo",
            $image->getRegistryUrl()
        );
    }

}
