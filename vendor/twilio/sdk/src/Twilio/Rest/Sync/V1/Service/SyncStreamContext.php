<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Sync
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Sync\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;
use Twilio\Rest\Sync\V1\Service\SyncStream\StreamMessageList;

/**
 * @property StreamMessageList $streamMessages
 */
class SyncStreamContext extends InstanceContext
{
    protected $_streamMessages;

    /**
     * Initialize the SyncStreamContext
     *
     * @param Version $version Version that contains the resource
     * @param string $serviceSid The SID of the [Sync Service](https://www.twilio.com/docs/sync/api/service) to create the new Stream in.
     * @param string $sid The SID of the Stream resource to delete.
     */
    public function __construct(Version $version, $serviceSid, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "serviceSid" => $serviceSid,
            "sid" => $sid,
        ];

        $this->uri =
            "/Services/" .
            \rawurlencode($serviceSid) .
            "/Streams/" .
            \rawurlencode($sid) .
            "";
    }

    /**
     * Delete the SyncStreamInstance
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
     * Fetch the SyncStreamInstance
     *
     * @return SyncStreamInstance Fetched SyncStreamInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): SyncStreamInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch("GET", $this->uri, [], [], $headers);

        return new SyncStreamInstance(
            $this->version,
            $payload,
            $this->solution["serviceSid"],
            $this->solution["sid"]
        );
    }

    /**
     * Update the SyncStreamInstance
     *
     * @param array|Options $options Optional Arguments
     * @return SyncStreamInstance Updated SyncStreamInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(array $options = []): SyncStreamInstance
    {
        $options = new Values($options);

        $data = Values::of([
            "Ttl" => $options["ttl"],
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

        return new SyncStreamInstance(
            $this->version,
            $payload,
            $this->solution["serviceSid"],
            $this->solution["sid"]
        );
    }

    /**
     * Access the streamMessages
     */
    protected function getStreamMessages(): StreamMessageList
    {
        if (!$this->_streamMessages) {
            $this->_streamMessages = new StreamMessageList(
                $this->version,
                $this->solution["serviceSid"],
                $this->solution["sid"]
            );
        }

        return $this->_streamMessages;
    }

    /**
     * Magic getter to lazy load subresources
     *
     * @param string $name Subresource to return
     * @return ListResource The requested subresource
     * @throws TwilioException For unknown subresources
     */
    public function __get(string $name): ListResource
    {
        if (\property_exists($this, "_" . $name)) {
            $method = "get" . \ucfirst($name);
            return $this->$method();
        }

        throw new TwilioException("Unknown subresource " . $name);
    }

    /**
     * Magic caller to get resource contexts
     *
     * @param string $name Resource to return
     * @param array $arguments Context parameters
     * @return InstanceContext The requested resource context
     * @throws TwilioException For unknown resource
     */
    public function __call(string $name, array $arguments): InstanceContext
    {
        $property = $this->$name;
        if (\method_exists($property, "getContext")) {
            return \call_user_func_array([$property, "getContext"], $arguments);
        }

        throw new TwilioException("Resource does not have a context");
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
        return "[Twilio.Sync.V1.SyncStreamContext " .
            \implode(" ", $context) .
            "]";
    }
}
