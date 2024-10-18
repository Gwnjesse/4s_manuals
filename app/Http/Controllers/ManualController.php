<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Manual;

class ManualController extends Controller
{
    public function show($brand_id, $brand_slug, $manual_id )
    {
        $brand = Brand::findOrFail($brand_id);
        $manual = Manual::findOrFail($manual_id);

        return view('pages/manual_view', [
            "manual" => $manual,
            "brand" => $brand,
        ]);
    }

        public function redirectToManual($id)
    {
        // Find the manual by its ID
        $manual = Manual::findOrFail($id);

        // Increment the click count
        $manual->increment('clicks');

        // Check if the manual is locally available or external
        if ($manual->locally_available) {
            // Redirect to locally stored manual
            return redirect()->away(route('manual.download', $manual->id)); // or wherever the manual should download from
        } else {
            // Redirect to the external URL
            return redirect()->away($manual->originUrl);
        }
    }

        public function showTopManuals()
    {

        $topManuals = Manual::orderBy('clicks', 'desc')->limit(10)->get();

        $brands = Brand::all()->sortBy('name');

        return view('pages.homepage', compact('topManuals', 'brands'));
    }


}
