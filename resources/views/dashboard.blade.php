@extends('template')

@section('title')
  Dashboard
@endsection

@section('breadcrumb')
  <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Dashboard</li>
@endsection

@section('content')
	<div class="box box-primary">
		<div class="box-header with-border">
			<i class="fa fa-dashboard"></i>
            <h3 class="box-title">Dashboard</h3>
		</div>
		<div class="box-body">
			<p>
				Selamat, {{ Auth::user()->name }}. Anda berhasil Login.
			</p>
		</div>
		<div class="box-footer">

		</div>
	</div>
@endsection

@section('script')
  <script type="text/javascript">


  </script>
@endsection
