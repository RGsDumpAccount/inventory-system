<div>
    <label class="block text-sm font-semibold mb-1">Photo</label>
    <div class="flex items-center gap-4">
        <img id="photoPreview" src="" alt="" class="hidden h-24 w-24 rounded-lg object-cover border border-slate-200">
        <div>
            <label for="image" class="inline-flex items-center gap-2 cursor-pointer bg-indigo-50 text-indigo-700 border border-indigo-200 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-100">📷 Choose photo</label>
            <input type="file" id="image" name="image" accept="image/*" class="hidden">
            <p id="photoName" class="text-xs text-slate-500 mt-2">No file chosen</p>
        </div>
    </div>
</div>

<script>
    document.getElementById('image').addEventListener('change', function () {
        const file = this.files[0];
        const preview = document.getElementById('photoPreview');
        document.getElementById('photoName').textContent = file ? file.name : 'No file chosen';
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        }
    });
</script>