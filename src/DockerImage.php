<?php

namespace Keruald\DockerHub;

use InvalidArgumentException;

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
    /// Constructors
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

    /**
     * Initializes a new instance of a DockerImage object
     * from the slash notation.
     *
     * @param string $image the full user image name (e.g. "acme/foo")
     * @return DockerImage
     *
     * @throws InvalidArgumentException when image name doesn't contain a slash.
     */
    public static function loadFromSlashNotation ($image) {
        if (strpos($image, '/') === false) {
            throw new InvalidArgumentException("Image name doesn't contain a slash (/).");
        }

        $imageFragments = explode('/', $image, 2);
        return new static(...$imageFragments);
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
