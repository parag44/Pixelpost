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
