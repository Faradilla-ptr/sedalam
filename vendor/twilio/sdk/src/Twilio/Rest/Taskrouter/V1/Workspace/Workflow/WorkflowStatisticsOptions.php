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

use Twilio\Options;
use Twilio\Values;

abstract class WorkflowStatisticsOptions
{
    /**
     * @param int $minutes Only calculate statistics since this many minutes in the past. The default 15 minutes. This is helpful for displaying statistics for the last 15 minutes, 240 minutes (4 hours), and 480 minutes (8 hours) to see trends.
     * @param \DateTime $startDate Only calculate statistics from this date and time and later, specified in [ISO 8601](https://en.wikipedia.org/wiki/ISO_8601) format.
     * @param \DateTime $endDate Only calculate statistics from this date and time and earlier, specified in GMT as an [ISO 8601](https://en.wikipedia.org/wiki/ISO_8601) date-time.
     * @param string $taskChannel Only calculate real-time statistics on this TaskChannel. Can be the TaskChannel's SID or its `unique_name`, such as `voice`, `sms`, or `default`.
     * @param string $splitByWaitTime A comma separated list of values that describes the thresholds, in seconds, to calculate statistics on. For each threshold specified, the number of Tasks canceled and reservations accepted above and below the specified thresholds in seconds are computed. For example, `5,30` would show splits of Tasks that were canceled or accepted before and after 5 seconds and before and after 30 seconds. This can be used to show short abandoned Tasks or Tasks that failed to meet an SLA.
     * @return FetchWorkflowStatisticsOptions Options builder
     */
    public static function fetch(
        int $minutes = Values::INT_NONE,
        \DateTime $startDate = null,
        \DateTime $endDate = null,
        string $taskChannel = Values::NONE,
        string $splitByWaitTime = Values::NONE
    ): FetchWorkflowStatisticsOptions {
        return new FetchWorkflowStatisticsOptions(
            $minutes,
            $startDate,
            $endDate,
            $taskChannel,
            $splitByWaitTime
        );
    }
}

class FetchWorkflowStatisticsOptions extends Options
{
    /**
     * @param int $minutes Only calculate statistics since this many minutes in the past. The default 15 minutes. This is helpful for displaying statistics for the last 15 minutes, 240 minutes (4 hours), and 480 minutes (8 hours) to see trends.
     * @param \DateTime $startDate Only calculate statistics from this date and time and later, specified in [ISO 8601](https://en.wikipedia.org/wiki/ISO_8601) format.
     * @param \DateTime $endDate Only calculate statistics from this date and time and earlier, specified in GMT as an [ISO 8601](https://en.wikipedia.org/wiki/ISO_8601) date-time.
     * @param string $taskChannel Only calculate real-time statistics on this TaskChannel. Can be the TaskChannel's SID or its `unique_name`, such as `voice`, `sms`, or `default`.
     * @param string $splitByWaitTime A comma separated list of values that describes the thresholds, in seconds, to calculate statistics on. For each threshold specified, the number of Tasks canceled and reservations accepted above and below the specified thresholds in seconds are computed. For example, `5,30` would show splits of Tasks that were canceled or accepted before and after 5 seconds and before and after 30 seconds. This can be used to show short abandoned Tasks or Tasks that failed to meet an SLA.
     */
    public function __construct(
        int $minutes = Values::INT_NONE,
        \DateTime $startDate = null,
        \DateTime $endDate = null,
        string $taskChannel = Values::NONE,
        string $splitByWaitTime = Values::NONE
    ) {
        $this->options["minutes"] = $minutes;
        $this->options["startDate"] = $startDate;
        $this->options["endDate"] = $endDate;
        $this->options["taskChannel"] = $taskChannel;
        $this->options["splitByWaitTime"] = $splitByWaitTime;
    }

    /**
     * Only calculate statistics since this many minutes in the past. The default 15 minutes. This is helpful for displaying statistics for the last 15 minutes, 240 minutes (4 hours), and 480 minutes (8 hours) to see trends.
     *
     * @param int $minutes Only calculate statistics since this many minutes in the past. The default 15 minutes. This is helpful for displaying statistics for the last 15 minutes, 240 minutes (4 hours), and 480 minutes (8 hours) to see trends.
     * @return $this Fluent Builder
     */
    public function setMinutes(int $minutes): self
    {
        $this->options["minutes"] = $minutes;
        return $this;
    }

    /**
     * Only calculate statistics from this date and time and later, specified in [ISO 8601](https://en.wikipedia.org/wiki/ISO_8601) format.
     *
     * @param \DateTime $startDate Only calculate statistics from this date and time and later, specified in [ISO 8601](https://en.wikipedia.org/wiki/ISO_8601) format.
     * @return $this Fluent Builder
     */
    public function setStartDate(\DateTime $startDate): self
    {
        $this->options["startDate"] = $startDate;
        return $this;
    }

    /**
     * Only calculate statistics from this date and time and earlier, specified in GMT as an [ISO 8601](https://en.wikipedia.org/wiki/ISO_8601) date-time.
     *
     * @param \DateTime $endDate Only calculate statistics from this date and time and earlier, specified in GMT as an [ISO 8601](https://en.wikipedia.org/wiki/ISO_8601) date-time.
     * @return $this Fluent Builder
     */
    public function setEndDate(\DateTime $endDate): self
    {
        $this->options["endDate"] = $endDate;
        return $this;
    }

    /**
     * Only calculate real-time statistics on this TaskChannel. Can be the TaskChannel's SID or its `unique_name`, such as `voice`, `sms`, or `default`.
     *
     * @param string $taskChannel Only calculate real-time statistics on this TaskChannel. Can be the TaskChannel's SID or its `unique_name`, such as `voice`, `sms`, or `default`.
     * @return $this Fluent Builder
     */
    public function setTaskChannel(string $taskChannel): self
    {
        $this->options["taskChannel"] = $taskChannel;
        return $this;
    }

    /**
     * A comma separated list of values that describes the thresholds, in seconds, to calculate statistics on. For each threshold specified, the number of Tasks canceled and reservations accepted above and below the specified thresholds in seconds are computed. For example, `5,30` would show splits of Tasks that were canceled or accepted before and after 5 seconds and before and after 30 seconds. This can be used to show short abandoned Tasks or Tasks that failed to meet an SLA.
     *
     * @param string $splitByWaitTime A comma separated list of values that describes the thresholds, in seconds, to calculate statistics on. For each threshold specified, the number of Tasks canceled and reservations accepted above and below the specified thresholds in seconds are computed. For example, `5,30` would show splits of Tasks that were canceled or accepted before and after 5 seconds and before and after 30 seconds. This can be used to show short abandoned Tasks or Tasks that failed to meet an SLA.
     * @return $this Fluent Builder
     */
    public function setSplitByWaitTime(string $splitByWaitTime): self
    {
        $this->options["splitByWaitTime"] = $splitByWaitTime;
        return $this;
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        $options = \http_build_query(Values::of($this->options), "", " ");
        return "[Twilio.Taskrouter.V1.FetchWorkflowStatisticsOptions " .
            $options .
            "]";
    }
}
