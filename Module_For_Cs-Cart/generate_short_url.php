function generate_short_url($product_id) {
    $long_url = fn_url("product.detail?product_id=$product_id");
    $short_url = generate_random_string(6); // генерируем случайную строку из 6 символов
    $result = db_query("INSERT INTO `prefix_short_urls` (`product_id`, `short_url`) VALUES (?, ?)", $product_id, $short_url);
    if ($result) {
        return $short_url;
    } else {
        return false;
    }
}