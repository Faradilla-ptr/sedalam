<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Intelligence
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Intelligence\V2;

use Twilio\Exceptions\TwilioException;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;
use Twilio\Serialize;

class CustomOperatorContext extends InstanceContext
{
    /**
     * Initialize the CustomOperatorContext
     *
     * @param Version $version Version that contains the resource
     * @param string $sid A 34 character string that uniquely identifies this Custom Operator.
     */
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "sid" => $sid,
        ];

        $this->uri = "/Operators/Custom/" . \rawurlencode($sid) . "";
    }

    /**
     * Delete the CustomOperatorInstance
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
     * Fetch the CustomOperatorInstance
     *
     * @return CustomOperatorInstance Fetched CustomOperatorInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): CustomOperatorInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch("GET", $this->uri, [], [], $headers);

        return new CustomOperatorInstance(
            $this->version,
            $payload,
            $this->solution["sid"]
        );
    }

    /**
     * Update the CustomOperatorInstance
     *
     * @param string $friendlyName A human-readable name of this resource, up to 64 characters.
     * @param array $config Operator configuration, following the schema defined by the Operator Type.
     * @param array|Options $options Optional Arguments
     * @return CustomOperatorInstance Updated CustomOperatorInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(
        string $friendlyName,
        array $config,
        array $options = []
    ): CustomOperatorInstance {
        $options = new Values($options);

        $data = Values::of([
            "FriendlyName" => $friendlyName,
            "Config" => Serialize::jsonObject($config),
        ]);

        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
            "If-Match" => $options["ifMatch"],
        ]);
        $payload = $this->version->update(
            "POST",
            $this->uri,
            [],
            $data,
            $headers
        );

        return new CustomOperatorInstance(
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
        return "[Twilio.Intelligence.V2.CustomOperatorContext " .
            \implode(" ", $context) .
            "]";
    }
}
