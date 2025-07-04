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

namespace Twilio\Rest\Numbers\V2\RegulatoryCompliance;

use Twilio\Exceptions\TwilioException;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;
use Twilio\Serialize;

class SupportingDocumentContext extends InstanceContext
{
    /**
     * Initialize the SupportingDocumentContext
     *
     * @param Version $version Version that contains the resource
     * @param string $sid The unique string created by Twilio to identify the Supporting Document resource.
     */
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "sid" => $sid,
        ];

        $this->uri =
            "/RegulatoryCompliance/SupportingDocuments/" .
            \rawurlencode($sid) .
            "";
    }

    /**
     * Delete the SupportingDocumentInstance
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
     * Fetch the SupportingDocumentInstance
     *
     * @return SupportingDocumentInstance Fetched SupportingDocumentInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): SupportingDocumentInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch("GET", $this->uri, [], [], $headers);

        return new SupportingDocumentInstance(
            $this->version,
            $payload,
            $this->solution["sid"]
        );
    }

    /**
     * Update the SupportingDocumentInstance
     *
     * @param array|Options $options Optional Arguments
     * @return SupportingDocumentInstance Updated SupportingDocumentInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(array $options = []): SupportingDocumentInstance
    {
        $options = new Values($options);

        $data = Values::of([
            "FriendlyName" => $options["friendlyName"],
            "Attributes" => Serialize::jsonObject($options["attributes"]),
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

        return new SupportingDocumentInstance(
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
        return "[Twilio.Numbers.V2.SupportingDocumentContext " .
            \implode(" ", $context) .
            "]";
    }
}
