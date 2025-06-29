<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Taskrouter
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Taskrouter\V1\Workspace\Worker;

use Twilio\ListResource;
use Twilio\Version;

class WorkerStatisticsList extends ListResource
{
    /**
     * Construct the WorkerStatisticsList
     *
     * @param Version $version Version that contains the resource
     * @param string $workspaceSid The SID of the Workspace with the WorkerChannel to fetch.
     * @param string $workerSid The SID of the Worker with the WorkerChannel to fetch.
     */
    public function __construct(
        Version $version,
        string $workspaceSid,
        string $workerSid
    ) {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "workspaceSid" => $workspaceSid,

            "workerSid" => $workerSid,
        ];
    }

    /**
     * Constructs a WorkerStatisticsContext
     */
    public function getContext(): WorkerStatisticsContext
    {
        return new WorkerStatisticsContext(
            $this->version,
            $this->solution["workspaceSid"],
            $this->solution["workerSid"]
        );
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return "[Twilio.Taskrouter.V1.WorkerStatisticsList]";
    }
}
