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

namespace Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber\AssignedAddOn;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string|null $sid
 * @property string|null $accountSid
 * @property string|null $resourceSid
 * @property string|null $assignedAddOnSid
 * @property string|null $friendlyName
 * @property string|null $productName
 * @property string|null $uniqueName
 * @property string|null $uri
 * @property bool|null $enabled
 */
class AssignedAddOnExtensionInstance extends InstanceResource
{
    /**
     * Initialize the AssignedAddOnExtensionInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $accountSid The SID of the [Account](https://www.twilio.com/docs/iam/api/account) that created the resource to fetch.
     * @param string $resourceSid The SID of the Phone Number to which the Add-on is assigned.
     * @param string $assignedAddOnSid The SID that uniquely identifies the assigned Add-on installation.
     * @param string $sid The Twilio-provided string that uniquely identifies the resource to fetch.
     */
    public function __construct(
        Version $version,
        array $payload,
        string $accountSid,
        string $resourceSid,
        string $assignedAddOnSid,
        string $sid = null
    ) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            "sid" => Values::array_get($payload, "sid"),
            "accountSid" => Values::array_get($payload, "account_sid"),
            "resourceSid" => Values::array_get($payload, "resource_sid"),
            "assignedAddOnSid" => Values::array_get(
                $payload,
                "assigned_add_on_sid"
            ),
            "friendlyName" => Values::array_get($payload, "friendly_name"),
            "productName" => Values::array_get($payload, "product_name"),
            "uniqueName" => Values::array_get($payload, "unique_name"),
            "uri" => Values::array_get($payload, "uri"),
            "enabled" => Values::array_get($payload, "enabled"),
        ];

        $this->solution = [
            "accountSid" => $accountSid,
            "resourceSid" => $resourceSid,
            "assignedAddOnSid" => $assignedAddOnSid,
            "sid" => $sid ?: $this->properties["sid"],
        ];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return AssignedAddOnExtensionContext Context for this AssignedAddOnExtensionInstance
     */
    protected function proxy(): AssignedAddOnExtensionContext
    {
        if (!$this->context) {
            $this->context = new AssignedAddOnExtensionContext(
                $this->version,
                $this->solution["accountSid"],
                $this->solution["resourceSid"],
                $this->solution["assignedAddOnSid"],
                $this->solution["sid"]
            );
        }

        return $this->context;
    }

    /**
     * Fetch the AssignedAddOnExtensionInstance
     *
     * @return AssignedAddOnExtensionInstance Fetched AssignedAddOnExtensionInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): AssignedAddOnExtensionInstance
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
        return "[Twilio.Api.V2010.AssignedAddOnExtensionInstance " .
            \implode(" ", $context) .
            "]";
    }
}
