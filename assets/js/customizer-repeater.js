/**
 * Pixelpost Customizer Repeater Control
 * Runs in the WordPress Customizer controls panel.
 */
/* global wp */
(function() {
  'use strict';

  function parseJson(str, fallback) {
    if (!str) return fallback;
    try {
      var parsed = JSON.parse(str);
      return Array.isArray(parsed) ? parsed : fallback;
    } catch (e) {
      return fallback;
    }
  }

  function escHtml(str) {
    var div = document.createElement('div');
    div.textContent = str === undefined || str === null ? '' : String(str);
    return div.innerHTML;
  }

  function initControl(container) {
    if (container.dataset.ready === '1') return;
    container.dataset.ready = '1';

    var fields = parseJson(container.dataset.fields, []);
    var items = parseJson(container.dataset.items, []);
    var labelKey = container.dataset.itemLabelKey || 'title';
    var subtitleKey = container.dataset.itemSubtitleKey || '';
    var settingId = container.dataset.settingId;
    var list = container.querySelector('.fp-repeater-list');
    var textarea = container.querySelector('.fp-repeater-value');
    var addBtn = container.querySelector('.fp-repeater-add');

    if (!list || !textarea) return;

    function save() {
      var data = [];
      var itemEls = list.querySelectorAll('.fp-repeater-item');

      itemEls.forEach(function(itemEl) {
        var row = {};
        fields.forEach(function(f) {
          var input = itemEl.querySelector('[data-key="' + f.key + '"]');
          if (input) {
            row[f.key] = input.value;
          } else {
            row[f.key] = f.default || '';
          }
        });
        data.push(row);
      });

      var jsonStr = JSON.stringify(data);
      textarea.value = jsonStr;
      textarea.dispatchEvent(new Event('change', { bubbles: true }));

      if (window.wp && wp.customize && wp.customize.has && wp.customize.has(settingId)) {
        wp.customize(settingId).set(jsonStr);
      }
    }

    function renderField(field, val) {
      val = val === undefined || val === null ? (field.default || '') : val;
      var k = escHtml(field.key);
      var labelHtml = '<span class="fp-field-label">' + escHtml(field.label) + '</span>';

      if (field.type === 'textarea') {
        return '<label class="fp-field-row">' +
          labelHtml +
          '<textarea data-key="' + k + '" placeholder="' + escHtml(field.placeholder || '') + '">' + escHtml(val) + '</textarea>' +
          '</label>';
      }

      if (field.type === 'select') {
        var opts = Object.keys(field.choices || {}).map(function(choice) {
          var sel = String(choice) === String(val) ? ' selected' : '';
          return '<option value="' + escHtml(choice) + '"' + sel + '>' + escHtml(field.choices[choice]) + '</option>';
        }).join('');

        return '<label class="fp-field-row">' +
          labelHtml +
          '<select data-key="' + k + '">' + opts + '</select>' +
          '</label>';
      }

      if (field.type === 'icon') {
        var catalog = window.pixelpostIconCatalog || [];
        var activeIconObj = catalog.find(function(ic) { return ic.id === val; });
        var activeSvg = activeIconObj ? activeIconObj.svg : (catalog[0] ? catalog[0].svg : '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/></svg>');
        var activeName = activeIconObj ? activeIconObj.name : (val || 'Select Icon');

        var optionsHtml = catalog.map(function(ic) {
          var isSel = (ic.id === val) ? ' is-selected' : '';
          return '<button type="button" class="fp-icon-option' + isSel + '" data-id="' + escHtml(ic.id) + '" data-name="' + escHtml(ic.name) + '" data-cat="' + escHtml(ic.category) + '" title="' + escHtml(ic.name + ' (' + ic.id + ')') + '">' +
            ic.svg +
            '<span class="fp-icon-opt-name">' + escHtml(ic.name) + '</span>' +
          '</button>';
        }).join('');

        return '<div class="fp-field-row fp-icon-picker-field">' +
          labelHtml +
          '<div class="fp-icon-picker-widget">' +
            '<button type="button" class="fp-icon-picker-trigger">' +
              '<span class="fp-icon-preview-box">' + activeSvg + '</span>' +
              '<span class="fp-icon-selected-name">' + escHtml(activeName) + '</span>' +
              '<span class="dashicons dashicons-arrow-down-alt2 fp-icon-picker-arrow"></span>' +
            '</button>' +
            '<input type="hidden" data-key="' + k + '" value="' + escHtml(val) + '">' +
            '<div class="fp-icon-picker-popover" style="display:none;">' +
              '<div class="fp-icon-picker-header">' +
                '<input type="text" class="fp-icon-search-input" placeholder="Search 35+ icons...">' +
                '<div class="fp-icon-category-tabs">' +
                  '<button type="button" class="fp-icon-cat-btn is-active" data-cat="all">All</button>' +
                  '<button type="button" class="fp-icon-cat-btn" data-cat="tech">Tech</button>' +
                  '<button type="button" class="fp-icon-cat-btn" data-cat="social">Social</button>' +
                  '<button type="button" class="fp-icon-cat-btn" data-cat="contact">Contact</button>' +
                  '<button type="button" class="fp-icon-cat-btn" data-cat="general">General</button>' +
                '</div>' +
              '</div>' +
              '<div class="fp-icon-grid" role="listbox">' +
                optionsHtml +
              '</div>' +
            '</div>' +
          '</div>' +
        '</div>';
      }

      var inputType = field.type === 'url' ? 'url' : 'text';
      return '<label class="fp-field-row">' +
        labelHtml +
        '<input type="' + inputType + '" data-key="' + k + '" value="' + escHtml(val) + '" placeholder="' + escHtml(field.placeholder || '') + '">' +
        '</label>';
    }

    function updateTitles(itemEl, rowData) {
      var primary = rowData[labelKey] || rowData.title || rowData.name || rowData.number || 'Item';
      var subtitle = subtitleKey ? (rowData[subtitleKey] || '') : '';

      var primEl = itemEl.querySelector('.fp-item-primary');
      var subEl = itemEl.querySelector('.fp-item-subtitle');

      if (primEl) primEl.textContent = primary;
      if (subEl) subEl.textContent = subtitle;
    }

    function initIconPickers(container) {
      var widgets = container.querySelectorAll('.fp-icon-picker-widget');
      widgets.forEach(function(widget) {
        var trigger = widget.querySelector('.fp-icon-picker-trigger');
        var popover = widget.querySelector('.fp-icon-picker-popover');
        var hiddenInput = widget.querySelector('input[type="hidden"]');
        var previewBox = widget.querySelector('.fp-icon-preview-box');
        var selectedName = widget.querySelector('.fp-icon-selected-name');
        var searchInput = widget.querySelector('.fp-icon-search-input');
        var catBtns = widget.querySelectorAll('.fp-icon-cat-btn');
        var options = widget.querySelectorAll('.fp-icon-option');

        if (!trigger || !popover || !hiddenInput) {
          return;
        }

        function filterIcons() {
          var query = (searchInput ? searchInput.value : '').toLowerCase().trim();
          var activeCatBtn = widget.querySelector('.fp-icon-cat-btn.is-active');
          var activeCat = activeCatBtn ? activeCatBtn.getAttribute('data-cat') : 'all';

          options.forEach(function(opt) {
            var id = (opt.getAttribute('data-id') || '').toLowerCase();
            var name = (opt.getAttribute('data-name') || '').toLowerCase();
            var cat = opt.getAttribute('data-cat') || '';

            var matchesCat = (activeCat === 'all' || cat === activeCat);
            var matchesQuery = !query || id.indexOf(query) !== -1 || name.indexOf(query) !== -1;

            if (matchesCat && matchesQuery) {
              opt.style.display = 'inline-flex';
            } else {
              opt.style.display = 'none';
            }
          });
        }

        trigger.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();

          var isVisible = (popover.style.display === 'block');

          document.querySelectorAll('.fp-icon-picker-popover').forEach(function(p) {
            p.style.display = 'none';
          });
          document.querySelectorAll('.fp-icon-picker-trigger').forEach(function(t) {
            t.classList.remove('is-active');
          });

          if (!isVisible) {
            popover.style.display = 'block';
            trigger.classList.add('is-active');
            if (searchInput) {
              searchInput.value = '';
              filterIcons();
              setTimeout(function() {
                searchInput.focus();
              }, 60);
            }
            var sel = widget.querySelector('.fp-icon-option.is-selected');
            if (sel) {
              sel.scrollIntoView({ block: 'nearest' });
            }
          }
        });

        if (searchInput) {
          searchInput.addEventListener('input', function() {
            filterIcons();
          });
          searchInput.addEventListener('click', function(e) {
            e.stopPropagation();
          });
          searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
              popover.style.display = 'none';
              trigger.classList.remove('is-active');
              trigger.focus();
            }
          });
        }

        catBtns.forEach(function(btn) {
          btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            catBtns.forEach(function(b) {
              b.classList.remove('is-active');
            });
            btn.classList.add('is-active');
            filterIcons();
          });
        });

        options.forEach(function(opt) {
          opt.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var iconId = opt.getAttribute('data-id') || '';
            var iconName = opt.getAttribute('data-name') || iconId;
            var svgEl = opt.querySelector('svg');

            hiddenInput.value = iconId;

            if (previewBox && svgEl) {
              previewBox.innerHTML = svgEl.outerHTML;
            }
            if (selectedName) {
              selectedName.textContent = iconName;
            }

            options.forEach(function(o) {
              o.classList.remove('is-selected');
            });
            opt.classList.add('is-selected');

            popover.style.display = 'none';
            trigger.classList.remove('is-active');

            // Dispatch input and change so repeater detects updates
            hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
            hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
          });
        });

        popover.addEventListener('click', function(e) {
          e.stopPropagation();
        });
      });
    }

    function buildItem(data, isNew, insertAfterEl) {
      var itemEl = document.createElement('div');
      itemEl.className = 'fp-repeater-item';
      itemEl.draggable = true;

      var primary = data[labelKey] || data.title || data.name || data.number || 'Item';
      var subtitle = subtitleKey ? (data[subtitleKey] || '') : '';

      var headerHtml = '<div class="fp-item-header">' +
        '<span class="fp-drag-handle dashicons dashicons-menu" title="Drag to reorder" aria-hidden="true"></span>' +
        '<div class="fp-item-titles">' +
          '<span class="fp-item-primary">' + escHtml(primary) + '</span>' +
          '<span class="fp-item-subtitle">' + escHtml(subtitle) + '</span>' +
        '</div>' +
        '<div class="fp-item-actions">' +
          '<button type="button" class="fp-btn-up" title="Move Up" aria-label="Move Up">▲</button>' +
          '<button type="button" class="fp-btn-down" title="Move Down" aria-label="Move Down">▼</button>' +
          '<button type="button" class="fp-btn-clone" title="Duplicate" aria-label="Duplicate"><span class="dashicons dashicons-admin-page" aria-hidden="true"></span></button>' +
          '<button type="button" class="fp-btn-delete" title="Delete" aria-label="Delete"><span class="dashicons dashicons-trash" aria-hidden="true"></span></button>' +
          '<span class="fp-item-toggle"><span class="dashicons dashicons-arrow-down-alt2" aria-hidden="true"></span></span>' +
        '</div>' +
      '</div>';

      var bodyHtml = '<div class="fp-item-body">' +
        fields.map(function(f) {
          return renderField(f, data[f.key]);
        }).join('') +
      '</div>';

      itemEl.innerHTML = headerHtml + bodyHtml;

      initIconPickers(itemEl);

      // Event: Header click toggles collapse
      var headerEl = itemEl.querySelector('.fp-item-header');
      headerEl.addEventListener('click', function(e) {
        if (e.target.closest('button') || e.target.closest('.fp-drag-handle')) {
          return;
        }
        itemEl.classList.toggle('is-expanded');
      });

      // Event: Real-time input updates title and saves
      itemEl.addEventListener('input', function() {
        var row = {};
        fields.forEach(function(f) {
          var input = itemEl.querySelector('[data-key="' + f.key + '"]');
          row[f.key] = input ? input.value : '';
        });
        updateTitles(itemEl, row);
        save();
      });

      itemEl.addEventListener('change', function() {
        save();
      });

      // Action: Move Up
      var upBtn = itemEl.querySelector('.fp-btn-up');
      upBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        var prev = itemEl.previousElementSibling;
        if (prev) {
          list.insertBefore(itemEl, prev);
          save();
        }
      });

      // Action: Move Down
      var downBtn = itemEl.querySelector('.fp-btn-down');
      downBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        var next = itemEl.nextElementSibling;
        if (next) {
          list.insertBefore(next, itemEl);
          save();
        }
      });

      // Action: Duplicate
      var cloneBtn = itemEl.querySelector('.fp-btn-clone');
      cloneBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        var currentData = {};
        fields.forEach(function(f) {
          var input = itemEl.querySelector('[data-key="' + f.key + '"]');
          currentData[f.key] = input ? input.value : '';
        });
        buildItem(currentData, true, itemEl);
        save();
      });

      // Action: Delete
      var delBtn = itemEl.querySelector('.fp-btn-delete');
      delBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        itemEl.remove();
        save();
      });

      // Drag and drop sorting
      itemEl.addEventListener('dragstart', function(e) {
        itemEl.classList.add('fp-dragging');
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/plain', '');
      });

      itemEl.addEventListener('dragend', function() {
        itemEl.classList.remove('fp-dragging');
        list.querySelectorAll('.fp-repeater-item').forEach(function(el) {
          el.classList.remove('fp-drag-over');
        });
        save();
      });

      itemEl.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        itemEl.classList.add('fp-drag-over');
      });

      itemEl.addEventListener('dragleave', function() {
        itemEl.classList.remove('fp-drag-over');
      });

      itemEl.addEventListener('drop', function(e) {
        e.preventDefault();
        itemEl.classList.remove('fp-drag-over');
        var draggingEl = list.querySelector('.fp-dragging');
        if (draggingEl && draggingEl !== itemEl) {
          var bounding = itemEl.getBoundingClientRect();
          var offset = e.clientY - bounding.top;
          if (offset > bounding.height / 2) {
            list.insertBefore(draggingEl, itemEl.nextSibling);
          } else {
            list.insertBefore(draggingEl, itemEl);
          }
          save();
        }
      });

      // Insert into DOM
      if (insertAfterEl && insertAfterEl.nextSibling) {
        list.insertBefore(itemEl, insertAfterEl.nextSibling);
      } else if (insertAfterEl) {
        list.appendChild(itemEl);
      } else {
        list.appendChild(itemEl);
      }

      if (isNew) {
        itemEl.classList.add('is-expanded');
        var firstInput = itemEl.querySelector('input, textarea, select');
        if (firstInput) firstInput.focus();
      }
    }

    // Populate initial items
    items.forEach(function(data) {
      buildItem(data, false);
    });

    // Add Item Button
    if (addBtn) {
      addBtn.addEventListener('click', function() {
        var defaultRow = {};
        fields.forEach(function(f) {
          defaultRow[f.key] = f.default || '';
        });
        buildItem(defaultRow, true);
        save();
      });
    }
  }

  function boot() {
    document.querySelectorAll('.fp-repeater-control').forEach(initControl);
  }

  // Close any open icon picker popovers when clicking outside
  document.addEventListener('click', function(e) {
    if (!e.target.closest('.fp-icon-picker-widget')) {
      document.querySelectorAll('.fp-icon-picker-popover').forEach(function(p) {
        p.style.display = 'none';
      });
      document.querySelectorAll('.fp-icon-picker-trigger').forEach(function(t) {
        t.classList.remove('is-active');
      });
    }
  });

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }

  // Also hook into Customizer section expansion in case controls are lazily rendered
  if (window.wp && wp.customize) {
    wp.customize.bind('ready', function() {
      boot();
      wp.customize.section.each(function(section) {
        section.expanded.bind(function(isExpanded) {
          if (isExpanded) {
            setTimeout(boot, 50);
          }
        });
      });
    });
  }

})();
