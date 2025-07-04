<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Serverless
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Serverless\V1\Service\Build;

use Twilio\ListResource;
use Twilio\Version;

class BuildStatusList extends ListResource
{
    /**
     * Construct the BuildStatusList
     *
     * @param Version $version Version that contains the resource
     * @param string $serviceSid The SID of the Service to fetch the Build resource from.
     * @param string $sid The SID of the Build resource to fetch.
     */
    public function __construct(
        Version $version,
        string $serviceSid,
        string $sid
    ) {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "serviceSid" => $serviceSid,

            "sid" => $sid,
        ];
    }

    /**
     * Constructs a BuildStatusContext
     */
    public function getContext(): BuildStatusContext
    {
        return new BuildStatusContext(
            $this->version,
            $this->solution["serviceSid"],
            $this->solution["sid"]
        );
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return "[Twilio.Serverless.V1.BuildStatusList]";
    }
}
