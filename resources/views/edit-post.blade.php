@extends('shared/layout')

@section('content')
    <div class="container mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <form method="post" action="{{ route('update-post', ['postid' => $post->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="editedTitle">Редагування заголовку:</label>
                        <input type="text" class="form-control" id="editedTitle" name="editedTitle" value="{{ $post->title }}">
                    </div>
                    <div class="mb-3">
                        <label for="editedDescription">Редагування опису:</label>
                        <textarea class="form-control" id="editedDescription" name="editedDescription" rows="4">{{ $post->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editedPhoto">Редагування фото:</label>
                        <input type="file" class="form-control" id="editedPhoto" name="editedPhoto" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Зберегти зміни</button>
                </form>
            </div>
        </div>
    </div>
@endsection
