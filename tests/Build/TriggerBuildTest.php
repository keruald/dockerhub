<?php

namespace Keruald\DockerHub\Tests\Build;

use Keruald\DockerHub\DockerHubImage;
use Keruald\DockerHub\Build\TriggerBuild;
use Keruald\DockerHub\Build\Payloads\AllBuildPayload;
use Keruald\DockerHub\Build\Payloads\DockerTagBuildPayload;
use Keruald\DockerHub\Build\Payloads\SourceRepositoryBuildPayload;

use Keruald\DockerHub\Tests\WithMockHttpClient;

use PHPUnit\Framework\TestCase;

class TriggerBuildTest extends TestCase {

    use WithMockHttpClient;

    /**
     * @var Keruald\DockerHub\Build\TriggerBuild
     */
    protected $trigger;

    /**
     * @var Keruald\DockerHub\DockerHubImage
     */
    protected $image;

    public function setUp () : void {
        $this->image = new DockerHubImage("acme", "foo");
        $this->trigger = new TriggerBuild($this->image, "0000");
    }

    public function testGetTriggerUrl () {
        $this->assertSame(
            "https://registry.hub.docker.com/u/acme/foo/trigger/0000/",
            $this->trigger->getTriggerUrl()
        );
    }

    public function testGetPayloadForAll () {
        // {"build": true}
        $payload = $this->trigger->getPayloadForAll();
        $this->assertInstanceOf(AllBuildPayload::class, $payload);
        $this->assertTrue($payload->build);
    }

    public function testGetPayloadForDockerTag () {
        // {"docker_tag": "master"}
        $payload = $this->trigger->getPayloadForDockerTag("master");
        $this->assertInstanceOf(DockerTagBuildPayload::class, $payload);
        $this->assertSame($payload->docker_tag, "master");
    }

    public function testGetPayloadForSourceRepositoryBranch () {
        // {"source_type": "Branch", "source_name": "staging"}
        $payload = $this->trigger->getPayloadForSourceRepositoryBranch("staging");
        $this->assertInstanceOf(SourceRepositoryBuildPayload::class, $payload);
        $this->assertSame($payload->source_type, "Branch");
        $this->assertSame($payload->source_name, "staging");
    }

    public function testGetPayloadForSourceRepositoryTag () {
        // {"source_type": "Tag", "source_name": "v1.1"}
        $payload = $this->trigger->getPayloadForSourceRepositoryTag("v1.1");
        $this->assertInstanceOf(SourceRepositoryBuildPayload::class, $payload);
        $this->assertSame($payload->source_type, "Tag");
        $this->assertSame($payload->source_name, "v1.1");
    }

    ///
    /// Overloads test
    ///

    public function testMethodOverloadingForNonExistingMethod () {
        $this->expectException(\BadMethodCallException::class);
        $this->trigger->loremIpsum();
    }

    public function testMethodOverloadingForNonExistingPayloadMethod () {
        $this->expectException(\BadMethodCallException::class);
        $this->trigger->sendPayloadForLoremIpsum();
    }

    ///
    /// HTTP client tests
    ///

     public function testPostWhenClientIsNull () {
        $this->expectException(\InvalidArgumentException::class);
        $this->trigger->sendPayloadForAll();
     }

     public function testPostThrowsRuntimeExceptionWhenResponseIsNot200 () {
        $this->expectException(\RuntimeException::class);
        $mockClient = $this->mockHttpClient(500);
        $trigger = new TriggerBuild($this->image, "0000", $mockClient);
        $trigger->sendPayloadForAll();
     }

}
