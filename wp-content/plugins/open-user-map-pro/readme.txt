=== Open User Map | Everybody can add locations ===
Contributors: 100plugins , freemius
Tags: map, location, collaborative, leaflet, user, marker
Requires at least: 4.6
Tested up to: 5.9
Requires PHP: 5.6
Stable tag: 1.2.14
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Let your visitors add new markers to a map (without registration). New locations will wait for your approval before getting published. The map is based on Leaflet.js (no API keys - it's free!).

== Description ==

🚀 Let your visitors add new markers to a map (without registration). New locations will wait for your approval before getting published. The map is based on Leaflet.js (no API keys - it's free!).

[Demo](https://www.open-user-map.com/demo/) | [More Info](https://www.open-user-map.com/)

Adding locations (backend and frontend) is as simple as dropping a marker on a map. **Search for addresses** worldwide to quickly find the right spots. Add custom fields and descriptions to the form to get the data you need.

The map is based on [Leaflet JS](https://leafletjs.com/) and offers you many free map and marker styles. So you do not need an API Key, Access Token or any other external registration. There are no API request limits. 

Use the **Gutenberg Block** to integrate your map or place the shortcode anywhere on your site. Close by locations will group together in clusters. Make use of Custom Fields to create the form accoding to your needs. In total there are **more than 60 options** to customize the map.

**FUN feature:**
Let your visitors upload sound to their locations. After your approval audio players will show up. 🎵

=== Howto add a new marker: ===
Just by clicking a "+"-Button a form will popup to let the visitor enter location details the same comfortable way you do it in the backend. After submit the location proposal will be "pending" and wait for your review approval to get published.

https://www.youtube.com/watch?v=kvIBY48yNgA

=== Free Features: ===
- frontend adding (can be disabled)
- admin approval for pending locations
- based on Leaflet
- no API Keys
- multiple map styles
- multiple marker styles
- full width map size
- locations with custom fields! 🥳
- "address", "description", "image", "audio" and even "title" fields can be disabled
- "address"-field links to google route
- every text bit can be customized
- locations with images & audio
- Shortcode with with custom settings
- Gutenberg Block with custom settings
- marker clustering
- fullscreen option
- refresh, redirection or thank you message after submit

=== 🚀 PRO ===
The Open User Map plugin is also available in a professional version which includes more styles, more funtionality and more flexibility!

- **More custom field types**
Add custom fields like links, radio buttons, checkboxes, dropdowns and even HTML. Social media links will automatically be rendered as icons.

- **Email user notification**
Users get notified by email after their location has been approved.

- **Email Admin notification**
Send notifications to an Admin email account on incoming location proposals.

- **User restriction**
Restrict "Add location" feature to registered users only. Redirect your visitors to the registration form.

- **Auto-publish**
When activated registered users will publish directly without admin approval. This can also be enabled for unregistered users.

- **Extend user registration**
Integrate the "Add location" feature to the WordPress user registration form.

- **Custom filesizes**
Customize max. filesize for image/audio uploads (default: 10MB).

- **Custom marker icons**
Use your own custom marker icon.

- **Custom UI Elements color**
Pick a color for buttons and icons that fits your theme.

- **Current location**
Add a button that relocates the map to the users current location.

- **Filterable Marker Categories**
Organize locations in multiple filterable marker groups. Each group (category) can have an individual marker icon and will be accessible to visitors.

- **Limit visible locations**
You can limit the locations to be shown by marker categories and by post ids. So it is possible to show only locations of a specific type or to render only one single location. This can be done in the block settings or with shortcode attributes.

- **Single pages for locations**
Per default locations will not have a single page. This should ensure that all the locations wont negatively affect your SEO. But if you'd like to add more content to locations you can easily enable it in the PRO version.

- **Allow registered users to edit their locations**
Open User Map PRO extends WordPress capabilities to allow backend access. If assigned to the user role registered users get access to read, edit and delete their locations from within the backend.

- **Submit your feature requests (high priority!)**
[Suggest features](https://www.open-user-map.com/) that you want to have and we will target these with high priority.

[Get a 7-day PRO trial (no credit card)](https://checkout.freemius.com/mode/dialog/plugin/9083/plan/16065/?trial=free)

=== A possible use case: ===
You want to build a map service where your visitors can add locations on their own. This could be a travel blog or a something like our [map with 500+ kite and windsurfing spots worldwide](https://surfspots.locations-and-areas.com).

=== Another use case: ===
Offer your audience a soundmap. The page visitors can not only upload text and images to their locations but audio as well! This way e.g urban (or remote) areas can be discovered by its specific soundscape. 

**The possibilities are endless. We are very curious about what you are building with the help of our plugin. Please don't hesitate to let us know or ask for feature requests in the support forum. As this plugin is under constant development we are keen to know what are the features that you need? Contact us!**

== Thanks: ==
neophytexx, dbark9, bergblume, angie77, stom1, opnavisuals, Krystian and many more for your feature requests that turned into actual functionality.

== Installation ==
From your WordPress dashboard

1. Visit Plugins > Add New
2. Search for “Open User Map”
3. Install and activate Open User Map from your Plugins page
4. Click on the new menu item “Open User Map” and create your first location!
5. Use the Gutenberg Block "Open User Map" (category "Widgets") or just use the shortcode `[open-user-map]` to show the map on your site.

== Frequently Asked Questions ==
= Do I need an API Key or some external registration? =
No, the plugin is based on Leaflet.js and offers you free map styles that don’t need any kind of registration.

= How to integrate the map? =
Use the Gutenberg Block "Open User Map" or just place the shortcode `[open-user-map]` anywhere in your content or integrate it within your theme template with PHP:

`echo do_shortcode("[open-user-map]")`

you can also override the initial map focus with shortcode attributes:

`[open-user-map lat="51.50665732176545" long="-0.12752251529432854" zoom="13"]`

= Can I set the initial map position individualy? =
If you want to override the initial map focus (settings) just use the shortcode with attributes:

`[open-user-map lat="51.50665732176545" long="-0.12752251529432854" zoom="13"]`

= Can I limit locations to a specific Type only? =
Yes, just add the "types" attribute to the shortcode:

`[open-user-map lat="51.50665732176545" long="-0.12752251529432854" zoom="13" types="food|drinks"]`

= Can I show only specific locations? =
Yes, just add the "ids" attribute to the shortcode:

`[open-user-map lat="51.50665732176545" long="-0.12752251529432854" zoom="13" ids="123"]`

= Do I need GPS coordinates? =
No. Add a new location simply by droping a marker on the map. You can search for addresses as well. If you want to use GPS coordinates though, there is an option for that.

= I want my own fields. Is this possible? =
Yes. You can add custom fields in the settings and use them instead of "address" and "description".

= Can I use Gutenberg? =
Yes! You will find the "Open User Map"-Block under widgets.

= Can I use marker clustering? =
Yes! This is enabled by default. You can disable it in the settings.

= Can I go fullscreen? =
Yes! There is a fullscreen control button on the top left of the map. You can disable it in the settings.

= Can I use custom styles? =
Yes, we encourage you to do so. This plugin is supposed to be developer friendly. Feel free to override the .open-user-map class in css to create your own awesome design.

= Can my users upload audio files? =
Yes! This is a new fun feature. Your visitors can upload mp3, wav and mp4 files and after your approval little audio players will be attached to the locations. The world needs soundmaps!

= Is there a max. filesize for image/audio uploads? =
Yes, per default it is 10MB. You customize that with the PRO version. Be aware that that you may need to increase **upload_max_filesize** and **post_max_size** on your server accordingly as they set the general limit for uploading files.

= Can I disable specific form fields? =
Yes, all default form fields can be disabled. You can use custom fields.

= Can the "link" field handle multiple URLs? =
Yes. They need to be separated with the | symbol.

= How can I access field values of a location? =
All location fields are stored as meta values. You can find the most recent list of currently availabe meta fields on [https://www.open-user-map.com/how-can-i-access-field-values-of-a-location/](https://www.open-user-map.com/how-can-i-access-field-values-of-a-location/).

= How to allow registered users to manage their locations? =
Make use of these capabilities: 'edit_oum-locations', 'edit_published_oum-locations' and 'delete_oum-locations'. Additionally you need to ensure the user has 'upload_files' capability if you want them to edit/upload images in the backend.
You can assign them to any user role with plugins like e.g. User Role Manager.

= I want to submit a feature request. =
Please do so! You can use the support forum to let us know about your ideas helping to make this plugin better. 

== Screenshots ==
1. Your map in the frontend
2. Show detail information on every location
3. Maybe try a different map style
4. ...or another one
5. Let your visitors add locations
6. The frontend popup form
7. The users Locations will be pending and wait for your approval
8. Use Marker clustering for locations that are close to each other
9. Edit Screen for Locations
10. Settings Screen
11. Settings Screen
12. Settings Screen
13. Integrate the map with Gutenberg Block Editor
14. X-mas Feature: visitors can upload audio files
15. Add Custom fields instead of "address" and "description"

== Changelog ==

= 1.2.14 =
* Bugfix: JS error in the backend (color-picker & custom fields)
* Bugfix: Image uploaded from the backend missing thumbnail
* Bugfix: Missing image rotation for mobile uploads
* Feature Request: All texts are now customizable
* Feature Request: New custom field "HTML"
* Feature Request: New capabilities that allow edit access for registered users
* Feature Request: Remove button for image & audio uploads
* Feature Request: Loading Icon on submit
* Optimized settings layout
* Code optimization

= 1.2.13 =
* Bugfix: php warning (type undefined)
* Feature Request: Allow refresh, redirection or text message after validation
* Feature Request: Notify admin on incoming location proposals
* Feature Request: Redirect "Add Location"-Button to registration form (when restricted to registered users only)
* Feature Request: Allow to limit the number of characters on text fields
* Feature Request: Allow empty option value
* Feature Request: Allow auto-publish for unregistered users

= 1.2.12 =
* Bugfix: Styling of checkboxes
* Bugfix: map paning on 1st click on marker incorrect due to lazy loading image dimensions
* Feature Request: new option to auto-generate title allowing locations without title
* Feature Request: Allow to change the title of the form and the title of the buttons
* Feature Request: limit map to specific location
* Feature Request: limit map to specific type
* Feature Request: adjustable map height (desktop & mobile)
* FEATURE: Customize Gutenberg Block with attributes

= 1.2.11 =
* Security Update
* Bugfix: "notify me on publish" was not translatable
* Feature Request: multiple links (separated with |)
* Feature Request: Add more Social Media Icons
* Feature Request: "Type" can have a custom label

= 1.2.10 =
* "Add location" button can be disabled entirely
* create and use automatic image thumbnails
* Better styling & validation for fieldsets
* hide empty custom fields
* Feature Request: "Full width", "Fixed Size" & "Reponsive size" option
* Feature Request: marker categories filter
* Feature Request: single pages for locations
* Feature Request: automatic Social Media Icons
* Feature Request: dynamic image size

= 1.2.9 =
* better styles for "+"-Button
* better settings overview
* Feature Request: change allowed audio file extensions to 'mp3', 'wav', 'mp4'
* Feature Request: individually disable "audio" and "image" upload
* Feature Request: mark "description", "audio" & "image" as required fields
* Feature Request: custom colors for ui elements
* Feature Request: more custom field types
* Feature Request: description texts for custom fields
* Bugfix: custom fields not showing correctly in the backend
* Bugfix: multiple approval confirmation emails

= 1.2.8 =
* Bugfix: default audio and image upload sizes
* optimized loading of settings
* fixing minor bugs
* ensure WordPress 5.9 compatibility

= 1.2.7 =
* Bugfix: "Address" & "Description" don't hide (thanks @tom29)
* Feature Request: pre-fill address field when geosearch succeeds

= 1.2.6 =
* Feature Request: Custom fields
* Feature Request: "Address" and "Description" fields can be disabled
* Feature Request: Search leads to marker placement

= 1.2.5 =
* PRO: use marker categories with individual marker icons

= 1.2.4 =
* Bugfix: enabling current user location

= 1.2.3 =
* Bugfix: UI settings page

= 1.2.2 =
* PRO: use your own custom marker icon
* PRO: add a button that relocates the map to the users current location (optional)

= 1.2.1 =
* wording

= 1.2.0 =
* major update provides access to PRO version
* better code structure
* limit max. filesize for image/audio uploads to 10MB
* PRO: user email notification after approval (optional)
* PRO: customize max. filesize for image/audio uploads
* PRO: auto-publish for registered users (optional)
* PRO: restrict "Add location" feature to registered users only (optional)
* PRO: add "Add location" feature to WordPress registration (optional)

= 1.1.10 =
* bugfix: dashicons

= 1.1.9 =
* FUN FEATURE: let your visitors upload audio to locations (xmas feature request)
* better frontend form
* code optimization

= 1.1.8 =
* new feature: use shortcode attributes to set initial map focus

= 1.1.7 =
* bugfix: escaping quotes

= 1.1.6 =
* escaping single quotes from HTML input

= 1.1.5 =
* better initial map position when adding new locations
* adding plugin contributers (thanks!)

= 1.1.4 =
* bugfix: fullscreen on ios
* better initial map position when adding another location
* better responsive styles for small screens

= 1.1.3 =
* style fixes

= 1.1.2 =
* style fixes

= 1.1.1 =
* better styling for overlay

= 1.1.0 =
* Add Fullscreen control
* Settings: custom "Thank you"-message
* better opt-in screen

= 1.0.0 =
* basic free features
* media assets & readme