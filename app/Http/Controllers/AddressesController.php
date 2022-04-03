<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Explorer;
use App\Models\Reviews;
use App\Models\Tags;
use Illuminate\Http\Request;

class AddressesController extends Controller
{
    public function index($address, $blockchain)
    {
        $addressBlock = Address::query()
            ->where(['Addresses' => $address, 'Blockchain' => $blockchain])
            ->withAvg('reviews', 'rating')
            ->with('tags')
            ->withCount('reviews')
            ->firstOrFail();

        $addressBlock->increment('count_view');

        $explorer = Explorer::where('Blockchain', $addressBlock->Blockchain)->first();


        $tags = Tags::query()->where('ID_address', $addressBlock->ID_address)
            ->limit(4)->orderBy('Date_Tag')->get();

        $reviews = Reviews::query()->where('ID_address', $addressBlock->ID_address)
            ->where('Public_status', 1)
            ->orderBy('ID_Reviews','desc')
            ->with('tags')->paginate(5);

        $last_reviews = Reviews::query()
            ->where('Public_status', 1)
            ->where('ID_address', '!=', $addressBlock->ID_address)
            ->orderBy('ID_Reviews', 'desc')
            ->groupBy('ID_address')
            ->with('tags')
            ->withCount('reviews')
            ->limit(5)
            ->get();


        return view('addresses.address', compact('addressBlock', 'last_reviews', 'reviews', 'tags', 'explorer'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'tags' => 'required',
            'rating' => 'required',
            'message' => 'required',
            'recapcha' => 'required',
            'address' => 'required'
        ]);

        $address = Address::query()->where('ID_address', $data['address'])->first();
        if(!$address){
            return back()->with('error', 'Something error! Please refresh the page and resend feedback');
        }

        Reviews::query()->create([
            'Addresses' => $address->Addresses,
            'ID_address' => $data['address'],
            'Blockchain' => $address->Blockchain,
            'IP_address' => $request->ip(),
            'Region' => "Russia",
            'Browser' => $request->userAgent(),
            'Name' => $data['name'],
            'Tag' => implode(', ', $data['tags']),
            'Rating' => $data['rating'],
            'Reviews_text' => $data['message'],
            'Public_status' => 1,
            'Date_Reviews' => date("Y-m-d H:i:s")
        ]);

        return back()->with('success', 'Feedback accepted!');

    }

    public function default()
    {
        $addresses= Address::query()->paginate(25);

        return view('welcome', ['addresses' => $addresses]);
    }
}
