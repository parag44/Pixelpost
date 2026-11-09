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

    // 2b. Dynamic control visibility toggling
    if (api('pixelpost_header_cta_show')) {
      var syncHeaderCtaControls = function(val) {
        if (api.control('pixelpost_header_cta_text')) {
          api.control('pixelpost_header_cta_text').active(!!val);
        }
        if (api.control('pixelpost_header_cta_url')) {
          api.control('pixelpost_header_cta_url').active(!!val);
        }
      };
      api('pixelpost_header_cta_show').bind(syncHeaderCtaControls);
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

      var uploadBtnDefaultHtml = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:block; flex-shrink:0;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg><span>Import & Apply Settings</span>';

      if (!fileInput || !fileInput.files || !fileInput.files[0]) {
        $feedback.show().css({
          'background': '#fcf0f1',
          'border': '1px solid #d63638',
          'color': '#b32d2e'
        }).html('<div style="display:flex; align-items:center; gap:8px;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#d63638" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block; flex-shrink:0;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg><span>' + (window.pixelpostExportImport ? window.pixelpostExportImport.select_file : 'Please select a .json file first.') + '</span></div>');
        return;
      }

      var file = fileInput.files[0];
      if (file.name.slice(-5).toLowerCase() !== '.json') {
        $feedback.show().css({
          'background': '#fcf0f1',
          'border': '1px solid #d63638',
          'color': '#b32d2e'
        }).html('<div style="display:flex; align-items:center; gap:8px;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#d63638" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block; flex-shrink:0;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg><span>Selected file must be in .json format.</span></div>');
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
      var importingText = (window.pixelpostExportImport && window.pixelpostExportImport.importing_label) ? window.pixelpostExportImport.importing_label : 'Importing...';
      $btn.prop('disabled', true).html('<span class="spinner is-active" style="float:none; margin:0; width:16px; height:16px; display:inline-block; vertical-align:middle;"></span> <span>' + importingText + '</span>');
      $feedback.show().css({
        'background': '#f0f6fc',
        'border': '1px solid #72aee6',
        'color': '#1d2327'
      }).html('<div style="display:flex; align-items:center; gap:8px;"><span class="spinner is-active" style="float:none; margin:0; width:16px; height:16px; flex-shrink:0;"></span> <span>Processing import...</span></div>');

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
              }).html('<div style="display:flex; align-items:flex-start; gap:8px;"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#135e23" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:block; flex-shrink:0; margin-top:2px;"><polyline points="20 6 9 17 4 12"></polyline></svg><div><strong>' + (res.data.message || 'Import successful!') + '</strong><br><span style="font-size:11px;">Reloading Customizer in 2 seconds...</span></div></div>');

              setTimeout(function() {
                window.location.reload();
              }, 1800);
            } else {
              $btn.prop('disabled', false).html(uploadBtnDefaultHtml);
              $feedback.css({
                'background': '#fcf0f1',
                'border': '1px solid #d63638',
                'color': '#b32d2e'
              }).html('<div style="display:flex; align-items:flex-start; gap:8px;"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#d63638" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block; flex-shrink:0; margin-top:2px;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg><div><strong>Error:</strong> ' + (res && res.data && res.data.message ? res.data.message : 'Import failed.') + '</div></div>');
            }
          },
          error: function(xhr, status, err) {
            $btn.prop('disabled', false).html(uploadBtnDefaultHtml);
            $feedback.css({
              'background': '#fcf0f1',
              'border': '1px solid #d63638',
              'color': '#b32d2e'
            }).html('<div style="display:flex; align-items:flex-start; gap:8px;"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#d63638" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:block; flex-shrink:0; margin-top:2px;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg><div><strong>Server Error:</strong> ' + (err || 'Could not communicate with server.') + '</div></div>');
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
