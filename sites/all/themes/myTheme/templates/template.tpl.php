<?php
function myTheme_preprocess_search_block_form(&$vars) {
    $vars['search_form'] = str_replace('type="text"', 'type="search"', $vars['search_form']);
}
?>

<?php
function myTheme_form_alter(&$form, &$form_state, $form_id) {
    if ($form_id == 'search_block_form') {
        $form['search_block_form']['#title'] = t('Search'); // Change the text on the label element
        $form['search_block_form']['#title_display'] = 'invisible'; // Toggle label visibilty
        $form['search_block_form']['#size'] = 40;  // define size of the textfield
        // Prevent user from searching the default text
        $form['#attributes']['onsubmit'] = "if(this.search_block_form.value=='Search'){ alert('Please enter a search'); return false; }";
        // Alternative (HTML5) placeholder attribute instead of using the javascript
        $form['search_block_form']['#attributes']['placeholder'] = t('Search');
        $form['search_block_form']['#attributes']['class'][] = 'search';
        $form['actions']['#attributes']['class'][] = 'element-invisible';
    }

    if($form_id == 'user_login' ) {
        $form['name']['#title_display'] = 'invisible';
        $form['name']['#attributes']['placeholder'] = t('User Name');
        $form['name']['#attributes']['onblur'] = "if (this.value == '') {this.value = 'User Name';}";
        $form['name']['#attributes']['onfocus'] = "if (this.value == 'User Name') {this.value = '';}";
        $form['pass']['#title_display'] = 'invisible';
        $form['pass']['#attributes']['placeholder'] = t('Password');
        $form['pass']['#attributes']['onblur'] = "if (this.value == '') {this.value = 'Password';}";
        $form['pass']['#attributes']['onfocus'] = "if (this.value == 'Password') {this.value = '';}";
        $form['#attributes']['onsubmit'] = "if(this.user_login.name.value=='User Name'){ alert('Please enter your user name'); return false; }";
        $form['#attributes']['onsubmit'] = "if(this.user_login.pass.value=='Password'){ alert('Please enter your password'); return false; }";
        $form['actions']['submit']['#attributes']['class'][] = 'button';
    }
}
?>

<?php
function myTheme_css_alter(&$css) {
    $exclude = array(
        'modules/comment/comment.css' => FALSE,
        'modules/node/node.css' => FALSE,
        'modules/search/search.css' => FALSE,
        'modules/system/system.menus.css' => FALSE,
        'modules/system/system.messages.css' => FALSE,
        'modules/system/system.theme.css' => FALSE,
        'modules/taxonomy/taxonomy.css' => FALSE,
        'modules/user/user.css' => FALSE,
        'modules/shortcut/shortcut.css' => FALSE,
        'modules/field/theme/field.css' => FALSE,
        'sites/all/modules/calendar/css/calendar_multiday.css' => FALSE,
        'sites/all/modules/date/date_api/date.css' => FALSE,
        'sites/all/modules/date/date_popup/themes/datepicker.1.7.css' => FALSE,
        'sites/all/modules/picture/picture_wysiwyg.css' => FALSE,
        'sites/all/modules/views/css/views.css' => FALSE,
        'sites/all/modules/ckeditor/css/ckeditor.css' => FALSE,
        'sites/all/modules/ctools/css/ctools.css' => FALSE,
    );
    $css = array_diff_key($css, $exclude);
}
?>
<?php
function myTheme_form_search_form_alter(&$form, &$form_state) {
    if ((arg(1) == 'node') && (arg(2) != NULL)) {
        $form['#access'] = FALSE;
    }
}
?>
<?php
function myTheme_theme() {
    $items = array();
    $items['user_login'] = array(
        'render element' => 'form',
        'path' => drupal_get_path('theme', 'myTheme') . '/templates',
        'template' => 'user-login',
    );
    $items['user_register_form'] = array(
        'render element' => 'form',
        'path' => drupal_get_path('theme', 'myTheme') . '/templates',
        'template' => 'user-register-form',
    );
    $items['user_pass'] = array(
        'render element' => 'form',
        'path' => drupal_get_path('theme', 'myTheme') . '/templates',
        'template' => 'user-pass',
    );
    return $items;
}
?>
<?php
//remove 'leaf' class from menu li...
function myTheme_menu_link(array $variables) {
// This is the part that removes or changes the 'leaf' class.
if (!empty($variables['element']['#attributes']['class'])) {
foreach ($variables['element']['#attributes']['class'] as $key => $class) {
if ($class == 'leaf') {
// To remove the 'leaf' class.
unset($variables['element']['#attributes']['class'][$key]);
}
}
}
return theme_menu_link($variables);
}
?>
