<?php
/**
 * Empties out the kidazzle-childcare theme folder on WP Engine.
 * This is a temporary self-destruct script to bypass WP Admin locks.
 */

add_action('admin_init', 'force_delete_kidazzle_childcare_theme');

function force_delete_kidazzle_childcare_theme() {
    // Only run if the 'force_nuke' parameter is present in the URL
    if ( ! isset( $_GET['force_nuke'] ) || $_GET['force_nuke'] !== 'kidazzle' ) {
        return;
    }

    $theme_dir = get_theme_root() . '/kidazzle-childcare';

    if ( is_dir( $theme_dir ) ) {
        // Recursively delete the directory and its contents
        $it = new RecursiveDirectoryIterator( $theme_dir, RecursiveDirectoryIterator::SKIP_DOTS );
        $files = new RecursiveIteratorIterator( $it,
            RecursiveIteratorIterator::CHILD_FIRST );
        foreach( $files as $file ) {
            if ( $file->isDir() ){
                rmdir( $file->getRealPath() );
            } else {
                unlink( $file->getRealPath() );
            }
        }
        rmdir( $theme_dir );
        
        // Output a success message and stop execution
        die( 'Successfully nuked kidazzle-childcare directory.' );
    } else {
        die( 'Directory not found.' );
    }
}
