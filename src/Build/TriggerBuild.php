<?php

namespace Keruald\DockerHub\Build;

use Keruald\DockerHub\DockerHubImage as Image;

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

}
