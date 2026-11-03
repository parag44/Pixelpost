/**
 * Pixelpost Customizer Controls Pane Script
 *
 * Listens to messages from the preview iframe and focuses/expands
 * the target control and section in the left pane.
 *
 * @package Pixelpost
 */
(function($, api) {
  'use strict';

  if (!api) return;

  api.bind('ready', function() {
    /**
     * Focus control or section in Customizer sidebar
     */
    function handleFocus(controlId, sectionId) {
      if (controlId && api.control.has(controlId)) {
        var ctrl = api.control(controlId);
        ctrl.focus();

        // Highlight control in sidebar
        if (ctrl.container) {
          $('.fp-control-highlighted').removeClass('fp-control-highlighted');
          ctrl.container.addClass('fp-control-highlighted');
          setTimeout(function() {
            ctrl.container.removeClass('fp-control-highlighted');
          }, 2400);

          if (ctrl.container[0] && typeof ctrl.container[0].scrollIntoView === 'function') {
            ctrl.container[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
          }
        }
      } else if (sectionId && api.section.has(sectionId)) {
        api.section(sectionId).focus();
      }
    }

    // 1. Listen for postMessage from the preview frame (cross-frame)
    window.addEventListener('message', function(event) {
      if (!event.data || event.data.type !== 'pixelpost-focus-control') {
        return;
      }

      var controlId = event.data.controlId;
      var sectionId = event.data.sectionId;

      handleFocus(controlId, sectionId);
    });

    // 2. Also handle native previewer.bind message if available
    if (api.previewer) {
      api.previewer.bind('focus-control-for-setting', function(settingId) {
        if (api.control.has(settingId)) {
          handleFocus(settingId, null);
        }
      });

      api.previewer.bind('pixelpost-select-element', function(data) {
        if (!data) return;
        handleFocus(data.controlId, data.sectionId);
      });
    }

    // 3. Shortcut button to open Menus panel
    $(document).on('click', '.fp-btn-open-footer-menus', function(e) {
      e.preventDefault();
      if (api.panel && api.panel.has('nav_menus')) {
        api.panel('nav_menus').focus();
      } else if (api.section && api.section.has('menu_locations')) {
        api.section('menu_locations').focus();
      }
    });

    // 4. Custom File Upload in Customizer Pane
    function updateCustFileUI(file) {
      if (file) {
        $('#fp-cust-filename').text(file.name);
        var sizeKb = (file.size / 1024).toFixed(1) + ' KB';
        $('#fp-cust-filesize').text('✓ ' + sizeKb);
        $('#fp-cust-upload-empty').hide();
        $('#fp-cust-upload-selected').css('display', 'flex');
        $('#fp-customizer-dropzone').css({ 'border-color': '#2271b1', 'background': '#F0F6FC' });
      } else {
        var fileInput = document.getElementById('pixelpost-customizer-import-file');
        if (fileInput) fileInput.value = '';
        $('#fp-cust-filename').text('');
        $('#fp-cust-filesize').text('');
        $('#fp-cust-upload-selected').hide();
        $('#fp-cust-upload-empty').css('display', 'flex');
        $('#fp-customizer-dropzone').css({ 'border-color': '#D3CEC6', 'background': '#FAF9F7' });
      }
    }

    $(document).on('change', '#pixelpost-customizer-import-file', function() {
      if (this.files && this.files.length > 0) {
        updateCustFileUI(this.files[0]);
      } else {
        updateCustFileUI(null);
      }
    });

    $(document).on('click', '#fp-customizer-dropzone', function(e) {
      if ($(e.target).closest('#fp-cust-remove-btn').length) {
        return;
      }
      var input = document.getElementById('pixelpost-customizer-import-file');
      if (input) input.click();
    });

    $(document).on('click', '#fp-cust-remove-btn', function(e) {
      e.preventDefault();
      e.stopPropagation();
      updateCustFileUI(null);
    });

    $(document).on('click', '#fp-cust-replace-btn, #fp-cust-browse-btn', function(e) {
      e.preventDefault();
      e.stopPropagation();
      var input = document.getElementById('pixelpost-customizer-import-file');
      if (input) input.click();
    });

    // 5. In-Customizer Import Settings (AJAX)
    $(document).on('click', '#pixelpost-btn-import-trigger', function(e) {
      e.preventDefault();

      var $btn = $(this);
      var $feedback = $('#pixelpost-import-feedback');
      var fileInput = document.getElementById('pixelpost-customizer-import-file');

      if (!fileInput || !fileInput.files || !fileInput.files[0]) {
        $feedback.show().css({
          'background': '#fcf0f1',
          'border': '1px solid #d63638',
          'color': '#b32d2e'
        }).html(window.pixelpostExportImport ? window.pixelpostExportImport.select_file : 'Please select a .json file first.');
        return;
      }

      var file = fileInput.files[0];
      if (file.name.slice(-5).toLowerCase() !== '.json') {
        $feedback.show().css({
          'background': '#fcf0f1',
          'border': '1px solid #d63638',
          'color': '#b32d2e'
        }).html('Selected file must be in .json format.');
        return;
      }

      var confirmMsg = (window.pixelpostExportImport && window.pixelpostExportImport.confirm_import) 
        ? window.pixelpostExportImport.confirm_import 
        : 'Are you sure you want to import these settings? Current customizer settings will be overwritten.';

      if (!window.confirm(confirmMsg)) {
        return;
      }

      var replaceUrls = $('#pixelpost-import-opt-replace-urls').is(':checked') ? 1 : 0;
      var importCss = $('#pixelpost-import-opt-css').is(':checked') ? 1 : 0;

      // Show loading status
      $btn.prop('disabled', true).text(window.pixelpostExportImport ? window.pixelpostExportImport.importing_label : 'Importing...');
      $feedback.show().css({
        'background': '#f0f6fc',
        'border': '1px solid #72aee6',
        'color': '#1d2327'
      }).html('<span class="spinner is-active" style="float:none; margin:0 6px 0 0; vertical-align:middle;"></span> Processing import...');

      var reader = new FileReader();
      reader.onload = function(evt) {
        var jsonContent = evt.target.result;
        var ajaxUrl = window.pixelpostExportImport ? window.pixelpostExportImport.ajax_url : '/wp-admin/admin-ajax.php';
        var nonce = window.pixelpostExportImport ? window.pixelpostExportImport.nonce : '';

        $.ajax({
          url: ajaxUrl,
          type: 'POST',
          dataType: 'json',
          data: {
            action: 'pixelpost_ajax_import_customizer',
            nonce: nonce,
            json_data: jsonContent,
            replace_urls: replaceUrls,
            import_css: importCss
          },
          success: function(res) {
            if (res && res.success) {
              $feedback.css({
                'background': '#edfaef',
                'border': '1px solid #68de7c',
                'color': '#135e23'
              }).html('<strong>✓ ' + (res.data.message || 'Import successful!') + '</strong><br>Reloading Customizer in 2 seconds...');

              setTimeout(function() {
                window.location.reload();
              }, 1800);
            } else {
              $btn.prop('disabled', false).html('<span class="dashicons dashicons-upload" style="margin-top:2px;"></span> Import & Apply Settings');
              $feedback.css({
                'background': '#fcf0f1',
                'border': '1px solid #d63638',
                'color': '#b32d2e'
              }).html('<strong>Error:</strong> ' + (res && res.data && res.data.message ? res.data.message : 'Import failed.'));
            }
          },
          error: function(xhr, status, err) {
            $btn.prop('disabled', false).html('<span class="dashicons dashicons-upload" style="margin-top:2px;"></span> Import & Apply Settings');
            $feedback.css({
              'background': '#fcf0f1',
              'border': '1px solid #d63638',
              'color': '#b32d2e'
            }).html('<strong>Server Error:</strong> ' + (err || 'Could not communicate with server.'));
          }
        });
      };
      reader.readAsText(file);
    });
  });

  // Inject subtle sidebar focus pulse style
  var style = document.createElement('style');
  style.textContent = [
    '@keyframes fpControlPulse {',
    '  0% { box-shadow: 0 0 0 0 rgba(153, 66, 0, 0.4); border-color: #994200; }',
    '  50% { box-shadow: 0 0 0 5px rgba(153, 66, 0, 0.25); border-color: #994200; }',
    '  100% { box-shadow: 0 0 0 0 rgba(153, 66, 0, 0); }',
    '}',
    '.customize-control.fp-control-highlighted {',
    '  animation: fpControlPulse 1.8s ease !important;',
    '  border-left: 3px solid #994200 !important;',
    '  padding-left: 10px !important;',
    '  transition: all 0.3s ease !important;',
    '}'
  ].join('\n');
  document.head.appendChild(style);

})(jQuery, wp.customize);
