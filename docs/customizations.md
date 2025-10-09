# Mukurtu Customizations for Genoa

## Account Registration
Admin Menu > Configuration > People > Account settings

**Who can register new accounts?**

Set to "Administrators only"

Click "Save configuration"

Users can still request a new password for recovery

## Disable Comments

### New Content
Admin Menu > Structure > Content Types

Open a new tab for each content type's "Edit" page
- Click "Comment settings"
- Set **Default comment setting for new content** to "Hidden"
- Click "Save content type"

### All Existing Nodes
This is best achieved via SQL.

We have to set comments hidden on both `node` and `node_revision` records.

```sql
USE (db name);

SET SQL_SAFE_UPDATES = 0;

UPDATE node SET comment=0;
UPDATE node_revision SET comment=0;

SET SQL_SAFE_UPDATES = 1;
```

If any comments were entered before they were disabled, they can be removed via
Admin menu > Content > Comments.

## Digital Heritage Browse Facets

A brief outline of the customizations we have made:

- Remove Collection
- Remove Community
- Remove Keywords
- Remove Media Type
- Change the order of facets to:
  - Search
  - Topic (renamed from Category)
  - Tribe (renamed from Tribal Affiliation)
  - Format
    - Add "Format" and "Format » Name" to index fields, re-index, and
      facet by "Format", not "Format » Name"
  - Type

The best way to handle this recently was to:
- Add the Tribal Affiliation, Name, and Name Format fields to the index
  for faceting and reindex all items
- Then customize the browse facets via the Admin UI

### Index a Field for Faceting
Admin Menu > Configuration > Search and metadata > Search API

Click the drop-down arrow right of the Edit button for "Default node index" and
click Fields

Add / ensure these Fields (and Machine Names) are checked for facet index:
- Category (field_category)
- Format (field_format)
  - Format » Name (field_format:name)
- Type (field_dh_type)
- Tribal Affiliation (field_unl_tribal_affiliation)

Check the box next to the field with which you'd like to index, scroll to the
bottom, and click Save Configuration

Click the link to "re-index" in the confirmation message

Click "Index now" and wait while items reindex

Click the "Facets" tab at the top if you'd like to continue on to enable as a
facet field

### Enable a Facet Field
Admin Menu > Configuration > Search and metadata > Search API

Click the drop-down arrow right of the Edit button for "Default node index" and
click Facets

Add / ensure these Fields (and Machine Names) are checked for facet index:
- Category (There are two now; click the one with `field_category` near the end
  of the URL for its "configure display" link on the right)
- Format (field_format); not "Format » Name"
- Type (field_dh_type)
- Tribal Affiliation (field_unl_tribal_affiliation)

Check the box next to the field with which you'd like to facet, scroll to the
bottom, and click Save Configuration

Scroll to the facet you just enabled and click "Configure display"
- Set "Display widget" select to "Links with checkboxes"
- Scroll down to Global Settings > Hard limit and set to "No limit"
- Click Save configuration

### Customize Browse Facets via Admin UI
Sign in, click "Browse" (redirects to `/digital-heritage` path), click gear in
far upper right of page content but below "Government records show that ",
click "Edit Panel".

The UI elements under "Left" are what display in the browse page's facets.

Add / ensure these items are present under Left:
- Exposed form: digital_heritage_grid_list-all
- Custom sorts for the browse pages
- Facet API: Search service: Default node index: Category
- Facet API: Search service: Default node index: Tribal Affiliation
- Facet API: Search service: Default node index: Format
- Facet API: Search service: Default node index: Type

Click the gear left of "Left" to add content. Click and drag to re-order facets.
Click the gears right of the facets' names to customize labels, remove, etc.
Remove any named "Deleted/missing block facetapi-..." from old customization.
Click "Update and Save" awkwardly placed on the right to save changes here.

Changes via the admin UI here will override changes to the file
`ma_digitalheritage.pages_default.inc` in stricken documentation below.

### Deprecated Facet Customization

#### Completely Disable Search Facets
Admin Menu > Configuration > Search and metadata > Search API

Click the drop-down arrow right of the Edit button for "Default node index" and
click Facets

One may uncheck the boxes next to facets to be completely disabled site-wide.
Guessing this is not the approach we want to take due to possibly unforseen
consequences elsewhere on the site.

#### Disable on This Page Only
<s>
This appears to not be customizable via the admin UI.

Edit `(path to site)/master/sites/all/modules/custom/features/ma_digitalheritage/ma_digitalheritage.pages_default.inc`

Look for `'override_title_text' => 'Media Type',` for the block you'd like to
disable. Comment lines between `$pane = new stdClass()` and the next instance to
disable that block.

Note a copy of a fully customized file is included in this repository in
`files/`
</s>

See [Customize Browse Facets via Admin UI](#customize-browse-facets-via-admin-ui)

#### Add Facet Field to Page
<s>
Edit `(path to site)/master/sites/all/modules/custom/features/ma_digitalheritage/ma_digitalheritage.pages_default.inc`

- Duplicate a block of code for a pane (from `$pane = new stdClass()` to
  `$display->panels['left'][#]`)
- Replace the uuid with a new random one (https://duckduckgo.com/?q=uuid works)
- For the subtype, set the string after `facetapi-` to the ID from the admin UI
  page by copying the ID string from the Admin Menu > Structure > Blocks page
  configure links to the right of the "Facet API …" block
- Update the zero-index position number in both the position attribute and
  `panels['left'][#]` assignment

Save the changes to the file and your new filter facet should appear on the
Digital Heritage browse page
</s>

## Digital Heritage Preview Displays

These are the display formats we're customizing:
- Admin > Structure > Content Types > Digital Heritage >
  Manage display
  - Search result highlighting input
  - Teaser

with the following field settings:
- Disable Mukurtu Mobile Sync even though field may say it is hidden
- Topic (renamed from Category)
  - Click gear to right to set label, click Update
- Summary
- Tribe(s) (renamed from Tribal Affiliation)
  - Label: Inline
  - Format: Separated
  - Click gear to right, check the box to hide label colon, rename, click Update
- People
  - Label: Inline
  - Format: Separated
  - Click gear to right, check the box to hide label colon, click Update
- Remove Community
  - Display: Disabled

Admin UI Screenshots:
- [Search result display
  config](images/digital-heritage-search-result-display-config.png)
- [Teaser display config](images/digital-heritage-teaser-display-config.png)

## Digital Heritage Full Display
Admin > Structure > Content Types > Digital Heritage > Manage display
and click "Full content".

Display customizations:
- Left:
  - Summary
  - Description
  - Cultural Narrative
  - Traditional Knowledge
  - Transcription
    - Transcription
  - Location
  - Citation
  - Related Content
  - Identifier (previously renamed from Image Identifier)
- Right:
  - People
  - Places (renamed from Location Description]
  - Tribe(s) (renamed from Tribal Affiliation)
  - Topic (renamed from Category)
  - Collections
  - Original Date
  - Title (Original: Community Record Title)
  - Original Date Description
  - Related Items
  - Creator
  - Contributor
  - Rights
  - Traditional Knowledge Labels
  - Licensing Options
  - Source
  - External Links
  - Publisher
  - Subject
  - Type
  - Format
- Bottom:
  - Comments
- Disabled: (other fields as well, but below were disabled from above)
  - Mukurtu Mobile Sync
  - Title
  - Links
  - Author
  - Keywords
  - Community
  - Protocol
  - Language

Admin UI Screenshot:
- [Full content display
  config](images/digital-heritage-full-content-display-config.png)

## Allowed HTML Elements
The allowed HTML elements within user-written and imported content may be
customized. For now, we've only added `<hr>` to the "Full HTML" list of allowed
tags.

Admin Menu > Configuration > Content authoring > Text formats

Click "configure" to the right of "Full HTML"

Scroll down to "Allowed HTML tags" and modify the space-separated list as
desired.

Click "Save configuration"

## Add Customizable Footer
Go to Admin > Structure > Blocks

**Delete and recreate Custom Site Footer**

After the Mukurtu 3.0 update, the "Site custom footer" block had to deleted as
it wasn't providing an input for HTML. After deleting, click "Add box" on
Structure > Blocks page and set name and options as below.

Change "Custom site footer" to display in the Footer region

Click "configure" to the right
- Set the desired "Text format" to Full HTML
- Enter the content you'd like to display in the footer. Can be copied from
  another instance of the site
- Click "Advanced Settings" and enter any custom CSS classes you'd like applied
- Click "Save block"

## Image Download Links
We are customizing the links below images to say "Download image" rather than
"Access image" and adding the HTML5 attribute which signals to browsers to show
their download prompt upon clicking the link.

The code is buried deep within one of the Mukurtu features and modifying the
file seems simpler than trying to override the feature.

Edit
`(path to site)/master/sites/all/modules/custom/features/ma_scald/ma_scald.module`
:
```php
  // 'Download' was determined to be unpalatable, switching to 'Access'
#  $download_link_text = 'Access' . ((empty($entity->type)) ? '' : ' ' . $entity->type);
#  return l($download_link_text, file_create_url ($entity->file_source));
# Customize with Download text and to show download prompt on click
  $download_link_text = 'Download' . ((empty($entity->type)) ? '' : ' ' . $entity->type);
  return l($download_link_text, file_create_url ($entity->file_source),
           array('attributes' => array('download' => ''))
  );
```

## Add Site-wide Search
Admin Menu > Structure > Blocks

This is where one adds blocks to the theme's regions. The page lists blocks,
views, exposed forms (from views), search facets, mini panels, etc.

Click "Demonstrate block regions (Genoa)" to see where each region will locate
any blocks added to it.

Scroll down to "Exposed form: digital_heritage_grid_list-all" and set its region
to "Top Bar". Scroll up and drag it to be above "Mukurtu Dashboard: Getting
Started Guide".

Scroll down and click "Save blocks". Now close the admin UI.

### Mukurtu versions except 2.1.8
Mouse over the search form near the top of the page and click the gear in the
upper right corner. Click "Edit view".

Under "Pane Settings", click the link to the right of "Use panel path". Change
the value to "No" and click "Apply".

Click "Advanced" on the right to open more settings. Click the link to the right
of "Link display". Click the radio next to "Custom URL" and enter
"/digital-heritage" in the input. Click "Apply (all displays)".

Click "Save".

Searches should know work from anywhere on the site

### Mukurtu 2.1.8
Mukurtu wasn't able to handle the customization of the search form itself
via the Admin Menu and had to be handled via the code for this view.

If the view has been customized via the Admin Menu in the past, it should be
reverted so the view is loaded from the code rather than the database (in table
`views_display`).

Admin Menu > Structure > Views

Scroll down to Digital Heritage Browse. If underneath the title is the text
"Database overriding code' rather than "In code", one must click the arrow right
of the "Edit" button on the right side of the row. Then click "Revert".

Now we must modify the file controlling the display of this view, `(path to
site)/master/sites/all/modules/custom/features/ma_digitalheritage/ma_digitalheritage.views_default.inc`.
An example version of this file resides at
[/files/ma_digitalheritage_views_default_views.inc](../files/ma_digitalheritage_views_default_views.inc).
The section of code related to the view we're using for site-wide search begins
on line 215 for the view `digital_heritage_grid_list`. The specific "display"
which needs customization begins on line 307. This view just needs a "path"
display option added.

```php
  /* Display: All */
  $handler = $view->new_display('panel_pane', 'All', 'all');
  $handler->display->display_options['exposed_block'] = TRUE;
  $handler->display->display_options['inherit_panels_path'] = '1';
  /* Custom site-wide nav search fix */
  $handler->display->display_options['path'] = '/digital-heritage';
  /* /Custom site-wide nav search fix */
```

This should make the site-wide nav search function as before.

For potential future troubleshooting, the settings that previously worked via
the Admin Menu were attempted here but these didn't even work when hardcoded.
Adding the `link_display` option with the value `custom_url` to the "default
Master" display, changing the `digital_heritage_grid_list` display's
`inherit_panels_path` option to `0`, and adding a `link_url` option with the
value `/digital-heritage` were the settings tried.

```php
  /* Display: Master */
  $handler = $view->new_display('default', 'Master', 'default');
  $handler->display->display_options['css_class'] = 'browse-view';
  /* Custom site-wide nav search fix */
//  $handler->display->display_options['link_display'] = 'custom_url';
  /* /Custom site-wide nav search fix */

...

  /* Display: All */
  $handler = $view->new_display('panel_pane', 'All', 'all');
  $handler->display->display_options['exposed_block'] = TRUE;
  /* Custom site-wide nav search fix */
  $handler->display->display_options['inherit_panels_path'] = '0';
  $handler->display->display_options['link_url'] = '/digital-heritage';
  /* /Custom site-wide nav search fix */
```

## Customize home page contents
- Reference: https://mukurtu.org/support/configuring-front-page-content-blocks/
- View Admin > Structure > Context; Click `mukurtu_theme-front_page` > Edit
  - Click Theme and check the box next to the Genoa theme
  - Click Blocks
    - Click the x's next to existing content in the middle column
    - In the right column click MUKURTU_THEME_BLOCKS and check Mukurtu Theme Frontpage Hero Image, then click "+ Add" to the right of "Top Bar"
    - In the right column click System and check Main page content, then click "+ Add" to the right of "Content"
    - In the right column click View: Browse Digital Heritage by Category, then click "+ Add" to the right of "Content"
    - Click Save

## CSS changes
This CSS change addresses an issue that comes up with the upgrade to Mukurtu 3.0.2. This is a temporary fix that should be revisited once Mukurtu 4 is released. 

To remove the "Last changed" text that appears on taxonomy term pages, edit
`(path to site)/master/sites/all/themes/genoa/genoa.css`: 
add `.meta.changed` to `{display: none}` list at line 12739 (make sure to add comma to preceding class)
