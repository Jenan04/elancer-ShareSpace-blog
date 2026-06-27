<x-layouts.app>
    <x-slot:title>Write a Story - ShareSpace</x-slot>

    <x-navbar />

    <main class="min-h-screen bg-surface pt-32 pb-24 px-6 md:px-12 max-w-4xl mx-auto font-sans relative z-10">
        <!-- Editor Header -->
        <div class="mb-10">
            <a href="{{ route('feed') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-primary hover:text-primary/80 transition-colors mb-4 group">
                <span class="material-symbols-outlined text-sm group-hover:-translate-x-0.5 transition-transform">arrow_back</span>
                Back to Feed
            </a>
            <h1 class="text-3xl md:text-4xl font-bold text-on-surface tracking-tight">
                Create a New Article
            </h1>
            <p class="text-on-surface-variant/80 text-sm mt-1">
                Share your ideas, document engineering knowledge, or publish daily essays.
            </p>
        </div>

        @if($errors->any())
            <div class="mb-8 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-sm">
                <div class="font-bold mb-1">Please fix the following validation errors:</div>
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Canvas -->
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8 bg-white p-8 md:p-10 rounded-3xl border border-outline-variant/20 shadow-sm">
            @csrf

            <!-- Cover Photo Upload -->
            <div>
                <label class="block text-sm font-bold text-on-surface mb-3">Cover Image</label>
                <div id="dropzone" class="border-2 border-dashed border-outline-variant/40 rounded-2xl p-6 text-center hover:border-primary/50 transition-all duration-300 bg-surface-container-low cursor-pointer relative group">
                    <input type="file" name="cover_image" id="cover-image-input" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" />
                    
                    <div id="upload-prompt" class="space-y-2 py-4">
                        <span class="material-symbols-outlined text-4xl text-on-surface-variant/40 group-hover:text-primary transition-colors duration-300">
                            cloud_upload
                        </span>
                        <div class="text-sm text-on-surface-variant/80">
                            <span class="font-semibold text-primary">Click to upload</span> or drag and drop
                        </div>
                        <p class="text-xs text-on-surface-variant/60">
                            WEBP, PNG, or JPEG (Max 2MB)
                        </p>
                    </div>

                    <!-- Image Preview -->
                    <div id="image-preview-container" class="hidden relative aspect-video w-full rounded-xl overflow-hidden mt-2 z-30">
                        <img id="image-preview" src="#" alt="Upload Preview" class="w-full h-full object-cover" />
                        <button type="button" id="remove-image-btn" class="absolute top-3 right-3 p-2 bg-black/60 hover:bg-black/80 text-white rounded-full transition-colors z-40">
                            <span class="material-symbols-outlined text-sm block">close</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Title Input -->
            <div>
                <label for="title" class="block text-sm font-bold text-on-surface mb-2">Title</label>
                <input type="text" name="title" id="title" required placeholder="Give your story a title..." value="{{ old('title') }}"
                       class="w-full px-5 py-4 bg-surface-container-lowest border border-outline-variant/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none rounded-2xl text-on-surface font-semibold text-lg placeholder-on-surface-variant/40 transition-all" />
            </div>

            <!-- Category Selector -->
            <div>
                <label for="category_id" class="block text-sm font-bold text-on-surface mb-2">Category</label>
                <select name="category_id" id="category_id" required
                        class="w-full px-5 py-4 bg-surface-container-lowest border border-outline-variant/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none rounded-2xl text-on-surface transition-all appearance-none">
                    <option value="" disabled selected>Select a category...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Content Area -->
            <div>
                <label for="content" class="block text-sm font-bold text-on-surface mb-2">Content</label>
                <textarea name="content" id="content" required rows="12" placeholder="Write your thoughts, ideas, or guides here..."
                          class="w-full px-5 py-4 bg-surface-container-lowest border border-outline-variant/30 focus:border-primary focus:ring-1 focus:ring-primary outline-none rounded-2xl text-on-surface placeholder-on-surface-variant/40 transition-all font-sans leading-relaxed">{{ old('content') }}</textarea>
            </div>

            <!-- Debounced AI Assisted Tag Suggestion Area -->
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-primary text-lg">auto_awesome</span>
                    AI Assisted Tags
                </label>
                <div class="p-4 bg-surface-container-low rounded-2xl border border-outline-variant/10">
                    <div id="ai-suggestions" class="flex flex-wrap gap-2">
                        <span class="text-xs text-on-surface-variant/60">
                            Start writing content above, and AI suggestions will automatically populate here...
                        </span>
                    </div>
                </div>
            </div>

            <!-- Chosen Tags list -->
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Selected Tags</label>
                <div id="selected-tags-container" class="flex flex-wrap gap-2 p-4 min-h-[60px] bg-surface-container-lowest border border-outline-variant/20 rounded-2xl">
                    <span id="no-tags-prompt" class="text-xs text-on-surface-variant/40 self-center">
                        No tags selected. Click AI suggested tags or type manual tags below.
                    </span>
                </div>
                <!-- Hidden inputs wrapper for tags -->
                <div id="hidden-tags-inputs"></div>
            </div>

            <!-- Manual Tag Input -->
            <div>
                <label for="manual-tag" class="block text-sm font-bold text-on-surface mb-2">Add Tag Manually</label>
                <div class="flex gap-3">
                    <input type="text" id="manual-tag" placeholder="Type tag and click Add..." 
                           class="flex-grow px-5 py-3.5 bg-surface-container-lowest border border-outline-variant/30 focus:border-primary outline-none rounded-xl text-on-surface text-sm transition-all" />
                    <button type="button" id="add-manual-tag-btn" class="px-5 py-3.5 bg-secondary text-white font-semibold rounded-xl text-sm hover:bg-secondary/95 transition-all">
                        Add Tag
                    </button>
                </div>
            </div>

            <!-- Hidden status input -->
            <input type="hidden" name="status" value="published" />

            <!-- Action buttons -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-outline-variant/10">
                <a href="{{ route('feed') }}" class="px-6 py-3.5 bg-surface-container text-on-surface-variant hover:text-on-surface font-semibold rounded-2xl text-sm transition-all">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3.5 bg-primary text-white font-semibold rounded-2xl text-sm shadow-md hover:bg-primary/95 transition-all scale-100 hover:scale-[1.01] active:scale-95">
                    Publish Article
                </button>
            </div>
        </form>
    </main>

    <!-- UI Interaction Scripts -->
    <script>
        // --- Image Preview Handler ---
        const imageInput = document.getElementById('cover-image-input');
        const uploadPrompt = document.getElementById('upload-prompt');
        const previewContainer = document.getElementById('image-preview-container');
        const previewImage = document.getElementById('image-preview');
        const removeImageBtn = document.getElementById('remove-image-btn');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.addEventListener('load', function() {
                    previewImage.setAttribute('src', this.result);
                    uploadPrompt.classList.add('hidden');
                    previewContainer.classList.remove('hidden');
                });
                reader.readAsDataURL(file);
            }
        });

        removeImageBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            imageInput.value = '';
            previewImage.setAttribute('src', '#');
            previewContainer.classList.add('hidden');
            uploadPrompt.classList.remove('hidden');
        });

        // --- Tag Management ---
        const activeTags = new Set();
        const selectedContainer = document.getElementById('selected-tags-container');
        const noTagsPrompt = document.getElementById('no-tags-prompt');
        const hiddenInputsContainer = document.getElementById('hidden-tags-inputs');

        function renderTags() {
            // Remove existing tag pills except prompt
            const pills = selectedContainer.querySelectorAll('.tag-pill');
            pills.forEach(p => p.remove());

            // Clear hidden inputs
            hiddenInputsContainer.innerHTML = '';

            if (activeTags.size === 0) {
                noTagsPrompt.classList.remove('hidden');
                return;
            }

            noTagsPrompt.classList.add('hidden');

            activeTags.forEach(tag => {
                // Add tag pill UI
                const pill = document.createElement('div');
                pill.className = 'tag-pill flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 bg-primary/10 text-primary border border-primary/20 rounded-full animate-fade-in';
                pill.innerHTML = `
                    <span>#${tag}</span>
                    <button type="button" class="flex items-center justify-center w-4 h-4 rounded-full hover:bg-primary/20 text-primary/70 transition-colors" onclick="removeTag('${tag}')">
                        <span class="material-symbols-outlined text-[10px] font-bold">close</span>
                    </button>
                `;
                selectedContainer.appendChild(pill);

                // Add hidden input for submit
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'tags[]';
                hiddenInput.value = tag;
                hiddenInputsContainer.appendChild(hiddenInput);
            });
        }

        window.addTag = function(tag) {
            const formatted = tag.trim().toLowerCase().replace(/[^a-z0-9\-\s]/g, '').replace(/\s+/g, '-');
            if (formatted && !activeTags.has(formatted)) {
                activeTags.add(formatted);
                renderTags();
            }
        };

        window.removeTag = function(tag) {
            if (activeTags.has(tag)) {
                activeTags.delete(tag);
                renderTags();
            }
        };

        // Manual tag addition
        const manualInput = document.getElementById('manual-tag');
        const addManualBtn = document.getElementById('add-manual-tag-btn');

        function handleManualAdd() {
            const val = manualInput.value.trim();
            if (val) {
                addTag(val);
                manualInput.value = '';
            }
        }

        addManualBtn.addEventListener('click', handleManualAdd);
        manualInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                handleManualAdd();
            }
        });

        // --- AI Tag Debounce suggestor ---
        let debounceTimer;
        const contentArea = document.getElementById('content');
        const suggestionContainer = document.getElementById('ai-suggestions');

        contentArea.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                const text = contentArea.value.trim();
                if (text.length < 10) return;

                suggestionContainer.innerHTML = `
                    <div class="flex items-center gap-1.5 text-xs text-on-surface-variant/60">
                        <span class="animate-spin inline-block w-3.5 h-3.5 border-2 border-primary border-t-transparent rounded-full"></span>
                        AI identifying technical tags...
                    </div>
                `;

                fetch("{{ route('api.suggest-tags') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ content: text })
                })
                .then(res => res.json())
                .then(tags => {
                    suggestionContainer.innerHTML = '';
                    if (tags.length === 0) {
                        suggestionContainer.innerHTML = '<span class="text-xs text-on-surface-variant/50">No tags suggested yet. Try writing more content.</span>';
                        return;
                    }
                    
                    tags.forEach(tag => {
                        const pill = document.createElement('button');
                        pill.type = 'button';
                        pill.className = 'text-xs px-3 py-1.5 rounded-full border border-primary/20 hover:border-primary text-on-surface bg-white shadow-sm hover:shadow transition-all font-semibold flex items-center gap-1 hover:bg-primary/5 active:scale-95';
                        pill.innerHTML = `<span>+ ${tag}</span>`;
                        pill.onclick = () => addTag(tag);
                        suggestionContainer.appendChild(pill);
                    });
                })
                .catch(err => {
                    suggestionContainer.innerHTML = '<span class="text-xs text-red-500/70">Failed to suggest tags.</span>';
                });
            }, 2000); // 2-second debounce
        });
    </script>
</x-layouts.app>
