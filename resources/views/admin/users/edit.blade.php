@extends('admin.layouts.app')
@section('title', 'Edit User')
@section('subtitle', $user->name)

@section('content')
<div style="max-width:700px">
    <a href="{{ route('admin.users.index') }}" class="btn-secondary" style="margin-bottom:20px;display:inline-flex">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back
    </a>
    <form method="POST" action="{{ route('admin.users.update', $user) }}" style="display:flex;flex-direction:column;gap:16px">
        @csrf @method('PUT')

        <div class="form-card">
            <div class="form-section">General Information</div>
            <div class="grid2">
                <div class="field">
                    <label>Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')<p class="err">{{ $message }}</p>@enderror
                </div>
                <div class="field">
                    <label>Role</label>
                    <input type="text" value="{{ ucfirst($user->role) }}" disabled style="background:#f1f5f9;color:#64748b">
                </div>
            </div>
            <div class="field">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')<p class="err">{{ $message }}</p>@enderror
            </div>
            <div class="grid2">
                <div class="field">
                    <label>New Password <span style="color:#94a3b8;font-weight:400">(optional)</span></label>
                    <input type="password" name="password" placeholder="Leave blank to keep current">
                    @error('password')<p class="err">{{ $message }}</p>@enderror
                </div>
                <div class="field">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="Repeat password">
                </div>
            </div>
            <div class="grid2">
                <div class="field">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}">
                </div>
                <div class="field">
                    <label>Address</label>
                    <input type="text" name="address" value="{{ old('address', $user->address) }}">
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;margin-top:4px">
                <input type="hidden" name="actif" value="0">
                <input type="checkbox" name="actif" value="1" @checked($user->actif) id="actif"
                       style="width:16px;height:16px;accent-color:#0369a1">
                <label for="actif" style="font-size:13px;color:#374151;cursor:pointer">Account active</label>
            </div>
        </div>

        @if($user->role==='medecin')
        <div class="form-card">
            <div class="form-section">Doctor Information</div>
            <div class="grid2">
                <div class="field">
                    <label>Speciality</label>
                    <select name="specialite_id">
                        @foreach($specialites as $s)
                            <option value="{{ $s->id }}" @selected(old('specialite_id',$user->medecin?->specialite_id)==$s->id)>{{ $s->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>Office Phone</label>
                    <input type="text" name="Phone" value="{{ old('Phone', $user->medecin?->Phone) }}">
                </div>
            </div>
        </div>
        @endif

        @if($user->role==='patient')
        <div class="form-card">
            <div class="form-section">Patient Information</div>
            <div class="grid3">
                <div class="field">
                    <label>Birth Date</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $user->patient?->birth_date?->format('Y-m-d')) }}">
                </div>
                <div class="field">
                    <label>Gender</label>
                    <select name="gender">
                        <option value="">—</option>
                        <option value="M" @selected(old('gender',$user->patient?->gender)==='M')>Male</option>
                        <option value="F" @selected(old('gender',$user->patient?->gender)==='F')>Female</option>
                    </select>
                </div>
                <div class="field">
                    <label>Blood Type</label>
                    <input type="text" name="blood_type" value="{{ old('blood_type', $user->patient?->blood_type) }}">
                </div>
            </div>
            <div class="grid2">
                <div class="field">
                    <label>Emergency Contact</label>
                    <input type="text" name="emergency_contact" value="{{ old('emergency_contact', $user->patient?->emergency_contact) }}">
                </div>
                <div class="field">
                    <label>Emergency Phone</label>
                    <input type="text" name="emergency_phone" value="{{ old('emergency_phone', $user->patient?->emergency_phone) }}">
                </div>
            </div>
        </div>
        @endif

        <div style="display:flex;gap:10px;flex-wrap:wrap">
            <button type="submit" class="btn-primary" style="padding:12px 24px;font-size:14px">Save Changes</button>
            <a href="{{ route('admin.users.index') }}" class="btn-secondary" style="padding:12px 24px;font-size:14px">Cancel</a>
        </div>
    </form>
</div>
@endsection