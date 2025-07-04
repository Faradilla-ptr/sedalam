<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Intelligence
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Intelligence\V2;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string|null $serviceSid
 * @property string|null $operatorSid
 * @property string|null $url
 */
class OperatorAttachmentInstance extends InstanceResource
{
    /**
     * Initialize the OperatorAttachmentInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $serviceSid The unique SID identifier of the Service.
     * @param string $operatorSid The unique SID identifier of the Operator. Allows both Custom and Pre-built Operators.
     */
    public function __construct(
        Version $version,
        array $payload,
        string $serviceSid = null,
        string $operatorSid = null
    ) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            "serviceSid" => Values::array_get($payload, "service_sid"),
            "operatorSid" => Values::array_get($payload, "operator_sid"),
            "url" => Values::array_get($payload, "url"),
        ];

        $this->solution = [
            "serviceSid" => $serviceSid ?: $this->properties["serviceSid"],
            "operatorSid" => $operatorSid ?: $this->properties["operatorSid"],
        ];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return OperatorAttachmentContext Context for this OperatorAttachmentInstance
     */
    protected function proxy(): OperatorAttachmentContext
    {
        if (!$this->context) {
            $this->context = new OperatorAttachmentContext(
                $this->version,
                $this->solution["serviceSid"],
                $this->solution["operatorSid"]
            );
        }

        return $this->context;
    }

    /**
     * Create the OperatorAttachmentInstance
     *
     * @return OperatorAttachmentInstance Created OperatorAttachmentInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function create(): OperatorAttachmentInstance
    {
        return $this->proxy()->create();
    }

    /**
     * Delete the OperatorAttachmentInstance
     *
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(): bool
    {
        return $this->proxy()->delete();
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
        return "[Twilio.Intelligence.V2.OperatorAttachmentInstance " .
            \implode(" ", $context) .
            "]";
    }
}
