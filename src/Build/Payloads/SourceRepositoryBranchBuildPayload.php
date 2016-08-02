<?php

namespace Keruald\DockerHub\Build\Payloads;

/**
 * Represents a build trigger payload to build a specific repo branch.
 */
class SourceRepositoryBranchBuildPayload extends SourceRepositoryBuildPayload {

    /**
     * Initializes a new instance of the SourceRepositoryBranchBuildPayload class.
     *
     * @param string $branch The name of the repo branch to build
     */
    public function __construct ($branch) {
        parent::__construct(SourceRepositoryType::BRANCH, $branch);
    }

}
