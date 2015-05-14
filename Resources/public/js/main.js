"use strict";

(function($) {
    var removeBlockButtons = $('.remove-block');
    var addBlockDropDown   = $('.add-block');

    var removeBlock = function(e) {
        e.preventDefault();

        // TODO: translations
        if (confirm('Are you sure you want to remove that block?')) {
            if (this.parentNode.className === 'block') {
                var block = this.parentNode;

                block.parentNode.removeChild(block);
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

    for (var i=0; i<removeBlockButtons.length; i++) {
        removeBlockButtons[i].addEventListener('click', removeBlock, false);
    }

    addBlockDropDown.on('change', addBlock);
})(jQuery);
