# ThumbFeedback

**ThumbFeedback** is a simple MediaWiki extension that allows users to rate articles with thumbs up / thumbs down and add short comments. Data is stored in the database, and administrators can view all ratings on a special page.

---

## Features

- Thumbs up / thumbs down as radio buttons
- Comment input field
- View comments on the special page `Special:ThumbFeedback`
- "Thank you for your feedback" popup after submission
- Color highlighting of buttons (green / red) when a vote is selected

---

## Installation

1. Copy the `ThumbFeedback` folder to `extensions/` in your MediaWiki installation.
2. Add to `LocalSettings.php`:

```php
wfLoadExtension( 'ThumbFeedback' );
```
3. Create the database table by running:
php maintenance/update.php
4. Make sure JS and CSS files are accessible and correctly loaded in extension.json.

---
## Configuration

You can optionally customize the form appearance, placeholder texts, or thumb colors by editing:
modules/ThumbFeedback.js – frontend logic, form display, AJAX
modules/ThumbFeedback.css – form styles and thumb coloring
i18n/en.json / i18n/pl.json – messages in different languages

---
## Special Page
After installation, a special page is available:
`Special:ThumbFeedback`

It contains a table with all comments and ratings:
`ID	Page	User	Vote	Comment	Date`

---
## Frontend
Form appears at the bottom of the article (above the footer)
Radio buttons as thumbs
Text area below the thumbs
"Submit" button to the right of the text area
Form submission does not reload the page
Shows a popup confirmation after sending feedback
