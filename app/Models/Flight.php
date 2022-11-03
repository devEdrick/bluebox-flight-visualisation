<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * Class Flight
 * @package App\Models
 */
class Flight
{
    public $tail;
    public $flight_id;
    public $date;
    public $origin;
    public $destination;
    public $log_ids;
    public $asset_order;
    public $secondaries;
    public $actual_departure;
    public $actual_arrival;
    public $box1;
    public $box2;

    /**
     * @return mixed
     */
    public function getTail()
    {
        return $this->tail;
    }

    /**
     * @param mixed $tail
     */
    public function setTail($tail)
    {
        $this->tail = $tail;
    }

    /**
     * @return mixed
     */
    public function getFlightId()
    {
        return $this->flight_id;
    }

    /**
     * @param mixed $flight_id
     */
    public function setFlightId($flight_id)
    {
        $this->flight_id = $flight_id;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = Carbon::parse($date);
    }

    /**
     * @return mixed
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @param mixed $origin
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;
    }

    /**
     * @return mixed
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param mixed $destination
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    /**
     * @return mixed
     */
    public function getLogIds()
    {
        return $this->log_ids;
    }

    /**
     * @param mixed $log_ids
     */
    public function setLogIds($log_ids)
    {
        $this->log_ids = collect($log_ids)->transform(function ($log) {
            return [
                'sequence' => $log['sequence'],
                'asset' => $log['asset'],
                'tail' => $log['tail'],
                'boot' => Carbon::parse($log['boot'])->format('Y-m-d H:i:s'),
                'shutdown' => Carbon::parse($log['shutdown'])->format('Y-m-d H:i:s'),
            ];
        });
    }

    /**
     * @return mixed
     */
    public function getAssetOrder()
    {
        return $this->asset_order;
    }

    /**
     * @param mixed $asset_order
     */
    public function setAssetOrder($asset_order)
    {
        $this->asset_order = $asset_order;
    }

    /**
     * @return mixed
     */
    public function getSecondaries()
    {
        return $this->secondaries;
    }

    /**
     * @param mixed $secondaries
     */
    public function setSecondaries($secondaries)
    {
        $this->secondaries = $secondaries;
    }

    /**
     * @return mixed
     */
    public function getActualDeparture()
    {
        return $this->actual_departure;
    }

    /**
     * @param mixed $actual_departure
     */
    public function setActualDeparture($actual_departure)
    {
        $this->actual_departure = Carbon::parse($actual_departure)->format('Y-m-d H:i:s');
    }

    /**
     * @return mixed
     */
    public function getActualArrival()
    {
        return $this->actual_arrival;
    }

    /**
     * @param mixed $actual_arrival
     */
    public function setActualArrival($actual_arrival)
    {
        $this->actual_arrival = Carbon::parse($actual_arrival)->format('Y-m-d H:i:s');
    }

    /**
     * @return mixed
     */
    public function getBox1()
    {
        return $this->box1;
    }

    /**
     * @param mixed $box1
     */
    public function setBox1($box1)
    {
        $this->box1 = $box1;
    }

    /**
     * @return mixed
     */
    public function getBox2()
    {
        return $this->box2;
    }

    /**
     * @param mixed $box2
     */
    public function setBox2($box2)
    {
        $this->box2 = $box2;
    }

    /**
     * @return mixed
     */
    public function toArray()
    {
        return json_decode(json_encode($this), true);
    }
}
