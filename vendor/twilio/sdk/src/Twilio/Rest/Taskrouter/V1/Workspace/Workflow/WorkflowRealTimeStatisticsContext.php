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

use Twilio\Exceptions\TwilioException;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;

class WorkflowRealTimeStatisticsContext extends InstanceContext
{
    /**
     * Initialize the WorkflowRealTimeStatisticsContext
     *
     * @param Version $version Version that contains the resource
     * @param string $workspaceSid The SID of the Workspace with the Workflow to fetch.
     * @param string $workflowSid Returns the list of Tasks that are being controlled by the Workflow with the specified SID value.
     */
    public function __construct(Version $version, $workspaceSid, $workflowSid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "workspaceSid" => $workspaceSid,
            "workflowSid" => $workflowSid,
        ];

        $this->uri =
            "/Workspaces/" .
            \rawurlencode($workspaceSid) .
            "/Workflows/" .
            \rawurlencode($workflowSid) .
            "/RealTimeStatistics";
    }

    /**
     * Fetch the WorkflowRealTimeStatisticsInstance
     *
     * @param array|Options $options Optional Arguments
     * @return WorkflowRealTimeStatisticsInstance Fetched WorkflowRealTimeStatisticsInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(
        array $options = []
    ): WorkflowRealTimeStatisticsInstance {
        $options = new Values($options);

        $params = Values::of([
            "TaskChannel" => $options["taskChannel"],
        ]);

        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch(
            "GET",
            $this->uri,
            $params,
            [],
            $headers
        );

        return new WorkflowRealTimeStatisticsInstance(
            $this->version,
            $payload,
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
        $context = [];
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return "[Twilio.Taskrouter.V1.WorkflowRealTimeStatisticsContext " .
            \implode(" ", $context) .
            "]";
    }
}
