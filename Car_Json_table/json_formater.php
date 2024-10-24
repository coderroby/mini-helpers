<?php
function generateSlug($title, $existingSlugs) {
    $slug = preg_replace('/[^a-zA-Z0-9\-]/', '', str_replace(' ', '-', $title));
    $slug = preg_replace('/-+/', '-', $slug); // remove multiple dashes

    // Make sure the slug is unique
    $originalSlug = $slug;
    // echo $originalSlug . "<br>";
    $counter = 1;
    while (in_array($slug, $existingSlugs)) {
        $slug = $originalSlug . '-' . $counter+1;
        // dd($counter);
        // dd($existingSlugs);
        // dd($slug);
        $counter++;
    }

    $existingSlugs[] = $slug;

    return $slug;
}

$carData = json_decode(file_get_contents('car_json.json'), true);

$existingSlugs = [];
// dd($existingSlugs);
foreach ($carData as $index => $car) {
    // Generate a slug
    $slug = generateSlug($car['post_title'], $existingSlugs);

    // Create a new array with slug added after post_title
    $newCar = [];
    foreach ($car as $key => $value) {
        $newCar[$key] = $value;
        if ($key == 'post_title') {
            $newCar['slug'] = $slug;
        }
    }

    $carData[$index] = $newCar;
    $existingSlugs[] = $slug;
}

file_put_contents('cars_formatted.json', json_encode($carData, JSON_PRETTY_PRINT));

dd($existingSlugs);

function dd($variable){
    echo "<pre>";
    print_r($variable);
    echo "</pre> <br>";

}

echo "Slugs added after post_title and data saved to cars_formatted.json.";
?>
