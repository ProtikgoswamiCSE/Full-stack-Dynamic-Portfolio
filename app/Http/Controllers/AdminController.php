<?php

namespace App\Http\Controllers;

use App\Models\HomeContent;
use App\Models\SocialMediaLink;
use Illuminate\Http\Request;
use App\Models\Skill;
use App\Models\Footer;
use App\Models\FooterSocialLink;
use App\Models\Achievement;
use App\Models\AboutContent;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * Show home page editor
     */
    public function editHome()
    {
        $homeContents = HomeContent::all()->keyBy('section');
        $socialLinks = SocialMediaLink::getAllOrdered();
        $skills = Skill::orderBy('order')->get();
        return view('admin.edit-home', compact('homeContents', 'socialLinks', 'skills'));
    }

    // Simple editors for other pages (placeholders for now)
    public function editAbout() { 
        $aboutContents = AboutContent::getAllOrdered();
        return view('admin.edit-about', compact('aboutContents')); 
    }
    public function editAchivement() { 
        $achievements = Achievement::getAllOrdered();
        return view('admin.edit-achivement', compact('achievements')); 
    }
    public function editAcademic() { return view('admin.edit-academic'); }
    public function editWork() { return view('admin.edit-work'); }
    public function editImage() { return view('admin.edit-image'); }
    public function editContact() { return view('admin.edit-contact'); }
    public function editFooter() {
        $footer = Footer::getActive();
        $socialLinks = FooterSocialLink::getAllOrdered();
        return view('admin.edit-footer', compact('footer', 'socialLinks'));
    }

    // Footer Social Links Management
    public function addFooterSocialLink(Request $request)
    {
        $request->validate([
            'platform' => 'required|string|max:50',
            'url' => 'required|url|max:255',
            'order' => 'required|integer|min:1',
        ]);

        $socialLink = new FooterSocialLink();
        $socialLink->platform = $request->platform;
        $socialLink->url = $request->url;
        $socialLink->order = $request->order;
        $socialLink->save();

        return response()->json(['success' => true, 'message' => 'Social link added successfully']);
    }

    public function updateFooterSocialLink(Request $request, $id)
    {
        $request->validate([
            'platform' => 'required|string|max:50',
            'url' => 'required|url|max:255',
            'order' => 'required|integer|min:1',
        ]);

        $socialLink = FooterSocialLink::findOrFail($id);
        $socialLink->platform = $request->platform;
        $socialLink->url = $request->url;
        $socialLink->order = $request->order;
        $socialLink->save();

        return response()->json(['success' => true, 'message' => 'Social link updated successfully']);
    }

    public function deleteFooterSocialLink($id)
    {
        $socialLink = FooterSocialLink::findOrFail($id);
        $socialLink->delete();

        return response()->json(['success' => true, 'message' => 'Social link deleted successfully']);
    }

    public function toggleFooterSocialLink($id)
    {
        $socialLink = FooterSocialLink::findOrFail($id);
        $socialLink->is_active = !$socialLink->is_active;
        $socialLink->save();

        return response()->json([
            'success' => true,
            'message' => 'Social link ' . ($socialLink->is_active ? 'activated' : 'deactivated') . ' successfully',
            'is_active' => $socialLink->is_active
        ]);
    }

    public function updateFooter(Request $request)
    {
        try {
            \Log::info('Footer update request received', $request->all());
            
            $request->validate([
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'copyright_text' => 'nullable|string|max:255',
                'facebook_url' => 'nullable|url',
                'twitter_url' => 'nullable|url',
                'linkedin_url' => 'nullable|url',
                'github_url' => 'nullable|url',
                'instagram_url' => 'nullable|url',
            ]);

            $footer = Footer::first();
            if (!$footer) {
                $footer = new Footer();
                $footer->is_active = true; // Set default active status
                \Log::info('Creating new footer record');
            } else {
                \Log::info('Updating existing footer record', ['id' => $footer->id]);
            }

            $footer->fill($request->all());
            $footer->save();

            \Log::info('Footer updated successfully', ['id' => $footer->id, 'data' => $footer->toArray()]);

            return response()->json(['success' => true, 'message' => 'Footer updated successfully']);
        } catch (\Exception $e) {
            \Log::error('Error updating footer: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'Error updating footer: ' . $e->getMessage()]);
        }
    }

    /**
     * Skills CRUD
     */
    public function addSkill(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:100',
                'icon_class' => 'nullable|string|max:100',
                'proficiency_percent' => 'required|integer|min:0|max:100',
            ]);

            $skill = new Skill();
            $skill->name = $request->name;
            $skill->icon_class = $request->icon_class;
            $skill->proficiency_percent = $request->proficiency_percent;
            $skill->order = Skill::getNextOrder();
            $skill->is_active = true;
            $skill->save();

            return redirect()->route('admin.edit-home')->with('success', 'Skill added successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.edit-home')->with('error', 'Error adding skill: ' . $e->getMessage());
        }
    }

    public function updateSkill(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:100',
                'icon_class' => 'nullable|string|max:100',
                'proficiency_percent' => 'required|integer|min:0|max:100',
                'order' => 'required|integer|min:1',
                'is_active' => 'boolean',
            ]);

            $skill = Skill::findOrFail($id);
            $skill->update([
                'name' => $request->name,
                'icon_class' => $request->icon_class,
                'proficiency_percent' => $request->proficiency_percent,
                'order' => $request->order,
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()->route('admin.edit-home')->with('success', 'Skill updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.edit-home')->with('error', 'Error updating skill: ' . $e->getMessage());
        }
    }

    public function deleteSkill($id)
    {
        try {
            $skill = Skill::findOrFail($id);
            $skill->delete();
            return redirect()->route('admin.edit-home')->with('success', 'Skill deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.edit-home')->with('error', 'Error deleting skill: ' . $e->getMessage());
        }
    }

    public function toggleSkill($id)
    {
        try {
            $skill = Skill::findOrFail($id);
            $skill->is_active = !$skill->is_active;
            $skill->save();

            $status = $skill->is_active ? 'activated' : 'deactivated';
            return redirect()->route('admin.edit-home')->with('success', "Skill {$status} successfully!");
        } catch (\Exception $e) {
            return redirect()->route('admin.edit-home')->with('error', 'Error toggling skill: ' . $e->getMessage());
        }
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

    // Achievement Management
    public function addAchievement(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'certificate_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'certificate_url' => 'nullable|url|max:255',
                'order' => 'required|integer|min:1',
            ]);

            $achievement = new Achievement();
            $achievement->title = $request->title;
            $achievement->description = $request->description;
            $achievement->certificate_url = $request->certificate_url;
            $achievement->order = $request->order;
            $achievement->is_active = true;

            // Handle image upload
            if ($request->hasFile('certificate_image')) {
                $imagePath = $request->file('certificate_image')->store('achievements', 'public');
                $achievement->certificate_image = $imagePath;
            }

            $achievement->save();

            return response()->json(['success' => true, 'message' => 'Achievement added successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error adding achievement: ' . $e->getMessage()]);
        }
    }

    public function updateAchievement(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'certificate_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'certificate_url' => 'nullable|url|max:255',
                'order' => 'required|integer|min:1',
            ]);

            $achievement = Achievement::findOrFail($id);
            $achievement->title = $request->title;
            $achievement->description = $request->description;
            $achievement->certificate_url = $request->certificate_url;
            $achievement->order = $request->order;

            // Handle image upload
            if ($request->hasFile('certificate_image')) {
                // Delete old image if exists
                if ($achievement->certificate_image) {
                    \Storage::disk('public')->delete($achievement->certificate_image);
                }
                $imagePath = $request->file('certificate_image')->store('achievements', 'public');
                $achievement->certificate_image = $imagePath;
            }

            $achievement->save();

            return response()->json(['success' => true, 'message' => 'Achievement updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating achievement: ' . $e->getMessage()]);
        }
    }

    public function deleteAchievement($id)
    {
        try {
            $achievement = Achievement::findOrFail($id);
            
            // Delete image if exists
            if ($achievement->certificate_image) {
                \Storage::disk('public')->delete($achievement->certificate_image);
            }
            
            $achievement->delete();

            return response()->json(['success' => true, 'message' => 'Achievement deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting achievement: ' . $e->getMessage()]);
        }
    }

    public function toggleAchievement($id)
    {
        try {
            $achievement = Achievement::findOrFail($id);
            $achievement->is_active = !$achievement->is_active;
            $achievement->save();

            $status = $achievement->is_active ? 'activated' : 'deactivated';
            return response()->json([
                'success' => true,
                'message' => 'Achievement ' . $status . ' successfully',
                'is_active' => $achievement->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error toggling achievement: ' . $e->getMessage()]);
        }
    }

    // About Content Management
    public function getAboutContent($id)
    {
        try {
            $aboutContent = AboutContent::findOrFail($id);
            return response()->json($aboutContent);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Content not found'], 404);
        }
    }

    public function addAboutContent(Request $request)
    {
        try {
            $request->validate([
                'section' => 'required|string|max:50',
                'custom_section' => 'nullable|string|max:100',
                'title' => 'nullable|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:5120',
                'order' => 'required|integer|min:1',
            ]);

            $aboutContent = new AboutContent();
            $aboutContent->section = $request->section;
            $aboutContent->custom_section = $request->custom_section;
            $aboutContent->title = $request->title;
            $aboutContent->content = $request->content;
            $aboutContent->order = $request->order;
            $aboutContent->is_active = true;

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('about', 'public');
                $aboutContent->image = $imagePath;
            }

            $aboutContent->save();

            return response()->json(['success' => true, 'message' => 'About content added successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error adding about content: ' . $e->getMessage()]);
        }
    }

    public function updateAboutContent(Request $request, $id)
    {
        try {
            $request->validate([
                'section' => 'required|string|max:50',
                'custom_section' => 'nullable|string|max:100',
                'title' => 'nullable|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:5120',
                'order' => 'required|integer|min:1',
            ]);

            $aboutContent = AboutContent::findOrFail($id);
            $aboutContent->section = $request->section;
            $aboutContent->custom_section = $request->custom_section;
            $aboutContent->title = $request->title;
            $aboutContent->content = $request->content;
            $aboutContent->order = $request->order;

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($aboutContent->image) {
                    \Storage::disk('public')->delete($aboutContent->image);
                }
                $imagePath = $request->file('image')->store('about', 'public');
                $aboutContent->image = $imagePath;
            }

            $aboutContent->save();

            return response()->json(['success' => true, 'message' => 'About content updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating about content: ' . $e->getMessage()]);
        }
    }

    public function deleteAboutContent($id)
    {
        try {
            $aboutContent = AboutContent::findOrFail($id);
            
            // Delete image if exists
            if ($aboutContent->image) {
                \Storage::disk('public')->delete($aboutContent->image);
            }
            
            $aboutContent->delete();

            return response()->json(['success' => true, 'message' => 'About content deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting about content: ' . $e->getMessage()]);
        }
    }

    public function toggleAboutContent($id)
    {
        try {
            $aboutContent = AboutContent::findOrFail($id);
            $aboutContent->is_active = !$aboutContent->is_active;
            $aboutContent->save();

            $status = $aboutContent->is_active ? 'activated' : 'deactivated';
            return response()->json([
                'success' => true,
                'message' => 'About content ' . $status . ' successfully',
                'is_active' => $aboutContent->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error toggling about content: ' . $e->getMessage()]);
        }
    }
}
