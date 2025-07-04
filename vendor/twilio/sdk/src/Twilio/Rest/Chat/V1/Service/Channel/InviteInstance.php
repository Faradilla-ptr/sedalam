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

namespace Twilio\Rest\Chat\V1\Service\Channel;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use Twilio\Deserialize;

/**
 * @property string|null $sid
 * @property string|null $accountSid
 * @property string|null $channelSid
 * @property string|null $serviceSid
 * @property string|null $identity
 * @property \DateTime|null $dateCreated
 * @property \DateTime|null $dateUpdated
 * @property string|null $roleSid
 * @property string|null $createdBy
 * @property string|null $url
 */
class InviteInstance extends InstanceResource
{
    /**
     * Initialize the InviteInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $serviceSid The SID of the [Service](https://www.twilio.com/docs/api/chat/rest/services) to create the resource under.
     * @param string $channelSid The SID of the [Channel](https://www.twilio.com/docs/api/chat/rest/channels) the new resource belongs to.
     * @param string $sid The Twilio-provided string that uniquely identifies the Invite resource to delete.
     */
    public function __construct(
        Version $version,
        array $payload,
        string $serviceSid,
        string $channelSid,
        string $sid = null
    ) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            "sid" => Values::array_get($payload, "sid"),
            "accountSid" => Values::array_get($payload, "account_sid"),
            "channelSid" => Values::array_get($payload, "channel_sid"),
            "serviceSid" => Values::array_get($payload, "service_sid"),
            "identity" => Values::array_get($payload, "identity"),
            "dateCreated" => Deserialize::dateTime(
                Values::array_get($payload, "date_created")
            ),
            "dateUpdated" => Deserialize::dateTime(
                Values::array_get($payload, "date_updated")
            ),
            "roleSid" => Values::array_get($payload, "role_sid"),
            "createdBy" => Values::array_get($payload, "created_by"),
            "url" => Values::array_get($payload, "url"),
        ];

        $this->solution = [
            "serviceSid" => $serviceSid,
            "channelSid" => $channelSid,
            "sid" => $sid ?: $this->properties["sid"],
        ];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return InviteContext Context for this InviteInstance
     */
    protected function proxy(): InviteContext
    {
        if (!$this->context) {
            $this->context = new InviteContext(
                $this->version,
                $this->solution["serviceSid"],
                $this->solution["channelSid"],
                $this->solution["sid"]
            );
        }

        return $this->context;
    }

    /**
     * Delete the InviteInstance
     *
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    /**
     * Fetch the InviteInstance
     *
     * @return InviteInstance Fetched InviteInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): InviteInstance
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
        return "[Twilio.Chat.V1.InviteInstance " .
            \implode(" ", $context) .
            "]";
    }
}
