<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Trunking
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Trunking\V1\Trunk;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use Twilio\Deserialize;

/**
 * @property string|null $accountSid
 * @property string $addressRequirements
 * @property string|null $apiVersion
 * @property bool|null $beta
 * @property array|null $capabilities
 * @property \DateTime|null $dateCreated
 * @property \DateTime|null $dateUpdated
 * @property string|null $friendlyName
 * @property array|null $links
 * @property string|null $phoneNumber
 * @property string|null $sid
 * @property string|null $smsApplicationSid
 * @property string|null $smsFallbackMethod
 * @property string|null $smsFallbackUrl
 * @property string|null $smsMethod
 * @property string|null $smsUrl
 * @property string|null $statusCallback
 * @property string|null $statusCallbackMethod
 * @property string|null $trunkSid
 * @property string|null $url
 * @property string|null $voiceApplicationSid
 * @property bool|null $voiceCallerIdLookup
 * @property string|null $voiceFallbackMethod
 * @property string|null $voiceFallbackUrl
 * @property string|null $voiceMethod
 * @property string|null $voiceUrl
 */
class PhoneNumberInstance extends InstanceResource
{
    /**
     * Initialize the PhoneNumberInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $trunkSid The SID of the Trunk to associate the phone number with.
     * @param string $sid The unique string that we created to identify the PhoneNumber resource to delete.
     */
    public function __construct(
        Version $version,
        array $payload,
        string $trunkSid,
        string $sid = null
    ) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            "accountSid" => Values::array_get($payload, "account_sid"),
            "addressRequirements" => Values::array_get(
                $payload,
                "address_requirements"
            ),
            "apiVersion" => Values::array_get($payload, "api_version"),
            "beta" => Values::array_get($payload, "beta"),
            "capabilities" => Values::array_get($payload, "capabilities"),
            "dateCreated" => Deserialize::dateTime(
                Values::array_get($payload, "date_created")
            ),
            "dateUpdated" => Deserialize::dateTime(
                Values::array_get($payload, "date_updated")
            ),
            "friendlyName" => Values::array_get($payload, "friendly_name"),
            "links" => Values::array_get($payload, "links"),
            "phoneNumber" => Values::array_get($payload, "phone_number"),
            "sid" => Values::array_get($payload, "sid"),
            "smsApplicationSid" => Values::array_get(
                $payload,
                "sms_application_sid"
            ),
            "smsFallbackMethod" => Values::array_get(
                $payload,
                "sms_fallback_method"
            ),
            "smsFallbackUrl" => Values::array_get($payload, "sms_fallback_url"),
            "smsMethod" => Values::array_get($payload, "sms_method"),
            "smsUrl" => Values::array_get($payload, "sms_url"),
            "statusCallback" => Values::array_get($payload, "status_callback"),
            "statusCallbackMethod" => Values::array_get(
                $payload,
                "status_callback_method"
            ),
            "trunkSid" => Values::array_get($payload, "trunk_sid"),
            "url" => Values::array_get($payload, "url"),
            "voiceApplicationSid" => Values::array_get(
                $payload,
                "voice_application_sid"
            ),
            "voiceCallerIdLookup" => Values::array_get(
                $payload,
                "voice_caller_id_lookup"
            ),
            "voiceFallbackMethod" => Values::array_get(
                $payload,
                "voice_fallback_method"
            ),
            "voiceFallbackUrl" => Values::array_get(
                $payload,
                "voice_fallback_url"
            ),
            "voiceMethod" => Values::array_get($payload, "voice_method"),
            "voiceUrl" => Values::array_get($payload, "voice_url"),
        ];

        $this->solution = [
            "trunkSid" => $trunkSid,
            "sid" => $sid ?: $this->properties["sid"],
        ];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return PhoneNumberContext Context for this PhoneNumberInstance
     */
    protected function proxy(): PhoneNumberContext
    {
        if (!$this->context) {
            $this->context = new PhoneNumberContext(
                $this->version,
                $this->solution["trunkSid"],
                $this->solution["sid"]
            );
        }

        return $this->context;
    }

    /**
     * Delete the PhoneNumberInstance
     *
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    /**
     * Fetch the PhoneNumberInstance
     *
     * @return PhoneNumberInstance Fetched PhoneNumberInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): PhoneNumberInstance
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
        return "[Twilio.Trunking.V1.PhoneNumberInstance " .
            \implode(" ", $context) .
            "]";
    }
}
