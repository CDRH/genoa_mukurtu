<?php

/**
 * Implements hook_form_FORM_ID_alter().
 */
function mukurtu_subtheme_form_system_theme_settings_alter(&$form, $form_state, $form_id = NULL) {
  // Mukurtu.
  $form['mukurtu_subtheme'] = array(
    '#type' => 'fieldset',
    '#title' => t('mukurtu_subtheme'),
    //'#group' => 'mukurtu_subtheme',
  );

  //// Color Scheme
  $form['mukurtu_subtheme']['colors'] = array(
    '#type' => 'fieldset',
    '#title' => t('Color Scheme'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  // Pick color scheme
  $form['mukurtu_subtheme']['colors']['mukurtu_subtheme_theme_color_scheme'] = array(
    '#type' => 'radios',
    '#title' => t('Select default color scheme for the Mukurtu theme'),
    '#default_value' => theme_get_setting('mukurtu_subtheme_theme_color_scheme', 'mukurtu_subtheme'),
    '#options' => array('blue-gold' => 'Blue & Gold', 'red-bone' => 'Red & Bone', 'neutral' => 'Neutral')
  );

  //// Default Images
  /*
  $form['mukurtu_subtheme']['images'] = array(
    '#type' => 'fieldset',
    '#title' => t('Default Images'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  // Default audio thumbnail
  $form['mukurtu_subtheme']['images']['mukurtu_subtheme_theme_default_audio_image'] = array(
    '#title' => t('Default Audio Thumbnail'),
    '#type' => 'managed_file',
    '#description' => t('The image to be used when an audio atom does not have a thumbnail.'),
    '#default_value' => variable_get('mukurtu_subtheme_theme_default_audio_image', ''),
    '#upload_location' => 'public://',
  );
  */

  //// Footer.
  $form['mukurtu_subtheme']['footer'] = array(
    '#type' => 'fieldset',
    '#title' => t('Footer'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  // Email us text.
  $form['mukurtu_subtheme']['footer']['mukurtu_subtheme_theme_email_us_message'] = array(
    '#type' => 'textfield',
    '#title' => t('Email us text'),
    '#default_value' => theme_get_setting('mukurtu_subtheme_theme_email_us_message', 'mukurtu_subtheme'),
    '#description'   => t("Leave empty to omit from display."),
  );

  // Contact email.
  $form['mukurtu_subtheme']['footer']['mukurtu_subtheme_theme_contact_email'] = array(
    '#type' => 'textfield',
    '#title' => t('Contact email address'),
    '#default_value' => theme_get_setting('mukurtu_subtheme_theme_contact_email', 'mukurtu_subtheme'),
    '#description'   => t("Leave empty to omit from display."),
  );

  // Twitter.
  $form['mukurtu_subtheme']['footer']['mukurtu_subtheme_theme_twitter_message'] = array(
    '#type' => 'textfield',
    '#title' => t('Twitter message text'),
    '#default_value' => theme_get_setting('mukurtu_subtheme_theme_twitter_message', 'mukurtu_subtheme'),
    '#description'   => t("Leave empty to omit from display."),
  );

  $form['mukurtu_subtheme']['footer']['mukurtu_subtheme_theme_twitter1'] = array(
    '#type' => 'textfield',
    '#title' => t('First Twitter account'),
    '#default_value' => theme_get_setting('mukurtu_subtheme_theme_twitter1', 'mukurtu_subtheme'),
    '#description'   => t("Leave empty to omit from display."),
  );

  $form['mukurtu_subtheme']['footer']['mukurtu_subtheme_theme_twitter2'] = array(
    '#type' => 'textfield',
    '#title' => t('Second Twitter account'),
    '#default_value' => theme_get_setting('mukurtu_subtheme_theme_twitter2', 'mukurtu_subtheme'),
    '#description'   => t("Leave empty to omit from display."),
  );

  // Copyright message.
  $form['mukurtu_subtheme']['footer']['mukurtu_subtheme_theme_copyright'] = array(
    '#type' => 'textfield',
    '#title' => t('Footer Copyright Message'),
    '#default_value' => theme_get_setting('mukurtu_subtheme_theme_copyright', 'mukurtu_subtheme'),
    '#description'   => t("Use replacement token [year] for the current year."),
  );

  //// Frontpage
    $form['mukurtu_subtheme']['frontpage'] = array(
    '#type' => 'fieldset',
    '#title' => t('Frontpage'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  // Frontpage Layout
  $form['mukurtu_subtheme']['frontpage']['mukurtu_subtheme_theme_frontpage_layout'] = array(
    '#type' => 'radios',
    '#title' => t('Frontpage Layout'),
    '#default_value' => theme_get_setting('mukurtu_subtheme_theme_frontpage_layout', 'mukurtu_subtheme'),
    '#options' => array('large-hero' => 'Large hero image', 'side-by-side' => 'Smaller hero image with welcome message')
  );

  // Hero Image
  /*
  $form['mukurtu_subtheme']['frontpage']['mukurtu_subtheme_theme_frontpage_hero_image'] = array(
    '#title' => t('Hero Image'),
    '#type' => 'managed_file',
    '#description' => t(''),
    '#default_value' => theme_get_setting('mukurtu_subtheme_theme_frontpage_hero_image'),
    '#upload_location' => 'public://theme/mukurtu/',
  );
  */
}
