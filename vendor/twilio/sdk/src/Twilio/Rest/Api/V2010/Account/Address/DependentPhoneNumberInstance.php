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

namespace Twilio\Rest\Api\V2010\Account\Address;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;
use Twilio\Deserialize;

/**
 * @property string|null $sid
 * @property string|null $accountSid
 * @property string|null $friendlyName
 * @property string|null $phoneNumber
 * @property string|null $voiceUrl
 * @property string|null $voiceMethod
 * @property string|null $voiceFallbackMethod
 * @property string|null $voiceFallbackUrl
 * @property bool|null $voiceCallerIdLookup
 * @property \DateTime|null $dateCreated
 * @property \DateTime|null $dateUpdated
 * @property string|null $smsFallbackMethod
 * @property string|null $smsFallbackUrl
 * @property string|null $smsMethod
 * @property string|null $smsUrl
 * @property string $addressRequirements
 * @property array|null $capabilities
 * @property string|null $statusCallback
 * @property string|null $statusCallbackMethod
 * @property string|null $apiVersion
 * @property string|null $smsApplicationSid
 * @property string|null $voiceApplicationSid
 * @property string|null $trunkSid
 * @property string $emergencyStatus
 * @property string|null $emergencyAddressSid
 * @property string|null $uri
 */
class DependentPhoneNumberInstance extends InstanceResource
{
    /**
     * Initialize the DependentPhoneNumberInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $accountSid The SID of the [Account](https://www.twilio.com/docs/iam/api/account) that created the DependentPhoneNumber resources to read.
     * @param string $addressSid The SID of the Address resource associated with the phone number.
     */
    public function __construct(
        Version $version,
        array $payload,
        string $accountSid,
        string $addressSid
    ) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            "sid" => Values::array_get($payload, "sid"),
            "accountSid" => Values::array_get($payload, "account_sid"),
            "friendlyName" => Values::array_get($payload, "friendly_name"),
            "phoneNumber" => Values::array_get($payload, "phone_number"),
            "voiceUrl" => Values::array_get($payload, "voice_url"),
            "voiceMethod" => Values::array_get($payload, "voice_method"),
            "voiceFallbackMethod" => Values::array_get(
                $payload,
                "voice_fallback_method"
            ),
            "voiceFallbackUrl" => Values::array_get(
                $payload,
                "voice_fallback_url"
            ),
            "voiceCallerIdLookup" => Values::array_get(
                $payload,
                "voice_caller_id_lookup"
            ),
            "dateCreated" => Deserialize::dateTime(
                Values::array_get($payload, "date_created")
            ),
            "dateUpdated" => Deserialize::dateTime(
                Values::array_get($payload, "date_updated")
            ),
            "smsFallbackMethod" => Values::array_get(
                $payload,
                "sms_fallback_method"
            ),
            "smsFallbackUrl" => Values::array_get($payload, "sms_fallback_url"),
            "smsMethod" => Values::array_get($payload, "sms_method"),
            "smsUrl" => Values::array_get($payload, "sms_url"),
            "addressRequirements" => Values::array_get(
                $payload,
                "address_requirements"
            ),
            "capabilities" => Values::array_get($payload, "capabilities"),
            "statusCallback" => Values::array_get($payload, "status_callback"),
            "statusCallbackMethod" => Values::array_get(
                $payload,
                "status_callback_method"
            ),
            "apiVersion" => Values::array_get($payload, "api_version"),
            "smsApplicationSid" => Values::array_get(
                $payload,
                "sms_application_sid"
            ),
            "voiceApplicationSid" => Values::array_get(
                $payload,
                "voice_application_sid"
            ),
            "trunkSid" => Values::array_get($payload, "trunk_sid"),
            "emergencyStatus" => Values::array_get(
                $payload,
                "emergency_status"
            ),
            "emergencyAddressSid" => Values::array_get(
                $payload,
                "emergency_address_sid"
            ),
            "uri" => Values::array_get($payload, "uri"),
        ];

        $this->solution = [
            "accountSid" => $accountSid,
            "addressSid" => $addressSid,
        ];
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
        return "[Twilio.Api.V2010.DependentPhoneNumberInstance]";
    }
}
