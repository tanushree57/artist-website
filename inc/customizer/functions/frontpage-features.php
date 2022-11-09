<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Eventsia
 * @since Eventsia 1.0
 */


$eventsia_settings = eventsia_get_theme_options();
$eventsia_categories_lists = eventsia_categories_lists();

/* About Us Section */
$wp_customize->add_setting( 'eventsia_theme_options[eventsia_disable_about_us]', array(
	'default' => $eventsia_settings['eventsia_disable_about_us'],
	'sanitize_callback' => 'eventsia_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_disable_about_us]', array(
	'priority' => 410,
	'label' => __('Disable About Us Section', 'eventsia'),
	'section' => 'eventsia_frontpage_about_us',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'eventsia_theme_options[eventsia-img-upload-aboutus-bg-image]',array(
		'default'	=> $eventsia_settings['eventsia-img-upload-aboutus-bg-image'],
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
		'type' => 'option',
	));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'eventsia_theme_options[eventsia-img-upload-aboutus-bg-image]', array(
	'label' => __('About Us Background Image','eventsia'),
	'description' => __('Image will be displayed on background','eventsia'),
	'priority'	=> 460,
	'section' => 'eventsia_frontpage_about_us',
	)
));

$wp_customize->add_setting('eventsia_theme_options[eventsia_about_us]', array(
	'default' =>$eventsia_settings['eventsia_about_us'],
	'sanitize_callback' =>'eventsia_sanitize_dropdown_pages',
	'type' => 'option',
	'capability' => 'manage_options'
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_about_us]', array(
	'priority' => 470,
	'label' => __('About Us Page', 'eventsia'),
	'section' => 'eventsia_frontpage_about_us',
	'type' => 'dropdown-pages',
	'allow_addition' => true,
));

/* Upcoming Event Section */
$wp_customize->add_setting( 'eventsia_theme_options[eventsia_disable_upcoming]', array(
	'default' => $eventsia_settings['eventsia_disable_upcoming'],
	'sanitize_callback' => 'eventsia_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_disable_upcoming]', array(
	'priority' => 600,
	'label' => __('Disable Upcoming Event', 'eventsia'),
	'section' => 'eventsia_upcoming_features',
	'type' => 'checkbox',
));

$wp_customize->add_setting('eventsia_theme_options[eventsia_upcoming_status]', array(
		'default' => $eventsia_settings['eventsia_upcoming_status'],
		'sanitize_callback' => 'eventsia_sanitize_select',
		'type' => 'option',
));
$wp_customize->add_control('eventsia_theme_options[eventsia_upcoming_status]', array(
	'priority' =>610,
	'label' => __('Display Upcoming Event', 'eventsia'),
	'section' => 'eventsia_upcoming_features',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
		'publish' => __('Default/ Publish','eventsia'),
		'future' => __('Scheduled','eventsia'),
	),
));

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_upcoming_title]', array(
	'default' => $eventsia_settings['eventsia_upcoming_title'],
	'sanitize_callback' => 'sanitize_text_field',
	'type' => 'option',
	'capability' => 'manage_options'
	)
);
$wp_customize->add_control( 'eventsia_theme_options[eventsia_upcoming_title]', array(
	'priority' => 620,
	'label' => __( 'Title', 'eventsia' ),
	'section' => 'eventsia_upcoming_features',
	'settings' => 'eventsia_theme_options[eventsia_upcoming_title]',
	'type' => 'text',
	'active_callback' => 'eventsia_upcoming_title_callback',
	)
);

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_upcoming_bg_image]',array(
	'default'	=> $eventsia_settings['eventsia_upcoming_bg_image'],
	'capability' => 'edit_theme_options',
	'sanitize_callback' => 'esc_url_raw',
	'type' => 'option',
));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'eventsia_theme_options[eventsia_upcoming_bg_image]', array(
	'label' => __('Background Image','eventsia'),
	'description' => __('Image will be displayed on background of Upcoming Event','eventsia'),
	'priority'	=> 630,
	'section' => 'eventsia_upcoming_features',
	)
));

$wp_customize->add_setting(
	'eventsia_theme_options[eventsia_upcoming_category_list]', array(
		'default'				=>$eventsia_settings['eventsia_upcoming_category_list'],
		'capability'			=> 'manage_options',
		'sanitize_callback'	=> 'eventsia_sanitize_category_select',
		'type'				=> 'option'
	)
);
$wp_customize->add_control( 'eventsia_theme_options[eventsia_upcoming_category_list]',
		array(
			'priority' => 640,
			'label'       => __( 'Select Category', 'eventsia' ),
			'section'     => 'eventsia_upcoming_features',
			'settings'	  => 'eventsia_theme_options[eventsia_upcoming_category_list]',
			'type'        => 'select',
			'choices'	=>  $eventsia_categories_lists,
			'active_callback' => 'eventsia_category_callback',
		)
);

	/* Our Speaker */
$wp_customize->add_setting( 'eventsia_theme_options[eventsia_disable_our_speaker]', array(
	'default' => $eventsia_settings['eventsia_disable_our_speaker'],
	'sanitize_callback' => 'eventsia_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_disable_our_speaker]', array(
	'priority' => 700,
	'label' => __('Disable Our Speaker', 'eventsia'),
	'section' => 'eventsia_our_speaker_features',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_our_speaker_title]', array(
	'default' => $eventsia_settings['eventsia_our_speaker_title'],
	'sanitize_callback' => 'sanitize_text_field',
	'type' => 'option',
	'capability' => 'manage_options'
	)
);
$wp_customize->add_control( 'eventsia_theme_options[eventsia_our_speaker_title]', array(
	'priority' => 710,
	'label' => __( 'Title', 'eventsia' ),
	'section' => 'eventsia_our_speaker_features',
	'settings' => 'eventsia_theme_options[eventsia_our_speaker_title]',
	'type' => 'text',
	)
);
$wp_customize->add_setting( 'eventsia_theme_options[eventsia-img-upload-speaker-bg-image]',array(
		'default'	=> $eventsia_settings['eventsia-img-upload-speaker-bg-image'],
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
		'type' => 'option',
	));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'eventsia_theme_options[eventsia-img-upload-speaker-bg-image]', array(
	'label' => __('Background Image','eventsia'),
	'description' => __('Image will be displayed on background','eventsia'),
	'priority'	=> 720,
	'section' => 'eventsia_our_speaker_features',
	)
));
for ( $i=1; $i <= $eventsia_settings['eventsia_total_our_speaker'] ; $i++ ) {
	$wp_customize->add_setting('eventsia_theme_options[eventsia_our_speaker_features_'. $i .']', array(
		'default' =>'',
		'sanitize_callback' =>'eventsia_sanitize_dropdown_pages',
		'type' => 'option',
		'capability' => 'manage_options'
	));
	$wp_customize->add_control( 'eventsia_theme_options[eventsia_our_speaker_features_'. $i .']', array(
		'priority' => 73 . $i,
		'label' => __(' Feature #', 'eventsia') . ' ' . $i ,
		'section' => 'eventsia_our_speaker_features',
		'type' => 'dropdown-pages',
		'allow_addition' => true,
	));
	$wp_customize->add_setting( 'eventsia_theme_options[eventsia_our_speaker_position_'. $i .']', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option',
		'capability' => 'manage_options'
	) );
	$wp_customize->add_control( 'eventsia_theme_options[eventsia_our_speaker_position_'. $i .']', array(
		'priority' => 73 . $i,
		'label' => __( 'Speaker Position #', 'eventsia' ) . ' ' . $i ,
		'section' => 'eventsia_our_speaker_features',
		'settings' => 'eventsia_theme_options[eventsia_our_speaker_position_'. $i .']',
		'type' => 'text',
	) );
}

/* Gallery */
$wp_customize->add_setting( 'eventsia_theme_options[eventsia_disable_our_gallery]', array(
	'default' => $eventsia_settings['eventsia_disable_our_gallery'],
	'sanitize_callback' => 'eventsia_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_disable_our_gallery]', array(
	'priority' => 900,
	'label' => __('Disable Gallery', 'eventsia'),
	'section' => 'eventsia_our_gallery_features',
	'type' => 'checkbox',
));
$wp_customize->add_setting( 'eventsia_theme_options[eventsia_our_gallery_title]', array(
	'default' => $eventsia_settings['eventsia_our_gallery_title'],
	'sanitize_callback' => 'sanitize_text_field',
	'type' => 'option',
	'capability' => 'manage_options'
	)
);
$wp_customize->add_control( 'eventsia_theme_options[eventsia_our_gallery_title]', array(
	'priority' => 910,
	'label' => __( 'Title', 'eventsia' ),
	'section' => 'eventsia_our_gallery_features',
	'settings' => 'eventsia_theme_options[eventsia_our_gallery_title]',
	'type' => 'text',
	)
);

for ( $i=1; $i <= $eventsia_settings['eventsia_total_our_gallery'] ; $i++ ) {
	$wp_customize->add_setting('eventsia_theme_options[eventsia_our_gallery_features_'. $i .']', array(
		'default' =>'',
		'sanitize_callback' =>'eventsia_sanitize_dropdown_pages',
		'type' => 'option',
		'capability' => 'manage_options'
	));
	$wp_customize->add_control( 'eventsia_theme_options[eventsia_our_gallery_features_'. $i .']', array(
		'priority' => 93 . $i,
		'label' => __(' Gallery #', 'eventsia') . ' ' . $i ,
		'section' => 'eventsia_our_gallery_features',
		'type' => 'dropdown-pages',
		'allow_addition' => true,
	));
}

/******************* Latest from Blog ******************************************/

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_disable_latest_blog]', array(
    'default' => $eventsia_settings['eventsia_disable_latest_blog'],
    'sanitize_callback' => 'eventsia_checkbox_integer',
    'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_disable_latest_blog]', array(
    'priority' => 600,
    'label' => __('Disable Latest from Blog', 'eventsia'),
    'section' => 'eventsia_lastestfrom_blog_features',
    'type' => 'checkbox',
));

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_latest_blog_title]', array(
    'default' => $eventsia_settings['eventsia_latest_blog_title'],
    'sanitize_callback' => 'sanitize_text_field',
    'type' => 'option',
    'capability' => 'manage_options'
    )
);

$wp_customize->add_control( 'eventsia_theme_options[eventsia_latest_blog_title]', array(
    'priority' => 650,
    'label' => __( 'Title', 'eventsia' ),
    'section' => 'eventsia_lastestfrom_blog_features',
    'settings' => 'eventsia_theme_options[eventsia_latest_blog_title]',
    'type' => 'text',
    'active_callback' => 'eventsia_latest_title_callback',
    )
);
$wp_customize->add_setting('eventsia_theme_options[eventsia_latest_category_blog_section]', array(
        'default' => $eventsia_settings['eventsia_latest_category_blog_section'],
        'sanitize_callback' => 'eventsia_sanitize_select',
        'type' => 'option',
));
$wp_customize->add_control('eventsia_theme_options[eventsia_latest_category_blog_section]', array(
    'priority' =>670,
    'label' => __('Display BLog Display', 'eventsia'),
    'section' => 'eventsia_lastestfrom_blog_features',
    'type' => 'radio',
    'checked' => 'checked',
    'choices' => array(
        'latest_blog' => __('Display Latest Blog','eventsia'),
        'category_display' => __('Display Category','eventsia'),
    ),
));
$wp_customize->add_setting(
	'eventsia_theme_options[eventsia_latest_blog_category_list]', array(
		'default'				=>$eventsia_settings['eventsia_upcoming_category_list'],
		'capability'			=> 'manage_options',
		'sanitize_callback'	=> 'eventsia_sanitize_category_select',
		'type'				=> 'option'
	)
);
$wp_customize->add_control( 'eventsia_theme_options[eventsia_latest_blog_category_list]',
		array(
			'priority' => 680,
			'label'       => __( 'Select Category', 'eventsia' ),
			'section'     => 'eventsia_lastestfrom_blog_features',
			'settings'	  => 'eventsia_theme_options[eventsia_latest_blog_category_list]',
			'type'        => 'select',
			'choices'	=>  $eventsia_categories_lists,
			'active_callback' => 'eventsia_latest_blogtitle_callback',
		)
);

/* Testimonial Box */
$wp_customize->add_setting( 'eventsia_theme_options[eventsia_disable_our_testimonial]', array(
	'default' => $eventsia_settings['eventsia_disable_our_testimonial'],
	'sanitize_callback' => 'eventsia_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_disable_our_testimonial]', array(
	'priority' => 1000,
	'label' => __('Disable Testimonial', 'eventsia'),
	'section' => 'eventsia_our_testimonial_features',
	'type' => 'checkbox',
));
$wp_customize->add_setting( 'eventsia_theme_options[eventsia_our_testimonial_title]', array(
	'default' => $eventsia_settings['eventsia_our_testimonial_title'],
	'sanitize_callback' => 'sanitize_text_field',
	'type' => 'option',
	'capability' => 'manage_options'
	)
);

$wp_customize->add_control( 'eventsia_theme_options[eventsia_our_testimonial_title]', array(
	'priority' => 1010,
	'label' => __( 'Title', 'eventsia' ),
	'section' => 'eventsia_our_testimonial_features',
	'settings' => 'eventsia_theme_options[eventsia_our_testimonial_title]',
	'type' => 'text',
	)
);
$wp_customize->add_setting( 'eventsia_theme_options[eventsia_our_testimonial_bg_image]',array(
	'default'	=> $eventsia_settings['eventsia_our_testimonial_bg_image'],
	'capability' => 'edit_theme_options',
	'sanitize_callback' => 'esc_url_raw',
	'type' => 'option',
));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'eventsia_theme_options[eventsia_our_testimonial_bg_image]', array(
	'label' => __('Background Image','eventsia'),
	'description' => __('Image will be displayed on background on Testimonial','eventsia'),
	'priority'	=> 1030,
	'section' => 'eventsia_our_testimonial_features',
	)
));
for ( $i=1; $i <= $eventsia_settings['eventsia_total_our_testimonial'] ; $i++ ) {
	$wp_customize->add_setting('eventsia_theme_options[eventsia_our_testimonial_features_'. $i .']', array(
		'default' =>'',
		'sanitize_callback' =>'eventsia_sanitize_dropdown_pages',
		'type' => 'option',
		'capability' => 'manage_options'
	));
	$wp_customize->add_control( 'eventsia_theme_options[eventsia_our_testimonial_features_'. $i .']', array(
		'priority' => 103 . $i,
		'label' => __(' Testimonial #', 'eventsia') . ' ' . $i ,
		'section' => 'eventsia_our_testimonial_features',
		'type' => 'dropdown-pages',
		'allow_addition' => true,
	));
}

/* Client Box */
$wp_customize->add_setting( 'eventsia_theme_options[eventsia_disable_sponsors_box]', array(
    'default' => $eventsia_settings['eventsia_disable_sponsors_box'],
    'sanitize_callback' => 'eventsia_checkbox_integer',
    'type' => 'option',
));
$wp_customize->add_control( 'eventsia_theme_options[eventsia_disable_sponsors_box]', array(
    'priority' => 10,
    'label' => __('Disable Client Box', 'eventsia'),
    'section' => 'eventsia_our_clientbox_features',
    'type' => 'checkbox',
));

$wp_customize->add_setting('eventsia_theme_options[eventsia_sponsors_box_image_heading]', array(
    'default' => $eventsia_settings['eventsia_sponsors_box_image_heading'],
    'sanitize_callback' => 'sanitize_text_field',
    'type' => 'option',
    'capability' => 'manage_options'
));
$wp_customize->add_control('eventsia_theme_options[eventsia_sponsors_box_image_heading]', array(
    'priority' => 30,
    'label' => __('Client Box Title', 'eventsia'),
    'section' => 'eventsia_our_clientbox_features',
    'type' => 'text',
) );

$wp_customize->add_setting( 'eventsia_theme_options[eventsia_sponsors_bg_image]',array(
	'default'	=> $eventsia_settings['eventsia_sponsors_bg_image'],
	'capability' => 'edit_theme_options',
	'sanitize_callback' => 'esc_url_raw',
	'type' => 'option',
));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'eventsia_theme_options[eventsia_sponsors_bg_image]', array(
	'label' => __('Background Image','eventsia'),
	'description' => __('Image will be displayed on background on Client Box','eventsia'),
	'priority'	=> 10,
	'section' => 'eventsia_our_clientbox_features',
	)
));

    for ( $i=1; $i <= $eventsia_settings['eventsia_sponsors_box_no'] ; $i++ ) {
    $wp_customize->add_setting('eventsia_theme_options[eventsia_sponsors_box_image_'. $i .']', array(
        'default'   =>$eventsia_settings['eventsia_sponsors_box_image_'. $i ],
        'sanitize_callback' =>'esc_url_raw',
        'type'  => 'option',
        'capability'    => 'manage_options'
    ));
    $wp_customize->add_control(
    new WP_Customize_Image_Control(
        $wp_customize,
            'eventsia_theme_options[eventsia_sponsors_box_image_'. $i .']',
            array(
            'priority'  => 50 . $i,
            'label' => ' Image #' . $i,
            'description'   => __('Recommended Size (200*60)','eventsia'),
            'section'   => 'eventsia_our_clientbox_features',
            )
        )
    );
    $wp_customize->add_setting('eventsia_theme_options[eventsia_redirect_link'. $i .']', array(
        'default'   =>$eventsia_settings['eventsia_redirect_link'. $i ],
        'sanitize_callback' =>'esc_url_raw',
        'type'  => 'option',
        'capability'    => 'manage_options'
    ));
    $wp_customize->add_control( 'eventsia_theme_options[eventsia_redirect_link'. $i .']', array(
        'priority'  => 50 . $i,
        'label' => __(' Redirect Link #', 'eventsia') . ' ' . $i ,
        'section'   => 'eventsia_our_clientbox_features',
        'type'  => 'text',
    ));
}