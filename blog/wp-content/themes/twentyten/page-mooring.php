<?php
/**
 * Template Name: Moorings
 *
 * This is the template that displays a list of moorings and a search form
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

/** 
 * The following lines is needed in order to use the autocomplete feature of the mooring_search_form() 
 * It MUST preceed the get_header() call
 */

mooring_scripts();

// Get header
get_header(); ?>

<div id="container">
    <div id="content" role="main">
    
    <?php // Display the search form ?>
    
    <?php mooring_search_form(); ?>

    <?php // Display the list of moorings ?>
    
    <?php moorings(); ?>

    </div><!-- #content -->
</div><!-- #container -->

<?php get_footer("moorings"); ?>
