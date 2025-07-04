<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Events
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Events\V1\Sink;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Values;
use Twilio\Version;

class SinkValidateList extends ListResource
{
    /**
     * Construct the SinkValidateList
     *
     * @param Version $version Version that contains the resource
     * @param string $sid A 34 character string that uniquely identifies the Sink being validated.
     */
    public function __construct(Version $version, string $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "sid" => $sid,
        ];

        $this->uri = "/Sinks/" . \rawurlencode($sid) . "/Validate";
    }

    /**
     * Create the SinkValidateInstance
     *
     * @param string $testId A 34 character string that uniquely identifies the test event for a Sink being validated.
     * @return SinkValidateInstance Created SinkValidateInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function create(string $testId): SinkValidateInstance
    {
        $data = Values::of([
            "TestId" => $testId,
        ]);

        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->create(
            "POST",
            $this->uri,
            [],
            $data,
            $headers
        );

        return new SinkValidateInstance(
            $this->version,
            $payload,
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
        return "[Twilio.Events.V1.SinkValidateList]";
    }
}
