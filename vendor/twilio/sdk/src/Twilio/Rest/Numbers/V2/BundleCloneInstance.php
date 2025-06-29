<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Numbers
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Numbers\V2;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use Twilio\Deserialize;

/**
 * @property string|null $bundleSid
 * @property string|null $accountSid
 * @property string|null $regulationSid
 * @property string|null $friendlyName
 * @property string $status
 * @property \DateTime|null $validUntil
 * @property string|null $email
 * @property string|null $statusCallback
 * @property \DateTime|null $dateCreated
 * @property \DateTime|null $dateUpdated
 * @property string|null $url
 */
class BundleCloneInstance extends InstanceResource
{
    /**
     * Initialize the BundleCloneInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $bundleSid The unique string that identifies the Bundle to be cloned.
     */
    public function __construct(
        Version $version,
        array $payload,
        string $bundleSid = null
    ) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            "bundleSid" => Values::array_get($payload, "bundle_sid"),
            "accountSid" => Values::array_get($payload, "account_sid"),
            "regulationSid" => Values::array_get($payload, "regulation_sid"),
            "friendlyName" => Values::array_get($payload, "friendly_name"),
            "status" => Values::array_get($payload, "status"),
            "validUntil" => Deserialize::dateTime(
                Values::array_get($payload, "valid_until")
            ),
            "email" => Values::array_get($payload, "email"),
            "statusCallback" => Values::array_get($payload, "status_callback"),
            "dateCreated" => Deserialize::dateTime(
                Values::array_get($payload, "date_created")
            ),
            "dateUpdated" => Deserialize::dateTime(
                Values::array_get($payload, "date_updated")
            ),
            "url" => Values::array_get($payload, "url"),
        ];

        $this->solution = [
            "bundleSid" => $bundleSid ?: $this->properties["bundleSid"],
        ];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return BundleCloneContext Context for this BundleCloneInstance
     */
    protected function proxy(): BundleCloneContext
    {
        if (!$this->context) {
            $this->context = new BundleCloneContext(
                $this->version,
                $this->solution["bundleSid"]
            );
        }

        return $this->context;
    }

    /**
     * Create the BundleCloneInstance
     *
     * @param string $targetAccountSid The SID of the [Account](https://www.twilio.com/docs/iam/api/account) where the bundle needs to be cloned.
     * @param array|Options $options Optional Arguments
     * @return BundleCloneInstance Created BundleCloneInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function create(
        string $targetAccountSid,
        array $options = []
    ): BundleCloneInstance {
        return $this->proxy()->create($targetAccountSid, $options);
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
        return "[Twilio.Numbers.V2.BundleCloneInstance " .
            \implode(" ", $context) .
            "]";
    }
}
