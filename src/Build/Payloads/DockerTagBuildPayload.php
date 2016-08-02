<?php

namespace Keruald\DockerHub\Build\Payloads;

/**
 * Represents a build trigger payload to build a specific Docker tag.
 */
class DockerTagBuildPayload extends BuildPayload {

    /**
     * @var string
     */
    public $docker_tag;

    /**
     * Initializes a new instance of the DockerTagBuildPayload class.
     *
     * @param string $tag The name of the Docker tag to build
     */
    public function __construct ($tag) {
        $this->docker_tag = $tag;
    }

}
