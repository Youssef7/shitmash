<?php

class Image {

	/**
	 * ID of image.
	 *
	 * @var int
	 */
	public $id;

	/**
	 * The image's name (example.png).
	 *
	 * @var string
	 */
	public $name = '';

	/**
	 * Rating of image.
	 *
	 * @var int
	 */
	public $rating;

	/**
	 * How many times this image won.
	 *
	 * @var int
	 */
	public $wins;

	/**
	 * How many times this image lost.
	 *
	 * @var int
	 */
	public $losses;	

	/**
	 * Retrieve Image instance.
	 *
	 * @static
	 *
	 * @param int $id Image id.
	 * @return Image|false Image object, false otherwise.
	 */
	public static function get_instance($id) {
		
	}


}