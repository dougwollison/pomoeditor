<?php
/**
 * POMOEdit Internal Functions
 *
 * @package POMOEdit
 * @subpackage Utilities
 *
 * @internal
 *
 * @since 1.0.0
 */

namespace POMOEdit;

/**
 * Check if the current directory matches one of the provided paths.
 *
 * @since 1.0.0
 *
 * @param string $dir  The directory to match.
 * @param string $list The list of directories to match against (colon-separated).
 *
 * @return bool Wether or not the directory is within one of the ones listed.
 */
function match_path( $dir, $list ) {
	// Split the list into individual directories
	$list = explode( ':', $list );

	// Loop through, see if $dir is within any of them
	foreach ( $list as $path ) {
		// If not an absolute path, prefix with WP_CONTENT_DIR
		if ( strpos( $path, '/' ) !== 0 ) {
			$path = WP_CONTENT_DIR . '/' . $path;
		}

		// Test if $dir starts with the path
		if ( strpos( $dir, rtrim( $path, '/' ) ) === 0 ) {
			return true;
		}
	}

	return false;
}

/**
 * Check if a path is permitted by the whitelist/blacklist.
 *
 * @since 1.0.0
 *
 * @param string $dir The directory to check.
 *
 * @return bool Wether or not the path is permitted by the whitelist/blacklist.
 */
function is_path_permitted( $path ) {
	// Check if POMOEDIT_SCAN_WHITELIST is defined, set $skip to TRUE if no match
	if ( defined( 'POMOEDIT_SCAN_WHITELIST' ) && ! match_path( $path, POMOEDIT_SCAN_WHITELIST ) ) {
		return false;
	}

	// Check if POMOEDIT_SCAN_BLACKLIST is defined, set $skip to TRUE if matched
	if ( defined( 'POMOEDIT_SCAN_BLACKLIST' ) && match_path( $path, POMOEDIT_SCAN_BLACKLIST ) ) {
		return false;
	}

	return true;
}