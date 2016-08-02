<?php

namespace Keruald\DockerHub\Tests\Build;

use Keruald\DockerHub\DockerHubImage;
use Keruald\DockerHub\Build\TriggerBuild;

class TriggerBuildTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Keruald\DockerHub\Build\TriggerBuild
     */
    protected $trigger;

    public function setUp () {
        $image = new DockerHubImage("acme", "foo");
        $this->trigger = new TriggerBuild($image, "0000");
    }

    public function testGetTriggerUrl () {
        $this->assertSame(
            "https://registry.hub.docker.com/u/acme/foo/trigger/0000/",
            $this->trigger->getTriggerUrl()
        );
    }

}
