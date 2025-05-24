<div class="d-flex gap-2">
    @isset($Result)
        @isset($item)
            @if ($item->is_checked == 1)
                <div class="edit">
                    <a href="{{ $Result }}">
                        <button class="btn btn-sm btn-success edit-item-btn editBtn">Result</button>
                    </a>
                </div>
            @endisset
        @endif
    @endisset
    @isset($viewModule)
        <div class="view">
            <a href="{{ $viewModule }}">
                <button class="btn btn-sm btn-success view-item-btn editBtn">View</button>
            </a>
        </div>
    @endisset
    @isset($url)
        @canany(['edit-roles', 'edit-users', 'edit-course', 'edit-candidate'])
            <div class="edit">
                <a href="{{ $url }}">
                    <button class="btn btn-sm btn-warning edit-item-btn editBtn">Edit</button>
                </a>
            </div>
        @endcanany
    @endisset
    @isset($deleteUrl)
        @canany(['delete-roles', 'delete-users', 'delete-course', 'delete-candidate'])
            <div class="remove">
                <button delete-url="{{ $deleteUrl }}"class="btn btn-sm btn-danger remove-item-btn removeBtn">Remove</button>
            </div>
        @endcanany
    @endisset

    @isset($Assignment)
        @if (\App\Models\CourseHelpContent::where('courses_master_id', $item->id)->where('type', 'Assignment')->exists())
            <div class="view">
                <a href="{{ $Assignment }}">
                    <button class="btn btn-sm btn-primary view-item-btn editBtn">Assignment</button>
                </a>
            </div>
        @endif

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
