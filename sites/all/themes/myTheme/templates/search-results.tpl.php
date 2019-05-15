<?php

/**
 * @file
 * Default theme implementation for displaying search results.
 *
 * This template collects each invocation of theme_search_result(). This and
 * the child template are dependent to one another sharing the markup for
 * definition lists.
 *
 * Note that modules may implement their own search type and theme function
 * completely bypassing this template.
 *
 * Available variables:
 * - $search_results: All results as it is rendered through
 *   search-result.tpl.php
 * - $module: The machine-readable name of the module (tab) being searched, such
 *   as "node" or "user".
 *
 *
 * @see template_preprocess_search_results()
 *
 * @ingroup themeable
 */
?>
<?php if ($search_results): ?>
    <div class="search-results"><?php print t('Search results');?></div>
  <ol class="search-results <?php print $module; ?>-results">
    <?php print $search_results; ?>
  </ol>
  <?php print $pager; ?>
<?php if($totalResults > 10){ // don't show Load More if less than 11 results ?>
    <div>
        <ul class="pager-load-more">
            <li><button class="load-more-ajax">Load more</button></li>
        </ul>
    </div>
<?php } ?>

<script type="text/javascript">
    (function($){
        Drupal.behaviors.loadMoreAjax = {
            attach: function (context, settings){
                $('.load-more-ajax', context).click(function(){
                    var nextPage = $('.pager .pager-next a').attr('href');
                    var lastPage = $('.pager .pager-last a').attr('href');
                    $.get(nextPage, function(data){
                        $(data).find('.search-results').insertBefore($('.item-list'));
                        $('.item-list .pager').remove();
                        if(nextPage == lastPage){
                            $('.load-more-ajax').remove();
                        }
                        else{
                            $(data).find('.item-list .pager').appendTo($('.item-list'));
                            Drupal.attachBehaviors($('.item-list'));
                        }
                    });
                });
                $('.item-list .pager').hide();
            }
        };
    })(jQuery);
</script>
