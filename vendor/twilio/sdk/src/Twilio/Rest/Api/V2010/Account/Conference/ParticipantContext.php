<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Api
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Api\V2010\Account\Conference;

use Twilio\Exceptions\TwilioException;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;
use Twilio\Serialize;

class ParticipantContext extends InstanceContext
{
    /**
     * Initialize the ParticipantContext
     *
     * @param Version $version Version that contains the resource
     * @param string $accountSid The SID of the [Account](https://www.twilio.com/docs/iam/api/account) that will create the resource.
     * @param string $conferenceSid The SID of the participant's conference.
     * @param string $callSid The [Call](https://www.twilio.com/docs/voice/api/call-resource) SID or label of the participant to delete. Non URL safe characters in a label must be percent encoded, for example, a space character is represented as %20.
     */
    public function __construct(
        Version $version,
        $accountSid,
        $conferenceSid,
        $callSid
    ) {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "accountSid" => $accountSid,
            "conferenceSid" => $conferenceSid,
            "callSid" => $callSid,
        ];

        $this->uri =
            "/Accounts/" .
            \rawurlencode($accountSid) .
            "/Conferences/" .
            \rawurlencode($conferenceSid) .
            "/Participants/" .
            \rawurlencode($callSid) .
            ".json";
    }

    /**
     * Delete the ParticipantInstance
     *
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(): bool
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
        ]);
        return $this->version->delete("DELETE", $this->uri, [], [], $headers);
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
            $this->solution["accountSid"],
            $this->solution["conferenceSid"],
            $this->solution["callSid"]
        );
    }

    /**
     * Update the ParticipantInstance
     *
     * @param array|Options $options Optional Arguments
     * @return ParticipantInstance Updated ParticipantInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(array $options = []): ParticipantInstance
    {
        $options = new Values($options);

        $data = Values::of([
            "Muted" => Serialize::booleanToString($options["muted"]),
            "Hold" => Serialize::booleanToString($options["hold"]),
            "HoldUrl" => $options["holdUrl"],
            "HoldMethod" => $options["holdMethod"],
            "AnnounceUrl" => $options["announceUrl"],
            "AnnounceMethod" => $options["announceMethod"],
            "WaitUrl" => $options["waitUrl"],
            "WaitMethod" => $options["waitMethod"],
            "BeepOnExit" => Serialize::booleanToString($options["beepOnExit"]),
            "EndConferenceOnExit" => Serialize::booleanToString(
                $options["endConferenceOnExit"]
            ),
            "Coaching" => Serialize::booleanToString($options["coaching"]),
            "CallSidToCoach" => $options["callSidToCoach"],
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

        return new ParticipantInstance(
            $this->version,
            $payload,
            $this->solution["accountSid"],
            $this->solution["conferenceSid"],
            $this->solution["callSid"]
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
        return "[Twilio.Api.V2010.ParticipantContext " .
            \implode(" ", $context) .
            "]";
    }
}
