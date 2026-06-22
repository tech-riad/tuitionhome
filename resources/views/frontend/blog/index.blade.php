<x-frontend.layouts.master>


  @push ('css')

  <link href="{{ asset('frontend/css/blogstylee.css') }}" rel="stylesheet" />

  @endpush
    <div class="row" id="allPost">
        @foreach ($posts as $post)
        <div class="col-md-4">
          <div class="card">
            <div class="zoom">
            <img src="{{ asset('storage/post-image/'. $post->image) }}" class="card-img-top" alt="...">
            </div>
            <div class="card-body ">
                <span class="">Posted By:{{$post->created_by}} </span>
              <h4 class="card-title"><b>{{Str::limit( $post->title,30 )}}</b></h4>
              <p class="card-text">{{Str::limit($post->short_description , 220)}}</p>
              <a href="{{route('blog.details', ['post' => $post->id])}}" class="btn btn-primary">View details</a>
            </div>
          </div>
        </div>
        @endforeach
       
    </div>



</x-frontend.layouts.master>