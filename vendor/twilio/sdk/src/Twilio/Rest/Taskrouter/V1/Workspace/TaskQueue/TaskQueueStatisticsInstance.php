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

namespace Twilio\Rest\Taskrouter\V1\Workspace\TaskQueue;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Options;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string|null $accountSid
 * @property array|null $cumulative
 * @property array|null $realtime
 * @property string|null $taskQueueSid
 * @property string|null $workspaceSid
 * @property string|null $url
 */
class TaskQueueStatisticsInstance extends InstanceResource
{
    /**
     * Initialize the TaskQueueStatisticsInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $workspaceSid The SID of the Workspace with the TaskQueue to fetch.
     * @param string $taskQueueSid The SID of the TaskQueue for which to fetch statistics.
     */
    public function __construct(
        Version $version,
        array $payload,
        string $workspaceSid,
        string $taskQueueSid
    ) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            "accountSid" => Values::array_get($payload, "account_sid"),
            "cumulative" => Values::array_get($payload, "cumulative"),
            "realtime" => Values::array_get($payload, "realtime"),
            "taskQueueSid" => Values::array_get($payload, "task_queue_sid"),
            "workspaceSid" => Values::array_get($payload, "workspace_sid"),
            "url" => Values::array_get($payload, "url"),
        ];

        $this->solution = [
            "workspaceSid" => $workspaceSid,
            "taskQueueSid" => $taskQueueSid,
        ];
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     *
     * @return TaskQueueStatisticsContext Context for this TaskQueueStatisticsInstance
     */
    protected function proxy(): TaskQueueStatisticsContext
    {
        if (!$this->context) {
            $this->context = new TaskQueueStatisticsContext(
                $this->version,
                $this->solution["workspaceSid"],
                $this->solution["taskQueueSid"]
            );
        }

        return $this->context;
    }

    /**
     * Fetch the TaskQueueStatisticsInstance
     *
     * @param array|Options $options Optional Arguments
     * @return TaskQueueStatisticsInstance Fetched TaskQueueStatisticsInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch(array $options = []): TaskQueueStatisticsInstance
    {
        return $this->proxy()->fetch($options);
    }

    /**
     * Magic getter to access properties
     *
     * @param string $name Property to access
     * @return mixed The requested property
     * @throws TwilioException For unknown properties
     */
    public function __get(string $name)
    {
        if (\array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        if (\property_exists($this, "_" . $name)) {
            $method = "get" . \ucfirst($name);
            return $this->$method();
        }

        throw new TwilioException("Unknown property: " . $name);
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
        return "[Twilio.Taskrouter.V1.TaskQueueStatisticsInstance " .
            \implode(" ", $context) .
            "]";
    }
}
