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

namespace Twilio\Rest\Numbers\V2\RegulatoryCompliance\Bundle;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use Twilio\Deserialize;

/**
 * @property string|null $sid
 * @property string|null $accountSid
 * @property string|null $regulationSid
 * @property string|null $friendlyName
 * @property string $status
 * @property \DateTime|null $validUntil
 * @property string|null $email
 * @property string|null $statusCallback
 * @property \DateTime|null $dateCreated
 * @property \DateTime|null $dateUpdated
 */
class BundleCopyInstance extends InstanceResource
{
    /**
     * Initialize the BundleCopyInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $bundleSid The unique string that identifies the Bundle to be copied.
     */
    public function __construct(
        Version $version,
        array $payload,
        string $bundleSid
    ) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            "sid" => Values::array_get($payload, "sid"),
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
        ];

        $this->solution = ["bundleSid" => $bundleSid];
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
        return "[Twilio.Numbers.V2.BundleCopyInstance]";
    }
}
