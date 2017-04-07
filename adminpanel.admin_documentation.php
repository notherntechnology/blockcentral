<?php
function ntcms_admin_documentation() {
?>
<div class="wrap">
<hr class="ntcms-hr-style">
<h1>Block Central - Documentation</h1>
<h3>Basic Instructions</h3>
<p><ul>
	<li>Step 1 - Go to Block Central > Manage Content - create a new block of content - be sure to make it active and has a tag - select a display template if desired - save it</li>
	<li>Step 2 - Edit a page or post to add the shortcode "[blockcentral tag="**tag name used in step 1**"]" - alternatively, go to WordPress Admin > Appearance > Widgets and place the Block Central widget somewhere - be sure to select the tag in the drop down that you created in Step 1</li>
	<li>Step 3 - Go to the website and confirm that everything is working as expected</li>
</ul></p>
<h3>Blocks & Displays - what are they?</h3>
<p>Block Central introduces two new elements for building your WordPress site: Content Blocks and Block Displays.</p>
<p>Content blocks can be any snippet of content that needs to be used anywhere on a WordPress site, either via a shortcode or a widget.  Blocks have active/inactive states, data-ranges, and schedules in which they are allowed to be displayed.  Left alone, they will display exactly as they are entered in WordPress Admin.</p>
<p>Displays are intended to wrap around the content to assist in formatting.  This could be as simple as a pair of div tags or as complicated as some tabling with a header graphic.  Simple formatting can also be done directly in the content itself.  Displays are tied to content via a drop down menu in admin on a content block by content block basis.  This allows one to easily change the display characteristics of content by selecting from a library of displays.  Block Central comes preloaded with a series of animated displays based animate.css (https://daneden.github.io/animate.css/), so its very easy to use any of the prebuilt displays or make your own.  Please note that Northern has intentionally not packaged animate.css with the extension - it references a public CDN hosting the file - this is to help illustrate the fact that the same trick can be done with any number of other JS/CSS effects libraries.</p>
<h3>Content Block Fields:</h3>
<ul>
<li>Name - The display name for this piece of content, shown only in WordPress Admin.</li>
<li>Tag(s) - Tag names (space separated) used for displaying content on a page (the WordPress shortcode for displaying content is driven by tag name).</li>
<li>Status - Active or Inactive - inactive content is never displayed.</li>
<li>Display - Select a display template used to format this content; alternatively, the content may be formatted completely here.  Select No Display Template if all formatting 
is done in the content itself.</li>
<li>Start Date - A date for which the content cannot be displayed earlier than; alternatively, leave blank for no date constraint. Dates are displayed as Year-Month-Day.</li>
<li>End Date - A date for which the content cannot be displayed later than; alternatively, leave blank for no date constraint. Dates are displayed as Year-Month-Day.</li>
<li>Examples of Date Usage: 
<table border=1 cellspacing=0 cellpadding=3>
<tr><td colspan=3>Date Display Logic</td></tr>
<tr><td>Start Date</td><td>End Date</td><td>Result</td></tr>
<tr><td>None</td><td>None</td><td>Content is displayed if active.</td></tr>
<tr><td>2018/03/01</td><td>None</td><td>Content is displayed if active and if the current date is after the first minute of 2018/03/01.</td></tr>
<tr><td>None</td><td>2018/03/01</td><td>Content is displayed if active and if the current date is before the first minute of 2018/03/01.</td></tr>
<tr><td>2018/02/01</td><td>2018/03/01</td><td>Content is displayed if active and if the current date is after the first minute of 2018/02/01 and before the first minute of 2018/03/01 (a 24 hour period).</td></tr>
</table></li>
<li>Sequence - If two or more content blocks match the tag being displayed, they will order themselves DESCENDING by their sequence number</li>
<li>Content - Enter the content you wish to display; content can be either plain and it will inherit the formatting of the surrounding page on which it is displayed or can be highly formatted 
(recommend that you test how it displays on an inactive page if you add formatting directly into the content).</li>
</ul>
<h3>Content Display Fields:</h3>
<ul>
<li>Name - Enter or update the name that the display template will be known by in WordPress Admin - this is not displayed on the public site.</li>
<li>Template - This area is used to create the formatting display template - somewhere in the template must be the characters %%content%% or the display will 
not display anything.</li>
</ul>
<h3>Content Strategies:</h3>
<p>Block Central was created to provide centralized management of a site's ancillary content - for example, a company address that's featured at the bottom of every page, but also inside every press announcement - or a message that needs to go live for readers every now and then and shows up in multiple places.  Block Central is not intended to manage *all* the content of a site - that's what core WordPress postings and pages are for.  When properly used, Block Central can dramatically lessen the number of times an author / site administrator needs to touch posts, pages, and widgets simply to update messaging.</p>
<p>Below are some strategies that you may want to try out to maximize the value of using Block Central:</p>
<p>Tag-Driven Content - content is displayed on the basis of tag matches and each piece of content may contain multiple tags.  As such, there are a number of tagging strategies that can be employed, for example:
	<ul>
		<li>Name tags after location where content is displayed - for example, you might have a widget in the header displaying the tag "header" and a shortcode near the bottom of many pages displaying the tag "content-footer" - when you have a snippet that you want to display in both places, you tag the snippet with both tags.</li>
		<li>Make new tagged content instead of updating existing content - you can keep older versions of content around for future re-use by creating new content instead of updating existing content - remove the tags from the older content and it will cease to display - add the tags to the newer content and the newer content will show up instead.  If you ever want to use the old content again, just switch the tags back again.</li>
	</ul>
</p>
<p>Use Sequences - Tags can match on multiple content blocks - the sequence number drives how they appear (they are sequenced ascending, so lowest first).  Just remember that if multiple content blocks have different displays associated to them, they will all use the display of the first matching block.</p>
<p>Create placeholders for areas likely to have content later - its very normal in modern sites for empty content blocks to be placed in strategic positions so they can be used later.  When a content block has no content, it does not take up any space.  If its pre-positioned for future use, its easy to create a piece of content, or activate something already in place, to provide notifications or other needed messaging.</p>
</div>
<?php
}
?>