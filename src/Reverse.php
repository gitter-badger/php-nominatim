<?php
/**
 * Class Reverse
 *
 * @package      maxh\nominatim
 * @author       Maxime Hélias <maximehelias16@gmail.com>
 */

namespace maxh\Nominatim;

use maxh\Nominatim\Exceptions\InvalidParameterException;

/**
 * Reverse Geocoding a OSM nominatim service for places.
 *
 * @see http://wiki.openstreetmap.org/wiki/Nominatim
 */
class Reverse implements QueryInterface
{
	use QueryTrait;

	/**
	 * Output format accepted
	 * @var array
	 */
	public $accepteFormat = ['xml', 'json'];

	/**
	 * OSM Type accepted (Node/Way/Relation)
	 * @var array
	 */
	public $osmType = ['N', 'W', 'R'];

	/**
	 * Outpu polygon format accepted
	 * @var array
	 */
	public $polygon = ['geojson', 'kml', 'svg', 'text'];


	/**
	 * Constructo
	 * @param array $query Default value for this query
	 */
	public function __construct(array $query = [])
	{
		if(!isset($query['format']))
		{
			//Default format
			$query['format'] = 'json';
		}

		$this->setPath('reverse');
		$this->setQuery($query);
		$this->setFormat($query['format']);

	}

	// -- Builder methods ------------------------------------------------------

	/**
	 * Format returning by the request.
	 *
	 * @param  string $format The output format for the request
	 * 
	 * @return maxh\Nominatim\Reverse
	 * @throws maxh\Nominatim\Exceptions\InvalidParameterException  if format is not supported
	 */
	public function format($format)
	{
		$format = strtolower($format);

		if(in_array($format, $this->accepteFormat))
		{
			$this->query['format'] = $format;
			$this->setFormat($format);

			return $this;
		}

		throw new InvalidParameterException("Format is not supported");
	}

	/**
	 * Preferred language order for showing search results, overrides the value
	 * specified in the "Accept-Language" HTTP header. Either uses standard
	 * rfc2616 accept-language string or a simple comma separated list of
	 * language codes.
	 *
	 * @param  string $language         Preferred language order for showing search results, overrides the value specified in the "Accept-Language" HTTP header.
	 * Either uses standard rfc2616 accept-language string or a simple comma separated list of language codes.
	 * 
	 * @return maxh\Nominatim\Reverse
	 */
	public function language($language)
	{
		$this->query['accept-language'] = $language;

		return $this;
	}

	/**
	 * [osmType description]
	 * 
	 * @param  string $type
	 * 
	 * @return maxh\Nominatim\Reverse
	 * @throws maxh\Nominatim\Exceptions\InvalidParameterException  if osm type is not supported
	 */
	public function osmType($type)
	{
		if(in_array($type, $this->osmType))
		{
			$this->query['osm_type'] = $type;

			return $this;
		}

		throw new InvalidParameterException("OSM Type is not supported");

	}

	/**
	 * A specific osm node / way / relation to return an address for.
	 * 
	 * @param  integer $id
	 * 
	 * @return maxh\Nominatim\Reverse
	 */
	public function osmId($id)
	{
		$this->query['osm_id'] = $id;

		return $this;
	}

	/**
	 * The location to generate an address for
	 * 
	 * @param  float $lat The latitude
	 * @param  float $lon The longitude
	 * 
	 * @return maxh\Nominatim\Reverse
	 */
	public function latlon($lat, $lon)
	{
		$this->query['lat'] = $lat;

		$this->query['lon'] = $lon;

		return $this;
	}

	/**
	 * Level of detail required where 0 is country and 18 is house/building
	 * 
	 * @param  integer $zoom 
	 * 
	 * @return maxh\Nominatim\Reverse
	 */
	public function zoom($zoom)
	{
		$this->query['zoom'] = strval($zoom);

		return $this;
	}

	/**
	 * Include a breakdown of the address into elements.
	 *
	 * @param  boolean $details
	 * 
	 * @return maxh\Nominatim\Reverse
	 */
	public function addressDetails($details = true)
	{
		$this->query['addressdetails'] = $details ? "1" : "0";

		return $this;
	}

	/**
	 * Output format for the geometry of results
	 * 
	 * @param  string $polygon
	 * 
	 * @return maxh\Nominatim\Reverse
	 * @throws maxh\Nominatim\Exceptions\InvalidParameterException  if polygon format is not supported
	 */
	public function polygon($polygon)
	{
		if(in_array($polygon, $this->polygon))
		{
			$this->query['polygon_'.$polygon] = "1";

			return $this;
		}

		throw new InvalidParameterException("This polygon format is not supported");
	}

	/**
	 * Include additional information in the result if available
	 * 
	 * @param  boolean $tags 
	 * 
	 * @return maxh\Nominatim\Reverse
	 */
	public function extraTags($tags = true)
	{
		$this->query['extratags'] = $tags ? "1" : "0";

		return $this;
	}

	/**
	 * Include a list of alternative names in the results.
	 * These may include language variants, references, operator and brand.
	 * 
	 * @param  boolean $details 
	 * 
	 * @return maxh\Nominatim\Reverse
	 */
	public function nameDetails($details = true)
	{
		$this->query['namedetails'] = $details ? "1" : "0";

		return $this;
	}


}
