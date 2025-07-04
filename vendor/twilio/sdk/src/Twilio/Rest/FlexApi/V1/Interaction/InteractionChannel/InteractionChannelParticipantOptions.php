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

namespace Twilio\Rest\FlexApi\V1\Interaction\InteractionChannel;

use Twilio\Options;
use Twilio\Values;

abstract class InteractionChannelParticipantOptions
{
    /**
     * @param array $routingProperties Object representing the Routing Properties for the new Participant.
     * @return CreateInteractionChannelParticipantOptions Options builder
     */
    public static function create(
        array $routingProperties = Values::ARRAY_NONE
    ): CreateInteractionChannelParticipantOptions {
        return new CreateInteractionChannelParticipantOptions(
            $routingProperties
        );
    }
}

class CreateInteractionChannelParticipantOptions extends Options
{
    /**
     * @param array $routingProperties Object representing the Routing Properties for the new Participant.
     */
    public function __construct(array $routingProperties = Values::ARRAY_NONE)
    {
        $this->options["routingProperties"] = $routingProperties;
    }

    /**
     * Object representing the Routing Properties for the new Participant.
     *
     * @param array $routingProperties Object representing the Routing Properties for the new Participant.
     * @return $this Fluent Builder
     */
    public function setRoutingProperties(array $routingProperties): self
    {
        $this->options["routingProperties"] = $routingProperties;
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
        return "[Twilio.FlexApi.V1.CreateInteractionChannelParticipantOptions " .
            $options .
            "]";
    }
}
