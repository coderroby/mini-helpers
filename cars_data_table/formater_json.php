<?php
// Function to generate a slug from the post_title
function generateSlug($title, $existingSlugs) {
    // Convert title to slug: replace spaces with dashes and remove multiple dashes
    $slug = preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', $title));
    $slug = preg_replace('/-+/', '-', $slug); // remove multiple dashes

    // Make sure the slug is unique
    $originalSlug = $slug;
    $counter = 1;
    while (in_array($slug, $existingSlugs)) {
        $slug = $originalSlug . '-' . $counter+1;
        $counter++;
    }

    // Add this slug to the list of existing slugs
    $existingSlugs[] = $slug;

    return $slug;
}

// Read the car_json.json file
$carData = json_decode(file_get_contents('car_json.json'), true);

$existingSlugs = [];
foreach ($carData as $index => $car) {
    // Generate a slug
    $slug = generateSlug($car['post_title'], $existingSlugs);
    
    // Create a new array with slug added after post_title
    $newCar = [];
    foreach ($car as $key => $value) {
        $newCar[$key] = $value;
        if ($key == 'post_title') {
            $newCar['slug'] = $slug; // Add the slug immediately after post_title
        }
    }
    
    // Replace the old car data with the new one that includes slug after post_title
    $carData[$index] = $newCar;

    // Add the slug to the list of existing slugs
    $existingSlugs[] = $slug;
}

// Write the new data to cars_formatted.json
file_put_contents('cars_formatted.json', json_encode($carData, JSON_PRETTY_PRINT));

echo "Slugs added after post_title and data saved to cars_formatted.json.";
?>
