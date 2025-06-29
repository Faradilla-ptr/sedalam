<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Voice
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Voice\V1\DialingPermissions;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;
use Twilio\Rest\Voice\V1\DialingPermissions\Country\HighriskSpecialPrefixList;

/**
 * @property HighriskSpecialPrefixList $highriskSpecialPrefixes
 */
class CountryContext extends InstanceContext
{
    protected $_highriskSpecialPrefixes;

    /**
     * Initialize the CountryContext
     *
     * @param Version $version Version that contains the resource
     * @param string $isoCode The [ISO country code](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2) of the DialingPermissions Country resource to fetch
     */
    public function __construct(Version $version, $isoCode)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "isoCode" => $isoCode,
        ];

        $this->uri =
            "/DialingPermissions/Countries/" . \rawurlencode($isoCode) . "";
    }

    /**
     * Fetch the CountryInstance
     *
     * @return CountryInstance Fetched CountryInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): CountryInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch("GET", $this->uri, [], [], $headers);

        return new CountryInstance(
            $this->version,
            $payload,
            $this->solution["isoCode"]
        );
    }

    /**
     * Access the highriskSpecialPrefixes
     */
    protected function getHighriskSpecialPrefixes(): HighriskSpecialPrefixList
    {
        if (!$this->_highriskSpecialPrefixes) {
            $this->_highriskSpecialPrefixes = new HighriskSpecialPrefixList(
                $this->version,
                $this->solution["isoCode"]
            );
        }

        return $this->_highriskSpecialPrefixes;
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
        return "[Twilio.Voice.V1.CountryContext " .
            \implode(" ", $context) .
            "]";
    }
}
