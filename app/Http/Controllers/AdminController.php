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
use App\Models\Academic;
use App\Models\ProfileImageSetting;
use App\Models\AiImage;
use App\Models\GalleryImage;
use App\Models\Project;
use App\Models\Work;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

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
        $profileSettings = ProfileImageSetting::getSettings();
        $aiImage = AiImage::getActiveImageForPage('skills');
        return view('admin.edit-home', compact('homeContents', 'socialLinks', 'skills', 'profileSettings', 'aiImage'));
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
    public function editAcademic() { 
        $academics = Academic::getAllOrdered();
        return view('admin.edit-academic', compact('academics')); 
    }
    public function editWork() { 
        $works = Work::getAllOrdered();
        return view('admin.edit-work', compact('works')); 
    }
    public function editProject() { 
        $projects = Project::getAllOrdered();
        return view('admin.edit-project', compact('projects')); 
    }
    public function editImage() 
    { 
        $aiImage = \App\Models\AiImage::getActiveImageForPage('skills');
        $galleryImages = GalleryImage::ordered()->get();
        return view('admin.edit-image', compact('aiImage', 'galleryImages')); 
    }
    public function editContact() {
        $messages = \App\Models\ContactMessage::orderByDesc('created_at')->get();
        return view('admin.edit-contact', compact('messages'));
    }

    public function deleteContactMessage($id)
    {
        try {
            $message = \App\Models\ContactMessage::findOrFail($id);
            $message->delete();
            return back()->with('success', 'Message deleted');
        } catch (\Exception $e) {
            return back()->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }

    public function bulkDeleteContactMessages(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer'
        ]);
        try {
            \App\Models\ContactMessage::whereIn('id', $request->ids)->delete();
            return back()->with('success', 'Selected messages deleted');
        } catch (\Exception $e) {
            return back()->with('error', 'Bulk delete failed: ' . $e->getMessage());
        }
    }

    public function deleteAllContactMessages()
    {
        try {
            \App\Models\ContactMessage::query()->delete();
            return back()->with('success', 'All messages deleted');
        } catch (\Exception $e) {
            return back()->with('error', 'Delete all failed: ' . $e->getMessage());
        }
    }
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
                'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:5120',
                'proficiency_percent' => 'required|integer|min:0|max:100',
            ]);

            $skill = new Skill();
            $skill->name = $request->name;
            $skill->icon_class = $request->icon_class;
            $skill->proficiency_percent = $request->proficiency_percent;
            $skill->order = Skill::getNextOrder();
            $skill->is_active = true;

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('skills', 'public');
                $skill->image = $imagePath;
            }

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
                'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:5120',
                'proficiency_percent' => 'required|integer|min:0|max:100',
                'order' => 'required|integer|min:1',
                'is_active' => 'boolean',
            ]);

            $skill = Skill::findOrFail($id);
            
            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($skill->image) {
                    \Storage::disk('public')->delete($skill->image);
                }
                $imagePath = $request->file('image')->store('skills', 'public');
                $skill->image = $imagePath;
            }

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
            
            // Delete image if exists
            if ($skill->image) {
                \Storage::disk('public')->delete($skill->image);
            }
            
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
            \Log::info('Update home request received', $request->all());
            
            $request->validate([
                'title' => 'required|string|max:500',
                'subtitle' => 'required|string|max:255',
                'skills_list' => 'required|string|max:1000',
                'contact_button_text' => 'required|string|max:100',
                'animation_enabled' => 'nullable'
            ]);

            // Update each section - don't escape HTML for title
            $titleResult = HomeContent::updateContent('title', $request->title);
            $subtitleResult = HomeContent::updateContent('subtitle', $request->subtitle);
            $skillsResult = HomeContent::updateContent('skills_list', $request->skills_list);
            $contactResult = HomeContent::updateContent('contact_button_text', $request->contact_button_text);
            $animationResult = HomeContent::updateContent('animation_enabled', $request->has('animation_enabled') ? '1' : '0');

            \Log::info('Home content updated successfully', [
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'skills_list' => $request->skills_list,
                'contact_button_text' => $request->contact_button_text,
                'animation_enabled' => $request->has('animation_enabled') ? '1' : '0',
                'title_result' => $titleResult ? $titleResult->id : 'failed',
                'subtitle_result' => $subtitleResult ? $subtitleResult->id : 'failed',
                'skills_result' => $skillsResult ? $skillsResult->id : 'failed',
                'contact_result' => $contactResult ? $contactResult->id : 'failed',
                'animation_result' => $animationResult ? $animationResult->id : 'failed'
            ]);

            return redirect()->route('admin.edit-home')->with('success', 'Home page updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Error updating home page: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return redirect()->route('admin.edit-home')->with('error', 'Error updating home page: ' . $e->getMessage());
        }
    }

    /**
     * Update profile image settings
     */
    public function updateProfileImage(Request $request)
    {
        try {
            $request->validate([
                'profile_image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:5120',
                'image_alt_text' => 'nullable|string|max:255',
                'background_color' => 'required|string|max:7',
                'border_color' => 'required|string|max:7',
                'shadow_color' => 'required|string|max:7',
                'shadow_opacity' => 'required|integer|min:0|max:100',
            ]);

            $data = $request->only([
                'image_alt_text',
                'background_color',
                'border_color',
                'shadow_color',
                'shadow_opacity'
            ]);

            // Handle image upload
            if ($request->hasFile('profile_image')) {
                // Delete old image if exists
                $currentSettings = ProfileImageSetting::getSettings();
                if ($currentSettings->profile_image) {
                    \Storage::disk('public')->delete($currentSettings->profile_image);
                }
                
                $imagePath = $request->file('profile_image')->store('profile', 'public');
                $data['profile_image'] = $imagePath;
            }

            $updatedSettings = ProfileImageSetting::updateSettings($data);

            return response()->json([
                'success' => true, 
                'message' => 'Profile image settings updated successfully',
                'data' => $updatedSettings
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating profile image settings: ' . $e->getMessage()]);
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
                'certificate_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:5120',
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
                'certificate_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:5120',
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

    public function getAchievement($id)
    {
        try {
            $achievement = Achievement::findOrFail($id);
            return response()->json($achievement);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error fetching achievement: ' . $e->getMessage()]);
        }
    }

    // Academic Management
    public function addAcademic(Request $request)
    {
        try {
            $request->validate([
                'institution_name' => 'required|string|max:255',
                'degree_title' => 'required|string|max:255',
                'field_of_study' => 'required|string|max:255',
                'start_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 10),
                'end_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 10),
                'description' => 'nullable|string',
                'certificate_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:5120',
                'certificate_url' => 'nullable|url|max:255',
                'order' => 'required|integer|min:1',
            ]);

            $academic = new Academic();
            $academic->institution_name = $request->institution_name;
            $academic->degree_title = $request->degree_title;
            $academic->field_of_study = $request->field_of_study;
            $academic->start_year = $request->start_year;
            $academic->end_year = $request->end_year;
            $academic->description = $request->description;
            $academic->certificate_url = $request->certificate_url;
            $academic->order = $request->order;
            $academic->is_active = true;

            // Handle image upload
            if ($request->hasFile('certificate_image')) {
                $imagePath = $request->file('certificate_image')->store('academics', 'public');
                $academic->certificate_image = $imagePath;
            }

            $academic->save();

            return response()->json(['success' => true, 'message' => 'Academic record added successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error adding academic record: ' . $e->getMessage()]);
        }
    }

    public function updateAcademic(Request $request, $id)
    {
        try {
            $request->validate([
                'institution_name' => 'required|string|max:255',
                'degree_title' => 'required|string|max:255',
                'field_of_study' => 'required|string|max:255',
                'start_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 10),
                'end_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 255),
                'description' => 'nullable|string',
                'certificate_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:5120',
                'certificate_url' => 'nullable|url|max:255',
                'order' => 'required|integer|min:1',
            ]);

            $academic = Academic::findOrFail($id);
            $academic->institution_name = $request->institution_name;
            $academic->degree_title = $request->degree_title;
            $academic->field_of_study = $request->field_of_study;
            $academic->start_year = $request->start_year;
            $academic->end_year = $request->end_year;
            $academic->description = $request->description;
            $academic->certificate_url = $request->certificate_url;
            $academic->order = $request->order;

            // Handle image upload
            if ($request->hasFile('certificate_image')) {
                // Delete old image if exists
                if ($academic->certificate_image) {
                    \Storage::disk('public')->delete($academic->certificate_image);
                }
                $imagePath = $request->file('certificate_image')->store('academics', 'public');
                $academic->certificate_image = $imagePath;
            }

            $academic->save();

            return response()->json(['success' => true, 'message' => 'Academic record updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating academic record: ' . $e->getMessage()]);
        }
    }

    public function deleteAcademic($id)
    {
        try {
            $academic = Academic::findOrFail($id);
            
            // Delete image if exists
            if ($academic->certificate_image) {
                \Storage::disk('public')->delete($academic->certificate_image);
            }
            
            $academic->delete();

            return response()->json(['success' => true, 'message' => 'Academic record deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting academic record: ' . $e->getMessage()]);
        }
    }

    public function toggleAcademic($id)
    {
        try {
            $academic = Academic::findOrFail($id);
            $academic->is_active = !$academic->is_active;
            $academic->save();

            $status = $academic->is_active ? 'activated' : 'deactivated';
            return response()->json([
                'success' => true,
                'message' => 'Academic record ' . $status . ' successfully',
                'is_active' => $academic->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error toggling academic record: ' . $e->getMessage()]);
        }
    }

    public function getAcademic($id)
    {
        try {
            $academic = Academic::findOrFail($id);
            return response()->json($academic);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error fetching academic record: ' . $e->getMessage()]);
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

    // Data Management Methods
    public function dataManagement()
    {
        $backupFiles = $this->getBackupFiles();
        return view('admin.data-management', compact('backupFiles'));
    }

    public function reloadData(Request $request)
    {
        try {
            // Backup existing images before reloading
            $imageBackup = $this->backupImages();
            
            // Run the seeder to reload data
            Artisan::call('db:seed', ['--class' => 'AdminContentSeeder']);
            
            // Restore images after reloading
            $this->restoreImages($imageBackup);
            
            return response()->json([
                'success' => true, 
                'message' => 'Portfolio data reloaded successfully! Images preserved.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Error reloading data: ' . $e->getMessage()
            ]);
        }
    }

    public function clearData(Request $request)
    {
        try {
            // Backup existing images before clearing
            $imageBackup = $this->backupImages();
            
            DB::transaction(function () {
                HomeContent::truncate();
                SocialMediaLink::truncate();
                Skill::truncate();
                Footer::truncate();
                FooterSocialLink::truncate();
                Achievement::truncate();
                Academic::truncate();
                AboutContent::truncate();
                ProfileImageSetting::truncate();
            });

            // Restore images after clearing
            $this->restoreImages($imageBackup);

            return response()->json([
                'success' => true, 
                'message' => 'All portfolio data cleared successfully! Images preserved.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Error clearing data: ' . $e->getMessage()
            ]);
        }
    }

    public function createBackup(Request $request)
    {
        try {
            $timestamp = now()->format('Y-m-d_H-i-s');
            $backupPath = "backups/portfolio_backup_{$timestamp}.json";
            
            // Create backup directory if it doesn't exist
            if (!Storage::exists('backups')) {
                Storage::makeDirectory('backups');
            }

            // Export data to JSON format
            $backupData = [
                'home_contents' => HomeContent::all()->toArray(),
                'social_media_links' => SocialMediaLink::all()->toArray(),
                'skills' => Skill::all()->toArray(),
                'footer' => Footer::all()->toArray(),
                'footer_social_links' => FooterSocialLink::all()->toArray(),
                'achievements' => Achievement::all()->toArray(),
                'academics' => Academic::all()->toArray(),
                'about_contents' => AboutContent::all()->toArray(),
                'profile_image_settings' => ProfileImageSetting::all()->toArray(),
                'created_at' => now()->toISOString()
            ];

            Storage::put($backupPath, json_encode($backupData, JSON_PRETTY_PRINT));
            
            return response()->json([
                'success' => true, 
                'message' => 'Backup created successfully!',
                'backup_file' => basename($backupPath)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Error creating backup: ' . $e->getMessage()
            ]);
        }
    }

    public function restoreData(Request $request)
    {
        try {
            $backupFile = $request->input('backup_file');
            
            if (!$backupFile) {
                return response()->json([
                    'success' => false, 
                    'message' => 'No backup file specified'
                ]);
            }

            $backupPath = "backups/{$backupFile}";
            
            if (!Storage::exists($backupPath)) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Backup file not found'
                ]);
            }

            $backupData = json_decode(Storage::get($backupPath), true);
            
            if (!$backupData) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Invalid backup file format'
                ]);
            }

            // Clear existing data
            DB::transaction(function () {
                HomeContent::truncate();
                SocialMediaLink::truncate();
                Skill::truncate();
                Footer::truncate();
                FooterSocialLink::truncate();
                Achievement::truncate();
                Academic::truncate();
                AboutContent::truncate();
                ProfileImageSetting::truncate();
            });

            // Restore data
            foreach ($backupData['home_contents'] as $data) {
                unset($data['id']);
                HomeContent::create($data);
            }

            foreach ($backupData['social_media_links'] as $data) {
                unset($data['id']);
                SocialMediaLink::create($data);
            }

            foreach ($backupData['skills'] as $data) {
                unset($data['id']);
                Skill::create($data);
            }

            foreach ($backupData['footer'] as $data) {
                unset($data['id']);
                Footer::create($data);
            }

            foreach ($backupData['footer_social_links'] as $data) {
                unset($data['id']);
                FooterSocialLink::create($data);
            }

            foreach ($backupData['achievements'] as $data) {
                unset($data['id']);
                Achievement::create($data);
            }

            foreach ($backupData['academics'] as $data) {
                unset($data['id']);
                Academic::create($data);
            }

            foreach ($backupData['about_contents'] as $data) {
                unset($data['id']);
                AboutContent::create($data);
            }

            foreach ($backupData['profile_image_settings'] as $data) {
                unset($data['id']);
                ProfileImageSetting::create($data);
            }

            return response()->json([
                'success' => true, 
                'message' => 'Data restored successfully!',
                'backup_date' => $backupData['created_at']
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Error restoring data: ' . $e->getMessage()
            ]);
        }
    }

    public function listBackups()
    {
        try {
            $backupFiles = $this->getBackupFiles();
            return response()->json([
                'success' => true, 
                'backups' => $backupFiles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Error listing backups: ' . $e->getMessage()
            ]);
        }
    }

    private function getBackupFiles()
    {
        $backupFiles = [];
        
        if (Storage::exists('backups')) {
            $files = Storage::files('backups');
            
            foreach ($files as $file) {
                if (str_ends_with($file, '.json')) {
                    $backupFiles[] = [
                        'filename' => basename($file),
                        'path' => $file,
                        'size' => Storage::size($file),
                        'created_at' => Storage::lastModified($file)
                    ];
                }
            }
            
            // Sort by creation time (newest first)
            usort($backupFiles, function($a, $b) {
                return $b['created_at'] - $a['created_at'];
            });
        }
        
        return $backupFiles;
    }

    /**
     * Backup all images before data operations
     */
    private function backupImages()
    {
        $imageBackup = [];
        
        try {
            // Backup profile images
            $profileSettings = ProfileImageSetting::all();
            foreach ($profileSettings as $setting) {
                if ($setting->profile_image && Storage::disk('public')->exists($setting->profile_image)) {
                    $imageBackup['profile'][$setting->id] = [
                        'path' => $setting->profile_image,
                        'content' => Storage::disk('public')->get($setting->profile_image)
                    ];
                }
            }

            // Backup achievement images
            $achievements = Achievement::all();
            foreach ($achievements as $achievement) {
                if ($achievement->certificate_image && Storage::disk('public')->exists($achievement->certificate_image)) {
                    $imageBackup['achievements'][$achievement->id] = [
                        'path' => $achievement->certificate_image,
                        'content' => Storage::disk('public')->get($achievement->certificate_image)
                    ];
                }
            }

            // Backup academic images
            $academics = Academic::all();
            foreach ($academics as $academic) {
                if ($academic->certificate_image && Storage::disk('public')->exists($academic->certificate_image)) {
                    $imageBackup['academics'][$academic->id] = [
                        'path' => $academic->certificate_image,
                        'content' => Storage::disk('public')->get($academic->certificate_image)
                    ];
                }
            }

            // Backup about content images
            $aboutContents = AboutContent::all();
            foreach ($aboutContents as $content) {
                if ($content->image && Storage::disk('public')->exists($content->image)) {
                    $imageBackup['about'][$content->id] = [
                        'path' => $content->image,
                        'content' => Storage::disk('public')->get($content->image)
                    ];
                }
            }

            // Backup skill images
            $skills = Skill::all();
            foreach ($skills as $skill) {
                if ($skill->image && Storage::disk('public')->exists($skill->image)) {
                    $imageBackup['skills'][$skill->id] = [
                        'path' => $skill->image,
                        'content' => Storage::disk('public')->get($skill->image)
                    ];
                }
            }

        } catch (\Exception $e) {
            \Log::error('Error backing up images: ' . $e->getMessage());
        }

        return $imageBackup;
    }

    /**
     * Restore images after data operations
     */
    private function restoreImages($imageBackup)
    {
        try {
            // Restore profile images
            if (isset($imageBackup['profile'])) {
                foreach ($imageBackup['profile'] as $id => $imageData) {
                    if (Storage::disk('public')->exists($imageData['path'])) {
                        continue; // Image already exists
                    }
                    Storage::disk('public')->put($imageData['path'], $imageData['content']);
                }
            }

            // Restore achievement images
            if (isset($imageBackup['achievements'])) {
                foreach ($imageBackup['achievements'] as $id => $imageData) {
                    if (Storage::disk('public')->exists($imageData['path'])) {
                        continue; // Image already exists
                    }
                    Storage::disk('public')->put($imageData['path'], $imageData['content']);
                }
            }

            // Restore academic images
            if (isset($imageBackup['academics'])) {
                foreach ($imageBackup['academics'] as $id => $imageData) {
                    if (Storage::disk('public')->exists($imageData['path'])) {
                        continue; // Image already exists
                    }
                    Storage::disk('public')->put($imageData['path'], $imageData['content']);
                }
            }

            // Restore about content images
            if (isset($imageBackup['about'])) {
                foreach ($imageBackup['about'] as $id => $imageData) {
                    if (Storage::disk('public')->exists($imageData['path'])) {
                        continue; // Image already exists
                    }
                    Storage::disk('public')->put($imageData['path'], $imageData['content']);
                }
            }

            // Restore skill images
            if (isset($imageBackup['skills'])) {
                foreach ($imageBackup['skills'] as $id => $imageData) {
                    if (Storage::disk('public')->exists($imageData['path'])) {
                        continue; // Image already exists
                    }
                    Storage::disk('public')->put($imageData['path'], $imageData['content']);
                }
            }

        } catch (\Exception $e) {
            \Log::error('Error restoring images: ' . $e->getMessage());
        }
    }

    /**
     * AI Image Management for Skills Page
     */
    public function updateAiImage(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|file|mimes:jpeg,png,jpg,gif|max:5120',
                'alt_text' => 'nullable|string|max:255',
            ]);

            // Deactivate current active image
            AiImage::where('page_type', 'skills')
                   ->where('is_active', true)
                   ->update(['is_active' => false]);

            // Handle image upload
            $imagePath = $request->file('image')->store('ai-images', 'public');

            // Create new active image
            $aiImage = new AiImage();
            $aiImage->image_path = $imagePath;
            $aiImage->alt_text = $request->alt_text ?? 'AI Generated Image';
            $aiImage->page_type = 'skills';
            $aiImage->is_active = true;
            $aiImage->save();

            return response()->json([
                'success' => true, 
                'message' => 'AI image updated successfully',
                'image_url' => asset('storage/' . $imagePath)
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating AI image: ' . $e->getMessage()]);
        }
    }

    /**
     * Gallery images CRUD
     */
    public function addGalleryImage(Request $request)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpeg,png,jpg,gif|max:5120',
            'alt_text' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:1',
        ]);

        $imagePath = $request->file('image')->store('gallery', 'public');

        $gallery = new GalleryImage();
        $gallery->image_path = $imagePath;
        $gallery->alt_text = $request->alt_text;
        $gallery->order = $request->order ?? (GalleryImage::max('order') + 1);
        $gallery->is_active = true;
        $gallery->save();

        return response()->json(['success' => true, 'message' => 'Image added', 'id' => $gallery->id]);
    }

    public function updateGalleryImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:5120',
            'alt_text' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        $gallery = GalleryImage::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($gallery->image_path) {
                \Storage::disk('public')->delete($gallery->image_path);
            }
            $gallery->image_path = $request->file('image')->store('gallery', 'public');
        }

        if ($request->filled('alt_text')) $gallery->alt_text = $request->alt_text;
        if ($request->filled('order')) $gallery->order = (int)$request->order;
        if ($request->has('is_active')) $gallery->is_active = (bool)$request->is_active;

        $gallery->save();

        return response()->json(['success' => true, 'message' => 'Image updated']);
    }

    public function deleteGalleryImage($id)
    {
        $gallery = GalleryImage::findOrFail($id);
        if ($gallery->image_path) {
            \Storage::disk('public')->delete($gallery->image_path);
        }
        $gallery->delete();
        return response()->json(['success' => true, 'message' => 'Image deleted']);
    }

    public function getAiImage()
    {
        try {
            $aiImage = AiImage::getActiveImageForPage('skills');
            if ($aiImage) {
                return response()->json([
                    'success' => true,
                    'image_url' => asset('storage/' . $aiImage->image_path),
                    'alt_text' => $aiImage->alt_text
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No AI image found'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error fetching AI image: ' . $e->getMessage()]);
        }
    }

    // Project Management Methods
    public function addProject(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image_url' => 'nullable|url|max:500',
                'project_url' => 'nullable|url|max:500',
                'github_url' => 'nullable|url|max:500',
                'technologies' => 'nullable|string|max:1000',
                'order' => 'required|integer|min:1',
            ]);

            $project = new Project();
            $project->title = $request->title;
            $project->description = $request->description;
            $project->image_url = $request->image_url;
            $project->project_url = $request->project_url;
            $project->github_url = $request->github_url;
            $project->order = $request->order;
            $project->is_active = true;

            // Handle technologies
            if ($request->technologies) {
                $technologies = array_map('trim', explode(',', $request->technologies));
                $project->technologies = $technologies;
            }

            $project->save();

            return response()->json(['success' => true, 'message' => 'Project added successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error adding project: ' . $e->getMessage()]);
        }
    }

    public function updateProject(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image_url' => 'nullable|url|max:500',
                'project_url' => 'nullable|url|max:500',
                'github_url' => 'nullable|url|max:500',
                'technologies' => 'nullable|string|max:1000',
                'order' => 'required|integer|min:1',
            ]);

            $project = Project::findOrFail($id);
            $project->title = $request->title;
            $project->description = $request->description;
            $project->image_url = $request->image_url;
            $project->project_url = $request->project_url;
            $project->github_url = $request->github_url;
            $project->order = $request->order;

            // Handle technologies
            if ($request->technologies) {
                $technologies = array_map('trim', explode(',', $request->technologies));
                $project->technologies = $technologies;
            }

            $project->save();

            return response()->json(['success' => true, 'message' => 'Project updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating project: ' . $e->getMessage()]);
        }
    }

    public function deleteProject($id)
    {
        try {
            $project = Project::findOrFail($id);
            $project->delete();

            return response()->json(['success' => true, 'message' => 'Project deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting project: ' . $e->getMessage()]);
        }
    }

    public function toggleProject($id)
    {
        try {
            $project = Project::findOrFail($id);
            $project->is_active = !$project->is_active;
            $project->save();

            $status = $project->is_active ? 'activated' : 'deactivated';
            return response()->json([
                'success' => true,
                'message' => 'Project ' . $status . ' successfully',
                'is_active' => $project->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error toggling project: ' . $e->getMessage()]);
        }
    }

    public function getProject($id)
    {
        try {
            $project = Project::findOrFail($id);
            return response()->json($project);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error fetching project: ' . $e->getMessage()]);
        }
    }

    // Work Management Methods
    public function addWork(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'company_name' => 'nullable|string|max:255',
                'position' => 'nullable|string|max:255',
                'image_url' => 'nullable|url|max:500',
                'work_url' => 'nullable|url|max:500',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'is_current' => 'boolean',
                'technologies' => 'nullable|string|max:1000',
                'order' => 'required|integer|min:1',
            ]);

            $work = new Work();
            $work->title = $request->title;
            $work->description = $request->description;
            $work->company_name = $request->company_name;
            $work->position = $request->position;
            $work->image_url = $request->image_url;
            $work->work_url = $request->work_url;
            $work->start_date = $request->start_date;
            $work->end_date = $request->end_date;
            $work->is_current = $request->has('is_current');
            $work->order = $request->order;
            $work->is_active = true;

            // Handle technologies
            if ($request->technologies) {
                $technologies = array_map('trim', explode(',', $request->technologies));
                $work->technologies = $technologies;
            }

            $work->save();

            return response()->json(['success' => true, 'message' => 'Work experience added successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error adding work experience: ' . $e->getMessage()]);
        }
    }

    public function updateWork(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'company_name' => 'nullable|string|max:255',
                'position' => 'nullable|string|max:255',
                'image_url' => 'nullable|url|max:500',
                'work_url' => 'nullable|url|max:500',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'is_current' => 'boolean',
                'technologies' => 'nullable|string|max:1000',
                'order' => 'required|integer|min:1',
            ]);

            $work = Work::findOrFail($id);
            $work->title = $request->title;
            $work->description = $request->description;
            $work->company_name = $request->company_name;
            $work->position = $request->position;
            $work->image_url = $request->image_url;
            $work->work_url = $request->work_url;
            $work->start_date = $request->start_date;
            $work->end_date = $request->end_date;
            $work->is_current = $request->has('is_current');
            $work->order = $request->order;

            // Handle technologies
            if ($request->technologies) {
                $technologies = array_map('trim', explode(',', $request->technologies));
                $work->technologies = $technologies;
            }

            $work->save();

            return response()->json(['success' => true, 'message' => 'Work experience updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating work experience: ' . $e->getMessage()]);
        }
    }

    public function deleteWork($id)
    {
        try {
            $work = Work::findOrFail($id);
            $work->delete();

            return response()->json(['success' => true, 'message' => 'Work experience deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting work experience: ' . $e->getMessage()]);
        }
    }

    public function toggleWork($id)
    {
        try {
            $work = Work::findOrFail($id);
            $work->is_active = !$work->is_active;
            $work->save();

            $status = $work->is_active ? 'activated' : 'deactivated';
            return response()->json([
                'success' => true,
                'message' => 'Work experience ' . $status . ' successfully',
                'is_active' => $work->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error toggling work experience: ' . $e->getMessage()]);
        }
    }

    public function getWork($id)
    {
        try {
            $work = Work::findOrFail($id);
            return response()->json($work);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error fetching work experience: ' . $e->getMessage()]);
        }
    }
}
