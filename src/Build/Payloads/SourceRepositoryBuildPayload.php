<?php

namespace Keruald\DockerHub\Build\Payloads;

/**
 * Represents a build trigger payload to build a specific tag or branch
 * from the source repository.
 */
abstract class SourceRepositoryBuildPayload extends BuildPayload {

    /**
     * @var string
     */
    public $source_type;

    /**
     * @var string
     */
    public $source_name;

    /**
     * Initializes a new instance of the SourceRepositoryBuildPayload class.
     *
     * @param string $type "Tag" or "Branch"
     * @param string $name The name of the tag or branch in the repository
     */
    public function __construct ($type, $name) {
        if (!self::isValidType($type)) {
            throw new \InvalidArgumentException("Unexpected type: $type.");
        }

        $this->source_type = $type;
        $this->source_name = $name;
    }

    ///
    /// Helper methods
    ///

    /**
     * Determines if type is "Tag" or "Branch".
     *
     * @param string $type
     * @return bool
     */
    public static function isValidType ($type) {
        return $type === SourceRepositoryType::TAG
            || $type === SourceRepositoryType::BRANCH;
    }

}
