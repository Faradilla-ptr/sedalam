<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Flex
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\FlexApi\V1\PluginConfiguration;

use Twilio\Exceptions\TwilioException;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;

class ConfiguredPluginContext extends InstanceContext
{
    /**
     * Initialize the ConfiguredPluginContext
     *
     * @param Version $version Version that contains the resource
     * @param string $configurationSid The SID of the Flex Plugin Configuration the resource to belongs to.
     * @param string $pluginSid The unique string that we created to identify the Flex Plugin resource.
     */
    public function __construct(Version $version, $configurationSid, $pluginSid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "configurationSid" => $configurationSid,
            "pluginSid" => $pluginSid,
        ];

        $this->uri =
            "/PluginService/Configurations/" .
            \rawurlencode($configurationSid) .
            "/Plugins/" .
            \rawurlencode($pluginSid) .
            "";
    }

    /**
     * Fetch the ConfiguredPluginInstance
     *
     * @param array|Options $options Optional Arguments
     * @return ConfiguredPluginInstance Fetched ConfiguredPluginInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(array $options = []): ConfiguredPluginInstance
    {
        $options = new Values($options);

        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
            "Flex-Metadata" => $options["flexMetadata"],
        ]);
        $payload = $this->version->fetch("GET", $this->uri, [], [], $headers);

        return new ConfiguredPluginInstance(
            $this->version,
            $payload,
            $this->solution["configurationSid"],
            $this->solution["pluginSid"]
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
        return "[Twilio.FlexApi.V1.ConfiguredPluginContext " .
            \implode(" ", $context) .
            "]";
    }
}
