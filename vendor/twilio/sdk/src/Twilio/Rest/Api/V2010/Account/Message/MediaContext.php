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

namespace Twilio\Rest\Api\V2010\Account\Message;

use Twilio\Exceptions\TwilioException;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;

class MediaContext extends InstanceContext
{
    /**
     * Initialize the MediaContext
     *
     * @param Version $version Version that contains the resource
     * @param string $accountSid The SID of the [Account](https://www.twilio.com/docs/iam/api/account) that is associated with the Media resource.
     * @param string $messageSid The SID of the Message resource that is associated with the Media resource.
     * @param string $sid The unique identifier of the to-be-deleted Media resource.
     */
    public function __construct(
        Version $version,
        $accountSid,
        $messageSid,
        $sid
    ) {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "accountSid" => $accountSid,
            "messageSid" => $messageSid,
            "sid" => $sid,
        ];

        $this->uri =
            "/Accounts/" .
            \rawurlencode($accountSid) .
            "/Messages/" .
            \rawurlencode($messageSid) .
            "/Media/" .
            \rawurlencode($sid) .
            ".json";
    }

    /**
     * Delete the MediaInstance
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
     * Fetch the MediaInstance
     *
     * @return MediaInstance Fetched MediaInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): MediaInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch("GET", $this->uri, [], [], $headers);

        return new MediaInstance(
            $this->version,
            $payload,
            $this->solution["accountSid"],
            $this->solution["messageSid"],
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
        return "[Twilio.Api.V2010.MediaContext " .
            \implode(" ", $context) .
            "]";
    }
}
