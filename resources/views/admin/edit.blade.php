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

            <!-- Content -->
            <div style="margin-bottom: 24px;">
                <label for="content" style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                    Content *
                </label>

                <!-- Rich Text Editor -->
                <div class="rich-text-editor">
                    <div class="editor-toolbar">
                        <!-- Font Size -->
                        <select id="fontSize" class="font-size-select" onchange="formatText('fontSize', this.value)">
                            <option value="12px">12px</option>
                            <option value="14px">14px</option>
                            <option value="16px" selected>16px</option>
                            <option value="18px">18px</option>
                            <option value="20px">20px</option>
                            <option value="24px">24px</option>
                            <option value="28px">28px</option>
                            <option value="32px">32px</option>
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

                        <!-- Lists -->
                        <button type="button" class="editor-btn" onclick="formatText('insertUnorderedList')" title="Bullet List">
                            <i class="fas fa-list-ul"></i>
                        </button>
                        <button type="button" class="editor-btn" onclick="formatText('insertOrderedList')" title="Numbered List">
                            <i class="fas fa-list-ol"></i>
                        </button>
                    </div>

                    <div id="content"
                         class="editor-content"
                         contenteditable="true"
                         data-placeholder="Write your blog post content here..."
                         oninput="updateContent()">{{ old('content', strip_tags($blog->content)) }}</div>

                    <!-- Hidden textarea for form submission -->
                    <textarea name="content" id="content-hidden" style="display: none;" required>{{ old('content', strip_tags($blog->content)) }}</textarea>
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
        document.execCommand('fontSize', false, '7');
        const fontElements = editor.querySelectorAll('font[size="7"]');
        fontElements.forEach(el => {
            el.removeAttribute('size');
            el.style.fontSize = value;
        });
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
    } else {
        document.execCommand(command, false, value);
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
</script>
@endsection
