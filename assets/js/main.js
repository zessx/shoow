// Init
function init() {

    // Init togglers
    var togglers = document.querySelectorAll('[data-toggle]');
    togglers.forEach(function(toggler) {
        var key = toggler.getAttribute('data-toggle');
        var cookie = Cookies.get('toggle_' + key);
        if (cookie && cookie == 0) {
            var targets = document.querySelectorAll('[data-toggle-target="' + key + '"]');
            targets.forEach(function(target) {
                target.classList.add('disabled');
            });
        }
    });

    // Enable togglers
    togglers.forEach(function(toggler) {
        toggler.addEventListener('click', function(event) {
            var key = event.target.getAttribute('data-toggle');
            var targets = document.querySelectorAll('[data-toggle-target="' + key + '"]');
            targets.forEach(function(target) {
                if (target.classList.contains('disabled')) {
                    target.classList.remove('disabled');
                    if (event.target.hasAttribute('data-keep')) {
                        Cookies.remove('toggle_' + key);
                    }
                } else {
                    target.classList.add('disabled');
                    if (event.target.hasAttribute('data-keep')) {
                        Cookies.set('toggle_' + key, 0);
                    }
                }
            });
        });
    });

}
window.addEventListener('DOMContentLoaded', init, false);

// Polyfill: Array.forEach
if (!Array.prototype.forEach) {
  Array.prototype.forEach = function(callback, thisArg) {
    var T, k;
    if (this === null) {
      throw new TypeError(' this vaut null ou n est pas défini');
    }
    var O = Object(this);
    var len = O.length >>> 0;
    if (typeof callback !== "function") {
      throw new TypeError(callback + ' n est pas une fonction');
    }
    if (arguments.length > 1) {
      T = thisArg;
    }
    k = 0;
    while (k < len) {
      var kValue;
      if (k in O) {
        kValue = O[k];
        callback.call(T, kValue, k, O);
      }
      k++;
    }
  };
}

// Polyfills: NodeList.forEach
var arrayMethods = Object.getOwnPropertyNames( Array.prototype );
arrayMethods.forEach( attachArrayMethodsToNodeList );
function attachArrayMethodsToNodeList(methodName) {
    NodeList.prototype[methodName] = Array.prototype[methodName];
};