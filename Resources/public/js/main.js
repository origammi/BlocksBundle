'use strict';

var blocksBundle = {
    $: null,

    init: function(jQuery) {
        this.$ = jQuery;
        var addBlockDropDowns  = this.$('.add-block');

        this.$('body').on('click', '.remove-block', this.removeBlock.bind(this));
        addBlockDropDowns.on('change', this.addBlock.bind(this));

        this.sortable.init(jQuery);
    },

    removeBlock: function(e) {
        var block = this.$(e.target);

        // TODO: translations
        if (confirm('Are you sure you want to remove that block?')) {
            block.closest('.block').remove();
        }
    },

    addBlock: function(e) {
        e.preventDefault();

        var dropDown       = this.$(e.target);
        var blocks         = dropDown.parent().prev();
        var nextBlockIndex = blocks.children().length;
        var prototype      = dropDown.val().replace(/__name__/g, nextBlockIndex);

        blocks.append(prototype);

        // reset dropdown
        dropDown.prop('selectedIndex', 0);
    },

    sortable: {
        $: null,
        unloadedEditors: {},

        init: function(jQuery) {
            this.$ = jQuery;

            this.$('.blocks').sortable({
                handle: '.block-name',
                helper: "clone",
            })
            .on('sortstart', this.unloadEditors.bind(this))
            .on('sortstart', this.startSorting.bind(this))
            .on('sortstop', this.loadEditors.bind(this))
            .on('sortstop', this.stopSorting.bind(this))
            .on('sort', this.sortPositioningCorretions.bind(this));

            $('.block-name').hover(function() {
                $(this).parent().addClass('ui-can-sort');
            },function() {
                $(this).parent().removeClass('ui-can-sort');
            });
        },

        unloadEditors: function(e) {
            var editors = this.$(e.toElement).closest('.block').find('.cke');
            var that = this;

            editors.each(function() {
                var editorID = that.$(this).prev().attr("id");
                var instance = CKEDITOR.instances[editorID];

                if (instance) {
                    that.$(this).prev().val(instance.getData());
                    that.unloadedEditors[editorID] = instance.rawConfig;
                    instance.destroy(true);
                }
            });
        },

        loadEditors: function() {
            this.$.each(this.unloadedEditors, function(editorID, config) {
                if(! CKEDITOR.instances[editorID]) {
                    CKEDITOR.replace(editorID, config);
                    CKEDITOR.instances[editorID].rawConfig = config;
                }
            });

            this.unloadedEditors = {};
        },

        startSorting: function(e) {
            var allEditors = this.$(e.toElement).closest('.blocks').find('.cke').css('position','relative');
            allEditors.append('<div class="cke-overlay" style="position:absolute; left:0; top:0; width:100%; height:100%;"></div>');

            // add sorting class when sorting starts
            $('.blocks').addClass('ui-sorting');
        },
        
        stopSorting: function() {
            
            $('.cke-overlay').remove();

            // remove sorting class when sorting ends
            $('.blocks').removeClass('ui-sorting');
        },

        sortPositioningCorretions: function(event, ui) {
            // hack for repositioning sortable helper element
            var helper = $('.ui-sortable-helper');
            var of = helper.parent().offset();
            helper.css({
                left: (event.pageX - of.left) + 'px',
                top: (event.pageY - of.top) + 'px'
            });
        }
    }
};

(function($) {
    blocksBundle.init($);
})(jQuery);
