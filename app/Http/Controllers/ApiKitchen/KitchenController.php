<?php
namespace App\Http\Controllers\ApiKitchen;

use App\Http\Controllers\Controller;
use App\Model\Country;
use App\Model\Day;
use App\Model\Feedback;
use App\Model\FoodSchedule;
use App\Model\Kitchen;
use App\Model\KitchenBanks;
use App\Model\KitchenDetails;
use App\Model\KitchenFood;
use App\Model\KitchenPayouts;
use App\Model\Order;
use App\Model\ScheduledFood;
use App\Model\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use MediaUploader;
use Plank\Mediable\Media;

//use Cart;

class KitchenController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:api-customer');
    }

    /**
     * Get Customer Address .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getKitchen(Request $request)
    {

        $kitchen_detail = Kitchen::with('KitchenDetails')->whereId($request->user('api-kitchen')->id)->first();
        $kitchenDetail = null;
        $kitchenDetail = [
            'name' => $kitchen_detail->name,
            'description' => $kitchen_detail->kitchenDetails->description,
            'about' => $kitchen_detail->kitchenDetails->about,
            'image' => !empty($kitchen_detail->getMedia('kitchen')->first()) ? $kitchen_detail->getMedia('kitchen')->first()->getUrl() : '',
        ];
        return response()->json(['kitchen' => $kitchenDetail], 200);

    }
    public function getKitchenAbout(Request $request)
    {

        $kitchen_detail = Kitchen::with('KitchenDetails')->whereId($request->user('api-kitchen')->id)->first();
        $kitchenAbout = $kitchen_detail->kitchenDetails->about;

        return response()->json(['kitchenAbout' => $kitchenAbout], 200);

    }
    public function getProfile(Request $request)
    {
        $kitchen = Kitchen::where('id', $request->user('api-kitchen')->id)->first();
        $kitchen->push([
            'country_code' => $kitchen->country_id ? Country::where('id', $kitchen->country_id)->first()->iso_code_2 : '',
            'state_code' => $kitchen->state_id ? State::where('id', $kitchen->state_id)->first()->code : '',
            'country_name' => $kitchen->country_id ? Country::where('id', $kitchen->country_id)->first()->name : '',
            'state_name' => $kitchen->state_id ? State::where('id', $kitchen->state_id)->first()->name : '',
        ]);
        return response()->json(['kitchen' => $kitchen]);
    }
    public function getFiles(Request $request)
    {
        $kitchen = Kitchen::where('id', $request->user('api-kitchen')->id)->first();
        $proof = $kitchen->getMedia('proof');

        return response()->json(['featuredImage' => $kitchen->getMedia('kitchen')->first() ? $kitchen->getMedia('kitchen')->first()->getUrl() : '',
            'proofFrontImage' => $proof ? $proof[0]->getUrl() : '',
            'proofBackImage' => $proof ? $proof[1]->getUrl() : '']);
    }
    /**
     * Change Customer Address .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function editKitchen(Request $request)
    {

        $kitchen = Kitchen::with('kitchenDetails', 'kitchenBanks', 'kitchenVideos')->where('id', $request->user('api-kitchen')->id)->first();
        $kitchenGallery = [];
        $kitchenSlider = [];
        $kitchenVideos = [];
        $sliderVideos = [];
        $kitchenDetails = [
            'name' => $kitchen->name,
            'email' => $kitchen->email,
            'phone' => $kitchen->phone,
            'additional_phone' => $kitchen->additional_phone,
            'contact_email' => $kitchen->contact_email,
            'notification_email' => $kitchen->notification_email,
            'description' => $kitchen->kitchenDetails->description,
            'specialities' => $kitchen->kitchenDetails->specialities,
            'about' => $kitchen->kitchenDetails->about,
            'order_policy' => $kitchen->kitchenDetails->order_policy,
            'delivery' => $kitchen->delivery,
            'delivery_policy' => $kitchen->kitchenDetails->delivery_policy,
            'payment_terms' => $kitchen->kitchenDetails->payment_terms,
            'bank_name' => $kitchen->kitchenBanks->bank_name,
            'payment_method' => $kitchen->kitchenBanks->payment_method,
            'account_number' => $kitchen->kitchenBanks->account_number,
            'swift' => $kitchen->kitchenBanks->swift,
            'ifsc' => $kitchen->kitchenBanks->ifsc,

            'branch' => $kitchen->kitchenBanks->branch,

        ];
        $featuredImage = $kitchen->getMedia('kitchen')->first() ? $kitchen->getMedia('kitchen')->first()->getUrl() : '';
        $slider = $kitchen->getMedia('slider');
        $gallery = $kitchen->getMedia('gallery');

        foreach ($slider as $image) {
            $kitchenSlider[] = [
                'image' => $image->getUrl(),
                'id' => $image->id,
            ];
        }
        foreach ($gallery as $image) {
            $kitchenGallery[] = [
                'image' => $image->getUrl(),
                'id' => $image->id,
            ];
        }
        if (!empty($kitchen->kitchenVideos)) {
            foreach ($kitchen->kitchenVideos as $video) {
                if ($video->featured == 0) {
                    $kitchenVideos[] = [
                        'url' => $video->url,
                    ];
                } else {
                    $sliderVideos[] = [
                        'url' => $video->url,
                    ];
                }
            }
        }
        return response()->json(['kitchen' => $kitchenDetails, 'featuredImage' => $featuredImage, 'sliderImages' => $kitchenSlider, 'galleryVideos' => $kitchenVideos, 'sliderVideos' => $sliderVideos, 'galleryImages' => $kitchenGallery]);

    }

    public function updateKitchen(Request $request)
    {
        file_put_contents('v1.txt', "");
        error_log(json_encode($request->all()), 3, 'v1.txt');
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|max:12',
            'bank_name' => 'required|string|max:255',
            'branch' => 'required|string|max:255',
            'account_number' => 'required|string|max:25',

            'ifsc' => 'required|string|max:255',
        ]);
        /*if($request->delivery==true){
        $delivery = 1;
        }
        if($request->delivery==false) {
        $delivery = 0;
        }*/
        $kitchen = Kitchen::where('id', $request->user('api-kitchen')->id)->first();
        $kitchenBanks = kitchenBanks::where('kitchen_id', $request->user('api-kitchen')->id)->first();
        $kitchenDetails = kitchenDetails::where('kitchen_id', $request->user('api-kitchen')->id)->first();
        $kitchen->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'additional_phone' => $request->additional_phone,
            'contact_email' => $request->contact_email,
            'notification_email' => $request->notification_email,
            'delivery' => $request->delivery,
        ]);
        $kitchenBanks->update([
            'bank_name' => $request->bank_name,
            'payment_method' => $request->payment_method,
            'account_number' => $request->account_number,
            'swift' => $request->swift,
            'ifsc' => $request->ifsc,
            'branch' => $request->branch,
        ]);
        $kitchenDetails->update([
            'description' => $request->description,
            'specialities' => $request->specialities,
            'about' => $request->about,
            'order_policy' => $request->order_policy,
            'delivery_policy' => $request->delivery_policy,
            'payment_terms' => $request->payment_terms,
        ]);
        $kitchen->kitchenVideos()->delete();
        $sliderVideos = json_decode($request->sliderVideos);
        $galleryVideos = json_decode($request->galleryVideos);

        foreach ($sliderVideos as $value) {
            file_put_contents('v2.txt', "");
            error_log(json_encode($value), 3, 'v2.txt');

            $kitchen->kitchenVideos()->create([
                'url' => $value->videoUrl,
                'featured' => 1,
            ]);
        }
        foreach ($galleryVideos as $value) {

            $kitchen->kitchenVideos()->create([
                'url' => $value->videoUrl,
                'featured' => 0,
            ]);
        }
        $featured = $kitchen->getMedia('kitchen')->first();
        if (!empty($request->file('featuredImage'))) {

            $old_image = Media::whereId($featured->id)->first();
            if ($old_image) {
                $old_image->delete();
            }
            $time = time();
            $filename = 'CHEF_' . $time;
            $featured = MediaUploader::fromSource($request->file('featuredImage'))
                ->useFilename($filename)
                ->toDirectory('kitchen/' . $kitchen->id)
                ->upload();
            $kitchen->attachMedia($featured, ['kitchen']);

        }
        if (!empty($request->file('sliderImages'))) {

            $slider = $request->file('sliderImages');

            foreach ($slider as $value1) {

                $time = time();
                $filename = 'CHEF' . $time;
                $mediaslider = MediaUploader::fromSource($value1)
                    ->useFilename($filename)
                    ->toDirectory('kitchen/' . $kitchen->id . '/slider')
                    ->upload();
                $kitchen->attachMedia($mediaslider, ['slider']);
            }
        }
        if (!empty($request->file('galleryImages'))) {

            $gallery = $request->file('galleryImages');

            foreach ($gallery as $value2) {

                $time = time();
                $filename = 'CHEF' . $time;
                $mediagallery = MediaUploader::fromSource($value2)
                    ->useFilename($filename)
                    ->toDirectory('kitchen/' . $kitchen->id . '/gallery')
                    ->upload();
                $kitchen->attachMedia($mediagallery, ['gallery']);
            }
        }

        $message = "Kitchen updated successfully";

        return response()->json(['kitchen' => $kitchen, 'kitchenDetails' => $kitchenDetails, 'message' => $message, 'image' => $featured->getUrl()]);
    }
    public function support(Request $request)
    {

        Feedback::create([

            'kitchen_id' => $request->user('api-kitchen')->id,
            'title' => $request->phone,
            'description' => $request->message,
            'type' => 1,
        ]);
        return response()->json(['status' => true], 201);
    }

    public function updateStatus(Request $request)
    {
        $kitchen = Kitchen::where('id', $request->user('api-kitchen')->id)->first();

        if ($kitchen->receive_order == 1) {
            $kitchen->update(['receive_order' => 0]);
        } else {
            $kitchen->update(['receive_order' => 1]);
        }

        return response()->json(['status' => $kitchen->receive_order], 201);
    }
    public function getNotifications(Request $request)
    {

    }
    public function register(Request $request)
    {
        file_put_contents('register_kitchen.txt', "");
        error_log(json_encode($request->all()), 3, 'register_kitchen.txt');
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|max:12',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'required|string|max:255',
            'street_name' => 'required|string|max:255',
            'landmark' => 'required|string|max:255',
            'city' => 'required|string|max:25',
            'latitude' => 'required',
            'longitude' => 'required',
            'postcode' => 'required|string|max:25',
            'country_id' => 'required',
            'state_id' => 'required',

        ]);
        $kitchen = Kitchen::where('id', $request->user('api-kitchen')->id)->first();
        $country_id = Country::where('iso_code_2', $request->country_id)->first()->id;
        $kitchen->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'street_name' => $request->street_name,
            'landmark' => $request->landmark,
            'country_id' => $country_id,
            'state_id' => State::where('code', $request->state_id)->where('country_id', $country_id)->first()->id,
            'city' => $request->city,
            'postcode' => $request->postcode,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'delivery' => $request->delivery,

        ]);
        KitchenDetails::create([
            'kitchen_id' => $request->user('api-kitchen')->id,
        ]);
        KitchenBanks::create([
            'kitchen_id' => $request->user('api-kitchen')->id,
        ]);
        return response()->json(['kitchen' => $kitchen,
            'message' => 'Profile creation is almost complete. Please provide proof document and kitchen image',
        ], 201);

    }
    public function fileUpload(Request $request)
    {

        $kitchen = Kitchen::where('id', $request->user('api-kitchen')->id)->first();
        $featured = $kitchen->getMedia('kitchen')->first();
        $proof = $kitchen->getMedia('proof');
        file_put_contents('fileUpload.txt', "");
        error_log(json_encode($proof), 3, 'fileUpload.txt');
        if (!empty($request->file('featuredImage'))) {
            if ($featured) {
                $old_image = Media::whereId($featured->id)->first();

                $old_image->delete();
            }
            $time = time();
            $filename = 'CHEF_' . $time;
            $media1 = MediaUploader::fromSource($request->file('featuredImage'))
                ->useFilename($filename)
                ->toDirectory('kitchen/' . $kitchen->id)
                ->upload();

            $kitchen->attachMedia($media1, ['kitchen']);
        }
        if (!empty($request->file('proofFrontImage'))) {
            if (isset($proof[0]->id)) {
                $old_image = Media::whereId($proof[0]->id)->first();

                $old_image->delete();
            }
            $time = time();
            $filename = 'CHEF_' . $time;
            $media2 = MediaUploader::fromSource($request->file('proofFrontImage'))
                ->useFilename($filename)
                ->toDirectory('kitchen/proof/' . $kitchen->id)
                ->upload();
            $kitchen->attachMedia($media2, ['proof']);
        }
        if (!empty($request->file('proofBackImage'))) {
            if (isset($proof[1]->id)) {
                $old_image = Media::whereId($proof[1]->id)->first();

                $old_image->delete();
            }
            $time = time();
            $filename = 'CHEF_' . $time;
            $media3 = MediaUploader::fromSource($request->file('proofBackImage'))
                ->useFilename($filename)
                ->toDirectory('kitchen/proof/' . $kitchen->id)
                ->upload();
            $kitchen->attachMedia($media3, ['proof']);
        }
        if ($media1 && $media2 && $media3) {
            $kitchen->verification_request_date = date('Y-m-d');
            $kitchen->save();
            // update(['verification_request_date'=>date('Y-m-d')]);

            return response()->json(['featuredImage' => $media1->getUrl(),
                'status' => 'success',
            ], 201);
        } else {
            return response()->json(['status' => 'failed'], 401);
        }

    }

    public function imageDelete(Request $request)
    {
        $image = Media::whereId($request->id)->first();

        if ($image->delete()) {
            return response()->json([
                'status' => 'success',
            ], 201);
        } else {
            return response()->json(['status' => 'failed'], 401);
        }

    }

    public function foodDelete(Request $request)
    {

        $schedule = FoodSchedule::whereId($request->id)->first();

        if ($schedule->delete()) {
            $schedules = [];

            $week = Day::get();

            foreach ($week as $day) {
                $foodSchedule = FoodSchedule::where('kitchen_id', $request->user('api-kitchen')->id)->where('day', $day->id)->with(['scheduledFood.KitchenFood'])->get();
                $items = [];
                foreach ($foodSchedule as $schedule) {
                    $food = [];
                    foreach ($schedule->scheduledFood as $scheduledFood) {
                        $food = [
                            'id' => $scheduledFood->id,
                            'name' => $scheduledFood->KitchenFood->name,
                            'price' => $scheduledFood->KitchenFood->price,
                            'quantity' => $scheduledFood->KitchenFood->quantity,
                            'image' => $scheduledFood->KitchenFood->getMedia('gallery')->first() ? $scheduledFood->KitchenFood->getMedia('gallery')->first()->getUrl() : '',
                        ];
                    }
                    $items[] = [
                        'id' => $schedule->id,
                        'time' => $schedule->time,
                        'food' => $food,
                    ];
                }
                $schedules[] = [
                    'name' => $day->name,
                    'id' => $day->id,
                    'items' => $items,
                ];

            }
            //dd($schedule['day'][1]['details']);

            return response()->json([

                'foodSchedule' => $schedules,
            ]);

        } else {
            return response()->json(['status' => 'failed'], 401);
        }
    }
    public function foodSchedule(Request $request)
    {
        file_put_contents('foodSchedule.txt', "");
        error_log(json_encode($request->all()), 3, 'foodSchedule.txt');
        $schedules = [];

        $week = Day::get();

        foreach ($week as $day) {
            $foodSchedule = FoodSchedule::where('kitchen_id', $request->user('api-kitchen')->id)->where('day', $day->id)->with(['scheduledFood.KitchenFood'])->get();
            $items = [];
            foreach ($foodSchedule as $schedule) {
                $food = [];
                foreach ($schedule->scheduledFood as $scheduledFood) {
                    $food = [
                        'id' => $scheduledFood->id,
                        'name' => $scheduledFood->KitchenFood->name,
                        'price' => $scheduledFood->KitchenFood->price,
                        'quantity' => $scheduledFood->KitchenFood->quantity,
                        'image' => $scheduledFood->KitchenFood->getMedia('gallery')->first() ? $scheduledFood->KitchenFood->getMedia('gallery')->first()->getUrl() : '',
                    ];
                }
                $items[] = [
                    'id' => $schedule->id,
                    'time' => $schedule->time,
                    'food' => $food,
                ];
            }
            $schedules[] = [
                'name' => $day->name,
                'id' => $day->id,
                'items' => $items,
            ];

        }
        //dd($schedule['day'][1]['details']);

        return response()->json([

            'foodSchedule' => $schedules,
        ]);

    }

    public function scheduleFood(Request $request)
    {
        $this->validate($request, [
            'available_time' => 'required',
            'kitchen_food_id' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        $food_schedule = FoodSchedule::create([
            'kitchen_id' => $request->user('api-kitchen')->id,
            'day' => $request->day,
            'time' => $request->available_time,
            'status' => 1,
        ]);

        $scheduled_food = ScheduledFood::create([
            'kitchen_food_id' => $request->kitchen_food_id,
            'food_schedule_id' => $food_schedule->id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'status' => 1,

        ]);

        $schedules = [];

        $week = Day::get();

        foreach ($week as $day) {
            $foodSchedule = FoodSchedule::where('kitchen_id', $request->user('api-kitchen')->id)->where('day', $day->id)->with(['scheduledFood.KitchenFood'])->get();
            $items = [];
            foreach ($foodSchedule as $schedule) {
                $food = [];
                foreach ($schedule->scheduledFood as $scheduledFood) {
                    $food = [
                        'id' => $scheduledFood->id,
                        'name' => $scheduledFood->KitchenFood->name,
                        'price' => $scheduledFood->price,
                        'quantity' => $scheduledFood->quantity,
                        'image' => $scheduledFood->KitchenFood->getMedia('gallery')->first() ? $scheduledFood->KitchenFood->getMedia('gallery')->first()->getUrl() : '',
                    ];
                }
                $items[] = [
                    'id' => $schedule->id,
                    'time' => $schedule->time,
                    'food' => $food,
                ];
            }
            $schedules[] = [
                'name' => $day->name,
                'id' => $day->id,
                'items' => $items,
            ];

        }
        //dd($schedule['day'][1]['details']);

        return response()->json([

            'foodSchedule' => $schedules,
        ]);
    }
    public function addFood(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'recipe_details' => 'required',
            'available_time' => 'required',
            'quantity' => 'required',
        ]);
        if (!empty($request->file('featuredImage'))) {
            $kitchenFood = KitchenFood::create([
                'kitchen_id' => $request->user('api-kitchen')->id,
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'recipe_details' => $request->recipe_details,
                'available_time' => $request->available_time,
                'veg_status' => $request->veg_status,
                'quantity' => $request->quantity,
                'status' => 0,
            ]);
            $foodCategory = json_decode($request->food_category);
            foreach ($foodCategory as $value) {
                $kitchenFood->categories()->create([
                    'food_category_id' => $value,
                ]);
            }
            $time = time();
            $filename = 'CHEF_' . $time;
            $media = MediaUploader::fromSource($request->file('featuredImage'))
                ->useFilename($filename)
                ->toDirectory('kitchen_food/' . $kitchenFood->id . '/gallery')
                ->upload();
            $kitchenFood->attachMedia($media, ['gallery']);

            $food_schedule = FoodSchedule::create([
                'kitchen_id' => $request->user('api-kitchen')->id,
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

            $schedules = [];

            $week = Day::get();

            foreach ($week as $day) {
                $foodSchedule = FoodSchedule::where('kitchen_id', $request->user('api-kitchen')->id)->where('day', $day->id)->with(['scheduledFood.KitchenFood'])->get();
                $items = [];
                foreach ($foodSchedule as $schedule) {
                    $food = [];
                    foreach ($schedule->scheduledFood as $scheduledFood) {
                        $food = [
                            'id' => $scheduledFood->id,
                            'name' => $scheduledFood->KitchenFood->name,
                            'price' => $scheduledFood->KitchenFood->price,
                            'quantity' => $scheduledFood->KitchenFood->quantity,
                            'image' => $scheduledFood->KitchenFood->getMedia('gallery')->first() ? $scheduledFood->KitchenFood->getMedia('gallery')->first()->getUrl() : '',
                        ];
                    }
                    $items[] = [
                        'id' => $schedule->id,
                        'time' => $schedule->time,
                        'food' => $food,
                    ];
                }
                $schedules[] = [
                    'name' => $day->name,
                    'id' => $day->id,
                    'items' => $items,
                ];

            }
            //dd($schedule['day'][1]['details']);

            return response()->json([

                'foodSchedule' => $schedules,
            ]);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Please select an Image'], 401);
        }
    }

    public function cronFoodSchedule(Request $request)
    {
        $today = Carbon::now();
        $current_date = Carbon::now()->format('Y-m-d');
        $dayOfWeek = $today->dayOfWeek;
        $foodSchedules = FoodSchedule::with('scheduledFood.KitchenFood')->where('day', $dayOfWeek)->get();
        foreach ($foodSchedules as $foodSchedule) {
            if (!empty($foodSchedule->scheduledFood->first()->kitchenFood)) {
                $kitchenFood = $foodSchedule->scheduledFood->first()->kitchenFood;
                $foodImage = $kitchenFood->getMedia('gallery')->first();
                $newFood = KitchenFood::create([
                    'name' => $kitchenFood->name,
                    'description' => $kitchenFood->description,
                    'kitchen_id' => $foodSchedule->kitchen_id,
                    'veg_status' => $kitchenFood->veg_status,
                    'recipe_details' => $kitchenFood->recipe_details,
                    'price' => $foodSchedule->scheduledFood->first()->price,
                    'quantity' => $foodSchedule->scheduledFood->first()->quantity,
                    'status' => 1,
                    'available_time' => $foodSchedule->time,
                ]);
                if ($newFood && $foodImage) {
                    $newFood->attachMedia($foodImage, ['gallery']);
                }
            }
        }
    }

    public function cronManageFood(Request $request)
    {
        $today = Carbon::now();
        $current_date = Carbon::now()->format('Y-m-d');
        $dayOfWeek = $today->dayOfWeek;
        KitchenFood::where(function ($query) use ($current_date) {
            $query->whereDate('created_at', '<', $current_date)->whereStatus(1);
        })->orWhere('quantity', '<', 1)->update([
            'status' => 0,
        ]);
        Order::where(function ($query) use ($current_date) {
            $query->whereDate('created_at', '<', $current_date)->whereNotIn('order_status_id', [5, 10]);
        })->orWhere('order_status_id', 0)->update(['order_status_id' => 10]);
    }

    public function cronPayout(Request $request)
    {
        $today = Carbon::now();
        $current_date = Carbon::now()->format('Y-m-d');
        $dayOfWeek = $today->dayOfWeek;
        $kitchens = Kitchen::with('payoutGroup', 'kitchenPayouts')->whereStatus(1)->get();
        foreach ($kitchens as $kitchen) {
            $lastPayoutDate = '';
            $nextPayoutDate = '';
            if (!empty($kitchen->payoutGroup)) {
                if ($kitchen->kitchenPayouts->count()) {
                    $lastPayoutDate = Carbon::parse($kitchen->kitchenPayouts->last()->payout_generated_date);
                    if ($kitchen->payoutGroup->payment_frequency == 1) {
                        $nextPayoutDate = $lastPayoutDate->addMonth();
                    } else {
                        $nextPayoutDate = $lastPayoutDate->addDays(7);
                    }
                } else {
                    if ($kitchen->payoutGroup->payment_frequency == 2) {

                        if ($dayOfWeek == ($kitchen->payoutGroup->day_id - 1)) {
                            $lastPayoutDate = $today->subDays(7);
                            $nextPayoutDate = $current_date;
                        }
                    } else {
                        $kitchenCreatedOn = Carbon::parse($kitchen->created_at);
                        if ($kitchenCreatedOn->addMonth() == $current_date) {
                            $lastPayoutDate = $kitchenCreatedOn;
                            $nextPayoutDate = $current_date;
                        }
                    }
                }

                $lastPayoutDate = Carbon::parse($lastPayoutDate)->format('Y-m-d');
                $nextPayoutDate = Carbon::parse($nextPayoutDate)->format('Y-m-d');
                // return response()->json([$lastPayoutDate,$nextPayoutDate, $current_date]);
                if ($current_date == $nextPayoutDate) {
                    // return response()->json($current_date);
                    $orders = Order::where('kitchen_id', $kitchen->id)->whereDate('created_at', '>', $lastPayoutDate)->whereDate('created_at', '<=', $nextPayoutDate)->where('order_status_id', 5)->get();
                    if ($orders->count()) {
                        KitchenPayouts::create([
                            'kitchen_id' => $kitchen->id,
                            'payout_group_id' => $kitchen->payout_group_id,
                            'total_orders' => $orders->count(),
                            'total_amount' => $orders->sum('total') - $orders->sum('delivery_charge'),
                            'payout_method' => 0,
                            'start_date' => $lastPayoutDate,
                            'end_date' => $nextPayoutDate,
                            'payout_generated_date' => $current_date,
                            'commission' => (($orders->sum('total') - $orders->sum('delivery_charge')) * $kitchen->payoutGroup->percentage / 100),
                            'payable_amount' => $orders->sum('total') - $orders->sum('delivery_charge') - (($orders->sum('total') - $orders->sum('delivery_charge')) * $kitchen->payoutGroup->percentage / 100),
                            'status' => 0,
                        ]);
                    }
                }
            }
        }
    }

    public function getPayouts(Request $request)
    {
        $payoutArray = [];
        $kitchen = Kitchen::with('payoutGroup')->where('id', $request->user('api-kitchen')->id)->first();
        $payouts = KitchenPayouts::where('kitchen_id', $request->user('api-kitchen')->id)->orderBy('payout_generated_date', 'desc')->get();
        $orders = Order::where('kitchen_id', $request->user('api-kitchen')->id)->where('order_status_id', 5)->get();
        $totalOrderAmount = $orders->sum('total');
        $totalOrderCount = $orders->count();
        $totalPayoutAmount = $orders->sum('total') - $orders->sum('delivery_charge') - (($orders->sum('total') - $orders->sum('delivery_charge')) * $kitchen->payoutGroup->percentage / 100);
        $totalPending = $totalPayoutAmount - $payouts->sum('payable_amount');

        foreach ($payouts as $payout) {
            $payoutArray[] = [
                'id' => $payout->id,
                'startDate' => Carbon::parse($payout->start_date)->format('Y-m-d'),
                'endDate' => Carbon::parse($payout->end_date)->format('Y-m-d'),
                'totalOrders' => $payout->total_orders,
                'totalAmount' => $payout->total_amount,
                'payoutGeneratedDate' => Carbon::parse($payout->payout_generated_date)->format('Y-m-d'),
                'commission' => $payout->commission,
                'payableAmount' => $payout->payable_amount,
                'transactionId' => $payout->transaction_id,
                'status' => $payout->status,
                'remarks' => $payout->remarks,
            ];
        }
        return response()->json(['payouts' => $payoutArray, 'totalOrderAmount' => $totalOrderAmount, 'totalOrderCount' => $totalOrderCount, 'totalPayoutAmount' => $totalPayoutAmount, 'totalPending' => $totalPending, 'payoutGroup' => $kitchen->payoutGroup]);
    }
}
