<div class="d-flex gap-2">
    @isset($replyModule)
        <button type="button" class="btn btn-sm btn-primary view-item-btn" data-bs-toggle="modal" data-bs-target="{{ $replyModule }}">
            @if (is_null($item->answered_by))
                Replay
            @else
                {{ $item->answered_by }}
            @endif
        </button>
        <!-- Modal -->
        <div class="modal fade" id="replyModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="replyModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('course_late.reply', $item->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="replyModalLabel{{ $item->id }}">Reply to Late Exam Request</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>{{ $item->comments }}</p>
                            <div class="mb-3">
                                <label for="replyText" class="form-label">Your Answer</label>
                                <textarea class="form-control" id="" name="reply" rows="3" required>{{ $item->replay }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit Reply</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endisset
    @isset($Result)
        <div class="edit">
            <a href="{{ $Result }}">
                <button class="btn btn-sm btn-success edit-item-btn editBtn">Result</button>
            </a>
        </div>
    @endisset
    @isset($url)
        <div class="edit">
            <a href="{{ $url }}">
                <button class="btn btn-sm btn-warning edit-item-btn editBtn">Edit</button>
            </a>
        </div>
    @endisset
    @isset($deleteUrl)
        <div class="remove">
            <button delete-url="{{ $deleteUrl }}"class="btn btn-sm btn-danger remove-item-btn removeBtn">Remove</button>
        </div>
    @endisset
    @isset($viewModule)
        <div class="view">
            <a href="{{ $viewModule }}">
                <button class="btn btn-sm btn-success view-item-btn editBtn">View</button>
            </a>
        </div>
    @endisset
    @isset($viewCandidates)
        <div class="view">
            <a href="{{ $viewCandidates }}">
                <button class="btn btn-sm btn-primary view-item-btn">Entrolled Candidates</button>
            </a>
        </div>
    @endisset
    @isset($helpModule)
        <div class="view">
            <a href="{{ $helpModule }}">
                <button class="btn btn-sm btn-success view-item-btn">Help</button>
            </a>
        </div>
    @endisset
    @if (isset($helpFile) && $helpFile != '' && $helpFile != null)
        <div class="view">
            <a href="{{ $helpFileUrl }}" target="blank">
                <button class="btn btn-sm btn-primary view-item-btn">File</button>
            </a>
        </div>
    @endif

</div>
