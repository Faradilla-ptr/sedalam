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

namespace Twilio\Rest\Numbers\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string|null $phoneNumber
 * @property string|null $accountSid
 * @property bool|null $portable
 * @property bool|null $pinAndAccountNumberRequired
 * @property string|null $notPortableReason
 * @property int|null $notPortableReasonCode
 * @property string $numberType
 * @property string|null $country
 * @property string|null $url
 */
class PortingPortabilityInstance extends InstanceResource
{
    /**
     * Initialize the PortingPortabilityInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $phoneNumber Phone number to check portability in e164 format.
     */
    public function __construct(
        Version $version,
        array $payload,
        string $phoneNumber = null
    ) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            "phoneNumber" => Values::array_get($payload, "phone_number"),
            "accountSid" => Values::array_get($payload, "account_sid"),
            "portable" => Values::array_get($payload, "portable"),
            "pinAndAccountNumberRequired" => Values::array_get(
                $payload,
                "pin_and_account_number_required"
            ),
            "notPortableReason" => Values::array_get(
                $payload,
                "not_portable_reason"
            ),
            "notPortableReasonCode" => Values::array_get(
                $payload,
                "not_portable_reason_code"
            ),
            "numberType" => Values::array_get($payload, "number_type"),
            "country" => Values::array_get($payload, "country"),
            "url" => Values::array_get($payload, "url"),
        ];

        $this->solution = [
            "phoneNumber" => $phoneNumber ?: $this->properties["phoneNumber"],
        ];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return PortingPortabilityContext Context for this PortingPortabilityInstance
     */
    protected function proxy(): PortingPortabilityContext
    {
        if (!$this->context) {
            $this->context = new PortingPortabilityContext(
                $this->version,
                $this->solution["phoneNumber"]
            );
        }

        return $this->context;
    }

    /**
     * Fetch the PortingPortabilityInstance
     *
     * @param array|Options $options Optional Arguments
     * @return PortingPortabilityInstance Fetched PortingPortabilityInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(array $options = []): PortingPortabilityInstance
    {
        return $this->proxy()->fetch($options);
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
        return "[Twilio.Numbers.V1.PortingPortabilityInstance " .
            \implode(" ", $context) .
            "]";
    }
}
