<?php

declare(strict_types=1);

namespace WPUtils;

class SimpleCPTBuilder
{
    public static function build(
        string $single_label,
        string $plural_label,
        array $supported_features = [ 'title', 'editor', 'thumbnail', 'excerpt',
            'custom-fields', 'author'],
    ): \WP_Error|\WP_Post_Type {
        $labels = [
            'name'                  => $plural_label,
            'singular_name'         => $single_label,
            'menu_name'             => $plural_label,
            'name_admin_bar'        => $single_label,
            'add_new'               => 'Add New',
            'add_new_item'          => "Add New {$single_label}",
            'new_item'              => "New {$single_label}",
            'edit_item'             => "Edit {$single_label}",
            'view_item'             => "View {$single_label}",
            'all_items'             => "All {$plural_label}",
            'search_items'          => "Search {$plural_label}",
            'parent_item_colon'     => "Parent {$plural_label}:",
            'not_found'             => "No {$plural_label} found.",
            'not_found_in_trash'    => "No {$plural_label} found in Trash.",
        ];
        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => ['slug' => strtolower(str_replace(' ', '_', $single_label))],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => $supported_features,
        ];

        $system_name = strtolower(str_replace(' ', '_', $single_label));
        $result = register_post_type($system_name, $args);
        if (is_wp_error($result)) {
            Logger::error("Failed to register custom post type '{$single_label}': " . $result->get_error_message());
            return $result;
        }

        return $result;
    }
}
