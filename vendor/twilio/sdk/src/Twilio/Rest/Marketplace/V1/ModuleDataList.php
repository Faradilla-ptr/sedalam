<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Marketplace
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Marketplace\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

class ModuleDataList extends ListResource
{
    /**
     * Construct the ModuleDataList
     *
     * @param Version $version Version that contains the resource
     */
    public function __construct(Version $version)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [];

        $this->uri = "/Listings";
    }

    /**
     * Create the ModuleDataInstance
     *
     * @param array|Options $options Optional Arguments
     * @return ModuleDataInstance Created ModuleDataInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function create(array $options = []): ModuleDataInstance
    {
        $options = new Values($options);

        $data = Values::of([
            "ModuleInfo" => $options["moduleInfo"],
            "Configuration" => $options["configuration"],
        ]);

        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->create(
            "POST",
            $this->uri,
            [],
            $data,
            $headers
        );

        return new ModuleDataInstance($this->version, $payload);
    }

    /**
     * Fetch the ModuleDataInstance
     *
     * @return ModuleDataInstance Fetched ModuleDataInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): ModuleDataInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch("GET", $this->uri, [], [], $headers);

        return new ModuleDataInstance($this->version, $payload);
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return "[Twilio.Marketplace.V1.ModuleDataList]";
    }
}
