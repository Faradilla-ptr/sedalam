<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Video
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Video\V1\Room;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use Twilio\Serialize;

class RecordingRulesList extends ListResource
{
    /**
     * Construct the RecordingRulesList
     *
     * @param Version $version Version that contains the resource
     * @param string $roomSid The SID of the Room resource where the recording rules to fetch apply.
     */
    public function __construct(Version $version, string $roomSid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "roomSid" => $roomSid,
        ];

        $this->uri = "/Rooms/" . \rawurlencode($roomSid) . "/RecordingRules";
    }

    /**
     * Fetch the RecordingRulesInstance
     *
     * @return RecordingRulesInstance Fetched RecordingRulesInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): RecordingRulesInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch("GET", $this->uri, [], [], $headers);

        return new RecordingRulesInstance(
            $this->version,
            $payload,
            $this->solution["roomSid"]
        );
    }

    /**
     * Update the RecordingRulesInstance
     *
     * @param array|Options $options Optional Arguments
     * @return RecordingRulesInstance Updated RecordingRulesInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(array $options = []): RecordingRulesInstance
    {
        $options = new Values($options);

        $data = Values::of([
            "Rules" => Serialize::jsonObject($options["rules"]),
        ]);

        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->update(
            "POST",
            $this->uri,
            [],
            $data,
            $headers
        );

        return new RecordingRulesInstance(
            $this->version,
            $payload,
            $this->solution["roomSid"]
        );
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return "[Twilio.Video.V1.RecordingRulesList]";
    }
}
