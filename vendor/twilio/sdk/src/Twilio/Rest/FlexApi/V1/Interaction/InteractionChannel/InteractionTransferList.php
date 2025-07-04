<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Flex
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\FlexApi\V1\Interaction\InteractionChannel;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Values;
use Twilio\Version;

class InteractionTransferList extends ListResource
{
    /**
     * Construct the InteractionTransferList
     *
     * @param Version $version Version that contains the resource
     * @param string $interactionSid The Interaction Sid for the Interaction
     * @param string $channelSid The Channel Sid for the Channel.
     */
    public function __construct(
        Version $version,
        string $interactionSid,
        string $channelSid
    ) {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "interactionSid" => $interactionSid,

            "channelSid" => $channelSid,
        ];

        $this->uri =
            "/Interactions/" .
            \rawurlencode($interactionSid) .
            "/Channels/" .
            \rawurlencode($channelSid) .
            "/Transfers";
    }

    /**
     * Create the InteractionTransferInstance
     *
     * @return InteractionTransferInstance Created InteractionTransferInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function create(): InteractionTransferInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/json",
            "Accept" => "application/json",
        ]);
        $data = $body->toArray();
        $payload = $this->version->create(
            "POST",
            $this->uri,
            [],
            $data,
            $headers
        );

        return new InteractionTransferInstance(
            $this->version,
            $payload,
            $this->solution["interactionSid"],
            $this->solution["channelSid"]
        );
    }

    /**
     * Constructs a InteractionTransferContext
     *
     * @param string $sid The unique string created by Twilio to identify a Transfer resource.
     */
    public function getContext(string $sid): InteractionTransferContext
    {
        return new InteractionTransferContext(
            $this->version,
            $this->solution["interactionSid"],
            $this->solution["channelSid"],
            $sid
        );
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return "[Twilio.FlexApi.V1.InteractionTransferList]";
    }
}
