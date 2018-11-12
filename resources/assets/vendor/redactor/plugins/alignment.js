(function($R)
{
    $R.add('plugin', 'alignment', {
        translations: {
    		en: {
    			"align": "Align",
    			"align-left": "Align Left",
    			"align-center": "Align Center",
    			"align-right": "Align Right",
    			"align-justify": "Align Justify"
    		},
            zh_tw: {
                "align": "對齊",
                "align-left": "靠左對齊",
                "align-center": "置中",
                "align-right": "靠右對齊",
                "align-justify": "左右對齊"
            }
        },
        init: function(app)
        {
            this.app = app;
            this.lang = app.lang;
            this.block = app.block;
            this.toolbar = app.toolbar;
        },
        // public
        start: function()
        {
            var dropdown = {};

    		dropdown.left = { title: this.lang.get('align-left'), api: 'plugin.alignment.set', args: 'left' };
    		dropdown.center = { title: this.lang.get('align-center'), api: 'plugin.alignment.set', args: 'center' };
    		dropdown.right = { title: this.lang.get('align-right'), api: 'plugin.alignment.set', args: 'right' };
    		dropdown.justify = { title: this.lang.get('align-justify'), api: 'plugin.alignment.set', args: 'justify' };

            var $button = this.toolbar.addButton('alignment', { title: this.lang.get('align') });
            $button.setIcon('<i class="re-icon-alignment"></i>');
			$button.setDropdown(dropdown);
        },
        set: function(type)
		{
    		if (type === 'left')
    		{
        		return this._remove();
    		}

    		var args = {
        	    style: { 'text-align': type }
    		};

			this.block.toggle(args);
		},

		// private
		_remove: function()
		{
		    this.block.remove({ style: 'text-align' });
		}
    });
})(Redactor);