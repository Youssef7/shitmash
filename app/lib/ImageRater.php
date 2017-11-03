<?php

abstract class ImageRater {

	/**
	 * First contender/image.
	 *
	 * @var Image Object
	 */
	public $image_a;

	/**
	 * Second contender/image.
	 *
	 * @var Image Object
	 */
	public $image_b;

	/**
	 * Retrieve Image instance.
	 *
	 * @param int $id Image id.
	 * @return Image|false Image object, false otherwise.
	 */
	public function __construct() {
		
	}

	/**
	 * The abstract rating method to be defined by a subclass rater
	 *
	 * @abstract
	 *
	 * @param int $id Image id.
	 * @return Image|false Image object, false otherwise.
	 */
	public abstract function rate();
}