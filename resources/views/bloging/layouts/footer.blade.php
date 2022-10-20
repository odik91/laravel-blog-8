<!-- Footer -->
<footer>
  <div class="bg2 p-t-40 p-b-25">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 p-b-20">
          <div class="size-h-3 flex-s-c">
            <a href="index.html">
              <img class="max-s-full" src="{{ asset('posting/images/icons/logo-02.png') }}" alt="LOGO">
            </a>
          </div>

          <div>
            <p class="f1-s-1 cl11 p-b-16">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur tempor magna eget elit efficitur, at
              accumsan sem placerat. Nulla tellus libero, mattis nec molestie at, facilisis ut turpis. Vestibulum
              dolor metus, tincidunt eget odio
            </p>

            <p class="f1-s-1 cl11 p-b-16">
              Any questions? Call us on (+1) 96 716 6879
            </p>

            <div class="p-t-15">
              <a href="#" class="fs-18 cl11 hov-cl10 trans-03 m-r-8">
                <span class="fab fa-facebook-f"></span>
              </a>

              <a href="#" class="fs-18 cl11 hov-cl10 trans-03 m-r-8">
                <span class="fab fa-twitter"></span>
              </a>

              <a href="#" class="fs-18 cl11 hov-cl10 trans-03 m-r-8">
                <span class="fab fa-pinterest-p"></span>
              </a>

              <a href="#" class="fs-18 cl11 hov-cl10 trans-03 m-r-8">
                <span class="fab fa-vimeo-v"></span>
              </a>

              <a href="#" class="fs-18 cl11 hov-cl10 trans-03 m-r-8">
                <span class="fab fa-youtube"></span>
              </a>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-4 p-b-20">
          <div class="size-h-3 flex-s-c">
            <h5 class="f1-m-7 cl0">
              Popular Posts
            </h5>
          </div>

          <ul>
            @foreach (App\Models\Post::orderBy('views', 'desc')->limit('3')->get() as $post)
            <li class="flex-wr-sb-s p-b-20">
              <a href="{{ route('article.view', [$post->getCategory['slug']]) }}" class="size-w-4 wrap-pic-w hov1 trans-03">
                <img src="{{ asset('post/' . $post['image']) }}" alt="IMG">
              </a>

              <div class="size-w-5">
                <h6 class="p-b-5">
                  <a href="{{ route('article.view', [$post['slug']]) }}" class="f1-s-5 cl11 hov-cl10 trans-03">
                    {{ ucfirst(substr($post['title'], 0, 70)) }}...
                  </a>
                </h6>

                <span class="f1-s-3 cl6">
                  {{ date_format(date_create(substr($post['created_at'], 0, (strlen($post['created_at']) - 9))), "D, d M Y") }}
                </span>
              </div>
            </li>                
            @endforeach
          </ul>
        </div>

        <div class="col-sm-6 col-lg-4 p-b-20">
          <div class="size-h-3 flex-s-c">
            <h5 class="f1-m-7 cl0">
              Category
            </h5>
          </div>

          <ul class="m-t--12">
            @foreach (App\Models\Category::orderBy('name', 'asc')->get() as $category)
            <li class="how-bor1 p-rl-5 p-tb-10">
              <a href="{{ route('article.category', [$category['slug']]) }}" class="f1-s-5 cl11 hov-cl10 trans-03 p-tb-8">
                {{ $category['name'] }} ({{ count(App\Models\Post::where('category_id', $category['id'])->get()) }})
              </a>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="bg11">
    <div class="container size-h-4 flex-c-c p-tb-15">
      <span class="f1-s-1 cl0 txt-center">
        Copyright © {{ date("Y") }} Gundul |

        <a href="#" class="f1-s-1 cl10 hov-link1">
          <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
          Copyright &copy;<script>
            document.write(new Date().getFullYear());
          </script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by
          <a href="https://colorlib.com" target="_blank">Colorlib</a>
          <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
      </span>
    </div>
  </div>
</footer>