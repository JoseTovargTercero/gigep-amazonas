(self.webpackChunk_am5 = self.webpackChunk_am5 || []).push([
  [7891],
  {
    5650: function (e, t, r) {
      "use strict";
      r.r(t),
        r.d(t, {
          am5themes_Dataviz: function () {
            return s;
          },
        });
      var u = r(5125),
        l = r(1112);
      const s = (function (e) {
        function t() {
          return (null !== e && e.apply(this, arguments)) || this;
        }
        return (
          (0, u.ZT)(t, e),
          Object.defineProperty(t.prototype, "setupDefaultRules", {
            enumerable: !1,
            configurable: !0,
            writable: !0,
            value: function () {
              e.prototype.setupDefaultRules.call(this),
                this.rule("ColorSet").setAll({
                  colors: [
                    l.Il.fromHex(0x69a5ff),
                    l.Il.fromHex(0xd3a850),
                    l.Il.fromHex(0x74b750),
                    l.Il.fromHex(15750208),
                  ],
                  reuse: !1,
                  passOptions: { lightness: 0.05, hue: 0 },
                });
            },
          }),
          t
        );
      })(r(3409).Q);
    },
  },
  function (e) {
    "use strict";
    var t = (5650, e((e.s = 5650))),
      r = window;
    for (var u in t) r[u] = t[u];
    t.__esModule && Object.defineProperty(r, "__esModule", { value: !0 });
  },
]);
//# sourceMappingURL=Dataviz.js.map
