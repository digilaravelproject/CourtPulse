<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step 2: Verification Documents — Court Pulse</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --accent: #B4B4FE;
            --accent-h: #9A9AF8;
            --navy-deep: #0A1120;
            --navy-bg: #0F172A;
            --border-dim: rgba(255, 255, 255, 0.1);
            --muted: #94A3B8;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--navy-bg);
            color: white;
            min-height: 100vh;
        }

        .step-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .step-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-dim);
            border-radius: 24px;
            overflow: hidden;
            display: flex;
            min-height: 600px;
        }

        .sidebar {
            width: 320px;
            background: rgba(255, 255, 255, 0.02);
            border-right: 1px solid var(--border-dim);
            padding: 40px;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
            padding: 40px;
            background: rgba(15, 23, 42, 0.6);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            margin-bottom: 48px;
        }

        .logo-badge {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            border: 1px solid rgba(180, 180, 254, 0.4);
            background: rgba(180, 180, 254, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 1rem;
        }

        .step-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: white;
        }

        .step-subtitle {
            color: var(--muted);
            font-size: 0.9rem;
            margin-bottom: 32px;
        }

        .req-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .req-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .req-item.active {
            color: var(--accent);
            font-weight: 600;
        }

        .req-item i {
            font-size: 1.1rem;
        }

        .req-item.done {
            color: #22C55E;
        }

        /* Upload Slots */
        .upload-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .upload-slot {
            background: rgba(255, 255, 255, 0.05);
            border: 2px dashed rgba(180, 180, 254, 0.2);
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            transition: all 0.3s;
            position: relative;
            cursor: pointer;
        }

        .upload-slot:hover {
            border-color: var(--accent);
            background: rgba(180, 180, 254, 0.05);
        }

        .upload-slot.uploaded {
            border-style: solid;
            border-color: #22C55E;
            background: rgba(34, 197, 94, 0.05);
        }

        .slot-icon {
            font-size: 2rem;
            color: var(--accent);
            margin-bottom: 12px;
        }

        .slot-label {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 4px;
        }

        .slot-desc {
            font-size: 0.75rem;
            color: var(--muted);
        }

        .slot-status {
            margin-top: 12px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
        }

        .btn-final {
            background: var(--accent);
            color: var(--navy-deep);
            border: none;
            padding: 14px 40px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            margin-top: 40px;
            transition: all 0.2s;
            box-shadow: 0 4px 20px rgba(180, 180, 254, 0.3);
        }

        .btn-final:hover:not(:disabled) {
            background: var(--accent-h);
            transform: translateY(-2px);
        }

        .btn-final:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            filter: grayscale(1);
        }

        input[type="file"] {
            display: none;
        }

        /* Loading Overlay */
        .loading-overlay {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.8);
            display: none;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            z-index: 10;
        }

        @media (max-width: 991px) {
            .step-card {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                padding: 30px;
                border-right: none;
                border-bottom: 1px solid var(--border-dim);
            }
        }
    </style>
</head>
<body>

<div class="step-container">
    <div class="step-card">
        <div class="sidebar">
            <a href="/" class="logo">
                <div class="logo-badge">⚖</div>
                Court Pulse
            </a>

            <div class="mb-4">
                <div class="text-xs text-uppercase tracking-widest text-muted mb-2">Registration Progress</div>
                <div class="d-flex align-items-center gap-2">
                    <div class="grow bg-white bg-opacity-10 h-1 rounded-pill">
                        <div class="bg-primary h-1 rounded-pill" style="width: 50%"></div>
                    </div>
                    <span class="small font-monospace">50%</span>
                </div>
            </div>

            <ul class="req-list">
                <li class="req-item done">
                    <i class="bi bi-check-circle-fill"></i>
                    Step 1: Basic Details
                </li>
                <li class="req-item active">
                    <i class="bi bi-circle"></i>
                    Step 2: Document Upload
                </li>
                <li class="req-item">
                    <i class="bi bi-circle"></i>
                    Step 3: Verification
                </li>
            </ul>

            <div class="mt-auto pt-4 border-top border-white border-opacity-10">
                <p class="small text-muted mb-0">Role: <strong class="text-white text-capitalize">{{ $user->role }}</strong></p>
                <p class="small text-muted">ID: <span class="font-monospace text-white">{{ $user->email }}</span></p>
            </div>
        </div>

        <div class="main-content">
            <h1 class="step-title">Verify Your Profile</h1>
            <p class="step-subtitle">Please upload clear copies of the following documents to get verified by our admin team.</p>

            <div class="upload-grid">
                @foreach($requirements as $key => $req)
                    @php 
                        $doc = $documents->firstWhere('document_type', $key);
                    @endphp
                    <div class="upload-slot {{ $doc ? 'uploaded' : '' }}" onclick="document.getElementById('file_{{ $key }}').click()">
                        <div class="loading-overlay" id="loading_{{ $key }}">
                            <div class="spinner-border spinner-border-sm text-primary"></div>
                        </div>
                        <i class="bi {{ $req['icon'] }} slot-icon"></i>
                        <span class="slot-label">{{ $req['label'] }} @if($req['required']) * @endif</span>
                        <span class="slot-desc">PDF, JPG or PNG (Max 5MB)</span>
                        
                        <div class="slot-status" id="status_{{ $key }}">
                            @if($doc)
                                <span class="text-success"><i class="bi bi-check-lg"></i> Uploaded</span>
                            @else
                                <span class="text-muted">Click to upload</span>
                            @endif
                        </div>

                        <input type="file" id="file_{{ $key }}" onchange="handleUpload(this, '{{ $key }}')" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <p class="small text-muted mt-4">* All mandatory documents must be uploaded to continue.</p>
                
                <form action="{{ route('register.step2.store') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-final" id="btnSubmit" @if(!$allUploaded) disabled @endif>
                        Submit for Verification <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.2/axios.min.js"></script>
<script>
    const requirements = @json($requirements);
    const uploadedTypes = @json($documents->pluck('document_type')->toArray());

    function checkCompletion() {
        let allRequired = true;
        for (const [key, config] of Object.entries(requirements)) {
            if (config.required && !uploadedTypes.includes(key)) {
                allRequired = false;
                break;
            }
        }
        document.getElementById('btnSubmit').disabled = !allRequired;
    }

    async function handleUpload(input, type) {
        if (!input.files || !input.files[0]) return;
        
        const file = input.files[0];
        const formData = new FormData();
        formData.append('file', file);
        formData.append('document_type', type);
        formData.append('_token', '{{ csrf_token() }}');

        const slot = input.closest('.upload-slot');
        const loading = document.getElementById('loading_' + type);
        const status = document.getElementById('status_' + type);

        loading.style.display = 'flex';

        try {
            const uploadUrl = "{{ in_array($user->role, ['advocate', 'clerk', 'ca']) ? route($user->role . '.documents.upload') : '#' }}";
            const response = await axios.post(uploadUrl, formData);
            if (response.data.success) {
                slot.classList.add('uploaded');
                status.innerHTML = '<span class="text-success"><i class="bi bi-check-lg"></i> Uploaded</span>';
                
                // Real-time toast implementation
                const toast = document.createElement('div');
                toast.className = 'position-fixed bottom-0 end-0 m-4 p-3 rounded-3 shadow-lg bg-success text-white';
                toast.style.zIndex = '1000';
                toast.innerHTML = `<i class="bi bi-check-circle-fill me-2"></i> ${type.replace('_',' ')} uploaded successfully!`;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);

                if (!uploadedTypes.includes(type)) {
                    uploadedTypes.push(type);
                }
                checkCompletion();
            }
        } catch (error) {
            console.error(error);
            alert(error.response?.data?.message || 'Upload failed. Please try again.');
        } finally {
            loading.style.display = 'none';
        }
    }
</script>

</body>
</html>
