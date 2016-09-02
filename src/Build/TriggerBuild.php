<?php

namespace Keruald\DockerHub\Build;

use Keruald\DockerHub\DockerHubImage as Image;

use Keruald\DockerHub\Build\Payloads\BuildPayload;
use Keruald\DockerHub\Build\Payloads\AllBuildPayload;
use Keruald\DockerHub\Build\Payloads\DockerTagBuildPayload;
use Keruald\DockerHub\Build\Payloads\SourceRepositoryBranchBuildPayload;
use Keruald\DockerHub\Build\Payloads\SourceRepositoryTagBuildPayload;

use GuzzleHttp\ClientInterface;

use BadMethodCallException;
use InvalidArgumentException;

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

    /**
     * The name of the class implementing PSR-7 message, or such an instance
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    ///
    /// Constructor
    ///

    /**
     * Initializes a new instance of the TriggerBuild class.
     *
     * @param Keruald\DockerHub\DockerHubImage $image The image to build
     * @param string $token The token to authentify the build request
     * @param \GuzzleHttp\ClientInterface|null $client A PSR-7 HTTP client
     */
    public function __construct (Image $image, $token, ClientInterface $client = null) {
        $this->image = $image;
        $this->token = $token;
        $this->client = $client;
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

    ///
    /// Overloads to send payloads
    ///

    /**
     * Method triggered when invoking inaccessible methods in an object context.
     *
     * This allows to mirror getPayloadFor... to sendPayloadFor... methods.
     *
     * @param string $methodName The name of the method called
     * @param array $args The arguments of the method called
     * @return mixed
     *
     * @throws \BadMethodCallException when the method isn't implemented.
     */
    public function __call ($methodName, array $args) {
        if (substr($methodName, 0, 4) === "send") {
            $actionName = substr($methodName, 4);
            return $this->sendPayload($actionName, $args);
        }

        throw new BadMethodCallException;
    }

    /**
     * Sends a payload to Docker Hub to trigger a build.
     *
     * @param string $payloadActionSubjectName The subject part of the name of the method called (e.g. "PayloadForAll")
     * @param array $args The arguments of the method called
     */
    private function sendPayload ($payloadActionSubjectName, array $args) {
        $payload = $this->getPayload($payloadActionSubjectName, $args);
        $url = $this->getTriggerUrl();

        $this->postPayload($payload, $url);

    }

    /**
     * @param \Keruald\DockerHub\Build\Payloads\BuildPayload $payload The payload to post
     * @param string $url
     */
    private function postPayload (BuildPayload $payload, $url) {
        if ($this->client === null) {
            throw new InvalidArgumentException("Client can't be null to post a payload.");
        }

        $this->client->request('POST', $url, [ 'json' => $payload ]);
    }

    /**
     * Gets the payload for the specified overload method.
     *
     * @param string $payloadActionSubjectName The subject part of the name of the method called
     * @param array $args The arguments of the method called
     * @return \Keruald\DockerHub\Build\Payloads\BuildPayload
     */
    private function getPayload ($payloadActionSubjectName, array $args) {
        $methodName = $this->getGetPayloadMethodName($payloadActionSubjectName);
        return $this->$methodName(...$args);
    }

    /**
     * Gets the getPayload… method name.
     *
     * @return string $payloadActionSubjectName The subject part of the name of the method called
     * @throws \BadMethodCallException when the method doesn't exist.
     */
    private function getGetPayloadMethodName ($payloadActionSubjectName) {
        $methodName = "get" . $payloadActionSubjectName;

        if (!method_exists($this, $methodName)) {
            throw new BadMethodCallException;
        }

        return $methodName;
    }

}
