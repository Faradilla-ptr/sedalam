<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Preview
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Preview\Marketplace;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use Twilio\Serialize;

class InstalledAddOnList extends ListResource
{
    /**
     * Construct the InstalledAddOnList
     *
     * @param Version $version Version that contains the resource
     */
    public function __construct(Version $version)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [];

        $this->uri = "/InstalledAddOns";
    }

    /**
     * Create the InstalledAddOnInstance
     *
     * @param string $availableAddOnSid The SID of the AvaliableAddOn to install.
     * @param bool $acceptTermsOfService Whether the Terms of Service were accepted.
     * @param array|Options $options Optional Arguments
     * @return InstalledAddOnInstance Created InstalledAddOnInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function create(
        string $availableAddOnSid,
        bool $acceptTermsOfService,
        array $options = []
    ): InstalledAddOnInstance {
        $options = new Values($options);

        $data = Values::of([
            "AvailableAddOnSid" => $availableAddOnSid,
            "AcceptTermsOfService" => Serialize::booleanToString(
                $acceptTermsOfService
            ),
            "Configuration" => Serialize::jsonObject($options["configuration"]),
            "UniqueName" => $options["uniqueName"],
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

        return new InstalledAddOnInstance($this->version, $payload);
    }

    /**
     * Reads InstalledAddOnInstance records from the API as a list.
     * Unlike stream(), this operation is eager and will load `limit` records into
     * memory before returning.
     *
     * @param int $limit Upper limit for the number of records to return. read()
     *                   guarantees to never return more than limit.  Default is no
     *                   limit
     * @param mixed $pageSize Number of records to fetch per request, when not set
     *                        will use the default value of 50 records.  If no
     *                        page_size is defined but a limit is defined, read()
     *                        will attempt to read the limit with the most
     *                        efficient page size, i.e. min(limit, 1000)
     * @return InstalledAddOnInstance[] Array of results
     */
    public function read(int $limit = null, $pageSize = null): array
    {
        return \iterator_to_array($this->stream($limit, $pageSize), false);
    }

    /**
     * Streams InstalledAddOnInstance records from the API as a generator stream.
     * This operation lazily loads records as efficiently as possible until the
     * limit
     * is reached.
     * The results are returned as a generator, so this operation is memory
     * efficient.
     *
     * @param int $limit Upper limit for the number of records to return. stream()
     *                   guarantees to never return more than limit.  Default is no
     *                   limit
     * @param mixed $pageSize Number of records to fetch per request, when not set
     *                        will use the default value of 50 records.  If no
     *                        page_size is defined but a limit is defined, stream()
     *                        will attempt to read the limit with the most
     *                        efficient page size, i.e. min(limit, 1000)
     * @return Stream stream of results
     */
    public function stream(int $limit = null, $pageSize = null): Stream
    {
        $limits = $this->version->readLimits($limit, $pageSize);

        $page = $this->page($limits["pageSize"]);

        return $this->version->stream(
            $page,
            $limits["limit"],
            $limits["pageLimit"]
        );
    }

    /**
     * Retrieve a single page of InstalledAddOnInstance records from the API.
     * Request is executed immediately
     *
     * @param mixed $pageSize Number of records to return, defaults to 50
     * @param string $pageToken PageToken provided by the API
     * @param mixed $pageNumber Page Number, this value is simply for client state
     * @return InstalledAddOnPage Page of InstalledAddOnInstance
     */
    public function page(
        $pageSize = Values::NONE,
        string $pageToken = Values::NONE,
        $pageNumber = Values::NONE
    ): InstalledAddOnPage {
        $params = Values::of([
            "PageToken" => $pageToken,
            "Page" => $pageNumber,
            "PageSize" => $pageSize,
        ]);

        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $response = $this->version->page(
            "GET",
            $this->uri,
            $params,
            [],
            $headers
        );

        return new InstalledAddOnPage(
            $this->version,
            $response,
            $this->solution
        );
    }

    /**
     * Retrieve a specific page of InstalledAddOnInstance records from the API.
     * Request is executed immediately
     *
     * @param string $targetUrl API-generated URL for the requested results page
     * @return InstalledAddOnPage Page of InstalledAddOnInstance
     */
    public function getPage(string $targetUrl): InstalledAddOnPage
    {
        $response = $this->version
            ->getDomain()
            ->getClient()
            ->request("GET", $targetUrl);

        return new InstalledAddOnPage(
            $this->version,
            $response,
            $this->solution
        );
    }

    /**
     * Constructs a InstalledAddOnContext
     *
     * @param string $sid The SID of the InstalledAddOn resource to delete.
     */
    public function getContext(string $sid): InstalledAddOnContext
    {
        return new InstalledAddOnContext($this->version, $sid);
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return "[Twilio.Preview.Marketplace.InstalledAddOnList]";
    }
}
