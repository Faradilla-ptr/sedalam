<?php
/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Flex
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\FlexApi\V1;

use Twilio\Options;
use Twilio\Values;

abstract class InteractionOptions
{
    /**
     * @param array $routing The Interaction's routing logic.
     * @param string $interactionContextSid The Interaction context sid is used for adding a context lookup sid
     * @return CreateInteractionOptions Options builder
     */
    public static function create(
        array $routing = Values::ARRAY_NONE,
        string $interactionContextSid = Values::NONE
    ): CreateInteractionOptions {
        return new CreateInteractionOptions($routing, $interactionContextSid);
    }
}

class CreateInteractionOptions extends Options
{
    /**
     * @param array $routing The Interaction's routing logic.
     * @param string $interactionContextSid The Interaction context sid is used for adding a context lookup sid
     */
    public function __construct(
        array $routing = Values::ARRAY_NONE,
        string $interactionContextSid = Values::NONE
    ) {
        $this->options["routing"] = $routing;
        $this->options["interactionContextSid"] = $interactionContextSid;
    }

    /**
     * The Interaction's routing logic.
     *
     * @param array $routing The Interaction's routing logic.
     * @return $this Fluent Builder
     */
    public function setRouting(array $routing): self
    {
        $this->options["routing"] = $routing;
        return $this;
    }

    /**
     * The Interaction context sid is used for adding a context lookup sid
     *
     * @param string $interactionContextSid The Interaction context sid is used for adding a context lookup sid
     * @return $this Fluent Builder
     */
    public function setInteractionContextSid(
        string $interactionContextSid
    ): self {
        $this->options["interactionContextSid"] = $interactionContextSid;
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
        return "[Twilio.FlexApi.V1.CreateInteractionOptions " . $options . "]";
    }
}
