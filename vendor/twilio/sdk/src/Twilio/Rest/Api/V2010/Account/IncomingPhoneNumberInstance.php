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
use Twilio\Base\PhoneNumberCapabilities;
use Twilio\Rest\Api\V2010\Account\IncomingPhoneNumber\AssignedAddOnList;

/**
 * @property string|null $accountSid
 * @property string|null $addressSid
 * @property string $addressRequirements
 * @property string|null $apiVersion
 * @property bool|null $beta
 * @property PhoneNumberCapabilities|null $capabilities
 * @property \DateTime|null $dateCreated
 * @property \DateTime|null $dateUpdated
 * @property string|null $friendlyName
 * @property string|null $identitySid
 * @property string|null $phoneNumber
 * @property string|null $origin
 * @property string|null $sid
 * @property string|null $smsApplicationSid
 * @property string|null $smsFallbackMethod
 * @property string|null $smsFallbackUrl
 * @property string|null $smsMethod
 * @property string|null $smsUrl
 * @property string|null $statusCallback
 * @property string|null $statusCallbackMethod
 * @property string|null $trunkSid
 * @property string|null $uri
 * @property string $voiceReceiveMode
 * @property string|null $voiceApplicationSid
 * @property bool|null $voiceCallerIdLookup
 * @property string|null $voiceFallbackMethod
 * @property string|null $voiceFallbackUrl
 * @property string|null $voiceMethod
 * @property string|null $voiceUrl
 * @property string $emergencyStatus
 * @property string|null $emergencyAddressSid
 * @property string $emergencyAddressStatus
 * @property string|null $bundleSid
 * @property string|null $status
 */
class IncomingPhoneNumberInstance extends InstanceResource
{
    protected $_assignedAddOns;

    /**
     * Initialize the IncomingPhoneNumberInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $accountSid The SID of the [Account](https://www.twilio.com/docs/iam/api/account) that will create the resource.
     * @param string $sid The Twilio-provided string that uniquely identifies the IncomingPhoneNumber resource to delete.
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
            "accountSid" => Values::array_get($payload, "account_sid"),
            "addressSid" => Values::array_get($payload, "address_sid"),
            "addressRequirements" => Values::array_get(
                $payload,
                "address_requirements"
            ),
            "apiVersion" => Values::array_get($payload, "api_version"),
            "beta" => Values::array_get($payload, "beta"),
            "capabilities" => Deserialize::phoneNumberCapabilities(
                Values::array_get($payload, "capabilities")
            ),
            "dateCreated" => Deserialize::dateTime(
                Values::array_get($payload, "date_created")
            ),
            "dateUpdated" => Deserialize::dateTime(
                Values::array_get($payload, "date_updated")
            ),
            "friendlyName" => Values::array_get($payload, "friendly_name"),
            "identitySid" => Values::array_get($payload, "identity_sid"),
            "phoneNumber" => Values::array_get($payload, "phone_number"),
            "origin" => Values::array_get($payload, "origin"),
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
            "uri" => Values::array_get($payload, "uri"),
            "voiceReceiveMode" => Values::array_get(
                $payload,
                "voice_receive_mode"
            ),
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
            "emergencyStatus" => Values::array_get(
                $payload,
                "emergency_status"
            ),
            "emergencyAddressSid" => Values::array_get(
                $payload,
                "emergency_address_sid"
            ),
            "emergencyAddressStatus" => Values::array_get(
                $payload,
                "emergency_address_status"
            ),
            "bundleSid" => Values::array_get($payload, "bundle_sid"),
            "status" => Values::array_get($payload, "status"),
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
     * @return IncomingPhoneNumberContext Context for this IncomingPhoneNumberInstance
     */
    protected function proxy(): IncomingPhoneNumberContext
    {
        if (!$this->context) {
            $this->context = new IncomingPhoneNumberContext(
                $this->version,
                $this->solution["accountSid"],
                $this->solution["sid"]
            );
        }

        return $this->context;
    }

    /**
     * Delete the IncomingPhoneNumberInstance
     *
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    /**
     * Fetch the IncomingPhoneNumberInstance
     *
     * @return IncomingPhoneNumberInstance Fetched IncomingPhoneNumberInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): IncomingPhoneNumberInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Update the IncomingPhoneNumberInstance
     *
     * @param array|Options $options Optional Arguments
     * @return IncomingPhoneNumberInstance Updated IncomingPhoneNumberInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(array $options = []): IncomingPhoneNumberInstance
    {
        return $this->proxy()->update($options);
    }

    /**
     * Access the assignedAddOns
     */
    protected function getAssignedAddOns(): AssignedAddOnList
    {
        return $this->proxy()->assignedAddOns;
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
        return "[Twilio.Api.V2010.IncomingPhoneNumberInstance " .
            \implode(" ", $context) .
            "]";
    }
}
