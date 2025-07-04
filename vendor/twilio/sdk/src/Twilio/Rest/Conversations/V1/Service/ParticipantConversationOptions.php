<?php
/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Conversations
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Twilio\Rest\Conversations\V1\Service;

use Twilio\Options;
use Twilio\Values;

abstract class ParticipantConversationOptions
{
    /**
     * @param string $identity A unique string identifier for the conversation participant as [Conversation User](https://www.twilio.com/docs/conversations/api/user-resource). This parameter is non-null if (and only if) the participant is using the Conversations SDK to communicate. Limited to 256 characters.
     * @param string $address A unique string identifier for the conversation participant who's not a Conversation User. This parameter could be found in messaging_binding.address field of Participant resource. It should be url-encoded.
     * @return ReadParticipantConversationOptions Options builder
     */
    public static function read(
        string $identity = Values::NONE,
        string $address = Values::NONE
    ): ReadParticipantConversationOptions {
        return new ReadParticipantConversationOptions($identity, $address);
    }
}

class ReadParticipantConversationOptions extends Options
{
    /**
     * @param string $identity A unique string identifier for the conversation participant as [Conversation User](https://www.twilio.com/docs/conversations/api/user-resource). This parameter is non-null if (and only if) the participant is using the Conversations SDK to communicate. Limited to 256 characters.
     * @param string $address A unique string identifier for the conversation participant who's not a Conversation User. This parameter could be found in messaging_binding.address field of Participant resource. It should be url-encoded.
     */
    public function __construct(
        string $identity = Values::NONE,
        string $address = Values::NONE
    ) {
        $this->options["identity"] = $identity;
        $this->options["address"] = $address;
    }

    /**
     * A unique string identifier for the conversation participant as [Conversation User](https://www.twilio.com/docs/conversations/api/user-resource). This parameter is non-null if (and only if) the participant is using the Conversations SDK to communicate. Limited to 256 characters.
     *
     * @param string $identity A unique string identifier for the conversation participant as [Conversation User](https://www.twilio.com/docs/conversations/api/user-resource). This parameter is non-null if (and only if) the participant is using the Conversations SDK to communicate. Limited to 256 characters.
     * @return $this Fluent Builder
     */
    public function setIdentity(string $identity): self
    {
        $this->options["identity"] = $identity;
        return $this;
    }

    /**
     * A unique string identifier for the conversation participant who's not a Conversation User. This parameter could be found in messaging_binding.address field of Participant resource. It should be url-encoded.
     *
     * @param string $address A unique string identifier for the conversation participant who's not a Conversation User. This parameter could be found in messaging_binding.address field of Participant resource. It should be url-encoded.
     * @return $this Fluent Builder
     */
    public function setAddress(string $address): self
    {
        $this->options["address"] = $address;
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
        return "[Twilio.Conversations.V1.ReadParticipantConversationOptions " .
            $options .
            "]";
    }
}
