<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Analytic;
use App\Models\Explorer;
use App\Models\Reviews;
use App\Models\Tags;
use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;
use Stevebauman\Location\Facades\Location;

class AddressesController extends Controller
{
    public function index($address, $blockchain, Request $request)
    {
        $addressBlock = Address::query()
            ->where(['Addresses' => $address, 'Blockchain' => $blockchain])
            ->withAvg('reviews', 'rating')
            ->with('tags')
            ->withCount(['reviews', 'analytic'])
            ->firstOrFail();

        /*
         * Set analytics
         * */

        $user_info = Location::get($request->ip());
        Analytic::query()->create(
            [
                'address_id' => $addressBlock->ID_address,
                'ip' => $user_info->ip ?? '',
                'country' => $user_info->countryName ?? '',
                'city' => $user_info->regionName ?? '',
                'browser' => $request->userAgent(),
                'date' => date("Y-m-d H:i:s"),
                'latitude' => $user_info->latitude ?? '',
                'longitude' => $user_info->longitude ?? '',
            ]
        );

//        $addressBlock->increment('count_view');

        $explorer = Explorer::where('Blockchain', $addressBlock->Blockchain)->first();


        $tags = Tags::query()->where('ID_address', $addressBlock->ID_address)
            ->orderBy('Date_Tag', 'desc')->paginate(4, ['*'], 'page_tag');


        if ($request->ajax() && $request->has('page_tag')) {
            return response()->json([
                'html' => view('addresses.tag_component', ['tags' => $tags])->render(),
                'next' => $tags->hasMorePages(),
                'next_page' => $tags->nextPageUrl()
            ]);
        }

        $reviews = Reviews::query()->where('ID_address', $addressBlock->ID_address)
            ->where('Public_status', 1)
            ->orderBy('ID_Reviews', 'desc')
            ->with('tags')->paginate(5);
        // Ajax response
        if ($request->ajax()) {
            return response()->json([
                'html' => view('addresses.review_content', ['reviews' => $reviews])->render(),
                'next' => $reviews->hasMorePages(),
                'next_page' => $reviews->nextPageUrl()
            ]);
        }

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
            'address' => 'required',
            'g-recaptcha-response' => 'required|recaptcha',
        ]);

        $address = Address::query()->where('ID_address', $data['address'])->first();
        if (!$address) {
            return back()->with('error', 'Something error! Please refresh the page and resend feedback');
        }

        $location = Location::get($request->ip());
        Reviews::query()->create([
            'Addresses' => $address->Addresses,
            'ID_address' => $data['address'],
            'Blockchain' => $address->Blockchain,
            'IP_address' => $request->ip(),
            'Region' => $location->regionName ?? 'None',
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
        $addresses = Address::query()->paginate(25);

        return view('welcome', ['addresses' => $addresses]);
    }

    public function search(Request $request)
    {
        $addresses = Address::query()
            ->where('Addresses', $request->get('q'))
            ->orWhere('Blockchain', $request->get('q'))
            ->paginate(25);
        return view('welcome', ['addresses' => $addresses]);
    }

    public function sitemap()
    {
        // Configuration
        $sitemapIndexPath = 'sitemap.xml';
        $i = 1;
        $sitemap_count = 100000;


        $siteMapIndex = SitemapIndex::create();
        $sitemap = Sitemap::create();

        Address::query()->select(['ID_address', 'Addresses', 'Blockchain'])->chunkById(10000,
            static function ($addresses) use ($i, $sitemap_count, $siteMapIndex, $sitemap) {
                foreach ($addresses as $address) {
                    if ($i % $sitemap_count === 0) {
                        $sitemapPath = "items_sitemap_" . ($i / $sitemap_count) . ".xml";
                        $sitemap->writeToFile($sitemapPath);

                        $siteMapIndex->add($sitemapPath);
                        $sitemap = Sitemap::create();
                    }
                    $sitemap->add(Url::create("/{$address->Addresses}-{$address->Blockchain}-address"));
                    $i++;
                }
            });

        $sitemapPath = "items_sitemap_" . (round($i / $sitemap_count)) . ".xml";
        $sitemap->writeToFile($sitemapPath);
        $siteMapIndex->add($sitemapPath);

        $siteMapIndex->writeToFile(public_path($sitemapIndexPath));

//        return response(file_get_contents(public_path($sitemapIndexPath)), 200, [
//            'Content-Type' => 'application/xml',
//        ]);
    }
}
