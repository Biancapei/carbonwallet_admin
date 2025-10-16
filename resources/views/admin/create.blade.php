@extends('admin.layout')

@section('content')
<div>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="font-size: 24px; font-weight: bold; color: #374151; margin: 0;">Create New Blog Post</h1>
        <a href="{{ route('admin.index') }}" class="back-to-posts-btn">
            <i class="fa-solid fa-arrow-left"></i> &nbsp;Back to Posts
        </a>
    </div>

    <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <form method="POST" action="{{ route('admin.store') }}" enctype="multipart/form-data" style="padding: 30px;">
            @csrf

            <!-- Title -->
            <div style="margin-bottom: 24px;">
                <label for="title" style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                    Title *
                </label>
                <input type="text"
                       id="title"
                       name="title"
                       value="{{ old('title') }}"
                       style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; background: white; color: #374151; box-sizing: border-box;"
                       placeholder="Enter blog post title"
                       required>
                @error('title')
                    <p style="margin-top: 4px; font-size: 12px; color: #dc2626;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div style="margin-bottom: 24px;">
                <label for="description" style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                    Description *
                </label>
                <input type="text"
                       id="description"
                       name="description"
                       value="{{ old('description') }}"
                       style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; background: white; color: #374151; box-sizing: border-box;"
                       placeholder="Enter blog post description"
                       required>
                @error('description')
                    <p style="margin-top: 4px; font-size: 12px; color: #dc2626;">{{ $message }}</p>
                @enderror
            </div>

                   <!-- Cover Image -->
                   <div style="margin-bottom: 24px;">
                       <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px; font-size: 14px;">
                           Cover Image
                       </label>
                       <div style="display: flex; align-items: center; gap: 10px;">
                           <input type="file"
                                  id="image"
                                  name="image"
                                  accept="image/*"
                                  style="display: none;"
                                  onchange="updateFileName(this); previewImage(this)">
                           <button type="button" onclick="document.getElementById('image').click()" style="background: #f3f4f6; border: 1px solid #d1d5db; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 14px; color: #374151;">
                               Browse...
                           </button>
                           <input type="text" id="file-name" placeholder="No file chosen" readonly style="flex: 1; padding: 8px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; background: #f9fafb; color: #6b7280;">
                       </div>
                       <div id="image-preview" class="image-preview" style="display: none;">
                           <img id="preview-img" src="" alt="Preview">
                           <br>
                           <button type="button" onclick="removeImage()">Remove Image</button>
                       </div>
                       @error('image')
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
                                oninput="updateContent()">{{ old('content') }}</div>

                           <!-- Hidden textarea for form submission -->
                           <textarea name="content" id="content-hidden" style="display: none;" required>{{ old('content') }}</textarea>
                       </div>

                       @error('content')
                           <p style="margin-top: 4px; font-size: 12px; color: #dc2626;">{{ $message }}</p>
                       @enderror
                   </div>

            <!-- Published Status -->
            {{-- <div style="margin-bottom: 30px;">
                <label style="display: flex; align-items: center; cursor: pointer;">
                    <input type="checkbox"
                           name="is_published"
                           value="1"
                           {{ old('is_published', true) ? 'checked' : '' }}
                           style="margin-right: 8px; accent-color: #dc2626;">
                    <span style="font-size: 14px; color: #374151;">Publish immediately</span>
                </label>
            </div> --}}

            <!-- Submit Button -->
            <div class="save-post-btn" style="text-align: center;">
                <button type="submit" onmouseover="this.style.background='#16d3ca'" onmouseout="this.style.background='#000'">
                    Save Post
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Image preview functionality
function updateFileName(input) {
    const fileNameInput = document.getElementById('file-name');
    if (input.files && input.files[0]) {
        fileNameInput.value = input.files[0].name;
        fileNameInput.style.color = '#374151';
    } else {
        fileNameInput.value = 'No file chosen';
        fileNameInput.style.color = '#6b7280';
    }
}

function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage() {
    const preview = document.getElementById('image-preview');
    const fileInput = document.getElementById('image');
    const fileNameInput = document.getElementById('file-name');

    preview.style.display = 'none';
    fileInput.value = '';
    fileNameInput.value = 'No file chosen';
    fileNameInput.style.color = '#6b7280';
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
