<?php

/**
 * Implements hook_form_FORM_ID_alter().
 */
function genoa_mukurtu_form_system_theme_settings_alter(&$form, $form_state, $form_id = NULL) {
  // genoa_mukurtu.
  $form['genoa_mukurtu'] = array(
    '#type' => 'fieldset',
    '#title' => t('genoa_mukurtu'),
    //'#group' => 'genoa_mukurtu',
  );

  //// Color Scheme
  $form['genoa_mukurtu']['colors'] = array(
    '#type' => 'fieldset',
    '#title' => t('Color Scheme'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  // Pick color scheme
  $form['genoa_mukurtu']['colors']['genoa_mukurtu_theme_color_scheme'] = array(
    '#type' => 'radios',
    '#title' => t('Select default color scheme for the genoa_mukurtu theme'),
    '#default_value' => theme_get_setting('genoa_mukurtu_theme_color_scheme', 'genoa_mukurtu'),
    '#options' => array('blue-gold' => 'Blue & Gold', 'red-bone' => 'Red & Bone')
  );

  //// Default Images
  /*
  $form['genoa_mukurtu']['images'] = array(
    '#type' => 'fieldset',
    '#title' => t('Default Images'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  // Default audio thumbnail
  $form['genoa_mukurtu']['images']['genoa_mukurtu_theme_default_audio_image'] = array(
    '#title' => t('Default Audio Thumbnail'),
    '#type' => 'managed_file',
    '#description' => t('The image to be used when an audio atom does not have a thumbnail.'),
    '#default_value' => variable_get('genoa_mukurtu_theme_default_audio_image', ''),
    '#upload_location' => 'public://',
  );
  */

  //// Footer.
  $form['genoa_mukurtu']['footer'] = array(
    '#type' => 'fieldset',
    '#title' => t('Footer'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  // Email us text.
  $form['genoa_mukurtu']['footer']['genoa_mukurtu_theme_email_us_message'] = array(
    '#type' => 'textfield',
    '#title' => t('Email us text'),
    '#default_value' => theme_get_setting('genoa_mukurtu_theme_email_us_message', 'genoa_mukurtu'),
    '#description'   => t("Leave empty to omit from display."),
  );

  // Contact email.
  $form['genoa_mukurtu']['footer']['genoa_mukurtu_theme_contact_email'] = array(
    '#type' => 'textfield',
    '#title' => t('Contact email address'),
    '#default_value' => theme_get_setting('genoa_mukurtu_theme_contact_email', 'genoa_mukurtu'),
    '#description'   => t("Leave empty to omit from display."),
  );

  // Twitter.
  $form['genoa_mukurtu']['footer']['genoa_mukurtu_theme_twitter_message'] = array(
    '#type' => 'textfield',
    '#title' => t('Twitter message text'),
    '#default_value' => theme_get_setting('genoa_mukurtu_theme_twitter_message', 'genoa_mukurtu'),
    '#description'   => t("Leave empty to omit from display."),
  );

  $form['genoa_mukurtu']['footer']['genoa_mukurtu_theme_twitter1'] = array(
    '#type' => 'textfield',
    '#title' => t('First Twitter account'),
    '#default_value' => theme_get_setting('genoa_mukurtu_theme_twitter1', 'genoa_mukurtu'),
    '#description'   => t("Leave empty to omit from display."),
  );

  $form['genoa_mukurtu']['footer']['genoa_mukurtu_theme_twitter2'] = array(
    '#type' => 'textfield',
    '#title' => t('Second Twitter account'),
    '#default_value' => theme_get_setting('genoa_mukurtu_theme_twitter2', 'genoa_mukurtu'),
    '#description'   => t("Leave empty to omit from display."),
  );

  // Copyright message.
  $form['genoa_mukurtu']['footer']['genoa_mukurtu_theme_copyright'] = array(
    '#type' => 'textfield',
    '#title' => t('Footer Copyright Message'),
    '#default_value' => theme_get_setting('genoa_mukurtu_theme_copyright', 'genoa_mukurtu'),
    '#description'   => t("Use replacement token [year] for the current year."),
  );

  //// Frontpage
    $form['genoa_mukurtu']['frontpage'] = array(
    '#type' => 'fieldset',
    '#title' => t('Frontpage'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  // Frontpage Layout
  $form['genoa_mukurtu']['frontpage']['genoa_mukurtu_theme_frontpage_layout'] = array(
    '#type' => 'radios',
    '#title' => t('Frontpage Layout'),
    '#default_value' => theme_get_setting('genoa_mukurtu_theme_frontpage_layout', 'genoa_mukurtu'),
    '#options' => array('large-hero' => 'Large hero image', 'side-by-side' => 'Smaller hero image with welcome message')
  );

  // Hero Image
  /*
  $form['genoa_mukurtu']['frontpage']['genoa_mukurtu_theme_frontpage_hero_image'] = array(
    '#title' => t('Hero Image'),
    '#type' => 'managed_file',
    '#description' => t(''),
    '#default_value' => theme_get_setting('genoa_mukurtu_theme_frontpage_hero_image'),
    '#upload_location' => 'public://theme/genoa_mukurtu/',
  );
  */
}
