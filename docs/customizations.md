# Mukurtu Customizations for Genoa

**Contents**
- [Account Registration](#account-registration)
- [Disable Comments](#disable-comments)
  - [New Content](#new-content)
  - [All Existing Nodes](#all-existing-nodes)
- [Digital Heritage Browse Facets](#digital-heritage-browse-filters)
  - [Completely Disable Search Facets](#completely-disable-search-facets)
  - [Disable on This Page Only](#disable-on-this-page-only)
  - [Index a Field for Faceting](#index-a-field-for-faceting)
  - [Enable a Facet Field](#enable-a-facet-field)
  - [Add Facet Field to Page](#add-facet-field-to-page)
- [Digital Heritage Preview Displays](#digital-heritage-preview-displays)
- [Digital Heritage Full Display](#digital-heritage-full-display)
- [Allowed HTML Elements](#allowed-html-elements)
- [Add Customizable Footer](#add-customizable-footer)
- [Image Download Links](#image-download-links)
- [Add Site-wide Search](#add-site-wide-search)

## Account Registration
Admin Menu > Configuration > People > Account settings

**Who can register new accounts?**

Set to "Administrators only"

Click "Save configuration"

Users cant still request a new password for recovery

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

- Remove Collection
- Remove Community
- Remove Media Type
- Change the order of facets to:
  - Search
  - Topic (renamed from Category)
  - Tribe (renamed from Tribal Affiliation)
  - Keywords
  - Format
    - Add "Format" and "Format » Name" to index fields, re-index, and
      facet by "Format", not "Format » Name"
  - Type

### Completely Disable Search Facets
Admin Menu > Configuration > Search and metadata > Search API

Click the drop-down arrow right of the Edit button for "Default node index" and
click Facets

One may uncheck the boxes next to facets to be completely disabled site-wide.
Guessing this is not the approach we want to take due to possibly unforseen
consequences elsewhere on the site.

### Disable on This Page Only
This appears to not be customizable via the admin UI.

Edit `(path to site)/master/sites/all/modules/custom/features/ma_digitalheritage/ma_digitalheritage.pages_default.inc`

Look for `'override_title_text' => 'Media Type',` for the block you'd like to
disable. Comment lines between `$pane = new stdClass()` and the next instance to
disable that block.

Note a copy of a fully customized file is included in this repository in
`files/`

### Index a Field for Faceting
Admin Menu > Configuration > Search and metadata > Search API

Click the drop-down arrow right of the Edit button for "Default node index" and
click Fields

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

Check the box next to the field with which you'd like to facet, scroll to the
bottom, and click Save Configuration

Scroll to the facet you just enabled and click "Configure display"
- Set "Display widget" select to "Links with checkboxes"
- Scroll down to Global Settings > Hard limit and set to "No limit"
- Click Save configuration

### Add Facet Field to Page
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

## Digital Heritage Preview Displays

These are the display formats we're customizing:
- Search result highlighting input
  - Hover over an item on the Digital Heritage Browse page, click the gear,
    click "Manage display"
- Teaser
  - Hover over an item on a page such as `/tags/parents-and-siblings`, click the
    gear, click "Manage display"

with the following field settings:
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
Browse to Digital Heritage item on the Browse page and click to it

Click the Item Menu, then click Manage display

Display customizations:
- Information below item images:
  - Summary
  - Description
  - Image Identifier (renamed from Identifier)
  - Citation
- Information in right-hand panel:
  - Original Date
  - Topic (renamed from Category)
  - Tribe(s) (renamed from Tribal Affiliation)
  - Keywords
  - People
  - Places (renamed from Location Description]
  - Format
  - Type
- Disabled:
  - Author
  - Community
  - Protocol

Had to increase PHP config `max_input_vars` from 1000 for customizing "Category"
display as "Topic". Set the value to 2048 and then the change succeeded

Admin UI Screenshot:
- [Full content display
  config](images/digital-heritage-full-content-display-config.png)

## Allowed HTML Elements
The allowed HTML elements within user-written and imported content may be
customized.

Admin Menu > Configuration > Content authoring > Text formats

Click "configure" to the right of "Filtered HTML" or "Full HTML"

Scroll down to "Allowed HTML tags" and modify the space-separated list as
desired.

Click "Save configuration"

## Add Customizable Footer
Admin UI > Structure > Blocks

Change "Custom site footer" to display in the Footer region

Click "configure" to the right
- Set the desired "Text format" to allow the HTML elements you'd like to use
- Enter the content you'd like to display in the footer
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

Mouse over the search form near the top of the page and click the gear in the
upper right corner. Click "Edit view".

Under "Pane Settings", click the link to the right of "Use panel path". Change
the value to "No" and click "Apply".

Click "Advanced" on the right to open more settings. Click the link to the right
of "Link display". Click the radio next to "Custom URL" and enter
"/digital-heritage" in the input. Click "Apply (all displays)".

Click "Save".

Searches should know work from anywhere on the site

