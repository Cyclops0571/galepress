@layout('layouts.master')

@section('content')
<?php
if (FALSE) {
	$rows = new Banner();
	$row = new Banner();
}
$appLink = (int) Input::get('applicationID', 0) > 0 ? '&applicationID=' . Input::get('applicationID', 0) : '';
//$searchLink = '&search=' . $search;
$sortDirLink = '&sort_dir=' . ($sort_dir == 'DESC' ? 'ASC' : 'DESC');
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
					<table id="DataTables_Table_1" cellpadding="0" cellspacing="0" width="100%" class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								@if((int)Auth::User()->UserTypeID == eUserTypes::Customer)
								<th><span class="icon-move"></span></th>
								@endif
								<?php foreach ($fields as $field): ?>
									<?php $sortLink = '&sort=' . $field[1]; ?>
									<?php $sort == $field[1] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array(); ?>
									<th scope="col">{{ HTML::link($route.'?' . $appLink  . $searchLink . $sortLink . $sortDirLink, $field[0], $sort) }}</th>
								<?php endforeach; ?>
							</tr>
						</thead>
						<tbody>
						<form id="contentOrderForm">
							<?php foreach ($rows->results as $row): ?>
								<?php if ((int) Auth::User()->UserTypeID == eUserTypes::Manager): ?>
									<tr id="bannerIDSet_<?php echo $row->BannerID ?>" class="{{ HTML::oddeven($page) }}">
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->CustomerName) }}</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->ApplicationName) }}</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->Name) }}</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->Blocked) }}</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->Status) }}</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->ContentID) }}</td>
									</tr>
								<?php elseif ((int) Auth::User()->UserTypeID == eUserTypes::Customer): ?>
									<tr id="contentIDSet_{{$row->ContentID}}" class="{{ HTML::oddeven($page) }}">
										<?php if ($page < 2): ?>
											<td style="cursor:pointer;"><span class="icon-resize-vertical list-draggable-icon"></span></td>
										<?php endif; ?>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->Name) }}</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->CategoryName) }}</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, Common::dateRead($row->PublishDate, 'dd.MM.yyyy')) }}</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, Common::dateRead($row->UnpublishDate, 'dd.MM.yyyy')) }}</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->Blocked) }}</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->Status) }}</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->ContentID) }}</td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
							<?php if (empty($rows)): ?>
								<tr>
									<td class="select">&nbsp;</td>
									<td colspan="{{ count($fields) - 1 }}">{{ __('common.list_norecord') }}</td>
								</tr>
							<?php endif; ?>
						</form>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!--</form>-->
@endsection