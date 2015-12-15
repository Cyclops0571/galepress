@layout('layouts.master')

@section('content')
    {{ HTML::script('js/managements.js?v=' . APP_VER); }}
    <div class="col-md-12">
        <div class="block block-drop-shadow">
            <div class="header">
                <h2><?php echo __('common.detailpage_caption'); ?> </h2>
            </div>
            <div class="content controls">
                <?php echo Laravel\Form::open(__('route.managements_save'), 'POST'); ?>
                <?php echo Laravel\Form::token(); ?>
                <div class="col-md-4">
                    <div class="form-row">
                        <input type="button" class="btn-info" value="Dilleri DBye yazdir"/>
                        <input type="button" class="btn-success" value="DBdeki dillerin ciktisini al"/>
                    </div>
                </div>
                <?php echo Laravel\Form::close(); ?>
            </div>
        </div>
    </div>
@endsection