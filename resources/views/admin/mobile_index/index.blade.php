@extends('admin.layout.app') {{-- Change this to your actual layout --}}

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Mobile Index Management</h2>
        @if(!$mobileIndex)
            <a href="{{ route('admin.mobile_index.create') }}" class="btn btn-primary">Add New Record</a>
        @else
            <a href="{{ route('admin.mobile_index.edit', $mobileIndex->id) }}" class="btn btn-warning">Edit Record</a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($mobileIndex && !empty($mobileIndex->mobile_images))
        <div class="card">
            <div class="card-body">
                <h5>Current Slide Configurations</h5>
                <div class="row">
                    @foreach($mobileIndex->mobile_images as $imgData)
                        <div class="col-md-3 mb-3 text-center">
                            <div class="border p-2 rounded">
                                <img src="{{ asset('uploads/mobile_index/' . $imgData['image']) }}" class="img-fluid mb-2 rounded" style="height: 150px; object-fit: cover;">
                                <span class="badge bg-secondary d-block">Duration: {{ $imgData['seconds'] ?? 5 }}s</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <form action="{{ route('admin.mobile_index.destroy', $mobileIndex->id) }}" method="POST" class="mt-4" onsubmit="return confirm('Delete everything?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete Complete Record</button>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-info">No active entries found. Please create one.</div>
    @endif
</div>
@endsection