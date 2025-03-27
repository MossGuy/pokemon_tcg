<?php
function array_to_images($types) {
    if (empty($types)) {
        return ['-'];
    }
    $images_list = [];
    foreach ($types as $type) {
        $images_list[] = ($type == "Free") ? '' : "<img class='type_img' src='./images/types/$type.png' alt='$type'>";
    }
    return $images_list;
}
?>