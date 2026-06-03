{{-- ══ USER MANAGEMENT MODALS ═══════════════════════════════════════ --}}
<div id="umOverlay" onclick="closeUmModal()" class="hidden fixed inset-0 bg-navy/80 backdrop-blur-sm z-[200] transition-opacity duration-300"></div>

<div id="umModal" class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[min(650px,calc(100vw-2rem))] bg-navy2 border border-white/10 rounded-2xl shadow-[0_0_50px_rgba(0,0,0,0.85)] z-[201] overflow-hidden transform scale-95 transition-all duration-300 flex flex-col max-h-[90vh]">
    
    {{-- Header --}}
    <div class="flex items-center gap-4 px-6 py-5 border-b border-white/5 bg-white/5 shrink-0">
        <div class="w-12 h-12 rounded-xl bg-blue/10 border border-blue/20 flex items-center justify-center text-blue text-xl shrink-0 shadow-[0_0_15px_rgba(180,180,254,0.2)]">
            <i class="fas fa-user-cog" id="modalIcon"></i>
        </div>
        <div class="flex-1">
            <div class="font-black text-sm text-white uppercase tracking-widest" id="modalTitle">Manage User Account</div>
            <div class="text-[0.65rem] text-white/50 uppercase tracking-wider font-bold mt-1" id="modalSubtitle">Configure Roles, Profile & Access Permissions</div>
        </div>
        <button onclick="closeUmModal()" class="text-white/40 hover:text-white transition-colors text-lg focus:outline-none">
            <i class="fas fa-times"></i>
        </button>
    </div>

    {{-- Tabs Bar --}}
    <div class="flex border-b border-white/5 bg-navy3/40 px-6 py-2 shrink-0">
        <button type="button" onclick="switchTab('tab-account')" id="btn-tab-account" class="tab-btn px-4 py-2 text-[0.65rem] font-black uppercase tracking-wider border-b-2 border-blue text-blue transition-all mr-2">
            1. Account & Info
        </button>
        <button type="button" onclick="switchTab('tab-access')" id="btn-tab-access" class="tab-btn px-4 py-2 text-[0.65rem] font-black uppercase tracking-wider border-b-2 border-transparent text-white/40 hover:text-white/80 transition-all mr-2">
            2. Courts & Permissions
        </button>
        <button type="button" onclick="switchTab('tab-profile')" id="btn-tab-profile" class="tab-btn px-4 py-2 text-[0.65rem] font-black uppercase tracking-wider border-b-2 border-transparent text-white/40 hover:text-white/80 transition-all">
            3. Professional Profile
        </button>
    </div>

    {{-- Form --}}
    <form id="umForm" onsubmit="submitUmForm(event)" class="flex flex-col flex-1 overflow-hidden">
        @csrf
        <input type="hidden" id="form_mode" value="add">
        <input type="hidden" id="user_id" value="">

        {{-- Scrollable Container --}}
        <div class="p-6 overflow-y-auto space-y-6 flex-1 bg-navy/20">

            {{-- Tab 1: Account --}}
            <div id="tab-account" class="tab-pane space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Name --}}
                    <div class="flex flex-col">
                        <label class="text-[0.6rem] font-black uppercase tracking-wider text-white/50 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" id="user_name" name="name" required class="bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-all" placeholder="John Doe">
                    </div>
                    {{-- Email --}}
                    <div class="flex flex-col">
                        <label class="text-[0.6rem] font-black uppercase tracking-wider text-white/50 mb-1.5">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" id="user_email" name="email" required class="bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-all" placeholder="john@example.com">
                    </div>
                    {{-- Phone --}}
                    <div class="flex flex-col">
                        <label class="text-[0.6rem] font-black uppercase tracking-wider text-white/50 mb-1.5">Phone Number</label>
                        <input type="text" id="user_phone" name="phone" class="bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-all" placeholder="9876543210">
                    </div>
                    {{-- Password --}}
                    <div class="flex flex-col">
                        <label id="pwd_label" class="text-[0.6rem] font-black uppercase tracking-wider text-white/50 mb-1.5">Password <span class="text-red-500">*</span></label>
                        <input type="password" id="user_password" name="password" class="bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-blue focus:ring-1 focus:ring-blue transition-all" placeholder="••••••••">
                        <span id="pwd_help" class="text-[0.55rem] text-white/30 font-bold mt-1">Minimum 8 characters.</span>
                    </div>
                    {{-- Role --}}
                    <div class="flex flex-col">
                        <label class="text-[0.6rem] font-black uppercase tracking-wider text-white/50 mb-1.5">User System Role <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="user_role" name="role" required onchange="handleRoleChange()" class="w-full bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-blue appearance-none">
                                {{-- Dynamically Loaded --}}
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-white/30 text-xs pointer-events-none"></i>
                        </div>
                    </div>
                    {{-- Status --}}
                    <div class="flex flex-col">
                        <label class="text-[0.6rem] font-black uppercase tracking-wider text-white/50 mb-1.5">Account Status <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="user_status" name="status" required class="w-full bg-navy border border-white/10 rounded-xl px-4 py-2.5 text-white text-xs focus:outline-none focus:border-blue appearance-none">
                                <option value="active">Active</option>
                                <option value="pending">Pending Review</option>
                                <option value="rejected">Suspended / Rejected</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-white/30 text-xs pointer-events-none"></i>
                        </div>
                    </div>
                </div>

                {{-- Contact Details / Address --}}
                <div class="bg-navy3/40 rounded-xl border border-white/5 p-4 space-y-4">
                    <div class="text-[0.65rem] font-black uppercase tracking-widest text-white/40"><i class="fas fa-map-marked-alt mr-1"></i> Office / Contact Address</div>
                    <div class="flex flex-col">
                        <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/40 mb-1">Street Address</label>
                        <input type="text" id="user_address" name="address" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none focus:border-blue transition-all" placeholder="123 Office Block, MG Road">
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div class="flex flex-col">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/40 mb-1">City</label>
                            <input type="text" id="user_city" name="city" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none focus:border-blue transition-all" placeholder="Mumbai">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/40 mb-1">State</label>
                            <input type="text" id="user_state" name="state" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none focus:border-blue transition-all" placeholder="Maharashtra">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/40 mb-1">Pincode</label>
                            <input type="text" id="user_pincode" name="pincode" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none focus:border-blue transition-all" placeholder="400001">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab 2: Access & Courts --}}
            <div id="tab-access" class="tab-pane space-y-5 hidden">
                {{-- Associated Courts --}}
                <div class="space-y-2">
                    <label class="text-[0.6rem] font-black uppercase tracking-wider text-white/50 block">Associated Courts Assignment</label>
                    <p class="text-[0.55rem] text-white/40 font-bold uppercase tracking-wide">Assign one or more judicial courts. Clerks are assigned to a single primary court (first choice).</p>
                    
                    <div class="bg-navy rounded-xl border border-white/10 p-3 shadow-inner">
                        <div class="relative mb-2">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-white/20 text-xs"></i>
                            <input type="text" id="courtFilter" onkeyup="filterCourts()" placeholder="Filter registered courts..." class="w-full pl-9 pr-4 py-1.5 bg-navy2 border border-white/5 rounded-lg text-white text-xs focus:outline-none transition-colors">
                        </div>
                        
                        <div class="max-h-40 overflow-y-auto space-y-1.5 pr-2" id="courtListContainer">
                            {{-- Dynamically Loaded Checkboxes --}}
                        </div>
                    </div>
                </div>

                {{-- Direct Permissions --}}
                <div class="space-y-2">
                    <label class="text-[0.6rem] font-black uppercase tracking-wider text-white/50 block">Direct Account Permissions</label>
                    <p class="text-[0.55rem] text-white/40 font-bold uppercase tracking-wide">Grant custom permissions directly to this user account (in addition to role defaults).</p>

                    <div class="bg-navy rounded-xl border border-white/10 p-3 shadow-inner">
                        <div class="relative mb-2">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-white/20 text-xs"></i>
                            <input type="text" id="permissionFilter" onkeyup="filterPermissions()" placeholder="Search available permissions..." class="w-full pl-9 pr-4 py-1.5 bg-navy2 border border-white/5 rounded-lg text-white text-xs focus:outline-none transition-colors">
                        </div>
                        
                        <div class="max-h-48 overflow-y-auto grid grid-cols-1 sm:grid-cols-2 gap-2 pr-2" id="permissionListContainer">
                            {{-- Dynamically Loaded Checkboxes --}}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab 3: Profile Details --}}
            <div id="tab-profile" class="tab-pane space-y-5 hidden">
                <div id="no-profile-msg" class="py-12 text-center bg-navy3/40 border border-white/5 rounded-xl">
                    <i class="fas fa-user-tag text-white/10 text-3xl mb-3 block"></i>
                    <p class="text-white/40 font-black uppercase tracking-widest text-[0.65rem]">No profile requirements</p>
                    <p class="text-[0.55rem] text-white/30 uppercase tracking-widest mt-1 font-bold">This role does not require verified corporate or professional profiles.</p>
                </div>

                {{-- Advocate Profile Fields --}}
                <div id="profile-advocate-pane" class="space-y-4 hidden">
                    <div class="flex items-center gap-2 text-[0.65rem] font-black uppercase tracking-widest text-blue mb-1 border-b border-white/5 pb-2">
                        <i class="fas fa-balance-scale"></i> Advocate Registration Information
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex flex-col">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/50 mb-1">Bar Council Number</label>
                            <input type="text" name="bar_council_number" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none" placeholder="BC/12345/2020">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/50 mb-1">Enrollment Number</label>
                            <input type="text" name="enrollment_number" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none" placeholder="ENR-99911A">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/50 mb-1">Enrollment Date</label>
                            <input type="date" name="enrollment_date" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/50 mb-1">High Court Association</label>
                            <input type="text" name="high_court" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none" placeholder="Bombay High Court">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/50 mb-1">Experience (Years)</label>
                            <input type="number" name="experience_years" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none" placeholder="5">
                        </div>
                        <div class="flex flex-col sm:col-span-2">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/50 mb-1">Short Profile Bio</label>
                            <textarea name="bio" rows="2" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none resize-none" placeholder="Brief details about practice areas and achievements..."></textarea>
                        </div>
                        <div class="flex flex-col sm:col-span-2">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/50 mb-1">Office Address</label>
                            <input type="text" name="office_address" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none" placeholder="Chamber 405, Court Complex">
                        </div>
                    </div>
                </div>

                {{-- Clerk Profile Fields --}}
                <div id="profile-clerk-pane" class="space-y-4 hidden">
                    <div class="flex items-center gap-2 text-[0.65rem] font-black uppercase tracking-widest text-purple-400 mb-1 border-b border-white/5 pb-2">
                        <i class="fas fa-clipboard-list"></i> Clerk / Support Staff Record
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex flex-col">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/50 mb-1">Clerk ID Number</label>
                            <input type="text" name="clerk_id_number" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none" placeholder="CLK-90812">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/50 mb-1">Associated Court Name</label>
                            <input type="text" name="court_name" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none" placeholder="District & Sessions Court">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/50 mb-1">Court City</label>
                            <input type="text" name="court_city" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none" placeholder="Pune">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/50 mb-1">Court State</label>
                            <input type="text" name="court_state" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none" placeholder="Maharashtra">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/50 mb-1">Department / Branch</label>
                            <input type="text" name="department" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none" placeholder="Civil Division">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/50 mb-1">Experience (Years)</label>
                            <input type="number" name="clerk_experience_years" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none" placeholder="3">
                        </div>
                        <div class="flex flex-col sm:col-span-2">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/50 mb-1">Short Bio</label>
                            <textarea name="clerk_bio" rows="2" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none resize-none" placeholder="Brief details about case management experience..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- CA Profile Fields --}}
                <div id="profile-ca-pane" class="space-y-4 hidden">
                    <div class="flex items-center gap-2 text-[0.65rem] font-black uppercase tracking-widest text-amber-400 mb-1 border-b border-white/5 pb-2">
                        <i class="fas fa-calculator"></i> CA / CS Associate Details
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex flex-col">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/50 mb-1">Membership Number</label>
                            <input type="text" name="membership_number" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none" placeholder="M-102931">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/50 mb-1">ICAI Region</label>
                            <input type="text" name="icai_region" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none" placeholder="WIRC">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/50 mb-1">Membership Date</label>
                            <input type="date" name="membership_date" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/50 mb-1">Firm Name</label>
                            <input type="text" name="firm_name" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none" placeholder="KP Associates & Co.">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/50 mb-1">Experience (Years)</label>
                            <input type="number" name="ca_experience_years" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none" placeholder="8">
                        </div>
                        <div class="flex flex-col sm:col-span-2">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/50 mb-1">Office Address</label>
                            <input type="text" name="ca_office_address" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none" placeholder="Office 12, Floor 3, Premium Square">
                        </div>
                        <div class="flex flex-col sm:col-span-2">
                            <label class="text-[0.55rem] font-black uppercase tracking-wider text-white/50 mb-1">Short Profile Bio</label>
                            <textarea name="ca_bio" rows="2" class="bg-navy border border-white/10 rounded-xl px-4 py-2 text-white text-xs focus:outline-none resize-none" placeholder="Details about corporate auditing, tax specializations..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Footer --}}
        <div class="flex items-center gap-3 px-6 py-5 border-t border-white/5 bg-navy shrink-0">
            <button type="button" id="umDeleteBtn" onclick="deleteUser()" class="hidden mr-auto flex items-center gap-2 px-4 py-3 text-[0.65rem] font-black uppercase tracking-widest bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white border border-red-500/20 hover:border-transparent rounded-xl transition-all shadow-[0_5px_15px_rgba(239,68,68,0.15)]">
                <i class="fas fa-trash-alt"></i> Delete User
            </button>

            <button type="button" onclick="closeUmModal()" class="px-6 py-3 text-[0.65rem] font-black uppercase tracking-widest border border-white/10 rounded-xl hover:bg-white/5 text-white/70 hover:text-white transition-all">Cancel</button>
            <button type="submit" id="umSubmitBtn" class="flex items-center gap-2 px-6 py-3 text-[0.65rem] font-black uppercase tracking-widest bg-green-500 hover:bg-green-400 text-navy rounded-xl transition-all shadow-[0_5px_15px_rgba(34,197,94,0.2)]">
                <i class="fas fa-save" id="submitIcon"></i> <span id="submitText">Save Details</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // In-memory data holds
    let _allCourts = [];
    let _allPermissions = [];
    let _allRoles = [];

    // Switch Tabs inside Modal
    function switchTab(tabId) {
        // Toggle tab buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            if (btn.id === `btn-${tabId}`) {
                btn.classList.add('border-blue', 'text-blue');
                btn.classList.remove('border-transparent', 'text-white/40');
            } else {
                btn.classList.remove('border-blue', 'text-blue');
                btn.classList.add('border-transparent', 'text-white/40');
            }
        });

        // Toggle pane contents
        document.querySelectorAll('.tab-pane').forEach(pane => {
            if (pane.id === tabId) {
                pane.classList.remove('hidden');
            } else {
                pane.classList.add('hidden');
            }
        });
    }

    // Toggle Profile Fields under Tab 3 based on role
    function handleRoleChange() {
        const role = document.getElementById('user_role').value;
        
        // Hide all
        document.getElementById('no-profile-msg').classList.add('hidden');
        document.getElementById('profile-advocate-pane').classList.add('hidden');
        document.getElementById('profile-clerk-pane').classList.add('hidden');
        document.getElementById('profile-ca-pane').classList.add('hidden');

        // Show matching
        if (role === 'advocate') {
            document.getElementById('profile-advocate-pane').classList.remove('hidden');
        } else if (role === 'court_clerk' || role === 'ip_clerk') {
            document.getElementById('profile-clerk-pane').classList.remove('hidden');
        } else if (role === 'ca_cs') {
            document.getElementById('profile-ca-pane').classList.remove('hidden');
        } else {
            document.getElementById('no-profile-msg').classList.remove('hidden');
        }
    }

    // Open Modal for Add
    function openAddUserModal() {
        document.getElementById('umForm').reset();
        document.getElementById('form_mode').value = 'add';
        document.getElementById('user_id').value = '';
        
        document.getElementById('modalTitle').textContent = 'Add New User';
        document.getElementById('modalSubtitle').textContent = 'Register a new participant and configure system access';
        
        document.getElementById('pwd_label').innerHTML = 'Password <span class="text-red-500">*</span>';
        document.getElementById('user_password').required = true;

        document.getElementById('umDeleteBtn').classList.add('hidden');
        document.getElementById('submitText').textContent = 'Create User';
        
        switchTab('tab-account');

        // Fetch Metadata via AJAX
        fetch("{{ route('admin.manage.users.create-data') }}")
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                _allCourts = data.allCourts;
                _allPermissions = data.allPermissions;
                _allRoles = data.allRoles;

                populateMetadataOptions([], []);
                handleRoleChange();
                showOverlayAndModal();
            }
        });
    }

    // Open Modal for Edit
    function openManageUser(userId) {
        document.getElementById('umForm').reset();
        document.getElementById('form_mode').value = 'edit';
        document.getElementById('user_id').value = userId;

        document.getElementById('modalTitle').textContent = 'Manage User Account';
        document.getElementById('modalSubtitle').textContent = 'Modify personal profile details, roles and security clearance';

        document.getElementById('pwd_label').innerHTML = 'Password (Optional)';
        document.getElementById('user_password').required = false;

        document.getElementById('umDeleteBtn').classList.remove('hidden');
        document.getElementById('submitText').textContent = 'Save Changes';

        switchTab('tab-account');

        // Fetch User details and metadata via AJAX
        const editUrl = `{{ url('/admin/manage/users') }}/${userId}/edit-data`;
        fetch(editUrl)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const user = data.user;
                _allCourts = data.allCourts;
                _allPermissions = data.allPermissions;
                _allRoles = data.allRoles;

                // Prepopulate user details
                document.getElementById('user_name').value = user.name;
                document.getElementById('user_email').value = user.email;
                document.getElementById('user_phone').value = user.phone || '';
                document.getElementById('user_status').value = user.status;
                document.getElementById('user_address').value = user.address || '';
                document.getElementById('user_city').value = user.city || '';
                document.getElementById('user_state').value = user.state || '';
                document.getElementById('user_pincode').value = user.pincode || '';

                populateMetadataOptions(data.userRoles, data.userDirectPermissions, user.court_ids);

                // Populate profile-specific fields
                if (user.role === 'advocate' && user.advocate_profile) {
                    const prof = user.advocate_profile;
                    document.querySelector('[name="bar_council_number"]').value = prof.bar_council_number || '';
                    document.querySelector('[name="enrollment_number"]').value = prof.enrollment_number || '';
                    document.querySelector('[name="enrollment_date"]').value = prof.enrollment_date || '';
                    document.querySelector('[name="high_court"]').value = prof.high_court || '';
                    document.querySelector('[name="experience_years"]').value = prof.experience_years || 0;
                    document.querySelector('[name="bio"]').value = prof.bio || '';
                    document.querySelector('[name="office_address"]').value = prof.office_address || '';
                } else if ((user.role === 'court_clerk' || user.role === 'ip_clerk') && user.clerk_profile) {
                    const prof = user.clerk_profile;
                    document.querySelector('[name="clerk_id_number"]').value = prof.clerk_id_number || '';
                    document.querySelector('[name="court_name"]').value = prof.court_name || '';
                    document.querySelector('[name="court_city"]').value = prof.court_city || '';
                    document.querySelector('[name="court_state"]').value = prof.court_state || '';
                    document.querySelector('[name="department"]').value = prof.department || '';
                    document.querySelector('[name="clerk_experience_years"]').value = prof.experience_years || 0;
                    document.querySelector('[name="clerk_bio"]').value = prof.bio || '';
                } else if (user.role === 'ca_cs' && user.ca_profile) {
                    const prof = user.ca_profile;
                    document.querySelector('[name="membership_number"]').value = prof.membership_number || '';
                    document.querySelector('[name="icai_region"]').value = prof.icai_region || '';
                    document.querySelector('[name="membership_date"]').value = prof.membership_date || '';
                    document.querySelector('[name="firm_name"]').value = prof.firm_name || '';
                    document.querySelector('[name="ca_experience_years"]').value = prof.experience_years || 0;
                    document.querySelector('[name="ca_office_address"]').value = prof.office_address || '';
                    document.querySelector('[name="ca_bio"]').value = prof.bio || '';
                }

                handleRoleChange();
                showOverlayAndModal();
            }
        });
    }

    // Populate Metadata (Dropdown, Courts checklist, Permissions checklist)
    function populateMetadataOptions(assignedRoles, directPermissions, assignedCourtIds = []) {
        assignedCourtIds = assignedCourtIds || [];
        
        // Roles dropdown
        const roleSel = document.getElementById('user_role');
        roleSel.innerHTML = '';
        _allRoles.forEach(r => {
            const opt = document.createElement('option');
            opt.value = r;
            opt.textContent = r.replace('_', ' ').toUpperCase();
            if (assignedRoles.includes(r)) {
                opt.selected = true;
            }
            roleSel.appendChild(opt);
        });

        // Courts checkboxes
        const courtList = document.getElementById('courtListContainer');
        courtList.innerHTML = '';
        _allCourts.forEach(c => {
            const checked = assignedCourtIds.includes(c.id) ? 'checked' : '';
            const item = `
                <label class="court-item flex items-center gap-3 px-3 py-2 bg-navy2/50 hover:bg-navy2 border border-white/5 rounded-lg text-xs font-bold text-white/70 hover:text-white cursor-pointer transition-colors">
                    <input type="checkbox" name="court_ids[]" value="${c.id}" ${checked} class="accent-blue rounded border-white/10 bg-navy">
                    <span class="flex-1">${c.name} <span class="text-white/30 text-[0.6rem] font-normal uppercase ml-1">(${c.city})</span></span>
                </label>
            `;
            courtList.insertAdjacentHTML('beforeend', item);
        });

        // Permissions checkboxes
        const permList = document.getElementById('permissionListContainer');
        permList.innerHTML = '';
        _allPermissions.forEach(p => {
            const checked = directPermissions.includes(p) ? 'checked' : '';
            const item = `
                <label class="permission-item flex items-center gap-3 px-3 py-2 bg-navy2/50 hover:bg-navy2 border border-white/5 rounded-lg text-[0.65rem] font-bold text-white/70 hover:text-white cursor-pointer transition-colors">
                    <input type="checkbox" name="permissions[]" value="${p}" ${checked} class="accent-blue rounded border-white/10 bg-navy">
                    <span>${p}</span>
                </label>
            `;
            permList.insertAdjacentHTML('beforeend', item);
        });
    }

    // Search filters
    function filterCourts() {
        const query = document.getElementById('courtFilter').value.toLowerCase();
        document.querySelectorAll('.court-item').forEach(el => {
            const text = el.textContent.toLowerCase();
            if (text.includes(query)) {
                el.classList.remove('hidden');
            } else {
                el.classList.add('hidden');
            }
        });
    }

    function filterPermissions() {
        const query = document.getElementById('permissionFilter').value.toLowerCase();
        document.querySelectorAll('.permission-item').forEach(el => {
            const text = el.textContent.toLowerCase();
            if (text.includes(query)) {
                el.classList.remove('hidden');
            } else {
                el.classList.add('hidden');
            }
        });
    }

    // Modal Show/Hide transitions
    function showOverlayAndModal() {
        const overlay = document.getElementById('umOverlay');
        const modal = document.getElementById('umModal');

        overlay.classList.remove('hidden');
        modal.classList.remove('hidden');
        setTimeout(() => {
            overlay.classList.remove('opacity-0');
            modal.classList.remove('scale-95');
            modal.classList.add('scale-100');
        }, 10);
    }

    function closeUmModal() {
        const overlay = document.getElementById('umOverlay');
        const modal = document.getElementById('umModal');

        overlay.classList.add('opacity-0');
        modal.classList.remove('scale-100');
        modal.classList.add('scale-95');

        setTimeout(() => {
            overlay.classList.add('hidden');
            modal.classList.add('hidden');
        }, 300);
    }

    // Submit User Form (Add or Edit)
    function submitUmForm(e) {
        e.preventDefault();
        const mode = document.getElementById('form_mode').value;
        const userId = document.getElementById('user_id').value;

        const btn = document.getElementById('umSubmitBtn');
        const originalText = document.getElementById('submitText').textContent;
        const icon = document.getElementById('submitIcon');
        
        btn.disabled = true;
        icon.className = 'fas fa-spinner fa-spin mr-1';
        document.getElementById('submitText').textContent = 'Saving...';

        const form = document.getElementById('umForm');
        const formData = new FormData(form);
        const data = {};

        // Parse standard properties
        formData.forEach((val, key) => {
            if (key.endsWith('[]')) {
                const pureKey = key.slice(0, -2);
                if (!data[pureKey]) data[pureKey] = [];
                data[pureKey].push(val);
            } else {
                data[key] = val;
            }
        });

        // Remap checkboxes if they were not checked (browser doesn't submit empty checkboxes)
        if (!data['court_ids']) data['court_ids'] = [];
        if (!data['permissions']) data['permissions'] = [];

        // Fetch multi-select checkboxes specifically since FormData is tricky with empty checkboxes
        form.querySelectorAll('input[name="court_ids[]"]:checked').forEach(cb => {
            if(!data['court_ids'].includes(cb.value)) data['court_ids'].push(cb.value);
        });
        form.querySelectorAll('input[name="permissions[]"]:checked').forEach(cb => {
            if(!data['permissions'].includes(cb.value)) data['permissions'].push(cb.value);
        });

        // Remap clerk experience and bio fields to generic fields
        const role = data['role'];
        if (role === 'court_clerk' || role === 'ip_clerk') {
            data['experience_years'] = formData.get('clerk_experience_years');
            data['bio'] = formData.get('clerk_bio');
        } else if (role === 'ca_cs') {
            data['experience_years'] = formData.get('ca_experience_years');
            data['bio'] = formData.get('ca_bio');
            data['office_address'] = formData.get('ca_office_address');
        }

        const url = mode === 'add' 
            ? "{{ route('admin.manage.users.store') }}" 
            : `{{ url('/admin/manage/users') }}/${userId}`;
            
        const method = mode === 'add' ? 'POST' : 'PUT';

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-HTTP-Method-Override': method
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(resData => {
            if (resData.success) {
                if (typeof showToast === 'function') {
                    showToast(resData.message || "User saved successfully!", "ok");
                } else {
                    alert(resData.message || "User saved successfully!");
                }
                closeUmModal();
                setTimeout(() => window.location.reload(), 800);
            } else {
                throw new Error(resData.message || "Failed to save user details.");
            }
        })
        .catch(err => {
            console.error(err);
            if (typeof showToast === 'function') {
                showToast(err.message || "An error occurred.", "err");
            } else {
                alert(err.message || "An error occurred.");
            }
        })
        .finally(() => {
            btn.disabled = false;
            icon.className = 'fas fa-save';
            document.getElementById('submitText').textContent = originalText;
        });
    }

    // Toggle User Status
    function toggleStatus(userId) {
        if (confirm("Are you sure you want to change this user's activation status?")) {
            const url = `{{ url('/admin/manage/users') }}/${userId}/toggle-status`;
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-HTTP-Method-Override': 'PATCH'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (typeof showToast === 'function') {
                        showToast(data.message || "Status updated!", "ok");
                    } else {
                        alert(data.message || "Status updated!");
                    }
                    setTimeout(() => window.location.reload(), 600);
                } else {
                    throw new Error(data.message || "Failed to update status.");
                }
            })
            .catch(err => {
                console.error(err);
                if (typeof showToast === 'function') {
                    showToast(err.message || "Error updating status.", "err");
                } else {
                    alert(err.message || "Error updating status.");
                }
            });
        }
    }

    // Delete User
    function deleteUser() {
        const userId = document.getElementById('user_id').value;
        const name = document.getElementById('user_name').value;
        
        if (confirm(`CRITICAL WARNING: Are you sure you want to permanently delete user "${name}"?\nThis action cannot be undone and will erase all connections, feedbacks and profile records associated with this user.`)) {
            const url = `{{ url('/admin/manage/users') }}/${userId}`;
            
            const btn = document.getElementById('umDeleteBtn');
            const originalHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Deleting...';

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-HTTP-Method-Override': 'DELETE'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (typeof showToast === 'function') {
                        showToast(data.message || "User deleted.", "ok");
                    } else {
                        alert(data.message || "User deleted.");
                    }
                    closeUmModal();
                    setTimeout(() => window.location.reload(), 600);
                } else {
                    throw new Error(data.message || "Failed to delete user.");
                }
            })
            .catch(err => {
                console.error(err);
                btn.disabled = false;
                btn.innerHTML = originalHtml;
                if (typeof showToast === 'function') {
                    showToast(err.message || "Error deleting user.", "err");
                } else {
                    alert(err.message || "Error deleting user.");
                }
            });
        }
    }

    // Compatibility wrappers for Dashboard verification queue
    function openVerify(id, name, role, email, phone, court, city) {
        openManageUser(id);
    }

    // Deactivation wrapper for dashboard / verification
    function openReject(id, name) {
        toggleStatus(id);
    }
</script>
@endpush
