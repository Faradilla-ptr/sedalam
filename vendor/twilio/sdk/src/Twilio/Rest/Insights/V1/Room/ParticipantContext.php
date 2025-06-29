<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Insights
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Insights\V1\Room;

use Twilio\Exceptions\TwilioException;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;

class ParticipantContext extends InstanceContext
{
    /**
     * Initialize the ParticipantContext
     *
     * @param Version $version Version that contains the resource
     * @param string $roomSid The SID of the Room resource.
     * @param string $participantSid The SID of the Participant resource.
     */
    public function __construct(Version $version, $roomSid, $participantSid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "roomSid" => $roomSid,
            "participantSid" => $participantSid,
        ];

        $this->uri =
            "/Video/Rooms/" .
            \rawurlencode($roomSid) .
            "/Participants/" .
            \rawurlencode($participantSid) .
            "";
    }

    /**
     * Fetch the ParticipantInstance
     *
     * @return ParticipantInstance Fetched ParticipantInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): ParticipantInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch("GET", $this->uri, [], [], $headers);

        return new ParticipantInstance(
            $this->version,
            $payload,
            $this->solution["roomSid"],
            $this->solution["participantSid"]
        );
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return "[Twilio.Insights.V1.ParticipantContext " .
            \implode(" ", $context) .
            "]";
    }
}
