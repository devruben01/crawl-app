<?php

namespace App\Casts;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use MongoDB\BSON\UTCDateTime;

class MongoDBDateTimeCast implements CastsAttributes
{
	/**
	 * Cast the given value.
	 *
	 * @param mixed $value
	 * @param array $attributes
	 * @return \DateTime|null
	 */
	public function get(Model $model, string $key, $value, array $attributes)
	{
		if (null === $value) {
			return null;
		}
		if ($value instanceof UTCDateTime) {
			$dateTime = $value->toDateTime();
			return Carbon::instance($dateTime)->timezone(config('app.timezone'));
		}
		return $value;
	}

	/**
	 * Prepare the given value for storage.
	 *
	 * @param mixed $value
	 * @return array
	 */
	public function set(Model $model, string $key, $value, array $attributes)
	{
		if ($value instanceof Carbon) {
			$value->timezone('UTC');
			return new UTCDateTime($value->timestamp * 1000);
		}
        return null;
	}
}
