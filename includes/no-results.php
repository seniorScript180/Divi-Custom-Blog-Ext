<?php 

// global $et_no_results_heading_tag;
// if ( empty( $et_no_results_heading_tag ) ){
// 	$et_no_results_heading_tag = 'h1';
// }


$serving_lang_de = 'lang="de-DE"' === get_language_attributes() ? TRUE : FALSE;

echo "<h1>Hello!!!!!!</h1>";

if ($serving_lang_de) {
	?>
		<h1>Es wurden leider keine Suchergebnisse gefunden.</h1>
		<h2>Bitte versuchen Sie es nochmal.</h2>
	<?php
} else {
	?>
		<h1>Sorry, no search results were found.</h1>
		<h2>Please try again.</h2>
	<?php
}



?>




<div class="entry">
<!--If no results are found-->
	<<?php echo $et_no_results_heading_tag; ?> class="not-found-title"><?php esc_html_e('No Results Found','Divi'); ?></<?php echo $et_no_results_heading_tag; ?>>
	<p><?php esc_html_e('The page you requested could not be found. Try refining your search, or use the navigation above to locate the post.','Divi'); ?></p>
</div>
<!--End if no results are found-->