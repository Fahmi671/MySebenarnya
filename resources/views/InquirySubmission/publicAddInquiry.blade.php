<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Inquiry - Public User</title>
    <style>
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            background: #faf7ed;
            font-family: 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            color: #2c2c2c;
        }

        /* Header */
        .header {
            width: 100%;
            height: 80px;
            background: #00396b;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 0 2.5rem;
            box-sizing: border-box;
        }

        .header .header-title {
            display: flex;
            align-items: center;
            color: #f8f8f8;
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .header .header-title::before {
            content: "";
            display: inline-block;
            width: 24px;
            height: 24px;
            margin-right: 12px;
        }

        .header .header-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .header-actions .logout-btn {
            padding: 0.5rem 1rem;
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 6px;
            color: #f8f8f8;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .header-actions .logout-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .header-actions .logout-btn svg {
            width: 18px;
            height: 18px;
        }

        .header-actions .avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            overflow: hidden;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .header-actions .avatar:hover {
            transform: scale(1.05);
            border-color: rgba(255, 255, 255, 0.6);
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background-color: #00396b;
            color: white;
            position: fixed;
            top: 80px;
            left: 0;
            bottom: 0;
            box-sizing: border-box;
            border-right: 1px solid #bfa292;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            min-height: calc(100vh - 80px);
            padding: 1.5rem 0;
            z-index: 99;
        }

        .sidebartitle {
            color: #f8f8f8;
            font-size: 1.15rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding: 0 1.5rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            opacity: 0.85;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .menuitems {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            padding: 0;
            margin: 0;
            list-style: none;
            box-sizing: border-box;
        }

        .menuitem {
            font-size: 1.1rem;
            font-weight: 500;
            background-color: transparent;
            border-radius: 8px;
            padding: 0.85rem 1.5rem;
            color: #f8f8f8;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, font-weight 0.2s;
            display: block;
            text-decoration: none;
            border: none;
            outline: none;
            opacity: 0.95;
            width: 100%;
            box-sizing: border-box;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: left;
        }

        .menuitem:hover,
        .menuitem:focus {
            background-color: rgba(255, 255, 255, 0.12);
            opacity: 1;
        }

        .menuitem.active {
            background-color: rgba(255, 255, 255, 0.22);
            color: #fff;
            font-weight: 700;
        }

        .menuitem::before,
        .menuitem.active::before {
            display: none;
        }

        /* Main Content */
        .main-content {
            margin-left: 220px;
            padding: 6rem 2.5rem 2rem;
            background: #faf7ed;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s;
        }

        .content-header {
            font-size: 1.7rem;
            font-weight: 700;
            color: #2c2c2c;
            margin-bottom: 1.5rem;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .content-header::before {
            content: "";
            display: inline-block;
            width: 8px;
            height: 28px;
            background: #00396b;
            border-radius: 3px;
        }

        .content-box {
            background: #fff;
            border: 1px solid #bfa292;
            border-radius: 14px;
            width: 100%;
            min-height: 300px;
            max-width: 1200px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        /* Drop zone area */
        .drop-zone {
            border: 2px dashed #bfa292;
            border-radius: 12px;
            background: #faf7ed;
            padding: 2rem 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0.5rem 0 1rem;
        }
        /* Visual feedback when file is dragged over */
        .drop-zone.dragover {
            border-color: #00396b;
            background: rgba(0, 57, 107, 0.05);
        }
        .drop-zone p {
            margin: 0.5rem 0 0;
            font-size: 1rem;
            color: #2c2c2c;
        }
        .drop-zone .browse-link {
            color: #00396b;
            font-weight: bold;
            text-decoration: underline;
        }
        .drop-zone .hint {
            font-size: 0.85rem;
            color: #666;
        }
        /* File info bar shown after file is selected */
        .file-info {
            display: none;
            align-items: center;
            padding: 0.75rem 1rem;
            background: #ffffff;
            border: 1px solid #bfa292;
            border-radius: 8px;
            margin-bottom: 1rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .preview-img {
            max-width: 60px;
            max-height: 60px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid #ccc;
            margin-right: 1rem;
            display: none;
        }
        .icon-placeholder {
            display: none;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            background: #e0f2fe;
            border-radius: 6px;
            border: 1px solid #bae6fd;
            margin-right: 1rem;
        }
        .file-details {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .file-info .remove-btn {
            background: #E53935;
            color: white;
            border: none;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
            line-height: 1;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="header-title">MySebenarnya</div>
        <div class="header-actions">
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"></path>
                    </svg>
                    Log Out
                </button>
            </form>
            <div class="avatar">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6f/Coat_of_arms_of_Malaysia.svg" alt="avatar" style="width:40px;height:40px;">
            </div>
        </div>
    </header>
    <nav class="sidebar" aria-label="Agency sidebar">
        <div class="sidebartitle">Public User</div>
        <ul class="menuitems">
            <li><a href="{{ route('InquiryProgress.publicInquiryTracking') }}" class="menuitem">Home</a></li>
            <li><a href="{{ route('InquirySubmission.publicAddInquiry') }}" class="menuitem active">Add New Inquiry</a></li>
            <li><a href="{{ route('InquirySubmission.publicViewInquiry') }}" class="menuitem">View Inquiry</a></li>
            <li><a href="{{ route('InquirySubmission.publicPublicInquiry') }}" class="menuitem">Public Inquiry</a></li>
            <li><a href="{{ route('InquiryProgress.publicHistory') }}" class="menuitem">History</a></li>
        </ul>
    </nav>

    <div class="main-content">
        <div class="content-header">Add New Inquiry</div>
        <div class="content-box">
            @if(session('success'))
            <div style="color:green">{{ session('success') }}</div>
            @endif


            <form action="{{ route('InquirySubmission.inquiry.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="newsTitle" style="font-weight: bold;">News Title:</label>
                <input type="text" id="newsTitle" name="SubmissionTitle" placeholder="Enter the news title..." required
                    style="width: 100%; padding: 0.6rem; margin: 0.5rem 0 1rem; border: 1px solid #ccc; border-radius: 6px;">

                <label for="newsDetails" style="font-weight: bold; display: flex; justify-content: space-between;">
                    Detailed Information:
                    <span id="char-counter" style="font-weight: normal; font-size: 0.85rem; color: #666;">0 / 255</span>
                </label>
                <textarea id="newsDetails" name="SubmissionDescription" rows="6" placeholder="Describe the issue or content of the news in detail..."
                    required maxlength="255"
                    style="width: 100%; padding: 0.6rem; margin: 0.5rem 0 1rem; border: 1px solid #ccc; border-radius: 6px; resize: vertical;"></textarea>

                <label for="submission_category" style="font-weight: bold;">News Category:</label>
                <select id="submission_category" name="SubmissionCategory" required
                    style="width: 100%; padding: 0.6rem; margin: 0.5rem 0 1rem; border: 1px solid #ccc; border-radius: 6px;">
                    <option value="">-- Select Category --</option>
                    <option value="Politics">Politics</option>
                    <option value="Health">Health</option>
                    <option value="Technology">Technology</option>
                    <option value="Crime">Crime</option>
                    <option value="Others">Public Safety</option>
                    <option value="Health">Education</option>
                    <option value="Crime">Administration</option>
                    <option value="Others">Economy</option>
                    <option value="Others">Others</option>
                </select>

                <label for="supportingFiles" style="font-weight: bold;">Upload Supporting Documents or Images:</label>
                
                <div id="drop-zone" class="drop-zone">
                    <p>Drag & Drop files here or <span class="browse-link">Browse files</span></p>
                    <span class="hint">Supports: JPG, PNG, PDF, DOCX, XLSX (Max: 10MB)</span>
                <input type="file" id="supportingFiles" name="SubmissionEvidence"
                    accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx" style="display: none;"> 
                </div>

                <!-- File info (shown after a file is selected) -->
                <div id="file-info" class="file-info">
                    <img id="image-preview" class="preview-img" src="#" alt="Preview" />
                    
                    <div class="file-details">
                        <span id="file-name" style="font-weight: 600; font-size: 0.95rem; color: #2c2c2c;"></span>
                        <span id="file-size" style="font-size: 0.85rem; color: #666;"></span>
                    </div>
                    <button type="button" id="remove-btn" class="remove-btn">&times;</button>
                </div>

                <label for="externalLinks" style="font-weight: bold;">Links (if any):</label>
                <input type="url" id="externalLinks" name="SourceofNews" placeholder="https://example.com"
                    style="width: 100%; padding: 0.6rem; margin: 0.5rem 0 1.5rem; border: 1px solid #ccc; border-radius: 6px;">

                <!-- You may also display the dynamic status here (read-only for public users) -->
                <label for="submission_status" style="font-weight: bold;">Submission Status:</label>
                <input type="text" id="submission_status" name="SubmissionStatus" value="Pending Review" readonly
                    style="width: 100%; padding: 0.6rem; margin-bottom: 1.5rem; border: 1px solid #ccc; border-radius: 6px; background-color: #f5f5f5;">

                <button type="submit"
                    style="background-color: #00396b; color: white; padding: 0.75rem 1.5rem; font-size: 1rem; border: none; border-radius: 8px; cursor: pointer;">
                    Submit
                </button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            //Count Characters  
            const newsDetails = document.getElementById('newsDetails');
            const charCounter = document.getElementById('char-counter');
            newsDetails.addEventListener('input', () => {
                const currentLength = newsDetails.value.length;
                charCounter.textContent = `${currentLength} / 255`;
                
                if (currentLength >= 250) {
                    charCounter.style.color = '#E53935';
                    charCounter.style.fontWeight = 'bold';
                } else {
                    charCounter.style.color = '#666';
                    charCounter.style.fontWeight = 'normal';
                }
            });
        
            const dropZone = document.getElementById('drop-zone');
            const fileInput = document.getElementById('supportingFiles');
            const fileInfo = document.getElementById('file-info');
            const fileName = document.getElementById('file-name');
            const fileSize = document.getElementById('file-size');
            const imagePreview = document.getElementById('image-preview');
            const iconPlaceholder = document.getElementById('icon-placeholder');
            const removeBtn = document.getElementById('remove-btn');
            // Click drop zone to open file chooser
            dropZone.addEventListener('click', () => fileInput.click());
            /// Highlight drop zone when file is dragged over
            ['dragenter', 'dragover'].forEach(evt => {
                dropZone.addEventListener(evt, (e) => {
                    e.preventDefault();
                    dropZone.classList.add('dragover');
                });
            });
            // Remove highlight when file leaves or is dropped
            ['dragleave', 'drop'].forEach(evt => {
                dropZone.addEventListener(evt, (e) => {
                    e.preventDefault();
                    dropZone.classList.remove('dragover');
                });
            });
            // Handle dropped files 
            dropZone.addEventListener('drop', (e) => {
                fileInput.files = e.dataTransfer.files;
                showFile(e.dataTransfer.files[0]);
            });
            // Handle file chosen via dialog
            fileInput.addEventListener('change', () => {
                if (fileInput.files.length) showFile(fileInput.files[0]);
            });
           // Display file name, size, and image preview 
            function showFile(file) {
                if (file.size > 10 * 1024 * 1024) {
                    alert('Error: File size exceeds 10MB limit.');
                    clearFile();
                    return;
                }
                fileName.textContent = file.name;
            fileSize.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
            fileInfo.style.display = 'flex';
                // Show thumbnail for images, icon for documents
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                        iconPlaceholder.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.style.display = 'none';
                    iconPlaceholder.style.display = 'flex';
                }
            }
            // Remove button clears the file
            removeBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                clearFile();
            });
            // Remove file upload and reset the preview
            function clearFile() {
                 fileInput.value = '';
                 fileInfo.style.display = 'none';
                 imagePreview.src = '#';
             }
        });
        </script>
</body>
</html>