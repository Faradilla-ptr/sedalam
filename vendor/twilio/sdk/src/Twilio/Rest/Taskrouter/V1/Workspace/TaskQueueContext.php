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

namespace Twilio\Rest\Taskrouter\V1\Workspace;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;
use Twilio\InstanceContext;
use Twilio\Rest\Taskrouter\V1\Workspace\TaskQueue\TaskQueueCumulativeStatisticsList;
use Twilio\Rest\Taskrouter\V1\Workspace\TaskQueue\TaskQueueStatisticsList;
use Twilio\Rest\Taskrouter\V1\Workspace\TaskQueue\TaskQueueRealTimeStatisticsList;

/**
 * @property TaskQueueCumulativeStatisticsList $cumulativeStatistics
 * @property TaskQueueStatisticsList $statistics
 * @property TaskQueueRealTimeStatisticsList $realTimeStatistics
 * @method \Twilio\Rest\Taskrouter\V1\Workspace\TaskQueue\TaskQueueCumulativeStatisticsContext cumulativeStatistics()
 * @method \Twilio\Rest\Taskrouter\V1\Workspace\TaskQueue\TaskQueueStatisticsContext statistics()
 * @method \Twilio\Rest\Taskrouter\V1\Workspace\TaskQueue\TaskQueueRealTimeStatisticsContext realTimeStatistics()
 */
class TaskQueueContext extends InstanceContext
{
    protected $_cumulativeStatistics;
    protected $_statistics;
    protected $_realTimeStatistics;

    /**
     * Initialize the TaskQueueContext
     *
     * @param Version $version Version that contains the resource
     * @param string $workspaceSid The SID of the Workspace that the new TaskQueue belongs to.
     * @param string $sid The SID of the TaskQueue resource to delete.
     */
    public function __construct(Version $version, $workspaceSid, $sid)
    {
        parent::__construct($version);

        // Path Solution
        $this->solution = [
            "workspaceSid" => $workspaceSid,
            "sid" => $sid,
        ];

        $this->uri =
            "/Workspaces/" .
            \rawurlencode($workspaceSid) .
            "/TaskQueues/" .
            \rawurlencode($sid) .
            "";
    }

    /**
     * Delete the TaskQueueInstance
     *
     * @return bool True if delete succeeds, false otherwise
     * @throws TwilioException When an HTTP error occurs.
     */
    public function delete(): bool
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
        ]);
        return $this->version->delete("DELETE", $this->uri, [], [], $headers);
    }

    /**
     * Fetch the TaskQueueInstance
     *
     * @return TaskQueueInstance Fetched TaskQueueInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(): TaskQueueInstance
    {
        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->fetch("GET", $this->uri, [], [], $headers);

        return new TaskQueueInstance(
            $this->version,
            $payload,
            $this->solution["workspaceSid"],
            $this->solution["sid"]
        );
    }

    /**
     * Update the TaskQueueInstance
     *
     * @param array|Options $options Optional Arguments
     * @return TaskQueueInstance Updated TaskQueueInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function update(array $options = []): TaskQueueInstance
    {
        $options = new Values($options);

        $data = Values::of([
            "FriendlyName" => $options["friendlyName"],
            "TargetWorkers" => $options["targetWorkers"],
            "ReservationActivitySid" => $options["reservationActivitySid"],
            "AssignmentActivitySid" => $options["assignmentActivitySid"],
            "MaxReservedWorkers" => $options["maxReservedWorkers"],
            "TaskOrder" => $options["taskOrder"],
        ]);

        $headers = Values::of([
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept" => "application/json",
        ]);
        $payload = $this->version->update(
            "POST",
            $this->uri,
            [],
            $data,
            $headers
        );

        return new TaskQueueInstance(
            $this->version,
            $payload,
            $this->solution["workspaceSid"],
            $this->solution["sid"]
        );
    }

    /**
     * Access the cumulativeStatistics
     */
    protected function getCumulativeStatistics(): TaskQueueCumulativeStatisticsList
    {
        if (!$this->_cumulativeStatistics) {
            $this->_cumulativeStatistics = new TaskQueueCumulativeStatisticsList(
                $this->version,
                $this->solution["workspaceSid"],
                $this->solution["sid"]
            );
        }

        return $this->_cumulativeStatistics;
    }

    /**
     * Access the statistics
     */
    protected function getStatistics(): TaskQueueStatisticsList
    {
        if (!$this->_statistics) {
            $this->_statistics = new TaskQueueStatisticsList(
                $this->version,
                $this->solution["workspaceSid"],
                $this->solution["sid"]
            );
        }

        return $this->_statistics;
    }

    /**
     * Access the realTimeStatistics
     */
    protected function getRealTimeStatistics(): TaskQueueRealTimeStatisticsList
    {
        if (!$this->_realTimeStatistics) {
            $this->_realTimeStatistics = new TaskQueueRealTimeStatisticsList(
                $this->version,
                $this->solution["workspaceSid"],
                $this->solution["sid"]
            );
        }

        return $this->_realTimeStatistics;
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
        return "[Twilio.Taskrouter.V1.TaskQueueContext " .
            \implode(" ", $context) .
            "]";
    }
}
