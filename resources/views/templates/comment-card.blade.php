<div class="card mt-2" style="background-color: #f8f9fa;">
    <div class="card-body">
        <a href="{{ route('profile', $row_user->id) }}" class="text-decoration-none link-dark">
            <div class="other d-flex align-items-center">
                <div class="img-container d-flex" style="height:35px; width:35px;">
                    <img src="{{ $user->photo ? asset(str_replace('public/', 'storage/', $user->photo)) : asset('images/user_male.jpg') }}"
                        style="width:100%; height:100%; object-fit: contain;"
                        class="rounded-circle border border-1 border-secondary" alt="Profile Picture">
                </div>
                <div class="ms-2">
                    <p class="fs-6 m-0">{{ $row_user->email }}</p>
                    <p class="card-text my-auto text-muted fs-6">{{ $comm->created_at }}</p>
                </div>
            </div>
        </a>
        <p class="card-text mt-2 comment-text fs-7 mb-0 text-wrap">{{ $comm->description }}</p>
        <div class="footer-comment align-items-center d-flex justify-content-between align-items-center">
            @if(Auth::check())
            @if(Auth::user()->admin == 1 || Auth::user()->id == $row_user->id)
            <form method="POST" action="{{ route('remove-comment', ['commentid'=>$comm->id]) }}">
                @csrf
                <button type="submit" style="border: none; background: none; cursor: pointer; color: #dc3545;">
                    <i class="fa fa-trash"></i>
                </button>
            </form>
            @endif
            @if(Auth::user()->id == $row_user->id || Auth::user()->admin == 1)
                <a href="{{ route('edit-comment', ['commentid' => $comm->id]) }}" style="color: #007bff;">
                    <i class="fa fa-pencil"></i>
                </a>
            @endif
            @endif
            <!-- Comment Edit -->
            <div class="modal fade" id="editCommentModal" tabindex="-1" aria-labelledby="editCommentModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCommentModalLabel">Редагування коментарю</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('edit-comment', ['commentid'=>$comm->id]) }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="editedComment">Відредагуйте свій коментар:</label>
                                    <textarea class="form-control" id="editedComment" name="editedComment"
                                        rows="4">{{ $comm->description }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Зберегти зміни</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
