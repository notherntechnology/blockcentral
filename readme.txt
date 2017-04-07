*************************************************
**                    BLOCK CENTRAL            **
** Northern Technology CMS WordPress Extension **
*************************************************

Version: 0.1
Web: http://nothern.technology
SRC: gitlab url

>> Description:

Purpose of Block Central:

Many content management systems provide the ability to manage blocks of content and position them at arbitrary points on a site.  This can be useful for things like generalized contact information, messages that need to appear in specific locations, and other scenarios where content needs to be used in multiple locations.  WordPress somewhat addresses this functionality with widgets, but widgets are not centrally managed and are not easy to use in the content body of pages/posts - and if a site uses multiple layout templates, this can drive the need for multiple positioned widgets containing the same content which will need to be managed separately.

Northern Technology’s CMS WordPress extension allows one to create and centrally manage blocks of content and then either insert the block into a page or post via a ShortCode or into the theme via a widget.  Content is referenced via tags so potentially multiple blocks of content can be inserted by referencing a single tag.  Additionally, content can be made active or inactive to display or suppress its display and each block of content can have effective dates to display in (i.e. show this block from “July 1st to August 1st” - or “stop showing this block on December 25th”).  Leveraging this functionality makes it easy to stop/start/add/remove content from a central location without worrying about whether all the instances of widgets, pages or posts have been updated.

>> Installation:

1) Unpack into your <wordpress-install-dir>/wp-content/plugins directory; will create a directory named “blockcentral”.
2) Log into Admin - go to Plugins - activate the BlockCentral plugin
3) This will create an BlockCentral sidemenu - this is where all content management activities will be conducted

>> Other Notes:

- If you are using a caching extension to speed up your WordPress install, you might have to clear the cache for CMS changes to take effect.

>> Changelog:

V0.1 - Initial Alpha Release

