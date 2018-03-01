@extends('layouts.app')

@section('content')


     
<div class="row col-md-9 col-lg-9 col-sm-9 pull-left ">
      <div class="well well-lg" >
        <h1>{{ $project->name }}</h1>
        <p class="lead">{{ $project->description }}</p>
      </div>

      <div class="row col-md-12 col-lg-12 col-sm-12" style="background: white; margin:10px">

        @include('partials.comments')


        <div class="row container-fluid">
          <form method="POST" action="{{route('comments.store')}}">
            {{csrf_field()}}
            <input type="hidden" name="commentable_type" value="App\Project"/>
            <input type="hidden" name="commentable_id" value="{{$project->id}}"/>

            <div class="form-group">
              <label for="comment-body">Comment</label>
              <textarea placeholder="Enter comment"
                        style="resize:vertical"
                        id="comment-body"
                        name="body"
                        rows="3" spellcheck="false"
                        class="form-control autosize-target text-left">
              </textarea>
            </div>

            <div class="form-group">
              <label for="comment-url">Proof of work done (Url/Photos)</label>
              <textarea placeholder="Enter url or screenshots"
                        style="resize: vertical"
                        id="comment-url"
                        name="url"
                        rows="3" spellcheck="false"
                        class="form-control autosize-target text-left">
              </textarea>                      
            </div>

            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Submit"/>
            </div>
          </form>
        </div>

      </div>
</div>

<div class="col-sm-3 col-md-3 col-lg-3 pull-right">
          <div class="sidebar-module">
            <h4>Actions</h4>
            <ol class="list-unstyled">
              <li><a href="/projects/{{ $project->id }}/edit">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a></li>
              <li><a href="/projects/create/">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>Create new project</a></li>
              <li><a href="/projects"><i class="fa fa-user-o" aria-hidden="true"></i>My projects</a></li>
            
            <br/>
            
            
              <li>

                  
              <a   
              href="#"
                  onclick="
                  var result = confirm('Are you sure you wish to delete this project?');
                      if( result ){
                              event.preventDefault();
                              document.getElementById('delete-form').submit();
                      }
                          "
                          >
                  <i class="fa fa-power-off" aria-hidden="true"></i>Delete
              </a>

              <form id="delete-form" action="{{ route('projects.destroy',[$project->id]) }}" 
                method="POST" style="display: none;">
                        <input type="hidden" name="_method" value="delete">
                        {{ csrf_field() }}
              </form>

 
              
              
              </li>

              <!-- <li><a href="#">Add new member</a></li> -->
            </ol>
          </div>

          <hr>

          <h4>Add members</h4>
          <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
              <form method="post" action="{{route('projects.adduser')}}">
                {{csrf_field()}}

                <input type="hidden" name="project_id" value="{{$project->id}}"/>

                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Email" name="email"/>
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" id="addMember">Add!</button>
                  </span>
                </div>
              </form>
            </div>
        </div>
        <br/>
        <h4>Team members</h4>
        <div class="row">
          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <ol class="list-unstyled" id="member-list">
              @foreach($project->users as $user)
              <li><a href="#">{{$user->email}}</a></li>
              @endforeach
            </ol>
          </div>
        </div>
    @endsection

                      <script type="text/javascript">
                      
                          $('#addMember').on('click',function(e){
                            alert('1');
                              e.preventDefault(); //prevent the form from auto submit

                              $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                }
                            });

alert('2');
                            var formData = {
                              project_id : $('#project_id').val(),
                              email : $('#email').val(),
                              '_token': $('input[name=_token]').val(),
                            }
alert('3');
                            var url = '/projects/adduser';

                            $.ajax({
                              type: 'post',
                              url: "{{ URL::route('projects.adduser') }}",
                              data : formData,
                              dataType : 'json',
                              success : function(data){
alert('4');
                                    var emailField = $('#email').val();
                                  $('#email').val('');
                                  $('#member-list').prepend('<li><a href="#">'+ emailField +'</a> </li>');
                                  
                              },
                              error: function(data){

                             alert('5');
                                //do something with data
                                console.log("error sending request" +data.error);
                              }
                            });

                             alert('6');
                          });

                      </script>

