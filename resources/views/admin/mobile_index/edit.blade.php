@extends('admin.layout.app')

@section('content')
<div class="container mt-5">
    <h2>Edit Mobile Index Configurations</h2>

    <form action="{{ route('admin.mobile_index.update', $mobileIndex->id) }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf
        @method('PUT')

        @if(!empty($mobileIndex->mobile_images))
            <h5 class="mb-3">Existing Images & Durations</h5>
            <div class="row mb-5">
                @foreach($mobileIndex->mobile_images as $imgData)
                    @php
                        // Safely detect if the entry is the old string format or the new array format
                        $isNewFormat = is_array($imgData);
                        $imageName = $isNewFormat ? ($imgData['image'] ?? '') : $imgData;
                        $seconds = $isNewFormat ? ($imgData['seconds'] ?? 5) : 5;
                    @endphp

                    @if(!empty($imageName))
                        <div class="col-md-4 mb-4 img-card-container" id="card-{{ Str::slug($imageName) }}">
                            <div class="card p-3">
                                <div class="text-center mb-2">
                                    <img src="{{ asset('uploads/mobile_index/' . $imageName) }}" class="img-fluid rounded" style="height: 120px; width: 100%; object-fit: cover;">
                                </div>
                                <div class="mb-2">
                                    <label class="small form-label">Display Duration (Secs)</label>
                                    <input type="number" name="existing_seconds[{{ $imageName }}]" class="form-control" value="{{ $seconds }}" min="1">
                                </div>
                                <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="removeCurrentImage('{{ $imageName }}', '{{ $mobileIndex->id }}')">Remove Image</button>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

        <h5 class="mb-3">Append New Images</h5>
        <div id="new-image-wrapper">
            <div class="row align-items-center mb-3 new-image-row">
                <div class="col-md-6">
                    <label class="form-label d-md-none">Select Image</label>
                    <input type="file" name="mobile_images[]" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label d-md-none">Seconds</label>
                    <input type="number" name="image_seconds[]" class="form-control" placeholder="Seconds" value="5" min="1">
                </div>
                <div class="col-md-2 mt-md-0 mt-2">
                    <button type="button" class="btn btn-danger btn-sm remove-new-row d-none">Remove</button>
                </div>
            </div>
        </div>
        <button type="button" id="append-more-btn" class="btn btn-secondary btn-sm mb-4">+ Add Another Image Slot</button>

        <div class="mt-4 border-top pt-3">
            <button type="submit" class="btn btn-primary">Apply Changes</button>
            <a href="{{ route('admin.mobile_index.index') }}" class="btn btn-light">Back</a>
        </div>
    </form>
</div>

<script>
    // Append new upload slots dynamically
    document.getElementById('append-more-btn').addEventListener('click', function() {
        let wrapper = document.getElementById('new-image-wrapper');
        let newRow = wrapper.querySelector('.new-image-row').cloneNode(true);
        
        // Reset row input states
        newRow.querySelector('input[type="file"]').value = '';
        newRow.querySelector('input[type="number"]').value = '5';
        
        let removeBtn = newRow.querySelector('.remove-new-row');
        removeBtn.classList.remove('d-none');
        removeBtn.addEventListener('click', () => newRow.remove());
        
        wrapper.appendChild(newRow);
    });

    function removeCurrentImage(imageName, recordId) {
    if (!confirm('Are you sure you want to completely remove this image file?')) return;

    // We build the complete URL dynamically using Laravel's route helper
    let url = "{{ route('admin.mobile_index.remove_image', ':id') }}";
    url = url.replace(':id', recordId);

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json' // Explicitly ask Laravel for a JSON response
        },
        body: JSON.stringify({ image_name: imageName })
    })
    .then(response => {
        if (!response.ok) {
            // This helps us see what error code the server returned (e.g. 404, 500)
            throw new Error(`Server returned status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            let safeId = imageName.replace(/[^a-z0-9]/gi, '-').toLowerCase();
            let targetCard = document.getElementById(`card-${safeId}`);
            
            if (targetCard) {
                targetCard.remove();
            } else {
                let fallBackContainers = document.querySelectorAll('.img-card-container');
                fallBackContainers.forEach(container => {
                    if (container.innerHTML.includes(imageName)) {
                        container.remove();
                    }
                });
            }
        } else {
            alert(data.message || 'Error occurred during image removal.');
        }
    })
    .catch((error) => {
        // This will print the exact reason in your browser console (F12)
        console.error('AJAX Error details:', error);
        alert('Network processing failure: ' + error.message);
    });
}   
</script>
@endsection