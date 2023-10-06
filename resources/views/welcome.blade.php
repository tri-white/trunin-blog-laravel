@extends('shared/layout')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('test.css') }}">
    @endpush
@section('content')
  <main>


    @if(Auth::check())
    <div class="container mt-5">
      <div class="row d-flex justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
          <form method="post" action="" enctype="multipart/form-data">
            <textarea name="post-description" class="form-control" id="contentInput" rows="5" required
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
          </div>

        </div>
      </div>
    </div>
  </main>
 

@endsection

@push('js')
        <script src="{{ asset('my-script.js') }}"></script>
    @endpush