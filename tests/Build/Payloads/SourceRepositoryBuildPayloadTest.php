<?php

namespace Keruald\DockerHub\Tests\Build\Payloads;

use Keruald\DockerHub\Build\Payloads\SourceRepositoryBuildPayload;

use PHPUnit\Framework\TestCase;

class SourceRepositoryBuildPayloadTest extends TestCase {

    public function testIsValidType () {
        $this->assertTrue(SourceRepositoryBuildPayload::isValidType('Tag'));
        $this->assertTrue(SourceRepositoryBuildPayload::isValidType('Branch'));
        $this->assertFalse(SourceRepositoryBuildPayload::isValidType('foo'));
        $this->assertFalse(SourceRepositoryBuildPayload::isValidType(''));
        $this->assertFalse(SourceRepositoryBuildPayload::isValidType(null));
    }

    public function testInvalidTypeThrowException () {
        $this->expectException(\InvalidArgumentException::class);
        $mock = new NotExistingObjectBuildPayloadMock();
    }

}
