@extends('index')
@push('styles')
<title>skills - Protik Goswami</title>
@section('skills-section')
<!--===== SKILLS =====-->
<section class="skills section" id="skills">
    <h2 class="section-title">Skills</h2>

    <div class="skills__container bd-grid">          
        <div>
            <h2 class="skills__subtitle">Profesional Skills</h2>
            <p class="skills__text">Here are some of my core skills and proficiency levels.</p>
            @php
                try {
                    $skillModels = \App\Models\Skill::getAllOrderedActive();
                } catch (\Throwable $e) {
                    $skillModels = collect();
                }
            @endphp
            @if($skillModels->count() > 0)
                @foreach($skillModels as $skill)
                    <div class="skills__data">
                        <div class="skills__names">
                            @if($skill->image)
                                <img src="{{ asset('storage/' . $skill->image) }}" alt="{{ $skill->name }}" class="skills__icon" style="width: 24px; height: 24px; object-fit: cover; border-radius: 4px;">
                            @elseif(!empty($skill->icon_class))
                                <i class="{{ $skill->icon_class }} skills__icon"></i>
                            @endif
                            <span class="skills__name">{{ $skill->name }}</span>
                        </div>
                        <div class="skills__bar" style="width: {{ (int) $skill->proficiency_percent }}%">
                        </div>
                        <div>
                            <span class="skills__percentage">{{ (int) $skill->proficiency_percent }}%</span>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="skills__data">
                    <div class="skills__names">
                        <i class='fa-solid fa-circle-info skills__icon'></i>
                        <span class="skills__name">No skills added yet</span>
                    </div>
                    <div class="skills__bar" style="width: 0%"></div>
                    <div>
                        <span class="skills__percentage">0%</span>
                    </div>
                </div>
            @endif
        </div>
        
        <div>              
            <img id="ai-image" src="{{ asset('assets/img/IMG_20231214_030304.jpg') }}" alt="AI Generated Image" class="skills__img" style="opacity: 1; transition: opacity 0.3s ease; width: 100%; height: auto; object-fit: cover;">
            <div id="image-loading" style="display: none; text-align: center; padding: 20px; color: #666;">
                <i class="fas fa-spinner fa-spin"></i> Loading AI Image...
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const aiImage = document.getElementById('ai-image');
    const imageLoading = document.getElementById('image-loading');
    let lastUpdateTime = null;
    let refreshCount = 0;
    let isLoading = false;
    
    console.log('AI Image Auto-refresh script loaded');
    console.log('AI Image element:', aiImage);
    
    // Function to fetch and update AI image
    function updateAiImage() {
        refreshCount++;
        console.log(`Fetching AI image... (attempt ${refreshCount})`);
        
        fetch('/api/ai-image/skills')
            .then(response => {
                console.log('API Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('API Response data:', data);
                
                if (data.success && data.image_url) {
                    // Only update if the image has changed
                    if (lastUpdateTime !== data.updated_at) {
                        console.log('Updating image from:', aiImage.src, 'to:', data.image_url);
                        
                        // Preload the new image to prevent buffering
                        if (!isLoading) {
                            isLoading = true;
                            imageLoading.style.display = 'block';
                            
                            const newImg = new Image();
                            newImg.onload = function() {
                                // Image loaded successfully, now update the display
                                aiImage.src = data.image_url + '?t=' + new Date().getTime();
                                aiImage.alt = data.alt_text || 'AI Generated Image';
                                lastUpdateTime = data.updated_at;
                                console.log('AI image updated at:', new Date().toLocaleTimeString());
                                
                                // Hide loading indicator
                                imageLoading.style.display = 'none';
                                isLoading = false;
                            };
                            newImg.onerror = function() {
                                console.error('Failed to load new image:', data.image_url);
                                imageLoading.style.display = 'none';
                                isLoading = false;
                            };
                            newImg.src = data.image_url + '?t=' + new Date().getTime();
                        }
                        
                    } else {
                        console.log('Image unchanged, skipping update');
                    }
                } else if (data.image_url) {
                    // Fallback to default image if no AI image is set
                    console.log('Using fallback image:', data.image_url);
                    
                    // Preload fallback image
                    if (!isLoading) {
                        isLoading = true;
                        imageLoading.style.display = 'block';
                        
                        const fallbackImg = new Image();
                        fallbackImg.onload = function() {
                            aiImage.src = data.image_url + '?t=' + new Date().getTime();
                            imageLoading.style.display = 'none';
                            isLoading = false;
                        };
                        fallbackImg.onerror = function() {
                            console.error('Failed to load fallback image:', data.image_url);
                            imageLoading.style.display = 'none';
                            isLoading = false;
                        };
                        fallbackImg.src = data.image_url + '?t=' + new Date().getTime();
                    }
                } else {
                    console.log('No image URL in response');
                }
            })
            .catch(error => {
                console.error('Error fetching AI image:', error);
                console.log('This might be normal if no AI image is uploaded yet');
            });
    }
    
    // Load initial AI image
    console.log('Loading initial AI image...');
    updateAiImage();
    
    // Set up auto-refresh every 2 seconds
    console.log('Setting up auto-refresh every 2 seconds...');
    setInterval(updateAiImage, 2000);
    
    // Handle image loading states
    if (aiImage) {
        aiImage.addEventListener('load', function() {
            console.log('Image loaded successfully');
            // Ensure image is fully visible
            this.style.opacity = '1';
        });
        
        aiImage.addEventListener('error', function() {
            console.error('Image failed to load:', this.src);
            // Keep the current image if loading fails
            this.style.opacity = '1';
        });
        
        aiImage.addEventListener('loadstart', function() {
            console.log('Image loading started');
            // Don't change opacity during loading to prevent flicker
        });
        
        aiImage.addEventListener('loadend', function() {
            console.log('Image loading ended');
            // Ensure image is visible when loading completes
            this.style.opacity = '1';
        });
    } else {
        console.error('AI Image element not found!');
    }
});
</script>
@endsection