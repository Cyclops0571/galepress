@layout('website.html')

@section('body-content')

      <!-- Start Parallax section-->
      <section class="sep-top-2x sep-bottom-2x">
        <div class="container">
          <div class="row">
            <div class="col-md-12" id="blog-frame">
              <a href="/{{ Session::get('language') }}/{{__('route.website_blog_news')}}" class="btn btn-primary btn-xs"><i class="fa fa-newspaper-o"></i><span style="margin-left:10px;">{{__('website.blog_news')}}</span></a>
              <iframe src="http://www.galepress.com/blog/" id="blogIframe" scrolling="no" frameborder="0" style="width:100% !important; height:100% !important; overflow:hidden; margin-top:19px;"></iframe>
            </div>
          </div>
        </div>
      </section>
      <!-- End Parallax section-->

@endsection