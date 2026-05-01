<?php
/**
 * Plugin Name: Calculator Core
 * Description: Shared core functionality for all calculator plugins.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*
|--------------------------------------------------------------------------
| Core constants
|--------------------------------------------------------------------------
*/
define( 'CALC_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'CALC_CORE_URL', plugin_dir_url( __FILE__ ) );

/*
|--------------------------------------------------------------------------
| Shared asset loading
|--------------------------------------------------------------------------
|
| JavaScript and CSS used by all calculators.
| Loaded once, regardless of how many calculators exist on a page.
|
*/
add_action( 'wp_enqueue_scripts', function () {

    wp_enqueue_style(
        'calculator-core-css',
        CALC_CORE_URL . 'assets/css/calculator.css',
        [],
        '1.0.0'
    );

    wp_enqueue_script(
        'calculator-core-js',
        CALC_CORE_URL . 'assets/js/calculator.js',
        [],
        '1.0.0',
        true
    );

} );

/*
|--------------------------------------------------------------------------
| Text lookup API (database abstraction)
|--------------------------------------------------------------------------
|
| Resolves user-facing text for calculators.
| Country-specific text overrides global text.
|
| The database is NOT implemented yet.
| This stub defines the contract.
|
*/
function calc_core_get_text( string $key, ?string $country = null ): string {

    /*
     * TEMPORARY STUB DATA
     * This will later be replaced by DB queries.
     */

    $global_text = [
        'calculate_button' => 'Calculate',
    ];

    $country_text = [
        'DE' => [
            'citizenship_question_label' => 'Are you a German citizen?',
        ],
        'FR' => [
            'citizenship_question_label' => 'Are you a French citizen?',
        ],
    ];

    // 1. Country-specific override
    if (
        $country !== null &&
        isset( $country_text[ $country ][ $key ] )
    ) {
        return $country_text[ $country ][ $key ];
    }

    // 2. Global fallback
    if ( isset( $global_text[ $key ] ) ) {
        return $global_text[ $key ];
    }

    /*
     * Final fallback:
     * Returning the key itself helps spot missing texts during development.
     */
    return $key;
}
