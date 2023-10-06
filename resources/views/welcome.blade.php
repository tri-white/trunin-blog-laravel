@extends('shared/layout')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('test.css') }}">
    @endpush
@section('content')
  <main>


    <!-- CREATE POST -->

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