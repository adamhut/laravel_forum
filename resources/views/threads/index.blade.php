@extends('layouts.app') 

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8">
			@include('threads._list') 
			{{$threads->render()}}
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					Search
				</div>
				<div class="panel-body">
					<form action="/threads/search" METHOD="GET">
						<div class="form-group">
							<input type="text" placeholder="Search For Something..." name="q" class="form-control">
						</div>
						<div class="form-group">
							<button class="btn btn-primary" type="submit">Search
							</button>
							<img src="/images/algolia-logo-light.svg" alt="" style="width:100px; height:20px;">
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			@if(count($trending)>0)
			<div class="panel panel-default">
				<div class="panel-heading">
					Trending Threads
				</div>
				<div class="panel-body">
					<ul class="list-group">
						@foreach($trending as $thread)
						<li class="list-group-item">
							<a href="{{$thread->path}}">
								{{$thread->title}}
							</a>
						</li>
						@endforeach
					</ul>
				</div>
			</div>
			@else @endif
		</div>
	</div>
</div>
@endsection