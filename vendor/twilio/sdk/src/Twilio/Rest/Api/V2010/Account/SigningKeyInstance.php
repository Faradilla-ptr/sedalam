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

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use Twilio\Deserialize;

/**
 * @property string|null $sid
 * @property string|null $friendlyName
 * @property \DateTime|null $dateCreated
 * @property \DateTime|null $dateUpdated
 */
class SigningKeyInstance extends InstanceResource
{
    /**
     * Initialize the SigningKeyInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $accountSid
     * @param string $sid
     */
    public function __construct(
        Version $version,
        array $payload,
        string $accountSid,
        string $sid = null
    ) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            "sid" => Values::array_get($payload, "sid"),
            "friendlyName" => Values::array_get($payload, "friendly_name"),
            "dateCreated" => Deserialize::dateTime(
                Values::array_get($payload, "date_created")
            ),
            "dateUpdated" => Deserialize::dateTime(
                Values::array_get($payload, "date_updated")
            ),
        ];

        $this->solution = [
            "accountSid" => $accountSid,
            "sid" => $sid ?: $this->properties["sid"],
        ];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return SigningKeyContext Context for this SigningKeyInstance
     */
    protected function proxy(): SigningKeyContext
    {
        if (!$this->context) {
            $this->context = new SigningKeyContext(
                $this->version,
                $this->solution["accountSid"],
                $this->solution["sid"]
            );
        }

        return $this->context;
    }

    /**
     * Delete the SigningKeyInstance
     *
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    /**
     * Fetch the SigningKeyInstance
     *
     * @return SigningKeyInstance Fetched SigningKeyInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): SigningKeyInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Update the SigningKeyInstance
     *
     * @param array|Options $options Optional Arguments
     * @return SigningKeyInstance Updated SigningKeyInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(array $options = []): SigningKeyInstance
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
        return "[Twilio.Api.V2010.SigningKeyInstance " .
            \implode(" ", $context) .
            "]";
    }
}
