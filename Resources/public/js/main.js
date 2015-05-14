'use strict';

(function($) {
    var addBlockDropDowns  = $('.add-block');

    var removeBlock = function() {
        var $this = $(this);

        // TODO: translations
        if (confirm('Are you sure you want to remove that block?')) {
            if ($this.parent().hasClass('block')) {
                $this.parent().remove();
            }
        }
    };

    var addBlock = function(e) {
        e.preventDefault();

        var dropDown       = $(e.target);
        var blocks         = dropDown.parent().prev();
        var nextBlockIndex = blocks.children().length;
        var prototype      = dropDown.val().replace(/__name__/g, nextBlockIndex);

        blocks.append(prototype);

        // reset dropdown
        dropDown.prop('selectedIndex', 0);
    };

    addBlockDropDowns.on('change', addBlock);
    $('body').on('click', '.remove-block', removeBlock);
})(jQuery);
