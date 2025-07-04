<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Studio
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Studio\V2\Flow\Execution;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string|null $accountSid
 * @property array|null $context
 * @property string|null $flowSid
 * @property string|null $executionSid
 * @property string|null $url
 */
class ExecutionContextInstance extends InstanceResource
{
    /**
     * Initialize the ExecutionContextInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $flowSid The SID of the Flow with the Execution context to fetch.
     * @param string $executionSid The SID of the Execution context to fetch.
     */
    public function __construct(
        Version $version,
        array $payload,
        string $flowSid,
        string $executionSid
    ) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            "accountSid" => Values::array_get($payload, "account_sid"),
            "context" => Values::array_get($payload, "context"),
            "flowSid" => Values::array_get($payload, "flow_sid"),
            "executionSid" => Values::array_get($payload, "execution_sid"),
            "url" => Values::array_get($payload, "url"),
        ];

        $this->solution = [
            "flowSid" => $flowSid,
            "executionSid" => $executionSid,
        ];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return ExecutionContextContext Context for this ExecutionContextInstance
     */
    protected function proxy(): ExecutionContextContext
    {
        if (!$this->context) {
            $this->context = new ExecutionContextContext(
                $this->version,
                $this->solution["flowSid"],
                $this->solution["executionSid"]
            );
        }

        return $this->context;
    }

    /**
     * Fetch the ExecutionContextInstance
     *
     * @return ExecutionContextInstance Fetched ExecutionContextInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): ExecutionContextInstance
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
        return "[Twilio.Studio.V2.ExecutionContextInstance " .
            \implode(" ", $context) .
            "]";
    }
}
