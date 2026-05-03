@extends('admin.layouts.app')
@section('title', 'New User')
@section('subtitle', 'Create a new account')

@section('content')
<div style="max-width:700px">
    <a href="{{ route('admin.users.index') }}" class="btn-secondary" style="margin-bottom:20px;display:inline-flex">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back
    </a>
    <form method="POST" action="{{ route('admin.users.store') }}" style="display:flex;flex-direction:column;gap:16px">
        @csrf
        <div class="form-card">
            <div class="form-section">General Information</div>
            <div class="grid2">
                <div class="field">
                    <label>Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Mohamed Alami">
                    @error('name')<p class="err">{{ $message }}</p>@enderror
                </div>
                <div class="field">
                    <label>Role</label>
                    <select name="role" id="role-select" onchange="toggleFields()" required>
                        <option value="">Select role...</option>
                        @foreach(['admin','medecin','secretaire','patient'] as $r)
                            <option value="{{ $r }}" @selected(old('role')===$r)>{{ ucfirst($r) }}</option>
                        @endforeach
                    </select>
                    @error('role')<p class="err">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="field">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="example@cabinet.ma">
                @error('email')<p class="err">{{ $message }}</p>@enderror
            </div>
            <div class="grid2">
                <div class="field">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="Min. 8 characters">
                    @error('password')<p class="err">{{ $message }}</p>@enderror
                </div>
                <div class="field">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" required placeholder="Repeat password">
                </div>
            </div>
            <div class="field">
                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="0600000000">
            </div>
        </div>

        <div class="form-card" id="fields-medecin" style="display:none">
            <div class="form-section">Doctor Information</div>
            <div class="grid2">
                <div class="field">
                    <label>Speciality</label>
                    <select name="specialite_id">
                        <option value="">Select...</option>
                        @foreach($specialites as $s)
                            <option value="{{ $s->id }}" @selected(old('specialite_id')==$s->id)>{{ $s->nom }}</option>
                        @endforeach
                    </select>
                    @error('specialite_id')<p class="err">{{ $message }}</p>@enderror
                </div>
                <div class="field">
                    <label>Office Phone</label>
                    <input type="text" name="telephone" value="{{ old('telephone') }}" placeholder="0522000000">
                </div>
            </div>
        </div>

        <div class="form-card" id="fields-patient" style="display:none">
            <div class="form-section">Patient Information</div>
            <div class="grid3">
                <div class="field">
                    <label>Birth Date</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date') }}">
                </div>
                <div class="field">
                    <label>Gender</label>
                    <select name="gender">
                        <option value="">—</option>
                        <option value="M" @selected(old('gender')==='M')>Male</option>
                        <option value="F" @selected(old('gender')==='F')>Female</option>
                    </select>
                </div>
                <div class="field">
                    <label>Blood Type</label>
                    <input type="text" name="blood_type" value="{{ old('blood_type') }}" placeholder="A+, O-...">
                </div>
            </div>
            <div class="grid2">
                <div class="field">
                    <label>Emergency Contact</label>
                    <input type="text" name="emergency_contact" value="{{ old('emergency_contact') }}">
                </div>
                <div class="field">
                    <label>Emergency Phone</label>
                    <input type="text" name="emergency_phone" value="{{ old('emergency_phone') }}">
                </div>
            </div>
        </div>

        <div style="display:flex;gap:10px;flex-wrap:wrap">
            <button type="submit" class="btn-primary" style="padding:12px 24px;font-size:14px">Create User</button>
            <a href="{{ route('admin.users.index') }}" class="btn-secondary" style="padding:12px 24px;font-size:14px">Cancel</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function toggleFields(){
    const r = document.getElementById('role-select').value;
    document.getElementById('fields-medecin').style.display = r==='medecin' ? 'block' : 'none';
    document.getElementById('fields-patient').style.display = r==='patient' ? 'block' : 'none';
}
document.addEventListener('DOMContentLoaded', toggleFields);
</script>
@endpush
@endsection