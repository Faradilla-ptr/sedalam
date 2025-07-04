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

namespace Twilio\Rest\Proxy\V1\Service;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Stream;
use Twilio\Values;
use Twilio\Version;
use Twilio\Serialize;

class SessionList extends ListResource
{
    /**
     * Construct the SessionList
     *
     * @param Version $version Version that contains the resource
     * @param string $serviceSid The SID of the parent [Service](https://www.twilio.com/docs/proxy/api/service) resource.
     */
    public function __construct(Version $version, string $serviceSid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "serviceSid" => $serviceSid,
        ];

        $this->uri = "/Services/" . \rawurlencode($serviceSid) . "/Sessions";
    }

    /**
     * Create the SessionInstance
     *
     * @param array|Options $options Optional Arguments
     * @return SessionInstance Created SessionInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function create(array $options = []): SessionInstance
    {
        $options = new Values($options);

        $data = Values::of([
            "UniqueName" => $options["uniqueName"],
            "DateExpiry" => Serialize::iso8601DateTime($options["dateExpiry"]),
            "Ttl" => $options["ttl"],
            "Mode" => $options["mode"],
            "Status" => $options["status"],
            "Participants" => Serialize::map(
                $options["participants"],
                function ($e) {
                    return Serialize::jsonObject($e);
                }
            ),
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

        return new SessionInstance(
            $this->version,
            $payload,
            $this->solution["serviceSid"]
        );
    }

    /**
     * Reads SessionInstance records from the API as a list.
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
     * @return SessionInstance[] Array of results
     */
    public function read(int $limit = null, $pageSize = null): array
    {
        return \iterator_to_array($this->stream($limit, $pageSize), false);
    }

    /**
     * Streams SessionInstance records from the API as a generator stream.
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
     * Retrieve a single page of SessionInstance records from the API.
     * Request is executed immediately
     *
     * @param mixed $pageSize Number of records to return, defaults to 50
     * @param string $pageToken PageToken provided by the API
     * @param mixed $pageNumber Page Number, this value is simply for client state
     * @return SessionPage Page of SessionInstance
     */
    public function page(
        $pageSize = Values::NONE,
        string $pageToken = Values::NONE,
        $pageNumber = Values::NONE
    ): SessionPage {
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

        return new SessionPage($this->version, $response, $this->solution);
    }

    /**
     * Retrieve a specific page of SessionInstance records from the API.
     * Request is executed immediately
     *
     * @param string $targetUrl API-generated URL for the requested results page
     * @return SessionPage Page of SessionInstance
     */
    public function getPage(string $targetUrl): SessionPage
    {
        $response = $this->version
            ->getDomain()
            ->getClient()
            ->request("GET", $targetUrl);

        return new SessionPage($this->version, $response, $this->solution);
    }

    /**
     * Constructs a SessionContext
     *
     * @param string $sid The Twilio-provided string that uniquely identifies the Session resource to delete.
     */
    public function getContext(string $sid): SessionContext
    {
        return new SessionContext(
            $this->version,
            $this->solution["serviceSid"],
            $sid
        );
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return "[Twilio.Proxy.V1.SessionList]";
    }
}
