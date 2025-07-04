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

class OperatorResultContext extends InstanceContext
{
    /**
     * Initialize the OperatorResultContext
     *
     * @param Version $version Version that contains the resource
     * @param string $transcriptSid A 34 character string that uniquely identifies this Transcript.
     * @param string $operatorSid A 34 character string that identifies this Language Understanding operator sid.
     */
    public function __construct(Version $version, $transcriptSid, $operatorSid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "transcriptSid" => $transcriptSid,
            "operatorSid" => $operatorSid,
        ];

        $this->uri =
            "/Transcripts/" .
            \rawurlencode($transcriptSid) .
            "/OperatorResults/" .
            \rawurlencode($operatorSid) .
            "";
    }

    /**
     * Fetch the OperatorResultInstance
     *
     * @param array|Options $options Optional Arguments
     * @return OperatorResultInstance Fetched OperatorResultInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(array $options = []): OperatorResultInstance
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

        return new OperatorResultInstance(
            $this->version,
            $payload,
            $this->solution["transcriptSid"],
            $this->solution["operatorSid"]
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
        return "[Twilio.Intelligence.V2.OperatorResultContext " .
            \implode(" ", $context) .
            "]";
    }
}
