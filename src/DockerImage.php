<?php

namespace Keruald\DockerHub;

abstract class DockerImage {

    ///
    /// Public properties
    ///

    /**
     * @var string
     */
    public $registry;

    /**
     * @var string
     */
    public $user;

    /**
     * @var string
     */
    public $image;

    ///
    /// Constructor
    ///

    /**
     * Initializes a new instance of a DockerImage object.
     *
     * @param string $user
     * @param string $image
     */
    public function __construct ($user, $image) {
        $this->user = $user;
        $this->image = $image;
    }

    ///
    /// Helper methods
    ///

    /**
     * Gets the URL to the image on the registry.
     *
     * @return string
     */
    public abstract function getRegistryUrl();

}
