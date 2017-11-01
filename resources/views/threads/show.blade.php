@extends('layouts.app')

@section('header')
<link href="/css/vendor/jquery.atwho.css" rel="stylesheet">
@endsection

@section('content')
<thread-view inline-template :thread="{{ $thread }}">
<div class="container">
    <div class="row">
        <div class="col-md-8" v-cloak>
            @include('threads._question')
          
            <replies @removed="repliesCount--"
                @added="repliesCount++"
            >
            </replies>
           
            {{--import Replies from '../components/replies.vue';
            @foreach($replies as $reply)
                @include('threads.reply')
            @endforeach
            

            {{$replies->links()}}
            --}}

            {{--@if(auth()->check())

                    <form method="POST" action="{{$thread->path().'/replies'}}">
                        {{csrf_field()}}
                        <div class="form-group">    
                            <textarea name="body" id="body" class="form-control" placeholder="Have something to say" rows=5></textarea>
                        </div>
                        <button class="btn btn-default" type="submit">Post</button>
                    </form>

            @else
                <p class="text-center">Please <a href="{{route('login')}}">sign in</a> to particatate in this discussion</p>
            @endif

            --}}
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
               
                <div class="panel-body">
                    <p>
                        This Thread was publisded {{$thread->created_at->diffForHumans()}} 
                        <br/>by <a href="#">{{$thread->creator->name}}</a> , 
                        and currently has  <span v-text="repliesCount"></span> {{str_plural('comment',$thread->replies_count)}}
                    </p>
                    <p>
                        <subscribe-button :active="{{json_encode($thread->isSubscribedTo)}}"  v-if="signedIn"></subscribe-button>
                        

                        <button class="btn btn-default" 
                            v-if="authorize('isAdmin')"
                            @click="toggleLock"
                            v-text="locked? 'Unlock':'Lock'"
                        >
                        </button>
                    </p>
                </div>  
            </div>
        </div>
    </div>
</div>
</thread-view>
@endsection
