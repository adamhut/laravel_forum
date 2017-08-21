@extends('layouts.app')

@section('header')
<link href="/css/vendor/jquery.atwho.css" rel="stylesheet">
@endsection

@section('content')
<thread-view inline-template :initial-replies-count="{{$thread->replies_count}}">
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="level">
                        <span class="flex">
                            
                            <img src="{{ $thread->creator->avatar_path}}" 
                                alt="{{$thread->creator->name}}" 
                                width="25" 
                                height="25" 
                                class="mr-1"
                            />

                            <a href="/profiles/{{$thread->creator->name}}">
                                {{$thread->creator->name}}
                            </a> posted:
                            {{$thread->title}}
                        </span>
                        @can('update', $thread)
                            <form action="{{$thread->path()}}" method="POST">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                                <button type="submit" class="btn btn-danger btn-xs">Delete Thread</button> 
                            </form>
                        @endcan
                        @if(auth()->check())
                            <form action="{{$thread->path()}}/favorite" method="POST">
                                {{csrf_field()}}
                                {{method_field('PATCH')}}
                                <button type="button" class="btn btn-default" onclick="favorite">
                                    <span class="glyphicon glyphicon-heart"></span>
                                    <span v-text="count" ></span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="panel-body">
                    <div class="body">{!!$thread->body!!}</div>
                    <hr>
                </div>
            </div>
          
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
                        <subscribe-button :active="{{json_encode($thread->isSubscribedTo)}}"></subscribe-button>
                        
                    </p>
                </div>  
            </div>
        </div>
    </div>
</div>
</thread-view>
@endsection
