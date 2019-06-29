<?php
/**
 * This file controls what content is rendered on the "Home" page of our site
 * as selected through WP Admin.
 *
 * @since 1.0.0
 * @author CreativeFuse
 *
 * NOTE: If you wish to override existing action hook output, you must first
 * remove the action hooks that generate that output. Note also that, when removing these actions
 * you must match the action hook name, fully namespaced function name AND the action hook priority.
 *
 * @see `layouts/template/landing.php` to see this in action
 *
 */

namespace Fuse\Layout\FrontPage;
use function Fuse\Controllers\render as render;
use Fuse\AssetHandlers;
use Samrap\Acf\Acf;


// Fire our setup once we have all  Wordpress data
add_action( 'wp', __NAMESPACE__ . '\setup');

function setup(){

	// If we are on the Front Page of our site
	if( is_front_page() ){


		// Load page sections
		add_action( 'fuse_before_content', __NAMESPACE__ . '\load_hero', 1);
		add_action( 'fuse_content', __NAMESPACE__ . '\load_intro', 1);
		add_action( 'fuse_content', __NAMESPACE__ . '\load_featured_projects', 2);
		add_action( 'fuse_content', __NAMESPACE__ . '\load_what_we_do', 3);
		add_action( 'fuse_content', __NAMESPACE__ . '\load_image_banner', 4);
		add_action( 'fuse_content', __NAMESPACE__ . '\load_clients', 5);
		add_action( 'fuse_content', __NAMESPACE__ . '\load_cta', 6);

	}
}

/*************************************************************
 * The following will be loaded when the conditional check in
 * setup() returns true.
 ************************************************************/


function load_hero(){

	$data = [

		'title'		=> Acf::field( 'title' )->get(),
		'copy'		=> Acf::field( 'subtitle' )->get(),

		'primary_action'	=> [

			'btn_text'		=> Acf::field( 'primary_action_text' )->get(),
			'btn_url'		=> Acf::field( 'primary_action_link' )->get(),
			'btn_type'		=> 'primary',
			'btn_theme'		=> 'purple',
			'btn_modifier'	=> '',

		],

		'secondary_action'	=> [

			'btn_text'		=> Acf::field( 'secondary_action_text' )->get(),
			'btn_url'		=> Acf::field( 'secondary_action_link' )->get(),
			'btn_type'		=> 'secondary',
			'btn_theme'		=> 'dark',
			'btn_modifier'	=> '',

		],

		'background'	=> [
			'image_url'		=> Acf::field( 'background_image' )->get(),
			'video_id'		=> Acf::field( 'background_video_id' )->get(),
			'overlay_type'	=> 'white--90'
		]

	];

	render( 'fragments/components/hero/_c-hero--home', $data );

}

function load_intro(){

	$section_data = [

		'copy'	=> Acf::field( 'intro_copy' )->get()

	];

	render( 'fragments/sections/home/_intro', $section_data );

}



function load_featured_projects(){

	$section_data = [

		'title'	=> Acf::field( 'projects_section_title' )->get(),
		'copy'	=> Acf::field( 'projects_section_copy' )->get(),

		'action'	=> [
			'btn_text'	=>	Acf::field( 'projects_section_action_text' )->get(),
			'btn_url'	=>	Acf::field( 'projects_section_action_link' )->get(),
			'btn_type'	=> 'tertiary',
			'btn_theme'	=> 'dark'
		],
	];

	render( 'fragments/sections/home/_featured-projects', $section_data );

}

function load_what_we_do(){

	$section_data = [

		'videography_island' => [

			'title'		=> Acf::field( 'videography_section_title' )->get(),
			'copy'		=> Acf::field( 'videography_section_copy' )->get(),
			'type'		=> 'light',

			'action'	=> [

				'btn_text'	=> Acf::field( 'videography_section_action_text' )->get(),
				'btn_url'	=> Acf::field( 'videography_section_action_link' )->get(),
				'btn_type'	=> 'tertiary',
				'btn_theme'	=> 'dark'

			],

			'background' => [

				'image_url'	=> 'https://picsum.photos/1000/602',

			]


		],

		'photography_island' => [

			'title'		=> Acf::field( 'photography_section_title' )->get(),
			'copy'		=> Acf::field( 'photography_section_copy' )->get(),
			'type'		=> 'light',


			'action'	=> [

				'btn_text'	=> Acf::field( 'photography_section_action_text' )->get(),
				'btn_url'	=> Acf::field( 'photography_section_action_link' )->get(),
				'btn_type'	=> 'tertiary',
				'btn_theme'	=> 'dark'

			],

			'background' => [

				'image_url'	=> 'https://picsum.photos/1000/600',

			]


		],

	];

	render( 'fragments/sections/home/_what-we-do', $section_data );


}

function load_image_banner(){


	$section_data = [

		'image_url'		=> '',
		'image_alt'		=> '',
		'image_width'	=> '1920',
		'image_height'	=> '1080',

	];

	render( 'fragments/sections/home/_image-banner', $section_data );

}

function load_clients(){


	$section_data = [

		'title'			=> Acf::field('clients_section_title')->get(),
		'client_logos'	=> Acf::field('client_logos')->get(),

		'action'	=> [

			'btn_text'	=> Acf::field('clients_section_action_text')->get(),
			'btn_url'	=> Acf::field('clients_section_action_link')->get(),
			'btn_type'	=> 'tertiary',
			'btn_theme'	=> 'dark'

		],

	];

	render( 'fragments/sections/home/_clients', $section_data );

}

function load_cta(){

	if( ! get_field( 'load_cta' ) ){
		return;
	}

	global $post;

	$cta_data = [

		'type'			=> 'simple',
		'title'			=> Acf::field( 'cta_title' )->escape( 'esc_html' )->get(),
		'copy'			=> Acf::field( 'cta_copy' )->escape( 'esc_html' )->get(),
		'modifier_class'	=> 'c-cta--home',
		'action'	=> [

			'btn_type'	=> 'primary',
			'btn_text'	=> Acf::field( 'cta_action_text' )->escape()->get(),
			'btn_url'	=> Acf::field( 'cta_action_link' )->default( home_url('/contact') )->escape( 'esc_url' )->get(),
			'btn_theme'	=> 'white',

		],
		'bg_image'	=> [
			'image_url' => Acf::field( 'cta_bg' )->default( 'https://picsum.photos/1920/500' )->get()
		]

	];

	render( 'fragments/components/_c-cta', $cta_data );

}
