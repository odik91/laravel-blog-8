<div class="col-md-10 col-lg-4 p-b-80">
  <div class="p-l-10 p-rl-0-sr991">	
    <!-- Most Popular -->
    <div class="p-b-23">
      <div class="how2 how2-cl4 flex-s-c">
        <h3 class="f1-m-2 cl3 tab01-title">
          Most Popular
        </h3>
      </div>

      <ul class="p-t-35">
        @foreach (App\Models\Post::orderBy('views', 'desc')->limit(5)->get() as $key => $post)
        <li class="flex-wr-sb-s p-b-22">
          <div class="size-a-8 flex-c-c borad-3 size-a-8 bg9 f1-m-4 cl0 m-b-6">
            {{ ++$key }}
          </div>

          <a href="{{ route('article.view', [$post['slug']]) }}" class="size-w-3 f1-s-7 cl3 hov-cl10 trans-03">
            {{ $post['title'] }}
          </a>
        </li>
        @endforeach        
      </ul>
    </div>

    <!-- ads -->
    <div class="flex-c-s p-b-50">
      <a href="#">
        <img class="max-w-full" src="{{ asset('posting/images/banner-02.jpg') }}" alt="IMG">
      </a>
    </div>

    <!-- Category -->
    <div class="p-b-60">
      <div class="how2 how2-cl4 flex-s-c">
        <h3 class="f1-m-2 cl3 tab01-title">
          Category
        </h3>
      </div>

      <ul class="p-t-35">
        @foreach (App\Models\Category::orderBy('name', 'asc')->get() as $category)
        <li class="how-bor3 p-rl-4">
          <a href="{{ route('article.category', $category['slug']) }}" class="dis-block f1-s-10 text-uppercase cl2 hov-cl10 trans-03 p-tb-13">
            {{ $category['name'] }}
          </a>
        </li> 
        @endforeach       
      </ul>
    </div>    

    <!-- Archive -->
    <div class="p-b-37">
      <div class="how2 how2-cl4 flex-s-c">
        <h3 class="f1-m-2 cl3 tab01-title">
          Archive
        </h3>
      </div>

      <ul class="p-t-32">
        @php
        $clause = [];
        for ($i = App\Models\Post::min('year'); $i <= App\Models\Post::max('year'); $i++) {
          for ($j = App\Models\Post::min('month'); $j <= App\Models\Post::max('month'); $j++) {
            array_push($clause, [
              "year" => $i,
              "month" => $j
            ]);
          }
        }
        @endphp

        @for ($i = count($clause) - 1; $i >= 0; $i--)
        <li class="p-rl-4 p-b-19">
          <a href="{{ route('article.archive', [$clause[$i]['year'], $clause[$i]['month']]) }}" class="flex-wr-sb-c f1-s-10 text-uppercase cl2 hov-cl10 trans-03">
            <span>
              @php
                $date=date_create($clause[$i]['year'] . "-" . $clause[$i]['month'] . "-01");
                echo date_format($date,"F Y");
              @endphp
            </span>

            <span>
              ({{ count(App\Models\Post::where('year', $clause[$i]['year'])->where('month', $clause[$i]['month'])->get()) }})
            </span>
          </a>
        </li>
        @endfor
      </ul>
    </div>
  </div>
</div>