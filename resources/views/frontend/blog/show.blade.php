<x-frontend.layouts.master>


<div class="row" style="padding-left: 30px">
    <div class="col-md-8" style="padding-left: 100px">

        <h3>{{ $postdata->title }}</h3>

        <img src="{{ asset('storage/post-image/'. $postdata->image) }}" style="height: 450px ; width: 480px" />
        <h5 style=""> <b>Short Description</b></h5>
        <p> {{ $postdata->short_description }}</p>
        <h5><b> Long Description</b></h5>
        <p> {{ $postdata->long_description }}</p>

        <h1>Comment Hare</h1>

        <form action="{{route('blog.message.store')}}" method="post" class="p-3 p-md-5 bg-light">
            @csrf
            <div class="form-group">
                <input type="hidden" value="{{$postdata->category_id}}" name="category_id">
                <input type="hidden" value="{{$postdata->id}}" name="Post_id">

            <label for="name">Name *</label>
            <input type="text" name="user_name" class="form-control" id="name" required>
            </div>
            <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <div class="form-group">
            <label for="message">Message</label>
            <textarea name="message" id="message" cols="30" rows="10" class="form-control" required>
            </textarea>
            </div>
            <div class="form-group">
            <input type="submit" value="Post Comment" class="btn py-3 px-4 btn-primary">
            </div>
            </form>


            <div id="comment" style="padding-left: 60px">
                <h1>Comments</h1>
                <ul>
                @foreach($comments as $comment)
                <li>
                    <img src="https://banner2.cleanpng.com/20180329/zue/kisspng-computer-icons-user-profile-person-5abd85306ff7f7.0592226715223698404586.jpg" style="height: 30px ; width: 30px" />
                    <b>{{$comment->user_name}}</b>
                    <p> {{$comment->message}} </p>
                    <time><mark> {{$comment->created_at->diffForHumans() }} </mark> </time>
                </li>
                @endforeach

                </ul>
            </div>
       
    </div>

    <div class="col-md-4" style="padding-left: 30px">

        <h5 class="text-nowrap bd-highlight">Blog categories</h5>

        <h5>Related Post</h5>
        @foreach($posts as $post)
        <div class="card" style="width: 18rem;">
            <img src="{{ asset('storage/post-image/'. $post->image) }}" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">{{Str::limit( $post->title,10 )}}</h5>
              <p class="card-text">{{Str::limit($post->short_description , 100)}}</p>
              <a href="{{route('blog.details', ['post' => $post->id])}}" class="btn btn-primary">View details</a>
            </div>
          </div>
          <br>
        @endforeach

    </div>



</div>
</x-frontend.layouts.master>



    
