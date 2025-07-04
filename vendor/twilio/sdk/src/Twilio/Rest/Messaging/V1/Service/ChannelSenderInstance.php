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
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use Twilio\Deserialize;

/**
 * @property string|null $accountSid
 * @property string|null $messagingServiceSid
 * @property string|null $sid
 * @property string|null $sender
 * @property string|null $senderType
 * @property string|null $countryCode
 * @property \DateTime|null $dateCreated
 * @property \DateTime|null $dateUpdated
 * @property string|null $url
 */
class ChannelSenderInstance extends InstanceResource
{
    /**
     * Initialize the ChannelSenderInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $messagingServiceSid The SID of the [Service](https://www.twilio.com/docs/chat/rest/service-resource) to create the resource under.
     * @param string $sid The SID of the Channel Sender resource to delete.
     */
    public function __construct(
        Version $version,
        array $payload,
        string $messagingServiceSid,
        string $sid = null
    ) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            "accountSid" => Values::array_get($payload, "account_sid"),
            "messagingServiceSid" => Values::array_get(
                $payload,
                "messaging_service_sid"
            ),
            "sid" => Values::array_get($payload, "sid"),
            "sender" => Values::array_get($payload, "sender"),
            "senderType" => Values::array_get($payload, "sender_type"),
            "countryCode" => Values::array_get($payload, "country_code"),
            "dateCreated" => Deserialize::dateTime(
                Values::array_get($payload, "date_created")
            ),
            "dateUpdated" => Deserialize::dateTime(
                Values::array_get($payload, "date_updated")
            ),
            "url" => Values::array_get($payload, "url"),
        ];

        $this->solution = [
            "messagingServiceSid" => $messagingServiceSid,
            "sid" => $sid ?: $this->properties["sid"],
        ];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return ChannelSenderContext Context for this ChannelSenderInstance
     */
    protected function proxy(): ChannelSenderContext
    {
        if (!$this->context) {
            $this->context = new ChannelSenderContext(
                $this->version,
                $this->solution["messagingServiceSid"],
                $this->solution["sid"]
            );
        }

        return $this->context;
    }

    /**
     * Delete the ChannelSenderInstance
     *
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    /**
     * Fetch the ChannelSenderInstance
     *
     * @return ChannelSenderInstance Fetched ChannelSenderInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): ChannelSenderInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Magic getter to access properties
     *
     * @param string $name Property to access
     * @return mixed The requested property
     * @throws TwilioException For unknown properties
     */
    public function __get(string $name)
    {
        if (\array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        if (\property_exists($this, "_" . $name)) {
            $method = "get" . \ucfirst($name);
            return $this->$method();
        }

        throw new TwilioException("Unknown property: " . $name);
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
        return "[Twilio.Messaging.V1.ChannelSenderInstance " .
            \implode(" ", $context) .
            "]";
    }
}
