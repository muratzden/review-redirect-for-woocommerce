# Changelog

All notable changes to Review Redirect for WooCommerce will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project follows [Semantic Versioning](https://semver.org/spec/v2.0.0.html).


## [0.1.7] - 2026-06-30

### Changed

- Fixed rating star clipping by giving each star a safer hit area while keeping the visual star size controlled.
- Reduced rating state spacing and close button prominence for a more compact popup.
- Added a small positive-state star confirmation row and tightened feedback textarea height.
- Preserved RRFW_VERSION asset enqueueing and existing AJAX nonce/order key behavior.

## [0.1.4] - 2026-06-30

### Changed

- Added the RC2 popup UI specification.
- Fixed popup layout to a controlled 440px modal with safer desktop and mobile sizing.
- Simplified rating stars by removing oversized background containers.
- Improved positive rating, low-rating feedback, feedback success, and Google click success presentation states.


## [v0.1.1] - 2026-06-30

### Changed

- Improved popup visual design.
- Refreshed frontend asset version for cache busting.

## [v0.1.0] - 2026-06-30

### Added

- Initial free Google review workflow.
- WooCommerce order received page review prompt.
- Configurable Google review URL, popup copy, rating threshold, notification email, and completed order email option.
- Low-rating private feedback storage as WooCommerce order meta.
- Admin notification email for low-rating feedback.
- WooCommerce completed order email review request content.
- AJAX nonce verification and WooCommerce order key validation.
- Duplicate feedback prevention.
- Per-order local browser prompt suppression.
- HPOS compatibility declaration.
- WordPress.org readme, uninstall cleanup, and translation template.



