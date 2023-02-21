<?php  if (count($errors) > 0) : ?>
  <div class="error">
  	<?php foreach ($errors as $error) : ?>
		<div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="toast-header">
            <img src="assets/favicon/android-icon-48x48.png" class="img" alt="Oximeter Logo">

            <strong class="me-auto">Oximeter</strong>
            <button type="button" class="btn-close" data-coreui-dismiss="toast" aria-label="Close"></button>
          </div>
          <div class="toast-body">
	<?php $error ?></div>
        </div>
      </div>
  	<?php endforeach ?>
  </div>
<?php  endif ?>