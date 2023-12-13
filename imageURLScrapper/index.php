<?php
include('dom_parser/simple_html_dom.php'); // Include the HTML DOM Parser

function scrapeImages($url) {
    $html = file_get_html($url); // Get the HTML content from the URL

    if ($html === false) {
        echo "Failed to fetch the URL.";
        return;
    }

    $images = $html->find('img'); // Find all image elements

    if (empty($images)) {
        echo "No images found on the page.";
    } else {
        foreach ($images as $image) {
            $imageUrl = $image->src; // Get the image source URL
            echo $imageUrl . "<br>";
        }
    }
}

// Example usage:
$urlToScrape = 'https://finance.pretauto60minutes.ca/'; // Replace with the URL of the website you want to scrape
scrapeImages($urlToScrape);
?>
