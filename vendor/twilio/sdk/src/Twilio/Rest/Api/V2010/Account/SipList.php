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

namespace Twilio\Rest\Api\V2010\Account;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Version;
use Twilio\InstanceContext;
use Twilio\Rest\Api\V2010\Account\Sip\DomainList;
use Twilio\Rest\Api\V2010\Account\Sip\CredentialListList;
use Twilio\Rest\Api\V2010\Account\Sip\IpAccessControlListList;

/**
 * @property DomainList $domains
 * @property CredentialListList $credentialLists
 * @property IpAccessControlListList $ipAccessControlLists
 * @method \Twilio\Rest\Api\V2010\Account\Sip\DomainContext domains(string $sid)
 * @method \Twilio\Rest\Api\V2010\Account\Sip\CredentialListContext credentialLists(string $sid)
 * @method \Twilio\Rest\Api\V2010\Account\Sip\IpAccessControlListContext ipAccessControlLists(string $sid)
 */
class SipList extends ListResource
{
    protected $_domains = null;
    protected $_credentialLists = null;
    protected $_ipAccessControlLists = null;

    /**
     * Construct the SipList
     *
     * @param Version $version Version that contains the resource
     * @param string $accountSid The SID of the [Account](https://www.twilio.com/docs/iam/api/account) that created the SipDomain resources to read.
     */
    public function __construct(Version $version, string $accountSid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "accountSid" => $accountSid,
        ];
    }

    /**
     * Access the domains
     */
    protected function getDomains(): DomainList
    {
        if (!$this->_domains) {
            $this->_domains = new DomainList(
                $this->version,
                $this->solution["accountSid"]
            );
        }
        return $this->_domains;
    }

    /**
     * Access the credentialLists
     */
    protected function getCredentialLists(): CredentialListList
    {
        if (!$this->_credentialLists) {
            $this->_credentialLists = new CredentialListList(
                $this->version,
                $this->solution["accountSid"]
            );
        }
        return $this->_credentialLists;
    }

    /**
     * Access the ipAccessControlLists
     */
    protected function getIpAccessControlLists(): IpAccessControlListList
    {
        if (!$this->_ipAccessControlLists) {
            $this->_ipAccessControlLists = new IpAccessControlListList(
                $this->version,
                $this->solution["accountSid"]
            );
        }
        return $this->_ipAccessControlLists;
    }

    /**
     * Magic getter to lazy load subresources
     *
     * @param string $name Subresource to return
     * @return \Twilio\ListResource The requested subresource
     * @throws TwilioException For unknown subresources
     */
    public function __get(string $name)
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
        return "[Twilio.Api.V2010.SipList]";
    }
}
