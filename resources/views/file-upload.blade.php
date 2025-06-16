<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #8e44ad, #3498db);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        .scrollable-list {
            max-height: 400px;
            overflow-y: auto;
        }

        #filePreview {
            width: 100%;
            min-height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px dashed rgba(255, 255, 255, 0.5);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-radius: 10px;
        }

        #filePreview img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
            border-radius: 10px;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center">
    <div class="glass-card w-full max-w-6xl p-8 rounded-2xl">
        <button onclick="location.href='/dashboard'"
            style=" color: white; border: none; padding: 10px 10px; border-radius: 5px; cursor: pointer;">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 30 30">
                <path
                    d="M 15 2 A 1 1 0 0 0 14.300781 2.2851562 L 3.3925781 11.207031 A 1 1 0 0 0 3.3554688 11.236328 L 3.3183594 11.267578 L 3.3183594 11.269531 A 1 1 0 0 0 3 12 A 1 1 0 0 0 4 13 L 5 13 L 5 24 C 5 25.105 5.895 26 7 26 L 23 26 C 24.105 26 25 25.105 25 24 L 25 13 L 26 13 A 1 1 0 0 0 27 12 A 1 1 0 0 0 26.681641 11.267578 L 26.666016 11.255859 A 1 1 0 0 0 26.597656 11.199219 L 25 9.8925781 L 25 6 C 25 5.448 24.552 5 24 5 L 23 5 C 22.448 5 22 5.448 22 6 L 22 7.4394531 L 15.677734 2.2675781 A 1 1 0 0 0 15 2 z M 18 15 L 22 15 L 22 23 L 18 23 L 18 15 z">
                </path>
            </svg>
        </button>

        <h2 class="text-4xl font-bold text-center mb-8 text-white">Upload and Manage Your Files</h2>
        @if (session('success'))
            <div id="successMessage" class="bg-green-500 text-white p-4 rounded-lg mb-4 shadow-md">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div id="errorMessage" class="bg-red-500 text-white p-4 rounded-lg mb-4 shadow-md">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Upload Form -->
            <div class="bg-white bg-opacity-20 p-6 rounded-lg shadow-lg">
                <h3 class="text-2xl font-bold text-white mb-4">Upload Your File</h3>
                <form action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-6"
                    onsubmit="showLoader()">
                    @csrf
                    <div>
                        <label for="file" class="block text-lg font-medium text-white mb-2">Select File</label>
                        <input type="file" name="file" id="file" onchange="previewFile(event)"
                            class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 p-3">
                        @error('file')
                            <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="hidden" id="previewContainer">
                        <p class="text-lg font-medium text-white mb-2">File Preview:</p>
                        <div id="filePreview"
                            class="w-full h-56 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">No
                            preview available</div>
                    </div>
                    <button type="submit"
                        class="w-full bg-purple-600 text-white py-3 rounded-lg text-lg font-semibold hover:bg-purple-700 transition duration-300">Upload
                        File</button>
                </form>
            </div>

            <!-- Uploaded Files List -->
            <div class="bg-white bg-opacity-20 p-6 rounded-lg shadow-lg">
                <h3 class="text-2xl font-bold text-white mb-4">Uploaded Files</h3>
                <ul class="space-y-4 scrollable-list">
                    @foreach ($files as $file)
                        <li
                            class="flex justify-between items-center p-4 bg-white bg-opacity-30 rounded-lg shadow-sm hover:shadow-lg transition duration-300">
                            <span class="text-white font-medium truncate">{{ $file->file_name }}</span>
                            <div class="flex space-x-4">
                                <!-- Download Button -->
                                <a href="{{ route('file.download', $file->file_id) }}"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300">Download</a>

                                <!-- Delete Button -->
                                <form action="{{ route('file.destroy', $file->file_id) }}" method="POST"
                                    onsubmit="showLoader()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Loader -->
    <div id="loadingOverlay"
        class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-purple-500"></div>
    </div>

    <script>
        function previewFile(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('previewContainer');
            const filePreview = document.getElementById('filePreview');
            previewContainer.classList.remove('hidden');
            filePreview.innerHTML = ''; // Clear previous preview

            if (!file) return;

            const fileType = file.type;
            const reader = new FileReader();

            if (fileType.startsWith('image/')) {
                reader.onload = function() {
                    const img = document.createElement('img');
                    img.src = reader.result;
                    img.className = 'w-full h-56 object-cover rounded-lg';
                    filePreview.appendChild(img);
                };
                reader.readAsDataURL(file);
            } else if (fileType === 'application/pdf') {
                const pdfLink = document.createElement('a');
                pdfLink.href = URL.createObjectURL(file);
                pdfLink.target = '_blank';
                pdfLink.textContent = 'Click here to preview the PDF';
                pdfLink.className = 'text-purple-500 underline';
                filePreview.appendChild(pdfLink);
            } else {
                const fileInfo = document.createElement('p');
                fileInfo.textContent = `File selected: ${file.name}`;
                fileInfo.className = 'text-white';
                filePreview.appendChild(fileInfo);
            }
        }

        function showLoader() {
            document.getElementById('loadingOverlay').classList.remove('hidden');
        }

        setTimeout(() => {
            const successMessage = document.getElementById('successMessage');
            const errorMessage = document.getElementById('errorMessage');
            if (successMessage) successMessage.style.display = 'none';
            if (errorMessage) errorMessage.style.display = 'none';
        }, 3000);
    </script>
</body>

</html>
