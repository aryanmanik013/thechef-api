<?php

namespace App\Http\Controllers\ApiCustomer;

use App\Http\Controllers\Controller;
use App\Model\Banner;
use App\Model\DeliveryCharge;
use App\Model\Feedback;
use App\Model\FoodCategory;
use App\Model\Information;
use App\Model\Kitchen;
use App\Model\KitchenDetails;
use App\Model\KitchenFavorite;
use App\Model\KitchenFood;
use App\Model\KitchenInappropriateReport;
use App\Model\Notification;
use App\Model\ReportReason;
use App\Model\Review;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function getAllBanners(Request $request)
    {
        $allBanners = [];
        $banners = Banner::where('status', 1)->orderBy('sort_order')->get();
        foreach ($banners as $banner) {
            $parameter = [];
            if ($banner->activity == 'Information') {
                $parameter = ['slug' => $banner->parameter];
            }
            if ($banner->activity == 'KitchenDetail') {
                $parameter = ['kitchenId' => $banner->parameter];
            }
            if ($banner->activity == 'CategoryDetail') {
                $parameter = ['categoryId' => $banner->parameter];
            }
            $allBanners[] = [
                'id' => $banner->id,
                'activity' => $banner->activity,
                'parameter' => $parameter,
                'image' => !empty($banner->getMedia('banner')->first()) ? $banner->getMedia('banner')->first()->getUrl() : '',
            ];
        }
        return response()->json($allBanners);
    }
    public function getAllCategories()
    {
        $categories = FoodCategory::where('status', 1)->orderBy('sort_order')->get();
        $allCategories = [];
        foreach ($categories as $category) {
            $allCategories[] = [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'icon' => !empty($category->getMedia('category')->first()) ? $category->getMedia('category')->first()->getUrl() : '',
            ];
        }
        return response()->json($allCategories);
    }

    public function getPopularCategories()
    {
        $categories = FoodCategory::where('status', 1)->where('popular', 1)->skip(0)->take(5)->orderBy('sort_order')->get();
        $popularCategories = [];
        foreach ($categories as $category) {
            $popularCategories[] = [
                'id' => $category->id,
                'name' => $category->name,
                'icon' => !empty($category->getMedia('category')->first()) ? $category->getMedia('category')->first()->getUrl() : '',
            ];
        }
        return response()->json($popularCategories);
    }
    public function search(Request $request)
    {
        file_put_contents('search.txt', '');
        error_log(json_encode($request->all()), 3, 'search.txt');
        $longitude = $request->longitude;
        $latitude = $request->latitude;
        $distance = 5;
        $search_value = $request->searchValue;
        $category = $request->categoryId;
        $nearkitchens = [];
        $allMenu = [];
        if ($latitude != null) {
            DB::enableQueryLog();
            $kitchens = Kitchen::selectRaw('*, ( 6371 * acos( cos( radians(' . $latitude . ' ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ' ) ) + sin( radians( ' . $latitude . ' ) ) * sin( radians( latitude ) ) ) ) AS distance', [$latitude, $longitude, $distance])

                ->with(['kitchenFood.categories', 'reviews', 'kitchenDetails'])

                ->where(function ($query) use ($search_value, $category) {
                    $query->whereHas('kitchenFood.categories', function ($query) use ($category) {
                        if (!empty($category)) {
                            $query->whereRaw("food_category_id='$category'");

                        }
                    });
                    if (!empty($search_value)) {
                        $query->whereRaw("name like '%$search_value%'");
                    }
                })
                ->havingRaw('distance <= 5')
                ->whereRaw('status=1')->whereRaw('verification_status=1')
                ->orderBy('distance')
                ->get();
            // print_r(DB::getQueryLog());exit;

            $kitchenFoods = Kitchen::selectRaw('*, ( 6371 * acos( cos( radians(' . $latitude . ' ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ' ) ) + sin( radians( ' . $latitude . ' ) ) * sin( radians( latitude ) ) ) ) AS distance', [$latitude, $longitude, $distance])

                ->with(['kitchenFood' => function ($query) use ($request) {
                    //  $query->where('name', 'LIKE', '%'.strtolower($request->searchValue).'%')->get();
                    $query->whereRaw('lower(name) like (?)', ['%' . strtolower($request->searchValue) . '%'])->get();
                }, 'reviews', 'kitchenDetails', 'kitchenFood.categories'])
                ->where(function ($query) use ($category) {
                    $query->whereHas('kitchenFood.categories', function ($query) use ($category) {
                        if (!empty($category)) {
                            $query->where('food_category_id', $category);
                        }
                    });

                })
                ->havingRaw('distance <= 5')
                ->whereRaw('status=1')->whereRaw('verification_status=1')
                ->orderBy('distance')
                ->get();
            //   $kitchenFoods=$kitchenFoods->whereHas('categories',function($q) {
            //             $q->where('food_category_id', $category);
            //         });
            //  return response()->json([$kitchenFoods]);
            $kitchenFoods = $kitchenFoods->filter(function ($item) {
                return $item->kitchenFood->count() > 0;
            });

            //  return response()->json([$filteredCollection]);
            // print_r(DB::getQueryLog());
            $kitchens_array = [];
            $foods_array = [];
            $j = 0;
            $k = 0;
            if (!empty($kitchenFoods)) {

                foreach ($kitchenFoods as $key => $kitchen) {

                    //dd($kitchen);
                    if (count($kitchen->kitchenFood)) {
                        // $array=$kitchen->kitchenFood;
                        // $arrayColumn=array_column(json_decode(json_encode($array), true), 'food');
                        // $arrayColumn=array_filter($arrayColumn);
                        // if(!empty($arrayColumn))
                        // {
                        $kitchens_array[$j]['id'] = $kitchen->id;
                        $kitchens_array[$j]['name'] = $kitchen->name;
                        $kitchens_array[$j]['rating'] = $kitchen->reviews->sum('rating') != 0 ? $kitchen->reviews->sum('rating') / $kitchen->reviews->count() : 0;
                        $kitchens_array[$j]['distance'] = $kitchen->distance;
                        $kitchens_array[$j]['description'] = !empty($kitchen->kitchenDetails) ? $kitchen->kitchenDetails->description : '';
                        $kitchens_array[$j]['image'] = !empty($kitchen->getMedia('kitchen')->first()) ? $kitchen->getMedia('kitchen')->first()->getUrl() : '';
                        $j++;

                        foreach ($kitchen->kitchenFood as $menu) {
                            if ($menu->status && $menu->quantity > 0) {
                                $foods_array[$k]['id'] = $menu->id;
                                $foods_array[$k]['kitchen_id'] = $kitchen->id;
                                $foods_array[$k]['name'] = $menu->name;
                                $foods_array[$k]['rating'] = $kitchen->reviews->sum('rating') != 0 ? $kitchen->reviews->sum('rating') / $kitchen->reviews->count() : 0;
                                $foods_array[$k]['description'] = $menu->description;
                                $foods_array[$k]['kitchen_name'] = $kitchen->name;
                                $foods_array[$k]['distance'] = $distance;
                                $foods_array[$k]['order_time'] = $menu->available_time;
                                $foods_array[$k]['price'] = $menu->price;
                                $foods_array[$k]['veg_status'] = $menu->veg_status;
                                $foods_array[$k]['quantity'] = $menu->quantity;
                                $foods_array[$k]['image'] = !empty($menu->getMedia('gallery')->first()) ? $menu->getMedia('gallery')->first()->getUrl() : '';
                                $k++;
                            }
                        }

                    }
                }
            }
            // return response()->json([$foods_array]);
            $kitchenId = [];
            $foodId = [];
            if (!empty($kitchens_array)) {
                $kitchenId = array_column($kitchens_array, 'id');
            }
            if (!empty($foods_array)) {
                $foodId = array_column($foods_array, 'id');
            }
            if (!empty($kitchens)) {
                foreach ($kitchens as $key => $kitchen) {
                    if (!in_array($kitchen->id, $kitchenId)) {
                        $kitchens_array[$j]['id'] = $kitchen->id;
                        $kitchens_array[$j]['name'] = $kitchen->name;
                        $kitchens_array[$j]['rating'] = $kitchen->reviews->sum('rating') != 0 ? $kitchen->reviews->sum('rating') / $kitchen->reviews->count() : 0;
                        $kitchens_array[$j]['distance'] = $kitchen->distance;
                        $kitchens_array[$j]['description'] = !empty($kitchen->kitchenDetails) ? $kitchen->kitchenDetails->description : '';
                        $kitchens_array[$j]['image'] = !empty($kitchen->getMedia('kitchen')->first()) ? $kitchen->getMedia('kitchen')->first()->getUrl() : '';
                        $j++;
                    }
                    foreach ($kitchen->kitchenFood as $menu) {
                        if ($menu->status && $menu->quantity > 0) {
                            if (!in_array($menu->id, $foodId)) {
                                $foods_array[$k]['id'] = $menu->id;
                                $foods_array[$k]['kitchen_id'] = $kitchen->id;
                                $foods_array[$k]['name'] = $menu->name;
                                $foods_array[$k]['rating'] = $kitchen->reviews->sum('rating') != 0 ? $kitchen->reviews->sum('rating') / $kitchen->reviews->count() : 0;
                                $foods_array[$k]['description'] = $menu->description;
                                $foods_array[$k]['kitchen_name'] = $kitchen->name;
                                $foods_array[$k]['distance'] = $distance;
                                $foods_array[$k]['order_time'] = $menu->available_time;
                                $foods_array[$k]['price'] = $menu->price;
                                $foods_array[$k]['veg_status'] = $menu->veg_status;
                                $foods_array[$k]['quantity'] = $menu->quantity;
                                $foods_array[$k]['image'] = !empty($menu->getMedia('gallery')->first()) ? $menu->getMedia('gallery')->first()->getUrl() : '';
                                $k++;
                            }
                        }
                    }
                }
            }

        }
        file_put_contents('search_out.txt', '');
        error_log(json_encode($kitchens_array), 3, 'search_out.txt');
        if (!empty($kitchens_array)) {
            return response()->json(['message' => 'Kitchens found Successfully', 'near_kitchen' => $kitchens_array, 'menu' => $foods_array], 200);
        } else {
            return response()->json(['message' => 'No Kitchens Found'], 422);
        }
    }
    public function getKitchens(Request $request)
    {
        $longitude = $request->longitude;
        $latitude = $request->latitude;
        $distance = 5;
        $nearkitchens = [];

        if ($latitude != null) {
            $nearkitchens = Kitchen::with(['kitchenFood', 'reviews', 'kitchenDetails'])->selectRaw('*, ( 6371 * acos( cos( radians(' . $latitude . ' ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ' ) ) + sin( radians( ' . $latitude . ' ) ) * sin( radians( latitude ) ) ) ) AS distance', [$latitude, $longitude, $distance])
                ->havingRaw('distance <= 5')
                ->whereRaw('status=1')->whereRaw('verification_status=1')
                ->orderBy('distance')
                ->get();

            $allNearKitchens = [];
            foreach ($nearkitchens as $kitchen) {

                $allNearKitchens[] = [
                    'id' => $kitchen->id,
                    'name' => $kitchen->name,
                    'rating' => $kitchen->reviews->sum('rating') != 0 ? $kitchen->reviews->sum('rating') / $kitchen->reviews->count() : 0,
                    //'categories'=>$kitchen->kitchenFood->categories?$kitchen->kitchenFood->categories:'',
                    'distance' => $kitchen->distance,
                    // 'latitude'=>$kitchen->latitude,
                    // 'longitude'=>$kitchen->longitude,
                    'description' => !empty($kitchen->kitchenDetails) ? $kitchen->kitchenDetails->description : '',
                    'image' => !empty($kitchen->getMedia('kitchen')->first()) ? $kitchen->getMedia('kitchen')->first()->getUrl() : '',

                ];

            }
        }
        if (!empty($allNearKitchens)) {
            return response()->json(['message' => 'Kitchens found Successfully', 'near_kitchen' => $allNearKitchens], 200);
        } else {
            return response()->json(['message' => 'Kitchens Not Found'], 422);
        }
    }
    public function getMenus(Request $request)
    {
        $longitude = $request->longitude;
        $latitude = $request->latitude;
        $distance = 5;
        $nearkitchen = [];
        if (!empty($latitude)) {
            $kitchens = Kitchen::with(['kitchenFood', 'reviews'])->selectRaw('*, ( 6371 * acos( cos( radians(' . $latitude . ' ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ' ) ) + sin( radians( ' . $latitude . ' ) ) * sin( radians( latitude ) ) ) ) AS distance', [$latitude, $longitude, $distance])
                ->havingRaw('distance <= 5')
                ->whereRaw('status=1')->whereRaw('verification_status=1')
                ->orderBy('distance')
                ->get();
            $allMenu = [];
            foreach ($kitchens as $kitchen) {
                foreach ($kitchen->kitchenFood as $menu) {
                    if ($menu->status && $menu->quantity > 0) {
                        $allMenu[] = [
                            'id' => $menu->id,
                            'kitchen_id' => $kitchen->id,
                            'name' => $menu->name,
                            'rating' => $kitchen->reviews->sum('rating') != 0 ? $kitchen->reviews->sum('rating') / $kitchen->reviews->count() : 0,
                            'description' => $menu->description,
                            'kitchen_name' => $kitchen->name,
                            'distance' => $kitchen->distance,
                            'order_time' => $menu->available_time,
                            'price' => $menu->price,
                            'veg_status' => $menu->veg_status,
                            'quantity' => $menu->quantity,
                            'image' => !empty($menu->getMedia('gallery')->first()) ? $menu->getMedia('gallery')->first()->getUrl() : '',
                        ];
                    }
                }
            }
        }
        if (!empty($allMenu)) {
            return response()->json(['message' => 'Kitchens foods found Successfully', 'menu' => $allMenu], 200);
        } else {
            return response()->json(['message' => 'Menu Not Found'], 422);
        }
    }
    public function getKitchenDetail(Request $request)
    {
        file_put_contents('kitchenDetails.txt', "");
        error_log(json_encode($request->all()), 3, 'kitchenDetails.txt');
        $kitchenDetail = [];
        $kitchenGallery = [];
        $kitchenSlider = [];
        $kitchenVideos = [];
        $featuredVideos = [];
        $favorite = '';
        $longitude = $request->longitude;
        $latitude = $request->latitude;
        $distance = 5;
        $kitchen_detail = Kitchen::selectRaw('*, ( 6371 * acos( cos( radians(' . $latitude . ' ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ' ) ) + sin( radians( ' . $latitude . ' ) ) * sin( radians( latitude ) ) ) ) AS distance', [$latitude, $longitude, $distance])->with('reviews', 'kitchenDetails', 'kitchenVideos')->whereRaw('id=' . $request->kitchen_id)->first();

        //  return response()->json(['kitchen' => $kitchen_detail], 200);
        if ($request->user('api-customer')) {
            $favorite = KitchenFavorite::where('customer_id', $request->user('api-customer')->id)->where('kitchen_id', $request->kitchen_id)->first();
        }
        $kitchenFeatured = $kitchen_detail->getMedia('kitchen')->first() ? $kitchen_detail->getMedia('kitchen')->first()->getUrl() : '';
        $slider = $kitchen_detail->getMedia('slider');
        $gallery = $kitchen_detail->getMedia('gallery');

        foreach ($slider as $image) {
            $kitchenSlider[] = [
                'image' => $image->getUrl(),
            ];
        }
        foreach ($gallery as $image) {
            $kitchenGallery[] = [
                'image' => $image->getUrl(),
            ];
        }
        foreach ($kitchen_detail->kitchenVideos as $video) {
            if ($video->featured == 0) {
                $kitchenVideos[] = [
                    'url' => $video->url,
                ];
            } else {
                $featuredVideos[] = [
                    'url' => $video->url,
                ];
            }
        }
        $kitchenDetail = [
            'id' => $kitchen_detail->id,
            'name' => $kitchen_detail->name,
            'rating' => $kitchen_detail->reviews->sum('rating') != 0 ? $kitchen_detail->reviews->sum('rating') / $kitchen_detail->reviews->count() : 0,
            'review_count' => $kitchen_detail->reviews->count(),
            'latitude' => $kitchen_detail->latitude,
            'longitude' => $kitchen_detail->longitude,
            'kitchenDistance' => $kitchen_detail->distance,
            'kitchen_about' => $kitchen_detail->kitchenDetails->about,
            'kitchen_specialities' => $kitchen_detail->kitchenDetails->specialities,
            'kitchen_description' => $kitchen_detail->kitchenDetails->description,
            'location' => $kitchen_detail->street_name . ',' . $kitchen_detail->city,
            'favoriteStatus' => ($favorite != null) ? 1 : 0,
        ];
        return response()->json(['kitchen' => $kitchenDetail, 'featuredImage' => $kitchenFeatured, 'sliderImages' => $kitchenSlider, 'galleryVideos' => $kitchenVideos, 'featuredVideos' => $featuredVideos, 'galleryImages' => $kitchenGallery], 200);

    }
    public function getKitchenMenu(Request $request)
    {
        $kitchenFoods = KitchenFood::with('kitchen')->where('kitchen_id', $request->kitchen_id)->where('status', 1)->get();
        $allMenu = [];
        foreach ($kitchenFoods as $kitchenFood) {
            if ($kitchenFood->status && $kitchenFood->quantity > 0) {
                $allMenu[] = [
                    'id' => $kitchenFood->id,
                    'kitchen_id' => $kitchenFood->kitchen->id,
                    'name' => $kitchenFood->name,
                    'kitchen_name' => $kitchenFood->kitchen->name,
                    'rating' => $kitchenFood->kitchen->reviews->sum('rating') != 0 ? $kitchenFood->kitchen->reviews->sum('rating') / $kitchenFood->kitchen->reviews->count() : 0,
                    'description' => $kitchenFood->description,
                    'veg_status' => $kitchenFood->veg_status,
                    'order_time' => $kitchenFood->available_time,
                    'price' => $kitchenFood->price,
                    'quantity' => $kitchenFood->quantity,
                    'image' => !empty($kitchenFood->getMedia('gallery')->first()) ? $kitchenFood->getMedia('gallery')->first()->getUrl() : '',
                ];

            }

        }
        return response()->json(['kitchen_menu' => $allMenu], 200);
    }
    public function getMenuDetail(Request $request)
    {
        $kitchenFood = KitchenFood::with('kitchen')->where('id', $request->food_id)->first();
        $food = [];
        $food = [
            'id' => $kitchenFood->id,
            'kitchen_id' => $kitchenFood->kitchen->id,
            'name' => $kitchenFood->name,
            'longitude' => $kitchenFood->kitchen->longitude,
            'latitude' => $kitchenFood->kitchen->latitude,
            'kitchen_name' => $kitchenFood->kitchen->name,
            'kitchen' => $kitchenFood->kitchen,
            'rating' => $kitchenFood->kitchen->reviews->sum('rating') != 0 ? $kitchenFood->kitchen->reviews->sum('rating') / $kitchenFood->kitchen->reviews->count() : 0,
            'description' => $kitchenFood->description,
            'recipe' => $kitchenFood->recipe_details,
            'veg_status' => $kitchenFood->veg_status,
            'order_time' => $kitchenFood->available_time,
            'price' => $kitchenFood->price,
            'quantity' => $kitchenFood->quantity,
            'image' => !empty($kitchenFood->getMedia('gallery')->first()) ? $kitchenFood->getMedia('gallery')->first()->getUrl() : '',
        ];
        return response()->json(['kitchen_menu' => $food], 200);
    }
    public function getKitchenGallery(Request $request)
    {
        $kitchen = Kitchen::whereId($request->kitchen_id)->first();
        $gallery = $kitchen->getMedia('kitchen')->first();
        return response()->json(['kitchen_gallery' => $gallery->getUrl()], 200);
    }
    public function getKitchenDeliveryType(Request $request)
    {

        file_put_contents('getKitchenDeliveryType.txt', "");
        error_log(json_encode($request->all()), 3, 'getKitchenDeliveryType.txt');
        $kitchen = Kitchen::whereId($request->kitchenId)->first();
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $kitchenId = $request->kitchenId;
        $charge = 0;
        $kitchen = Kitchen::selectRaw('*, ( 6371 * acos( cos( radians(' . $latitude . ' ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ' ) ) + sin( radians( ' . $latitude . ' ) ) * sin( radians( latitude ) ) ) ) AS distance', [$latitude, $longitude, $kitchenId])
            ->whereRaw("id='$kitchenId'")
            ->first();

        $deliveryCharge = DeliveryCharge::where('state_id', $kitchen->state_id)->where('status', 1)->first();

        if (!empty($deliveryCharge->minimum_distance)) {
            if ($deliveryCharge->minimum_distance >= $kitchen->distance) {
                $charge = $deliveryCharge->minimum_charge;
            } else {
                $extraDistance = $kitchen->distance - $deliveryCharge->minimum_distance;
                $charge = $charge + ($extraDistance * $deliveryCharge->charge);
            }
        } elseif (!empty($deliveryCharge->charge)) {
            $charge = $charge + ($kitchen->distance * $deliveryCharge->charge);
        }

        return response()->json(['status' => $kitchen->delivery, 'deliveryCharge' => !empty($charge) ? $charge : 0], 200);
    }
    public function getKitchenReview(Request $request)
    {
        $kitchenReviews = Review::with('customer')->where('kitchen_id', $request->kitchen_id)->where('status', 1)->get();
        $allReviews = [];
        foreach ($kitchenReviews as $review) {
            $allReviews[] = [
                'name' => $review->customer->name,
                'rating' => $review->rating,
                'description' => $review->description,
                'heading' => $review->heading,
                'date' => date('M d.Y', strtotime($review->created_at)),
            ];
        }
        $totalRating = $kitchenReviews->sum('rating') != 0 ? $kitchenReviews->sum('rating') / $kitchenReviews->count() : 0;
        return response()->json(['kitchen_reviews' => $allReviews, 'total_rating' => $totalRating], 200);
    }

    public function GetKitchenByCategory(Request $request)
    {
        file_put_contents('cat.txt', "");
        error_log(json_encode($request->all()), 3, 'cat.txt');
        $longitude = $request->longitude;
        $latitude = $request->latitude;
        $distance = 5;
        $nearkitchens = [];
        $allMenu = [];

        if ($latitude != null) {
            //DB::enableQueryLog();
            $nearkitchens = Kitchen::selectRaw('*, ( 6371 * acos( cos( radians(' . $latitude . ' ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ' ) ) + sin( radians( ' . $latitude . ' ) ) * sin( radians( latitude ) ) ) ) AS distance', [$latitude, $longitude, $distance])
                ->havingRaw('distance <= 5')
                ->with(['kitchenFood', 'kitchenFood.categories', 'reviews', 'kitchenDetails'])

                ->where(function ($query) use ($request) {
                    $query->whereHas('kitchenFood.categories', function ($query) use ($request) {
                        $query->whereRaw('food_category_id=' . $request->category_id);
                    });

                })
                ->whereRaw('status=1')->whereRaw('verification_status=1')
                ->orderBy('distance')
                ->get();
            // return response()->json($nearkitchens);
            //  print_r(DB::getQueryLog());

            $allNearKitchens = [];
            // dd($allNearKitchens);
            foreach ($nearkitchens as $kitchen) {

                $allNearKitchens[] = [
                    'id' => $kitchen->id,
                    'name' => $kitchen->name,
                    'rating' => $kitchen->reviews->sum('rating') != 0 ? $kitchen->reviews->sum('rating') / $kitchen->reviews->count() : 0,
                    //'categories'=>$kitchen->kitchenFood->categories?$kitchen->kitchenFood->categories:'',
                    'distance' => $kitchen->distance,
                    'description' => !empty($kitchen->kitchenDetails) ? $kitchen->kitchenDetails->description : '',
                    'image' => !empty($kitchen->getMedia('kitchen')->first()) ? $kitchen->getMedia('kitchen')->first()->getUrl() : '',

                ];

                foreach ($kitchen->kitchenFood as $menu) {

                    if (!empty($menu->categories) && count($menu->categories) > 0 && in_array($request->category_id, $menu->categories->pluck('food_category_id')->toArray())) {

                        if ($menu->status && $menu->quantity > 0) {

                            $allMenu[] = [
                                'id' => $menu->id,
                                'kitchen_id' => $kitchen->id,

                                'name' => $menu->name,
                                'rating' => $kitchen->reviews->sum('rating') != 0 ? $kitchen->reviews->sum('rating') / $kitchen->reviews->count() : 0,
                                'description' => $menu->description,
                                'kitchen_name' => $kitchen->name,
                                'distance' => $kitchen->distance,
                                'order_time' => $menu->available_time,
                                'price' => $menu->price,
                                'veg_status' => $menu->veg_status,
                                'quantity' => $menu->quantity,
                                'image' => !empty($menu->getMedia('gallery')->first()) ? $menu->getMedia('gallery')->first()->getUrl() : '',
                            ];
                        }

                    }

                }
            }
        }
        if (!empty($allNearKitchens)) {
            return response()->json(['message' => 'Kitchens found Successfully', 'near_kitchen' => $allNearKitchens, 'menu' => $allMenu], 200);
        } else {
            return response()->json(['message' => 'No Kitchens Found'], 422);
        }
    }

    /**
     * Get informations .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getInformation(Request $request)
    {
        //print_r($request->all());exit();

        $information = Information::where('id', $request->slug)->first();

        return response()->json(['information' => ['title' => $information->title,
            'description' => $information->description]]);

    }

    public function sendFeedback(Request $request)
    {
        if ($request->user('api-customer')->id) {
            Feedback::create([
                'customer_id' => $request->user('api-customer')->id,
                'title' => $request->phone,
                'description' => $request->message,
                'type' => 0,
            ]);
        } else {
            Feedback::create([
                'customer_id' => 999999,
                'title' => $request->phone,
                'description' => $request->message,
                'type' => 0,
            ]);
        }

        return response()->json(['status' => true], 201);
    }
    public function getNotifications(Request $request)
    {
        $kitchen_id = $request->user('api-customer')->id;
        $notification = Notification::where('user_id', $kitchen_id)->where('user_type', 1)->where('read_status', 0)->get();
        Notification::where('user_id', $kitchen_id)->where('user_type', 1)->update(['read_status' => 1]);
        return response()->json([
            'notification' => $notification,
        ], 200);
    }
    public function getReportReasons(Request $request)
    {
        $reasons = ReportReason::get();
        return response()->json(['reasons' => $reasons]);
    }

    public function reportKitchen(Request $request)
    {
        if ($request->user('api-customer')->id) {
            $reportId = KitchenInappropriateReport::create([
                'kitchen_id' => $request->kitchen_id,
                'customer_id' => $request->user('api-customer')->id,
                'customer_name' => $request->user('api-customer')->name,
                'reason_id' => $request->reason_id,
                'reason' => $request->reason,
                'type' => '0',
                'remarks' => $request->remarks,
            ]);
        }
        return response()->json(['success' => 'You have reported inappropriate with this kitchen']);
    }
    public function reportDelivery(Request $request)
    {
        if ($request->user('api-customer')->id) {
            $reportId = KitchenInappropriateReport::create([
                'order_id' => $request->order_id,
                'type' => '1',
                'kitchen_id' => $request->kitchen_id,
                'customer_id' => $request->user('api-customer')->id,
                'customer_name' => $request->user('api-customer')->name,
                'reason_id' => $request->reason_id,
                'reason' => $request->reason,
                'remarks' => $request->remarks,
            ]);
        }
        return response()->json(['success' => 'You have reported inappropriate with this kitchen']);
    }
}
