<?php
/**
 *
 *
 * Author :Ananthu
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Day;
use App\Model\FoodCategory;
use App\Model\FoodSchedule;
use App\Model\Kitchen;
use App\Model\KitchenFood;
use App\Model\KitchenFoodCategory;
use App\Model\ScheduledFood;
use Illuminate\Http\Request;
use MediaUploader;

class FoodScheduleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($kitchen_id)
    {

        $schedule = [];

        $week = Day::get();

        foreach ($week as $day) {

            $schedule['day'][$day->id]['name'] = $day->name;
            $schedule['day'][$day->id]['id'] = $day->id;

            $schedule['day'][$day->id]['details'] = FoodSchedule::where('kitchen_id', $kitchen_id)->where('day', $day->id)->with(['scheduledFood.KitchenFood'])->get();

        }
        //dd($schedule['day'][1]['details']);

        return view('admin.food_schedule.list')->with([

            'food_schedule' => $schedule,
            'kitchen_id' => $kitchen_id,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($day, $kitchen_id)
    {

        return view('admin.food_schedule.form')->with([

            'categories' => FoodCategory::where('status', 1)->get(),
            'kitchens' => Kitchen::where('id', $kitchen_id)->where('status', 1)->get(),
            'existing_food' => KitchenFood::where('kitchen_id', $kitchen_id)->where('status', 1)->get(),
            'kitchen_food' => new KitchenFood(),
            'day' => $day,
            'kitchen_id' => $kitchen_id,

        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());

        if ($request->submit_type == 1) {

            $this->validate($request, [

                'available_time' => 'required',
                'kitchen_food_id' => 'required',
                'price' => 'required',
                'quantity' => 'required',

            ]);

            $food_schedule = FoodSchedule::create([

                'kitchen_id' => $request->kitchen_id,
                'day' => $request->day,
                'time' => $request->available_time,
                'status' => 1,
                'veg_status' => $request->veg_status,

            ]);

            $scheduled_food = ScheduledFood::create([

                'kitchen_food_id' => $request->kitchen_food_id,
                'food_schedule_id' => $food_schedule->id,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'status' => 1,
                'veg_status' => $request->veg_status,

            ]);

        } else {

            $this->validate($request, [

                'kitchen_id' => 'required',
                'category_id' => 'required',
                'name' => 'required',
                'description' => 'required',
                'price' => 'required',
                'quantity' => 'required',

            ]);

            $kitchenFood = KitchenFood::create($request->all());

            /* Add food Category*/

            $category_id = $request->category_id;

            foreach ($category_id as $id) {

                KitchenFoodCategory::create([
                    'kitchen_food_id' => $kitchenFood->id,
                    'food_category_id' => $id,

                ]);
            }

            if (!empty($request->file('gallery_images'))) {

                $gallery = $request->file('gallery_images');

                foreach ($gallery as $key => $value) {

                    $time = time();
                    $filename = 'CHEF' . $time;
                    $mediagallery = MediaUploader::fromSource($value)
                        ->useFilename($filename)
                        ->toDirectory('kitchen_food/' . $kitchenFood->id . '/gallery')
                        ->upload();
                    $kitchenFood->attachMedia($mediagallery, ['gallery']);
                }
            }

            $food_schedule = FoodSchedule::create([

                'kitchen_id' => $request->kitchen_id,
                'day' => $request->day,
                'time' => $request->available_time,
                'status' => 1,

            ]);

            $scheduled_food = ScheduledFood::create([

                'kitchen_food_id' => $kitchenFood->id,
                'food_schedule_id' => $food_schedule->id,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'status' => 1,

            ]);

        }
        return redirect()->route('admin.food-schedule.view', $request->kitchen_id);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\FoodSchedule  $foodSchedule
     * @return \Illuminate\Http\Response
     */
    public function show(FoodSchedule $foodSchedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\FoodSchedule  $foodSchedule
     * @return \Illuminate\Http\Response
     */
    public function edit(FoodSchedule $foodSchedule)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\FoodSchedule  $foodSchedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FoodSchedule $foodSchedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\FoodSchedule  $foodSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(FoodSchedule $foodSchedule)
    {

        $foodSchedule->delete();
        return response()->json(['status' => 'success']);
    }
}
