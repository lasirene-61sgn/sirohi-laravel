@extends('admin.layout.app')

@section('content')
<div class="container mt-5">
    <h2>Create Mobile Index Slides</h2>

    <form action="{{ route('admin.mobile_index.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf

        <div id="image-upload-wrapper">
            <div class="row align-items-center mb-3 image-row">
                <div class="col-md-6">
                    <label class="form-label">Select Image</label>
                    <input type="file" name="mobile_images[]" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Show Duration (Seconds)</label>
                    <input type="number" name="image_seconds[]" class="form-control" value="5" min="1" required>
                </div>
                <div class="col-md-2 mt-4">
                    <button type="button" class="btn btn-danger remove-row-btn d-none">Remove</button>
                </div>
            </div>
        </div>

        <button type="button" id="add-more-btn" class="btn btn-secondary btn-sm mb-4">+ Add More Images</button>

        <div class="mt-3">
            <button type="submit" class="btn btn-success">Save Configurations</button>
            <a href="{{ route('admin.mobile_index.index') }}" class="btn btn-light">Cancel</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('add-more-btn').addEventListener('click', function() {
        let wrapper = document.getElementById('image-upload-wrapper');
        let newRow = wrapper.querySelector('.image-row').cloneNode(true);
        
        // Reset dynamic values
        newRow.querySelector('input[type="file"]').value = '';
        newRow.querySelector('input[type="number"]').value = '5';
        
        // Show row removal option if expanded
        let removeBtn = newRow.querySelector('.remove-row-btn');
        removeBtn.classList.remove('d-none');
        
        removeBtn.addEventListener('click', function() {
            newRow.remove();
        });

        wrapper.appendChild(newRow);
    });
</script>
@endsection