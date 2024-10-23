<?php
// File: generate_sitemap.php

// Load JSON data from cars_formatted.json
$jsonFile = 'cars_formatted.json';
if (!file_exists($jsonFile)) {
    die("JSON file not found.");
}

$jsonData = file_get_contents($jsonFile);
$cars = json_decode($jsonData, true);
if (!$cars) {
    die("Failed to decode JSON data.");
}

// Define the root URL
$rootUrl = $_SERVER['SERVER_NAME'] . '/';

// Static links
$staticLinks = [
    '' => '',           // Root URL for default language (French)
    'en/' => 'en/',     // Root URL for English version
    'contact/' => 'en/contact', // Contact page (both French and English)
    'privacy/' => 'en/privacy', // Privacy page (both French and English)
];

// Generate sitemap XML
$xml = new SimpleXMLElement('<urlset/>');
$xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

// Add static links to the sitemap
foreach ($staticLinks as $fr => $en) {
    // French version (default language)
    $url = $xml->addChild('url');
    $url->addChild('loc', $rootUrl . $fr);
    $url->addChild('changefreq', 'monthly');
    $url->addChild('priority', '0.8');

    // English version
    if (!empty($en)) {
        $url = $xml->addChild('url');
        $url->addChild('loc', $rootUrl . $en);
        $url->addChild('changefreq', 'monthly');
        $url->addChild('priority', '0.8');
    }
}

// Add car listing slugs to the sitemap
foreach ($cars as $car) {
    if (isset($car['slug'])) {
        $slug = $car['slug'];

        // French version (default language)
        $url = $xml->addChild('url');
        $url->addChild('loc', $rootUrl .'cars/'. $slug);
        $url->addChild('changefreq', 'weekly');
        $url->addChild('priority', '0.9');

        // English version
        $url = $xml->addChild('url');
        $url->addChild('loc', $rootUrl . 'en/' . $slug);
        $url->addChild('changefreq', 'weekly');
        $url->addChild('priority', '0.9');
    }
}

// Save the generated sitemap to a file
$sitemapFile = 'sitemap.xml';
file_put_contents($sitemapFile, $xml->asXML());

echo "Sitemap generated: $sitemapFile";
?>
