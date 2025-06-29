<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Proxy
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Proxy\V1\Service\Session;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;
use Twilio\Rest\Proxy\V1\Service\Session\Participant\MessageInteractionList;

/**
 * @property MessageInteractionList $messageInteractions
 * @method \Twilio\Rest\Proxy\V1\Service\Session\Participant\MessageInteractionContext messageInteractions(string $sid)
 */
class ParticipantContext extends InstanceContext
{
    protected $_messageInteractions;

    /**
     * Initialize the ParticipantContext
     *
     * @param Version $version Version that contains the resource
     * @param string $serviceSid The SID of the parent [Service](https://www.twilio.com/docs/proxy/api/service) resource.
     * @param string $sessionSid The SID of the parent [Session](https://www.twilio.com/docs/proxy/api/session) resource.
     * @param string $sid The Twilio-provided string that uniquely identifies the Participant resource to delete.
     */
    public function __construct(
        Version $version,
        $serviceSid,
        $sessionSid,
        $sid
    ) {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "serviceSid" => $serviceSid,
            "sessionSid" => $sessionSid,
            "sid" => $sid,
        ];

        $this->uri =
            "/Services/" .
            \rawurlencode($serviceSid) .
            "/Sessions/" .
            \rawurlencode($sessionSid) .
            "/Participants/" .
            \rawurlencode($sid) .
            "";
    }

    /**
     * Delete the ParticipantInstance
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
     * Fetch the ParticipantInstance
     *
     * @return ParticipantInstance Fetched ParticipantInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): ParticipantInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch("GET", $this->uri, [], [], $headers);

        return new ParticipantInstance(
            $this->version,
            $payload,
            $this->solution["serviceSid"],
            $this->solution["sessionSid"],
            $this->solution["sid"]
        );
    }

    /**
     * Access the messageInteractions
     */
    protected function getMessageInteractions(): MessageInteractionList
    {
        if (!$this->_messageInteractions) {
            $this->_messageInteractions = new MessageInteractionList(
                $this->version,
                $this->solution["serviceSid"],
                $this->solution["sessionSid"],
                $this->solution["sid"]
            );
        }

        return $this->_messageInteractions;
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
        return "[Twilio.Proxy.V1.ParticipantContext " .
            \implode(" ", $context) .
            "]";
    }
}
