<?php
<?php
/**
 * Admin Page Framework
 * 
 * http://en.michaeluno.jp/admin-page-framework/
 * Copyright (c) 2013-2014 Michael Uno; Licensed MIT
 */
if ( ! class_exists( 'AdminPageFramework_Documentation' ) ) :
/**
 * Handles creation of admin pages and setting forms.
 * 
 * This class should be extended and the `setUp()` method should be overridden to define how pages are composed.
 * Most of the internal methods are prefixed with the underscore like `_getSomething()` and callback methods are prefixed with <code>_reply</code>.
 * The methods for the users are public and do not have those prefixes.
 * 
 * <h2>Hooks</h2>
 * <p>The class automatically creates WordPress action and filter hooks associated with the class methods.
 * The class methods corresponding to the name of the below actions and filters can be extended to modify the page output. Those methods are the callbacks of the filters and the actions.</p>
 * <h3>Methods and Action Hooks</h3>
 * <ul>
 *     <li><strong>start_{instantiated class name}</strong> – triggered at the end of the class constructor. This will be triggered in any admin page except admin-ajax.php. The class object will be passed to the first parameter [3.1.3+].</li>
 *     <li><strong>set_up_{instantiated class name}</strong> – [3.1.3+] triggered after the setUp() method is called. The class object will be passed to the first parameter.</li>
 *     <li><strong>load_{instantiated class name}</strong> – [2.1.0+] triggered when the framework's page is loaded before the header gets sent. This will not be triggered in the admin pages that are not registered by the framework. The first parameter: class object [3.1.2+].</li>
 *     <li><strong>load_{page slug}</strong> – [2.1.0+] triggered when the framework's page is loaded before the header gets sent. This will not be triggered in the admin pages that are not registered by the framework. The first parameter: class object [3.1.2+].</li>
 *     <li><strong>load_{page slug}_{tab slug}</strong> – [2.1.0+] triggered when the framework's page is loaded before the header gets sent. This will not be triggered in the admin pages that are not registered by the framework. The first parameter: class object [3.1.2+].</li>
 *     <li><strong>load_after_{instantiated class name}</strong> – [3.1.3+] triggered when one of the framework's pages is loaded before the header gets sent. This will not be triggered in the admin pages that are not registered by the framework. The first parameter: class object.</li>
 *     <li><strong>do_before_{instantiated class name}</strong> – triggered before rendering the page. It applies to all the pages created by the instantiated class object. The class object will be passed to the first parameter [3.1.3+].</li>
 *     <li><strong>do_before_{page slug}</strong> – triggered before rendering the page. The class object will be passed to the first parameter [3.1.3+].</li>
 *     <li><strong>do_before_{page slug}_{tab slug}</strong> – triggered before rendering the page. The class object will be passed to the first parameter [3.1.3+].</li>
 *     <li><strong>do_form_{instantiated class name}</strong> – triggered right after the form opening tag. It applies to all the pages created by the instantiated class object. The class object will be passed to the first parameter [3.1.3+].</li>
 *     <li><strong>do_form_{page slug}</strong> – triggered right after the form opening tag. The class object will be passed to the first parameter [3.1.3+].</li>
 *     <li><strong>do_form_{page slug}_{tab slug}</strong> – triggered right after the form opening tag. The class object will be passed to the first parameter [3.1.3+].</li>
 *     <li><strong>do_{instantiated class name}</strong> – triggered in the middle of rendering the page. It applies to all the pages created by the instantiated class object. The class object will be passed to the first parameter [3.1.3+].</li>
 *     <li><strong>do_{page slug}</strong> – triggered in the middle of rendering the page. The class object will be passed to the first parameter [3.1.3+].</li>
 *     <li><strong>do_{page slug}_{tab slug}</strong> – triggered in the middle of rendering the page. The class object will be passed to the first parameter [3.1.3+].</li>
 *     <li><strong>do_after_{instantiated class name}</strong> – triggered after rendering the page. It applies to all the pages created by the instantiated class object. The class object will be passed to the first parameter [3.1.3+].</li>
 *     <li><strong>do_after_{page slug}</strong> – triggered after rendering the page. The class object will be passed to the first parameter [3.1.3+].</li>
 *     <li><strong>do_after_{page slug}_{tab slug}</strong> – triggered after rendering the page. The class object will be passed to the first parameter [3.1.3+].</li>
 *     <li><strong>submit_{instantiated class name}_{submit input id}</strong> – [3.0.0+] triggered after the form is submitted with the submit button of the specified input id.</li>
 *     <li><strong>submit_{instantiated class name}_{submit field id}</strong> – [3.0.0+] triggered after the form is submitted with the submit button of the specified field that does not hava section is submitted.</li>
 *     <li><strong>submit_{instantiated class name}_{submit section id}_{submit field id}</strong> – [3.0.0+] triggered after the form is submitted with the submit button of the specified section and field is submitted.</li>
 *     <li><strong>submit_{instantiated class name}_{submit section id}</strong> – [3.0.0+] triggered after the form is submitted with the submit button of the specified section.</li>
 *     <li><strong>submit_{instantiated class name}</strong> – [3.0.0+] triggered after the form is submitted.</li>
 * </ul>
 * <h3>Methods and Filter Hooks</h3>
 * <ul>
 *     <li><strong>content_top_{page slug}_{tab slug}</strong> – receives the output of the top part of the page. [3.0.0+] Changed the name from head_{...}.</li>
 *     <li><strong>content_top_{page slug}</strong> – receives the output of the top part of the page. [3.0.0+] Changed the name from head_{...}.</li>
 *     <li><strong>content_top_{instantiated class name}</strong> – receives the output of the top part of the page, applied to all pages created by the instantiated class object. [3.0.0+] Changed the name from head_{...}.</li>
 *     <li><strong>content_{page slug}_{tab slug}</strong> – receives the output of the middle part of the page including form input fields.</li>
 *     <li><strong>content_{page slug}</strong> – receives the output of the middle part of the page including form input fields.</li>
 *     <li><strong>content_{instantiated class name}</strong> – receives the output of the middle part of the page, applied to all pages created by the instantiated class object.</li>
 *     <li><strong>content_bottom_{page slug}_{tab slug}</strong> – receives the output of the bottom part of the page. [3.0.0+] Changed the name from foot_{...}.</li>
 *     <li><strong>content_bottom_{page slug}</strong> – receives the output of the bottom part of the page. [3.0.0+] Changed the name from foot_{...}.</li>
 *     <li><strong>content_bottom_{instantiated class name}</strong> – receives the output of the bottom part of the page, applied to all pages created by the instantiated class object. [3.0.0+] Changed the name from foot_{...}.</li>
 *     <li><strong>section_head_{instantiated class name}_{section ID}</strong> – receives the title and the description output of the given form section ID. The first parameter: the output string.</li> 
 *     <li><strong>field_{instantiated class name}_{field ID}</strong> – receives the form input field output of the given input field ID that does not have a section. The first parameter: output string. The second parameter: the array of option.</li>
 *     <li><strong>field_{instantiated class name}_{section id}_{field ID}</strong> – [3.0.0+] receives the form input field output of the given input field ID that has a section. The first parameter: output string. The second parameter: the array of option.</li>
 *     <li><strong>sections_{instantiated class name}</strong> – receives the registered section arrays. The first parameter: sections container array.</li> 
 *     <li><strong>fields_{instantiated class name}</strong> – receives the registered field arrays. The first parameter: fields container array.</li> 
 *     <li><strong>fields_{instantiated class name}_{section id}</strong> – [3.0.0+] receives the registered field arrays which belong to the specified section. The first parameter: fields container array.</li> 
 *     <li><strong>field_definition_{instantiated class name}_{field ID}</strong> – [3.0.2+] receives the form field definition array of the given input field ID that does not have a section. The first parameter: the field definition array.</li>
 *     <li><strong>field_definition_{instantiated class name}_{section id}_{field ID}</strong> – [3.0.2+] receives the form field definition array of the given input field ID that has a section. The first parameter: the field definition array. The second parameter: the integer representing sub-section index if the field belongs to a sub-section.</li>
 *     <li><strong>pages_{instantiated class name}</strong> – receives the registered page arrays. The first parameter: pages container array.</li> 
 *     <li><strong>tabs_{instantiated class name}_{page slug}</strong> – receives the registered in-page tab arrays. The first parameter: tabs container array.</li> 
 *     <li><strong>validation_{instantiated class name}_{field id}</strong> – [3.0.0+] receives the form submission value of the field that does not have a section. The first parameter: ( string|array ) submitted input value. The second parameter: ( string|array ) the old value stored in the database. The third parameter: ( object ) [3.1.0+] the caller object.</li>
 *     <li><strong>validation_{instantiated class name}_{section_id}_{field id}</strong> – [3.0.0+] receives the form submission value of the field that has a section. The first parameter: ( string|array ) submitted input value. The second parameter: ( string|array ) the old value stored in the database. The third parameter: ( object ) [3.1.0+] the caller object.</li>
 *     <li><strong>validation_{instantiated class name}_{section id}</strong> – [3.0.0+] receives the form submission values that belongs to the section.. The first parameter: ( array ) the array of submitted input values that belong to the section. The second parameter: ( array ) the array of the old values stored in the database. The third parameter: ( object ) [3.1.0+] the caller object.</li>
 *     <li><strong>validation_{page slug}_{tab slug}</strong> – receives the form submission values as array. The first parameter: submitted input array. The second parameter: the original array stored in the database. The third parameter: ( object ) [3.1.0+] the caller object.</li>
 *     <li><strong>validation_{page slug}</strong> – receives the form submission values as array. The first parameter: submitted input array. The second parameter: the original array stored in the database. The third parameter: ( object ) [3.1.0+] the caller object.</li>
 *     <li><strong>validation_{instantiated class name}</strong> – receives the form submission values as array. The first parameter: submitted input array. The second parameter: the original array stored in the database. The third parameter: ( object ) [3.1.0+] the caller object.</li>
 *     <li><strong>validation_saved_options_{instantiated class name}</strong> – [3.1.2+] receives the saved form options as an array. The first parameter: the stored options array. The second parameter: the caller object.</li>
 *     <li><strong>validation_saved_options_{page slug}</strong> – [3.0.0+] receives the saved form options as an array of the page. The first parameter: the stored options array of the page. The second parameter: the caller object.</li>
 *     <li><strong>validation_saved_options_{page slug}_{tab slug}</strong> – [3.0.0+] receives the saved form options as an array of the tab. The first parameter: the stored options array of the tab. The second parameter: the caller object.</li>
 *     <li><strong>style_{page slug}_{tab slug}</strong> – receives the output of the CSS rules applied to the tab page of the slug.</li>
 *     <li><strong>style_{page slug}</strong> – receives the output of the CSS rules applied to the page of the slug.</li>
 *     <li><strong>style_{instantiated class name}</strong> – receives the output of the CSS rules applied to the pages added by the instantiated class object.</li>
 *     <li><strong>script_{page slug}_{tab slug}</strong> – receives the output of the JavaScript script applied to the tab page of the slug.</li>
 *     <li><strong>script_{page slug}</strong> – receives the output of the JavaScript script applied to the page of the slug.</li>
 *     <li><strong>script_{instantiated class name}</strong> – receives the output of the JavaScript script applied to the pages added by the instantiated class object.</li>
 *     <li><strong>export_{instantiated class name}_{input id}</strong> – [2.1.5+] receives the exporting array submitted from the specific export button.</li>
 *     <li><strong>export_{instantiated class name}_{field id}</strong> – [2.1.5+] receives the exporting array submitted from the specific field that does not have a section.</li>
 *     <li><strong>export_{instantiated class name}_{section id}_{field id}</strong> – [3.0.0+] receives the exporting array submitted from the specific field that has a section.</li>
 *     <li><strong>export_{page slug}_{tab slug}</strong> – receives the exporting array sent from the tab page.</li>
 *     <li><strong>export_{page slug}</strong> – receives the exporting array submitted from the page.</li>
 *     <li><strong>export_{instantiated class name}</strong> – receives the exporting array submitted from the plugin.</li>
 *     <li><strong>export_name_{instantiated class name}_{input id}</strong> – receives the exporting file name submitted the specified input id.</li>
 *     <li><strong>export_name_{instantiated class name}_{field id}</strong> – receives the exporting file name submitted from the specific field that does not have a section.</li>
 *     <li><strong>export_name_{instantiated class name}_{section id}_{field id}</strong> – [3.0.0+] receives the exporting file name submitted from the specific field that has a section.</li>
 *     <li><strong>export_name_{page slug}_{tab slug}</strong> – receives the exporting file name submitted from the tab page.</li>
 *     <li><strong>export_name_{page slug}</strong> – receives the exporting file name submitted from the page.</li>
 *     <li><strong>export_name_{instantiated class name}</strong> – receives the exporting file name submitted from the script.</li>
 *     <li><strong>export_format_{instantiated class name}_{input id}</strong> – receives the exporting file format submitted from the specific export button.</li>
 *     <li><strong>export_format_{instantiated class name}_{field id}</strong> – receives the exporting file format submitted from the specific field that does not have a section.</li>
 *     <li><strong>export_format_{instantiated class name}_{section id}_{field id}</strong> – [3.0.0+] receives the exporting file format submitted from the specific field that has a section.</li>
 *     <li><strong>export_format_{page slug}_{tab slug}</strong> – receives the exporting file format sent from the tab page.</li>
 *     <li><strong>export_format_{page slug}</strong> – receives the exporting file format submitted from the page.</li>
 *     <li><strong>export_format_{instantiated class name}</strong> – receives the exporting file format submitted from the plugin.</li> 
 *     <li><strong>import_{instantiated class name}_{input id}</strong> – [2.1.5+] receives the importing array submitted from the specific import button.</li>
 *     <li><strong>import_{instantiated class name}_{field id}</strong> – [2.1.5+] receives the importing array submitted from the specific import field that does not have a section.</li>
 *     <li><strong>import_{instantiated class name}_{section id}_{field id}</strong> – [3.0.0+] receives the importing array submitted from the specific import field that has a section.</li>
 *     <li><strong>import_{page slug}_{tab slug}</strong> – receives the importing array submitted from the tab page.</li>
 *     <li><strong>import_{page slug}</strong> – receives the importing array submitted from the page.</li>
 *     <li><strong>import_{instantiated class name}</strong> – receives the importing array submitted from the plugin.</li>
 *     <li><strong>import_mime_types_{instantiated class name}_{input id}</strong> – [2.1.5+] receives the mime types of the import data submitted from the specific import button.</li>
 *     <li><strong>import_mime_types_{instantiated class name}_{field id}</strong> – [2.1.5+] receives the mime types of the import data submitted from the specific import field that does not have a section.</li>
 *     <li><strong>import_mime_types_{instantiated class name}_{section id}_{field id}</strong> – [3.0.0+] receives the mime types of the import data submitted from the specific import field that has a section.</li>
 *     <li><strong>import_mime_types_{page slug}_{tab slug}</strong> – receives the mime types of the import data submitted from the tab page.</li>
 *     <li><strong>import_mime_types_{page slug}</strong> – receives the mime types of the import data submitted from the page.</li>
 *     <li><strong>import_mime_types_{instantiated class name}</strong> – receives the mime types of the import data submitted from the plugin.</li>
 *     <li><strong>import_format_{instantiated class name}_{input id}</strong> – [2.1.5+] receives the import data format submitted from the specific import button.</li>
 *     <li><strong>import_format_{instantiated class name}_{field id}</strong> – [2.1.5+] receives the import data format submitted from the specific import field that does not have a section.</li>
 *     <li><strong>import_format_{instantiated class name}_{section id}_{field id}</strong> – [3.0.0+] receives the import data format submitted from the specific import field that has a section.</li>
 *     <li><strong>import_format_{page slug}_{tab slug}</strong> – receives the import data format submitted from the tab page.</li>
 *     <li><strong>import_format_{page slug}</strong> – receives the import data format submitted from the page.</li>
 *     <li><strong>import_format_{instantiated class name}</strong> – receives the import data format submitted from the plugin.</li>
 *     <li><strong>import_option_key_{instantiated class name}_{input id}</strong> – [2.1.5+] receives the option array key of the importing array submitted from the specific import button.</li>
 *     <li><strong>import_option_key_{instantiated class name}_{field id}</strong> – [2.1.5+] receives the option array key of the importing array submitted from the specific import field that does not have a section.</li>
 *     <li><strong>import_option_key_{instantiated class name}_{section id}_{field id}</strong> – [3.0.0+] receives the option array key of the importing array submitted from the specific import field that has a section.</li>
 *     <li><strong>import_option_key_{page slug}_{tab slug}</strong> – receives the option array key of the importing array submitted from the tab page.</li>
 *     <li><strong>import_option_key_{page slug}</strong> – receives the option array key of the importing array submitted from the page.</li>
 *     <li><strong>import_option_key_{instantiated class name}</strong> – receives the option array key of the importing array submitted from the plugin.</li> 
 *     <li><strong>options_{instantiated class name}</strong> – [3.1.0+] receives the option array.</li> 
 * </ul>
 * <h3>Remarks</h3>
 * <p>The slugs must not contain a dot(.) or a hyphen(-) since it is used in the callback method name.</p>
 * <h3>Examples</h3>
 * <p>If the instantiated class name is Sample_Admin_Pages, defining the following class method will embed a banner image in all pages created by the class.</p>
 * <code>class Sample_Admin_Pages extends AdminPageFramework {
 * ...
 *     function content_top_Sample_Admin_Pages( $sContent ) {
 *         return '<div style="float:right;"><img src="' . plugins_url( 'img/banner468x60.gif', __FILE__ ) . '" /></div>' 
 *             . $sContent;
 *     }
 * ...
 * }</code>
 * <p>If the created page slug is my_first_setting_page, defining the following class method will filter the middle part of the page output.</p>
 * <code>class Sample_Admin_Pages extends AdminPageFramework {
 * ...
 *     function content_my_first_setting_page( $sContent ) {
 *         return $sContent . '<p>Hello world!</p>';
 *     }
 * ...
 * }</code>
 * <h3>Timing of Hooks</h3>
 * <code>------ After the class is instantiated ------
 *  
 *  start_{instantiated class name}
 * 
 * ------ When the page starts loading  ------
 * 
 *  load_{instantiated class name}
 *  load_{page slug}
 *  load_{page slug}_{tab slug}
 *  load_after_{instantiated class name}
 * 
 *  sections_{instantiated class name}
 *  fields_{instantiated class name}
 *  pages_{instantiated class name}
 *  tabs_{instantiated class name}_{page slug}
 *  
 *  submit_{instantiated class name}_{pressed submit field id}
 *  submit_{instantiated class name}_{section id}
 *  submit_{instantiated class name}_{section id}_{field id}
 *  submit_{instantiated class name}_{page slug}
 *  submit_{instantiated class name}_{page slug}_{tab slug}
 *  submit_{instantiated class name}
 *  validation_saved_options_{instantiated class name}
 *  validation_saved_options_{page slug}_{tab slug}
 *  validation_saved_options_{page slug}
 *  validation_{instantiated class name}_{field id (which does not have a section)}
 *  validation_{instantiated class name}_{section_id}
 *  validation_{instantiated class name}_{section id}_{field id}
 *  validation_{page slug}_{tab slug}
 *  validation_{page slug }
 *  validation_{instantiated class name }
 *  export_{page slug}_{tab slug}
 *  export_{page slug}
 *  export_{instantiated class name}
 *  import_{page slug}_{tab slug}
 *  import_{page slug}
 *  import_{instantiated class name}
 * 
 *  ------ Start Rendering HTML - after HTML header is sent ------
 *  
 *  <head>
 *      <style type="text/css" name="admin-page-framework">
 *          style_{page slug}_{tab slug}
 *          style_{page slug}
 *          style_{instantiated class name}
 *          script_{page slug}_{tab slug}
 *          script_{page slug}
 *          script_{instantiated class name}
 *      </style>
 *  
 *  <head/>
 *  
 *  do_before_{instantiated class name}
 *  do_before_{page slug}
 *  do_before_{page slug}_{tab slug}
 *  
 *  <div class="wrap">
 *  
 *      content_top_{page slug}_{tab slug}
 *      content_top_{page slug}
 *      content_top_{instantiated class name}
 *  
 *      <div class="admin-page-framework-container">
 *          <form action="current page" method="post">
 *  
 *              do_form_{instantiated class name}
 *              do_form_{page slug}
 *              do_form_{page slug}_{tab slug}
 *              
 *              field_definition_{instantiated class name}_{section ID}_{field ID}
 *              field_definition_{instantiated class name}_{field ID (which does not have a section)}
 *              section_head_{instantiated class name}_{section ID}
 *              field_{instantiated class name}_{field ID}
 *  
 *              content_{page slug}_{tab slug}
 *              content_{page slug}
 *              content_{instantiated class name}
 *  
 *              do_{instantiated class name}
 *              do_{page slug}
 *              do_{page slug}_{tab slug}
 *  
 *          </form>
 *      </div>
 *  
 *          content_bottom_{page slug}_{tab slug}
 *          content_bottom_{page slug}
 *          content_bottom_{instantiated class name}
 *  
 *  </div>
 *  
 *  do_after_{instantiated class name}
 *  do_after_{page slug}
 *  do_after_{page slug}_{tab slug}
 *  
 * </code>
 * 
 * @since       3.3.0
 * @package     AdminPageFramework
 * @subpackage  AdminPage
 * @heading
 */
class AdminPageFramework_Documentaiton {}
endif;
