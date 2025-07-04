<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Conversations
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Conversations\V1\Service\Conversation;

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
     * @param string $chatServiceSid The SID of the [Conversation Service](https://www.twilio.com/docs/conversations/api/service-resource) the Participant resource is associated with.
     * @param string $conversationSid The unique ID of the [Conversation](https://www.twilio.com/docs/conversations/api/conversation-resource) for this participant.
     * @param string $sid A 34 character string that uniquely identifies this resource.
     */
    public function __construct(
        Version $version,
        $chatServiceSid,
        $conversationSid,
        $sid
    ) {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "chatServiceSid" => $chatServiceSid,
            "conversationSid" => $conversationSid,
            "sid" => $sid,
        ];

        $this->uri =
            "/Services/" .
            \rawurlencode($chatServiceSid) .
            "/Conversations/" .
            \rawurlencode($conversationSid) .
            "/Participants/" .
            \rawurlencode($sid) .
            "";
    }

    /**
     * Delete the ParticipantInstance
     *
     * @param array|Options $options Optional Arguments
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(array $options = []): bool
    {
        $options = new Values($options);

        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "X-Twilio-Webhook-Enabled" => $options["xTwilioWebhookEnabled"],
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
            $this->solution["chatServiceSid"],
            $this->solution["conversationSid"],
            $this->solution["sid"]
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
            "DateCreated" => Serialize::iso8601DateTime(
                $options["dateCreated"]
            ),
            "DateUpdated" => Serialize::iso8601DateTime(
                $options["dateUpdated"]
            ),
            "Identity" => $options["identity"],
            "Attributes" => $options["attributes"],
            "RoleSid" => $options["roleSid"],
            "MessagingBinding.ProxyAddress" =>
                $options["messagingBindingProxyAddress"],
            "MessagingBinding.ProjectedAddress" =>
                $options["messagingBindingProjectedAddress"],
            "LastReadMessageIndex" => $options["lastReadMessageIndex"],
            "LastReadTimestamp" => $options["lastReadTimestamp"],
        ]);

        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
            "X-Twilio-Webhook-Enabled" => $options["xTwilioWebhookEnabled"],
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
            $this->solution["chatServiceSid"],
            $this->solution["conversationSid"],
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
        return "[Twilio.Conversations.V1.ParticipantContext " .
            \implode(" ", $context) .
            "]";
    }
}
