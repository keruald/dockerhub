<?php

namespace Keruald\DockerHub\Build;

use Keruald\DockerHub\DockerHubImage;

use GuzzleHttp\ClientInterface;

use InvalidArgumentException;

/**
 * Allows to build several TriggerBuild instances
 * with the same HTTP client and a collection of tokens.
 */
class TriggerBuildFactory {

    ///
    /// Private members, to pass to instances
    ///

    /**
     * @var $array
     */
    private $tokens;

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    private $client;

    ///
    /// Constructor
    ///

    /**
     * Initializes a new instance of the TriggerBuildFactory object.
     *
     * @param \GuzzleHttp\ClientInterface $client HTTP client
     * @param array $tokens The tokens for the image
     */
    public function __construct (ClientInterface $client, array $tokens) {
        $this->client = $client;
        $this->tokens = $tokens;
    }

    ///
    /// Builder
    ///

    /**
     * Builds a new TriggerBuild instance for the specified image.
     *
     * @param string $image The image name
     * @return TriggerBuild
     */
    public function getForImage ($image) {
        return new TriggerBuild(
            DockerHubImage::loadFromSlashNotation($image),
            $this->getToken($image),
            $this->client
        );
    }

    /**
     * Sends to registry a payload to trigger a build for the specified image.
     *
     * @param string $image The image name
     */
    public function build ($image) {
        $this->getForImage($image)->sendPayloadForAll();
    }

    /**
     * Determines if we've a token for the specified image.
     *
     * @return bool true if we've a token for this image; otherwise, false.
     */
    public function hasToken ($image) {
        return array_key_exists($image, $this->tokens);
    }

    ///
    /// Helper methods
    ///

    /**
     * Gets the token associated to an image.
     *
     * @return string
     */
    protected function getToken ($image) {
        if ($this->hasToken($image)) {
            return $this->tokens[$image];
        }

        throw new InvalidArgumentException("No token found for image $image.");
    }

}
