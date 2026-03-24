<?php
namespace JB\WPPowerPack\Commands;

use WP_CLI;
use WP_CLI\Utils;

/**
 * Prints a concise overview of the current WordPress environment.
 */
class SiteSummaryCommand {

    /**
     * Render a summary of the site environment.
     *
     * ## OPTIONS
     *
     * [--format=<format>]
     * : Output format. One of:
     * ---
     * default: table
     * options:
     *   - table
     *   - json
     *   - markdown
     *   - csv
     * ---
     *
     * ## EXAMPLES
     *
     *     wp site:summary
     *     wp site:summary --format=json
     *     wp site:summary --format=markdown
     *     wp site:summary --format=csv
     *
     * @when after_wp_load
     */
    public function __invoke( $args, $assoc_args ) {
        $format = $assoc_args['format'] ?? 'table';
        $allowed_formats = [ 'table', 'json', 'markdown', 'csv' ];

        if ( ! in_array( $format, $allowed_formats, true ) ) {
            WP_CLI::error(
                sprintf(
                    'Invalid format "%s". Allowed formats: %s',
                    $format,
                    implode( ', ', $allowed_formats )
                )
            );
        }

        $theme_name    = 'n/a';
        $theme_version = '';

        if ( function_exists( 'wp_get_theme' ) ) {
            $theme = wp_get_theme();
            if ( $theme ) {
                $theme_name    = $theme->get( 'Name' ) ?: 'n/a';
                $theme_version = $theme->get( 'Version' ) ?: '';
            }
        }

        $theme_display = trim( $theme_name . ' ' . $theme_version );

        $user_count = 'n/a';
        if ( function_exists( 'count_users' ) ) {
            $counts = count_users();
            $user_count = $counts['total_users'] ?? 'n/a';
        }

        $data = [
            [ 'key' => 'WordPress', 'value' => get_bloginfo( 'version' ) ],
            [ 'key' => 'PHP', 'value' => PHP_VERSION ],
            [ 'key' => 'Site URL', 'value' => get_option( 'siteurl' ) ],
            [ 'key' => 'Home URL', 'value' => get_option( 'home' ) ],
            [ 'key' => 'Theme', 'value' => $theme_display ?: 'n/a' ],
            [ 'key' => 'Multisite', 'value' => is_multisite() ? 'yes' : 'no' ],
            [ 'key' => 'Users', 'value' => $user_count ],
        ];

        if ( 'json' === $format ) {
            WP_CLI::line( wp_json_encode( $data, JSON_PRETTY_PRINT ) );
            return;
        }

        if ( 'markdown' === $format ) {
            WP_CLI::line( '| Key | Value |' );
            WP_CLI::line( '| --- | --- |' );

            foreach ( $data as $row ) {
                $key   = str_replace( '|', '\|', (string) $row['key'] );
                $value = str_replace( '|', '\|', (string) $row['value'] );
                WP_CLI::line( sprintf( '| %s | %s |', $key, $value ) );
            }

            return;
        }

        if ( 'csv' === $format ) {
            WP_CLI::line( 'Key,Value' );

            foreach ( $data as $row ) {
                $key   = '"' . str_replace( '"', '""', (string) $row['key'] ) . '"';
                $value = '"' . str_replace( '"', '""', (string) $row['value'] ) . '"';
                WP_CLI::line( $key . ',' . $value );
            }

            return;
        }

        $assoc = [];
        foreach ( $data as $row ) {
            $assoc[] = [
                'Key'   => $row['key'],
                'Value' => $row['value'],
            ];
        }

        Utils\format_items( 'table', $assoc, [ 'Key', 'Value' ] );
    }
}