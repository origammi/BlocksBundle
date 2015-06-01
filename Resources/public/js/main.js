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
                handle: '.block-name'
            })
                .on('sortstart', this.unloadEditors.bind(this))
                .on('sortstop', this.loadEditors.bind(this))
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
        }
    }
};

(function($) {
    blocksBundle.init($);
})(jQuery);
