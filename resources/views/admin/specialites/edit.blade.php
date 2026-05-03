@extends('admin.layouts.app')
@section('title', 'Edit Speciality')
@section('subtitle', $specialite->nom ?? '')

@section('content')
<div style="max-width:500px">
    <a href="{{ route('admin.specialites.index') }}" class="btn-secondary" style="margin-bottom:20px;display:inline-flex">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back
    </a>
    <div class="form-card">
        <div class="form-section">Edit Speciality</div>
        <form method="POST" action="{{ route('admin.specialites.update', $specialite) }}">
            @csrf @method('PUT')
            <div class="field">
                <label>Speciality Name</label>
                <input type="text" name="nom" value="{{ old('nom', $specialite->nom) }}"
                       required autofocus placeholder="Ex: Cardiology">
                @error('nom')<p class="err">{{ $message }}</p>@enderror
            </div>
            <div style="display:flex;gap:10px;margin-top:8px;flex-wrap:wrap">
                <button type="submit" class="btn-primary" style="padding:12px 24px">Save Changes</button>
                <a href="{{ route('admin.specialites.index') }}" class="btn-secondary" style="padding:12px 24px">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection