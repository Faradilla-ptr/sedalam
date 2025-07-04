<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Messaging
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Messaging\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;

class DomainConfigMessagingServiceContext extends InstanceContext
{
    /**
     * Initialize the DomainConfigMessagingServiceContext
     *
     * @param Version $version Version that contains the resource
     * @param string $messagingServiceSid Unique string used to identify the Messaging service that this domain should be associated with.
     */
    public function __construct(Version $version, $messagingServiceSid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "messagingServiceSid" => $messagingServiceSid,
        ];

        $this->uri =
            "/LinkShortening/MessagingService/" .
            \rawurlencode($messagingServiceSid) .
            "/DomainConfig";
    }

    /**
     * Fetch the DomainConfigMessagingServiceInstance
     *
     * @return DomainConfigMessagingServiceInstance Fetched DomainConfigMessagingServiceInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): DomainConfigMessagingServiceInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch("GET", $this->uri, [], [], $headers);

        return new DomainConfigMessagingServiceInstance(
            $this->version,
            $payload,
            $this->solution["messagingServiceSid"]
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
        return "[Twilio.Messaging.V1.DomainConfigMessagingServiceContext " .
            \implode(" ", $context) .
            "]";
    }
}
