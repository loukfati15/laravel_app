@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Regions for ') }} {{ $superuser->name }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.updateRegions', $superuser->id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="regions">Select Regions:</label>
                            <select name="region_ids[]" id="regions" class="form-control" multiple>
                                @foreach($allRegions as $region)
                                    <option value="{{ $region->id }}"
                                        @if($superuser->regions->contains($region->id)) selected @endif>
                                        {{ $region->region_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Regions</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inclure jQuery avant Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#regions').select2({
            placeholder: "Select Regions",
            allowClear: true
        });
    });
</script>

@endsection
