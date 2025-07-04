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

namespace Twilio\Rest\Taskrouter\V1\Workspace\Workflow;

use Twilio\ListResource;
use Twilio\Version;

class WorkflowRealTimeStatisticsList extends ListResource
{
    /**
     * Construct the WorkflowRealTimeStatisticsList
     *
     * @param Version $version Version that contains the resource
     * @param string $workspaceSid The SID of the Workspace with the Workflow to fetch.
     * @param string $workflowSid Returns the list of Tasks that are being controlled by the Workflow with the specified SID value.
     */
    public function __construct(
        Version $version,
        string $workspaceSid,
        string $workflowSid
    ) {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "workspaceSid" => $workspaceSid,

            "workflowSid" => $workflowSid,
        ];
    }

    /**
     * Constructs a WorkflowRealTimeStatisticsContext
     */
    public function getContext(): WorkflowRealTimeStatisticsContext
    {
        return new WorkflowRealTimeStatisticsContext(
            $this->version,
            $this->solution["workspaceSid"],
            $this->solution["workflowSid"]
        );
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return "[Twilio.Taskrouter.V1.WorkflowRealTimeStatisticsList]";
    }
}
