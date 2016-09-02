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

    ///
    /// Factory methods to build a TriggerBuild instance or use it.
    ///

    /**
     * Gets a trigger build for this image
     * to be able to prepare a build trigger payload.
     *
     * @param \Guzzle\ClientInterface A HTTP client [optional]
     * @param string $token The token to authentify the build request [optional]
     * @return Keruald\DockerHub\Build\TriggerBuild
     */
    public function getTriggerBuild (ClientInterface $client = null, $token = "") {
        return new TriggerBuild($this, $token, $client);
    }

    /**
     * Triggers a full build for this image.
     *
     * @param \Guzzle\ClientInterface A HTTP client
     * @param string $token The token to authentify the build request
     */
    public function triggerBuild (ClientInterface $client, $token) {
        $this->getTriggerBuild($client, $token)->sendPayloadForAll();
    }

}
