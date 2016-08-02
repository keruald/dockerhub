<?php

namespace Keruald\DockerHub\Tests\Build\Payloads;

use Keruald\DockerHub\Build\Payloads\SourceRepositoryBuildPayload;

class SourceRepositoryBuildPayloadTest extends \PHPUnit_Framework_TestCase {

    public function testIsValidType () {
        $this->assertTrue(SourceRepositoryBuildPayload::isValidType('Tag'));
        $this->assertTrue(SourceRepositoryBuildPayload::isValidType('Branch'));
        $this->assertFalse(SourceRepositoryBuildPayload::isValidType('foo'));
        $this->assertFalse(SourceRepositoryBuildPayload::isValidType(''));
        $this->assertFalse(SourceRepositoryBuildPayload::isValidType(null));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidTypeThrowException () {
        $mock = new NotExistingObjectBuildPayloadMock();
    }

}
