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
use Twilio\Values;
use Twilio\Version;
use Twilio\Deserialize;

/**
 * @property string|null $accountSid
 * @property \DateTime|null $dateCreated
 * @property \DateTime|null $dateUpdated
 * @property string[]|null $iceServers
 * @property string|null $password
 * @property string|null $ttl
 * @property string|null $username
 */
class TokenInstance extends InstanceResource
{
    /**
     * Initialize the TokenInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $accountSid The SID of the [Account](https://www.twilio.com/docs/iam/api/account) that will create the resource.
     */
    public function __construct(
        Version $version,
        array $payload,
        string $accountSid
    ) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            "accountSid" => Values::array_get($payload, "account_sid"),
            "dateCreated" => Deserialize::dateTime(
                Values::array_get($payload, "date_created")
            ),
            "dateUpdated" => Deserialize::dateTime(
                Values::array_get($payload, "date_updated")
            ),
            "iceServers" => Values::array_get($payload, "ice_servers"),
            "password" => Values::array_get($payload, "password"),
            "ttl" => Values::array_get($payload, "ttl"),
            "username" => Values::array_get($payload, "username"),
        ];

        $this->solution = ["accountSid" => $accountSid];
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
        return "[Twilio.Api.V2010.TokenInstance]";
    }
}
