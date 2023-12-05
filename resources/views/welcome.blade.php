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
              <div class="mb-3">
                <label for="photoInput" class="form-label">Виберіть фото</label>
                <input type="file" class="form-control" id="photoInput" name="post-photo">
              </div>
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
            <form method="get" action="{{ route('post-search') }}">
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
                      <option value="null" {{ $cat == 'null' ? 'selected' : '' }}>Без категорії</option>
                      <option value="Освіта та наука" {{ $cat == 'Освіта та наука' ? 'selected' : '' }}>Освіта та наука</option>
                      <option value="Розваги" {{ $cat == 'Розваги' ? 'selected' : '' }}>Розваги</option>
                      <option value="Життя та спорт" {{ $cat == 'Життя та спорт' ? 'selected' : '' }}>Життя та спорт</option>
                  </select>
                </div>
                <div class="col-lg-6">
                  <select id="post-sort" name="post-sort" class="form-select" aria-label="Категорія"
                    style="width:100%;">
                    <option value="date-desc"  {{ $sort == 'date-desc' ? 'selected' : '' }}>По даті (↓)</option>
                    <option value="date-asc" {{ $sort == 'date-asc' ? 'selected' : '' }}>По даті (↑)</option>
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
            @if (!$currentPagePosts || $currentPagePosts->count()==0)
        <div class='mb-5 text-muted col-lg-12 text-center display-4'>
            Не знайдено постів
        </div>

        @else
            @foreach($currentPagePosts as $post)
              @include('templates/post-card')
            @endforeach
        @endif
        <nav aria-label="Page navigation example" class="mt-5">
            <ul class="pagination justify-content-center">
                @for ($page = 1; $page <= $totalPages; $page++) <li
                    class="page-item{{ $page == $currentPage ? ' active' : '' }}">
                    <a class="page-link"
                        href="{{ route('welcome', ['page' => $page, 'searchKey' => $key, 'category'=>$cat,'sort'=>$sort]) }}">{{ $page }}</a>
                    </li>
                    @endfor
            </ul>
        </nav>

          </div>
        </div>
      </div>
    </div>
  </main>
@endsection

@push('js')
        <script src="{{ asset('my-script.js') }}"></script>
    @endpush