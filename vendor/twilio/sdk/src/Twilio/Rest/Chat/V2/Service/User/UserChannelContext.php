<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Chat
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Chat\V2\Service\User;

use Twilio\Exceptions\TwilioException;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;
use Twilio\Serialize;

class UserChannelContext extends InstanceContext
{
    /**
     * Initialize the UserChannelContext
     *
     * @param Version $version Version that contains the resource
     * @param string $serviceSid The SID of the [Service](https://www.twilio.com/docs/api/chat/rest/services) to read the resources from.
     * @param string $userSid The SID of the [User](https://www.twilio.com/docs/api/chat/rest/users) to read the User Channel resources from.
     * @param string $channelSid The SID of the [Channel](https://www.twilio.com/docs/api/chat/rest/channels) the resource belongs to.
     */
    public function __construct(
        Version $version,
        $serviceSid,
        $userSid,
        $channelSid
    ) {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "serviceSid" => $serviceSid,
            "userSid" => $userSid,
            "channelSid" => $channelSid,
        ];

        $this->uri =
            "/Services/" .
            \rawurlencode($serviceSid) .
            "/Users/" .
            \rawurlencode($userSid) .
            "/Channels/" .
            \rawurlencode($channelSid) .
            "";
    }

    /**
     * Delete the UserChannelInstance
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
     * Fetch the UserChannelInstance
     *
     * @return UserChannelInstance Fetched UserChannelInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): UserChannelInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch("GET", $this->uri, [], [], $headers);

        return new UserChannelInstance(
            $this->version,
            $payload,
            $this->solution["serviceSid"],
            $this->solution["userSid"],
            $this->solution["channelSid"]
        );
    }

    /**
     * Update the UserChannelInstance
     *
     * @param array|Options $options Optional Arguments
     * @return UserChannelInstance Updated UserChannelInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(array $options = []): UserChannelInstance
    {
        $options = new Values($options);

        $data = Values::of([
            "NotificationLevel" => $options["notificationLevel"],
            "LastConsumedMessageIndex" => $options["lastConsumedMessageIndex"],
            "LastConsumptionTimestamp" => Serialize::iso8601DateTime(
                $options["lastConsumptionTimestamp"]
            ),
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

        return new UserChannelInstance(
            $this->version,
            $payload,
            $this->solution["serviceSid"],
            $this->solution["userSid"],
            $this->solution["channelSid"]
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
        return "[Twilio.Chat.V2.UserChannelContext " .
            \implode(" ", $context) .
            "]";
    }
}
