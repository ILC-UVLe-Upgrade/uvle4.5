## Site settings
### Site home > Site home settings
- Site home
    - Set `None` for all.
- Site home items when logged in
    - Set `None` for all.
### Appearance > Themes > Boost
- Theme preset
    - From `default.scss` -> `uvle.scss`.
### Appearance > Logos
- Logo, Compact logo, Favicon
    - Add `uvle.png` to all three dialogs.

## Frontpage Configuration
### Frontpage Layout
- The frontpage layout has been configured to use a custom template for logged-out users
- Files created/modified:
  - `moodle/theme/boost/layout/frontpage.php` - Layout controller
  - `moodle/theme/boost/templates/frontpage.mustache` - Frontpage template
  - `moodle/theme/boost/config.php` - Updated to use frontpage.php layout

### Frontpage Features
- Hero section with login/signup buttons for logged-out users
- Site news/announcements display (if available)
- Welcome message and feature highlights
- Quick action buttons
- FAQ section
- Contact information

### Customization Options
- Edit `frontpage.mustache` to modify the frontpage design
- Update FAQ items in `frontpage.php` layout controller
- Add carousel slides in `frontpage.php` layout controller
- Modify contact information in the template