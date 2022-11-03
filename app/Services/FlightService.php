<?php

namespace App\Services;

use App\Models\Flight;
use Carbon\Carbon;

/**
 * Class FlightService
 * @package App\Services
 */
class FlightService
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $collection;

    /**
     * FlightService constructor.
     */
    public function __construct()
    {
        $this->collection = collect([]);

        foreach (json_decode(file_get_contents(storage_path() . '\json\flights.json'), true) as $item) {
            $model = new Flight;
            $model->setTail($item['tail']);
            $model->setFlightId($item['flightid']);
            $model->setDate($item['date']);
            $model->setOrigin($item['origin']);
            $model->setDestination($item['destination']);
            $model->setLogIds($item['log_ids']);
            $model->setAssetOrder($item['assetorder']);
            $model->setSecondaries($item['secondaries']);
            $model->setActualDeparture($item['actual_departure']);
            $model->setActualArrival($item['actual_arrival']);
            $model->setBox1($item['Box1']);
            $model->setBox2($item['Box2']);

            $this->collection->push($model);
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        return $this->collection;
    }

    /**
     * @param $flights
     * @return \Illuminate\Support\Collection
     */
    public function timeline($flights)
    {
        $count = 0;
        $timeline = collect([]);

        foreach($flights as $flight)
        {
            if (isset($flight) and !empty($flight->actual_departure)) {

                $count++;
                $item = [];
                $item['key'] = $count;
                $item['type'] = 'bb';
                $item['tail'] = $flight->tail;
                $item['name'] = "{$flight->flight_id} ({$flight->date->toFormattedDateString()} {$flight->origin} - {$flight->destination})";
                $item['start'] = $flight->actual_departure;
                $item['end'] = $flight->actual_arrival;

                $timeline->push($item);
            }

            foreach ($flight->log_ids as $key => $log) {
                if (isset($log['boot']) and !empty($log['boot'])) {

                    $count++;
                    $item = [];
                    $item['key'] = $count;
                    $item['type'] = 'wb';
                    $item['tail'] = $flight->tail;
                    $item['name'] = "{$log['asset']} - B". (array_search($log['asset'], $flight->asset_order)+1);
                    $item['start'] = $log['boot'];
                    $item['end'] = $log['shutdown'];

                    $exists = $timeline->where('type', 'wb')->where('tail', $item['tail'])->where('name', $item['name'])->where('start', $item['start'])->where('end', $item['end'])->toArray();
                    if (!$exists) {
                        $timeline->push($item);
                    }
                }
            }
        }

        return $timeline;
    }

    /**
     * @return array
     */
    public function tails()
    {
        return $this->collection->pluck('tail')->unique()->toArray();
    }
}
