@foreach($notes as $note)
    <div class="p-3 bg-light rounded-3 border border-1 border-dark mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <p class="mb-0 text-dark fs-5">{{ $note->author }}</p>
                <p class="text-info" style="font-size: 12px">
                    ID-{{ $note->id }}
                </p>
            </div>
            <div>
                <p>{{ $note->created_at->format('M d, Y') }}</p>
            </div>
        </div>
        <div>
            <p class="mb-0" style="font-size: 16px; color: #3b3c3d">
                {{ $note->title }}
            </p>
            <p>
                {{ $note->details }}
            </p>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <p style="font-size: 16px; color: #3b3c3d">
                    Read More
                </p>
            </div>
            <div>
                <button class="btn btn-primary py-1">Edit</button>
            </div>
        </div>
    </div>
@endforeach
