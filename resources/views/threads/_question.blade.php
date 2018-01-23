{{--Edit the question--}}
<div class="panel panel-default" v-if="editing">
    <div class="panel-heading">
        <div class="level">
            <div class="form-group">
                <input type="text" v-model="form.title" class="form-control" >
            </div>
            {{--
            @if(auth()->check())
            <form action="{{$thread->path()}}/favorites" method="POST">
                {{csrf_field()}} {{method_field('PATCH')}}
                <button type="button" class="btn btn-default" onclick="favorite">
                    <span class="glyphicon glyphicon-heart"></span>
                    <span v-text="count"></span>
                </button>
            </form>
            @endif 
            --}}
        </div>
    </div>
    <div class="panel-body">
        <div class="form-group">

            {{--<textarea class="form-control" row="10" name="body" v-model="form.body"></textarea>--}}
            <wysiwyg name="body" v-model="form.body" :value="form.body"></wysiwyg>
        </div>
    </div>
    <div class="panel-footer">
        <div class="level">
            <button class="btn btn-xs btn-primary level-item" @click="update">Update</button>
            <button class="btn btn-xs btn-default level-item" @click="resetForm">Cancel</button>
            {{--<button class="btn btn-xs btn-default level-item" @click="editing=false">Cancel</button>--}}
            @can('update', $thread)
                <form action="{{$thread->path()}}" method="POST" class="ml-a">
                    {{csrf_field()}} {{method_field('DELETE')}}
                    <button type="submit" class="btn btn-danger btn-xs">Delete Thread</button>
                </form>
            @endcan 
        </div>
    </div>
</div>


{{--Viewing the Question--}}
<div class="panel panel-default" v-else>
    <div class="panel-heading">
        <div class="level">
            <img src="{{ $thread->creator->avatar_path}}" 
                alt="{{$thread->creator->name}}" 
                width="25" 
                height="25" 
                class="mr-1" 
            />
            <span class="flex">
                <a href="/profiles/{{$thread->creator->name}}">
                    {{$thread->creator->name}} ( {{$thread->creator->points}} XP)
                </a> posted: <span v-text="title"></span>
            </span>
            
            {{--
            @if(auth()->check())
            <form action="{{$thread->path()}}/favorites" method="POST">
                {{csrf_field()}} {{method_field('PATCH')}}
                <button type="button" class="btn btn-default" onclick="favorite">
                    <span class="glyphicon glyphicon-heart"></span>
                    <span v-text="count"></span>
                </button>
            </form>
            @endif 
            --}}
        </div>
    </div>
    <div class="panel-body">
        <div class="body">
            <highlight :content="body"></highlight>
        </div>
        <hr>
    </div>
    <div class="panel-footer" v-if="authorize('owns', thread)">
        <button class="btn btn-xs btn-default" @click="editing=true">Edit</button>
    </div>
</div>