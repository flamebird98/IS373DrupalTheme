<?php

/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct URL of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type; for example, "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type; for example, story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode; for example, "full", "teaser".
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined; for example, $node->body becomes $body. When needing to
 * access a field's raw values, developers/themers are strongly encouraged to
 * use these variables. Otherwise they will have to explicitly specify the
 * desired field language; for example, $node->body['en'], thus overriding any
 * language negotiation rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 *
 * @ingroup themeable
 */
?>

<?php
// get current URL info to determine which layout to render...
$currentURL = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$currentURLarray = explode('/', $currentURL);
$urlArrayCountMinusThree = count($currentURLarray) -3;
$urlArrayCountMinusTwo = count($currentURLarray) -2;
$urlArrayCountMinusOne = count($currentURLarray) -1;
$lastURLsegment = $currentURLarray[$urlArrayCountMinusOne];
$secondToLastURLsegment = $currentURLarray[$urlArrayCountMinusTwo];
$thirdToLastURLsegment = $currentURLarray[$urlArrayCountMinusThree];
?>

<?php if($title == 'About'){ ?>
    <h1 class="main-title">About Drupal</h1>
<?php } else { ?>
    <p class="section-title">About Drupal</p>
<?php } ?>
<?php
if($secondToLastURLsegment == 'event' ||
    $thirdToLastURLsegment == 'event' ||
    $secondToLastURLsegment == "node" ||
    $thirdToLastURLsegment == "node"){
    ?>
    ...render ALL of the Event's content...
<?php } else { ?>
    ...render LESS of the Event's content...
<?php } ?>

<?php print render($content['body']); ?>

<h3 style="color: green; font-size: 30px; padding: 22px; background-color: yellow"><?php print $title; ?></h3>


<div class="eventMedia">
    <?php
    if(!empty($content['field_video'])){
        print render($content['field_video']);
    }
    else{
        print render($content['field_main_image']);
    }
    ?>
</div>

<div style="padding: 22px; font-size: 19px; color: grey;">
<?php print render($content['field_date']); ?>

<?php print render($content['field_location']); ?>

<?php print render($content['body']); ?>

<?php print render($content['field_agenda']); ?>
</div>

<?php
// add specific content based off of the page title...
// get page title (must be written exactly as in Drupal 'title' field)...
if($node->title == 'Regional Event'){
    ?>
    <div class="row" style="background-color:blue;">
        <div class="container">
            <p style="color:white;">This is a Regional Event.</p>
            <?php print views_embed_view('regional_event_view', 'block'); ?>
        </div>
    </div>
    <?php
}
?>

<div class="eventDate" style="padding: 22px; font-size: 19px; color: grey;">
    <?php
    $eventDate = field_get_items('node', $node, 'field_date');

    // get first date data...
    $date1 = date_create($eventDate[0]['value']);
    $day1 = date_format($date1, 'jS');
    $month1 = date_format($date1, 'F');

    // get second date data...
    $date2 = date_create($eventDate[0]['value']);
    $day2 = date_format($date2, 'jS');
    $month2 = date_format($date2, 'F');

    print $month1.' '.$day1;
    // if start date and end date are not in the same month...
    if($month1 != $month2){
        print " - ".$month2.' '.$day2;
    }
    // else if dates are in the same month...
    elseif($month1 == $month2 && $day1 != $day2){
        print " - ".$day2;
    }
    // else one day event...
    else{
    }
    ?>
</div>
<div class="eventTime" style="padding: 18px; font-size: 15px; color: orange;">
    <?php
    $time1 = date_format($date1, 'g:i A');
    print $time1;
    ?>
</div>

<?php
// if video exists for node, then proceed to render DIV...
// get value from field_video to pass to View (if video exists)...
$video = render($content['field_video']);
if(!empty($video)){ // if the page has a video...
    // adds 'video' Views block...
    print views_embed_view('video_events', 'block', $video);
}
?>
