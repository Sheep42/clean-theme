<?php

class TestThemeFunctions extends WP_UnitTestCase {

	function test_theme_enabled() {
		
		$this->assertTrue( 
			'Clean-Theme' == wp_get_theme(), 
			'Registered theme name does not equal "cleantheme"' 
		);

	}

	function test_theme_support() {

		$features = [
			'title-tag',
			'post-thumbnails',
		];

		foreach( $features as $feature ) {
			$this->assertTrue( 
				current_theme_supports( $feature ),
				sprintf( 'Expected feature "%s" is not supported', $feature ) 
			);
		}

	}

	function test_custom_image_sizes() {

		$sizes = [
			'cleantheme-featured-image',
			'cleantheme-thumbnail-avatar',
		];

		foreach( $sizes as $size ) {
			$this->assertTrue( 
				has_image_size( $size ), 
				sprintf( 'Expected size "%s" is not registered', $size ) 
			);
		}

	}

	function test_google_fonts_url() {

		$url = cleantheme_google_fonts_url();
		$valid_url = wp_http_validate_url( $url );

		$this->assertFalse( 
			empty( $url ),
			'cleantheme_google_fonts_url returns an empty string' 
		);

		$this->assertFalse( 
			false === $valid_url,
			'cleantheme_google_fonts_url returns an invalid url'
		);

		$this->assertTrue(
			$url == $valid_url,
			'cleantheme_google_fonts_url returns a malformed url'
		);

	}

	function test__cleantheme_get_cache_version_caching_wp_debug() {

		if( !defined('WP_DEBUG') )
			define( 'WP_DEBUG', true );

		$test_files = [
			'main.min.js' => get_template_directory() . '/assets/js/build/theme/', 
			'style.css' => trailingslashit( get_template_directory() ),
		];

		foreach( $test_files as $test_file => $path) {

			$cache_version = _cleantheme_get_cache_version( $test_file );
			$file_sha = hash_file( 'sha256', $path . $test_file );

			$this->assertFalse( 
				$file_sha == $cache_version,
				sprintf( 
					"cache_version should not match file sha for %s, when WP_DEBUG is active:\n\ncache version: %s\nfile sha: %s", 
					$test_file, 
					$cache_version, 
					$file_sha 
				)
			);

		}

	}

	function test__cleantheme_get_cache_version_always_cache() {

		if( !defined('ALWAYS_CACHE') )
			define( 'ALWAYS_CACHE', true );
		
		$test_files = [
			'main.min.js' => get_template_directory() . '/assets/js/build/theme/', 
			'style.css' => trailingslashit( get_template_directory() ),
		];

		foreach( $test_files as $test_file => $path) {

			$cache_version = _cleantheme_get_cache_version( $test_file );
			$file_sha = hash_file( 'sha256', $path . $test_file );

			$this->assertTrue( 
				$file_sha == $cache_version,
				sprintf( 
					"cache_version should match file sha for %s, when WP_DEBUG is not active:\n\ncache version: %s\nfile sha: %s", 
					$test_file, 
					$cache_version, 
					$file_sha 
				)
			);

		}

	}

	function test_cleantheme_doing_ajax() {

		$this->assertFalse( 
			cleantheme_doing_ajax(),
			'cleantheme_doing_ajax check failed'
		);

		define( 'DOING_AJAX', true );

		$this->assertTrue( 
			cleantheme_doing_ajax(),
			'cleantheme_doing_ajax check failed'
		);

	}

	function test_cleantheme_doing_cron() {

		$this->assertFalse( 
			cleantheme_doing_cron(),
			'cleantheme_doing_cron check failed'
		);

		define( 'DOING_CRON', true );

		$this->assertTrue( 
			cleantheme_doing_cron(),
			'cleantheme_doing_cron check failed'
		);

	}

}
