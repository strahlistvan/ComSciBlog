           <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h3>{{ trans('public.search') }}</h3>
                    <div class="input-group">
                        <input id='search-text' type="text" class="form-control" placeholder="{{ trans('public.search') }}..." role='search'  required >
                        <span class="input-group-btn">
                            <button id='search-button' class="btn btn-default" type="button" title="{{ trans('public.search') }}">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    <!-- /.input-group -->
                </div>

                <!-- Side Widget Well with Facebook Page Plugin -->
                <div class="well" id='descWell'>
                    <h3>{{ trans('public.siteName') }}</h3>
                    <div class="fb-page" data-href="https://www.facebook.com/comsciblog" data-small-header="false" data-adapt-container-width="true" data-show-facepile="true" data-show-posts="false">
                     <div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/comsciblog">
                      <a href="https://www.facebook.com/comsciblog">ComSci blog</a></blockquote>
                      </div>
                      </div>
                    <p> {{ trans('public.desc') }}</p>
                </div>

                <!-- Blog Categories Well -->
                <div class="well">
                    <h3> {{ trans('public.keywords') }} </h3>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
								@for ($i=0; $i<count($allKeywords)/2; ++$i)
									<li><a href="{{ url().'/keyword/'.urlencode($allKeywords[$i]->keyword) }}" title="{{ trans('list-category')}}" >{{ $allKeywords[$i]->keyword }}</a> </li>
								@endfor
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                @for ($i=count($allKeywords)/2; $i<count($allKeywords); ++$i)
									<li><a href="{{ url().'/keyword/'.urlencode($allKeywords[$i]->keyword) }}" title="{{ trans('list-category')}}" >{{ $allKeywords[$i]->keyword }}</a> </li>
								@endfor
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

            </div>

        </div>
		
        <!-- /.row -->