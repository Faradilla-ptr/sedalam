<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Wireless
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Wireless\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use Twilio\Deserialize;

/**
 * @property string|null $sid
 * @property string|null $uniqueName
 * @property string|null $accountSid
 * @property string|null $friendlyName
 * @property bool|null $dataEnabled
 * @property string|null $dataMetering
 * @property int $dataLimit
 * @property bool|null $messagingEnabled
 * @property bool|null $voiceEnabled
 * @property bool|null $nationalRoamingEnabled
 * @property int $nationalRoamingDataLimit
 * @property string[]|null $internationalRoaming
 * @property int $internationalRoamingDataLimit
 * @property \DateTime|null $dateCreated
 * @property \DateTime|null $dateUpdated
 * @property string|null $url
 */
class RatePlanInstance extends InstanceResource
{
    /**
     * Initialize the RatePlanInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $sid The SID of the RatePlan resource to delete.
     */
    public function __construct(
        Version $version,
        array $payload,
        string $sid = null
    ) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            "sid" => Values::array_get($payload, "sid"),
            "uniqueName" => Values::array_get($payload, "unique_name"),
            "accountSid" => Values::array_get($payload, "account_sid"),
            "friendlyName" => Values::array_get($payload, "friendly_name"),
            "dataEnabled" => Values::array_get($payload, "data_enabled"),
            "dataMetering" => Values::array_get($payload, "data_metering"),
            "dataLimit" => Values::array_get($payload, "data_limit"),
            "messagingEnabled" => Values::array_get(
                $payload,
                "messaging_enabled"
            ),
            "voiceEnabled" => Values::array_get($payload, "voice_enabled"),
            "nationalRoamingEnabled" => Values::array_get(
                $payload,
                "national_roaming_enabled"
            ),
            "nationalRoamingDataLimit" => Values::array_get(
                $payload,
                "national_roaming_data_limit"
            ),
            "internationalRoaming" => Values::array_get(
                $payload,
                "international_roaming"
            ),
            "internationalRoamingDataLimit" => Values::array_get(
                $payload,
                "international_roaming_data_limit"
            ),
            "dateCreated" => Deserialize::dateTime(
                Values::array_get($payload, "date_created")
            ),
            "dateUpdated" => Deserialize::dateTime(
                Values::array_get($payload, "date_updated")
            ),
            "url" => Values::array_get($payload, "url"),
        ];

        $this->solution = ["sid" => $sid ?: $this->properties["sid"]];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return RatePlanContext Context for this RatePlanInstance
     */
    protected function proxy(): RatePlanContext
    {
        if (!$this->context) {
            $this->context = new RatePlanContext(
                $this->version,
                $this->solution["sid"]
            );
        }

        return $this->context;
    }

    /**
     * Delete the RatePlanInstance
     *
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(): bool
    {
        return $this->proxy()->delete();
    }

    /**
     * Fetch the RatePlanInstance
     *
     * @return RatePlanInstance Fetched RatePlanInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): RatePlanInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Update the RatePlanInstance
     *
     * @param array|Options $options Optional Arguments
     * @return RatePlanInstance Updated RatePlanInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(array $options = []): RatePlanInstance
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
        return "[Twilio.Wireless.V1.RatePlanInstance " .
            \implode(" ", $context) .
            "]";
    }
}
