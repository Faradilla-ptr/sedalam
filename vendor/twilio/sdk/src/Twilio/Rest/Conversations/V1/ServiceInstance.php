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

namespace Twilio\Rest\Conversations\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use Twilio\Deserialize;
use Twilio\Rest\Conversations\V1\Service\ParticipantConversationList;
use Twilio\Rest\Conversations\V1\Service\UserList;
use Twilio\Rest\Conversations\V1\Service\BindingList;
use Twilio\Rest\Conversations\V1\Service\ConversationWithParticipantsList;
use Twilio\Rest\Conversations\V1\Service\ConversationList;
use Twilio\Rest\Conversations\V1\Service\RoleList;
use Twilio\Rest\Conversations\V1\Service\ConfigurationList;

/**
 * @property string|null $accountSid
 * @property string|null $sid
 * @property string|null $friendlyName
 * @property \DateTime|null $dateCreated
 * @property \DateTime|null $dateUpdated
 * @property string|null $url
 * @property array|null $links
 */
class ServiceInstance extends InstanceResource
{
    protected $_participantConversations;
    protected $_users;
    protected $_bindings;
    protected $_conversationWithParticipants;
    protected $_conversations;
    protected $_roles;
    protected $_configuration;

    /**
     * Initialize the ServiceInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $sid A 34 character string that uniquely identifies this resource.
     */
    public function __construct(
        Version $version,
        array $payload,
        string $sid = null
    ) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            "accountSid" => Values::array_get($payload, "account_sid"),
            "sid" => Values::array_get($payload, "sid"),
            "friendlyName" => Values::array_get($payload, "friendly_name"),
            "dateCreated" => Deserialize::dateTime(
                Values::array_get($payload, "date_created")
            ),
            "dateUpdated" => Deserialize::dateTime(
                Values::array_get($payload, "date_updated")
            ),
            "url" => Values::array_get($payload, "url"),
            "links" => Values::array_get($payload, "links"),
        ];

        $this->solution = ["sid" => $sid ?: $this->properties["sid"]];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return ServiceContext Context for this ServiceInstance
     */
    protected function proxy(): ServiceContext
    {
        if (!$this->context) {
            $this->context = new ServiceContext(
                $this->version,
                $this->solution["sid"]
            );
        }

        return $this->context;
    }

    /**
     * Delete the ServiceInstance
     *
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    /**
     * Fetch the ServiceInstance
     *
     * @return ServiceInstance Fetched ServiceInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): ServiceInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Access the participantConversations
     */
    protected function getParticipantConversations(): ParticipantConversationList
    {
        return $this->proxy()->participantConversations;
    }

    /**
     * Access the users
     */
    protected function getUsers(): UserList
    {
        return $this->proxy()->users;
    }

    /**
     * Access the bindings
     */
    protected function getBindings(): BindingList
    {
        return $this->proxy()->bindings;
    }

    /**
     * Access the conversationWithParticipants
     */
    protected function getConversationWithParticipants(): ConversationWithParticipantsList
    {
        return $this->proxy()->conversationWithParticipants;
    }

    /**
     * Access the conversations
     */
    protected function getConversations(): ConversationList
    {
        return $this->proxy()->conversations;
    }

    /**
     * Access the roles
     */
    protected function getRoles(): RoleList
    {
        return $this->proxy()->roles;
    }

    /**
     * Access the configuration
     */
    protected function getConfiguration(): ConfigurationList
    {
        return $this->proxy()->configuration;
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
        return "[Twilio.Conversations.V1.ServiceInstance " .
            \implode(" ", $context) .
            "]";
    }
}
