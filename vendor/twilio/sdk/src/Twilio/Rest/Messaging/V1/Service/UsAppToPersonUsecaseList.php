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

namespace Twilio\Rest\Messaging\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

class UsAppToPersonUsecaseList extends ListResource
{
    /**
     * Construct the UsAppToPersonUsecaseList
     *
     * @param Version $version Version that contains the resource
     * @param string $messagingServiceSid The SID of the [Messaging Service](https://www.twilio.com/docs/messaging/api/service-resource) to fetch the resource from.
     */
    public function __construct(Version $version, string $messagingServiceSid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "messagingServiceSid" => $messagingServiceSid,
        ];

        $this->uri =
            "/Services/" .
            \rawurlencode($messagingServiceSid) .
            "/Compliance/Usa2p/Usecases";
    }

    /**
     * Fetch the UsAppToPersonUsecaseInstance
     *
     * @param array|Options $options Optional Arguments
     * @return UsAppToPersonUsecaseInstance Fetched UsAppToPersonUsecaseInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(array $options = []): UsAppToPersonUsecaseInstance
    {
        $options = new Values($options);

        $params = Values::of([
            "BrandRegistrationSid" => $options["brandRegistrationSid"],
        ]);

        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch(
            "GET",
            $this->uri,
            $params,
            [],
            $headers
        );

        return new UsAppToPersonUsecaseInstance(
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
        return "[Twilio.Messaging.V1.UsAppToPersonUsecaseList]";
    }
}
