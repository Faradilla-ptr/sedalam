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

namespace Twilio\Rest\Sync\V1\Service\SyncList;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use Twilio\Serialize;

class SyncListItemList extends ListResource
{
    /**
     * Construct the SyncListItemList
     *
     * @param Version $version Version that contains the resource
     * @param string $serviceSid The SID of the [Sync Service](https://www.twilio.com/docs/sync/api/service) to create the new List Item in.
     * @param string $listSid The SID of the Sync List to add the new List Item to. Can be the Sync List resource's `sid` or its `unique_name`.
     */
    public function __construct(
        Version $version,
        string $serviceSid,
        string $listSid
    ) {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "serviceSid" => $serviceSid,

            "listSid" => $listSid,
        ];

        $this->uri =
            "/Services/" .
            \rawurlencode($serviceSid) .
            "/Lists/" .
            \rawurlencode($listSid) .
            "/Items";
    }

    /**
     * Create the SyncListItemInstance
     *
     * @param array $data A JSON string that represents an arbitrary, schema-less object that the List Item stores. Can be up to 16 KiB in length.
     * @param array|Options $options Optional Arguments
     * @return SyncListItemInstance Created SyncListItemInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function create(
        array $data,
        array $options = []
    ): SyncListItemInstance {
        $options = new Values($options);

        $data = Values::of([
            "Data" => Serialize::jsonObject($data),
            "Ttl" => $options["ttl"],
            "ItemTtl" => $options["itemTtl"],
            "CollectionTtl" => $options["collectionTtl"],
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

        return new SyncListItemInstance(
            $this->version,
            $payload,
            $this->solution["serviceSid"],
            $this->solution["listSid"]
        );
    }

    /**
     * Reads SyncListItemInstance records from the API as a list.
     * Unlike stream(), this operation is eager and will load `limit` records into
     * memory before returning.
     *
     * @param array|Options $options Optional Arguments
     * @param int $limit Upper limit for the number of records to return. read()
     *                   guarantees to never return more than limit.  Default is no
     *                   limit
     * @param mixed $pageSize Number of records to fetch per request, when not set
     *                        will use the default value of 50 records.  If no
     *                        page_size is defined but a limit is defined, read()
     *                        will attempt to read the limit with the most
     *                        efficient page size, i.e. min(limit, 1000)
     * @return SyncListItemInstance[] Array of results
     */
    public function read(
        array $options = [],
        int $limit = null,
        $pageSize = null
    ): array {
        return \iterator_to_array(
            $this->stream($options, $limit, $pageSize),
            false
        );
    }

    /**
     * Streams SyncListItemInstance records from the API as a generator stream.
     * This operation lazily loads records as efficiently as possible until the
     * limit
     * is reached.
     * The results are returned as a generator, so this operation is memory
     * efficient.
     *
     * @param array|Options $options Optional Arguments
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
    public function stream(
        array $options = [],
        int $limit = null,
        $pageSize = null
    ): Stream {
        $limits = $this->version->readLimits($limit, $pageSize);

        $page = $this->page($options, $limits["pageSize"]);

        return $this->version->stream(
            $page,
            $limits["limit"],
            $limits["pageLimit"]
        );
    }

    /**
     * Retrieve a single page of SyncListItemInstance records from the API.
     * Request is executed immediately
     *
     * @param mixed $pageSize Number of records to return, defaults to 50
     * @param string $pageToken PageToken provided by the API
     * @param mixed $pageNumber Page Number, this value is simply for client state
     * @return SyncListItemPage Page of SyncListItemInstance
     */
    public function page(
        array $options = [],
        $pageSize = Values::NONE,
        string $pageToken = Values::NONE,
        $pageNumber = Values::NONE
    ): SyncListItemPage {
        $options = new Values($options);

        $params = Values::of([
            "Order" => $options["order"],
            "From" => $options["from"],
            "Bounds" => $options["bounds"],
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

        return new SyncListItemPage($this->version, $response, $this->solution);
    }

    /**
     * Retrieve a specific page of SyncListItemInstance records from the API.
     * Request is executed immediately
     *
     * @param string $targetUrl API-generated URL for the requested results page
     * @return SyncListItemPage Page of SyncListItemInstance
     */
    public function getPage(string $targetUrl): SyncListItemPage
    {
        $response = $this->version
            ->getDomain()
            ->getClient()
            ->request("GET", $targetUrl);

        return new SyncListItemPage($this->version, $response, $this->solution);
    }

    /**
     * Constructs a SyncListItemContext
     *
     * @param int $index The index of the Sync List Item resource to delete.
     */
    public function getContext(int $index): SyncListItemContext
    {
        return new SyncListItemContext(
            $this->version,
            $this->solution["serviceSid"],
            $this->solution["listSid"],
            $index
        );
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return "[Twilio.Sync.V1.SyncListItemList]";
    }
}
