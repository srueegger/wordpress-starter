<?php
/* Einstellungen für Gravity Forms */

/***************************************
 * Gravity Forms, die CSV Exporte nutzen als Trennzeichen ein ";" statt ein "," -> bessere Kompatibilität mit Microsoft Excel auf Windows
 ***************************************/
function compresso_gform_export_separator($separator, $formId) {
  return ";";
}
add_filter( 'gform_export_separator', 'compresso_gform_export_separator', 10, 2);

/***************************************
 * Add Bootstrap Classes to Gravityforms Submit Button
 ***************************************/
function compresso_add_custom_css_classes_to_gravityform_button( $button, $form ) {
  $dom = new DOMDocument();
  $dom->loadHTML( $button );
  $input = $dom->getElementsByTagName( 'input' )->item(0);
  $classes = "btn btn-primary"; /* Hier können die Klassen angepasst werden */
  $input->setAttribute( 'class', $classes );
  return $dom->saveHtml( $input );
}
add_filter( 'gform_submit_button', 'compresso_add_custom_css_classes_to_gravityform_button', 10, 2 );

/***************************************
 * PLZ vor Ort im Adressfeld anzeigen (Richtige Reihenfolge für Schweiz)
 ***************************************/
function compresso_address_format( $format ) {
  return 'zip_before_city';
}
add_filter( 'gform_address_display_format', 'compresso_address_format' );