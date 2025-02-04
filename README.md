# My Users Plugin

## Overview
This plugin displays a user list in WordPress using data from a third-party API. Users are shown in a table, and clicking on a user reveals additional details dynamically.

## Installation
1. Clone the repository into the `wp-content/plugins` directory.
2. Run `composer install` to install required dependencies.
3. Activate the plugin in the WordPress admin dashboard.

## Usage
Visit `/my-lovely-users-table/` on your site to see the user list.

## Key Features
- Custom endpoint for displaying the user table.
- Server-side API calls for data fetching.
- AJAX for dynamic user details display.
- Backend caching for optimized API calls.

## Implementation Decisions
- **Composer:** Used for dependency management.
- **Caching:** Implemented server-side to reduce API calls.
- **Error Handling:** Ensures a smooth user experience during API failures.
- **OOP Structure:** Promotes maintainable and scalable code.
