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

namespace Twilio\Rest\Intelligence\V2\Transcript;

use Twilio\Exceptions\TwilioException;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;
use Twilio\Serialize;

class MediaContext extends InstanceContext
{
    /**
     * Initialize the MediaContext
     *
     * @param Version $version Version that contains the resource
     * @param string $sid The unique SID identifier of the Transcript.
     */
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "sid" => $sid,
        ];

        $this->uri = "/Transcripts/" . \rawurlencode($sid) . "/Media";
    }

    /**
     * Fetch the MediaInstance
     *
     * @param array|Options $options Optional Arguments
     * @return MediaInstance Fetched MediaInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(array $options = []): MediaInstance
    {
        $options = new Values($options);

        $params = Values::of([
            "Redacted" => Serialize::booleanToString($options["redacted"]),
        ]);

        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch(
            "GET",
            $this->uri,
            $params,
            [],
            $headers
        );

        return new MediaInstance(
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
        return "[Twilio.Intelligence.V2.MediaContext " .
            \implode(" ", $context) .
            "]";
    }
}
