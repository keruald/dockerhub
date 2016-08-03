<?php

namespace Keruald\DockerHub;

use Keruald\DockerHub\Build\TriggerBuild;

/**
 * Represents a DockerHub image.
 */
class DockerHubImage extends DockerImage {

    public function getRegistryUrl () {
        return "https://registry.hub.docker.com/u/$this->user/$this->image";
    }

    /**
     * Gets a trigger build for this image
     * to be able to prepare a build trigger payload.
     *
     * @param string $token The token to authentify the build request
     * @return Keruald\DockerHub\Build\TriggerBuild
     */
    public function getTriggerBuild ($token) {
        return new TriggerBuild($this, $token);
    }

}
