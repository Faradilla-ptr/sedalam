<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Numbers
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Numbers\V2;

use Twilio\ListResource;
use Twilio\Version;

class BundleCloneList extends ListResource
{
    /**
     * Construct the BundleCloneList
     *
     * @param Version $version Version that contains the resource
     */
    public function __construct(Version $version)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [];
    }

    /**
     * Constructs a BundleCloneContext
     *
     * @param string $bundleSid The unique string that identifies the Bundle to be cloned.
     */
    public function getContext(string $bundleSid): BundleCloneContext
    {
        return new BundleCloneContext($this->version, $bundleSid);
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return "[Twilio.Numbers.V2.BundleCloneList]";
    }
}
