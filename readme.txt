=== Review Redirect for WooCommerce ===
Contributors: muratozden
Tags: woocommerce, reviews, google reviews, customer feedback, marketing
Requires at least: 6.0
Tested up to: 7.0
Requires PHP: 7.4
Requires Plugins: woocommerce
Stable tag: 0.1.7
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Collect customer ratings after WooCommerce orders and invite happy customers to leave a Google review.

== Description ==

Review Redirect for WooCommerce helps store owners collect customer sentiment after completed purchases.

On the WooCommerce order received page, customers can choose a star rating. Ratings at or above the configured threshold reveal a Google review button. Lower ratings open a private feedback form so the store can learn what went wrong before asking for a public review.

The plugin can also add review request content to WooCommerce completed order emails.

== Features ==

* Enable or disable the review prompt.
* Configure the Google review URL.
* Customize popup title and message.
* Set the positive rating threshold.
* Save low-rating feedback to order meta.
* Send low-rating feedback notifications by email.
* Optionally add review request content to completed order emails.
* Verify order keys before accepting private feedback.
* Avoid repeated prompts for the same order in the same browser.

== Requirements ==

* WordPress 6.0 or higher.
* PHP 7.4 or higher.
* WooCommerce 7.0 or higher.

== Installation ==

1. Upload the `review-redirect-for-woocommerce` folder to `/wp-content/plugins/`.
2. Activate the plugin through the Plugins screen in WordPress.
3. Go to Marketing > Review Redirect to configure settings.

== Frequently Asked Questions ==

= Does this plugin require WooCommerce? =

Yes. Review Redirect for WooCommerce depends on WooCommerce order pages and email hooks.

= Does the plugin automatically redirect customers? =

No. Customers choose whether to click the Google review button.

= Which Google review URLs are accepted? =

The Google review URL must use one of these hosts: `google.com`, `www.google.com`, `g.page`, `maps.app.goo.gl`, or `search.google.com`.

= Does the plugin override WooCommerce email templates? =

No. It uses WooCommerce email hooks.

= Where is private feedback stored? =

Private low-rating feedback is stored as WooCommerce order meta using the `_rrfw_feedback` meta key.

== Screenshots ==

1. Review Redirect settings page under Marketing.
2. Customer star rating prompt on the WooCommerce order received page.
3. Private feedback form shown for ratings below the configured threshold.

== Changelog ==

= 0.1.7 =
* Polished rating star alignment to prevent clipping on desktop and mobile.
* Tightened popup spacing, close button sizing, and feedback textarea height.
* Added a small positive-state rating confirmation row.

= 0.1.4 =
* Fixed popup layout to a controlled 440px modal with safer responsive sizing.
* Simplified star rating presentation and removed oversized star containers.
* Improved positive, feedback, and Google click success states.


= 0.1.1 =
* Improved popup visual design and refreshed frontend asset version.

= 0.1.0 =
* Initial release.

== Upgrade Notice ==

= 0.1.7 =
Final popup UI polish for rating alignment and compact spacing.

= 0.1.4 =
Popup UI specification and responsive layout update.


= 0.1.1 =
Popup UI styling refresh.

= 0.1.0 =
Initial release.



