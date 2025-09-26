<?php
if (!function_exists('isMenuActive')) {
    function isMenuActive($item, $currentRouteName) {
        // Match exact slug
        if (!empty($item->slug) && $currentRouteName === $item->slug) {
            return true;
        }

        // Slug bisa array
        if (is_array($item->slug)) {
            foreach ($item->slug as $slug) {
                if (str_starts_with($currentRouteName, $slug)) {
                    return true;
                }
            }
        } elseif (!empty($item->slug) && str_starts_with($currentRouteName, $item->slug)) {
            return true;
        }

        // Recursive cek anak-anak
        if (isset($item->submenu)) {
            foreach ($item->submenu as $child) {
                if (isMenuActive($child, $currentRouteName)) {
                    return true;
                }
            }
        }

        return false;
    }
}
