@extends('layouts.auth')

@section('title', 'Document Verification')

@section('content')
<div class="glass p-8 rounded-3xl glow-shadow" x-data="docUpload()">
    <div class="mb-8 text-center">
        <h1 class="text-2xl font-bold text-white mb-1">Verify Your Identity</h1>
        <p class="text-muted text-sm">Upload documents to verify your professional status.</p>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs">
        {{ $errors->first() }}
    </div>
    @endif

    <div class="space-y-4">
        <template x-for="(req, key) in requirements" :key="key">
            <div class="relative group p-4 rounded-2xl border border-white/10 bg-white/5 transition-all hover:border-white/20">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-accent/10 border border-accent/20 flex items-center justify-center text-accent text-xl">
                            <i :class="req.icon || 'bi-file-earmark-text'"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white" x-text="req.label"></h3>
                            <p class="text-[10px] uppercase tracking-widest text-muted" x-text="req.required ? 'Mandatory' : 'Optional'"></p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <!-- Status indicator -->
                        <div x-show="isUploaded(key)" class="flex items-center gap-1.5 text-green-400 text-xs font-bold">
                            <i class="bi bi-patch-check-fill"></i> Done
                        </div>
                        <div x-show="isUploading(key)" class="flex items-center gap-2">
                            <span class="w-4 h-4 border-2 border-accent border-t-transparent rounded-full animate-spin"></span>
                        </div>
                        
                        <!-- Upload Button -->
                        <div class="relative overflow-hidden" x-show="!isUploaded(key) && !isUploading(key)">
                            <button class="bg-white/10 hover:bg-white/20 text-white text-xs font-bold px-4 py-2 rounded-lg transition-all border border-white/5">
                                <i class="bi bi-cloud-arrow-up me-1.5"></i> Upload
                            </button>
                            <input type="file" 
                                @change="handleUpload($event, key)"
                                class="absolute inset-0 opacity-0 cursor-pointer scale-150"
                                accept=".pdf,.jpg,.jpeg,.png">
                        </div>

                        <!-- Change button -->
                        <div class="relative" x-show="isUploaded(key) && !isUploading(key)">
                            <button class="text-muted hover:text-white transition-colors">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <input type="file" 
                                @change="handleUpload($event, key)"
                                class="absolute inset-0 opacity-0 cursor-pointer"
                                accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                    </div>
                </div>

                <!-- Progress Bar (Internal) -->
                <div x-show="isUploading(key)" class="mt-4 h-1 w-full bg-white/5 rounded-full overflow-hidden">
                    <div class="h-full bg-accent transition-all duration-300" :style="`width: ${uploadProgress[key] || 0}%`"></div>
                </div>
            </div>
        </template>
    </div>

    <div class="mt-10">
        <form action="{{ route('register.complete') }}" method="POST">
            @csrf
            <button type="submit" 
                :disabled="!canFinish"
                class="w-full bg-accent hover:bg-accent/90 disabled:opacity-50 disabled:grayscale disabled:cursor-not-allowed text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-accent/20">
                <span x-show="!finishing">
                    Complete & Request Review <i class="bi bi-arrow-right ms-2"></i>
                </span>
                <span x-show="finishing" class="flex items-center justify-center gap-2">
                    <span class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span> Processing...
                </span>
            </button>
        </form>
        <p class="text-center text-[10px] text-muted mt-4">
            By clicking complete, you agree that submitted documents are genuine.
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
function docUpload() {
    return {
        requirements: @json($requirements),
        uploadedDocs: @json($uploadedDocs),
        uploadProgress: {},
        uploading: {},
        finishing: false,

        isUploaded(key) {
            return this.uploadedDocs.includes(key);
        },

        isUploading(key) {
            return this.uploading[key] === true;
        },

        get canFinish() {
            // Check if all mandatory requirements are met
            for (let key in this.requirements) {
                if (this.requirements[key].required && !this.isUploaded(key)) {
                    return false;
                }
            }
            return true;
        },

        async handleUpload(event, key) {
            const file = event.target.files[0];
            if (!file) return;

            // Validate file type & size (5MB)
            const allowed = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'];
            if (!allowed.includes(file.type)) {
                alert('Invalid file format. Please upload PDF or Images.');
                return;
            }
            if (file.size > 5 * 1024 * 1024) {
                alert('File is too large (max 5MB)');
                return;
            }

            this.uploading[key] = true;
            this.uploadProgress[key] = 0;

            const formData = new FormData();
            formData.append('document', file);
            formData.append('type', key);
            formData.append('_token', '{{ csrf_token() }}');

            try {
                // We use XMLHTTPRequest for progress monitoring
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('register.upload-doc') }}', true);

                xhr.upload.onprogress = (e) => {
                    if (e.lengthComputable) {
                        this.uploadProgress[key] = Math.round((e.loaded / e.total) * 100);
                    }
                };

                xhr.onload = () => {
                    this.uploading[key] = false;
                    if (xhr.status >= 200 && xhr.status < 300) {
                        const resp = JSON.parse(xhr.responseText);
                        if (resp.success) {
                            if (!this.uploadedDocs.includes(key)) {
                                this.uploadedDocs.push(key);
                            }
                        } else {
                            alert('Upload failed: ' + resp.message);
                        }
                    } else {
                        alert('Error uploading file.');
                    }
                };

                xhr.onerror = () => {
                    this.uploading[key] = false;
                    alert('Network error occurred.');
                };

                xhr.send(formData);

            } catch (err) {
                console.error(err);
                this.uploading[key] = false;
                alert('Something went wrong.');
            }
        }
    }
}
</script>
@endpush
