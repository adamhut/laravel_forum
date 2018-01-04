@extends('layouts.app')

@section ('head')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create a Thread</div>
                <div class="panel-body">
                    <form action="/threads" method="POST">
                        {{csrf_field()}}
                        <div class="form-gruop">
                            <label for="">Choose a channel :</label>
                            <select name="channel_id" id="channel_id" class="form-control" required>
                                <option value="">Choose One</option>
                                @foreach($channels as $channel)
                                    <option value="{{$channel->id}}" {{old('channel_id')==$channel->id? 'selected':''}}>
                                        {{$channel->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text"
                                class="form-control"
                                name="title"
                                id="title"
                                value="{{old('title')}}"
                                required
                            >
                        </div>
                        <div class="form-group">
                            <label for="title">Body </label>
                            <wysiwyg name="body"></wysiwyg>
                            {{--
                            <textarea class="form-control"
                                name="body"
                                id="body"
                                rows="5"

                            >
                                {{old('body')}}
                            </textarea>
                            --}}
                        </div>
                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="{{config('council.recaptcha.key')}}"></div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Publish</button>
                        </div>
                        <div class="form-group">
                            @if(count($errors))
                                <ul class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <li>
                                            {{$error}}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('footerScript')


{{--
<script src="/js/tinymce/tinymce.min.js"></script>
<script>
     var editor_config = {
    path_absolute : "/",
    selector: "textarea#body",
    plugins: [
      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime media nonbreaking save table contextmenu directionality",
      "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    relative_urls: false,
    file_browser_callback : function(field_name, url, type, win) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
      if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no"
      });
    }
  };
    tinymce.init(editor_config);
  </script>
--}}
@endsection
