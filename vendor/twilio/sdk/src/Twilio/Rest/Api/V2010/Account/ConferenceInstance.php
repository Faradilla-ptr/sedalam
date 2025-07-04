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
use Twilio\Rest\Api\V2010\Account\Conference\ParticipantList;
use Twilio\Rest\Api\V2010\Account\Conference\RecordingList;

/**
 * @property string|null $accountSid
 * @property \DateTime|null $dateCreated
 * @property \DateTime|null $dateUpdated
 * @property string|null $apiVersion
 * @property string|null $friendlyName
 * @property string|null $region
 * @property string|null $sid
 * @property string $status
 * @property string|null $uri
 * @property array|null $subresourceUris
 * @property string $reasonConferenceEnded
 * @property string|null $callSidEndingConference
 */
class ConferenceInstance extends InstanceResource
{
    protected $_participants;
    protected $_recordings;

    /**
     * Initialize the ConferenceInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $accountSid The SID of the [Account](https://www.twilio.com/docs/iam/api/account) that created the Conference resource(s) to fetch.
     * @param string $sid The Twilio-provided string that uniquely identifies the Conference resource to fetch
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
            "dateCreated" => Deserialize::dateTime(
                Values::array_get($payload, "date_created")
            ),
            "dateUpdated" => Deserialize::dateTime(
                Values::array_get($payload, "date_updated")
            ),
            "apiVersion" => Values::array_get($payload, "api_version"),
            "friendlyName" => Values::array_get($payload, "friendly_name"),
            "region" => Values::array_get($payload, "region"),
            "sid" => Values::array_get($payload, "sid"),
            "status" => Values::array_get($payload, "status"),
            "uri" => Values::array_get($payload, "uri"),
            "subresourceUris" => Values::array_get(
                $payload,
                "subresource_uris"
            ),
            "reasonConferenceEnded" => Values::array_get(
                $payload,
                "reason_conference_ended"
            ),
            "callSidEndingConference" => Values::array_get(
                $payload,
                "call_sid_ending_conference"
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
     * @return ConferenceContext Context for this ConferenceInstance
     */
    protected function proxy(): ConferenceContext
    {
        if (!$this->context) {
            $this->context = new ConferenceContext(
                $this->version,
                $this->solution["accountSid"],
                $this->solution["sid"]
            );
        }

        return $this->context;
    }

    /**
     * Fetch the ConferenceInstance
     *
     * @return ConferenceInstance Fetched ConferenceInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): ConferenceInstance
    {
        return $this->proxy()->fetch();
    }

    /**
     * Update the ConferenceInstance
     *
     * @param array|Options $options Optional Arguments
     * @return ConferenceInstance Updated ConferenceInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(array $options = []): ConferenceInstance
    {
        return $this->proxy()->update($options);
    }

    /**
     * Access the participants
     */
    protected function getParticipants(): ParticipantList
    {
        return $this->proxy()->participants;
    }

    /**
     * Access the recordings
     */
    protected function getRecordings(): RecordingList
    {
        return $this->proxy()->recordings;
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
        return "[Twilio.Api.V2010.ConferenceInstance " .
            \implode(" ", $context) .
            "]";
    }
}
