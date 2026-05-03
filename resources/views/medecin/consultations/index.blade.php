﻿@extends('medecin.layouts.app')

@section('title', 'Consultations')
@section('subtitle', '{{ $consultations->total() }} consultations')

@section('topbar-actions')
  <a href="{{ route('medecin.consultations.create') }}" class="btn-primary">
    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
    <span>New Consultation</span>
  </a>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <h2>{{ $consultations->total() }} Consultations</h2>
  </div>
  <table>
    <thead>
      <tr>
        <th>Patient</th>
        <th>Date</th>
        <th>Summary</th>
        <th>Prescription</th>
        <th style="text-align:right">Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($consultations as $c)
      <tr>
        <td data-label="Patient" style="font-weight:600">
          <div style="display:flex;align-items:center;gap:8px">
            <div class="avatar" style="background:#f0fdf4;color:#059669">
              {{ strtoupper(substr($c->patient->user->name??'?',0,2)) }}
            </div>
            {{ $c->patient->user->name ?? '-' }}
          </div>
        </td>
        <td data-label="Date">
          {{ \Carbon\Carbon::parse($c->date_consultation)->format('d/m/Y') }}
        </td>
        <td data-label="Summary" style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#64748b">
          {{ Str::limit($c->compte_rendu, 60) }}
        </td>
        <td data-label="Prescription">
          @if($c->Prescription)
            <span class="pill pg">Yes</span>
          @else
            <span style="color:#94a3b8;font-size:12px">No</span>
          @endif
        </td>
        <td data-label="Actions">
          <div style="display:flex;justify-content:flex-end;gap:6px;flex-wrap:wrap">
            <a href="{{ route('medecin.consultations.show', $c) }}" class="btn-secondary">
              <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
              View
            </a>
            @if($c->ordonnance)
              <a href="{{ route('medecin.ordonnances.pdf', $c->ordonnance) }}" class="btn-primary" style="padding:7px 10px;font-size:12px">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                PDF
              </a>
            @endif
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="5">
          <div class="empty-state">No consultations found.</div>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
  @if($consultations->hasPages())
  <div class="pagination-wrap">{{ $consultations->links() }}</div>
  @endif
</div>
@endsection