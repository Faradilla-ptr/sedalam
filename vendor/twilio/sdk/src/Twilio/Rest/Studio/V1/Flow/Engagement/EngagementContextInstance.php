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

namespace Twilio\Rest\Studio\V1\Flow\Engagement;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string|null $accountSid
 * @property array|null $context
 * @property string|null $engagementSid
 * @property string|null $flowSid
 * @property string|null $url
 */
class EngagementContextInstance extends InstanceResource
{
    /**
     * Initialize the EngagementContextInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $flowSid The SID of the Flow.
     * @param string $engagementSid The SID of the Engagement.
     */
    public function __construct(
        Version $version,
        array $payload,
        string $flowSid,
        string $engagementSid
    ) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            "accountSid" => Values::array_get($payload, "account_sid"),
            "context" => Values::array_get($payload, "context"),
            "engagementSid" => Values::array_get($payload, "engagement_sid"),
            "flowSid" => Values::array_get($payload, "flow_sid"),
            "url" => Values::array_get($payload, "url"),
        ];

        $this->solution = [
            "flowSid" => $flowSid,
            "engagementSid" => $engagementSid,
        ];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return EngagementContextContext Context for this EngagementContextInstance
     */
    protected function proxy(): EngagementContextContext
    {
        if (!$this->context) {
            $this->context = new EngagementContextContext(
                $this->version,
                $this->solution["flowSid"],
                $this->solution["engagementSid"]
            );
        }

        return $this->context;
    }

    /**
     * Fetch the EngagementContextInstance
     *
     * @return EngagementContextInstance Fetched EngagementContextInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): EngagementContextInstance
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
        return "[Twilio.Studio.V1.EngagementContextInstance " .
            \implode(" ", $context) .
            "]";
    }
}
