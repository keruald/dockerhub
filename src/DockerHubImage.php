<?php

namespace Keruald\DockerHub;

use Keruald\DockerHub\Build\TriggerBuild;

use GuzzleHttp\ClientInterface;

/**
 * Represents a DockerHub image.
 */
class DockerHubImage extends DockerImage {

    /**
     * Gets the URL to the image on the registry.
     *
     * @return string
     */
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
    public function getTriggerBuild (ClientInterface $client, $token) {
        return new TriggerBuild($this, $token);
    }

    /**
     * Triggers a full build for this image.
     *
     * @param string $token The token to authentify the build request
     */
    public function triggerBuild (ClientInterface $client, $token) {
        $this->getTriggerBuild($client, $token)->sendPayloadForAll();
    }

}
