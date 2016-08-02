<?php

namespace Keruald\DockerHub;

/**
 * Represents a DockerHub image.
 */
class DockerHubImage extends DockerImage {

    public function getRegistryUrl () {
        return "https://registry.hub.docker.com/u/$this->user/$this->image";
    }

}
