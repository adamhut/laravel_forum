@if(auth()->check())
<div class="col-md-4">
	<h3>contribute a Link</h3>

	<div class="panel panel-default">
		<div class="panel-body">
			<form action="/community" method="POST">
				{{csrf_field()}}
				<div class="form-group {{$errors->has('channel_id')?'has-error':''}}">
					<label for="channel">Channel</label>
					<select class="form-control" name="channel_id">
						<option selected disabled>Pick one Channel</option>
						@foreach($channels as $channel)
							<option value="{{$channel->id}}" {{old('channel_id')==$channel->id ?'selected':''}}>
								{{$channel->title}}
							</option>
						@endforeach
					</select>
					{!!$errors->first('channel_id','<span class="help-block">:message</span>')!!}
				</div>
				<div class="form-group {{$errors->has('title')?'has-error':''}}">
					<label for="title">Title</label>
					<input type="text" 
						   class="form-control" 
						   id="title" 
						   name="title" 
						   placeholder="what is the title for your article" 
						   value="{{old('title')}}"
						   required
					>
					{!!$errors->first('title','<span class="help-block">:message</span>')!!}
				</div>
				<div class="form-group {{$errors->has('url')?'has-error':''}}">
					<label for="url">Link</label>
					<input type="text" 
						   class="form-control" 
						   id="url" 
						   name="url" 
						   placeholder="what is the URL for your article" 
						   value="{{old('url')}}"
						   required
					>
					{!!$errors->first('url','<span class="help-block">:message</span>')!!}
				</div>
				<div class="form-group">
					<button class="btn btn-primary">Contribute Link</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endif