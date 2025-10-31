@extends('admin.layout')

@section('content')
<div>
    <div class="flex justify-between items-center mb-6">
        <h1 style="font-size: 24px; font-weight: bold; color: #374151; margin: 0;">Edit Blog Post</h1>
        <a href="{{ route('admin.index') }}" class="back-to-posts-btn px-4 py-2">
            Back to Posts
        </a>
    </div>

    <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <form method="POST" action="{{ route('admin.update', $blog->id) }}" enctype="multipart/form-data" style="padding: 30px;">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div style="margin-bottom: 24px;">
                <label for="title" style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                    Title *
                </label>
                <input type="text"
                       id="title"
                       name="title"
                       value="{{ old('title', $blog->title) }}"
                       style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; background: white; color: #374151; box-sizing: border-box;"
                       placeholder="Enter blog post title"
                       required>
                @error('title')
                    <p style="margin-top: 4px; font-size: 12px; color: #dc2626;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category and Status Row -->
            <div style="display: flex; gap: 16px; margin-bottom: 24px;">
                <!-- Category -->
                <div style="flex: 1;">
                    <label for="category" style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                        Category
                    </label>
                    <div class="custom-dropdown">
                        <button type="button" class="custom-dropdown-toggle" id="categoryDropdownToggle" aria-expanded="false">
                            <span class="dropdown-text">
                                @php
                                    $categoryMap = [
                                        '' => 'Select a category (optional)',
                                        'carbon-accounting' => 'Carbon Accounting',
                                        'hospitality' => 'Hospitality & Tourism',
                                        'net-zero' => 'Net Zero & Strategy',
                                        'regulations' => 'Regulations & Disclosure'
                                    ];
                                    $oldCategory = old('category', $blog->category);
                                @endphp
                                {{ $categoryMap[$oldCategory ?? ''] ?? 'Select a category (optional)' }}
                            </span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <input type="hidden" id="category" name="category" value="{{ old('category', $blog->category) ?: '' }}">
                        <ul class="dropdown-menu" id="categoryDropdownMenu">
                            <li><a class="dropdown-item" href="#" data-value="">Select a category (optional)</a></li>
                            <li><a class="dropdown-item" href="#" data-value="carbon-accounting">Carbon Accounting</a></li>
                            <li><a class="dropdown-item" href="#" data-value="hospitality">Hospitality & Tourism</a></li>
                            <li><a class="dropdown-item" href="#" data-value="net-zero">Net Zero & Strategy</a></li>
                            <li><a class="dropdown-item" href="#" data-value="regulations">Regulations & Disclosure</a></li>
                        </ul>
                    </div>
                    @error('category')
                        <p style="margin-top: 4px; font-size: 12px; color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Blog Status -->
                <div style="flex: 1;">
                    <label for="blog_status" style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                        Blog Status *
                    </label>
                    <div class="custom-dropdown">
                        <button type="button" class="custom-dropdown-toggle" id="blogStatusDropdownToggle" aria-expanded="false">
                            <span class="dropdown-text">
                                @php
                                    $statusMap = [
                                        'draft' => 'Draft',
                                        'published' => 'Published',
                                        'deleted' => 'Deleted'
                                    ];
                                    $oldStatus = old('blog_status', $blog->blog_status ?? 'draft');
                                @endphp
                                {{ $statusMap[$oldStatus] ?? 'Draft' }}
                            </span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <input type="hidden" id="blog_status" name="blog_status" value="{{ old('blog_status', $blog->blog_status ?? 'draft') }}">
                        <ul class="dropdown-menu" id="blogStatusDropdownMenu">
                            <li><a class="dropdown-item" href="#" data-value="draft">Draft</a></li>
                            <li><a class="dropdown-item" href="#" data-value="published">Published</a></li>
                            <li><a class="dropdown-item" href="#" data-value="deleted">Deleted</a></li>
                        </ul>
                    </div>
                    @error('blog_status')
                        <p style="margin-top: 4px; font-size: 12px; color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Meta Title -->
            <div style="margin-bottom: 24px;">
                <label for="meta_title" style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                    Meta Title
                </label>
                <input type="text"
                       id="meta_title"
                       name="meta_title"
                       value="{{ old('meta_title', $blog->meta_title ?? '') }}"
                       style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; background: white; color: #374151; box-sizing: border-box;"
                       placeholder="Enter meta title for SEO">
                @error('meta_title')
                    <p style="margin-top: 4px; font-size: 12px; color: #dc2626;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Meta Description -->
            <div style="margin-bottom: 24px;">
                <label for="meta_description" style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                    Meta Description
                </label>
                <textarea id="meta_description"
                          name="meta_description"
                          rows="3"
                          style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; background: white; color: #374151; resize: vertical; box-sizing: border-box;"
                          placeholder="Enter meta description for SEO">{{ old('meta_description', $blog->meta_description ?? '') }}</textarea>
                @error('meta_description')
                    <p style="margin-top: 4px; font-size: 12px; color: #dc2626;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Meta Keywords -->
            <div style="margin-bottom: 24px;">
                <label for="meta_keywords_input" style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                    Meta Keywords
                </label>

                <!-- Tags Container -->
                <div id="keywords-tags-container" style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 8px; min-height: 32px; padding: 8px; border: 1px solid #d1d5db; border-radius: 6px; background: white;">
                    <!-- Tags will be displayed here -->
                </div>

                <!-- Hidden input to store keywords -->
                <input type="hidden" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $blog->meta_keywords ?? '') }}">

                <!-- Input for adding new keywords -->
                <input type="text"
                       id="meta_keywords_input"
                       style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; background: white; color: #374151; box-sizing: border-box;"
                       placeholder="Type and press Enter to add keyword">
                <!-- Counter -->
                <p id="keywords-counter" style="margin-top: 4px; font-size: 12px; color: #6b7280; text-align: right;">15 keywords remaining</p>
                @error('meta_keywords')
                    <p style="margin-top: 4px; font-size: 12px; color: #dc2626;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div style="margin-bottom: 24px;">
                <label for="content" style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                    Content *
                </label>

                <!-- Rich Text Editor -->
                <div class="rich-text-editor">
                    <div class="editor-toolbar">
                        <!-- Paragraph/Block Format -->
                        <select id="blockFormat" class="editor-dropdown" onchange="formatText('formatBlock', this.value)">
                            <option value="p">Paragraph</option>
                            <option value="h1">Heading 1</option>
                            <option value="h2">Heading 2</option>
                            <option value="h3">Heading 3</option>
                            <option value="h4">Heading 4</option>
                            <option value="h5">Heading 5</option>
                            <option value="h6">Heading 6</option>
                        </select>

                        <!-- Font Family -->
                        <select id="fontFamily" class="editor-dropdown" onchange="formatText('fontName', this.value)">
                            <option value="System Font">System Font</option>
                            <option value="Arial, sans-serif">Arial</option>
                            <option value="Helvetica, sans-serif">Helvetica</option>
                            <option value="Georgia, serif">Georgia</option>
                            <option value="Times New Roman, serif">Times New Roman</option>
                            <option value="Courier New, monospace">Courier New</option>
                            <option value="Verdana, sans-serif">Verdana</option>
                        </select>

                        <!-- Font Size -->
                        <select id="fontSize" class="editor-dropdown" onchange="formatText('fontSize', this.value)">
                            <option value="1">8pt</option>
                            <option value="2">10pt</option>
                            <option value="3" selected>12pt</option>
                            <option value="4">14pt</option>
                            <option value="5">18pt</option>
                            <option value="6">24pt</option>
                            <option value="7">36pt</option>
                        </select>

                        <!-- Line Height -->
                        <select id="lineHeight" class="editor-dropdown" onchange="applyLineHeight(this.value)">
                            <option value="1">1</option>
                            <option value="1.25">1.25</option>
                            <option value="1.5" selected>1.5</option>
                            <option value="1.75">1.75</option>
                            <option value="2">2</option>
                        </select>

                        <!-- Text Formatting -->
                        <button type="button" class="editor-btn" onclick="formatText('bold')" title="Bold">
                            <i class="fas fa-bold"></i>
                        </button>
                        <button type="button" class="editor-btn" onclick="formatText('italic')" title="Italic">
                            <i class="fas fa-italic"></i>
                        </button>
                        <button type="button" class="editor-btn" onclick="formatText('underline')" title="Underline">
                            <i class="fas fa-underline"></i>
                        </button>

                        <!-- Text Color -->
                        <input type="color" id="textColor" class="color-picker" value="#000000" onchange="applyTextColor(this.value)" title="Text Color">

                        <!-- Background Color -->
                        <input type="color" id="bgColor" class="color-picker" value="#ffffff" onchange="applyBackgroundColor(this.value)" title="Background Color">

                        <!-- Alignment -->
                        <button type="button" class="editor-btn" onclick="formatText('justifyLeft')" title="Align Left">
                            <i class="fas fa-align-left"></i>
                        </button>
                        <button type="button" class="editor-btn" onclick="formatText('justifyCenter')" title="Align Center">
                            <i class="fas fa-align-center"></i>
                        </button>
                        <button type="button" class="editor-btn" onclick="formatText('justifyRight')" title="Align Right">
                            <i class="fas fa-align-right"></i>
                        </button>

                        <!-- Numbered List -->
                        <button type="button" class="editor-btn" onclick="formatText('insertOrderedList')" title="Numbered List">
                            <i class="fas fa-list-ol"></i>
                        </button>

                        <!-- Bullet List -->
                        <button type="button" class="editor-btn" onclick="formatText('insertUnorderedList')" title="Bullet List">
                            <i class="fas fa-list-ul"></i>
                        </button>

                        <!-- Decrease Indent -->
                        <button type="button" class="editor-btn" onclick="formatText('outdent')" title="Decrease Indent">
                            <i class="fas fa-outdent"></i>
                        </button>

                        <!-- Increase Indent -->
                        <button type="button" class="editor-btn" onclick="formatText('indent')" title="Increase Indent">
                            <i class="fas fa-indent"></i>
                        </button>
                    </div>

                    <div id="content"
                         class="editor-content"
                         contenteditable="true"
                         data-placeholder="Write your blog post content here..."
                         oninput="updateContent()">{{ old('content', $blog->content) }}</div>

                    <!-- Hidden textarea for form submission -->
                    <textarea name="content" id="content-hidden" style="display: none;" required>{{ old('content', $blog->content) }}</textarea>
                </div>

                @error('content')
                    <p style="margin-top: 4px; font-size: 12px; color: #dc2626;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Image -->
            @if($blog->image)
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                        Current Featured Image
                    </label>
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" style="height: 80px; width: 80px; object-fit: cover; border-radius: 8px;">
                        <div>
                            <p style="font-size: 14px; color: #6b7280; margin: 0;">Current image</p>
                            <p style="font-size: 12px; color: #6b7280; margin: 0;">Upload a new image to replace this one</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Image Upload -->
            <div style="margin-bottom: 24px;">
                <label for="image" style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                    {{ $blog->image ? 'Replace Featured Image' : 'Featured Image' }}
                </label>
                <input type="file"
                       id="image"
                       name="image"
                       accept="image/*"
                       onchange="previewImage(this)"
                       style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; background: white; color: #374151; box-sizing: border-box;">
                <p style="margin-top: 4px; font-size: 12px; color: #6b7280;">Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB.</p>

                <!-- Image Preview -->
                <div id="imagePreview" style="margin-top: 12px; display: none;">
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                        New Image Preview
                    </label>
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <img id="previewImg" src="" alt="Preview" style="height: 80px; width: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #d1d5db;">
                        <div>
                            <p id="fileName" style="font-size: 14px; color: #374151; margin: 0; font-weight: 500;"></p>
                            <p style="font-size: 12px; color: #6b7280; margin: 0;">This will replace the current image</p>
                        </div>
                    </div>
                </div>

                @error('image')
                    <p style="margin-top: 4px; font-size: 12px; color: #dc2626;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Published Status -->
            {{-- <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox"
                           name="is_published"
                           value="1"
                           {{ old('is_published', $blog->is_published) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-[#f53003] dark:text-[#FF4433] shadow-sm focus:border-[#f53003] dark:focus:border-[#FF4433] focus:ring focus:ring-[#f53003] dark:focus:ring-[#FF4433] focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-[#1b1b18] dark:text-[#EDEDEC]">Published</span>
                </label>
            </div> --}}

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.index') }}"
                   class="back-to-posts-btn px-6 py-2 rounded-sm text-sm font-medium transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="bg-[#1b1b18] hover:bg-black text-white px-6 py-2 rounded-sm text-sm font-medium transition-colors">
                    Update Post
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Image preview functionality
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const fileName = document.getElementById('fileName');

    if (input.files && input.files[0]) {
        const file = input.files[0];

        // Show preview container
        preview.style.display = 'block';

        // Display file name
        fileName.textContent = file.name;

        // Create file reader to preview image
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        // Hide preview if no file selected
        preview.style.display = 'none';
    }
}

// Rich text editor functionality
function formatText(command, value = null) {
    const editor = document.getElementById('content');
    editor.focus();

    if (command === 'fontSize' && value) {
        document.execCommand('fontSize', false, value);
        const fontElements = editor.querySelectorAll('font');
        const sizeMap = {
            '1': '8pt',
            '2': '10pt',
            '3': '12pt',
            '4': '14pt',
            '5': '18pt',
            '6': '24pt',
            '7': '36pt'
        };
        fontElements.forEach(el => {
            if (el.getAttribute('size')) {
                el.style.fontSize = sizeMap[el.getAttribute('size')] || '12pt';
                el.removeAttribute('size');
            }
        });
    } else if (command === 'fontName' && value) {
        if (value === 'System Font') {
            document.execCommand('removeFormat', false);
        } else {
            document.execCommand('fontName', false, value);
        }
    } else if (command === 'formatBlock' && value) {
        document.execCommand('formatBlock', false, value);
    } else if (command === 'foreColor' && value) {
        // For text color - direct approach
        document.execCommand('styleWithCSS', false, true);
        document.execCommand('foreColor', false, value);
    } else if (command === 'backColor' && value) {
        // For background color - direct approach
        document.execCommand('styleWithCSS', false, true);
        document.execCommand('backColor', false, value);
    } else if (command === 'insertUnorderedList') {
        document.execCommand('insertUnorderedList', false, null);
    } else if (command === 'insertOrderedList') {
        document.execCommand('insertOrderedList', false, null);
    } else if (command === 'indent') {
        document.execCommand('indent', false, null);
    } else if (command === 'outdent') {
        document.execCommand('outdent', false, null);
    } else {
        document.execCommand(command, false, value);
    }

    updateContent();
}

function applyLineHeight(value) {
    const editor = document.getElementById('content');
    editor.focus();
    document.execCommand('styleWithCSS', false, true);
    document.execCommand('styleWithCSS', false, true);
    const selectedText = window.getSelection().toString();
    if (selectedText) {
        const selection = window.getSelection();
        if (selection.rangeCount > 0) {
            const range = selection.getRangeAt(0);
            const span = document.createElement('span');
            span.style.lineHeight = value;
            try {
                range.surroundContents(span);
            } catch (e) {
                const contents = range.extractContents();
                span.appendChild(contents);
                range.insertNode(span);
            }
        }
    } else {
        document.execCommand('formatBlock', false, 'p');
        const paragraphs = editor.querySelectorAll('p');
        if (paragraphs.length > 0) {
            paragraphs[paragraphs.length - 1].style.lineHeight = value;
        }
    }
    updateContent();
}

function updateContent() {
    const editor = document.getElementById('content');
    const hiddenTextarea = document.getElementById('content-hidden');

    // Update hidden textarea with HTML content
    hiddenTextarea.value = editor.innerHTML;

    // Add placeholder functionality
    if (editor.innerHTML.trim() === '' || editor.innerHTML.trim() === '<br>') {
        editor.innerHTML = '';
        editor.classList.add('placeholder');
    } else {
        editor.classList.remove('placeholder');
    }
}

// Simple text color function using manual HTML manipulation
function applyTextColor(color) {
    console.log('Applying text color:', color);
    const editor = document.getElementById('content');
    editor.focus();

    const selection = window.getSelection();
    console.log('Selection:', selection.toString());

    if (selection.rangeCount > 0) {
        const range = selection.getRangeAt(0);

        if (!range.collapsed) {
            // There's selected text - wrap it with a span
            const span = document.createElement('span');
            span.style.color = color;

            try {
                range.surroundContents(span);
                console.log('Successfully wrapped selected text');
            } catch (e) {
                console.log('surroundContents failed, trying extractContents');
                // If surroundContents fails, extract and wrap content
                const contents = range.extractContents();
                span.appendChild(contents);
                range.insertNode(span);
            }
        } else {
            // No selection, try execCommand as fallback
            console.log('No selection, trying execCommand');
            try {
                document.execCommand('foreColor', false, color);
            } catch (e) {
                console.error('execCommand failed:', e);
            }
        }
    } else {
        console.log('No selection range, trying execCommand');
        try {
            document.execCommand('foreColor', false, color);
        } catch (e) {
            console.error('execCommand failed:', e);
        }
    }

    updateContent();
}

// Simple background color function
function applyBackgroundColor(color) {
    console.log('Applying background color:', color);
    const editor = document.getElementById('content');
    editor.focus();

    // Check if there's a selection
    const selection = window.getSelection();
    console.log('Selection:', selection.toString());

    // Try different approaches
    try {
        document.execCommand('styleWithCSS', false, true);
        const result = document.execCommand('backColor', false, color);
        console.log('execCommand result:', result);
    } catch (e) {
        console.error('Error with styleWithCSS:', e);
        // Fallback approach
        const result = document.execCommand('backColor', false, color);
        console.log('Fallback execCommand result:', result);
    }

    updateContent();
}

// Initialize rich text editor
document.addEventListener('DOMContentLoaded', function() {
    const editor = document.getElementById('content');
    const hiddenTextarea = document.getElementById('content-hidden');

    // Set initial content if exists
    if (hiddenTextarea.value.trim()) {
        editor.innerHTML = hiddenTextarea.value;
    }

    // Handle placeholder
    editor.addEventListener('focus', function() {
        if (this.innerHTML.trim() === '' || this.innerHTML.trim() === '<br>') {
            this.innerHTML = '';
            this.classList.remove('placeholder');
        }
    });

    editor.addEventListener('blur', function() {
        if (this.innerHTML.trim() === '' || this.innerHTML.trim() === '<br>') {
            this.innerHTML = '';
            this.classList.add('placeholder');
        }
    });

    // Handle paste to clean up formatting
    editor.addEventListener('paste', function(e) {
        e.preventDefault();
        const text = (e.clipboardData || window.clipboardData).getData('text/plain');
        document.execCommand('insertText', false, text);
    });

    // Update button states based on current formatting
    editor.addEventListener('keyup', function() {
        updateButtonStates();
    });

    editor.addEventListener('mouseup', function() {
        updateButtonStates();
    });
});

function updateButtonStates() {
    const editor = document.getElementById('content');

    // Update bold button state
    const boldBtn = document.querySelector('[onclick="formatText(\'bold\')"]');
    if (document.queryCommandState('bold')) {
        boldBtn.classList.add('active');
    } else {
        boldBtn.classList.remove('active');
    }

    // Update italic button state
    const italicBtn = document.querySelector('[onclick="formatText(\'italic\')"]');
    if (document.queryCommandState('italic')) {
        italicBtn.classList.add('active');
    } else {
        italicBtn.classList.remove('active');
    }

    // Update underline button state
    const underlineBtn = document.querySelector('[onclick="formatText(\'underline\')"]');
    if (document.queryCommandState('underline')) {
        underlineBtn.classList.add('active');
    } else {
        underlineBtn.classList.remove('active');
    }

    // Update unordered list button state
    const ulBtn = document.querySelector('[onclick="formatText(\'insertUnorderedList\')"]');
    if (document.queryCommandState('insertUnorderedList')) {
        ulBtn.classList.add('active');
    } else {
        ulBtn.classList.remove('active');
    }

    // Update ordered list button state
    const olBtn = document.querySelector('[onclick="formatText(\'insertOrderedList\')"]');
    if (document.queryCommandState('insertOrderedList')) {
        olBtn.classList.add('active');
    } else {
        olBtn.classList.remove('active');
    }
}

// Form submission - ensure content is updated
document.querySelector('form').addEventListener('submit', function(e) {
    updateContent();
    if (!document.getElementById('content-hidden').value.trim()) {
        e.preventDefault();
        alert('Please enter some content for your blog post.');
        document.getElementById('content').focus();
    }
});

// Meta Keywords Tag Management
(function() {
    const keywordsInput = document.getElementById('meta_keywords_input');
    const keywordsContainer = document.getElementById('keywords-tags-container');
    const hiddenInput = document.getElementById('meta_keywords');
    let keywords = [];

    // Load existing keywords if any
    const existingKeywords = hiddenInput.value;
    if (existingKeywords) {
        keywords = existingKeywords.split(',').map(k => k.trim()).filter(k => k);
        renderTags();
        updateCounter();
    }

    // Add keyword on Enter
    keywordsInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const value = this.value.trim();
            if (value && !keywords.includes(value)) {
                if (keywords.length >= 15) {
                    alert('Maximum of 15 keywords allowed');
                    return;
                }
                keywords.push(value);
                this.value = '';
                renderTags();
                updateHiddenInput();
                updateCounter();
            }
        }
    });

    // Remove keyword
    function removeKeyword(keyword) {
        keywords = keywords.filter(k => k !== keyword);
        renderTags();
        updateHiddenInput();
        updateCounter();
    }

    // Render tags
    function renderTags() {
        keywordsContainer.innerHTML = '';
        keywords.forEach(keyword => {
            const tag = document.createElement('div');
            tag.style.cssText = 'display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; background: #f3f4f6; border: 1px solid #d1d5db; border-radius: 4px; font-size: 14px; color: #374151;';

            const text = document.createElement('span');
            text.textContent = keyword;

            const removeBtn = document.createElement('span');
            removeBtn.innerHTML = '×';
            removeBtn.style.cssText = 'cursor: pointer; font-size: 18px; color: #6b7280; font-weight: bold; line-height: 1; margin-left: 4px;';
            removeBtn.addEventListener('click', () => removeKeyword(keyword));

            tag.appendChild(text);
            tag.appendChild(removeBtn);
            keywordsContainer.appendChild(tag);
        });
    }

    // Update hidden input with comma-separated keywords
    function updateHiddenInput() {
        hiddenInput.value = keywords.join(',');
    }

    // Update counter display
    function updateCounter() {
        const counter = document.getElementById('keywords-counter');
        const remaining = 15 - keywords.length;
        counter.textContent = remaining + ' keywords remaining';
        if (remaining <= 0) {
            counter.style.color = '#dc2626';
            counter.textContent = 'Maximum reached (15 keywords)';
        } else if (remaining <= 3) {
            counter.style.color = '#f59e0b';
        } else {
            counter.style.color = '#6b7280';
        }
    }

    // Initialize counter
    updateCounter();
})();

// Custom Dropdown Functionality
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.custom-dropdown-toggle').forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const dropdown = this.closest('.custom-dropdown');
            const dropdownMenu = dropdown.querySelector('.dropdown-menu');
            const isOpen = dropdownMenu.classList.contains('show');

            // Close all
            document.querySelectorAll('.custom-dropdown .dropdown-menu').forEach(function(menu) {
                menu.classList.remove('show');
            });
            document.querySelectorAll('.custom-dropdown-toggle').forEach(function(t) {
                t.setAttribute('aria-expanded', 'false');
            });

            if (!isOpen) {
                dropdownMenu.classList.add('show');
                this.setAttribute('aria-expanded', 'true');
            }
        });
    });

    // Item selection handlers
    document.querySelectorAll('.custom-dropdown .dropdown-item').forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();

            const dropdown = this.closest('.custom-dropdown');
            const toggle = dropdown.querySelector('.custom-dropdown-toggle');
            const hiddenInput = dropdown.querySelector('input[type="hidden"]');
            const dropdownText = toggle.querySelector('.dropdown-text');

            dropdownText.textContent = this.textContent;
            hiddenInput.value = this.dataset.value;

            const dropdownMenu = dropdown.querySelector('.dropdown-menu');
            dropdownMenu.classList.remove('show');
            toggle.setAttribute('aria-expanded', 'false');
        });
    });

    // Close on outside click
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.custom-dropdown')) {
            document.querySelectorAll('.custom-dropdown .dropdown-menu').forEach(function(menu) {
                menu.classList.remove('show');
            });
            document.querySelectorAll('.custom-dropdown-toggle').forEach(function(t) {
                t.setAttribute('aria-expanded', 'false');
            });
        }
    });
});
</script>
@endsection
