<?php

namespace App\Http\Controllers;

use App\Models\HomeContent;
use App\Models\SocialMediaLink;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $homeContents = HomeContent::all();
        $socialLinks = SocialMediaLink::getAllOrdered();
        return view('admin.dashboard', compact('homeContents', 'socialLinks'));
    }

    /**
     * Show home page editor
     */
    public function editHome()
    {
        $homeContents = HomeContent::all()->keyBy('section');
        $socialLinks = SocialMediaLink::getAllOrdered();
        return view('admin.edit-home', compact('homeContents', 'socialLinks'));
    }

    /**
     * Update home page content
     */
    public function updateHome(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:500',
                'subtitle' => 'required|string|max:255',
                'skills_list' => 'required|string|max:1000',
                'contact_button_text' => 'required|string|max:100',
            ]);

            // Update each section
            HomeContent::updateContent('title', $request->title);
            HomeContent::updateContent('subtitle', $request->subtitle);
            HomeContent::updateContent('skills_list', $request->skills_list);
            HomeContent::updateContent('contact_button_text', $request->contact_button_text);

            return redirect()->route('admin.edit-home')->with('success', 'Home page updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.edit-home')->with('error', 'Error updating home page: ' . $e->getMessage());
        }
    }

    /**
     * Add new social media link
     */
    public function addSocialLink(Request $request)
    {
        try {
            $request->validate([
                'platform' => 'required|string|max:50',
                'name' => 'required|string|max:100',
                'icon_class' => 'required|string|max:100',
                'url' => 'required|url|max:500',
            ]);

            $socialLink = new SocialMediaLink();
            $socialLink->platform = $request->platform;
            $socialLink->name = $request->name;
            $socialLink->icon_class = $request->icon_class;
            $socialLink->url = $request->url;
            $socialLink->order = SocialMediaLink::getNextOrder();
            $socialLink->save();

            return redirect()->route('admin.edit-home')->with('success', 'Social media link added successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.edit-home')->with('error', 'Error adding social media link: ' . $e->getMessage());
        }
    }

    /**
     * Update social media link
     */
    public function updateSocialLink(Request $request, $id)
    {
        try {
            $request->validate([
                'platform' => 'required|string|max:50',
                'name' => 'required|string|max:100',
                'icon_class' => 'required|string|max:100',
                'url' => 'required|url|max:500',
                'order' => 'required|integer|min:1',
                'is_active' => 'boolean',
            ]);

            $socialLink = SocialMediaLink::findOrFail($id);
            $socialLink->update($request->all());

            return redirect()->route('admin.edit-home')->with('success', 'Social media link updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.edit-home')->with('error', 'Error updating social media link: ' . $e->getMessage());
        }
    }

    /**
     * Delete social media link
     */
    public function deleteSocialLink($id)
    {
        try {
            $socialLink = SocialMediaLink::findOrFail($id);
            $socialLink->delete();

            return redirect()->route('admin.edit-home')->with('success', 'Social media link deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.edit-home')->with('error', 'Error deleting social media link: ' . $e->getMessage());
        }
    }

    /**
     * Toggle social media link status
     */
    public function toggleSocialLink($id)
    {
        try {
            $socialLink = SocialMediaLink::findOrFail($id);
            $socialLink->is_active = !$socialLink->is_active;
            $socialLink->save();

            $status = $socialLink->is_active ? 'activated' : 'deactivated';
            return redirect()->route('admin.edit-home')->with('success', "Social media link {$status} successfully!");
        } catch (\Exception $e) {
            return redirect()->route('admin.edit-home')->with('error', 'Error toggling social media link: ' . $e->getMessage());
        }
    }

    /**
     * Initialize default content
     */
    public function initializeContent()
    {
        $defaults = [
            'title' => 'Hi there,<br>I\'m <span class="home__title-color">Protik Goswami</span><br>Web Designer',
            'subtitle' => 'Network Security Specialist',
            'skills_list' => "* Network Security Specialist\n* Programming\n* UI/UX Design\n* Artificial Intelligence",
            'contact_button_text' => 'Contact',
        ];

        foreach ($defaults as $section => $content) {
            HomeContent::updateContent($section, $content);
        }

        // Initialize default social media links
        $defaultSocialLinks = [
            [
                'platform' => 'github',
                'name' => 'GitHub',
                'icon_class' => 'fa-brands fa-github',
                'url' => 'https://github.com/ProtikgoswamiCSE',
                'order' => 1,
            ],
            [
                'platform' => 'facebook',
                'name' => 'Facebook',
                'icon_class' => 'fa-brands fa-facebook',
                'url' => 'https://www.facebook.com/protik.goswami.140',
                'order' => 2,
            ],
            [
                'platform' => 'instagram',
                'name' => 'Instagram',
                'icon_class' => 'fa-brands fa-instagram',
                'url' => 'https://www.instagram.com/goswamiprotik/',
                'order' => 3,
            ],
        ];

        foreach ($defaultSocialLinks as $link) {
            SocialMediaLink::create($link);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Default content and social media links initialized!');
    }
}
