   <!-- POST -->
   <div class="card mb-5">
                  <div class="card-body">
                      <a href="{{ route('profile') }}" class="text-decoration-none link-dark">
                          <div class="d-flex">
                              <div class="img-container" style="height:50px; width:50px;">
                                  <img src="{{ Auth::user()->photo ? Auth::user()->photo : asset('images/user_male.jpg') }}"
                                      style="width:100%; height:100%; object-fit: contain;"
                                      class="rounded-circle border border-1 border-dark" alt="Profile Picture">
                              </div>
                              <div class="ms-2">
                                  <h5 class="card-title">{{ Auth::user()->login }}</h5>
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
                              <img src="{{ $post->photo }}"
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