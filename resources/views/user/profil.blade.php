@extends('template')

@section('title')
  Profil {{ Auth::user()->name }}
@endsection

@section('breadcrumb')
  <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">User Profil</li>
@endsection

@section('content')
	<div class="box box-primary">
		<div class="box-header with-border">
			<i class="fa fa-user"></i>
              <h3 class="box-title">Data User</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-3">
					<img src="{{ asset('images/users/'.Auth::user()->foto) }}" alt="">
				</div>
				<div class="col-md-6">
					<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<tbody>
								<tr>
									<th>Nama</th> <td>{{ Auth::user()->name }}</td>
								</tr>
								<tr>
									<th>Email</th> <td>{{ Auth::user()->email }}</td>
								</tr>
								<tr>
									<th>Role</th> <td></td>
								</tr>
							</tbody>
						</table>
					</div>
					<button class="btn btn-default btn-flat" onclick="editForm('{{ Auth::user()->uuid }}')"><i class="fa fa-edit"></i> EDIT</button>
				</div>
			</div>
		</div>
		<div class="box box-footer">

		</div>
	</div>

{{-- MODAL FORM --}}
  <div class="modal fade" id="userForm" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
          <form method="POST" id="Register" enctype="multipart/form-data">
              {{ csrf_field() }} {{ method_field('POST') }}
              <input type="hidden" name="uuid" value="">

                <div class="row">
                  <div class="col-sm-4">
                    <img src="" id="userImage" class="img img-responsive">
                  </div>
                  <div class="col-sm-8">
                    <div class="form-group has-feedback" id="group_name">
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Nama lengkap">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    <span class="text-danger"><p id="name-error"></p> </span>
                  </div>
                  <div class="form-group has-feedback" id="group_email">
                      <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email">
                      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                      <span class="text-danger"> <p id="email-error"></p> </span>
                  </div>
                  <div class="form-group has-feedback" id="group_password">
                      <input type="password" name="password" class="form-control" placeholder="Password">
                      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                      <span class="text-danger"> <p id="password-error"></p> </span>
                  </div>
                  <div class="form-group has-feedback" group_password_confirmation>
                      <input type="password" name="password_confirmation" class="form-control" placeholder="Ketik ulang password">
                      <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                      <input type="file" name="foto" class="form-control" placeholder="File Foto">
                      <span class="glyphicon glyphicon-file form-control-feedback"></span>
                  </div>
                  </div>
                </div>
        </div>
        <div class="modal-footer">
            <div class="btn-group">
              <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Batal</button>
              <button type="button" id="submitForm" class="btn btn-success btn-flat">Simpan</button>
            </div>
            </form>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('script')
  <script type="text/javascript">
  	//EDIT FORM
  	function editForm(id) {
    $('#userForm').modal('show');
    $('.modal-title').text('Form Edit User');
    $('input[name="_method"]').val('PATCH');

    $('#group_name').removeClass('has-error');
    $('#group_email').removeClass('has-error');
    $('#group_password').removeClass('has-error');

    $( '#name-error' ).html( "" );
    $( '#email-error' ).html( "" );
    $( '#password-error' ).html( "" );

    $.ajax({
      url: '/user/'+id+'/edit',
      type: 'GET',
      success: function (data) {
        $('input[name="name"]').val(data.name);
        $('input[name="email"]').val(data.email);
        $('input[name="uuid"]').val(data.uuid);
        $('#userImage').attr('src', '/images/users/'+data.foto+'');
      }
    });
  }

  //SAVE DATA
    $(function () {
      $('#submitForm').on('click', function () {
        var registerForm = $("#Register");
        var uuid = $('input[name="uuid"]').val();

        $( '#name-error' ).html( "" );
        $( '#email-error' ).html( "" );
        $( '#password-error' ).html( "" );

        if(uuid != ''){
          url = '/user/'+uuid+'';
        } else {
          url = '{{ route('user.store') }}';
        }

        $.ajax({
            url: url,
            type:'POST',
            data: new FormData($("#Register")[0]),
            dataType:'json',
            async:false,
            processData: false,
            contentType: false,
            success:function(data) {
                console.log(data);
                if(data.errors) {
                    if(data.errors.name){
                        $('#group_name').addClass('has-error');
                        $('#name-error').html( data.errors.name[0] );
                    }
                    if(data.errors.email){
                        $('#group_email').addClass('has-error');
                        $('#email-error').html( data.errors.email[0] );
                    }
                    if(data.errors.password){
                        $('#group_password').addClass('has-error');
                        $('#password-error').html( data.errors.password[0] );
                    }

                }
                if(data.success) {
                  $('#userForm').modal('hide');
                  location.reload();
                }
            },
        });

      });
    });

  </script>
@endsection
