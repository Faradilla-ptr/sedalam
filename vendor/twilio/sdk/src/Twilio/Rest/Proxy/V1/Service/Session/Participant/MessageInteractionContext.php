<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Proxy
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Proxy\V1\Service\Session\Participant;

use Twilio\Exceptions\TwilioException;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;

class MessageInteractionContext extends InstanceContext
{
    /**
     * Initialize the MessageInteractionContext
     *
     * @param Version $version Version that contains the resource
     * @param string $serviceSid The SID of the parent [Service](https://www.twilio.com/docs/proxy/api/service) resource.
     * @param string $sessionSid The SID of the parent [Session](https://www.twilio.com/docs/proxy/api/session) resource.
     * @param string $participantSid The SID of the [Participant](https://www.twilio.com/docs/proxy/api/participant) resource.
     * @param string $sid The Twilio-provided string that uniquely identifies the MessageInteraction resource to fetch.
     */
    public function __construct(
        Version $version,
        $serviceSid,
        $sessionSid,
        $participantSid,
        $sid
    ) {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "serviceSid" => $serviceSid,
            "sessionSid" => $sessionSid,
            "participantSid" => $participantSid,
            "sid" => $sid,
        ];

        $this->uri =
            "/Services/" .
            \rawurlencode($serviceSid) .
            "/Sessions/" .
            \rawurlencode($sessionSid) .
            "/Participants/" .
            \rawurlencode($participantSid) .
            "/MessageInteractions/" .
            \rawurlencode($sid) .
            "";
    }

    /**
     * Fetch the MessageInteractionInstance
     *
     * @return MessageInteractionInstance Fetched MessageInteractionInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): MessageInteractionInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch("GET", $this->uri, [], [], $headers);

        return new MessageInteractionInstance(
            $this->version,
            $payload,
            $this->solution["serviceSid"],
            $this->solution["sessionSid"],
            $this->solution["participantSid"],
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
        return "[Twilio.Proxy.V1.MessageInteractionContext " .
            \implode(" ", $context) .
            "]";
    }
}
