# Admin Panel - Portfolio Management System

## Overview
This admin panel allows you to manage your portfolio website content dynamically without editing code files. You can edit the home page content and manage social media links through a user-friendly interface.

## Access
- **Admin Dashboard**: `/admin`
- **Edit Home Page**: `/admin/edit-home`

## Features

### 1. Home Page Content Management
- **Title**: Edit the main heading with HTML support (e.g., line breaks, styling)
- **Subtitle**: Update the subtitle text
- **Skills List**: Manage your skills list (one per line, starting with *)
- **Contact Button**: Customize the contact button text

### 2. Social Media Links Management
- **Add New Links**: Click "Add New Link" button to add social media profiles
- **Edit Links**: Click the edit button (pencil icon) to modify existing links
- **Delete Links**: Click the delete button (trash icon) to remove links
- **Toggle Status**: Activate/deactivate links using the eye icon
- **Reorder**: Change the display order of links

### 3. Social Media Link Fields
- **Platform**: Internal identifier (e.g., github, facebook, instagram)
- **Display Name**: What users see (e.g., GitHub, Facebook, Instagram)
- **Icon Class**: FontAwesome icon class (e.g., fa-brands fa-github)
- **URL**: The actual link to your profile
- **Order**: Display order (lower numbers appear first)
- **Active Status**: Whether the link is visible on the website

## Getting Started

### Step 1: Initialize Content
1. Go to `/admin`
2. Click "Initialize Content" in the sidebar
3. This will create default content and social media links

### Step 2: Customize Content
1. Go to `/admin/edit-home`
2. Edit the home page content in the form
3. Click "Update Home Page" to save changes

### Step 3: Manage Social Media
1. In the Social Media Links section, click "Add New Link"
2. Fill in the required information
3. Use the action buttons to edit, delete, or toggle links

## Icon Classes
For social media icons, use FontAwesome classes. Common examples:
- GitHub: `fa-brands fa-github`
- Facebook: `fa-brands fa-facebook`
- Instagram: `fa-brands fa-instagram`
- Twitter: `fa-brands fa-twitter`
- LinkedIn: `fa-brands fa-linkedin`
- YouTube: `fa-brands fa-youtube`

Find more icons at: https://fontawesome.com/icons

## Tips
- HTML is supported in the title field for advanced formatting
- Skills should start with an asterisk (*) and be on separate lines
- Social media links can be reordered by changing the order number
- Inactive social media links won't appear on the website
- All changes are saved immediately to the database

## Security
- The admin panel is currently open to anyone who knows the URL
- Consider adding authentication in production environments
- All form inputs are validated and sanitized

## Support
If you encounter any issues:
1. Check that all required fields are filled
2. Ensure URLs are valid (start with http:// or https://)
3. Verify FontAwesome icon classes are correct
4. Check the browser console for JavaScript errors
