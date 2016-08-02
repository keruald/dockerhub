<?php

namespace Keruald\DockerHub\Build\Payloads;

/**
 * Represents a build trigger payload to build all branches/tags.
 */
class AllBuildPayload extends BuildPayload {

    /**
     * @var bool
     */
    public $build = true;

}
