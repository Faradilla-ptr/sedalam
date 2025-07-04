<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Content
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Content\V1\Content;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string|null $sid
 * @property string|null $accountSid
 * @property array|null $whatsapp
 * @property string|null $url
 */
class ApprovalFetchInstance extends InstanceResource
{
    /**
     * Initialize the ApprovalFetchInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $sid The Twilio-provided string that uniquely identifies the Content resource whose approval information to fetch.
     */
    public function __construct(Version $version, array $payload, string $sid)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            "sid" => Values::array_get($payload, "sid"),
            "accountSid" => Values::array_get($payload, "account_sid"),
            "whatsapp" => Values::array_get($payload, "whatsapp"),
            "url" => Values::array_get($payload, "url"),
        ];

        $this->solution = ["sid" => $sid];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return ApprovalFetchContext Context for this ApprovalFetchInstance
     */
    protected function proxy(): ApprovalFetchContext
    {
        if (!$this->context) {
            $this->context = new ApprovalFetchContext(
                $this->version,
                $this->solution["sid"]
            );
        }

        return $this->context;
    }

    /**
     * Fetch the ApprovalFetchInstance
     *
     * @return ApprovalFetchInstance Fetched ApprovalFetchInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): ApprovalFetchInstance
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
        return "[Twilio.Content.V1.ApprovalFetchInstance " .
            \implode(" ", $context) .
            "]";
    }
}
