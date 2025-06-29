<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Studio
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Studio\V1\Flow\Engagement\Step;

use Twilio\ListResource;
use Twilio\Version;

class StepContextList extends ListResource
{
    /**
     * Construct the StepContextList
     *
     * @param Version $version Version that contains the resource
     * @param string $flowSid The SID of the Flow with the Step to fetch.
     * @param string $engagementSid The SID of the Engagement with the Step to fetch.
     * @param string $stepSid The SID of the Step to fetch
     */
    public function __construct(
        Version $version,
        string $flowSid,
        string $engagementSid,
        string $stepSid
    ) {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "flowSid" => $flowSid,

            "engagementSid" => $engagementSid,

            "stepSid" => $stepSid,
        ];
    }

    /**
     * Constructs a StepContextContext
     */
    public function getContext(): StepContextContext
    {
        return new StepContextContext(
            $this->version,
            $this->solution["flowSid"],
            $this->solution["engagementSid"],
            $this->solution["stepSid"]
        );
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return "[Twilio.Studio.V1.StepContextList]";
    }
}
