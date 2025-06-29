<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Supersim
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Supersim\V1\NetworkAccessProfile;

use Twilio\Exceptions\TwilioException;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;

class NetworkAccessProfileNetworkContext extends InstanceContext
{
    /**
     * Initialize the NetworkAccessProfileNetworkContext
     *
     * @param Version $version Version that contains the resource
     * @param string $networkAccessProfileSid The unique string that identifies the Network Access Profile resource.
     * @param string $sid The SID of the Network resource to be removed from the Network Access Profile resource.
     */
    public function __construct(
        Version $version,
        $networkAccessProfileSid,
        $sid
    ) {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "networkAccessProfileSid" => $networkAccessProfileSid,
            "sid" => $sid,
        ];

        $this->uri =
            "/NetworkAccessProfiles/" .
            \rawurlencode($networkAccessProfileSid) .
            "/Networks/" .
            \rawurlencode($sid) .
            "";
    }

    /**
     * Delete the NetworkAccessProfileNetworkInstance
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
     * Fetch the NetworkAccessProfileNetworkInstance
     *
     * @return NetworkAccessProfileNetworkInstance Fetched NetworkAccessProfileNetworkInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): NetworkAccessProfileNetworkInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch("GET", $this->uri, [], [], $headers);

        return new NetworkAccessProfileNetworkInstance(
            $this->version,
            $payload,
            $this->solution["networkAccessProfileSid"],
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
        return "[Twilio.Supersim.V1.NetworkAccessProfileNetworkContext " .
            \implode(" ", $context) .
            "]";
    }
}
