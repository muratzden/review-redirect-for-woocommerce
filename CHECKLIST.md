# Review Redirect for WooCommerce Checklist

## Manual test checklist

- Activate WooCommerce and Review Redirect for WooCommerce.
- Confirm the Plugins screen shows a Settings action link.
- Confirm Settings opens the Review Redirect settings page under Marketing.
- Save settings with the plugin enabled, a valid Google review URL, a custom title/message, threshold, notification email, and completed order email enabled.
- Complete a test order and open the order received page.
- Select a rating at or above the threshold and confirm only the Google review button appears.
- Select a rating below the threshold and submit private feedback.
- Confirm low-rating feedback is saved to the order meta key `_rrfw_feedback`.
- Confirm the notification email is sent to the configured email address.
- Trigger a customer completed order email and confirm review request content is appended.
- Submit feedback with a valid order ID and invalid order key; confirm the AJAX response rejects it.
- Submit low-rating feedback twice for the same order; confirm the second request is rejected as already submitted.
- Save a Google review URL with an unapproved host; confirm the setting is cleared and a settings error appears.
- Click the Google review button, reload the order received page, and confirm the popup does not appear again for that order.
- Submit private feedback successfully, reload the order received page, and confirm the popup does not appear again for that order.

## Plugin Check checklist

- Plugin header is complete and uses the `review-redirect-for-woocommerce` text domain.
- `Requires Plugins: woocommerce` is present.
- No direct file access is allowed.
- Settings are registered with `register_setting()` and a sanitize callback.
- Output is escaped with WordPress escaping functions.
- User input is sanitized before storage or use.
- AJAX requests verify a nonce with `check_ajax_referer()`.
- AJAX feedback requests verify the submitted WooCommerce order key.
- Duplicate feedback for the same order is rejected.
- Google review URLs are limited to approved Google hosts.
- No custom database tables are created.
- WooCommerce templates are not overridden.
- HPOS compatibility is declared with WooCommerce `FeaturesUtil`.

## Security checklist

- Admin settings page checks `current_user_can()`.
- Settings form uses WordPress Settings API nonce output via `settings_fields()`.
- Frontend AJAX nonce is passed with `wp_localize_script()`.
- Frontend AJAX includes both `order_id` and `order_key`.
- Order IDs and ratings use `absint()`.
- Order keys use `sanitize_text_field()` and are compared to the WooCommerce order key.
- Feedback messages use `sanitize_textarea_field()`.
- Settings URLs use `esc_url_raw()`.
- Google review URL hosts are parsed with `wp_parse_url()` and allowlisted.
- Email addresses use `sanitize_email()` and `is_email()`.
- Frontend and admin output is escaped with `esc_html()`, `esc_attr()`, `esc_url()`, `esc_textarea()`, or `wp_kses_post()`.
- Uninstall removes plugin options and stored feedback meta.
