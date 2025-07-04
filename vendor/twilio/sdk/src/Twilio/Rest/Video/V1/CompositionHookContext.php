<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Video
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Video\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;
use Twilio\Serialize;

class CompositionHookContext extends InstanceContext
{
    /**
     * Initialize the CompositionHookContext
     *
     * @param Version $version Version that contains the resource
     * @param string $sid The SID of the CompositionHook resource to delete.
     */
    public function __construct(Version $version, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "sid" => $sid,
        ];

        $this->uri = "/CompositionHooks/" . \rawurlencode($sid) . "";
    }

    /**
     * Delete the CompositionHookInstance
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
     * Fetch the CompositionHookInstance
     *
     * @return CompositionHookInstance Fetched CompositionHookInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): CompositionHookInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch("GET", $this->uri, [], [], $headers);

        return new CompositionHookInstance(
            $this->version,
            $payload,
            $this->solution["sid"]
        );
    }

    /**
     * Update the CompositionHookInstance
     *
     * @param string $friendlyName A descriptive string that you create to describe the resource. It can be up to  100 characters long and it must be unique within the account.
     * @param array|Options $options Optional Arguments
     * @return CompositionHookInstance Updated CompositionHookInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(
        string $friendlyName,
        array $options = []
    ): CompositionHookInstance {
        $options = new Values($options);

        $data = Values::of([
            "FriendlyName" => $friendlyName,
            "Enabled" => Serialize::booleanToString($options["enabled"]),
            "VideoLayout" => Serialize::jsonObject($options["videoLayout"]),
            "AudioSources" => Serialize::map(
                $options["audioSources"],
                function ($e) {
                    return $e;
                }
            ),
            "AudioSourcesExcluded" => Serialize::map(
                $options["audioSourcesExcluded"],
                function ($e) {
                    return $e;
                }
            ),
            "Trim" => Serialize::booleanToString($options["trim"]),
            "Format" => $options["format"],
            "Resolution" => $options["resolution"],
            "StatusCallback" => $options["statusCallback"],
            "StatusCallbackMethod" => $options["statusCallbackMethod"],
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

        return new CompositionHookInstance(
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
        return "[Twilio.Video.V1.CompositionHookContext " .
            \implode(" ", $context) .
            "]";
    }
}
