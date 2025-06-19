<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="code" class="form-label">Code *</label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                           id="code" name="code" 
                           value="{{ old('code', $client->code ?? '') }}" required>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="status" class="form-label">Status *</label>
                    <select class="form-select @error('status') is-invalid @enderror" 
                            id="status" name="status" required>
                        <option value="" disabled {{ old('status', $client->status ?? '') == '' ? 'selected' : '' }}>Select status</option>
                        <option value="Indépendant" {{ old('status', $client->status ?? '') == 'Indépendant' ? 'selected' : '' }}>Indépendant</option>
                        <option value="Société" {{ old('status', $client->status ?? '') == 'Société' ? 'selected' : '' }}>Société</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="firstname" class="form-label">First Name *</label>
                    <input type="text" class="form-control @error('firstname') is-invalid @enderror" 
                           id="firstname" name="firstname" 
                           value="{{ old('firstname', $client->firstname ?? '') }}" required>
                    @error('firstname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="lastname" class="form-label">Last Name *</label>
                    <input type="text" class="form-control @error('lastname') is-invalid @enderror" 
                           id="lastname" name="lastname" 
                           value="{{ old('lastname', $client->lastname ?? '') }}" required>
                    @error('lastname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mb-3" id="society-field" style="display: none;">
            <label for="society" class="form-label">Society Name</label>
            <input type="text" class="form-control @error('society') is-invalid @enderror" 
                   id="society" name="society" 
                   value="{{ old('society', $client->society ?? '') }}">
            @error('society')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="street_number" class="form-label">Street Number *</label>
                    <input type="text" class="form-control @error('street_number') is-invalid @enderror" 
                           id="street_number" name="street_number" 
                           value="{{ old('street_number', $client->street_number ?? '') }}" required>
                    @error('street_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="street" class="form-label">Street *</label>
                    <input type="text" class="form-control @error('street') is-invalid @enderror" 
                           id="street" name="street" 
                           value="{{ old('street', $client->street ?? '') }}" required>
                    @error('street')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="CP" class="form-label">Postal Code *</label>
                    <input type="text" class="form-control @error('CP') is-invalid @enderror" 
                           id="CP" name="CP" 
                           value="{{ old('CP', $client->CP ?? '') }}" required>
                    @error('CP')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="city" class="form-label">City *</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                           id="city" name="city" 
                           value="{{ old('city', $client->city ?? '') }}" required>
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Clients
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> {{ $buttonText ?? 'Save' }}
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const societyField = document.getElementById('society-field');
    const societyInput = document.getElementById('society');
    
    function toggleSocietyField() {
        console.log('Status changed to:', statusSelect.value); // Debug line
        
        if (statusSelect.value === 'Société') {
            societyField.style.display = 'block';
            societyInput.required = true;
        } else {
            societyField.style.display = 'none';
            societyInput.required = false;
            societyInput.value = '';
        }
    }
    
    // Set initial state
    toggleSocietyField();
    
    // Add change event listener
    statusSelect.addEventListener('change', toggleSocietyField);
});
</script>