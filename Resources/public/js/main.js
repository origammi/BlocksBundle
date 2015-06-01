'use strict';

var blocksBundle = {
    $: null,

    init: function(jQuery) {
        this.$ = jQuery;
        var addBlockDropDowns  = this.$('.add-block');

        this.$('body').on('click', '.remove-block', this.removeBlock.bind(this));
        addBlockDropDowns.on('change', this.addBlock.bind(this));
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
    }
};

(function($) {
    blocksBundle.init($);
})(jQuery);
