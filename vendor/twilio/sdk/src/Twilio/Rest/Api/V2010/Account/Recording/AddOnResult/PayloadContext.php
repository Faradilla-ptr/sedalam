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

namespace Twilio\Rest\Api\V2010\Account\Recording\AddOnResult;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;
use Twilio\Rest\Api\V2010\Account\Recording\AddOnResult\Payload\DataList;

/**
 * @property DataList $data
 * @method \Twilio\Rest\Api\V2010\Account\Recording\AddOnResult\Payload\DataContext data()
 */
class PayloadContext extends InstanceContext
{
    protected $_data;

    /**
     * Initialize the PayloadContext
     *
     * @param Version $version Version that contains the resource
     * @param string $accountSid The SID of the [Account](https://www.twilio.com/docs/iam/api/account) that created the Recording AddOnResult Payload resources to delete.
     * @param string $referenceSid The SID of the recording to which the AddOnResult resource that contains the payloads to delete belongs.
     * @param string $addOnResultSid The SID of the AddOnResult to which the payloads to delete belongs.
     * @param string $sid The Twilio-provided string that uniquely identifies the Recording AddOnResult Payload resource to delete.
     */
    public function __construct(
        Version $version,
        $accountSid,
        $referenceSid,
        $addOnResultSid,
        $sid
    ) {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "accountSid" => $accountSid,
            "referenceSid" => $referenceSid,
            "addOnResultSid" => $addOnResultSid,
            "sid" => $sid,
        ];

        $this->uri =
            "/Accounts/" .
            \rawurlencode($accountSid) .
            "/Recordings/" .
            \rawurlencode($referenceSid) .
            "/AddOnResults/" .
            \rawurlencode($addOnResultSid) .
            "/Payloads/" .
            \rawurlencode($sid) .
            ".json";
    }

    /**
     * Delete the PayloadInstance
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
     * Fetch the PayloadInstance
     *
     * @return PayloadInstance Fetched PayloadInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): PayloadInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch("GET", $this->uri, [], [], $headers);

        return new PayloadInstance(
            $this->version,
            $payload,
            $this->solution["accountSid"],
            $this->solution["referenceSid"],
            $this->solution["addOnResultSid"],
            $this->solution["sid"]
        );
    }

    /**
     * Access the data
     */
    protected function getData(): DataList
    {
        if (!$this->_data) {
            $this->_data = new DataList(
                $this->version,
                $this->solution["accountSid"],
                $this->solution["referenceSid"],
                $this->solution["addOnResultSid"],
                $this->solution["sid"]
            );
        }

        return $this->_data;
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
        return "[Twilio.Api.V2010.PayloadContext " .
            \implode(" ", $context) .
            "]";
    }
}
