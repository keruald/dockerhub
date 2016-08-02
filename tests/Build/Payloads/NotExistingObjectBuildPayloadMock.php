<?php

namespace Keruald\DockerHub\Tests\Build\Payloads;

use Keruald\DockerHub\Build\Payloads\SourceRepositoryBuildPayload;

/**
 * Concrete implementation for abstract class SourceRepositoryBuildPayload.
 *
 * This implementation should raise an exception, as the parent constructor
 * wants a known type as first source type argument and 'notexisting' is not.
 */
class NotExistingObjectBuildPayloadMock extends SourceRepositoryBuildPayload {
    public function __construct () {
        parent::__construct('notexisting', 'acme');
    }
}
