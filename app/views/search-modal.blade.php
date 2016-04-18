
<!-- Modal -->
  <div class="modal fade" id="search-result-modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{ trans('public.search-result') }} "<span class='key-span' id='search-key'> </span>"</h4>
        </div>
        <div class="modal-body" id='search-result-content'>
			<p> Searching in progress... "<span class='key-span'> </span>" </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>