<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Voice
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Voice\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;
use Twilio\Serialize;

class ByocTrunkContext extends InstanceContext
{
    /**
     * Initialize the ByocTrunkContext
     *
     * @param Version $version Version that contains the resource
     * @param string $sid The Twilio-provided string that uniquely identifies the BYOC Trunk resource to delete.
     */
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "sid" => $sid,
        ];

        $this->uri = "/ByocTrunks/" . \rawurlencode($sid) . "";
    }

    /**
     * Delete the ByocTrunkInstance
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
     * Fetch the ByocTrunkInstance
     *
     * @return ByocTrunkInstance Fetched ByocTrunkInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): ByocTrunkInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch("GET", $this->uri, [], [], $headers);

        return new ByocTrunkInstance(
            $this->version,
            $payload,
            $this->solution["sid"]
        );
    }

    /**
     * Update the ByocTrunkInstance
     *
     * @param array|Options $options Optional Arguments
     * @return ByocTrunkInstance Updated ByocTrunkInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(array $options = []): ByocTrunkInstance
    {
        $options = new Values($options);

        $data = Values::of([
            "FriendlyName" => $options["friendlyName"],
            "VoiceUrl" => $options["voiceUrl"],
            "VoiceMethod" => $options["voiceMethod"],
            "VoiceFallbackUrl" => $options["voiceFallbackUrl"],
            "VoiceFallbackMethod" => $options["voiceFallbackMethod"],
            "StatusCallbackUrl" => $options["statusCallbackUrl"],
            "StatusCallbackMethod" => $options["statusCallbackMethod"],
            "CnamLookupEnabled" => Serialize::booleanToString(
                $options["cnamLookupEnabled"]
            ),
            "ConnectionPolicySid" => $options["connectionPolicySid"],
            "FromDomainSid" => $options["fromDomainSid"],
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

        return new ByocTrunkInstance(
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
        return "[Twilio.Voice.V1.ByocTrunkContext " .
            \implode(" ", $context) .
            "]";
    }
}
