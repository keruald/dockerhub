<?php

namespace Keruald\DockerHub\Build;

use Keruald\DockerHub\DockerHubImage as Image;

use Keruald\DockerHub\Build\Payloads\AllBuildPayload;
use Keruald\DockerHub\Build\Payloads\DockerTagBuildPayload;
use Keruald\DockerHub\Build\Payloads\SourceRepositoryBranchBuildPayload;
use Keruald\DockerHub\Build\Payloads\SourceRepositoryTagBuildPayload;

/**
 * Represents a trigger for a new build on the Docker Hub registry.
 */
class TriggerBuild {

    ///
    /// Private members
    ///

    /**
     * The image to build
     *
     * @var Keruald\DockerHub\DockerHubImage
     */
    protected $image;

    /**
     * Trigger token used to authentify requests
     *
     * @var string
     */
    protected $token;

    ///
    /// Constructor
    ///

    /**
     * Initializes a new instance of the TriggerBuild class.
     *
     * @param Keruald\DockerHub\DockerHubImage $image The image to build
     * @param string $token The token to authentify the build request
     */
    public function __construct (Image $image, $token) {
        $this->image = $image;
        $this->token = $token;
    }

    ///
    /// Helper methods
    ///

    /**
     * Gets build trigger URL.
     *
     * @return string
     */
    public function getTriggerUrl () {
        return $this->image->getRegistryUrl()
            . '/trigger/' . $this->token . '/';
    }

    ///
    /// Payloads to specify what to build
    ///

    /**
     * Gets a payload to build all branch/tag.
     *
     * @return Keruald\DockerHub\Build\Payloads\AllBuildPayload
     */
    public function getPayloadForAll () {
        return new AllBuildPayload;
    }

    /**
     * Gets a payload to build the specified Docker tag.
     *
     * @param string $tag
     * @return Keruald\DockerHub\Build\Payloads\DockerTagBuildPayload
     */
    public function getPayloadForDockerTag ($tag) {
        return new DockerTagBuildPayload($tag);
    }

    /**
     * Gets a payload to build the specified repository branch.
     *
     * @param string $branch
     * @return Keruald\DockerHub\Build\Payloads\SourceRepositoryBranchBuildPayload
     */
    public function getPayloadForSourceRepositoryBranch ($branch) {
        return new SourceRepositoryBranchBuildPayload($branch);
    }

    /**
     * Gets a payload to build the specified repository tag.
     *
     * @param string $tag
     * @return Keruald\DockerHub\Build\Payloads\SourceRepositoryTagBuildPayload
     */
    public function getPayloadForSourceRepositoryTag ($tag) {
        return new SourceRepositoryTagBuildPayload($tag);
    }

}
