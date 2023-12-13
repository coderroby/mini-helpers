<?php
require_once DIR . '/../../wp-load.php';
global $wpdb;
// Delete posts of post type 'cars'
$postType = 'cars';
$query = $wpdb->prepare("DELETE FROM {$wpdb->posts} WHERE post_type = %s", $postType);
$deletedRows = $wpdb->query($query);

if ($deletedRows === false) {
    echo "Error executing the query: " . $wpdb->last_error;
} else {
    echo "Successfully deleted $deletedRows posts of post type '$postType'.";
}