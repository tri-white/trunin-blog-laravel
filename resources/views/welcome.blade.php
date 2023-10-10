@extends('shared/layout')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('test.css') }}">
    @endpush
@section('content')
  <main>
    @if(Auth::check())
      @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if(session('empty-post'))
          <div class="alert alert-danger">{{ session('empty-post') }}</div>
      @endif
      <div class="container mt-5">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-6 col-md-8 col-sm-12">
            <form method="post" action="{{ route('create-post') }}" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                        <input type="text" name="post-title" class="form-control" placeholder="Заголовок поста">
                    </div>
                <textarea name="post-description" class="form-control" id="contentInput" rows="5"
                  placeholder="Що у вас нового?"></textarea>
                <div class="row d-flex justify-content-between">
                  <div class="col-lg-4 col-md-6 col-sm-12 mt-1">
                    <select name="post-category" class="form-select" aria-label="Категорія" style="width:100%;">
                      <option value="no">Без категорії</option>
                      <option value="StudyScience">Освіта та наука</option>
                      <option value="Entertainment">Розваги</option>
                      <option value="LifeSport">Життя та спорт</option>
                    </select>
                  </div>
                  <div class="col-lg-4 col-md-12 col-sm-12 mt-1">
                    <button type="submit" class="btn btn-outline-primary" style="width:100%;">Опублікувати</button>
                  </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    @endif

     <!-- Search bar -->
     <div class="container mt-5">
    <div class="mb-2 mt-5 col-lg-12 text-center display-5">
          Пошук
        </div>
      <div class="col-lg-8 col-md-10 col-sm-12 mx-auto align-items-center">
        
        <div class="row d-flex justify-content-center">
          <div class="col-lg-8 col-md-10 col-sm-12 text-center">
            <form method="post" action="{{ route('post-search') }}">
              <div class="input-group">
                <input value="{{ $key }}" name="search-input-key" type="search" class="px-3 form-control" placeholder="Пошук..."
                  aria-label="Search" aria-describedby="search-addon" />
                <button type="submit" class="btn btn-outline-dark">Знайти</button>
              </div>
              <div class="d-flex justify-content-around mb-2 mt-2">
                <div class="col-lg-6">
                  <select id="post-category-filter" name="post-category-filter" class="form-select"
                    aria-label="Категорія" style="width:100%;">
                      <option value="all" {{ $cat == 'all' ? 'selected' : '' }}>Всі категорії</option>
                      <option value="no" {{ $cat == 'no' ? 'selected' : '' }}>Без категорії</option>
                      <option value="StudyScience" {{ $cat == 'StudyScience' ? 'selected' : '' }}>Освіта та наука</option>
                      <option value="Entertainment" {{ $cat == 'Entertainment' ? 'selected' : '' }}>Розваги</option>
                      <option value="LifeSport" {{ $cat == 'LifeSport' ? 'selected' : '' }}>Життя та спорт</option>
                  </select>
                </div>
                <div class="col-lg-6">
                  <select id="post-sort" name="post-sort" class="form-select" aria-label="Категорія"
                    style="width:100%;">
                    <option value="date-desc"  {{ $sort == 'date-desc' ? 'selected' : '' }}>По даті (↓)</option>
                    <option value="date-asc" {{ $sort == 'date-asc' ? 'selected' : '' }}>По даті (↑)</option>
                    <option value="comm-desc" {{ $sort == 'comm-desc' ? 'selected' : '' }}>По комментарям (↓)
                    </option>
                    <option value="comm-asc" {{ $sort == 'comm-asc' ? 'selected' : '' }}>По комментарям (↑)
                    </option>
                    <option value="like-desc" {{ $sort == 'like-desc' ? 'selected' : '' }}>По вподобайкам (↓)
                    </option>
                    <option value="like-asc" {{ $sort == 'like-asc' ? 'selected' : '' }}>По вподобайкам (↑)
                    </option>
                  </select>
                  </div>
                </div>
          </div>
          </form>

        </div>
        <!-- END SEARCH BAR -->

        <div class="mb-5 mt-5 col-lg-12 text-center display-2">
          Пости
        </div>
        <div class="row d-flex justify-content-center">
          <div class="col-lg-8 col-md-10 col-sm-12">

            @foreach($posts as $post)
                @php
                    $user = \App\Models\User::find($post->userid);
                @endphp
                @include('templates/post-card')
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection

@push('js')
        <script src="{{ asset('my-script.js') }}"></script>
    @endpush