<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Marketplace
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Marketplace\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string|null $url
 * @property string|null $sid
 * @property array|null $description
 * @property array|null $support
 * @property array|null $policies
 * @property array|null $moduleInfo
 * @property array|null $documentation
 * @property array|null $configuration
 * @property array|null $pricing
 */
class ModuleDataManagementInstance extends InstanceResource
{
    /**
     * Initialize the ModuleDataManagementInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $sid The unique identifier of a Listing.
     */
    public function __construct(
        Version $version,
        array $payload,
        string $sid = null
    ) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            "url" => Values::array_get($payload, "url"),
            "sid" => Values::array_get($payload, "sid"),
            "description" => Values::array_get($payload, "description"),
            "support" => Values::array_get($payload, "support"),
            "policies" => Values::array_get($payload, "policies"),
            "moduleInfo" => Values::array_get($payload, "module_info"),
            "documentation" => Values::array_get($payload, "documentation"),
            "configuration" => Values::array_get($payload, "configuration"),
            "pricing" => Values::array_get($payload, "pricing"),
        ];

        $this->solution = ["sid" => $sid ?: $this->properties["sid"]];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return ModuleDataManagementContext Context for this ModuleDataManagementInstance
     */
    protected function proxy(): ModuleDataManagementContext
    {
        if (!$this->context) {
            $this->context = new ModuleDataManagementContext(
                $this->version,
                $this->solution["sid"]
            );
        }

        return $this->context;
    }

    /**
     * Fetch the ModuleDataManagementInstance
     *
     * @return ModuleDataManagementInstance Fetched ModuleDataManagementInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): ModuleDataManagementInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Update the ModuleDataManagementInstance
     *
     * @param array|Options $options Optional Arguments
     * @return ModuleDataManagementInstance Updated ModuleDataManagementInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(array $options = []): ModuleDataManagementInstance
    {
        return $this->proxy()->update($options);
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
        return "[Twilio.Marketplace.V1.ModuleDataManagementInstance " .
            \implode(" ", $context) .
            "]";
    }
}
