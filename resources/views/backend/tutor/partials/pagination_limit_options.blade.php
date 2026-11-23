@foreach ([25, 50, 100, 150, 200, 250, 300, 350, 400] as $limit)
    <option value="{{ $limit }}" {{ (int) $input === $limit ? 'selected' : '' }}>{{ $limit }}</option>
@endforeach
