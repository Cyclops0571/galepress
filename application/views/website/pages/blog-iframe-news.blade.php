@layout('website.html')

@section('body-content')

      <!-- Start Parallax section-->
      <section class="sep-top-2x sep-bottom-2x">
        <div class="container">
          <div class="row">
            <div class="col-md-12" id="blog-frame-news">
              <a href="http://www.galepress.com/{{ Session::get('language') }}/blog" class="btn btn-primary btn-xs"><i class="fa fa-rss"></i><span style="margin-left:10px;">Blog</span></a>
              <iframe src="http://www.galepress.com/blog/?page_id=5894" id="blogIframeNews" scrolling="no" frameborder="0" style="width:100% !important; height:100% !important; overflow:hidden; margin-top:19px;"></iframe>
            </div>
          </div>
        </div>
      </section>
      <!-- End Parallax section-->

@endsection