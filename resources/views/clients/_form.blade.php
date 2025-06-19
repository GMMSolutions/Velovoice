@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Client Form</h2>
    <form action="{{ route('clients.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="">-- Sélectionner --</option>
                <option value="Particulier" {{ old('status') == 'Particulier' ? 'selected' : '' }}>Particulier</option>
                <option value="Société" {{ old('status') == 'Société' ? 'selected' : '' }}>Société</option>
            </select>
        </div>

        <div class="mb-3" id="society-field" style="display: none;">
            <label for="society" class="form-label">Nom de la société</label>
            <input type="text" class="form-control" id="society" name="society" value="{{ old('society') }}">
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const statusSelect = document.getElementById('status');
    const societyField = document.getElementById('society-field');
    const societyInput = document.getElementById('society');

    function toggleSocietyField() {
        if (statusSelect.value === 'Société') {
            societyField.style.display = 'block';
            societyInput.required = true;
        } else {
            societyField.style.display = 'none';
            societyInput.required = false;
            societyInput.value = '';
        }
    }

    if (statusSelect) {
        // Initial check on page load (important if old value preselects "Société")
        toggleSocietyField();

        // Bind event listener
        statusSelect.addEventListener('change', toggleSocietyField);
    }
});
</script>
@endpush
