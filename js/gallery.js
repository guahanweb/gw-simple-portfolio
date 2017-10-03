(function ($) {
  function Gallery(selector) {
    var self = this;

    this.$container = $(selector);
    this.index = 0;

    if (this.$container) {
      this.$feature = this.$container.find('.feature');
      this.images = this.$feature.find('.img');
      this.$controls = this.$container.find('.controls');
      this.$thumbs = this.$controls.find('.thumbs');

      // analyze all images and indexes
      this.queue = [];
      this.images.each(function (i, img) {
        self.queue[i] = $(img).attr('id');
      });
      this.length = this.queue.length;

      this.listen();

      // initialize (looking for hash)
      var id = (function (hash) {
        if (hash.length > 0) {
          return hash.substr(1);
        }
        return null;
      })(window.location.hash);
      this.selectById(id);
    }
  }

  Gallery.prototype.next = function () {
    this.index++;
    if (this.index == this.length) {
      this.index = 0;
    }
    this.select(this.$thumbs.find('.thumb:eq(' + this.index + ')'));
  };

  Gallery.prototype.prev = function () {
    this.index--;
    if (this.index < 0) {
      this.index = this.length - 1;
    }
    this.select(this.$thumbs.find('.thumb:eq(' + this.index + ')'));
  };

  Gallery.prototype.listen = function () {
    var self = this;

    // manage thumbnail selection
    this.$thumbs.on('click', 'div.thumb > a', function (e) {
      e.preventDefault();
      e.stopPropagation();
      history.pushState(null, null, '#' + $(e.target).data('select'));
      self.select($(e.target));
    });

    // monitor hash change
    window.addEventListener('hashchange', function (e) {
      self.checkDeepLink();
    });
  };

  Gallery.prototype.checkDeepLink = function () {
    var hash = window.location.hash;
    if (hash.length > 0) {
      this.selectById(hash.substr(1), false);
    }
  };

  Gallery.prototype.selectById = function (id, select_default) {
    var default_value = typeof select_default === 'undefined' ? true : !!select_default;
    if (this.queue.indexOf(id) > -1) {
      var $el = this.$thumbs.find('[data-select=' + id + ']');
      this.select($el);
    } else if (default_value) {
      this.select(this.$thumbs.find('[data-select=' + this.queue[0] + ']'));
    }
  };

  Gallery.prototype.select = function ($el) {
    // remove previous
    this.$feature.find('.img.opaque').removeClass('opaque');
    this.$thumbs.find('.thumb.selected').removeClass('selected');

    // select new
    var id = $el.data('select');
    $el.closest('div').addClass('selected');
    this.$feature.find('#' + id).addClass('opaque');
    this.index = this.queue.indexOf(id);
  };

  $(document).ready(function () {
    var gallery = new Gallery('.gw-gallery');
    window.gallery = gallery;
  });
})(jQuery);
