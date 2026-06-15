<?php

class Redimag_Nav_Walker extends Walker_Nav_Menu {

    public function start_lvl( &$output, $depth = 0, $args = null ) {
        if ( $depth === 0 ) {
            $output .= '<div class="submenu" aria-label="Submenú">';
        }
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        if ( $depth === 0 ) {
            $output .= '</div>';
        }
    }

    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $item    = $data_object;
        $classes = empty( $item->classes ) ? [] : (array) $item->classes;
        $active  = in_array( 'current-menu-item', $classes ) || in_array( 'current-menu-ancestor', $classes );

        $has_children = in_array( 'menu-item-has-children', $classes );
        $url          = esc_url( $item->url );
        $title        = esc_html( $item->title );
        $active_attr  = $active ? ' class="active"' : '';

        if ( $depth === 0 && $has_children ) {
            $output .= '<div class="nav-dropdown">';
            $output .= "<a{$active_attr} href=\"{$url}\">{$title}</a>";
        } elseif ( $depth === 0 ) {
            $output .= "<a{$active_attr} href=\"{$url}\">{$title}</a>";
        } else {
            $output .= "<a href=\"{$url}\">{$title}</a>";
        }
    }

    public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
        $item    = $data_object;
        $classes = empty( $item->classes ) ? [] : (array) $item->classes;

        if ( $depth === 0 && in_array( 'menu-item-has-children', $classes ) ) {
            $output .= '</div>';
        }
    }
}
