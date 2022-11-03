<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Services\FlightService;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class FlightController
 * @package App\Http\Controllers
 */
class FlightController extends Controller
{
    /**
     * @var FlightService
     */
    protected $service;

    /**
     * FlightController constructor.
     * @param FlightService $service
     */
    public function __construct(FlightService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function visual(Request $request)
    {
        $fromDate = Carbon::parse($request->input('from', Carbon::parse('2020-08-01')))->startOfDay();
        $toDate = Carbon::parse($request->input('to', Carbon::parse('2020-08-02')))->endOfDay();

        // Get filtered flights
        $flights = $this->service->all()->whereBetween('actual_departure', [$fromDate, $toDate]);

        // Get extracted flights timeline
        $timeline = $this->service->timeline($flights);

        return view('timeline')
            ->with('flights', $flights)
            ->with('timeline', $timeline)
            ->with('from', $fromDate)
            ->with('to', $toDate);
    }
}
