;(function($, window, document, undefined) {
  
  var PLUGIN_NAME = 'tree',
      PLUGIN_VERSION = '0.1',
      PLUGIN_OPTIONS = {
        branches: 'li',
        helper: {
          open: 'open',
          closed: 'closed',
          hover: 'hover'
        },
        handle: function (branch) {
          return $(branch).children('button[rel="toggle"]');
        },
        identifier: function(branch) {
          return $(branch).data('branch');
        },
        storageKey: function(tree) {
          return $(tree).data('storagekey');
        }
      };
  
  function Plugin(options, element) {
    
    this.name = PLUGIN_NAME;
    this.version = PLUGIN_VERSION;        
    this.opt = PLUGIN_OPTIONS;

    this.$branches = {};
    this.element = element;
    this.$element = $(element);
      
    this.setOptions(options);
    
    this._init();
    
  };
  
  Plugin.prototype = {
    
    _init: function() {
      this.update();
    },
    
    update: function() {
      
      this.$element.find(this.opt.branches).each((function(key, branch) {
        
        var $handle = this.opt.handle(branch),
            identifier = this.opt.identifier(branch);
        
        $handle.unbind('click').bind('click', (function() {
          this.toggle(identifier);
        }).bind(this));
                
        this.$branches[identifier] = $(branch);
                
        if (this._getState(identifier) === true) {
          this.open(identifier);
        } else {
          this.close(identifier);
        }
        
      }).bind(this));
              
    },
    
    setOptions: function(options) {
        this.opt = $.extend(true, {}, this.opt, options);
    },

    getOptions: function() {
        return this.opt;
    },

    options: function(options) {
        return typeof options === 'object' ? this.setOptions(options) : this.getOptions();
    },

    option: function(option, value) {
      if (typeof option === 'string' && this.opt[option]) {
        if (value === undefined) {
          return this.opt[option];
        } else {
          this.opt[option] = value;
        }
      }
    },
    
    _getStates: function() {    
      var states = localStorage.getItem(this.opt.storageKey(this.element));
      return states === null ? {} : JSON.parse(states);
    },
    
    _setStates: function(states) {
      localStorage.setItem(this.opt.storageKey(this.element), JSON.stringify(states));
    },
    
    _getState: function(identifier) {
      var states = this._getStates();
      return Boolean(states[identifier]); 
    },
    
    _setState: function(identifier, state) {
      var states = this._getStates();
      states[identifier] = state;
      this._setStates(states);
    },
    
    open: function(identifier) {
      this._setState(identifier, true);
      this.$branches[identifier].removeClass(this.opt.helper.closed).addClass(this.opt.helper.open);
    },
    
    openAll: function() {
      
      this.$branches.each((function(identifier) {
        this.open(identifier);
      }).bind(this));
      
    },
    
    close: function(identifier) {
      this._setState(identifier, false);
      this.$branches[identifier].removeClass(this.opt.helper.open).addClass(this.opt.helper.closed);
    },
    
    closeAll: function() {
      
      this.$branches.each((function(identifier) {
        this.close(identifier);
      }).bind(this));
      
    },
    
    toggle: function(identifier) {
      
      if (this._getState(identifier) === true) {
        this.close(identifier);
      } else {
        this.open(identifier);
      }
      
    },
    
    toggleAll: function() {
      
      this.$branches.each((function(identifier) {
        this.toggle(identifier);
      }).bind(this));
      
    }
    
  };
  
  $.widget.bridge(PLUGIN_NAME, Plugin);

}(jQuery, window, document));