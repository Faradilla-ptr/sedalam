<?php
/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Voice
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Voice\V1\ConnectionPolicy;

use Twilio\Options;
use Twilio\Values;

abstract class ConnectionPolicyTargetOptions
{
    /**
     * @param string $friendlyName A descriptive string that you create to describe the resource. It is not unique and can be up to 255 characters long.
     * @param int $priority The relative importance of the target. Can be an integer from 0 to 65535, inclusive, and the default is 10. The lowest number represents the most important target.
     * @param int $weight The value that determines the relative share of the load the Target should receive compared to other Targets with the same priority. Can be an integer from 1 to 65535, inclusive, and the default is 10. Targets with higher values receive more load than those with lower ones with the same priority.
     * @param bool $enabled Whether the Target is enabled. The default is `true`.
     * @return CreateConnectionPolicyTargetOptions Options builder
     */
    public static function create(
        string $friendlyName = Values::NONE,
        int $priority = Values::INT_NONE,
        int $weight = Values::INT_NONE,
        bool $enabled = Values::BOOL_NONE
    ): CreateConnectionPolicyTargetOptions {
        return new CreateConnectionPolicyTargetOptions(
            $friendlyName,
            $priority,
            $weight,
            $enabled
        );
    }

    /**
     * @param string $friendlyName A descriptive string that you create to describe the resource. It is not unique and can be up to 255 characters long.
     * @param string $target The SIP address you want Twilio to route your calls to. This must be a `sip:` schema. `sips` is NOT supported.
     * @param int $priority The relative importance of the target. Can be an integer from 0 to 65535, inclusive. The lowest number represents the most important target.
     * @param int $weight The value that determines the relative share of the load the Target should receive compared to other Targets with the same priority. Can be an integer from 1 to 65535, inclusive. Targets with higher values receive more load than those with lower ones with the same priority.
     * @param bool $enabled Whether the Target is enabled.
     * @return UpdateConnectionPolicyTargetOptions Options builder
     */
    public static function update(
        string $friendlyName = Values::NONE,
        string $target = Values::NONE,
        int $priority = Values::INT_NONE,
        int $weight = Values::INT_NONE,
        bool $enabled = Values::BOOL_NONE
    ): UpdateConnectionPolicyTargetOptions {
        return new UpdateConnectionPolicyTargetOptions(
            $friendlyName,
            $target,
            $priority,
            $weight,
            $enabled
        );
    }
}

class CreateConnectionPolicyTargetOptions extends Options
{
    /**
     * @param string $friendlyName A descriptive string that you create to describe the resource. It is not unique and can be up to 255 characters long.
     * @param int $priority The relative importance of the target. Can be an integer from 0 to 65535, inclusive, and the default is 10. The lowest number represents the most important target.
     * @param int $weight The value that determines the relative share of the load the Target should receive compared to other Targets with the same priority. Can be an integer from 1 to 65535, inclusive, and the default is 10. Targets with higher values receive more load than those with lower ones with the same priority.
     * @param bool $enabled Whether the Target is enabled. The default is `true`.
     */
    public function __construct(
        string $friendlyName = Values::NONE,
        int $priority = Values::INT_NONE,
        int $weight = Values::INT_NONE,
        bool $enabled = Values::BOOL_NONE
    ) {
        $this->options["friendlyName"] = $friendlyName;
        $this->options["priority"] = $priority;
        $this->options["weight"] = $weight;
        $this->options["enabled"] = $enabled;
    }

    /**
     * A descriptive string that you create to describe the resource. It is not unique and can be up to 255 characters long.
     *
     * @param string $friendlyName A descriptive string that you create to describe the resource. It is not unique and can be up to 255 characters long.
     * @return $this Fluent Builder
     */
    public function setFriendlyName(string $friendlyName): self
    {
        $this->options["friendlyName"] = $friendlyName;
        return $this;
    }

    /**
     * The relative importance of the target. Can be an integer from 0 to 65535, inclusive, and the default is 10. The lowest number represents the most important target.
     *
     * @param int $priority The relative importance of the target. Can be an integer from 0 to 65535, inclusive, and the default is 10. The lowest number represents the most important target.
     * @return $this Fluent Builder
     */
    public function setPriority(int $priority): self
    {
        $this->options["priority"] = $priority;
        return $this;
    }

    /**
     * The value that determines the relative share of the load the Target should receive compared to other Targets with the same priority. Can be an integer from 1 to 65535, inclusive, and the default is 10. Targets with higher values receive more load than those with lower ones with the same priority.
     *
     * @param int $weight The value that determines the relative share of the load the Target should receive compared to other Targets with the same priority. Can be an integer from 1 to 65535, inclusive, and the default is 10. Targets with higher values receive more load than those with lower ones with the same priority.
     * @return $this Fluent Builder
     */
    public function setWeight(int $weight): self
    {
        $this->options["weight"] = $weight;
        return $this;
    }

    /**
     * Whether the Target is enabled. The default is `true`.
     *
     * @param bool $enabled Whether the Target is enabled. The default is `true`.
     * @return $this Fluent Builder
     */
    public function setEnabled(bool $enabled): self
    {
        $this->options["enabled"] = $enabled;
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
        return "[Twilio.Voice.V1.CreateConnectionPolicyTargetOptions " .
            $options .
            "]";
    }
}

class UpdateConnectionPolicyTargetOptions extends Options
{
    /**
     * @param string $friendlyName A descriptive string that you create to describe the resource. It is not unique and can be up to 255 characters long.
     * @param string $target The SIP address you want Twilio to route your calls to. This must be a `sip:` schema. `sips` is NOT supported.
     * @param int $priority The relative importance of the target. Can be an integer from 0 to 65535, inclusive. The lowest number represents the most important target.
     * @param int $weight The value that determines the relative share of the load the Target should receive compared to other Targets with the same priority. Can be an integer from 1 to 65535, inclusive. Targets with higher values receive more load than those with lower ones with the same priority.
     * @param bool $enabled Whether the Target is enabled.
     */
    public function __construct(
        string $friendlyName = Values::NONE,
        string $target = Values::NONE,
        int $priority = Values::INT_NONE,
        int $weight = Values::INT_NONE,
        bool $enabled = Values::BOOL_NONE
    ) {
        $this->options["friendlyName"] = $friendlyName;
        $this->options["target"] = $target;
        $this->options["priority"] = $priority;
        $this->options["weight"] = $weight;
        $this->options["enabled"] = $enabled;
    }

    /**
     * A descriptive string that you create to describe the resource. It is not unique and can be up to 255 characters long.
     *
     * @param string $friendlyName A descriptive string that you create to describe the resource. It is not unique and can be up to 255 characters long.
     * @return $this Fluent Builder
     */
    public function setFriendlyName(string $friendlyName): self
    {
        $this->options["friendlyName"] = $friendlyName;
        return $this;
    }

    /**
     * The SIP address you want Twilio to route your calls to. This must be a `sip:` schema. `sips` is NOT supported.
     *
     * @param string $target The SIP address you want Twilio to route your calls to. This must be a `sip:` schema. `sips` is NOT supported.
     * @return $this Fluent Builder
     */
    public function setTarget(string $target): self
    {
        $this->options["target"] = $target;
        return $this;
    }

    /**
     * The relative importance of the target. Can be an integer from 0 to 65535, inclusive. The lowest number represents the most important target.
     *
     * @param int $priority The relative importance of the target. Can be an integer from 0 to 65535, inclusive. The lowest number represents the most important target.
     * @return $this Fluent Builder
     */
    public function setPriority(int $priority): self
    {
        $this->options["priority"] = $priority;
        return $this;
    }

    /**
     * The value that determines the relative share of the load the Target should receive compared to other Targets with the same priority. Can be an integer from 1 to 65535, inclusive. Targets with higher values receive more load than those with lower ones with the same priority.
     *
     * @param int $weight The value that determines the relative share of the load the Target should receive compared to other Targets with the same priority. Can be an integer from 1 to 65535, inclusive. Targets with higher values receive more load than those with lower ones with the same priority.
     * @return $this Fluent Builder
     */
    public function setWeight(int $weight): self
    {
        $this->options["weight"] = $weight;
        return $this;
    }

    /**
     * Whether the Target is enabled.
     *
     * @param bool $enabled Whether the Target is enabled.
     * @return $this Fluent Builder
     */
    public function setEnabled(bool $enabled): self
    {
        $this->options["enabled"] = $enabled;
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
        return "[Twilio.Voice.V1.UpdateConnectionPolicyTargetOptions " .
            $options .
            "]";
    }
}
