<div class="sidebar">
    @if (count($data) > 0)
        @foreach ($data as $row)
            <a href="#">{{ $row->subject_name }}</a>
        @endforeach
    @endif
</div>
