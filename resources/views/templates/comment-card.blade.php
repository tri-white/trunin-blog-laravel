
<div class="card mt-2">
                   
                  <div class="card-body">
                  <a href="{{ route('profile', $row_user->id) }}" class="text-decoration-none link-dark">
                  <div class="other d-flex align-items-center">
                    <div class="img-container d-flex" style="height:35px; width:35px;">
                      <img src="{{ $user->photo ? asset($user->photo) : asset('images/user_male.jpg') }}"
                       style="width:100%; height:100%; object-fit: contain;" class="rounded-circle border border-1 border-dark" alt="Profile Picture">
                    </div>
                     <div class="ms-2">
                        <p class="fs-6 m-0">{{ $row_user->login }} </p>
                        <p class="card-text my-auto text-muted fs-6">{{ $comm->created_at }}</p>
                    </div>
                  </div>
                  </a> 
                    <p class="card-text mt-2 comment-text fs-7 mb-0 text-wrap">{{ $comm->description }}</p>
                    <div class="footer-comment align-items-center d-flex justify-content-end align-items-center">
                      @if(Auth::check())
                        @if(Auth::user()->admin == 1)
                        <a class="my-auto me-4 link-dark" href="">
                            <i class="fa fa-trash-can"></i>
                        </a>
                        @endif
                      @endif
                    </div>
                    
                    
                  </div>
                </div>