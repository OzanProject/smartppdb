<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $schools = School::all();
        $xmlDeclaration = '<?xml version="1.0" encoding="UTF-8"?>';
        
        $xml = view('public.sitemap', compact('schools', 'xmlDeclaration'))->render();
        
        return response($xml, 200)
            ->header('Content-Type', 'text/xml');
    }

    public function robots(): Response
    {
        $robots = "User-agent: *\n";
        $robots .= "Allow: /\n";
        $robots .= "Disallow: /admin/\n";
        $robots .= "Disallow: /superadmin/\n";
        $robots .= "Disallow: /applicant/\n";
        $robots .= "\nSitemap: " . url('/sitemap.xml');
        
        return response($robots, 200)
            ->header('Content-Type', 'text/plain');
    }
}
