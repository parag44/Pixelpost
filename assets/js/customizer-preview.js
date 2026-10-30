/**
 * Pixelpost Customizer Live Preview & Visual Element Selection
 * (Runs inside the WordPress Customizer preview iframe)
 */
(function($, api) {
  'use strict';

  if (!api) return;

  /* ==========================================================================
     1. LIVE PREVIEW SETTING BINDINGS (postMessage)
     ========================================================================== */

  // Site title and description
  api('blogname', function(value) {
    value.bind(function(to) {
      $('.fp-site-title a, .fp-footer-title a, .fp-site-title-text').text(to);
    });
  });

  api('blogdescription', function(value) {
    value.bind(function(to) {
      $('.fp-site-tagline, .fp-footer-tagline').text(to);
    });
  });

  // Hero Section
  api('pixelpost_hero_eyebrow', function(value) {
    value.bind(function(to) {
      $('.fp-hero-eyebrow').text(to);
    });
  });

  api('pixelpost_hero_headline', function(value) {
    value.bind(function(to) {
      $('.fp-hero-headline-main').text(to);
    });
  });

  api('pixelpost_hero_accent', function(value) {
    value.bind(function(to) {
      $('.fp-hero-accent').text(to);
    });
  });

  api('pixelpost_hero_role', function(value) {
    value.bind(function(to) {
      $('.fp-hero-role').text(to);
    });
  });

  api('pixelpost_hero_description', function(value) {
    value.bind(function(to) {
      $('.fp-hero-description').text(to);
    });
  });

  api('pixelpost_hero_location', function(value) {
    value.bind(function(to) {
      $('.fp-hero-location-text').text(to);
    });
  });

  api('pixelpost_hero_avail_status', function(value) {
    value.bind(function(to) {
      $('.fp-hero-avail-text').text(to);
    });
  });

  // Projects Section
  api('pixelpost_projects_eyebrow', function(value) {
    value.bind(function(to) {
      $('#projects .fp-eyebrow').text(to);
    });
  });

  api('pixelpost_projects_heading', function(value) {
    value.bind(function(to) {
      $('#projects .fp-section-title').text(to);
    });
  });

  api('pixelpost_projects_subtitle', function(value) {
    value.bind(function(to) {
      $('#projects .fp-section-subtitle').text(to);
    });
  });

  // Contact Section
  api('pixelpost_contact_heading', function(value) {
    value.bind(function(to) {
      $('.fp-contact-heading-main').text(to);
    });
  });

  api('pixelpost_contact_heading_accent', function(value) {
    value.bind(function(to) {
      $('.fp-contact-heading-accent').text(to);
    });
  });

  api('pixelpost_contact_description', function(value) {
    value.bind(function(to) {
      $('.fp-contact-description').text(to);
    });
  });

  api('pixelpost_contact_email', function(value) {
    value.bind(function(to) {
      $('.fp-contact-email-val a').text(to);
      $('.fp-contact-email-link').attr('href', 'mailto:' + to);
    });
  });

  api('pixelpost_contact_location', function(value) {
    value.bind(function(to) {
      $('.fp-contact-location-val').text(to);
    });
  });

  api('pixelpost_contact_availability_status', function(value) {
    value.bind(function(to) {
      $('.fp-contact-avail-val').text(to);
    });
  });

  // Footer Navigation Title
  api('pixelpost_footer_nav_title', function(value) {
    value.bind(function(to) {
      $('.fp-footer-nav-title').text(to);
    });
  });

  // Colors
  api('pixelpost_color_bg', function(value) {
    value.bind(function(to) {
      document.documentElement.style.setProperty('--fp-bg', to);
    });
  });

  api('pixelpost_color_surface', function(value) {
    value.bind(function(to) {
      document.documentElement.style.setProperty('--fp-surface', to);
    });
  });

  api('pixelpost_color_text', function(value) {
    value.bind(function(to) {
      document.documentElement.style.setProperty('--fp-text', to);
    });
  });

  api('pixelpost_color_accent', function(value) {
    value.bind(function(to) {
      document.documentElement.style.setProperty('--fp-accent', to);
    });
  });

  /* ==========================================================================
     2. VISUAL ELEMENT SELECTION (CLICK-TO-CUSTOMIZE)
     ========================================================================== */

  // Inject visual hover and selection styles into iframe <head>
  $('<style id="pixelpost-preview-click-to-edit-css">' +
    '.fp-customizer-editable { position: relative; cursor: pointer !important; transition: outline .15s ease, outline-offset .15s ease; }' +
    '.fp-customizer-editable:hover { outline: 2px dashed #994200 !important; outline-offset: 4px; }' +
    '.fp-customizer-editable::after { content: "✎"; position: absolute; top: -10px; right: -10px; width: 22px; height: 22px; background: #994200; color: #FFFFFF; border-radius: 50%; font-size: 11px; font-weight: bold; display: none; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(0,0,0,0.3); pointer-events: none; z-index: 9999; }' +
    '.fp-customizer-editable:hover::after, .fp-customizer-editable.fp-customizer-selected::after { display: flex !important; }' +
    '.fp-customizer-editable.fp-customizer-selected { outline: 2px solid #994200 !important; outline-offset: 4px; box-shadow: 0 0 0 3px rgba(153, 66, 0, 0.25); }' +
  '</style>').appendTo('head');

  /**
   * Send focus message to parent Customizer controls pane
   */
  function focusControl(controlId, sectionId) {
    // 1. Send via native WordPress customizer preview channel
    if (api.preview && api.preview.send) {
      api.preview.send('focus-control-for-setting', controlId);
      api.preview.send('pixelpost-select-element', {
        controlId: controlId,
        sectionId: sectionId
      });
    }

    // 2. Send via postMessage to parent window (universal cross-frame support)
    window.parent.postMessage({
      type: 'pixelpost-focus-control',
      controlId: controlId,
      sectionId: sectionId
    }, '*');
  }

  // Element mappings: CSS Selector -> Customizer Control & Section
  var mappings = [
    // Header & Brand
    { selector: '.fp-site-header .fp-branding', control: 'blogname', section: 'title_tagline' },
    { selector: '.fp-site-title', control: 'blogname', section: 'title_tagline' },
    { selector: '.fp-site-tagline', control: 'blogdescription', section: 'title_tagline' },
    { selector: '.fp-site-header .fp-main-navigation', control: 'pixelpost_header_sticky', section: 'pixelpost_header_section' },

    // Hero Section
    { selector: '.fp-hero-eyebrow', control: 'pixelpost_hero_eyebrow', section: 'pixelpost_hero_section' },
    { selector: '.fp-hero-headline-main', control: 'pixelpost_hero_headline', section: 'pixelpost_hero_section' },
    { selector: '.fp-hero-accent', control: 'pixelpost_hero_accent', section: 'pixelpost_hero_section' },
    { selector: '.fp-hero-role', control: 'pixelpost_hero_role', section: 'pixelpost_hero_section' },
    { selector: '.fp-hero-description', control: 'pixelpost_hero_description', section: 'pixelpost_hero_section' },
    { selector: '.fp-hero-actions .fp-button-primary', control: 'pixelpost_hero_btn_primary_text', section: 'pixelpost_hero_section' },
    { selector: '.fp-hero-actions .fp-button-subtle', control: 'pixelpost_hero_btn_secondary_text', section: 'pixelpost_hero_section' },
    { selector: '.fp-hero-inner', control: 'pixelpost_hero_headline', section: 'pixelpost_hero_section' },
    { selector: '.fp-hero-card', control: 'pixelpost_hero_image', section: 'pixelpost_hero_section' },

    // Statistics Strip
    { selector: '.fp-stat-item', control: 'pixelpost_stats_items', section: 'pixelpost_stats_section' },
    { selector: '.fp-stats-strip', control: 'pixelpost_stats_items', section: 'pixelpost_stats_section' },

    // Skills Section
    { selector: '#skills .fp-eyebrow', control: 'pixelpost_skills_eyebrow', section: 'pixelpost_skills_section' },
    { selector: '#skills .fp-section-title', control: 'pixelpost_skills_heading', section: 'pixelpost_skills_section' },
    { selector: '#skills .fp-section-subtitle', control: 'pixelpost_skills_subtitle', section: 'pixelpost_skills_section' },
    { selector: '.fp-skills-cta', control: 'pixelpost_skills_view_all_show', section: 'pixelpost_skills_section' },
    { selector: '.fp-skill-pill', control: 'pixelpost_skills_items', section: 'pixelpost_skills_section' },
    { selector: '.fp-skills-pills', control: 'pixelpost_skills_items', section: 'pixelpost_skills_section' },
    { selector: '#skills', control: 'pixelpost_skills_heading', section: 'pixelpost_skills_section' },

    // Experience Section
    { selector: '#experience .fp-eyebrow', control: 'pixelpost_exp_eyebrow', section: 'pixelpost_experience_section' },
    { selector: '#experience .fp-section-title', control: 'pixelpost_exp_heading', section: 'pixelpost_experience_section' },
    { selector: '.fp-timeline-item', control: 'pixelpost_experience_items', section: 'pixelpost_experience_section' },
    { selector: '.fp-timeline', control: 'pixelpost_experience_items', section: 'pixelpost_experience_section' },
    { selector: '#experience', control: 'pixelpost_experience_items', section: 'pixelpost_experience_section' },

    // Projects Section
    { selector: '#projects .fp-eyebrow', control: 'pixelpost_projects_eyebrow', section: 'pixelpost_projects_section' },
    { selector: '#projects .fp-section-title', control: 'pixelpost_projects_heading', section: 'pixelpost_projects_section' },
    { selector: '#projects .fp-section-subtitle', control: 'pixelpost_projects_subtitle', section: 'pixelpost_projects_section' },
    { selector: '.fp-projects-cta', control: 'pixelpost_projects_view_all_show', section: 'pixelpost_projects_section' },
    { selector: '.fp-project-card', control: 'pixelpost_projects_items', section: 'pixelpost_projects_section' },
    { selector: '.fp-projects-grid', control: 'pixelpost_projects_items', section: 'pixelpost_projects_section' },
    { selector: '#projects', control: 'pixelpost_projects_items', section: 'pixelpost_projects_section' },

    // Blog Section
    { selector: '#blog .fp-eyebrow', control: 'pixelpost_blog_eyebrow', section: 'pixelpost_blog_section' },
    { selector: '#blog .fp-section-title', control: 'pixelpost_blog_heading', section: 'pixelpost_blog_section' },
    { selector: '#blog .fp-section-subtitle', control: 'pixelpost_blog_subtitle', section: 'pixelpost_blog_section' },
    { selector: '.fp-posts-grid', control: 'pixelpost_blog_posts_count', section: 'pixelpost_blog_section' },
    { selector: '#blog', control: 'pixelpost_blog_heading', section: 'pixelpost_blog_section' },

    // About Section
    { selector: '#about .fp-eyebrow', control: 'pixelpost_about_eyebrow', section: 'pixelpost_about_section' },
    { selector: '#about .fp-section-title', control: 'pixelpost_about_heading', section: 'pixelpost_about_section' },
    { selector: '.fp-about-content', control: 'pixelpost_about_text', section: 'pixelpost_about_section' },
    { selector: '.fp-about-bullets', control: 'pixelpost_about_bullets', section: 'pixelpost_about_section' },
    { selector: '#about', control: 'pixelpost_about_heading', section: 'pixelpost_about_section' },

    // Contact Section
    { selector: '#contact .fp-contact-eyebrow', control: 'pixelpost_contact_eyebrow', section: 'pixelpost_contact_section' },
    { selector: '.fp-contact-heading', control: 'pixelpost_contact_heading', section: 'pixelpost_contact_section' },
    { selector: '.fp-contact-description', control: 'pixelpost_contact_description', section: 'pixelpost_contact_section' },
    { selector: '.fp-contact-buttons .fp-button-primary', control: 'pixelpost_contact_btn_primary', section: 'pixelpost_contact_section' },
    { selector: '.fp-contact-buttons .fp-button-secondary', control: 'pixelpost_contact_btn_secondary', section: 'pixelpost_contact_section' },
    { selector: '.fp-contact-row', control: 'pixelpost_contact_items', section: 'pixelpost_contact_section' },
    { selector: '.fp-contact-channels', control: 'pixelpost_contact_items', section: 'pixelpost_contact_section' },
    { selector: '#contact', control: 'pixelpost_contact_heading', section: 'pixelpost_contact_section' },

    // Footer
    { selector: '.fp-footer-tagline', control: 'pixelpost_footer_tagline', section: 'pixelpost_footer_section' },
    { selector: '.fp-footer-col-nav', control: 'pixelpost_footer_nav_show', section: 'pixelpost_footer_section' },
    { selector: '.fp-footer-nav-title', control: 'pixelpost_footer_nav_title', section: 'pixelpost_footer_section' },
    { selector: '.fp-social-icon-row', control: 'pixelpost_social_links', section: 'pixelpost_footer_section' },
    { selector: '.fp-social-pill', control: 'pixelpost_social_links', section: 'pixelpost_footer_section' },
    { selector: '.fp-copyright', control: 'pixelpost_footer_copyright', section: 'pixelpost_footer_section' },
    { selector: '.fp-back-to-top', control: 'pixelpost_footer_back_to_top_text', section: 'pixelpost_footer_section' },
    { selector: '.fp-site-footer', control: 'pixelpost_footer_copyright', section: 'pixelpost_footer_section' }
  ];

  // Element ID to Control mapping for data-pixelpost-customize attributes
  var dataAttrMapping = {
    'site-branding': { control: 'blogname', section: 'title_tagline' },
    'header': { control: 'pixelpost_header_sticky', section: 'pixelpost_header_section' },
    'navigation': { control: 'pixelpost_header_sticky', section: 'pixelpost_header_section' },
    'hero': { control: 'pixelpost_hero_headline', section: 'pixelpost_hero_section' },
    'hero-visual': { control: 'pixelpost_hero_visual_type', section: 'pixelpost_hero_section' },
    'hero-eyebrow': { control: 'pixelpost_hero_eyebrow', section: 'pixelpost_hero_section' },
    'hero-headline': { control: 'pixelpost_hero_headline', section: 'pixelpost_hero_section' },
    'hero-name': { control: 'pixelpost_hero_accent', section: 'pixelpost_hero_section' },
    'hero-role': { control: 'pixelpost_hero_role', section: 'pixelpost_hero_section' },
    'hero-description': { control: 'pixelpost_hero_description', section: 'pixelpost_hero_section' },
    'hero-primary-button': { control: 'pixelpost_hero_btn_primary_text', section: 'pixelpost_hero_section' },
    'hero-secondary-button': { control: 'pixelpost_hero_btn_secondary_text', section: 'pixelpost_hero_section' },
    'statistics': { control: 'pixelpost_stats_items', section: 'pixelpost_stats_section' },
    'stat-1': { control: 'pixelpost_stats_items', section: 'pixelpost_stats_section' },
    'stat-2': { control: 'pixelpost_stats_items', section: 'pixelpost_stats_section' },
    'stat-3': { control: 'pixelpost_stats_items', section: 'pixelpost_stats_section' },
    'stat-4': { control: 'pixelpost_stats_items', section: 'pixelpost_stats_section' },
    'skills': { control: 'pixelpost_skills_items', section: 'pixelpost_skills_section' },
    'skills-list': { control: 'pixelpost_skills_items', section: 'pixelpost_skills_section' },
    'experience': { control: 'pixelpost_experience_items', section: 'pixelpost_experience_section' },
    'exp-1': { control: 'pixelpost_experience_items', section: 'pixelpost_experience_section' },
    'exp-2': { control: 'pixelpost_experience_items', section: 'pixelpost_experience_section' },
    'exp-3': { control: 'pixelpost_experience_items', section: 'pixelpost_experience_section' },
    'projects': { control: 'pixelpost_projects_items', section: 'pixelpost_projects_section' },
    'projects-grid': { control: 'pixelpost_projects_items', section: 'pixelpost_projects_section' },
    'impact': { control: 'pixelpost_section_impact_show', section: 'pixelpost_sections_visibility' },
    'blog': { control: 'pixelpost_blog_heading', section: 'pixelpost_blog_section' },
    'about': { control: 'pixelpost_about_heading', section: 'pixelpost_about_section' },
    'about-text': { control: 'pixelpost_about_text', section: 'pixelpost_about_section' },
    'about-bullets': { control: 'pixelpost_about_bullets', section: 'pixelpost_about_section' },
    'contact': { control: 'pixelpost_contact_heading', section: 'pixelpost_contact_section' },
    'contact-heading': { control: 'pixelpost_contact_heading', section: 'pixelpost_contact_section' },
    'contact-description': { control: 'pixelpost_contact_description', section: 'pixelpost_contact_section' },
    'contact-primary-btn': { control: 'pixelpost_contact_btn_primary', section: 'pixelpost_contact_section' },
    'contact-secondary-btn': { control: 'pixelpost_contact_btn_secondary', section: 'pixelpost_contact_section' },
    'contact-channels': { control: 'pixelpost_contact_items', section: 'pixelpost_contact_section' },
    'contact-email': { control: 'pixelpost_contact_items', section: 'pixelpost_contact_section' },
    'contact-location': { control: 'pixelpost_contact_items', section: 'pixelpost_contact_section' },
    'contact-availability': { control: 'pixelpost_contact_items', section: 'pixelpost_contact_section' },
    'footer': { control: 'pixelpost_footer_copyright', section: 'pixelpost_footer_section' },
    'footer-nav': { control: 'pixelpost_footer_nav_show', section: 'pixelpost_footer_section' },
    'footer-copyright': { control: 'pixelpost_footer_copyright', section: 'pixelpost_footer_section' },
    'footer-back-to-top': { control: 'pixelpost_footer_back_to_top_text', section: 'pixelpost_footer_section' },
    'footer-social': { control: 'pixelpost_social_links', section: 'pixelpost_footer_section' }
  };

  /**
   * Initialize interactive elements on DOM ready
   */
  $(document).ready(function() {
    // 1. Attach to selector mappings
    mappings.forEach(function(item) {
      var $el = $(item.selector);
      if ($el.length) {
        $el.addClass('fp-customizer-editable');
        $el.attr('title', 'Click to edit in Customizer');
        $el.on('click', function(e) {
          if ($(e.target).is('a') || $(e.target).closest('a').length || $(e.target).is('button')) {
            e.preventDefault();
          }
          e.stopPropagation();

          $('.fp-customizer-selected').removeClass('fp-customizer-selected');
          $el.addClass('fp-customizer-selected');

          focusControl(item.control, item.section);
        });
      }
    });

    // 2. Also attach to any element with [data-pixelpost-customize]
    $('[data-pixelpost-customize]').each(function() {
      var $el = $(this);
      var key = $el.attr('data-pixelpost-customize');
      var mapping = dataAttrMapping[key];

      $el.addClass('fp-customizer-editable');
      $el.attr('title', 'Click to edit in Customizer');

      $el.on('click', function(e) {
        if ($(e.target).is('a') || $(e.target).closest('a').length || $(e.target).is('button')) {
          e.preventDefault();
        }
        e.stopPropagation();

        $('.fp-customizer-selected').removeClass('fp-customizer-selected');
        $el.addClass('fp-customizer-selected');

        if (mapping) {
          focusControl(mapping.control, mapping.section);
        } else {
          focusControl(null, 'pixelpost_' + key + '_section');
        }
      });
    });
  });

})(jQuery, wp.customize);
