<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Messaging
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Messaging\V1;

use Twilio\ListResource;
use Twilio\Version;

class LinkshorteningMessagingServiceDomainAssociationList extends ListResource
{
    /**
     * Construct the LinkshorteningMessagingServiceDomainAssociationList
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
     * Constructs a LinkshorteningMessagingServiceDomainAssociationContext
     *
     * @param string $messagingServiceSid Unique string used to identify the Messaging service that this domain should be associated with.
     */
    public function getContext(
        string $messagingServiceSid
    ): LinkshorteningMessagingServiceDomainAssociationContext {
        return new LinkshorteningMessagingServiceDomainAssociationContext(
            $this->version,
            $messagingServiceSid
        );
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return "[Twilio.Messaging.V1.LinkshorteningMessagingServiceDomainAssociationList]";
    }
}
