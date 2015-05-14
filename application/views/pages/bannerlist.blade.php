@layout('layouts.master')

@section('content')
<?php
if (FALSE) {
	$rows = new Banner();
	$row = new Banner();
	$application = new Application;
}
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
									<th scope="col"><?php echo $field; ?></th>
								<?php endforeach; ?>
							</tr>
						</thead>
						<tbody>
						<form id="contentOrderForm">
							<?php foreach ($rows as $row): ?>
								<?php if ((int) Auth::User()->UserTypeID == eUserTypes::Manager): ?>
									<tr id="bannerIDSet_<?php echo $row->BannerID ?>" class="{{ HTML::oddeven($page) }}">
										<td>
											<a href="<?php echo $route . '/' . $row->BannerID ?>">
												<img src="<?php echo $row->getImagePath($application) ?>" width="80px" height="40px" />
											</a>
										</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->CustomerName) }}</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->ApplicationName) }}</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->TargetUrl) }}</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->TargetContent) }}</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->Description) }}</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->statusText()) }}</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->BannerID) }}</td>
										<td class="text-center">
											<a href="javascript:void(0)" onclick="cBanner.delete(<?php echo $row->BannerID;?>);">
												<span class="icon-remove-sign"></span>
											</a>
										</td>
									</tr>
								<?php elseif ((int) Auth::User()->UserTypeID == eUserTypes::Customer): ?>
									<tr id="bannerIDSet_<?php echo $row->BannerID ?>" class="{{ HTML::oddeven($page) }}">
										<td style="cursor:pointer;"><span class="icon-resize-vertical list-draggable-icon"></span></td>
										<td>
											<a href="<?php echo $route . '/' . $row->BannerID ?>">
												<img src="<?php echo $row->getImagePath($application) ?>" width="80px" height="40px" />
											</a>
										</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->TargetUrl) }}</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->TargetContent) }}</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->Description) }}</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->statusText()) }}</td>
										<td>{{ HTML::link($route.'/'.$row->BannerID, $row->BannerID) }}</td>
										<td class="text-center">
											<a href="javascript:void(0)" onclick="cBanner.delete(<?php echo $row->BannerID;?>);">
												<span class="icon-remove-sign"></span>
											</a>
										</td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
							<?php if (empty($rows)): ?>
								<tr>
									<td class="select">&nbsp;</td>
									<td colspan="{{ count ($fields) - 1 }}">{{ __('common.list_norecord') }}</td>
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
<script type="text/javascript">
    var appID = <?php echo $application->ApplicationID ?>;
    $(function () {
	$("#DataTables_Table_1 tbody").sortable({
		axis: 'y',
		update: function () {
		var data = $(this).sortable('serialize');
		$.ajax({
			data: data,
			type: 'POST',
			url: '/banners/order/' + appID,
			success: function (res) {
			cNotification.success();
			setTimeout(function () {
				cNotification.hide();
			}, 1000);
			}

		});

		}
	});
    });

</script>
@endsection