<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Marketplace
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Marketplace\V1\AvailableAddOn;

use Twilio\Exceptions\TwilioException;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;

class AvailableAddOnExtensionContext extends InstanceContext
{
    /**
     * Initialize the AvailableAddOnExtensionContext
     *
     * @param Version $version Version that contains the resource
     * @param string $availableAddOnSid The SID of the AvailableAddOn resource with the extension to fetch.
     * @param string $sid The SID of the AvailableAddOn Extension resource to fetch.
     */
    public function __construct(Version $version, $availableAddOnSid, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "availableAddOnSid" => $availableAddOnSid,
            "sid" => $sid,
        ];

        $this->uri =
            "/AvailableAddOns/" .
            \rawurlencode($availableAddOnSid) .
            "/Extensions/" .
            \rawurlencode($sid) .
            "";
    }

    /**
     * Fetch the AvailableAddOnExtensionInstance
     *
     * @return AvailableAddOnExtensionInstance Fetched AvailableAddOnExtensionInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): AvailableAddOnExtensionInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch("GET", $this->uri, [], [], $headers);

        return new AvailableAddOnExtensionInstance(
            $this->version,
            $payload,
            $this->solution["availableAddOnSid"],
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
        return "[Twilio.Marketplace.V1.AvailableAddOnExtensionContext " .
            \implode(" ", $context) .
            "]";
    }
}
