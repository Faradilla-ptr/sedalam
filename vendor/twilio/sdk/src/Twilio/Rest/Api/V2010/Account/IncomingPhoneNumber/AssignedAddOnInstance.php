<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Api
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use Twilio\Deserialize;
use Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber\AssignedAddOn\AssignedAddOnExtensionList;

/**
 * @property string|null $sid
 * @property string|null $accountSid
 * @property string|null $resourceSid
 * @property string|null $friendlyName
 * @property string|null $description
 * @property array|null $configuration
 * @property string|null $uniqueName
 * @property \DateTime|null $dateCreated
 * @property \DateTime|null $dateUpdated
 * @property string|null $uri
 * @property array|null $subresourceUris
 */
class AssignedAddOnInstance extends InstanceResource
{
    protected $_extensions;

    /**
     * Initialize the AssignedAddOnInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $accountSid The SID of the [Account](https://www.twilio.com/docs/iam/api/account) that will create the resource.
     * @param string $resourceSid The SID of the Phone Number to assign the Add-on.
     * @param string $sid The Twilio-provided string that uniquely identifies the resource to delete.
     */
    public function __construct(
        Version $version,
        array $payload,
        string $accountSid,
        string $resourceSid,
        string $sid = null
    ) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            "sid" => Values::array_get($payload, "sid"),
            "accountSid" => Values::array_get($payload, "account_sid"),
            "resourceSid" => Values::array_get($payload, "resource_sid"),
            "friendlyName" => Values::array_get($payload, "friendly_name"),
            "description" => Values::array_get($payload, "description"),
            "configuration" => Values::array_get($payload, "configuration"),
            "uniqueName" => Values::array_get($payload, "unique_name"),
            "dateCreated" => Deserialize::dateTime(
                Values::array_get($payload, "date_created")
            ),
            "dateUpdated" => Deserialize::dateTime(
                Values::array_get($payload, "date_updated")
            ),
            "uri" => Values::array_get($payload, "uri"),
            "subresourceUris" => Values::array_get(
                $payload,
                "subresource_uris"
            ),
        ];

        $this->solution = [
            "accountSid" => $accountSid,
            "resourceSid" => $resourceSid,
            "sid" => $sid ?: $this->properties["sid"],
        ];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return AssignedAddOnContext Context for this AssignedAddOnInstance
     */
    protected function proxy(): AssignedAddOnContext
    {
        if (!$this->context) {
            $this->context = new AssignedAddOnContext(
                $this->version,
                $this->solution["accountSid"],
                $this->solution["resourceSid"],
                $this->solution["sid"]
            );
        }

        return $this->context;
    }

    /**
     * Delete the AssignedAddOnInstance
     *
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    /**
     * Fetch the AssignedAddOnInstance
     *
     * @return AssignedAddOnInstance Fetched AssignedAddOnInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): AssignedAddOnInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Access the extensions
     */
    protected function getExtensions(): AssignedAddOnExtensionList
    {
        return $this->proxy()->extensions;
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
        return "[Twilio.Api.V2010.AssignedAddOnInstance " .
            \implode(" ", $context) .
            "]";
    }
}
