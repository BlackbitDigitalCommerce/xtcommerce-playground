<?php 

namespace Shipcloud;

/**
 * Webhooks allow you to subscribe to certain events
 */
class WebhookCreateRequest extends JsonSerializable
{

	/**
	 * @var ArrayObject
	 */
	protected $event_types;

	/**
	 * The unique identifier for a webhook. Will be generated by shipcloud.
	 * 
	 * @var string
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $url;

	/**
	 * Provides the event_types attribute.
	 */
	public function eventTypes() {
		return $this->event_types;
	}

	/**
	 * Provides the id attribute.
	 * The unique identifier for a webhook. Will be generated by shipcloud.
	 */
	public function id() {
		return $this->id;
	}

	/**
	 * Setter for the event_types attribute.
	 * 
	 * @param ArrayObject $value
	 */
	public function setEventTypes(ArrayObject $value) {
		$this->event_types = $value;
		return $this;
	}

	/**
	 * Setter for the id attribute.
	 * The unique identifier for a webhook. Will be generated by shipcloud.
	 * 
	 * @param string $value
	 */
	public function setId($value) {
		$this->id = $value;
		return $this;
	}

	/**
	 * Setter for the url attribute.
	 * 
	 * @param string $value
	 */
	public function setUrl($value) {
		$this->url = $value;
		return $this;
	}

	/**
	 * Provides the url attribute.
	 */
	public function url() {
		return $this->url;
	}
}