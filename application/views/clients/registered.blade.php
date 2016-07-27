@layout('layouts.genericmaster')

@section('content') 
<div class="header">
    <h2><?php echo __('common.detailpage_caption'); ?> </h2>
</div>
<div class="content controls">
    <h2>{{__('common.registration_succesful')}}</h2>
</div>
@endsection