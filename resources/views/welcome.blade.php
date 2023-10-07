@extends('shared/layout')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('test.css') }}">
    @endpush
@section('content')
  <main>
    @if(Auth::check())
      @if(session('success-post'))
          <div class="alert alert-success">{{ session('success-post') }}</div>
      @endif
      @if(session('empty-post'))
          <div class="alert alert-danger">{{ session('empty-post') }}</div>
      @endif
      <div class="container mt-5">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-6 col-md-8 col-sm-12">
            <form method="post" action="{{ route('create-post') }}" enctype="multipart/form-data">
              @csrf
                <textarea name="post-description" class="form-control" id="contentInput" rows="5"
                  placeholder="Що у вас нового?"></textarea>
                <div class="row d-flex">
                  <div class="col-lg-4 col-md-6 col-sm-12 mt-1">
                    <select name="post-category" class="form-select" aria-label="Категорія" style="width:100%;">
                      <option value="no">Без категорії</option>
                      <option value="StudyScience">Освіта та наука</option>
                      <option value="Entertainment">Розваги</option>
                      <option value="LifeSport">Життя та спорт</option>
                    </select>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-12 mt-1">
                    <label for="inputField" class="btn btn-light border border-1 border-dark my-auto"
                      style="width:100%;">Завантажити фото</label>
                    <input name="post-image" type="file" id="inputField" style="display:none">
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

    <!-- POSTS SECTION-->
    <div class="container mt-5">
    <div class="mb-2 mt-5 col-lg-12 text-center display-5">
          Пошук
        </div>
      <div class="col-lg-8 col-md-10 col-sm-12 mx-auto align-items-center">
        <!-- Search bar -->
        <div class="row d-flex justify-content-center">
          <div class="col-lg-8 col-md-10 col-sm-12 text-center">
            <form method="get" action="">
              <div class="input-group">
                <button id="search-button" type="submit" class="btn btn-outline-dark">Знайти</button>
              </div>
              <div class="d-flex justify-content-between mb-2 mt-2">
                <div class="col-lg-6">
                  <select id="post-category-filter" name="post-category-filter" class="form-select"
                    aria-label="Категорія" style="width:100%;">

                  </select>
                </div>

                </div>
          </div>
          </form>
        </div>
        <div class="mb-5 mt-5 col-lg-12 text-center display-2">
          Пости
        </div>
        <div class="row d-flex justify-content-center">
          <div class="col-lg-8 col-md-10 col-sm-12">

            @foreach($posts as $post)
            @php
                $user = \App\Models\User::find($post->userid);
            @endphp
                   <!-- POST -->
                  <div class="card mb-5">
                  <div class="card-body">
                      <a href="{{ route('profile', $user->id) }}" class="text-decoration-none link-dark">
                          <div class="d-flex">
                              <div class="img-container" style="height:50px; width:50px;">
                                  <img src="{{ $user->photo ? $user->photo : asset('images/user_male.jpg') }}"
                                      style="width:100%; height:100%; object-fit: contain;"
                                      class="rounded-circle border border-1 border-dark" alt="Profile Picture">
                              </div>
                              <div class="ms-2">
                                  <h5 class="card-title">{{ $user->login }}</h5>
                                  <p class="card-text text-muted">
                                      <i class="fa fa-clock"></i> {{ $post->created_at }}
                                  </p>
                              </div>
                          </div>
                      </a>
                      <hr class="my-2 mb-4">
                      <a href=""
                          class="text-decoration-none link-dark">
                          @if ($post->description)
                          <p class="card-text">
                              <pre class="fs-5" style="white-space: pre-wrap; text-align: justify;">
                                  {{ $post->description }}
                              </pre>
                          </p>
                          @endif
                          @if ($post->photo)
                              <img src="{{ asset(C:\Users\olego\Desktop\Веб Ковальчук\blog_app\storage\app\{{ $post->photo }}) }}"
                                  class="card-img-top border border-1 border-dark" alt="Image Content">
                          @endif
                      </a>
                      <div class="d-flex justify-content-between mt-2 align-items-center">
                          <div class="col-lg-6">
                              <p class="my-auto me-2 text-muted">{{ $post->category }}</p>
                          </div>
                          <div class="col-lg-6">
                              <div class="d-flex justify-content-end">
                                  @if (Auth::user()->admin == 1)
                                      <a class="my-auto me-4 link-dark"
                                          href="">
                                          <i class="fa fa-trash-can"></i>
                                      </a>
                                  @endif
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- POST END -->
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