<?php
/**
 * Plugin Name: Jetpack Stats Script Deprioritization
 * Description: Adds <code>fetchpriority=low</code> to the Jetpack Stats script to reduce network contention with the loading of resources in the critical rendering path. Also removes the <code>dns-prefetch</code>.
 * Requires at least: 6.5
 * Requires PHP: 8.1
 * Version: 0.1.0
 * Author: Weston Ruter
 * Author URI: https://weston.ruter.net/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Update URI: false
 *
 * @package JetpackStatsScriptDeprioritization
 */

namespace JetpackStatsScriptDeprioritization;

// Short-circuit functionality to facilitate benchmarking performance impact.
if ( isset( $_GET['disable_jetpack_stats_script_deprioritization'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	return;
}

const HANDLE = 'jetpack-stats';

// Add fetchpriority=low to the Stats script.
add_filter(
	'wp_script_attributes',
	static function ( $attributes ): array {
		if ( ! is_array( $attributes ) ) {
			$attributes = array();
		}

		if (
			isset( $attributes['id'] ) &&
			HANDLE . '-js' === $attributes['id']
		) {
			$attributes['fetchpriority'] = 'low';
		}

		return $attributes;
	}
);

// Undo wp_dependencies_unique_hosts() for Jetpack Stats.
// TODO: wp_dependencies_unique_hosts() could omit adding any resource hints for dependencies with low priority.
add_filter(
	'wp_resource_hints',
	static function ( $urls, $relation_type ): array {
		if ( ! is_array( $urls ) ) {
			$urls = array();
		}
		if ( 'dns-prefetch' === $relation_type ) {
			$urls = array_filter(
				$urls,
				static function ( $url ): bool {
					return is_string( $url ) && ! str_contains( $url, 'stats.wp.com' );
				}
			);
		}
		return $urls;
	},
	100,
	2
);
