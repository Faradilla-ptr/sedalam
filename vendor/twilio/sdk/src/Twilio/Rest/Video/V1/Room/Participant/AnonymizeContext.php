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

namespace Twilio\Rest\Video\V1\Room\Participant;

use Twilio\Exceptions\TwilioException;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;

class AnonymizeContext extends InstanceContext
{
    /**
     * Initialize the AnonymizeContext
     *
     * @param Version $version Version that contains the resource
     * @param string $roomSid The SID of the room with the participant to update.
     * @param string $sid The SID of the RoomParticipant resource to update.
     */
    public function __construct(Version $version, $roomSid, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "roomSid" => $roomSid,
            "sid" => $sid,
        ];

        $this->uri =
            "/Rooms/" .
            \rawurlencode($roomSid) .
            "/Participants/" .
            \rawurlencode($sid) .
            "/Anonymize";
    }

    /**
     * Update the AnonymizeInstance
     *
     * @return AnonymizeInstance Updated AnonymizeInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(): AnonymizeInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->update("POST", $this->uri, [], [], $headers);

        return new AnonymizeInstance(
            $this->version,
            $payload,
            $this->solution["roomSid"],
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
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return "[Twilio.Video.V1.AnonymizeContext " .
            \implode(" ", $context) .
            "]";
    }
}
