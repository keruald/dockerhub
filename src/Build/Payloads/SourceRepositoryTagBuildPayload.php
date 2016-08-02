<?php

namespace Keruald\DockerHub\Build\Payloads;

/**
 * Represents a build trigger payload to build a specific repo tag.
 */
class SourceRepositoryTagBuildPayload extends SourceRepositoryBuildPayload {

    /**
     * Initializes a new instance of the SourceRepositoryTagBuildPayload class.
     *
     * @param string $tag The name of the repo tag to build
     */
    public function __construct ($tag) {
        parent::__construct(SourceRepositoryType::TAG, $tag);
    }

}
