<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Analytic;
use App\Models\Explorer;
use App\Models\Reviews;
use App\Models\Tags;
use App\Models\TagsList;
use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;
use Stevebauman\Location\Facades\Location;

class AddressesController extends Controller
{
    /**
     * @throws \Exception
     */
    public function index($address, $blockchain, Request $request)
    {
        $addressBlock = cache()->remember('address_' . $address . "_" . $blockchain, 3600, function () use ($address, $blockchain) {
            return Address::query()
                ->where(['Addresses' => $address, 'Blockchain' => $blockchain])
                ->withAvg('reviews', 'rating')
                ->with('tags')
                ->withCount(['reviews', 'analytic'])
                ->firstOrFail();
        });

        $tags = Tags::query()->where('ID_address', $addressBlock->ID_address)
            ->orderBy('Date_Tag', 'desc')
            ->get();



        $tags_in_reviews = Reviews::query()->select('ID_address', 'Tag')->where('ID_address', $addressBlock->ID_address)->get()->toArray();


        // Tag list ajax load
        if ($request->ajax() && $request->has('page_tag')) {
            return response()->json([
                'html' => view('addresses.tag_component', ['tags' => $tags])->render(),
                'next' => $tags->hasMorePages(),
                'next_page' => $tags->nextPageUrl()
            ]);
        }

        $reviews = Reviews::query()
            ->where('ID_address', $addressBlock->ID_address)
            ->where('Public_status', 1)
            ->orderBy('ID_Reviews', 'desc')
            ->paginate(5);

        // Ajax review response
        if ($request->ajax()) {
            return response()->json([
                'html' => view('addresses.review_content', ['reviews' => $reviews])->render(),
                'next' => $reviews->hasMorePages(),
                'next_page' => $reviews->nextPageUrl()
            ]);
        }

        $explorer = cache()->remember('explorer_' . $addressBlock->Blockchain, 3600, function () use ($addressBlock) {
            return Explorer::query()->where('Blockchain', $addressBlock->Blockchain)->first();
        });

        $last_reviews = Reviews::query()
        ->where('Public_status', 1)
        ->orderBy('ID_Reviews', 'desc')
        ->withCount('reviews')
        ->limit(7)
        ->get()->unique('ID_address');


        $tag_lists = cache()->remember('tag_list', 3600 * 24, function () {
            return TagsList::query()->select('Tag')->get()->toArray();
        });

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

        return view('addresses.address',
            compact('addressBlock', 'last_reviews', 'reviews', 'tags', 'explorer', 'tag_lists', 'tags_in_reviews'));
    }


    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required',
            'tag' => 'required',
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
            'Tag' => $data['tag'],
            'Rating' => $data['rating'],
            'Reviews_text' => $data['message'],
            'Public_status' => 1,
            'Date_Reviews' => date("Y-m-d H:i:s")
        ]);

        return back()->with('success', 'Feedback accepted!');

    }

    public function default(Request $request)
    {
        $addresses = Address::query()->paginate(100);
        if ($request->ajax()) {
            return response()->json([
                'html' => view('components.main_menu_table', ['addresses' => $addresses])->render(),
                'next' => $addresses->hasMorePages(),
                'next_page' => $addresses->nextPageUrl()
            ]);
        }
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
        $sitemapIndexPath = 'sitemap_index.xml';
        $i = 1;
        $sitemap_count = 50000;


        $siteMapIndex = SitemapIndex::create();

        $sitemap_head = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
    ';

        $sitemap_footer = "</urlset>";

        $sitemap_content = "";
        $sitemap_page_count = 0;

        Address::query()->select(['ID_address', 'Addresses', 'Blockchain'])->chunkById(10000,
            static function ($addresses) use (&$i, $sitemap_count, &$sitemap_page_count, &$siteMapIndex, &$sitemap_content, $sitemap_head, $sitemap_footer) {
                foreach ($addresses as $address) {
                    if ($i % $sitemap_count === 0) {
                        $sitemapPath = "items_sitemap_" . $sitemap_page_count . ".xml";

                        file_put_contents($sitemapPath, $sitemap_head . $sitemap_content . $sitemap_footer);
                        $siteMapIndex->add($sitemapPath);
                        $sitemap_content = '';
                        $sitemap_page_count++;
                    }

                    $url = Url::create("/{$address->Addresses}-{$address->Blockchain}-address");

                    $sitemap_content .= '<url>
        <loc>' . config('app.url') . $url->url . '</loc>
        <lastmod>' . $url->lastModificationDate . '</lastmod>
        <changefreq>daily</changefreq>
        <priority>' . $url->priority . '</priority>
    </url>
    ';
                    $i++;
                }
            });

        $sitemapPath = "items_sitemap_" . $sitemap_page_count . ".xml";
        file_put_contents($sitemapPath, $sitemap_head . $sitemap_content . $sitemap_footer);
        $sitemap_content = '';
        $siteMapIndex->add($sitemapPath);

        $siteMapIndex->writeToFile(public_path($sitemapIndexPath));

        return response(file_get_contents(public_path($sitemapIndexPath)), 200, [
            'Content-Type' => 'application/xml',
        ]);
    }

    public function tags($slug){
        $slug = str_replace('_', ' ', $slug);
        $tag = false;
        $tags = Tags::where('tag', $slug)->paginate(25);

        if($tags){
            $tag = $tags[0] ?? false;
        }
        return view("tag", compact('tag', 'tags'));
    }
}
