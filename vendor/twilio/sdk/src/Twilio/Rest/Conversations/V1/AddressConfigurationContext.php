<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Conversations
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Conversations\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;
use Twilio\Serialize;

class AddressConfigurationContext extends InstanceContext
{
    /**
     * Initialize the AddressConfigurationContext
     *
     * @param Version $version Version that contains the resource
     * @param string $sid The SID of the Address Configuration resource. This value can be either the `sid` or the `address` of the configuration
     */
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "sid" => $sid,
        ];

        $this->uri = "/Configuration/Addresses/" . \rawurlencode($sid) . "";
    }

    /**
     * Delete the AddressConfigurationInstance
     *
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(): bool
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
        ]);
        return $this->version->delete("DELETE", $this->uri, [], [], $headers);
    }

    /**
     * Fetch the AddressConfigurationInstance
     *
     * @return AddressConfigurationInstance Fetched AddressConfigurationInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): AddressConfigurationInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch("GET", $this->uri, [], [], $headers);

        return new AddressConfigurationInstance(
            $this->version,
            $payload,
            $this->solution["sid"]
        );
    }

    /**
     * Update the AddressConfigurationInstance
     *
     * @param array|Options $options Optional Arguments
     * @return AddressConfigurationInstance Updated AddressConfigurationInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(array $options = []): AddressConfigurationInstance
    {
        $options = new Values($options);

        $data = Values::of([
            "FriendlyName" => $options["friendlyName"],
            "AutoCreation.Enabled" => Serialize::booleanToString(
                $options["autoCreationEnabled"]
            ),
            "AutoCreation.Type" => $options["autoCreationType"],
            "AutoCreation.ConversationServiceSid" =>
                $options["autoCreationConversationServiceSid"],
            "AutoCreation.WebhookUrl" => $options["autoCreationWebhookUrl"],
            "AutoCreation.WebhookMethod" =>
                $options["autoCreationWebhookMethod"],
            "AutoCreation.WebhookFilters" => Serialize::map(
                $options["autoCreationWebhookFilters"],
                function ($e) {
                    return $e;
                }
            ),
            "AutoCreation.StudioFlowSid" =>
                $options["autoCreationStudioFlowSid"],
            "AutoCreation.StudioRetryCount" =>
                $options["autoCreationStudioRetryCount"],
        ]);

        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->update(
            "POST",
            $this->uri,
            [],
            $data,
            $headers
        );

        return new AddressConfigurationInstance(
            $this->version,
            $payload,
            $this->solution["sid"]
        );
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
        return "[Twilio.Conversations.V1.AddressConfigurationContext " .
            \implode(" ", $context) .
            "]";
    }
}
