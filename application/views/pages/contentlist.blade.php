@layout('layouts.master')

@section('content')
<?php 
$currentPageNo = (int)Input::get('page', 0);
$applicationID = (int)Input::get('applicationID', 0);
$appLink = $applicationID > 0 ? '&applicationID=' . $applicationID : '';
$searchLink = '&search='.$search;
$sortDirLink = '&sort_dir='.($sort_dir == 'DESC' ? 'ASC' : 'DESC');
	?>
	<script>
	var currentPageNo = <?php echo (int)$currentPageNo ; ?>;
	var appID = <?php echo $applicationID ?>;
	$(function() {
		if(appID && currentPageNo < 2) {
		  $( "#DataTables_Table_1 tbody" ).sortable({
			  axis:'y',
			  update: function() {
				  var data = $(this).sortable('serialize');
				  $.ajax({
					  data: data,
					  type:'POST',
					  url:'/contents/order/' + appID,
					  success: function(res) {
						  cNotification.success();
						  setTimeout(function() {
							  cNotification.hide();
						  }, 1000);
					  }
				  });
			  }
		  });
		  $( "#DataTables_Table_1 tbody" ).disableSelection();
	  }
	});
	</script>
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
									@if($currentPageNo < 2 && (int)Auth::User()->UserTypeID == eUserTypes::Customer)
									<th><span class="icon-move"></span></th>
									@endif
									<?php foreach($fields as $field): ?>
									<?php $sortLink = '&sort='.$field[1]; ?>
									<?php $sort == $field[1] ? ($sort_dir == 'ASC' ? array('class' => 'sort_up') : array('class' => 'sort_down')) : array(); ?>
										<th scope="col">{{ HTML::link($route.'?page=1'. $appLink  . $searchLink . $sortLink . $sortDirLink, $field[0], $sort) }}</th>
									<?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
								<form id="contentOrderForm">
									@forelse($rows->results as $row)
										@if((int)Auth::User()->UserTypeID == eUserTypes::Manager)
											<tr id="contentIDSet_{{$row->ContentID}}" class="{{ HTML::oddeven($page) }}">
												<td>{{ HTML::link($route.'/'.$row->ContentID, $row->CustomerName) }}</td>
												<td>{{ HTML::link($route.'/'.$row->ContentID, $row->ApplicationName) }}</td>
												<td>{{ HTML::link($route.'/'.$row->ContentID, $row->Name) }}</td>
												<td>{{ HTML::link($route.'/'.$row->ContentID, $row->Blocked) }}</td>
												<td>{{ HTML::link($route.'/'.$row->ContentID, $row->Status) }}</td>
												<td>{{ HTML::link($route.'/'.$row->ContentID, $row->ContentID) }}</td>
											</tr>
										@elseif((int)Auth::User()->UserTypeID == eUserTypes::Customer)
											<tr id="contentIDSet_{{$row->ContentID}}" class="{{ HTML::oddeven($page) }}">
												<?php if($page < 2): ?>
													<td><span class="icon-resize-vertical"></span></td>
												<?php endif; ?>
												<td>{{ HTML::link($route.'/'.$row->ContentID, $row->Name) }}</td>
												<td>{{ HTML::link($route.'/'.$row->ContentID, $row->CategoryName) }}</td>
												<td>{{ HTML::link($route.'/'.$row->ContentID, Common::dateRead($row->PublishDate, 'dd.MM.yyyy')) }}</td>
												<td>{{ HTML::link($route.'/'.$row->ContentID, Common::dateRead($row->UnpublishDate, 'dd.MM.yyyy')) }}</td>
												<td>{{ HTML::link($route.'/'.$row->ContentID, $row->Blocked) }}</td>
												<td>{{ HTML::link($route.'/'.$row->ContentID, $row->Status) }}</td>
												<td>{{ HTML::link($route.'/'.$row->ContentID, $row->ContentID) }}</td>
											</tr>
										@endif
									@empty
										<tr>
											<td class="select">&nbsp;</td>
											<td colspan="{{ count($fields) - 1 }}">{{ __('common.list_norecord') }}</td>
										</tr>
									@endforelse
								</form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end tabular_content-->
            <div class="select">
                @if($applicationID > 0)
                    {{ $rows->appends(array('applicationID' => $applicationID, 'search' => $search, 'sort' => $sort, 'sort_dir' => $sort_dir))->links() }}
                @else
                    {{ $rows->appends(array('search' => $search, 'sort' => $sort, 'sort_dir' => $sort_dir))->links() }}
                @endif
            </div>
            <script type="text/javascript">
                $(function() {
                    $("div.pagination ul").addClass("pagination");
                });
            </script>
            <!-- end select-->
        </div>
    </div>
    <!--</form>-->
@endsection

