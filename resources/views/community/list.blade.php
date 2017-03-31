<ul class="list-group">
	@if(count($links))
   		@foreach($links as $link)
			<li class="list-group-item CommunityLink">
				<form method="POST"  action="votes/{{$link->id}}" class="">
					{{csrf_field()}}
					<button class="btn {{Auth::check() && $link->votes->contains('id',Auth::id()) ? 'btn-success':'btn-default'}}"
						{{Auth::guest()? 'disabled':''}}
					>
						{{$link->votes->count()}}
					</button>
				</form>
			   
			   	<a href="/community/{{$link->channel->slug}}"
			   	   class="label label-default" 
			   	   style="background: {{$link->channel->color}}">
			   			{{$link->channel->title}}
			   	</a>
			   
			   	<a href="{{$link->url}}" target="_blank">
			   		{{$link->title}}
			   	</a>
			   	<small>
			   	 	Contributed By <a href="">{{$link->creator->name}}</a> {{$link->updated_at->diffForHumans()}}
				</small>
			</li>	
 		@endforeach
	@else
		<li class="list-group-item">
			No Contribution Yet
		</li>
 	@endif
</ul> 

{{	$links->appends(['popular'=>''])->links() }}