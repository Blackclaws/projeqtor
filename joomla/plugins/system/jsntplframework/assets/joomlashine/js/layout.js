/**
 * @version     $Id$
 * @package     JSNTPLFW
 * @author      JoomlaShine Team <support@joomlashine.com>
 * @copyright   Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 * @license     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */

(function($) {
	$.JSNLayoutCustomizer = function(params) {
		// Initialize parameters
		this.params = $.extend({
			id: 'jsn_mainColumns',
			boundary: null,
			sortable: true,
			resizable: true
		}, params);

		// Initialize functionality
		$(document).ready($.proxy(this.check, this));

		// Handle window resize event
		$(window).resize($.proxy(function(event) {
			if (event.target == window) {
				this.timer && clearTimeout(this.timer);
				this.timer = setTimeout($.proxy(this.check, this), 500);
			}
		}, this));
	};

	$.JSNLayoutCustomizer.prototype = {
		check: function() {
			$('#style-form > .tab-content > .tab-pane.active').find('#' + this.params.id).each($.proxy(function(i, e) {
				this.init();
			}, this));

			$('#style-form > #jsn-main-nav > li > a[data-toggle="tab"]').on('shown', $.proxy(function(event) {
				$($(event.target).attr('href')).find('#' + this.params.id).each($.proxy(function(i, e) {
					this.init();
				}, this));
			}, this));
		},

		init: function() {
			// Get necessary elements
			this.container = this.container || $('#' + this.params.id);
			this.columns = this.columns || this.container.children('.jsn-layout-column');

			// Detect parent fieldset
			if (!this.params.boundary) {
				this.params.boundary = this.container.parent();
	
				while (this.params.boundary[0].nodeName != 'BODY' && this.params.boundary[0].nodeName != 'FIELDSET') {
					this.params.boundary = this.params.boundary.parent();
				}
			}

			// Reset width for necessary elements
			this.columns.children().css('width', '');
			this.container.css('width', '');

			// Initialize variables
			this.maxWidth = this.params.boundary.parent().css('overflow-x', 'hidden').width();
			this.maxHeight = this.container.height();
			this.spacing = parseInt(this.columns.css('margin-left')) + parseInt(this.columns.css('margin-right'));
			this.step = parseInt((this.maxWidth - (this.spacing * 12)) / 12);

			// Calculate width for resizable columns
			var total = 0;

			this.columns.children().each($.proxy(function(i, e) {
				// Calculate column width
				var	span = parseInt($(e).attr('class').replace('span', '')),
					width = (this.step * span) + (this.spacing * (span - 1));

				$(e).css('width', width + 'px');

				// Count total width
				total += $(e).parent().outerWidth(true);
			}, this));

			// Update width for container
			this.container.css('width', total + 'px');

			// Initialize sortable
			if (this.params.sortable) {
				this.container.sortable({
					axis: 'x',
					placeholder: 'ui-state-highlight',
	
					start: $.proxy(function(event, ui) {
						ui.placeholder.append(ui.item.children().clone());
					}, this),
	
					stop: $.proxy(function(event, ui) {
						// Refresh columns ordering
						this.columns = this.container.children('.jsn-layout-column');
	
						// Re-initialize resizable
						this.initResizable();
					}, this)
				});
	
				this.container.disableSelection();
			}

			// Initialize resizable
			this.params.resizable && this.initResizable();

			// Generate grid preview
			if (!this.container.find('.jsn-layout-grid-preview').length) {
				this.container.append($('<div />', {'class': 'jsn-layout-grid-preview'}));
	
				for (var i = 0; i < 11; i++) {
					this.container.children('.jsn-layout-grid-preview').append($('<div />'));
				}
			}

			this.container.children('.jsn-layout-grid-preview').children().each($.proxy(function(i, e) {
				// Calculate left position for this grid
				var left = (this.step * (i + 1)) + (parseInt(this.columns.css('margin-left')) * (i + 1)) + (parseInt(this.columns.css('margin-right')) * i);

				$(e).css({
					left: left + 'px',
					height: this.container.height() + 'px'
				});
			}, this));

			// Reset overflow-x property for boundary element
			this.params.boundary.parent().css('overflow-x', '');
		},

		initResizable: function() {
			this.columns.children().each($.proxy(function(i, e) {
				// Reset resizable column
				!$(e).hasClass('ui-resizable') || $(e).resizable('destroy');
				!e.__next || (e.__next = null);

				// Initialize resizable column
				if (i + 1 < this.columns.length) {
					$(e).resizable({
						handles: 'e',
						minWidth: this.step,
						grid: [this.step, this.maxHeight],

						start: $.proxy(function(event, ui) {
							ui.element[0].__next = ui.element[0].__next || ui.element.parent().next().children();

							// Store original width for next sibling element
							ui.element[0].__next[0].originalWidth = ui.element[0].__next.width();

							// Show grid preview
							this.container.children('.jsn-layout-grid-preview').show();

							// Reset max width
							ui.element.resizable('option', 'maxWidth', '');

							// Temporary disable sortable move icon
							var allSortableLists = $('ul.jsn-layout.ui-sortable');

							allSortableLists.attr('class', allSortableLists.attr('class').replace('ui-sortable', 'ui-unsortable'));
						}, this),

						resize: $.proxy(function(event, ui) {
							var	span = parseInt(ui.element.width() / this.step),
								thisWidth = (this.step * span) + (this.spacing * (span - 1)),
								nextWidth = ui.element[0].__next[0].originalWidth - (thisWidth - ui.originalSize.width);

							if (thisWidth < this.step) {
								thisWidth = this.step;
								nextWidth = ui.element[0].__next[0].originalWidth - (thisWidth - ui.originalSize.width);

								// Set min width to prevent column from collapse more
								ui.element.resizable('option', 'minWidth', this.step);
							} else if (nextWidth < this.step) {
								nextWidth = this.step;
								thisWidth = ui.originalSize.width - (nextWidth - ui.element[0].__next[0].originalWidth);

								// Set max width to prevent column from expand more
								ui.element.resizable('option', 'maxWidth', thisWidth);
							}

							// Snap column to grid
							ui.element.css('width', thisWidth + 'px');

							// Reset nested layout
							ui.element[0].__nestedLayout && ui.element[0].__nestedLayout.init();

							// Resize next sibling element as well
							ui.element[0].__next.css('width', nextWidth + 'px');

							// Reset nested layout
							ui.element[0].__next[0].__nestedLayout && ui.element[0].__next[0].__nestedLayout.init();
						}, this),

						stop: $.proxy(function(event, ui) {
							var	oldValue = parseInt(ui.element.children('input').val().replace('span', '')),
								newValue = parseInt(ui.size.width / this.step),
								nextOldValue = parseInt(ui.element[0].__next.children('input').val().replace('span', ''));

							// Update field values
							ui.element.children('input').val('span' + newValue);
							ui.element[0].__next.children('input').val('span' + (nextOldValue - (newValue - oldValue)));

							// Update visual classes
							ui.element.attr('class', ui.element.attr('class').replace(/\bspan\d+\b/, 'span' + newValue));
							ui.element[0].__next.attr('class', ui.element[0].__next.attr('class').replace(/\bspan\d+\b/, 'span' + (nextOldValue - (newValue - oldValue))));

							// Hide grid preview
							this.container.children('.jsn-layout-grid-preview').hide();

							// Restore sortable move icon
							var allSortableLists = $('ul.jsn-layout.ui-unsortable');

							allSortableLists.attr('class', allSortableLists.attr('class').replace('ui-unsortable', 'ui-sortable'));
						}, this)
					});
				}

				// Check if this column has nested column
				var nested = $(e).children().children('ul.jsn-layout');

				if (nested.length) {
					e.__nestedLayout = new $.JSNLayoutCustomizer({
						id: nested.attr('id'),
						boundary: $(e),
						sortable: false
					});
				}

				$(e).parent().css('box-shadow', $(e).children().css('box-shadow'));
			}, this));
		}
	};
})(jQuery);
