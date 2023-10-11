@extends('shared/layout')

@section('content')
    <div class="container mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <form method="post" action="{{ route('update-comment', ['commentid' => $comment->id]) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="editedComment">Редагування коментарію:</label>
                        <textarea class="form-control" id="editedComment" name="editedComment" rows="4">{{ $comment->description }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Зберегти зміни</button>
                </form>
            </div>
        </div>
    </div>
@endsection
