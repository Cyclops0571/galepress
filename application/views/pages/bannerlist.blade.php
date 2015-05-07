@layout('layouts.master')

@section('content')
<?php
//$appLink = (int) Input::get('applicationID', 0) > 0 ? '&applicationID=' . Input::get('applicationID', 0) : '';
//$searchLink = '&search=' . $search;
//$sortDirLink = '&sort_dir=' . ($sort_dir == 'DESC' ? 'ASC' : 'DESC');
?>

<!--<form id="list">--> 
<div class="col-md-12">
	<div class="block bg-light-ltr" >
		<div class="content controls bg-light-rtl">
			<div class="form-row ">            
				{{ $commandbar }}
			</div>
			<div class="form-row">
				<div class="col-md-12">  

				</div>
			</div>
		</div>
	</div>
</div>
<!--</form>-->
@endsection