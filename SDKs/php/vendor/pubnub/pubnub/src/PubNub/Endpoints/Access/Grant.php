<?php

namespace PubNub\Endpoints\Access;

use PubNub\Endpoints\Endpoint;
use PubNub\Exceptions\PubNubValidationException;
use PubNub\Models\Consumer\AccessManager\PNAccessManagerGrantResult;
use PubNub\PubNubUtil;
use PubNub\Enums\PNHttpMethod;
use PubNub\Enums\PNOperationType;


class Grant extends Endpoint
{
    const PATH = "/v1/auth/grant/sub-key/%s";

    /** @var string[] */
    protected $authKeys = [];

    /** @var string[] */
    protected $channels = [];

    /** @var string[] */
    protected $groups = [];

    /** @var  bool */
    protected $read;

    /** @var  bool */
    protected $write;

    /** @var  bool */
    protected $manage;

    /** @var  int */
    protected $ttl;

    /**
     * @param string|string[] $authKeys
     * @return $this
     */
    public function authKeys($authKeys)
    {
        $this->authKeys = PubNubUtil::extendArray($this->authKeys, $authKeys);
        return $this;
    }

    /**
     * @param string|string[] $channels
     * @return $this
     */
    public function channels($channels)
    {
        $this->channels = PubNubUtil::extendArray($this->channels, $channels);
        return $this;
    }

    /**
     * @param string[]|string $channelsGroups
     * @return $this
     */
    public function channelGroups($channelsGroups)
    {
        $this->groups = PubNubUtil::extendArray($this->groups, $channelsGroups);

        return $this;
    }

    /**
     * @param bool $flag
     * @return $this
     */
    public function read($flag)
    {
        $this->read = $flag;

        return $this;
    }

    /**
     * @param bool $flag
     * @return $this
     */
    public function write($flag)
    {
        $this->write = $flag;

        return $this;
    }

    /**
     * @param bool $flag
     * @return $this
     */
    public function manage($flag)
    {
        $this->manage = $flag;

        return $this;
    }

    /**
     * Set time in minutes for which granted permissions are valid
     *
     * Max: 525600
     * Min: 1
     * Default: 1440
     *
     * Setting 0 will apply the grant indefinitely (forever grant).
     *
     * @param int $value
     * @return $this
     */
    public function ttl($value)
    {
        $this->ttl = $value;

        return $this;
    }

    /**
     * @throws PubNubValidationException
     */
    public function validateParams()
    {
        $this->validateSubscribeKey();
        $this->validateSecretKey();

        if ($this->write === null && $this->read === null && $this->manage === null) {
            throw new PubNubValidationException("At least one flag should be specified");
        }
    }

    /**
     * @return array
     */
    public function customParams()
    {
        $params = [];

        if ($this->read !== null) {
            $params["r"] = ($this->read) ? "1" : "0";
        }

        if ($this->write !== null) {
            $params["w"] = ($this->write) ? "1" : "0";
        }

        if ($this->manage !== null) {
            $params["m"] = ($this->manage) ? "1" : "0";
        }

        if (count($this->authKeys) > 0) {
            $params["auth"] = PubNubUtil::joinItems($this->authKeys);
        }

        if (count($this->channels) > 0) {
            $params["channel"] = PubNubUtil::joinItems($this->channels);
        }

        if (count($this->groups) > 0) {
            $params["channel-group"] = PubNubUtil::joinItems($this->groups);
        }

        if ($this->ttl !== null && $this->ttl >= -1) {
            $params["ttl"] = (string) $this->ttl;
        }

        $params['timestamp'] = strval($this->pubnub->timestamp());

        return $params;
    }

    /**
     * @return null
     */
    public function buildData()
    {
        return null;
    }

    /**
     * @return string
     */
    public function buildPath()
    {
        return sprintf(static::PATH, $this->pubnub->getConfiguration()->getSubscribeKey());
    }

    /**
     * @return PNAccessManagerGrantResult
     */
    public function sync()
    {
        return parent::sync();
    }

    /**
     * @param array $json
     * @return PNAccessManagerGrantResult
     */
    public function createResponse($json)
    {
        return PNAccessManagerGrantResult::fromJson($json['payload']);
    }

    /**
     * @return bool
     */
    public function isAuthRequired()
    {
        return false;
    }

    /**
     * @return \string[]
     */
    public function getAffectedChannels()
    {
        return $this->channels;
    }

    /**
     * @return \string[]
     */
    public function getAffectedChannelGroups()
    {
        return $this->groups;
    }

    /**
     * @return int
     */
    public function getRequestTimeout()
    {
        return $this->pubnub->getConfiguration()->getNonSubscribeRequestTimeout();
    }

    /**
     * @return int
     */
    public function getConnectTimeout()
    {
        return $this->pubnub->getConfiguration()->getConnectTimeout();
    }

    /**
     * @return string
     */
    public function httpMethod()
    {
        return PNHttpMethod::GET;
    }

    /**
     * @return int
     */
    public function getOperationType()
    {
        return PNOperationType::PNAccessManagerGrant;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "Grant";
    }
}

