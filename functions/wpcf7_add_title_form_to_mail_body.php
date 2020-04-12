<?php

add_action( 'wpcf7_before_send_mail', 'wpcf7_add_title_form_to_mail_body' );

/**
 * @param WPCF7_ContactForm $contact_form
 */
function wpcf7_add_title_form_to_mail_body( $contact_form ) {
	$form_title = $contact_form->title();
	$form_mail  = $contact_form->prop( 'mail' );

	$form_mail['body'] .= "\n\nНазвание формы: $form_title";

	$contact_form->set_properties( [ 'mail' => $form_mail ] );
}