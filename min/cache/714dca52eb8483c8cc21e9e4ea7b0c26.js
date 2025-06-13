/*!
  * Bootstrap v5.1.3 (https://getbootstrap.com/)
  * Copyright 2011-2021 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
  */
!function (t, e) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = e() : "function" == typeof define && define.amd ? define(e) : (t = "undefined" != typeof globalThis ? globalThis : t || self).bootstrap = e()
}(this, (function () {
    "use strict";
    const t = "transitionend", e = t => {
            let e = t.getAttribute("data-bs-target");
            if (!e || "#" === e) {
                let i = t.getAttribute("href");
                if (!i || !i.includes("#") && !i.startsWith(".")) return null;
                i.includes("#") && !i.startsWith("#") && (i = "#" + i.split("#")[1]), e = i && "#" !== i ? i.trim() : null
            }
            return e
        }, i = t => {
            const i = e(t);
            return i && document.querySelector(i) ? i : null
        }, n = t => {
            const i = e(t);
            return i ? document.querySelector(i) : null
        }, s = e => {
            e.dispatchEvent(new Event(t))
        }, o = t => !(!t || "object" != typeof t) && (void 0 !== t.jquery && (t = t[0]), void 0 !== t.nodeType),
        r = t => o(t) ? t.jquery ? t[0] : t : "string" == typeof t && t.length > 0 ? document.querySelector(t) : null,
        a = (t, e, i) => {
            Object.keys(i).forEach(n => {
                const s = i[n], r = e[n],
                    a = r && o(r) ? "element" : null == (l = r) ? "" + l : {}.toString.call(l).match(/\s([a-z]+)/i)[1].toLowerCase();
                var l;
                if (!new RegExp(s).test(a)) throw new TypeError(`${t.toUpperCase()}: Option "${n}" provided type "${a}" but expected type "${s}".`)
            })
        },
        l = t => !(!o(t) || 0 === t.getClientRects().length) && "visible" === getComputedStyle(t).getPropertyValue("visibility"),
        c = t => !t || t.nodeType !== Node.ELEMENT_NODE || !!t.classList.contains("disabled") || (void 0 !== t.disabled ? t.disabled : t.hasAttribute("disabled") && "false" !== t.getAttribute("disabled")),
        h = t => {
            if (!document.documentElement.attachShadow) return null;
            if ("function" == typeof t.getRootNode) {
                const e = t.getRootNode();
                return e instanceof ShadowRoot ? e : null
            }
            return t instanceof ShadowRoot ? t : t.parentNode ? h(t.parentNode) : null
        }, d = () => {
        }, u = t => {
            t.offsetHeight
        }, f = () => {
            const {jQuery: t} = window;
            return t && !document.body.hasAttribute("data-bs-no-jquery") ? t : null
        }, p = [], m = () => "rtl" === document.documentElement.dir, g = t => {
            var e;
            e = () => {
                const e = f();
                if (e) {
                    const i = t.NAME, n = e.fn[i];
                    e.fn[i] = t.jQueryInterface, e.fn[i].Constructor = t, e.fn[i].noConflict = () => (e.fn[i] = n, t.jQueryInterface)
                }
            }, "loading" === document.readyState ? (p.length || document.addEventListener("DOMContentLoaded", () => {
                p.forEach(t => t())
            }), p.push(e)) : e()
        }, _ = t => {
            "function" == typeof t && t()
        }, b = (e, i, n = !0) => {
            if (!n) return void _(e);
            const o = (t => {
                if (!t) return 0;
                let {transitionDuration: e, transitionDelay: i} = window.getComputedStyle(t);
                const n = Number.parseFloat(e), s = Number.parseFloat(i);
                return n || s ? (e = e.split(",")[0], i = i.split(",")[0], 1e3 * (Number.parseFloat(e) + Number.parseFloat(i))) : 0
            })(i) + 5;
            let r = !1;
            const a = ({target: n}) => {
                n === i && (r = !0, i.removeEventListener(t, a), _(e))
            };
            i.addEventListener(t, a), setTimeout(() => {
                r || s(i)
            }, o)
        }, v = (t, e, i, n) => {
            let s = t.indexOf(e);
            if (-1 === s) return t[!i && n ? t.length - 1 : 0];
            const o = t.length;
            return s += i ? 1 : -1, n && (s = (s + o) % o), t[Math.max(0, Math.min(s, o - 1))]
        }, y = /[^.]*(?=\..*)\.|.*/, w = /\..*/, E = /::\d+$/, A = {};
    let T = 1;
    const O = {mouseenter: "mouseover", mouseleave: "mouseout"}, C = /^(mouseenter|mouseleave)/i,
        k = new Set(["click", "dblclick", "mouseup", "mousedown", "contextmenu", "mousewheel", "DOMMouseScroll", "mouseover", "mouseout", "mousemove", "selectstart", "selectend", "keydown", "keypress", "keyup", "orientationchange", "touchstart", "touchmove", "touchend", "touchcancel", "pointerdown", "pointermove", "pointerup", "pointerleave", "pointercancel", "gesturestart", "gesturechange", "gestureend", "focus", "blur", "change", "reset", "select", "submit", "focusin", "focusout", "load", "unload", "beforeunload", "resize", "move", "DOMContentLoaded", "readystatechange", "error", "abort", "scroll"]);

    function L(t, e) {
        return e && `${e}::${T++}` || t.uidEvent || T++
    }

    function x(t) {
        const e = L(t);
        return t.uidEvent = e, A[e] = A[e] || {}, A[e]
    }

    function D(t, e, i = null) {
        const n = Object.keys(t);
        for (let s = 0, o = n.length; s < o; s++) {
            const o = t[n[s]];
            if (o.originalHandler === e && o.delegationSelector === i) return o
        }
        return null
    }

    function S(t, e, i) {
        const n = "string" == typeof e, s = n ? i : e;
        let o = P(t);
        return k.has(o) || (o = t), [n, s, o]
    }

    function N(t, e, i, n, s) {
        if ("string" != typeof e || !t) return;
        if (i || (i = n, n = null), C.test(e)) {
            const t = t => function (e) {
                if (!e.relatedTarget || e.relatedTarget !== e.delegateTarget && !e.delegateTarget.contains(e.relatedTarget)) return t.call(this, e)
            };
            n ? n = t(n) : i = t(i)
        }
        const [o, r, a] = S(e, i, n), l = x(t), c = l[a] || (l[a] = {}), h = D(c, r, o ? i : null);
        if (h) return void (h.oneOff = h.oneOff && s);
        const d = L(r, e.replace(y, "")), u = o ? function (t, e, i) {
            return function n(s) {
                const o = t.querySelectorAll(e);
                for (let {target: r} = s; r && r !== this; r = r.parentNode) for (let a = o.length; a--;) if (o[a] === r) return s.delegateTarget = r, n.oneOff && j.off(t, s.type, e, i), i.apply(r, [s]);
                return null
            }
        }(t, i, n) : function (t, e) {
            return function i(n) {
                return n.delegateTarget = t, i.oneOff && j.off(t, n.type, e), e.apply(t, [n])
            }
        }(t, i);
        u.delegationSelector = o ? i : null, u.originalHandler = r, u.oneOff = s, u.uidEvent = d, c[d] = u, t.addEventListener(a, u, o)
    }

    function I(t, e, i, n, s) {
        const o = D(e[i], n, s);
        o && (t.removeEventListener(i, o, Boolean(s)), delete e[i][o.uidEvent])
    }

    function P(t) {
        return t = t.replace(w, ""), O[t] || t
    }

    const j = {
        on(t, e, i, n) {
            N(t, e, i, n, !1)
        }, one(t, e, i, n) {
            N(t, e, i, n, !0)
        }, off(t, e, i, n) {
            if ("string" != typeof e || !t) return;
            const [s, o, r] = S(e, i, n), a = r !== e, l = x(t), c = e.startsWith(".");
            if (void 0 !== o) {
                if (!l || !l[r]) return;
                return void I(t, l, r, o, s ? i : null)
            }
            c && Object.keys(l).forEach(i => {
                !function (t, e, i, n) {
                    const s = e[i] || {};
                    Object.keys(s).forEach(o => {
                        if (o.includes(n)) {
                            const n = s[o];
                            I(t, e, i, n.originalHandler, n.delegationSelector)
                        }
                    })
                }(t, l, i, e.slice(1))
            });
            const h = l[r] || {};
            Object.keys(h).forEach(i => {
                const n = i.replace(E, "");
                if (!a || e.includes(n)) {
                    const e = h[i];
                    I(t, l, r, e.originalHandler, e.delegationSelector)
                }
            })
        }, trigger(t, e, i) {
            if ("string" != typeof e || !t) return null;
            const n = f(), s = P(e), o = e !== s, r = k.has(s);
            let a, l = !0, c = !0, h = !1, d = null;
            return o && n && (a = n.Event(e, i), n(t).trigger(a), l = !a.isPropagationStopped(), c = !a.isImmediatePropagationStopped(), h = a.isDefaultPrevented()), r ? (d = document.createEvent("HTMLEvents"), d.initEvent(s, l, !0)) : d = new CustomEvent(e, {
                bubbles: l,
                cancelable: !0
            }), void 0 !== i && Object.keys(i).forEach(t => {
                Object.defineProperty(d, t, {get: () => i[t]})
            }), h && d.preventDefault(), c && t.dispatchEvent(d), d.defaultPrevented && void 0 !== a && a.preventDefault(), d
        }
    }, M = new Map, H = {
        set(t, e, i) {
            M.has(t) || M.set(t, new Map);
            const n = M.get(t);
            n.has(e) || 0 === n.size ? n.set(e, i) : console.error(`Bootstrap doesn't allow more than one instance per element. Bound instance: ${Array.from(n.keys())[0]}.`)
        }, get: (t, e) => M.has(t) && M.get(t).get(e) || null, remove(t, e) {
            if (!M.has(t)) return;
            const i = M.get(t);
            i.delete(e), 0 === i.size && M.delete(t)
        }
    };

    class B {
        constructor(t) {
            (t = r(t)) && (this._element = t, H.set(this._element, this.constructor.DATA_KEY, this))
        }

        dispose() {
            H.remove(this._element, this.constructor.DATA_KEY), j.off(this._element, this.constructor.EVENT_KEY), Object.getOwnPropertyNames(this).forEach(t => {
                this[t] = null
            })
        }

        _queueCallback(t, e, i = !0) {
            b(t, e, i)
        }

        static getInstance(t) {
            return H.get(r(t), this.DATA_KEY)
        }

        static getOrCreateInstance(t, e = {}) {
            return this.getInstance(t) || new this(t, "object" == typeof e ? e : null)
        }

        static get VERSION() {
            return "5.1.3"
        }

        static get NAME() {
            throw new Error('You have to implement the static method "NAME", for each component!')
        }

        static get DATA_KEY() {
            return "bs." + this.NAME
        }

        static get EVENT_KEY() {
            return "." + this.DATA_KEY
        }
    }

    const R = (t, e = "hide") => {
        const i = "click.dismiss" + t.EVENT_KEY, s = t.NAME;
        j.on(document, i, `[data-bs-dismiss="${s}"]`, (function (i) {
            if (["A", "AREA"].includes(this.tagName) && i.preventDefault(), c(this)) return;
            const o = n(this) || this.closest("." + s);
            t.getOrCreateInstance(o)[e]()
        }))
    };

    class W extends B {
        static get NAME() {
            return "alert"
        }

        close() {
            if (j.trigger(this._element, "close.bs.alert").defaultPrevented) return;
            this._element.classList.remove("show");
            const t = this._element.classList.contains("fade");
            this._queueCallback(() => this._destroyElement(), this._element, t)
        }

        _destroyElement() {
            this._element.remove(), j.trigger(this._element, "closed.bs.alert"), this.dispose()
        }

        static jQueryInterface(t) {
            return this.each((function () {
                const e = W.getOrCreateInstance(this);
                if ("string" == typeof t) {
                    if (void 0 === e[t] || t.startsWith("_") || "constructor" === t) throw new TypeError(`No method named "${t}"`);
                    e[t](this)
                }
            }))
        }
    }

    R(W, "close"), g(W);
    const z = '[data-bs-toggle="button"]';

    class q extends B {
        static get NAME() {
            return "button"
        }

        toggle() {
            this._element.setAttribute("aria-pressed", this._element.classList.toggle("active"))
        }

        static jQueryInterface(t) {
            return this.each((function () {
                const e = q.getOrCreateInstance(this);
                "toggle" === t && e[t]()
            }))
        }
    }

    function F(t) {
        return "true" === t || "false" !== t && (t === Number(t).toString() ? Number(t) : "" === t || "null" === t ? null : t)
    }

    function $(t) {
        return t.replace(/[A-Z]/g, t => "-" + t.toLowerCase())
    }

    j.on(document, "click.bs.button.data-api", z, t => {
        t.preventDefault();
        const e = t.target.closest(z);
        q.getOrCreateInstance(e).toggle()
    }), g(q);
    const U = {
            setDataAttribute(t, e, i) {
                t.setAttribute("data-bs-" + $(e), i)
            }, removeDataAttribute(t, e) {
                t.removeAttribute("data-bs-" + $(e))
            }, getDataAttributes(t) {
                if (!t) return {};
                const e = {};
                return Object.keys(t.dataset).filter(t => t.startsWith("bs")).forEach(i => {
                    let n = i.replace(/^bs/, "");
                    n = n.charAt(0).toLowerCase() + n.slice(1, n.length), e[n] = F(t.dataset[i])
                }), e
            }, getDataAttribute: (t, e) => F(t.getAttribute("data-bs-" + $(e))), offset(t) {
                const e = t.getBoundingClientRect();
                return {top: e.top + window.pageYOffset, left: e.left + window.pageXOffset}
            }, position: t => ({top: t.offsetTop, left: t.offsetLeft})
        }, V = {
            find: (t, e = document.documentElement) => [].concat(...Element.prototype.querySelectorAll.call(e, t)),
            findOne: (t, e = document.documentElement) => Element.prototype.querySelector.call(e, t),
            children: (t, e) => [].concat(...t.children).filter(t => t.matches(e)),
            parents(t, e) {
                const i = [];
                let n = t.parentNode;
                for (; n && n.nodeType === Node.ELEMENT_NODE && 3 !== n.nodeType;) n.matches(e) && i.push(n), n = n.parentNode;
                return i
            },
            prev(t, e) {
                let i = t.previousElementSibling;
                for (; i;) {
                    if (i.matches(e)) return [i];
                    i = i.previousElementSibling
                }
                return []
            },
            next(t, e) {
                let i = t.nextElementSibling;
                for (; i;) {
                    if (i.matches(e)) return [i];
                    i = i.nextElementSibling
                }
                return []
            },
            focusableChildren(t) {
                const e = ["a", "button", "input", "textarea", "select", "details", "[tabindex]", '[contenteditable="true"]'].map(t => t + ':not([tabindex^="-"])').join(", ");
                return this.find(e, t).filter(t => !c(t) && l(t))
            }
        }, K = "carousel", X = {interval: 5e3, keyboard: !0, slide: !1, pause: "hover", wrap: !0, touch: !0}, Y = {
            interval: "(number|boolean)",
            keyboard: "boolean",
            slide: "(boolean|string)",
            pause: "(string|boolean)",
            wrap: "boolean",
            touch: "boolean"
        }, Q = "next", G = "prev", Z = "left", J = "right", tt = {ArrowLeft: J, ArrowRight: Z}, et = "slid.bs.carousel",
        it = "active", nt = ".active.carousel-item";

    class st extends B {
        constructor(t, e) {
            super(t), this._items = null, this._interval = null, this._activeElement = null, this._isPaused = !1, this._isSliding = !1, this.touchTimeout = null, this.touchStartX = 0, this.touchDeltaX = 0, this._config = this._getConfig(e), this._indicatorsElement = V.findOne(".carousel-indicators", this._element), this._touchSupported = "ontouchstart" in document.documentElement || navigator.maxTouchPoints > 0, this._pointerEvent = Boolean(window.PointerEvent), this._addEventListeners()
        }

        static get Default() {
            return X
        }

        static get NAME() {
            return K
        }

        next() {
            this._slide(Q)
        }

        nextWhenVisible() {
            !document.hidden && l(this._element) && this.next()
        }

        prev() {
            this._slide(G)
        }

        pause(t) {
            t || (this._isPaused = !0), V.findOne(".carousel-item-next, .carousel-item-prev", this._element) && (s(this._element), this.cycle(!0)), clearInterval(this._interval), this._interval = null
        }

        cycle(t) {
            t || (this._isPaused = !1), this._interval && (clearInterval(this._interval), this._interval = null), this._config && this._config.interval && !this._isPaused && (this._updateInterval(), this._interval = setInterval((document.visibilityState ? this.nextWhenVisible : this.next).bind(this), this._config.interval))
        }

        to(t) {
            this._activeElement = V.findOne(nt, this._element);
            const e = this._getItemIndex(this._activeElement);
            if (t > this._items.length - 1 || t < 0) return;
            if (this._isSliding) return void j.one(this._element, et, () => this.to(t));
            if (e === t) return this.pause(), void this.cycle();
            const i = t > e ? Q : G;
            this._slide(i, this._items[t])
        }

        _getConfig(t) {
            return t = {...X, ...U.getDataAttributes(this._element), ..."object" == typeof t ? t : {}}, a(K, t, Y), t
        }

        _handleSwipe() {
            const t = Math.abs(this.touchDeltaX);
            if (t <= 40) return;
            const e = t / this.touchDeltaX;
            this.touchDeltaX = 0, e && this._slide(e > 0 ? J : Z)
        }

        _addEventListeners() {
            this._config.keyboard && j.on(this._element, "keydown.bs.carousel", t => this._keydown(t)), "hover" === this._config.pause && (j.on(this._element, "mouseenter.bs.carousel", t => this.pause(t)), j.on(this._element, "mouseleave.bs.carousel", t => this.cycle(t))), this._config.touch && this._touchSupported && this._addTouchEventListeners()
        }

        _addTouchEventListeners() {
            const t = t => this._pointerEvent && ("pen" === t.pointerType || "touch" === t.pointerType), e = e => {
                t(e) ? this.touchStartX = e.clientX : this._pointerEvent || (this.touchStartX = e.touches[0].clientX)
            }, i = t => {
                this.touchDeltaX = t.touches && t.touches.length > 1 ? 0 : t.touches[0].clientX - this.touchStartX
            }, n = e => {
                t(e) && (this.touchDeltaX = e.clientX - this.touchStartX), this._handleSwipe(), "hover" === this._config.pause && (this.pause(), this.touchTimeout && clearTimeout(this.touchTimeout), this.touchTimeout = setTimeout(t => this.cycle(t), 500 + this._config.interval))
            };
            V.find(".carousel-item img", this._element).forEach(t => {
                j.on(t, "dragstart.bs.carousel", t => t.preventDefault())
            }), this._pointerEvent ? (j.on(this._element, "pointerdown.bs.carousel", t => e(t)), j.on(this._element, "pointerup.bs.carousel", t => n(t)), this._element.classList.add("pointer-event")) : (j.on(this._element, "touchstart.bs.carousel", t => e(t)), j.on(this._element, "touchmove.bs.carousel", t => i(t)), j.on(this._element, "touchend.bs.carousel", t => n(t)))
        }

        _keydown(t) {
            if (/input|textarea/i.test(t.target.tagName)) return;
            const e = tt[t.key];
            e && (t.preventDefault(), this._slide(e))
        }

        _getItemIndex(t) {
            return this._items = t && t.parentNode ? V.find(".carousel-item", t.parentNode) : [], this._items.indexOf(t)
        }

        _getItemByOrder(t, e) {
            const i = t === Q;
            return v(this._items, e, i, this._config.wrap)
        }

        _triggerSlideEvent(t, e) {
            const i = this._getItemIndex(t), n = this._getItemIndex(V.findOne(nt, this._element));
            return j.trigger(this._element, "slide.bs.carousel", {relatedTarget: t, direction: e, from: n, to: i})
        }

        _setActiveIndicatorElement(t) {
            if (this._indicatorsElement) {
                const e = V.findOne(".active", this._indicatorsElement);
                e.classList.remove(it), e.removeAttribute("aria-current");
                const i = V.find("[data-bs-target]", this._indicatorsElement);
                for (let e = 0; e < i.length; e++) if (Number.parseInt(i[e].getAttribute("data-bs-slide-to"), 10) === this._getItemIndex(t)) {
                    i[e].classList.add(it), i[e].setAttribute("aria-current", "true");
                    break
                }
            }
        }

        _updateInterval() {
            const t = this._activeElement || V.findOne(nt, this._element);
            if (!t) return;
            const e = Number.parseInt(t.getAttribute("data-bs-interval"), 10);
            e ? (this._config.defaultInterval = this._config.defaultInterval || this._config.interval, this._config.interval = e) : this._config.interval = this._config.defaultInterval || this._config.interval
        }

        _slide(t, e) {
            const i = this._directionToOrder(t), n = V.findOne(nt, this._element), s = this._getItemIndex(n),
                o = e || this._getItemByOrder(i, n), r = this._getItemIndex(o), a = Boolean(this._interval),
                l = i === Q, c = l ? "carousel-item-start" : "carousel-item-end",
                h = l ? "carousel-item-next" : "carousel-item-prev", d = this._orderToDirection(i);
            if (o && o.classList.contains(it)) return void (this._isSliding = !1);
            if (this._isSliding) return;
            if (this._triggerSlideEvent(o, d).defaultPrevented) return;
            if (!n || !o) return;
            this._isSliding = !0, a && this.pause(), this._setActiveIndicatorElement(o), this._activeElement = o;
            const f = () => {
                j.trigger(this._element, et, {relatedTarget: o, direction: d, from: s, to: r})
            };
            if (this._element.classList.contains("slide")) {
                o.classList.add(h), u(o), n.classList.add(c), o.classList.add(c);
                const t = () => {
                    o.classList.remove(c, h), o.classList.add(it), n.classList.remove(it, h, c), this._isSliding = !1, setTimeout(f, 0)
                };
                this._queueCallback(t, n, !0)
            } else n.classList.remove(it), o.classList.add(it), this._isSliding = !1, f();
            a && this.cycle()
        }

        _directionToOrder(t) {
            return [J, Z].includes(t) ? m() ? t === Z ? G : Q : t === Z ? Q : G : t
        }

        _orderToDirection(t) {
            return [Q, G].includes(t) ? m() ? t === G ? Z : J : t === G ? J : Z : t
        }

        static carouselInterface(t, e) {
            const i = st.getOrCreateInstance(t, e);
            let {_config: n} = i;
            "object" == typeof e && (n = {...n, ...e});
            const s = "string" == typeof e ? e : n.slide;
            if ("number" == typeof e) i.to(e); else if ("string" == typeof s) {
                if (void 0 === i[s]) throw new TypeError(`No method named "${s}"`);
                i[s]()
            } else n.interval && n.ride && (i.pause(), i.cycle())
        }

        static jQueryInterface(t) {
            return this.each((function () {
                st.carouselInterface(this, t)
            }))
        }

        static dataApiClickHandler(t) {
            const e = n(this);
            if (!e || !e.classList.contains("carousel")) return;
            const i = {...U.getDataAttributes(e), ...U.getDataAttributes(this)},
                s = this.getAttribute("data-bs-slide-to");
            s && (i.interval = !1), st.carouselInterface(e, i), s && st.getInstance(e).to(s), t.preventDefault()
        }
    }

    j.on(document, "click.bs.carousel.data-api", "[data-bs-slide], [data-bs-slide-to]", st.dataApiClickHandler), j.on(window, "load.bs.carousel.data-api", () => {
        const t = V.find('[data-bs-ride="carousel"]');
        for (let e = 0, i = t.length; e < i; e++) st.carouselInterface(t[e], st.getInstance(t[e]))
    }), g(st);
    const ot = "collapse", rt = {toggle: !0, parent: null}, at = {toggle: "boolean", parent: "(null|element)"},
        lt = "show", ct = "collapse", ht = "collapsing", dt = "collapsed", ut = ":scope .collapse .collapse",
        ft = '[data-bs-toggle="collapse"]';

    class pt extends B {
        constructor(t, e) {
            super(t), this._isTransitioning = !1, this._config = this._getConfig(e), this._triggerArray = [];
            const n = V.find(ft);
            for (let t = 0, e = n.length; t < e; t++) {
                const e = n[t], s = i(e), o = V.find(s).filter(t => t === this._element);
                null !== s && o.length && (this._selector = s, this._triggerArray.push(e))
            }
            this._initializeChildren(), this._config.parent || this._addAriaAndCollapsedClass(this._triggerArray, this._isShown()), this._config.toggle && this.toggle()
        }

        static get Default() {
            return rt
        }

        static get NAME() {
            return ot
        }

        toggle() {
            this._isShown() ? this.hide() : this.show()
        }

        show() {
            if (this._isTransitioning || this._isShown()) return;
            let t, e = [];
            if (this._config.parent) {
                const t = V.find(ut, this._config.parent);
                e = V.find(".collapse.show, .collapse.collapsing", this._config.parent).filter(e => !t.includes(e))
            }
            const i = V.findOne(this._selector);
            if (e.length) {
                const n = e.find(t => i !== t);
                if (t = n ? pt.getInstance(n) : null, t && t._isTransitioning) return
            }
            if (j.trigger(this._element, "show.bs.collapse").defaultPrevented) return;
            e.forEach(e => {
                i !== e && pt.getOrCreateInstance(e, {toggle: !1}).hide(), t || H.set(e, "bs.collapse", null)
            });
            const n = this._getDimension();
            this._element.classList.remove(ct), this._element.classList.add(ht), this._element.style[n] = 0, this._addAriaAndCollapsedClass(this._triggerArray, !0), this._isTransitioning = !0;
            const s = "scroll" + (n[0].toUpperCase() + n.slice(1));
            this._queueCallback(() => {
                this._isTransitioning = !1, this._element.classList.remove(ht), this._element.classList.add(ct, lt), this._element.style[n] = "", j.trigger(this._element, "shown.bs.collapse")
            }, this._element, !0), this._element.style[n] = this._element[s] + "px"
        }

        hide() {
            if (this._isTransitioning || !this._isShown()) return;
            if (j.trigger(this._element, "hide.bs.collapse").defaultPrevented) return;
            const t = this._getDimension();
            this._element.style[t] = this._element.getBoundingClientRect()[t] + "px", u(this._element), this._element.classList.add(ht), this._element.classList.remove(ct, lt);
            const e = this._triggerArray.length;
            for (let t = 0; t < e; t++) {
                const e = this._triggerArray[t], i = n(e);
                i && !this._isShown(i) && this._addAriaAndCollapsedClass([e], !1)
            }
            this._isTransitioning = !0, this._element.style[t] = "", this._queueCallback(() => {
                this._isTransitioning = !1, this._element.classList.remove(ht), this._element.classList.add(ct), j.trigger(this._element, "hidden.bs.collapse")
            }, this._element, !0)
        }

        _isShown(t = this._element) {
            return t.classList.contains(lt)
        }

        _getConfig(t) {
            return (t = {...rt, ...U.getDataAttributes(this._element), ...t}).toggle = Boolean(t.toggle), t.parent = r(t.parent), a(ot, t, at), t
        }

        _getDimension() {
            return this._element.classList.contains("collapse-horizontal") ? "width" : "height"
        }

        _initializeChildren() {
            if (!this._config.parent) return;
            const t = V.find(ut, this._config.parent);
            V.find(ft, this._config.parent).filter(e => !t.includes(e)).forEach(t => {
                const e = n(t);
                e && this._addAriaAndCollapsedClass([t], this._isShown(e))
            })
        }

        _addAriaAndCollapsedClass(t, e) {
            t.length && t.forEach(t => {
                e ? t.classList.remove(dt) : t.classList.add(dt), t.setAttribute("aria-expanded", e)
            })
        }

        static jQueryInterface(t) {
            return this.each((function () {
                const e = {};
                "string" == typeof t && /show|hide/.test(t) && (e.toggle = !1);
                const i = pt.getOrCreateInstance(this, e);
                if ("string" == typeof t) {
                    if (void 0 === i[t]) throw new TypeError(`No method named "${t}"`);
                    i[t]()
                }
            }))
        }
    }

    j.on(document, "click.bs.collapse.data-api", ft, (function (t) {
        ("A" === t.target.tagName || t.delegateTarget && "A" === t.delegateTarget.tagName) && t.preventDefault();
        const e = i(this);
        V.find(e).forEach(t => {
            pt.getOrCreateInstance(t, {toggle: !1}).toggle()
        })
    })), g(pt);
    var mt = "top", gt = "bottom", _t = "right", bt = "left", vt = "auto", yt = [mt, gt, _t, bt], wt = "start",
        Et = "end", At = "clippingParents", Tt = "viewport", Ot = "popper", Ct = "reference",
        kt = yt.reduce((function (t, e) {
            return t.concat([e + "-" + wt, e + "-" + Et])
        }), []), Lt = [].concat(yt, [vt]).reduce((function (t, e) {
            return t.concat([e, e + "-" + wt, e + "-" + Et])
        }), []), xt = "beforeRead", Dt = "afterRead", St = "beforeMain", Nt = "afterMain", It = "beforeWrite",
        Pt = "afterWrite", jt = [xt, "read", Dt, St, "main", Nt, It, "write", Pt];

    function Mt(t) {
        return t ? (t.nodeName || "").toLowerCase() : null
    }

    function Ht(t) {
        if (null == t) return window;
        if ("[object Window]" !== t.toString()) {
            var e = t.ownerDocument;
            return e && e.defaultView || window
        }
        return t
    }

    function Bt(t) {
        return t instanceof Ht(t).Element || t instanceof Element
    }

    function Rt(t) {
        return t instanceof Ht(t).HTMLElement || t instanceof HTMLElement
    }

    function Wt(t) {
        return "undefined" != typeof ShadowRoot && (t instanceof Ht(t).ShadowRoot || t instanceof ShadowRoot)
    }

    const zt = {
        name: "applyStyles", enabled: !0, phase: "write", fn: function (t) {
            var e = t.state;
            Object.keys(e.elements).forEach((function (t) {
                var i = e.styles[t] || {}, n = e.attributes[t] || {}, s = e.elements[t];
                Rt(s) && Mt(s) && (Object.assign(s.style, i), Object.keys(n).forEach((function (t) {
                    var e = n[t];
                    !1 === e ? s.removeAttribute(t) : s.setAttribute(t, !0 === e ? "" : e)
                })))
            }))
        }, effect: function (t) {
            var e = t.state, i = {
                popper: {position: e.options.strategy, left: "0", top: "0", margin: "0"},
                arrow: {position: "absolute"},
                reference: {}
            };
            return Object.assign(e.elements.popper.style, i.popper), e.styles = i, e.elements.arrow && Object.assign(e.elements.arrow.style, i.arrow), function () {
                Object.keys(e.elements).forEach((function (t) {
                    var n = e.elements[t], s = e.attributes[t] || {},
                        o = Object.keys(e.styles.hasOwnProperty(t) ? e.styles[t] : i[t]).reduce((function (t, e) {
                            return t[e] = "", t
                        }), {});
                    Rt(n) && Mt(n) && (Object.assign(n.style, o), Object.keys(s).forEach((function (t) {
                        n.removeAttribute(t)
                    })))
                }))
            }
        }, requires: ["computeStyles"]
    };

    function qt(t) {
        return t.split("-")[0]
    }

    function Ft(t, e) {
        var i = t.getBoundingClientRect();
        return {
            width: i.width / 1,
            height: i.height / 1,
            top: i.top / 1,
            right: i.right / 1,
            bottom: i.bottom / 1,
            left: i.left / 1,
            x: i.left / 1,
            y: i.top / 1
        }
    }

    function $t(t) {
        var e = Ft(t), i = t.offsetWidth, n = t.offsetHeight;
        return Math.abs(e.width - i) <= 1 && (i = e.width), Math.abs(e.height - n) <= 1 && (n = e.height), {
            x: t.offsetLeft,
            y: t.offsetTop,
            width: i,
            height: n
        }
    }

    function Ut(t, e) {
        var i = e.getRootNode && e.getRootNode();
        if (t.contains(e)) return !0;
        if (i && Wt(i)) {
            var n = e;
            do {
                if (n && t.isSameNode(n)) return !0;
                n = n.parentNode || n.host
            } while (n)
        }
        return !1
    }

    function Vt(t) {
        return Ht(t).getComputedStyle(t)
    }

    function Kt(t) {
        return ["table", "td", "th"].indexOf(Mt(t)) >= 0
    }

    function Xt(t) {
        return ((Bt(t) ? t.ownerDocument : t.document) || window.document).documentElement
    }

    function Yt(t) {
        return "html" === Mt(t) ? t : t.assignedSlot || t.parentNode || (Wt(t) ? t.host : null) || Xt(t)
    }

    function Qt(t) {
        return Rt(t) && "fixed" !== Vt(t).position ? t.offsetParent : null
    }

    function Gt(t) {
        for (var e = Ht(t), i = Qt(t); i && Kt(i) && "static" === Vt(i).position;) i = Qt(i);
        return i && ("html" === Mt(i) || "body" === Mt(i) && "static" === Vt(i).position) ? e : i || function (t) {
            var e = -1 !== navigator.userAgent.toLowerCase().indexOf("firefox");
            if (-1 !== navigator.userAgent.indexOf("Trident") && Rt(t) && "fixed" === Vt(t).position) return null;
            for (var i = Yt(t); Rt(i) && ["html", "body"].indexOf(Mt(i)) < 0;) {
                var n = Vt(i);
                if ("none" !== n.transform || "none" !== n.perspective || "paint" === n.contain || -1 !== ["transform", "perspective"].indexOf(n.willChange) || e && "filter" === n.willChange || e && n.filter && "none" !== n.filter) return i;
                i = i.parentNode
            }
            return null
        }(t) || e
    }

    function Zt(t) {
        return ["top", "bottom"].indexOf(t) >= 0 ? "x" : "y"
    }

    var Jt = Math.max, te = Math.min, ee = Math.round;

    function ie(t, e, i) {
        return Jt(t, te(e, i))
    }

    function ne(t) {
        return Object.assign({}, {top: 0, right: 0, bottom: 0, left: 0}, t)
    }

    function se(t, e) {
        return e.reduce((function (e, i) {
            return e[i] = t, e
        }), {})
    }

    const oe = {
        name: "arrow", enabled: !0, phase: "main", fn: function (t) {
            var e, i = t.state, n = t.name, s = t.options, o = i.elements.arrow, r = i.modifiersData.popperOffsets,
                a = qt(i.placement), l = Zt(a), c = [bt, _t].indexOf(a) >= 0 ? "height" : "width";
            if (o && r) {
                var h = function (t, e) {
                        return ne("number" != typeof (t = "function" == typeof t ? t(Object.assign({}, e.rects, {placement: e.placement})) : t) ? t : se(t, yt))
                    }(s.padding, i), d = $t(o), u = "y" === l ? mt : bt, f = "y" === l ? gt : _t,
                    p = i.rects.reference[c] + i.rects.reference[l] - r[l] - i.rects.popper[c],
                    m = r[l] - i.rects.reference[l], g = Gt(o),
                    _ = g ? "y" === l ? g.clientHeight || 0 : g.clientWidth || 0 : 0, b = p / 2 - m / 2, v = h[u],
                    y = _ - d[c] - h[f], w = _ / 2 - d[c] / 2 + b, E = ie(v, w, y), A = l;
                i.modifiersData[n] = ((e = {})[A] = E, e.centerOffset = E - w, e)
            }
        }, effect: function (t) {
            var e = t.state, i = t.options.element, n = void 0 === i ? "[data-popper-arrow]" : i;
            null != n && ("string" != typeof n || (n = e.elements.popper.querySelector(n))) && Ut(e.elements.popper, n) && (e.elements.arrow = n)
        }, requires: ["popperOffsets"], requiresIfExists: ["preventOverflow"]
    };

    function re(t) {
        return t.split("-")[1]
    }

    var ae = {top: "auto", right: "auto", bottom: "auto", left: "auto"};

    function le(t) {
        var e, i = t.popper, n = t.popperRect, s = t.placement, o = t.variation, r = t.offsets, a = t.position,
            l = t.gpuAcceleration, c = t.adaptive, h = t.roundOffsets, d = !0 === h ? function (t) {
                var e = t.x, i = t.y, n = window.devicePixelRatio || 1;
                return {x: ee(ee(e * n) / n) || 0, y: ee(ee(i * n) / n) || 0}
            }(r) : "function" == typeof h ? h(r) : r, u = d.x, f = void 0 === u ? 0 : u, p = d.y, m = void 0 === p ? 0 : p,
            g = r.hasOwnProperty("x"), _ = r.hasOwnProperty("y"), b = bt, v = mt, y = window;
        if (c) {
            var w = Gt(i), E = "clientHeight", A = "clientWidth";
            w === Ht(i) && "static" !== Vt(w = Xt(i)).position && "absolute" === a && (E = "scrollHeight", A = "scrollWidth"), w = w, s !== mt && (s !== bt && s !== _t || o !== Et) || (v = gt, m -= w[E] - n.height, m *= l ? 1 : -1), s !== bt && (s !== mt && s !== gt || o !== Et) || (b = _t, f -= w[A] - n.width, f *= l ? 1 : -1)
        }
        var T, O = Object.assign({position: a}, c && ae);
        return l ? Object.assign({}, O, ((T = {})[v] = _ ? "0" : "", T[b] = g ? "0" : "", T.transform = (y.devicePixelRatio || 1) <= 1 ? "translate(" + f + "px, " + m + "px)" : "translate3d(" + f + "px, " + m + "px, 0)", T)) : Object.assign({}, O, ((e = {})[v] = _ ? m + "px" : "", e[b] = g ? f + "px" : "", e.transform = "", e))
    }

    const ce = {
        name: "computeStyles", enabled: !0, phase: "beforeWrite", fn: function (t) {
            var e = t.state, i = t.options, n = i.gpuAcceleration, s = void 0 === n || n, o = i.adaptive,
                r = void 0 === o || o, a = i.roundOffsets, l = void 0 === a || a, c = {
                    placement: qt(e.placement),
                    variation: re(e.placement),
                    popper: e.elements.popper,
                    popperRect: e.rects.popper,
                    gpuAcceleration: s
                };
            null != e.modifiersData.popperOffsets && (e.styles.popper = Object.assign({}, e.styles.popper, le(Object.assign({}, c, {
                offsets: e.modifiersData.popperOffsets,
                position: e.options.strategy,
                adaptive: r,
                roundOffsets: l
            })))), null != e.modifiersData.arrow && (e.styles.arrow = Object.assign({}, e.styles.arrow, le(Object.assign({}, c, {
                offsets: e.modifiersData.arrow,
                position: "absolute",
                adaptive: !1,
                roundOffsets: l
            })))), e.attributes.popper = Object.assign({}, e.attributes.popper, {"data-popper-placement": e.placement})
        }, data: {}
    };
    var he = {passive: !0};
    const de = {
        name: "eventListeners", enabled: !0, phase: "write", fn: function () {
        }, effect: function (t) {
            var e = t.state, i = t.instance, n = t.options, s = n.scroll, o = void 0 === s || s, r = n.resize,
                a = void 0 === r || r, l = Ht(e.elements.popper),
                c = [].concat(e.scrollParents.reference, e.scrollParents.popper);
            return o && c.forEach((function (t) {
                t.addEventListener("scroll", i.update, he)
            })), a && l.addEventListener("resize", i.update, he), function () {
                o && c.forEach((function (t) {
                    t.removeEventListener("scroll", i.update, he)
                })), a && l.removeEventListener("resize", i.update, he)
            }
        }, data: {}
    };
    var ue = {left: "right", right: "left", bottom: "top", top: "bottom"};

    function fe(t) {
        return t.replace(/left|right|bottom|top/g, (function (t) {
            return ue[t]
        }))
    }

    var pe = {start: "end", end: "start"};

    function me(t) {
        return t.replace(/start|end/g, (function (t) {
            return pe[t]
        }))
    }

    function ge(t) {
        var e = Ht(t);
        return {scrollLeft: e.pageXOffset, scrollTop: e.pageYOffset}
    }

    function _e(t) {
        return Ft(Xt(t)).left + ge(t).scrollLeft
    }

    function be(t) {
        var e = Vt(t), i = e.overflow, n = e.overflowX, s = e.overflowY;
        return /auto|scroll|overlay|hidden/.test(i + s + n)
    }

    function ve(t, e) {
        var i;
        void 0 === e && (e = []);
        var n = function t(e) {
                return ["html", "body", "#document"].indexOf(Mt(e)) >= 0 ? e.ownerDocument.body : Rt(e) && be(e) ? e : t(Yt(e))
            }(t), s = n === (null == (i = t.ownerDocument) ? void 0 : i.body), o = Ht(n),
            r = s ? [o].concat(o.visualViewport || [], be(n) ? n : []) : n, a = e.concat(r);
        return s ? a : a.concat(ve(Yt(r)))
    }

    function ye(t) {
        return Object.assign({}, t, {left: t.x, top: t.y, right: t.x + t.width, bottom: t.y + t.height})
    }

    function we(t, e) {
        return e === Tt ? ye(function (t) {
            var e = Ht(t), i = Xt(t), n = e.visualViewport, s = i.clientWidth, o = i.clientHeight, r = 0, a = 0;
            return n && (s = n.width, o = n.height, /^((?!chrome|android).)*safari/i.test(navigator.userAgent) || (r = n.offsetLeft, a = n.offsetTop)), {
                width: s,
                height: o,
                x: r + _e(t),
                y: a
            }
        }(t)) : Rt(e) ? function (t) {
            var e = Ft(t);
            return e.top = e.top + t.clientTop, e.left = e.left + t.clientLeft, e.bottom = e.top + t.clientHeight, e.right = e.left + t.clientWidth, e.width = t.clientWidth, e.height = t.clientHeight, e.x = e.left, e.y = e.top, e
        }(e) : ye(function (t) {
            var e, i = Xt(t), n = ge(t), s = null == (e = t.ownerDocument) ? void 0 : e.body,
                o = Jt(i.scrollWidth, i.clientWidth, s ? s.scrollWidth : 0, s ? s.clientWidth : 0),
                r = Jt(i.scrollHeight, i.clientHeight, s ? s.scrollHeight : 0, s ? s.clientHeight : 0),
                a = -n.scrollLeft + _e(t), l = -n.scrollTop;
            return "rtl" === Vt(s || i).direction && (a += Jt(i.clientWidth, s ? s.clientWidth : 0) - o), {
                width: o,
                height: r,
                x: a,
                y: l
            }
        }(Xt(t)))
    }

    function Ee(t) {
        var e, i = t.reference, n = t.element, s = t.placement, o = s ? qt(s) : null, r = s ? re(s) : null,
            a = i.x + i.width / 2 - n.width / 2, l = i.y + i.height / 2 - n.height / 2;
        switch (o) {
            case mt:
                e = {x: a, y: i.y - n.height};
                break;
            case gt:
                e = {x: a, y: i.y + i.height};
                break;
            case _t:
                e = {x: i.x + i.width, y: l};
                break;
            case bt:
                e = {x: i.x - n.width, y: l};
                break;
            default:
                e = {x: i.x, y: i.y}
        }
        var c = o ? Zt(o) : null;
        if (null != c) {
            var h = "y" === c ? "height" : "width";
            switch (r) {
                case wt:
                    e[c] = e[c] - (i[h] / 2 - n[h] / 2);
                    break;
                case Et:
                    e[c] = e[c] + (i[h] / 2 - n[h] / 2)
            }
        }
        return e
    }

    function Ae(t, e) {
        void 0 === e && (e = {});
        var i = e, n = i.placement, s = void 0 === n ? t.placement : n, o = i.boundary, r = void 0 === o ? At : o,
            a = i.rootBoundary, l = void 0 === a ? Tt : a, c = i.elementContext, h = void 0 === c ? Ot : c,
            d = i.altBoundary, u = void 0 !== d && d, f = i.padding, p = void 0 === f ? 0 : f,
            m = ne("number" != typeof p ? p : se(p, yt)), g = h === Ot ? Ct : Ot, _ = t.rects.popper,
            b = t.elements[u ? g : h], v = function (t, e, i) {
                var n = "clippingParents" === e ? function (t) {
                    var e = ve(Yt(t)), i = ["absolute", "fixed"].indexOf(Vt(t).position) >= 0 && Rt(t) ? Gt(t) : t;
                    return Bt(i) ? e.filter((function (t) {
                        return Bt(t) && Ut(t, i) && "body" !== Mt(t)
                    })) : []
                }(t) : [].concat(e), s = [].concat(n, [i]), o = s[0], r = s.reduce((function (e, i) {
                    var n = we(t, i);
                    return e.top = Jt(n.top, e.top), e.right = te(n.right, e.right), e.bottom = te(n.bottom, e.bottom), e.left = Jt(n.left, e.left), e
                }), we(t, o));
                return r.width = r.right - r.left, r.height = r.bottom - r.top, r.x = r.left, r.y = r.top, r
            }(Bt(b) ? b : b.contextElement || Xt(t.elements.popper), r, l), y = Ft(t.elements.reference),
            w = Ee({reference: y, element: _, strategy: "absolute", placement: s}), E = ye(Object.assign({}, _, w)),
            A = h === Ot ? E : y, T = {
                top: v.top - A.top + m.top,
                bottom: A.bottom - v.bottom + m.bottom,
                left: v.left - A.left + m.left,
                right: A.right - v.right + m.right
            }, O = t.modifiersData.offset;
        if (h === Ot && O) {
            var C = O[s];
            Object.keys(T).forEach((function (t) {
                var e = [_t, gt].indexOf(t) >= 0 ? 1 : -1, i = [mt, gt].indexOf(t) >= 0 ? "y" : "x";
                T[t] += C[i] * e
            }))
        }
        return T
    }

    const Te = {
        name: "flip", enabled: !0, phase: "main", fn: function (t) {
            var e = t.state, i = t.options, n = t.name;
            if (!e.modifiersData[n]._skip) {
                for (var s = i.mainAxis, o = void 0 === s || s, r = i.altAxis, a = void 0 === r || r, l = i.fallbackPlacements, c = i.padding, h = i.boundary, d = i.rootBoundary, u = i.altBoundary, f = i.flipVariations, p = void 0 === f || f, m = i.allowedAutoPlacements, g = e.options.placement, _ = qt(g), b = l || (_ !== g && p ? function (t) {
                    if (qt(t) === vt) return [];
                    var e = fe(t);
                    return [me(t), e, me(e)]
                }(g) : [fe(g)]), v = [g].concat(b).reduce((function (t, i) {
                    return t.concat(qt(i) === vt ? function (t, e) {
                        void 0 === e && (e = {});
                        var i = e, n = i.placement, s = i.boundary, o = i.rootBoundary, r = i.padding,
                            a = i.flipVariations, l = i.allowedAutoPlacements, c = void 0 === l ? Lt : l, h = re(n),
                            d = h ? a ? kt : kt.filter((function (t) {
                                return re(t) === h
                            })) : yt, u = d.filter((function (t) {
                                return c.indexOf(t) >= 0
                            }));
                        0 === u.length && (u = d);
                        var f = u.reduce((function (e, i) {
                            return e[i] = Ae(t, {placement: i, boundary: s, rootBoundary: o, padding: r})[qt(i)], e
                        }), {});
                        return Object.keys(f).sort((function (t, e) {
                            return f[t] - f[e]
                        }))
                    }(e, {
                        placement: i,
                        boundary: h,
                        rootBoundary: d,
                        padding: c,
                        flipVariations: p,
                        allowedAutoPlacements: m
                    }) : i)
                }), []), y = e.rects.reference, w = e.rects.popper, E = new Map, A = !0, T = v[0], O = 0; O < v.length; O++) {
                    var C = v[O], k = qt(C), L = re(C) === wt, x = [mt, gt].indexOf(k) >= 0, D = x ? "width" : "height",
                        S = Ae(e, {placement: C, boundary: h, rootBoundary: d, altBoundary: u, padding: c}),
                        N = x ? L ? _t : bt : L ? gt : mt;
                    y[D] > w[D] && (N = fe(N));
                    var I = fe(N), P = [];
                    if (o && P.push(S[k] <= 0), a && P.push(S[N] <= 0, S[I] <= 0), P.every((function (t) {
                        return t
                    }))) {
                        T = C, A = !1;
                        break
                    }
                    E.set(C, P)
                }
                if (A) for (var j = function (t) {
                    var e = v.find((function (e) {
                        var i = E.get(e);
                        if (i) return i.slice(0, t).every((function (t) {
                            return t
                        }))
                    }));
                    if (e) return T = e, "break"
                }, M = p ? 3 : 1; M > 0 && "break" !== j(M); M--) ;
                e.placement !== T && (e.modifiersData[n]._skip = !0, e.placement = T, e.reset = !0)
            }
        }, requiresIfExists: ["offset"], data: {_skip: !1}
    };

    function Oe(t, e, i) {
        return void 0 === i && (i = {x: 0, y: 0}), {
            top: t.top - e.height - i.y,
            right: t.right - e.width + i.x,
            bottom: t.bottom - e.height + i.y,
            left: t.left - e.width - i.x
        }
    }

    function Ce(t) {
        return [mt, _t, gt, bt].some((function (e) {
            return t[e] >= 0
        }))
    }

    const ke = {
        name: "hide", enabled: !0, phase: "main", requiresIfExists: ["preventOverflow"], fn: function (t) {
            var e = t.state, i = t.name, n = e.rects.reference, s = e.rects.popper, o = e.modifiersData.preventOverflow,
                r = Ae(e, {elementContext: "reference"}), a = Ae(e, {altBoundary: !0}), l = Oe(r, n), c = Oe(a, s, o),
                h = Ce(l), d = Ce(c);
            e.modifiersData[i] = {
                referenceClippingOffsets: l,
                popperEscapeOffsets: c,
                isReferenceHidden: h,
                hasPopperEscaped: d
            }, e.attributes.popper = Object.assign({}, e.attributes.popper, {
                "data-popper-reference-hidden": h,
                "data-popper-escaped": d
            })
        }
    }, Le = {
        name: "offset", enabled: !0, phase: "main", requires: ["popperOffsets"], fn: function (t) {
            var e = t.state, i = t.options, n = t.name, s = i.offset, o = void 0 === s ? [0, 0] : s,
                r = Lt.reduce((function (t, i) {
                    return t[i] = function (t, e, i) {
                        var n = qt(t), s = [bt, mt].indexOf(n) >= 0 ? -1 : 1,
                            o = "function" == typeof i ? i(Object.assign({}, e, {placement: t})) : i, r = o[0],
                            a = o[1];
                        return r = r || 0, a = (a || 0) * s, [bt, _t].indexOf(n) >= 0 ? {x: a, y: r} : {x: r, y: a}
                    }(i, e.rects, o), t
                }), {}), a = r[e.placement], l = a.x, c = a.y;
            null != e.modifiersData.popperOffsets && (e.modifiersData.popperOffsets.x += l, e.modifiersData.popperOffsets.y += c), e.modifiersData[n] = r
        }
    }, xe = {
        name: "popperOffsets", enabled: !0, phase: "read", fn: function (t) {
            var e = t.state, i = t.name;
            e.modifiersData[i] = Ee({
                reference: e.rects.reference,
                element: e.rects.popper,
                strategy: "absolute",
                placement: e.placement
            })
        }, data: {}
    }, De = {
        name: "preventOverflow", enabled: !0, phase: "main", fn: function (t) {
            var e = t.state, i = t.options, n = t.name, s = i.mainAxis, o = void 0 === s || s, r = i.altAxis,
                a = void 0 !== r && r, l = i.boundary, c = i.rootBoundary, h = i.altBoundary, d = i.padding,
                u = i.tether, f = void 0 === u || u, p = i.tetherOffset, m = void 0 === p ? 0 : p,
                g = Ae(e, {boundary: l, rootBoundary: c, padding: d, altBoundary: h}), _ = qt(e.placement),
                b = re(e.placement), v = !b, y = Zt(_), w = "x" === y ? "y" : "x", E = e.modifiersData.popperOffsets,
                A = e.rects.reference, T = e.rects.popper,
                O = "function" == typeof m ? m(Object.assign({}, e.rects, {placement: e.placement})) : m,
                C = {x: 0, y: 0};
            if (E) {
                if (o || a) {
                    var k = "y" === y ? mt : bt, L = "y" === y ? gt : _t, x = "y" === y ? "height" : "width", D = E[y],
                        S = E[y] + g[k], N = E[y] - g[L], I = f ? -T[x] / 2 : 0, P = b === wt ? A[x] : T[x],
                        j = b === wt ? -T[x] : -A[x], M = e.elements.arrow, H = f && M ? $t(M) : {width: 0, height: 0},
                        B = e.modifiersData["arrow#persistent"] ? e.modifiersData["arrow#persistent"].padding : {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0
                        }, R = B[k], W = B[L], z = ie(0, A[x], H[x]), q = v ? A[x] / 2 - I - z - R - O : P - z - R - O,
                        F = v ? -A[x] / 2 + I + z + W + O : j + z + W + O, $ = e.elements.arrow && Gt(e.elements.arrow),
                        U = $ ? "y" === y ? $.clientTop || 0 : $.clientLeft || 0 : 0,
                        V = e.modifiersData.offset ? e.modifiersData.offset[e.placement][y] : 0, K = E[y] + q - V - U,
                        X = E[y] + F - V;
                    if (o) {
                        var Y = ie(f ? te(S, K) : S, D, f ? Jt(N, X) : N);
                        E[y] = Y, C[y] = Y - D
                    }
                    if (a) {
                        var Q = "x" === y ? mt : bt, G = "x" === y ? gt : _t, Z = E[w], J = Z + g[Q], tt = Z - g[G],
                            et = ie(f ? te(J, K) : J, Z, f ? Jt(tt, X) : tt);
                        E[w] = et, C[w] = et - Z
                    }
                }
                e.modifiersData[n] = C
            }
        }, requiresIfExists: ["offset"]
    };

    function Se(t, e, i) {
        void 0 === i && (i = !1);
        var n = Rt(e);
        Rt(e) && function (t) {
            var e = t.getBoundingClientRect();
            e.width, t.offsetWidth, e.height, t.offsetHeight
        }(e);
        var s, o, r = Xt(e), a = Ft(t), l = {scrollLeft: 0, scrollTop: 0}, c = {x: 0, y: 0};
        return (n || !n && !i) && (("body" !== Mt(e) || be(r)) && (l = (s = e) !== Ht(s) && Rt(s) ? {
            scrollLeft: (o = s).scrollLeft,
            scrollTop: o.scrollTop
        } : ge(s)), Rt(e) ? ((c = Ft(e)).x += e.clientLeft, c.y += e.clientTop) : r && (c.x = _e(r))), {
            x: a.left + l.scrollLeft - c.x,
            y: a.top + l.scrollTop - c.y,
            width: a.width,
            height: a.height
        }
    }

    function Ne(t) {
        var e = new Map, i = new Set, n = [];
        return t.forEach((function (t) {
            e.set(t.name, t)
        })), t.forEach((function (t) {
            i.has(t.name) || function t(s) {
                i.add(s.name), [].concat(s.requires || [], s.requiresIfExists || []).forEach((function (n) {
                    if (!i.has(n)) {
                        var s = e.get(n);
                        s && t(s)
                    }
                })), n.push(s)
            }(t)
        })), n
    }

    var Ie = {placement: "bottom", modifiers: [], strategy: "absolute"};

    function Pe() {
        for (var t = arguments.length, e = new Array(t), i = 0; i < t; i++) e[i] = arguments[i];
        return !e.some((function (t) {
            return !(t && "function" == typeof t.getBoundingClientRect)
        }))
    }

    function je(t) {
        void 0 === t && (t = {});
        var e = t, i = e.defaultModifiers, n = void 0 === i ? [] : i, s = e.defaultOptions, o = void 0 === s ? Ie : s;
        return function (t, e, i) {
            void 0 === i && (i = o);
            var s, r, a = {
                placement: "bottom",
                orderedModifiers: [],
                options: Object.assign({}, Ie, o),
                modifiersData: {},
                elements: {reference: t, popper: e},
                attributes: {},
                styles: {}
            }, l = [], c = !1, h = {
                state: a, setOptions: function (i) {
                    var s = "function" == typeof i ? i(a.options) : i;
                    d(), a.options = Object.assign({}, o, a.options, s), a.scrollParents = {
                        reference: Bt(t) ? ve(t) : t.contextElement ? ve(t.contextElement) : [],
                        popper: ve(e)
                    };
                    var r, c, u = function (t) {
                        var e = Ne(t);
                        return jt.reduce((function (t, i) {
                            return t.concat(e.filter((function (t) {
                                return t.phase === i
                            })))
                        }), [])
                    }((r = [].concat(n, a.options.modifiers), c = r.reduce((function (t, e) {
                        var i = t[e.name];
                        return t[e.name] = i ? Object.assign({}, i, e, {
                            options: Object.assign({}, i.options, e.options),
                            data: Object.assign({}, i.data, e.data)
                        }) : e, t
                    }), {}), Object.keys(c).map((function (t) {
                        return c[t]
                    }))));
                    return a.orderedModifiers = u.filter((function (t) {
                        return t.enabled
                    })), a.orderedModifiers.forEach((function (t) {
                        var e = t.name, i = t.options, n = void 0 === i ? {} : i, s = t.effect;
                        if ("function" == typeof s) {
                            var o = s({state: a, name: e, instance: h, options: n});
                            l.push(o || function () {
                            })
                        }
                    })), h.update()
                }, forceUpdate: function () {
                    if (!c) {
                        var t = a.elements, e = t.reference, i = t.popper;
                        if (Pe(e, i)) {
                            a.rects = {
                                reference: Se(e, Gt(i), "fixed" === a.options.strategy),
                                popper: $t(i)
                            }, a.reset = !1, a.placement = a.options.placement, a.orderedModifiers.forEach((function (t) {
                                return a.modifiersData[t.name] = Object.assign({}, t.data)
                            }));
                            for (var n = 0; n < a.orderedModifiers.length; n++) if (!0 !== a.reset) {
                                var s = a.orderedModifiers[n], o = s.fn, r = s.options, l = void 0 === r ? {} : r,
                                    d = s.name;
                                "function" == typeof o && (a = o({state: a, options: l, name: d, instance: h}) || a)
                            } else a.reset = !1, n = -1
                        }
                    }
                }, update: (s = function () {
                    return new Promise((function (t) {
                        h.forceUpdate(), t(a)
                    }))
                }, function () {
                    return r || (r = new Promise((function (t) {
                        Promise.resolve().then((function () {
                            r = void 0, t(s())
                        }))
                    }))), r
                }), destroy: function () {
                    d(), c = !0
                }
            };
            if (!Pe(t, e)) return h;

            function d() {
                l.forEach((function (t) {
                    return t()
                })), l = []
            }

            return h.setOptions(i).then((function (t) {
                !c && i.onFirstUpdate && i.onFirstUpdate(t)
            })), h
        }
    }

    var Me = je(), He = je({defaultModifiers: [de, xe, ce, zt]}),
        Be = je({defaultModifiers: [de, xe, ce, zt, Le, Te, De, oe, ke]});
    const Re = Object.freeze({
            __proto__: null,
            popperGenerator: je,
            detectOverflow: Ae,
            createPopperBase: Me,
            createPopper: Be,
            createPopperLite: He,
            top: mt,
            bottom: gt,
            right: _t,
            left: bt,
            auto: vt,
            basePlacements: yt,
            start: wt,
            end: Et,
            clippingParents: At,
            viewport: Tt,
            popper: Ot,
            reference: Ct,
            variationPlacements: kt,
            placements: Lt,
            beforeRead: xt,
            read: "read",
            afterRead: Dt,
            beforeMain: St,
            main: "main",
            afterMain: Nt,
            beforeWrite: It,
            write: "write",
            afterWrite: Pt,
            modifierPhases: jt,
            applyStyles: zt,
            arrow: oe,
            computeStyles: ce,
            eventListeners: de,
            flip: Te,
            hide: ke,
            offset: Le,
            popperOffsets: xe,
            preventOverflow: De
        }), We = "dropdown", ze = "Escape", qe = "ArrowUp", Fe = "ArrowDown", $e = new RegExp("ArrowUp|ArrowDown|Escape"),
        Ue = "click.bs.dropdown.data-api", Ve = "keydown.bs.dropdown.data-api", Ke = "show",
        Xe = '[data-bs-toggle="dropdown"]', Ye = ".dropdown-menu", Qe = m() ? "top-end" : "top-start",
        Ge = m() ? "top-start" : "top-end", Ze = m() ? "bottom-end" : "bottom-start",
        Je = m() ? "bottom-start" : "bottom-end", ti = m() ? "left-start" : "right-start",
        ei = m() ? "right-start" : "left-start", ii = {
            offset: [0, 2],
            boundary: "clippingParents",
            reference: "toggle",
            display: "dynamic",
            popperConfig: null,
            autoClose: !0
        }, ni = {
            offset: "(array|string|function)",
            boundary: "(string|element)",
            reference: "(string|element|object)",
            display: "string",
            popperConfig: "(null|object|function)",
            autoClose: "(boolean|string)"
        };

    class si extends B {
        constructor(t, e) {
            super(t), this._popper = null, this._config = this._getConfig(e), this._menu = this._getMenuElement(), this._inNavbar = this._detectNavbar()
        }

        static get Default() {
            return ii
        }

        static get DefaultType() {
            return ni
        }

        static get NAME() {
            return We
        }

        toggle() {
            return this._isShown() ? this.hide() : this.show()
        }

        show() {
            if (c(this._element) || this._isShown(this._menu)) return;
            const t = {relatedTarget: this._element};
            if (j.trigger(this._element, "show.bs.dropdown", t).defaultPrevented) return;
            const e = si.getParentFromElement(this._element);
            this._inNavbar ? U.setDataAttribute(this._menu, "popper", "none") : this._createPopper(e), "ontouchstart" in document.documentElement && !e.closest(".navbar-nav") && [].concat(...document.body.children).forEach(t => j.on(t, "mouseover", d)), this._element.focus(), this._element.setAttribute("aria-expanded", !0), this._menu.classList.add(Ke), this._element.classList.add(Ke), j.trigger(this._element, "shown.bs.dropdown", t)
        }

        hide() {
            if (c(this._element) || !this._isShown(this._menu)) return;
            const t = {relatedTarget: this._element};
            this._completeHide(t)
        }

        dispose() {
            this._popper && this._popper.destroy(), super.dispose()
        }

        update() {
            this._inNavbar = this._detectNavbar(), this._popper && this._popper.update()
        }

        _completeHide(t) {
            j.trigger(this._element, "hide.bs.dropdown", t).defaultPrevented || ("ontouchstart" in document.documentElement && [].concat(...document.body.children).forEach(t => j.off(t, "mouseover", d)), this._popper && this._popper.destroy(), this._menu.classList.remove(Ke), this._element.classList.remove(Ke), this._element.setAttribute("aria-expanded", "false"), U.removeDataAttribute(this._menu, "popper"), j.trigger(this._element, "hidden.bs.dropdown", t))
        }

        _getConfig(t) {
            if (t = {...this.constructor.Default, ...U.getDataAttributes(this._element), ...t}, a(We, t, this.constructor.DefaultType), "object" == typeof t.reference && !o(t.reference) && "function" != typeof t.reference.getBoundingClientRect) throw new TypeError(We.toUpperCase() + ': Option "reference" provided type "object" without a required "getBoundingClientRect" method.');
            return t
        }

        _createPopper(t) {
            if (void 0 === Re) throw new TypeError("Bootstrap's dropdowns require Popper");
            let e = this._element;
            "parent" === this._config.reference ? e = t : o(this._config.reference) ? e = r(this._config.reference) : "object" == typeof this._config.reference && (e = this._config.reference);
            const i = this._getPopperConfig(), n = i.modifiers.find(t => "applyStyles" === t.name && !1 === t.enabled);
            this._popper = Be(e, this._menu, i), n && U.setDataAttribute(this._menu, "popper", "static")
        }

        _isShown(t = this._element) {
            return t.classList.contains(Ke)
        }

        _getMenuElement() {
            return V.next(this._element, Ye)[0]
        }

        _getPlacement() {
            const t = this._element.parentNode;
            if (t.classList.contains("dropend")) return ti;
            if (t.classList.contains("dropstart")) return ei;
            const e = "end" === getComputedStyle(this._menu).getPropertyValue("--bs-position").trim();
            return t.classList.contains("dropup") ? e ? Ge : Qe : e ? Je : Ze
        }

        _detectNavbar() {
            return null !== this._element.closest(".navbar")
        }

        _getOffset() {
            const {offset: t} = this._config;
            return "string" == typeof t ? t.split(",").map(t => Number.parseInt(t, 10)) : "function" == typeof t ? e => t(e, this._element) : t
        }

        _getPopperConfig() {
            const t = {
                placement: this._getPlacement(),
                modifiers: [{name: "preventOverflow", options: {boundary: this._config.boundary}}, {
                    name: "offset",
                    options: {offset: this._getOffset()}
                }]
            };
            return "static" === this._config.display && (t.modifiers = [{
                name: "applyStyles",
                enabled: !1
            }]), {...t, ..."function" == typeof this._config.popperConfig ? this._config.popperConfig(t) : this._config.popperConfig}
        }

        _selectMenuItem({key: t, target: e}) {
            const i = V.find(".dropdown-menu .dropdown-item:not(.disabled):not(:disabled)", this._menu).filter(l);
            i.length && v(i, e, t === Fe, !i.includes(e)).focus()
        }

        static jQueryInterface(t) {
            return this.each((function () {
                const e = si.getOrCreateInstance(this, t);
                if ("string" == typeof t) {
                    if (void 0 === e[t]) throw new TypeError(`No method named "${t}"`);
                    e[t]()
                }
            }))
        }

        static clearMenus(t) {
            if (t && (2 === t.button || "keyup" === t.type && "Tab" !== t.key)) return;
            const e = V.find(Xe);
            for (let i = 0, n = e.length; i < n; i++) {
                const n = si.getInstance(e[i]);
                if (!n || !1 === n._config.autoClose) continue;
                if (!n._isShown()) continue;
                const s = {relatedTarget: n._element};
                if (t) {
                    const e = t.composedPath(), i = e.includes(n._menu);
                    if (e.includes(n._element) || "inside" === n._config.autoClose && !i || "outside" === n._config.autoClose && i) continue;
                    if (n._menu.contains(t.target) && ("keyup" === t.type && "Tab" === t.key || /input|select|option|textarea|form/i.test(t.target.tagName))) continue;
                    "click" === t.type && (s.clickEvent = t)
                }
                n._completeHide(s)
            }
        }

        static getParentFromElement(t) {
            return n(t) || t.parentNode
        }

        static dataApiKeydownHandler(t) {
            if (/input|textarea/i.test(t.target.tagName) ? "Space" === t.key || t.key !== ze && (t.key !== Fe && t.key !== qe || t.target.closest(Ye)) : !$e.test(t.key)) return;
            const e = this.classList.contains(Ke);
            if (!e && t.key === ze) return;
            if (t.preventDefault(), t.stopPropagation(), c(this)) return;
            const i = this.matches(Xe) ? this : V.prev(this, Xe)[0], n = si.getOrCreateInstance(i);
            if (t.key !== ze) return t.key === qe || t.key === Fe ? (e || n.show(), void n._selectMenuItem(t)) : void (e && "Space" !== t.key || si.clearMenus());
            n.hide()
        }
    }

    j.on(document, Ve, Xe, si.dataApiKeydownHandler), j.on(document, Ve, Ye, si.dataApiKeydownHandler), j.on(document, Ue, si.clearMenus), j.on(document, "keyup.bs.dropdown.data-api", si.clearMenus), j.on(document, Ue, Xe, (function (t) {
        t.preventDefault(), si.getOrCreateInstance(this).toggle()
    })), g(si);
    const oi = ".fixed-top, .fixed-bottom, .is-fixed, .sticky-top", ri = ".sticky-top";

    class ai {
        constructor() {
            this._element = document.body
        }

        getWidth() {
            const t = document.documentElement.clientWidth;
            return Math.abs(window.innerWidth - t)
        }

        hide() {
            const t = this.getWidth();
            this._disableOverFlow(), this._setElementAttributes(this._element, "paddingRight", e => e + t), this._setElementAttributes(oi, "paddingRight", e => e + t), this._setElementAttributes(ri, "marginRight", e => e - t)
        }

        _disableOverFlow() {
            this._saveInitialAttribute(this._element, "overflow"), this._element.style.overflow = "hidden"
        }

        _setElementAttributes(t, e, i) {
            const n = this.getWidth();
            this._applyManipulationCallback(t, t => {
                if (t !== this._element && window.innerWidth > t.clientWidth + n) return;
                this._saveInitialAttribute(t, e);
                const s = window.getComputedStyle(t)[e];
                t.style[e] = i(Number.parseFloat(s)) + "px"
            })
        }

        reset() {
            this._resetElementAttributes(this._element, "overflow"), this._resetElementAttributes(this._element, "paddingRight"), this._resetElementAttributes(oi, "paddingRight"), this._resetElementAttributes(ri, "marginRight")
        }

        _saveInitialAttribute(t, e) {
            const i = t.style[e];
            i && U.setDataAttribute(t, e, i)
        }

        _resetElementAttributes(t, e) {
            this._applyManipulationCallback(t, t => {
                const i = U.getDataAttribute(t, e);
                void 0 === i ? t.style.removeProperty(e) : (U.removeDataAttribute(t, e), t.style[e] = i)
            })
        }

        _applyManipulationCallback(t, e) {
            o(t) ? e(t) : V.find(t, this._element).forEach(e)
        }

        isOverflowing() {
            return this.getWidth() > 0
        }
    }

    const li = {className: "modal-backdrop", isVisible: !0, isAnimated: !1, rootElement: "body", clickCallback: null},
        ci = {
            className: "string",
            isVisible: "boolean",
            isAnimated: "boolean",
            rootElement: "(element|string)",
            clickCallback: "(function|null)"
        }, hi = "mousedown.bs.backdrop";

    class di {
        constructor(t) {
            this._config = this._getConfig(t), this._isAppended = !1, this._element = null
        }

        show(t) {
            this._config.isVisible ? (this._append(), this._config.isAnimated && u(this._getElement()), this._getElement().classList.add("show"), this._emulateAnimation(() => {
                _(t)
            })) : _(t)
        }

        hide(t) {
            this._config.isVisible ? (this._getElement().classList.remove("show"), this._emulateAnimation(() => {
                this.dispose(), _(t)
            })) : _(t)
        }

        _getElement() {
            if (!this._element) {
                const t = document.createElement("div");
                t.className = this._config.className, this._config.isAnimated && t.classList.add("fade"), this._element = t
            }
            return this._element
        }

        _getConfig(t) {
            return (t = {...li, ..."object" == typeof t ? t : {}}).rootElement = r(t.rootElement), a("backdrop", t, ci), t
        }

        _append() {
            this._isAppended || (this._config.rootElement.append(this._getElement()), j.on(this._getElement(), hi, () => {
                _(this._config.clickCallback)
            }), this._isAppended = !0)
        }

        dispose() {
            this._isAppended && (j.off(this._element, hi), this._element.remove(), this._isAppended = !1)
        }

        _emulateAnimation(t) {
            b(t, this._getElement(), this._config.isAnimated)
        }
    }

    const ui = {trapElement: null, autofocus: !0}, fi = {trapElement: "element", autofocus: "boolean"},
        pi = ".bs.focustrap", mi = "backward";

    class gi {
        constructor(t) {
            this._config = this._getConfig(t), this._isActive = !1, this._lastTabNavDirection = null
        }

        activate() {
            const {trapElement: t, autofocus: e} = this._config;
            this._isActive || (e && t.focus(), j.off(document, pi), j.on(document, "focusin.bs.focustrap", t => this._handleFocusin(t)), j.on(document, "keydown.tab.bs.focustrap", t => this._handleKeydown(t)), this._isActive = !0)
        }

        deactivate() {
            this._isActive && (this._isActive = !1, j.off(document, pi))
        }

        _handleFocusin(t) {
            const {target: e} = t, {trapElement: i} = this._config;
            if (e === document || e === i || i.contains(e)) return;
            const n = V.focusableChildren(i);
            0 === n.length ? i.focus() : this._lastTabNavDirection === mi ? n[n.length - 1].focus() : n[0].focus()
        }

        _handleKeydown(t) {
            "Tab" === t.key && (this._lastTabNavDirection = t.shiftKey ? mi : "forward")
        }

        _getConfig(t) {
            return t = {...ui, ..."object" == typeof t ? t : {}}, a("focustrap", t, fi), t
        }
    }

    const _i = {backdrop: !0, keyboard: !0, focus: !0},
        bi = {backdrop: "(boolean|string)", keyboard: "boolean", focus: "boolean"}, vi = "hidden.bs.modal",
        yi = "show.bs.modal", wi = "resize.bs.modal", Ei = "click.dismiss.bs.modal", Ai = "keydown.dismiss.bs.modal",
        Ti = "mousedown.dismiss.bs.modal", Oi = "modal-open", Ci = "modal-static";

    class ki extends B {
        constructor(t, e) {
            super(t), this._config = this._getConfig(e), this._dialog = V.findOne(".modal-dialog", this._element), this._backdrop = this._initializeBackDrop(), this._focustrap = this._initializeFocusTrap(), this._isShown = !1, this._ignoreBackdropClick = !1, this._isTransitioning = !1, this._scrollBar = new ai
        }

        static get Default() {
            return _i
        }

        static get NAME() {
            return "modal"
        }

        toggle(t) {
            return this._isShown ? this.hide() : this.show(t)
        }

        show(t) {
            this._isShown || this._isTransitioning || j.trigger(this._element, yi, {relatedTarget: t}).defaultPrevented || (this._isShown = !0, this._isAnimated() && (this._isTransitioning = !0), this._scrollBar.hide(), document.body.classList.add(Oi), this._adjustDialog(), this._setEscapeEvent(), this._setResizeEvent(), j.on(this._dialog, Ti, () => {
                j.one(this._element, "mouseup.dismiss.bs.modal", t => {
                    t.target === this._element && (this._ignoreBackdropClick = !0)
                })
            }), this._showBackdrop(() => this._showElement(t)))
        }

        hide() {
            if (!this._isShown || this._isTransitioning) return;
            if (j.trigger(this._element, "hide.bs.modal").defaultPrevented) return;
            this._isShown = !1;
            const t = this._isAnimated();
            t && (this._isTransitioning = !0), this._setEscapeEvent(), this._setResizeEvent(), this._focustrap.deactivate(), this._element.classList.remove("show"), j.off(this._element, Ei), j.off(this._dialog, Ti), this._queueCallback(() => this._hideModal(), this._element, t)
        }

        dispose() {
            [window, this._dialog].forEach(t => j.off(t, ".bs.modal")), this._backdrop.dispose(), this._focustrap.deactivate(), super.dispose()
        }

        handleUpdate() {
            this._adjustDialog()
        }

        _initializeBackDrop() {
            return new di({isVisible: Boolean(this._config.backdrop), isAnimated: this._isAnimated()})
        }

        _initializeFocusTrap() {
            return new gi({trapElement: this._element})
        }

        _getConfig(t) {
            return t = {..._i, ...U.getDataAttributes(this._element), ..."object" == typeof t ? t : {}}, a("modal", t, bi), t
        }

        _showElement(t) {
            const e = this._isAnimated(), i = V.findOne(".modal-body", this._dialog);
            this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE || document.body.append(this._element), this._element.style.display = "block", this._element.removeAttribute("aria-hidden"), this._element.setAttribute("aria-modal", !0), this._element.setAttribute("role", "dialog"), this._element.scrollTop = 0, i && (i.scrollTop = 0), e && u(this._element), this._element.classList.add("show"), this._queueCallback(() => {
                this._config.focus && this._focustrap.activate(), this._isTransitioning = !1, j.trigger(this._element, "shown.bs.modal", {relatedTarget: t})
            }, this._dialog, e)
        }

        _setEscapeEvent() {
            this._isShown ? j.on(this._element, Ai, t => {
                this._config.keyboard && "Escape" === t.key ? (t.preventDefault(), this.hide()) : this._config.keyboard || "Escape" !== t.key || this._triggerBackdropTransition()
            }) : j.off(this._element, Ai)
        }

        _setResizeEvent() {
            this._isShown ? j.on(window, wi, () => this._adjustDialog()) : j.off(window, wi)
        }

        _hideModal() {
            this._element.style.display = "none", this._element.setAttribute("aria-hidden", !0), this._element.removeAttribute("aria-modal"), this._element.removeAttribute("role"), this._isTransitioning = !1, this._backdrop.hide(() => {
                document.body.classList.remove(Oi), this._resetAdjustments(), this._scrollBar.reset(), j.trigger(this._element, vi)
            })
        }

        _showBackdrop(t) {
            j.on(this._element, Ei, t => {
                this._ignoreBackdropClick ? this._ignoreBackdropClick = !1 : t.target === t.currentTarget && (!0 === this._config.backdrop ? this.hide() : "static" === this._config.backdrop && this._triggerBackdropTransition())
            }), this._backdrop.show(t)
        }

        _isAnimated() {
            return this._element.classList.contains("fade")
        }

        _triggerBackdropTransition() {
            if (j.trigger(this._element, "hidePrevented.bs.modal").defaultPrevented) return;
            const {classList: t, scrollHeight: e, style: i} = this._element,
                n = e > document.documentElement.clientHeight;
            !n && "hidden" === i.overflowY || t.contains(Ci) || (n || (i.overflowY = "hidden"), t.add(Ci), this._queueCallback(() => {
                t.remove(Ci), n || this._queueCallback(() => {
                    i.overflowY = ""
                }, this._dialog)
            }, this._dialog), this._element.focus())
        }

        _adjustDialog() {
            const t = this._element.scrollHeight > document.documentElement.clientHeight,
                e = this._scrollBar.getWidth(), i = e > 0;
            (!i && t && !m() || i && !t && m()) && (this._element.style.paddingLeft = e + "px"), (i && !t && !m() || !i && t && m()) && (this._element.style.paddingRight = e + "px")
        }

        _resetAdjustments() {
            this._element.style.paddingLeft = "", this._element.style.paddingRight = ""
        }

        static jQueryInterface(t, e) {
            return this.each((function () {
                const i = ki.getOrCreateInstance(this, t);
                if ("string" == typeof t) {
                    if (void 0 === i[t]) throw new TypeError(`No method named "${t}"`);
                    i[t](e)
                }
            }))
        }
    }

    j.on(document, "click.bs.modal.data-api", '[data-bs-toggle="modal"]', (function (t) {
        const e = n(this);
        ["A", "AREA"].includes(this.tagName) && t.preventDefault(), j.one(e, yi, t => {
            t.defaultPrevented || j.one(e, vi, () => {
                l(this) && this.focus()
            })
        });
        const i = V.findOne(".modal.show");
        i && ki.getInstance(i).hide(), ki.getOrCreateInstance(e).toggle(this)
    })), R(ki), g(ki);
    const Li = "offcanvas", xi = {backdrop: !0, keyboard: !0, scroll: !1},
        Di = {backdrop: "boolean", keyboard: "boolean", scroll: "boolean"}, Si = ".offcanvas.show",
        Ni = "hidden.bs.offcanvas";

    class Ii extends B {
        constructor(t, e) {
            super(t), this._config = this._getConfig(e), this._isShown = !1, this._backdrop = this._initializeBackDrop(), this._focustrap = this._initializeFocusTrap(), this._addEventListeners()
        }

        static get NAME() {
            return Li
        }

        static get Default() {
            return xi
        }

        toggle(t) {
            return this._isShown ? this.hide() : this.show(t)
        }

        show(t) {
            this._isShown || j.trigger(this._element, "show.bs.offcanvas", {relatedTarget: t}).defaultPrevented || (this._isShown = !0, this._element.style.visibility = "visible", this._backdrop.show(), this._config.scroll || (new ai).hide(), this._element.removeAttribute("aria-hidden"), this._element.setAttribute("aria-modal", !0), this._element.setAttribute("role", "dialog"), this._element.classList.add("show"), this._queueCallback(() => {
                this._config.scroll || this._focustrap.activate(), j.trigger(this._element, "shown.bs.offcanvas", {relatedTarget: t})
            }, this._element, !0))
        }

        hide() {
            this._isShown && (j.trigger(this._element, "hide.bs.offcanvas").defaultPrevented || (this._focustrap.deactivate(), this._element.blur(), this._isShown = !1, this._element.classList.remove("show"), this._backdrop.hide(), this._queueCallback(() => {
                this._element.setAttribute("aria-hidden", !0), this._element.removeAttribute("aria-modal"), this._element.removeAttribute("role"), this._element.style.visibility = "hidden", this._config.scroll || (new ai).reset(), j.trigger(this._element, Ni)
            }, this._element, !0)))
        }

        dispose() {
            this._backdrop.dispose(), this._focustrap.deactivate(), super.dispose()
        }

        _getConfig(t) {
            return t = {...xi, ...U.getDataAttributes(this._element), ..."object" == typeof t ? t : {}}, a(Li, t, Di), t
        }

        _initializeBackDrop() {
            return new di({
                className: "offcanvas-backdrop",
                isVisible: this._config.backdrop,
                isAnimated: !0,
                rootElement: this._element.parentNode,
                clickCallback: () => this.hide()
            })
        }

        _initializeFocusTrap() {
            return new gi({trapElement: this._element})
        }

        _addEventListeners() {
            j.on(this._element, "keydown.dismiss.bs.offcanvas", t => {
                this._config.keyboard && "Escape" === t.key && this.hide()
            })
        }

        static jQueryInterface(t) {
            return this.each((function () {
                const e = Ii.getOrCreateInstance(this, t);
                if ("string" == typeof t) {
                    if (void 0 === e[t] || t.startsWith("_") || "constructor" === t) throw new TypeError(`No method named "${t}"`);
                    e[t](this)
                }
            }))
        }
    }

    j.on(document, "click.bs.offcanvas.data-api", '[data-bs-toggle="offcanvas"]', (function (t) {
        const e = n(this);
        if (["A", "AREA"].includes(this.tagName) && t.preventDefault(), c(this)) return;
        j.one(e, Ni, () => {
            l(this) && this.focus()
        });
        const i = V.findOne(Si);
        i && i !== e && Ii.getInstance(i).hide(), Ii.getOrCreateInstance(e).toggle(this)
    })), j.on(window, "load.bs.offcanvas.data-api", () => V.find(Si).forEach(t => Ii.getOrCreateInstance(t).show())), R(Ii), g(Ii);
    const Pi = new Set(["background", "cite", "href", "itemtype", "longdesc", "poster", "src", "xlink:href"]),
        ji = /^(?:(?:https?|mailto|ftp|tel|file|sms):|[^#&/:?]*(?:[#/?]|$))/i,
        Mi = /^data:(?:image\/(?:bmp|gif|jpeg|jpg|png|tiff|webp)|video\/(?:mpeg|mp4|ogg|webm)|audio\/(?:mp3|oga|ogg|opus));base64,[\d+/a-z]+=*$/i,
        Hi = (t, e) => {
            const i = t.nodeName.toLowerCase();
            if (e.includes(i)) return !Pi.has(i) || Boolean(ji.test(t.nodeValue) || Mi.test(t.nodeValue));
            const n = e.filter(t => t instanceof RegExp);
            for (let t = 0, e = n.length; t < e; t++) if (n[t].test(i)) return !0;
            return !1
        };

    function Bi(t, e, i) {
        if (!t.length) return t;
        if (i && "function" == typeof i) return i(t);
        const n = (new window.DOMParser).parseFromString(t, "text/html"),
            s = [].concat(...n.body.querySelectorAll("*"));
        for (let t = 0, i = s.length; t < i; t++) {
            const i = s[t], n = i.nodeName.toLowerCase();
            if (!Object.keys(e).includes(n)) {
                i.remove();
                continue
            }
            const o = [].concat(...i.attributes), r = [].concat(e["*"] || [], e[n] || []);
            o.forEach(t => {
                Hi(t, r) || i.removeAttribute(t.nodeName)
            })
        }
        return n.body.innerHTML
    }

    const Ri = "tooltip", Wi = new Set(["sanitize", "allowList", "sanitizeFn"]), zi = {
            animation: "boolean",
            template: "string",
            title: "(string|element|function)",
            trigger: "string",
            delay: "(number|object)",
            html: "boolean",
            selector: "(string|boolean)",
            placement: "(string|function)",
            offset: "(array|string|function)",
            container: "(string|element|boolean)",
            fallbackPlacements: "array",
            boundary: "(string|element)",
            customClass: "(string|function)",
            sanitize: "boolean",
            sanitizeFn: "(null|function)",
            allowList: "object",
            popperConfig: "(null|object|function)"
        }, qi = {AUTO: "auto", TOP: "top", RIGHT: m() ? "left" : "right", BOTTOM: "bottom", LEFT: m() ? "right" : "left"},
        Fi = {
            animation: !0,
            template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
            trigger: "hover focus",
            title: "",
            delay: 0,
            html: !1,
            selector: !1,
            placement: "top",
            offset: [0, 0],
            container: !1,
            fallbackPlacements: ["top", "right", "bottom", "left"],
            boundary: "clippingParents",
            customClass: "",
            sanitize: !0,
            sanitizeFn: null,
            allowList: {
                "*": ["class", "dir", "id", "lang", "role", /^aria-[\w-]*$/i],
                a: ["target", "href", "title", "rel"],
                area: [],
                b: [],
                br: [],
                col: [],
                code: [],
                div: [],
                em: [],
                hr: [],
                h1: [],
                h2: [],
                h3: [],
                h4: [],
                h5: [],
                h6: [],
                i: [],
                img: ["src", "srcset", "alt", "title", "width", "height"],
                li: [],
                ol: [],
                p: [],
                pre: [],
                s: [],
                small: [],
                span: [],
                sub: [],
                sup: [],
                strong: [],
                u: [],
                ul: []
            },
            popperConfig: null
        }, $i = {
            HIDE: "hide.bs.tooltip",
            HIDDEN: "hidden.bs.tooltip",
            SHOW: "show.bs.tooltip",
            SHOWN: "shown.bs.tooltip",
            INSERTED: "inserted.bs.tooltip",
            CLICK: "click.bs.tooltip",
            FOCUSIN: "focusin.bs.tooltip",
            FOCUSOUT: "focusout.bs.tooltip",
            MOUSEENTER: "mouseenter.bs.tooltip",
            MOUSELEAVE: "mouseleave.bs.tooltip"
        }, Ui = "fade", Vi = "show", Ki = "show", Xi = ".tooltip-inner", Yi = "hide.bs.modal", Qi = "hover";

    class Gi extends B {
        constructor(t, e) {
            if (void 0 === Re) throw new TypeError("Bootstrap's tooltips require Popper");
            super(t), this._isEnabled = !0, this._timeout = 0, this._hoverState = "", this._activeTrigger = {}, this._popper = null, this._config = this._getConfig(e), this.tip = null, this._setListeners()
        }

        static get Default() {
            return Fi
        }

        static get NAME() {
            return Ri
        }

        static get Event() {
            return $i
        }

        static get DefaultType() {
            return zi
        }

        enable() {
            this._isEnabled = !0
        }

        disable() {
            this._isEnabled = !1
        }

        toggleEnabled() {
            this._isEnabled = !this._isEnabled
        }

        toggle(t) {
            if (this._isEnabled) if (t) {
                const e = this._initializeOnDelegatedTarget(t);
                e._activeTrigger.click = !e._activeTrigger.click, e._isWithActiveTrigger() ? e._enter(null, e) : e._leave(null, e)
            } else {
                if (this.getTipElement().classList.contains(Vi)) return void this._leave(null, this);
                this._enter(null, this)
            }
        }

        dispose() {
            clearTimeout(this._timeout), j.off(this._element.closest(".modal"), Yi, this._hideModalHandler), this.tip && this.tip.remove(), this._disposePopper(), super.dispose()
        }

        show() {
            if ("none" === this._element.style.display) throw new Error("Please use show on visible elements");
            if (!this.isWithContent() || !this._isEnabled) return;
            const t = j.trigger(this._element, this.constructor.Event.SHOW), e = h(this._element),
                i = null === e ? this._element.ownerDocument.documentElement.contains(this._element) : e.contains(this._element);
            if (t.defaultPrevented || !i) return;
            "tooltip" === this.constructor.NAME && this.tip && this.getTitle() !== this.tip.querySelector(Xi).innerHTML && (this._disposePopper(), this.tip.remove(), this.tip = null);
            const n = this.getTipElement(), s = (t => {
                do {
                    t += Math.floor(1e6 * Math.random())
                } while (document.getElementById(t));
                return t
            })(this.constructor.NAME);
            n.setAttribute("id", s), this._element.setAttribute("aria-describedby", s), this._config.animation && n.classList.add(Ui);
            const o = "function" == typeof this._config.placement ? this._config.placement.call(this, n, this._element) : this._config.placement,
                r = this._getAttachment(o);
            this._addAttachmentClass(r);
            const {container: a} = this._config;
            H.set(n, this.constructor.DATA_KEY, this), this._element.ownerDocument.documentElement.contains(this.tip) || (a.append(n), j.trigger(this._element, this.constructor.Event.INSERTED)), this._popper ? this._popper.update() : this._popper = Be(this._element, n, this._getPopperConfig(r)), n.classList.add(Vi);
            const l = this._resolvePossibleFunction(this._config.customClass);
            l && n.classList.add(...l.split(" ")), "ontouchstart" in document.documentElement && [].concat(...document.body.children).forEach(t => {
                j.on(t, "mouseover", d)
            });
            const c = this.tip.classList.contains(Ui);
            this._queueCallback(() => {
                const t = this._hoverState;
                this._hoverState = null, j.trigger(this._element, this.constructor.Event.SHOWN), "out" === t && this._leave(null, this)
            }, this.tip, c)
        }

        hide() {
            if (!this._popper) return;
            const t = this.getTipElement();
            if (j.trigger(this._element, this.constructor.Event.HIDE).defaultPrevented) return;
            t.classList.remove(Vi), "ontouchstart" in document.documentElement && [].concat(...document.body.children).forEach(t => j.off(t, "mouseover", d)), this._activeTrigger.click = !1, this._activeTrigger.focus = !1, this._activeTrigger.hover = !1;
            const e = this.tip.classList.contains(Ui);
            this._queueCallback(() => {
                this._isWithActiveTrigger() || (this._hoverState !== Ki && t.remove(), this._cleanTipClass(), this._element.removeAttribute("aria-describedby"), j.trigger(this._element, this.constructor.Event.HIDDEN), this._disposePopper())
            }, this.tip, e), this._hoverState = ""
        }

        update() {
            null !== this._popper && this._popper.update()
        }

        isWithContent() {
            return Boolean(this.getTitle())
        }

        getTipElement() {
            if (this.tip) return this.tip;
            const t = document.createElement("div");
            t.innerHTML = this._config.template;
            const e = t.children[0];
            return this.setContent(e), e.classList.remove(Ui, Vi), this.tip = e, this.tip
        }

        setContent(t) {
            this._sanitizeAndSetContent(t, this.getTitle(), Xi)
        }

        _sanitizeAndSetContent(t, e, i) {
            const n = V.findOne(i, t);
            e || !n ? this.setElementContent(n, e) : n.remove()
        }

        setElementContent(t, e) {
            if (null !== t) return o(e) ? (e = r(e), void (this._config.html ? e.parentNode !== t && (t.innerHTML = "", t.append(e)) : t.textContent = e.textContent)) : void (this._config.html ? (this._config.sanitize && (e = Bi(e, this._config.allowList, this._config.sanitizeFn)), t.innerHTML = e) : t.textContent = e)
        }

        getTitle() {
            const t = this._element.getAttribute("data-bs-original-title") || this._config.title;
            return this._resolvePossibleFunction(t)
        }

        updateAttachment(t) {
            return "right" === t ? "end" : "left" === t ? "start" : t
        }

        _initializeOnDelegatedTarget(t, e) {
            return e || this.constructor.getOrCreateInstance(t.delegateTarget, this._getDelegateConfig())
        }

        _getOffset() {
            const {offset: t} = this._config;
            return "string" == typeof t ? t.split(",").map(t => Number.parseInt(t, 10)) : "function" == typeof t ? e => t(e, this._element) : t
        }

        _resolvePossibleFunction(t) {
            return "function" == typeof t ? t.call(this._element) : t
        }

        _getPopperConfig(t) {
            const e = {
                placement: t,
                modifiers: [{
                    name: "flip",
                    options: {fallbackPlacements: this._config.fallbackPlacements}
                }, {name: "offset", options: {offset: this._getOffset()}}, {
                    name: "preventOverflow",
                    options: {boundary: this._config.boundary}
                }, {name: "arrow", options: {element: `.${this.constructor.NAME}-arrow`}}, {
                    name: "onChange",
                    enabled: !0,
                    phase: "afterWrite",
                    fn: t => this._handlePopperPlacementChange(t)
                }],
                onFirstUpdate: t => {
                    t.options.placement !== t.placement && this._handlePopperPlacementChange(t)
                }
            };
            return {...e, ..."function" == typeof this._config.popperConfig ? this._config.popperConfig(e) : this._config.popperConfig}
        }

        _addAttachmentClass(t) {
            this.getTipElement().classList.add(`${this._getBasicClassPrefix()}-${this.updateAttachment(t)}`)
        }

        _getAttachment(t) {
            return qi[t.toUpperCase()]
        }

        _setListeners() {
            this._config.trigger.split(" ").forEach(t => {
                if ("click" === t) j.on(this._element, this.constructor.Event.CLICK, this._config.selector, t => this.toggle(t)); else if ("manual" !== t) {
                    const e = t === Qi ? this.constructor.Event.MOUSEENTER : this.constructor.Event.FOCUSIN,
                        i = t === Qi ? this.constructor.Event.MOUSELEAVE : this.constructor.Event.FOCUSOUT;
                    j.on(this._element, e, this._config.selector, t => this._enter(t)), j.on(this._element, i, this._config.selector, t => this._leave(t))
                }
            }), this._hideModalHandler = () => {
                this._element && this.hide()
            }, j.on(this._element.closest(".modal"), Yi, this._hideModalHandler), this._config.selector ? this._config = {
                ...this._config,
                trigger: "manual",
                selector: ""
            } : this._fixTitle()
        }

        _fixTitle() {
            const t = this._element.getAttribute("title"),
                e = typeof this._element.getAttribute("data-bs-original-title");
            (t || "string" !== e) && (this._element.setAttribute("data-bs-original-title", t || ""), !t || this._element.getAttribute("aria-label") || this._element.textContent || this._element.setAttribute("aria-label", t), this._element.setAttribute("title", ""))
        }

        _enter(t, e) {
            e = this._initializeOnDelegatedTarget(t, e), t && (e._activeTrigger["focusin" === t.type ? "focus" : Qi] = !0), e.getTipElement().classList.contains(Vi) || e._hoverState === Ki ? e._hoverState = Ki : (clearTimeout(e._timeout), e._hoverState = Ki, e._config.delay && e._config.delay.show ? e._timeout = setTimeout(() => {
                e._hoverState === Ki && e.show()
            }, e._config.delay.show) : e.show())
        }

        _leave(t, e) {
            e = this._initializeOnDelegatedTarget(t, e), t && (e._activeTrigger["focusout" === t.type ? "focus" : Qi] = e._element.contains(t.relatedTarget)), e._isWithActiveTrigger() || (clearTimeout(e._timeout), e._hoverState = "out", e._config.delay && e._config.delay.hide ? e._timeout = setTimeout(() => {
                "out" === e._hoverState && e.hide()
            }, e._config.delay.hide) : e.hide())
        }

        _isWithActiveTrigger() {
            for (const t in this._activeTrigger) if (this._activeTrigger[t]) return !0;
            return !1
        }

        _getConfig(t) {
            const e = U.getDataAttributes(this._element);
            return Object.keys(e).forEach(t => {
                Wi.has(t) && delete e[t]
            }), (t = {...this.constructor.Default, ...e, ..."object" == typeof t && t ? t : {}}).container = !1 === t.container ? document.body : r(t.container), "number" == typeof t.delay && (t.delay = {
                show: t.delay,
                hide: t.delay
            }), "number" == typeof t.title && (t.title = t.title.toString()), "number" == typeof t.content && (t.content = t.content.toString()), a(Ri, t, this.constructor.DefaultType), t.sanitize && (t.template = Bi(t.template, t.allowList, t.sanitizeFn)), t
        }

        _getDelegateConfig() {
            const t = {};
            for (const e in this._config) this.constructor.Default[e] !== this._config[e] && (t[e] = this._config[e]);
            return t
        }

        _cleanTipClass() {
            const t = this.getTipElement(), e = new RegExp(`(^|\\s)${this._getBasicClassPrefix()}\\S+`, "g"),
                i = t.getAttribute("class").match(e);
            null !== i && i.length > 0 && i.map(t => t.trim()).forEach(e => t.classList.remove(e))
        }

        _getBasicClassPrefix() {
            return "bs-tooltip"
        }

        _handlePopperPlacementChange(t) {
            const {state: e} = t;
            e && (this.tip = e.elements.popper, this._cleanTipClass(), this._addAttachmentClass(this._getAttachment(e.placement)))
        }

        _disposePopper() {
            this._popper && (this._popper.destroy(), this._popper = null)
        }

        static jQueryInterface(t) {
            return this.each((function () {
                const e = Gi.getOrCreateInstance(this, t);
                if ("string" == typeof t) {
                    if (void 0 === e[t]) throw new TypeError(`No method named "${t}"`);
                    e[t]()
                }
            }))
        }
    }

    g(Gi);
    const Zi = {
        ...Gi.Default,
        placement: "right",
        offset: [0, 8],
        trigger: "click",
        content: "",
        template: '<div class="popover" role="tooltip"><div class="popover-arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
    }, Ji = {...Gi.DefaultType, content: "(string|element|function)"}, tn = {
        HIDE: "hide.bs.popover",
        HIDDEN: "hidden.bs.popover",
        SHOW: "show.bs.popover",
        SHOWN: "shown.bs.popover",
        INSERTED: "inserted.bs.popover",
        CLICK: "click.bs.popover",
        FOCUSIN: "focusin.bs.popover",
        FOCUSOUT: "focusout.bs.popover",
        MOUSEENTER: "mouseenter.bs.popover",
        MOUSELEAVE: "mouseleave.bs.popover"
    };

    class en extends Gi {
        static get Default() {
            return Zi
        }

        static get NAME() {
            return "popover"
        }

        static get Event() {
            return tn
        }

        static get DefaultType() {
            return Ji
        }

        isWithContent() {
            return this.getTitle() || this._getContent()
        }

        setContent(t) {
            this._sanitizeAndSetContent(t, this.getTitle(), ".popover-header"), this._sanitizeAndSetContent(t, this._getContent(), ".popover-body")
        }

        _getContent() {
            return this._resolvePossibleFunction(this._config.content)
        }

        _getBasicClassPrefix() {
            return "bs-popover"
        }

        static jQueryInterface(t) {
            return this.each((function () {
                const e = en.getOrCreateInstance(this, t);
                if ("string" == typeof t) {
                    if (void 0 === e[t]) throw new TypeError(`No method named "${t}"`);
                    e[t]()
                }
            }))
        }
    }

    g(en);
    const nn = "scrollspy", sn = {offset: 10, method: "auto", target: ""},
        on = {offset: "number", method: "string", target: "(string|element)"}, rn = "active",
        an = ".nav-link, .list-group-item, .dropdown-item", ln = "position";

    class cn extends B {
        constructor(t, e) {
            super(t), this._scrollElement = "BODY" === this._element.tagName ? window : this._element, this._config = this._getConfig(e), this._offsets = [], this._targets = [], this._activeTarget = null, this._scrollHeight = 0, j.on(this._scrollElement, "scroll.bs.scrollspy", () => this._process()), this.refresh(), this._process()
        }

        static get Default() {
            return sn
        }

        static get NAME() {
            return nn
        }

        refresh() {
            const t = this._scrollElement === this._scrollElement.window ? "offset" : ln,
                e = "auto" === this._config.method ? t : this._config.method, n = e === ln ? this._getScrollTop() : 0;
            this._offsets = [], this._targets = [], this._scrollHeight = this._getScrollHeight(), V.find(an, this._config.target).map(t => {
                const s = i(t), o = s ? V.findOne(s) : null;
                if (o) {
                    const t = o.getBoundingClientRect();
                    if (t.width || t.height) return [U[e](o).top + n, s]
                }
                return null
            }).filter(t => t).sort((t, e) => t[0] - e[0]).forEach(t => {
                this._offsets.push(t[0]), this._targets.push(t[1])
            })
        }

        dispose() {
            j.off(this._scrollElement, ".bs.scrollspy"), super.dispose()
        }

        _getConfig(t) {
            return (t = {...sn, ...U.getDataAttributes(this._element), ..."object" == typeof t && t ? t : {}}).target = r(t.target) || document.documentElement, a(nn, t, on), t
        }

        _getScrollTop() {
            return this._scrollElement === window ? this._scrollElement.pageYOffset : this._scrollElement.scrollTop
        }

        _getScrollHeight() {
            return this._scrollElement.scrollHeight || Math.max(document.body.scrollHeight, document.documentElement.scrollHeight)
        }

        _getOffsetHeight() {
            return this._scrollElement === window ? window.innerHeight : this._scrollElement.getBoundingClientRect().height
        }

        _process() {
            const t = this._getScrollTop() + this._config.offset, e = this._getScrollHeight(),
                i = this._config.offset + e - this._getOffsetHeight();
            if (this._scrollHeight !== e && this.refresh(), t >= i) {
                const t = this._targets[this._targets.length - 1];
                this._activeTarget !== t && this._activate(t)
            } else {
                if (this._activeTarget && t < this._offsets[0] && this._offsets[0] > 0) return this._activeTarget = null, void this._clear();
                for (let e = this._offsets.length; e--;) this._activeTarget !== this._targets[e] && t >= this._offsets[e] && (void 0 === this._offsets[e + 1] || t < this._offsets[e + 1]) && this._activate(this._targets[e])
            }
        }

        _activate(t) {
            this._activeTarget = t, this._clear();
            const e = an.split(",").map(e => `${e}[data-bs-target="${t}"],${e}[href="${t}"]`),
                i = V.findOne(e.join(","), this._config.target);
            i.classList.add(rn), i.classList.contains("dropdown-item") ? V.findOne(".dropdown-toggle", i.closest(".dropdown")).classList.add(rn) : V.parents(i, ".nav, .list-group").forEach(t => {
                V.prev(t, ".nav-link, .list-group-item").forEach(t => t.classList.add(rn)), V.prev(t, ".nav-item").forEach(t => {
                    V.children(t, ".nav-link").forEach(t => t.classList.add(rn))
                })
            }), j.trigger(this._scrollElement, "activate.bs.scrollspy", {relatedTarget: t})
        }

        _clear() {
            V.find(an, this._config.target).filter(t => t.classList.contains(rn)).forEach(t => t.classList.remove(rn))
        }

        static jQueryInterface(t) {
            return this.each((function () {
                const e = cn.getOrCreateInstance(this, t);
                if ("string" == typeof t) {
                    if (void 0 === e[t]) throw new TypeError(`No method named "${t}"`);
                    e[t]()
                }
            }))
        }
    }

    j.on(window, "load.bs.scrollspy.data-api", () => {
        V.find('[data-bs-spy="scroll"]').forEach(t => new cn(t))
    }), g(cn);
    const hn = "active", dn = ".active", un = ":scope > li > .active";

    class fn extends B {
        static get NAME() {
            return "tab"
        }

        show() {
            if (this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE && this._element.classList.contains(hn)) return;
            let t;
            const e = n(this._element), i = this._element.closest(".nav, .list-group");
            if (i) {
                const e = "UL" === i.nodeName || "OL" === i.nodeName ? un : dn;
                t = V.find(e, i), t = t[t.length - 1]
            }
            const s = t ? j.trigger(t, "hide.bs.tab", {relatedTarget: this._element}) : null;
            if (j.trigger(this._element, "show.bs.tab", {relatedTarget: t}).defaultPrevented || null !== s && s.defaultPrevented) return;
            this._activate(this._element, i);
            const o = () => {
                j.trigger(t, "hidden.bs.tab", {relatedTarget: this._element}), j.trigger(this._element, "shown.bs.tab", {relatedTarget: t})
            };
            e ? this._activate(e, e.parentNode, o) : o()
        }

        _activate(t, e, i) {
            const n = (!e || "UL" !== e.nodeName && "OL" !== e.nodeName ? V.children(e, dn) : V.find(un, e))[0],
                s = i && n && n.classList.contains("fade"), o = () => this._transitionComplete(t, n, i);
            n && s ? (n.classList.remove("show"), this._queueCallback(o, t, !0)) : o()
        }

        _transitionComplete(t, e, i) {
            if (e) {
                e.classList.remove(hn);
                const t = V.findOne(":scope > .dropdown-menu .active", e.parentNode);
                t && t.classList.remove(hn), "tab" === e.getAttribute("role") && e.setAttribute("aria-selected", !1)
            }
            t.classList.add(hn), "tab" === t.getAttribute("role") && t.setAttribute("aria-selected", !0), u(t), t.classList.contains("fade") && t.classList.add("show");
            let n = t.parentNode;
            if (n && "LI" === n.nodeName && (n = n.parentNode), n && n.classList.contains("dropdown-menu")) {
                const e = t.closest(".dropdown");
                e && V.find(".dropdown-toggle", e).forEach(t => t.classList.add(hn)), t.setAttribute("aria-expanded", !0)
            }
            i && i()
        }

        static jQueryInterface(t) {
            return this.each((function () {
                const e = fn.getOrCreateInstance(this);
                if ("string" == typeof t) {
                    if (void 0 === e[t]) throw new TypeError(`No method named "${t}"`);
                    e[t]()
                }
            }))
        }
    }

    j.on(document, "click.bs.tab.data-api", '[data-bs-toggle="tab"], [data-bs-toggle="pill"], [data-bs-toggle="list"]', (function (t) {
        ["A", "AREA"].includes(this.tagName) && t.preventDefault(), c(this) || fn.getOrCreateInstance(this).show()
    })), g(fn);
    const pn = "show", mn = "showing", gn = {animation: "boolean", autohide: "boolean", delay: "number"},
        _n = {animation: !0, autohide: !0, delay: 5e3};

    class bn extends B {
        constructor(t, e) {
            super(t), this._config = this._getConfig(e), this._timeout = null, this._hasMouseInteraction = !1, this._hasKeyboardInteraction = !1, this._setListeners()
        }

        static get DefaultType() {
            return gn
        }

        static get Default() {
            return _n
        }

        static get NAME() {
            return "toast"
        }

        show() {
            j.trigger(this._element, "show.bs.toast").defaultPrevented || (this._clearTimeout(), this._config.animation && this._element.classList.add("fade"), this._element.classList.remove("hide"), u(this._element), this._element.classList.add(pn), this._element.classList.add(mn), this._queueCallback(() => {
                this._element.classList.remove(mn), j.trigger(this._element, "shown.bs.toast"), this._maybeScheduleHide()
            }, this._element, this._config.animation))
        }

        hide() {
            this._element.classList.contains(pn) && (j.trigger(this._element, "hide.bs.toast").defaultPrevented || (this._element.classList.add(mn), this._queueCallback(() => {
                this._element.classList.add("hide"), this._element.classList.remove(mn), this._element.classList.remove(pn), j.trigger(this._element, "hidden.bs.toast")
            }, this._element, this._config.animation)))
        }

        dispose() {
            this._clearTimeout(), this._element.classList.contains(pn) && this._element.classList.remove(pn), super.dispose()
        }

        _getConfig(t) {
            return t = {..._n, ...U.getDataAttributes(this._element), ..."object" == typeof t && t ? t : {}}, a("toast", t, this.constructor.DefaultType), t
        }

        _maybeScheduleHide() {
            this._config.autohide && (this._hasMouseInteraction || this._hasKeyboardInteraction || (this._timeout = setTimeout(() => {
                this.hide()
            }, this._config.delay)))
        }

        _onInteraction(t, e) {
            switch (t.type) {
                case"mouseover":
                case"mouseout":
                    this._hasMouseInteraction = e;
                    break;
                case"focusin":
                case"focusout":
                    this._hasKeyboardInteraction = e
            }
            if (e) return void this._clearTimeout();
            const i = t.relatedTarget;
            this._element === i || this._element.contains(i) || this._maybeScheduleHide()
        }

        _setListeners() {
            j.on(this._element, "mouseover.bs.toast", t => this._onInteraction(t, !0)), j.on(this._element, "mouseout.bs.toast", t => this._onInteraction(t, !1)), j.on(this._element, "focusin.bs.toast", t => this._onInteraction(t, !0)), j.on(this._element, "focusout.bs.toast", t => this._onInteraction(t, !1))
        }

        _clearTimeout() {
            clearTimeout(this._timeout), this._timeout = null
        }

        static jQueryInterface(t) {
            return this.each((function () {
                const e = bn.getOrCreateInstance(this, t);
                if ("string" == typeof t) {
                    if (void 0 === e[t]) throw new TypeError(`No method named "${t}"`);
                    e[t](this)
                }
            }))
        }
    }

    return R(bn), g(bn), {
        Alert: W,
        Button: q,
        Carousel: st,
        Collapse: pt,
        Dropdown: si,
        Modal: ki,
        Offcanvas: Ii,
        Popover: en,
        ScrollSpy: cn,
        Tab: fn,
        Toast: bn,
        Tooltip: Gi
    }
}));
/*! jQuery v3.6.0 | (c) OpenJS Foundation and other contributors | jquery.org/license */
!function (e, t) {
    "use strict";
    "object" == typeof module && "object" == typeof module.exports ? module.exports = e.document ? t(e, !0) : function (e) {
        if (!e.document) throw new Error("jQuery requires a window with a document");
        return t(e)
    } : t(e)
}("undefined" != typeof window ? window : this, (function (e, t) {
    "use strict";
    var n = [], r = Object.getPrototypeOf, i = n.slice, o = n.flat ? function (e) {
            return n.flat.call(e)
        } : function (e) {
            return n.concat.apply([], e)
        }, a = n.push, s = n.indexOf, u = {}, l = u.toString, c = u.hasOwnProperty, f = c.toString, p = f.call(Object),
        d = {}, h = function (e) {
            return "function" == typeof e && "number" != typeof e.nodeType && "function" != typeof e.item
        }, g = function (e) {
            return null != e && e === e.window
        }, v = e.document, y = {type: !0, src: !0, nonce: !0, noModule: !0};

    function m(e, t, n) {
        var r, i, o = (n = n || v).createElement("script");
        if (o.text = e, t) for (r in y) (i = t[r] || t.getAttribute && t.getAttribute(r)) && o.setAttribute(r, i);
        n.head.appendChild(o).parentNode.removeChild(o)
    }

    function x(e) {
        return null == e ? e + "" : "object" == typeof e || "function" == typeof e ? u[l.call(e)] || "object" : typeof e
    }

    var b = "3.6.0", w = function (e, t) {
        return new w.fn.init(e, t)
    };

    function T(e) {
        var t = !!e && "length" in e && e.length, n = x(e);
        return !h(e) && !g(e) && ("array" === n || 0 === t || "number" == typeof t && 0 < t && t - 1 in e)
    }

    w.fn = w.prototype = {
        jquery: b, constructor: w, length: 0, toArray: function () {
            return i.call(this)
        }, get: function (e) {
            return null == e ? i.call(this) : e < 0 ? this[e + this.length] : this[e]
        }, pushStack: function (e) {
            var t = w.merge(this.constructor(), e);
            return t.prevObject = this, t
        }, each: function (e) {
            return w.each(this, e)
        }, map: function (e) {
            return this.pushStack(w.map(this, (function (t, n) {
                return e.call(t, n, t)
            })))
        }, slice: function () {
            return this.pushStack(i.apply(this, arguments))
        }, first: function () {
            return this.eq(0)
        }, last: function () {
            return this.eq(-1)
        }, even: function () {
            return this.pushStack(w.grep(this, (function (e, t) {
                return (t + 1) % 2
            })))
        }, odd: function () {
            return this.pushStack(w.grep(this, (function (e, t) {
                return t % 2
            })))
        }, eq: function (e) {
            var t = this.length, n = +e + (e < 0 ? t : 0);
            return this.pushStack(0 <= n && n < t ? [this[n]] : [])
        }, end: function () {
            return this.prevObject || this.constructor()
        }, push: a, sort: n.sort, splice: n.splice
    }, w.extend = w.fn.extend = function () {
        var e, t, n, r, i, o, a = arguments[0] || {}, s = 1, u = arguments.length, l = !1;
        for ("boolean" == typeof a && (l = a, a = arguments[s] || {}, s++), "object" == typeof a || h(a) || (a = {}), s === u && (a = this, s--); s < u; s++) if (null != (e = arguments[s])) for (t in e) r = e[t], "__proto__" !== t && a !== r && (l && r && (w.isPlainObject(r) || (i = Array.isArray(r))) ? (n = a[t], o = i && !Array.isArray(n) ? [] : i || w.isPlainObject(n) ? n : {}, i = !1, a[t] = w.extend(l, o, r)) : void 0 !== r && (a[t] = r));
        return a
    }, w.extend({
        expando: "jQuery" + (b + Math.random()).replace(/\D/g, ""), isReady: !0, error: function (e) {
            throw new Error(e)
        }, noop: function () {
        }, isPlainObject: function (e) {
            var t, n;
            return !(!e || "[object Object]" !== l.call(e) || (t = r(e)) && ("function" != typeof (n = c.call(t, "constructor") && t.constructor) || f.call(n) !== p))
        }, isEmptyObject: function (e) {
            var t;
            for (t in e) return !1;
            return !0
        }, globalEval: function (e, t, n) {
            m(e, {nonce: t && t.nonce}, n)
        }, each: function (e, t) {
            var n, r = 0;
            if (T(e)) for (n = e.length; r < n && !1 !== t.call(e[r], r, e[r]); r++) ; else for (r in e) if (!1 === t.call(e[r], r, e[r])) break;
            return e
        }, makeArray: function (e, t) {
            var n = t || [];
            return null != e && (T(Object(e)) ? w.merge(n, "string" == typeof e ? [e] : e) : a.call(n, e)), n
        }, inArray: function (e, t, n) {
            return null == t ? -1 : s.call(t, e, n)
        }, merge: function (e, t) {
            for (var n = +t.length, r = 0, i = e.length; r < n; r++) e[i++] = t[r];
            return e.length = i, e
        }, grep: function (e, t, n) {
            for (var r = [], i = 0, o = e.length, a = !n; i < o; i++) !t(e[i], i) !== a && r.push(e[i]);
            return r
        }, map: function (e, t, n) {
            var r, i, a = 0, s = [];
            if (T(e)) for (r = e.length; a < r; a++) null != (i = t(e[a], a, n)) && s.push(i); else for (a in e) null != (i = t(e[a], a, n)) && s.push(i);
            return o(s)
        }, guid: 1, support: d
    }), "function" == typeof Symbol && (w.fn[Symbol.iterator] = n[Symbol.iterator]), w.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "), (function (e, t) {
        u["[object " + t + "]"] = t.toLowerCase()
    }));
    var C = function (e) {
        var t, n, r, i, o, a, s, u, l, c, f, p, d, h, g, v, y, m, x, b = "sizzle" + 1 * new Date, w = e.document, T = 0,
            C = 0, E = ue(), S = ue(), k = ue(), A = ue(), N = function (e, t) {
                return e === t && (f = !0), 0
            }, j = {}.hasOwnProperty, D = [], q = D.pop, L = D.push, H = D.push, O = D.slice, P = function (e, t) {
                for (var n = 0, r = e.length; n < r; n++) if (e[n] === t) return n;
                return -1
            },
            R = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
            M = "[\\x20\\t\\r\\n\\f]", I = "(?:\\\\[\\da-fA-F]{1,6}" + M + "?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\\x7f])+",
            W = "\\[" + M + "*(" + I + ")(?:" + M + "*([*^$|!~]?=)" + M + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + I + "))|)" + M + "*\\]",
            F = ":(" + I + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + W + ")*)|.*)\\)|)",
            B = new RegExp(M + "+", "g"), $ = new RegExp("^" + M + "+|((?:^|[^\\\\])(?:\\\\.)*)" + M + "+$", "g"),
            _ = new RegExp("^" + M + "*," + M + "*"), z = new RegExp("^" + M + "*([>+~]|" + M + ")" + M + "*"),
            U = new RegExp(M + "|>"), X = new RegExp(F), V = new RegExp("^" + I + "$"), G = {
                ID: new RegExp("^#(" + I + ")"),
                CLASS: new RegExp("^\\.(" + I + ")"),
                TAG: new RegExp("^(" + I + "|[*])"),
                ATTR: new RegExp("^" + W),
                PSEUDO: new RegExp("^" + F),
                CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + M + "*(even|odd|(([+-]|)(\\d*)n|)" + M + "*(?:([+-]|)" + M + "*(\\d+)|))" + M + "*\\)|)", "i"),
                bool: new RegExp("^(?:" + R + ")$", "i"),
                needsContext: new RegExp("^" + M + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + M + "*((?:-\\d)?\\d*)" + M + "*\\)|)(?=[^-]|$)", "i")
            }, Y = /HTML$/i, Q = /^(?:input|select|textarea|button)$/i, J = /^h\d$/i, K = /^[^{]+\{\s*\[native \w/,
            Z = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/, ee = /[+~]/,
            te = new RegExp("\\\\[\\da-fA-F]{1,6}" + M + "?|\\\\([^\\r\\n\\f])", "g"), ne = function (e, t) {
                var n = "0x" + e.slice(1) - 65536;
                return t || (n < 0 ? String.fromCharCode(n + 65536) : String.fromCharCode(n >> 10 | 55296, 1023 & n | 56320))
            }, re = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g, ie = function (e, t) {
                return t ? "\0" === e ? "�" : e.slice(0, -1) + "\\" + e.charCodeAt(e.length - 1).toString(16) + " " : "\\" + e
            }, oe = function () {
                p()
            }, ae = be((function (e) {
                return !0 === e.disabled && "fieldset" === e.nodeName.toLowerCase()
            }), {dir: "parentNode", next: "legend"});
        try {
            H.apply(D = O.call(w.childNodes), w.childNodes), D[w.childNodes.length].nodeType
        } catch (t) {
            H = {
                apply: D.length ? function (e, t) {
                    L.apply(e, O.call(t))
                } : function (e, t) {
                    for (var n = e.length, r = 0; e[n++] = t[r++];) ;
                    e.length = n - 1
                }
            }
        }

        function se(e, t, r, i) {
            var o, s, l, c, f, h, y, m = t && t.ownerDocument, w = t ? t.nodeType : 9;
            if (r = r || [], "string" != typeof e || !e || 1 !== w && 9 !== w && 11 !== w) return r;
            if (!i && (p(t), t = t || d, g)) {
                if (11 !== w && (f = Z.exec(e))) if (o = f[1]) {
                    if (9 === w) {
                        if (!(l = t.getElementById(o))) return r;
                        if (l.id === o) return r.push(l), r
                    } else if (m && (l = m.getElementById(o)) && x(t, l) && l.id === o) return r.push(l), r
                } else {
                    if (f[2]) return H.apply(r, t.getElementsByTagName(e)), r;
                    if ((o = f[3]) && n.getElementsByClassName && t.getElementsByClassName) return H.apply(r, t.getElementsByClassName(o)), r
                }
                if (n.qsa && !A[e + " "] && (!v || !v.test(e)) && (1 !== w || "object" !== t.nodeName.toLowerCase())) {
                    if (y = e, m = t, 1 === w && (U.test(e) || z.test(e))) {
                        for ((m = ee.test(e) && ye(t.parentNode) || t) === t && n.scope || ((c = t.getAttribute("id")) ? c = c.replace(re, ie) : t.setAttribute("id", c = b)), s = (h = a(e)).length; s--;) h[s] = (c ? "#" + c : ":scope") + " " + xe(h[s]);
                        y = h.join(",")
                    }
                    try {
                        return H.apply(r, m.querySelectorAll(y)), r
                    } catch (t) {
                        A(e, !0)
                    } finally {
                        c === b && t.removeAttribute("id")
                    }
                }
            }
            return u(e.replace($, "$1"), t, r, i)
        }

        function ue() {
            var e = [];
            return function t(n, i) {
                return e.push(n + " ") > r.cacheLength && delete t[e.shift()], t[n + " "] = i
            }
        }

        function le(e) {
            return e[b] = !0, e
        }

        function ce(e) {
            var t = d.createElement("fieldset");
            try {
                return !!e(t)
            } catch (e) {
                return !1
            } finally {
                t.parentNode && t.parentNode.removeChild(t), t = null
            }
        }

        function fe(e, t) {
            for (var n = e.split("|"), i = n.length; i--;) r.attrHandle[n[i]] = t
        }

        function pe(e, t) {
            var n = t && e, r = n && 1 === e.nodeType && 1 === t.nodeType && e.sourceIndex - t.sourceIndex;
            if (r) return r;
            if (n) for (; n = n.nextSibling;) if (n === t) return -1;
            return e ? 1 : -1
        }

        function de(e) {
            return function (t) {
                return "input" === t.nodeName.toLowerCase() && t.type === e
            }
        }

        function he(e) {
            return function (t) {
                var n = t.nodeName.toLowerCase();
                return ("input" === n || "button" === n) && t.type === e
            }
        }

        function ge(e) {
            return function (t) {
                return "form" in t ? t.parentNode && !1 === t.disabled ? "label" in t ? "label" in t.parentNode ? t.parentNode.disabled === e : t.disabled === e : t.isDisabled === e || t.isDisabled !== !e && ae(t) === e : t.disabled === e : "label" in t && t.disabled === e
            }
        }

        function ve(e) {
            return le((function (t) {
                return t = +t, le((function (n, r) {
                    for (var i, o = e([], n.length, t), a = o.length; a--;) n[i = o[a]] && (n[i] = !(r[i] = n[i]))
                }))
            }))
        }

        function ye(e) {
            return e && void 0 !== e.getElementsByTagName && e
        }

        for (t in n = se.support = {}, o = se.isXML = function (e) {
            var t = e && e.namespaceURI, n = e && (e.ownerDocument || e).documentElement;
            return !Y.test(t || n && n.nodeName || "HTML")
        }, p = se.setDocument = function (e) {
            var t, i, a = e ? e.ownerDocument || e : w;
            return a != d && 9 === a.nodeType && a.documentElement && (h = (d = a).documentElement, g = !o(d), w != d && (i = d.defaultView) && i.top !== i && (i.addEventListener ? i.addEventListener("unload", oe, !1) : i.attachEvent && i.attachEvent("onunload", oe)), n.scope = ce((function (e) {
                return h.appendChild(e).appendChild(d.createElement("div")), void 0 !== e.querySelectorAll && !e.querySelectorAll(":scope fieldset div").length
            })), n.attributes = ce((function (e) {
                return e.className = "i", !e.getAttribute("className")
            })), n.getElementsByTagName = ce((function (e) {
                return e.appendChild(d.createComment("")), !e.getElementsByTagName("*").length
            })), n.getElementsByClassName = K.test(d.getElementsByClassName), n.getById = ce((function (e) {
                return h.appendChild(e).id = b, !d.getElementsByName || !d.getElementsByName(b).length
            })), n.getById ? (r.filter.ID = function (e) {
                var t = e.replace(te, ne);
                return function (e) {
                    return e.getAttribute("id") === t
                }
            }, r.find.ID = function (e, t) {
                if (void 0 !== t.getElementById && g) {
                    var n = t.getElementById(e);
                    return n ? [n] : []
                }
            }) : (r.filter.ID = function (e) {
                var t = e.replace(te, ne);
                return function (e) {
                    var n = void 0 !== e.getAttributeNode && e.getAttributeNode("id");
                    return n && n.value === t
                }
            }, r.find.ID = function (e, t) {
                if (void 0 !== t.getElementById && g) {
                    var n, r, i, o = t.getElementById(e);
                    if (o) {
                        if ((n = o.getAttributeNode("id")) && n.value === e) return [o];
                        for (i = t.getElementsByName(e), r = 0; o = i[r++];) if ((n = o.getAttributeNode("id")) && n.value === e) return [o]
                    }
                    return []
                }
            }), r.find.TAG = n.getElementsByTagName ? function (e, t) {
                return void 0 !== t.getElementsByTagName ? t.getElementsByTagName(e) : n.qsa ? t.querySelectorAll(e) : void 0
            } : function (e, t) {
                var n, r = [], i = 0, o = t.getElementsByTagName(e);
                if ("*" === e) {
                    for (; n = o[i++];) 1 === n.nodeType && r.push(n);
                    return r
                }
                return o
            }, r.find.CLASS = n.getElementsByClassName && function (e, t) {
                if (void 0 !== t.getElementsByClassName && g) return t.getElementsByClassName(e)
            }, y = [], v = [], (n.qsa = K.test(d.querySelectorAll)) && (ce((function (e) {
                var t;
                h.appendChild(e).innerHTML = "<a id='" + b + "'></a><select id='" + b + "-\r\\' msallowcapture=''><option selected=''></option></select>", e.querySelectorAll("[msallowcapture^='']").length && v.push("[*^$]=" + M + "*(?:''|\"\")"), e.querySelectorAll("[selected]").length || v.push("\\[" + M + "*(?:value|" + R + ")"), e.querySelectorAll("[id~=" + b + "-]").length || v.push("~="), (t = d.createElement("input")).setAttribute("name", ""), e.appendChild(t), e.querySelectorAll("[name='']").length || v.push("\\[" + M + "*name" + M + "*=" + M + "*(?:''|\"\")"), e.querySelectorAll(":checked").length || v.push(":checked"), e.querySelectorAll("a#" + b + "+*").length || v.push(".#.+[+~]"), e.querySelectorAll("\\\f"), v.push("[\\r\\n\\f]")
            })), ce((function (e) {
                e.innerHTML = "<a href='' disabled='disabled'></a><select disabled='disabled'><option/></select>";
                var t = d.createElement("input");
                t.setAttribute("type", "hidden"), e.appendChild(t).setAttribute("name", "D"), e.querySelectorAll("[name=d]").length && v.push("name" + M + "*[*^$|!~]?="), 2 !== e.querySelectorAll(":enabled").length && v.push(":enabled", ":disabled"), h.appendChild(e).disabled = !0, 2 !== e.querySelectorAll(":disabled").length && v.push(":enabled", ":disabled"), e.querySelectorAll("*,:x"), v.push(",.*:")
            }))), (n.matchesSelector = K.test(m = h.matches || h.webkitMatchesSelector || h.mozMatchesSelector || h.oMatchesSelector || h.msMatchesSelector)) && ce((function (e) {
                n.disconnectedMatch = m.call(e, "*"), m.call(e, "[s!='']:x"), y.push("!=", F)
            })), v = v.length && new RegExp(v.join("|")), y = y.length && new RegExp(y.join("|")), t = K.test(h.compareDocumentPosition), x = t || K.test(h.contains) ? function (e, t) {
                var n = 9 === e.nodeType ? e.documentElement : e, r = t && t.parentNode;
                return e === r || !(!r || 1 !== r.nodeType || !(n.contains ? n.contains(r) : e.compareDocumentPosition && 16 & e.compareDocumentPosition(r)))
            } : function (e, t) {
                if (t) for (; t = t.parentNode;) if (t === e) return !0;
                return !1
            }, N = t ? function (e, t) {
                if (e === t) return f = !0, 0;
                var r = !e.compareDocumentPosition - !t.compareDocumentPosition;
                return r || (1 & (r = (e.ownerDocument || e) == (t.ownerDocument || t) ? e.compareDocumentPosition(t) : 1) || !n.sortDetached && t.compareDocumentPosition(e) === r ? e == d || e.ownerDocument == w && x(w, e) ? -1 : t == d || t.ownerDocument == w && x(w, t) ? 1 : c ? P(c, e) - P(c, t) : 0 : 4 & r ? -1 : 1)
            } : function (e, t) {
                if (e === t) return f = !0, 0;
                var n, r = 0, i = e.parentNode, o = t.parentNode, a = [e], s = [t];
                if (!i || !o) return e == d ? -1 : t == d ? 1 : i ? -1 : o ? 1 : c ? P(c, e) - P(c, t) : 0;
                if (i === o) return pe(e, t);
                for (n = e; n = n.parentNode;) a.unshift(n);
                for (n = t; n = n.parentNode;) s.unshift(n);
                for (; a[r] === s[r];) r++;
                return r ? pe(a[r], s[r]) : a[r] == w ? -1 : s[r] == w ? 1 : 0
            }), d
        }, se.matches = function (e, t) {
            return se(e, null, null, t)
        }, se.matchesSelector = function (e, t) {
            if (p(e), n.matchesSelector && g && !A[t + " "] && (!y || !y.test(t)) && (!v || !v.test(t))) try {
                var r = m.call(e, t);
                if (r || n.disconnectedMatch || e.document && 11 !== e.document.nodeType) return r
            } catch (e) {
                A(t, !0)
            }
            return 0 < se(t, d, null, [e]).length
        }, se.contains = function (e, t) {
            return (e.ownerDocument || e) != d && p(e), x(e, t)
        }, se.attr = function (e, t) {
            (e.ownerDocument || e) != d && p(e);
            var i = r.attrHandle[t.toLowerCase()],
                o = i && j.call(r.attrHandle, t.toLowerCase()) ? i(e, t, !g) : void 0;
            return void 0 !== o ? o : n.attributes || !g ? e.getAttribute(t) : (o = e.getAttributeNode(t)) && o.specified ? o.value : null
        }, se.escape = function (e) {
            return (e + "").replace(re, ie)
        }, se.error = function (e) {
            throw new Error("Syntax error, unrecognized expression: " + e)
        }, se.uniqueSort = function (e) {
            var t, r = [], i = 0, o = 0;
            if (f = !n.detectDuplicates, c = !n.sortStable && e.slice(0), e.sort(N), f) {
                for (; t = e[o++];) t === e[o] && (i = r.push(o));
                for (; i--;) e.splice(r[i], 1)
            }
            return c = null, e
        }, i = se.getText = function (e) {
            var t, n = "", r = 0, o = e.nodeType;
            if (o) {
                if (1 === o || 9 === o || 11 === o) {
                    if ("string" == typeof e.textContent) return e.textContent;
                    for (e = e.firstChild; e; e = e.nextSibling) n += i(e)
                } else if (3 === o || 4 === o) return e.nodeValue
            } else for (; t = e[r++];) n += i(t);
            return n
        }, (r = se.selectors = {
            cacheLength: 50,
            createPseudo: le,
            match: G,
            attrHandle: {},
            find: {},
            relative: {
                ">": {dir: "parentNode", first: !0},
                " ": {dir: "parentNode"},
                "+": {dir: "previousSibling", first: !0},
                "~": {dir: "previousSibling"}
            },
            preFilter: {
                ATTR: function (e) {
                    return e[1] = e[1].replace(te, ne), e[3] = (e[3] || e[4] || e[5] || "").replace(te, ne), "~=" === e[2] && (e[3] = " " + e[3] + " "), e.slice(0, 4)
                }, CHILD: function (e) {
                    return e[1] = e[1].toLowerCase(), "nth" === e[1].slice(0, 3) ? (e[3] || se.error(e[0]), e[4] = +(e[4] ? e[5] + (e[6] || 1) : 2 * ("even" === e[3] || "odd" === e[3])), e[5] = +(e[7] + e[8] || "odd" === e[3])) : e[3] && se.error(e[0]), e
                }, PSEUDO: function (e) {
                    var t, n = !e[6] && e[2];
                    return G.CHILD.test(e[0]) ? null : (e[3] ? e[2] = e[4] || e[5] || "" : n && X.test(n) && (t = a(n, !0)) && (t = n.indexOf(")", n.length - t) - n.length) && (e[0] = e[0].slice(0, t), e[2] = n.slice(0, t)), e.slice(0, 3))
                }
            },
            filter: {
                TAG: function (e) {
                    var t = e.replace(te, ne).toLowerCase();
                    return "*" === e ? function () {
                        return !0
                    } : function (e) {
                        return e.nodeName && e.nodeName.toLowerCase() === t
                    }
                }, CLASS: function (e) {
                    var t = E[e + " "];
                    return t || (t = new RegExp("(^|" + M + ")" + e + "(" + M + "|$)")) && E(e, (function (e) {
                        return t.test("string" == typeof e.className && e.className || void 0 !== e.getAttribute && e.getAttribute("class") || "")
                    }))
                }, ATTR: function (e, t, n) {
                    return function (r) {
                        var i = se.attr(r, e);
                        return null == i ? "!=" === t : !t || (i += "", "=" === t ? i === n : "!=" === t ? i !== n : "^=" === t ? n && 0 === i.indexOf(n) : "*=" === t ? n && -1 < i.indexOf(n) : "$=" === t ? n && i.slice(-n.length) === n : "~=" === t ? -1 < (" " + i.replace(B, " ") + " ").indexOf(n) : "|=" === t && (i === n || i.slice(0, n.length + 1) === n + "-"))
                    }
                }, CHILD: function (e, t, n, r, i) {
                    var o = "nth" !== e.slice(0, 3), a = "last" !== e.slice(-4), s = "of-type" === t;
                    return 1 === r && 0 === i ? function (e) {
                        return !!e.parentNode
                    } : function (t, n, u) {
                        var l, c, f, p, d, h, g = o !== a ? "nextSibling" : "previousSibling", v = t.parentNode,
                            y = s && t.nodeName.toLowerCase(), m = !u && !s, x = !1;
                        if (v) {
                            if (o) {
                                for (; g;) {
                                    for (p = t; p = p[g];) if (s ? p.nodeName.toLowerCase() === y : 1 === p.nodeType) return !1;
                                    h = g = "only" === e && !h && "nextSibling"
                                }
                                return !0
                            }
                            if (h = [a ? v.firstChild : v.lastChild], a && m) {
                                for (x = (d = (l = (c = (f = (p = v)[b] || (p[b] = {}))[p.uniqueID] || (f[p.uniqueID] = {}))[e] || [])[0] === T && l[1]) && l[2], p = d && v.childNodes[d]; p = ++d && p && p[g] || (x = d = 0) || h.pop();) if (1 === p.nodeType && ++x && p === t) {
                                    c[e] = [T, d, x];
                                    break
                                }
                            } else if (m && (x = d = (l = (c = (f = (p = t)[b] || (p[b] = {}))[p.uniqueID] || (f[p.uniqueID] = {}))[e] || [])[0] === T && l[1]), !1 === x) for (; (p = ++d && p && p[g] || (x = d = 0) || h.pop()) && ((s ? p.nodeName.toLowerCase() !== y : 1 !== p.nodeType) || !++x || (m && ((c = (f = p[b] || (p[b] = {}))[p.uniqueID] || (f[p.uniqueID] = {}))[e] = [T, x]), p !== t));) ;
                            return (x -= i) === r || x % r == 0 && 0 <= x / r
                        }
                    }
                }, PSEUDO: function (e, t) {
                    var n, i = r.pseudos[e] || r.setFilters[e.toLowerCase()] || se.error("unsupported pseudo: " + e);
                    return i[b] ? i(t) : 1 < i.length ? (n = [e, e, "", t], r.setFilters.hasOwnProperty(e.toLowerCase()) ? le((function (e, n) {
                        for (var r, o = i(e, t), a = o.length; a--;) e[r = P(e, o[a])] = !(n[r] = o[a])
                    })) : function (e) {
                        return i(e, 0, n)
                    }) : i
                }
            },
            pseudos: {
                not: le((function (e) {
                    var t = [], n = [], r = s(e.replace($, "$1"));
                    return r[b] ? le((function (e, t, n, i) {
                        for (var o, a = r(e, null, i, []), s = e.length; s--;) (o = a[s]) && (e[s] = !(t[s] = o))
                    })) : function (e, i, o) {
                        return t[0] = e, r(t, null, o, n), t[0] = null, !n.pop()
                    }
                })), has: le((function (e) {
                    return function (t) {
                        return 0 < se(e, t).length
                    }
                })), contains: le((function (e) {
                    return e = e.replace(te, ne), function (t) {
                        return -1 < (t.textContent || i(t)).indexOf(e)
                    }
                })), lang: le((function (e) {
                    return V.test(e || "") || se.error("unsupported lang: " + e), e = e.replace(te, ne).toLowerCase(), function (t) {
                        var n;
                        do {
                            if (n = g ? t.lang : t.getAttribute("xml:lang") || t.getAttribute("lang")) return (n = n.toLowerCase()) === e || 0 === n.indexOf(e + "-")
                        } while ((t = t.parentNode) && 1 === t.nodeType);
                        return !1
                    }
                })), target: function (t) {
                    var n = e.location && e.location.hash;
                    return n && n.slice(1) === t.id
                }, root: function (e) {
                    return e === h
                }, focus: function (e) {
                    return e === d.activeElement && (!d.hasFocus || d.hasFocus()) && !!(e.type || e.href || ~e.tabIndex)
                }, enabled: ge(!1), disabled: ge(!0), checked: function (e) {
                    var t = e.nodeName.toLowerCase();
                    return "input" === t && !!e.checked || "option" === t && !!e.selected
                }, selected: function (e) {
                    return e.parentNode && e.parentNode.selectedIndex, !0 === e.selected
                }, empty: function (e) {
                    for (e = e.firstChild; e; e = e.nextSibling) if (e.nodeType < 6) return !1;
                    return !0
                }, parent: function (e) {
                    return !r.pseudos.empty(e)
                }, header: function (e) {
                    return J.test(e.nodeName)
                }, input: function (e) {
                    return Q.test(e.nodeName)
                }, button: function (e) {
                    var t = e.nodeName.toLowerCase();
                    return "input" === t && "button" === e.type || "button" === t
                }, text: function (e) {
                    var t;
                    return "input" === e.nodeName.toLowerCase() && "text" === e.type && (null == (t = e.getAttribute("type")) || "text" === t.toLowerCase())
                }, first: ve((function () {
                    return [0]
                })), last: ve((function (e, t) {
                    return [t - 1]
                })), eq: ve((function (e, t, n) {
                    return [n < 0 ? n + t : n]
                })), even: ve((function (e, t) {
                    for (var n = 0; n < t; n += 2) e.push(n);
                    return e
                })), odd: ve((function (e, t) {
                    for (var n = 1; n < t; n += 2) e.push(n);
                    return e
                })), lt: ve((function (e, t, n) {
                    for (var r = n < 0 ? n + t : t < n ? t : n; 0 <= --r;) e.push(r);
                    return e
                })), gt: ve((function (e, t, n) {
                    for (var r = n < 0 ? n + t : n; ++r < t;) e.push(r);
                    return e
                }))
            }
        }).pseudos.nth = r.pseudos.eq, {
            radio: !0,
            checkbox: !0,
            file: !0,
            password: !0,
            image: !0
        }) r.pseudos[t] = de(t);
        for (t in {submit: !0, reset: !0}) r.pseudos[t] = he(t);

        function me() {
        }

        function xe(e) {
            for (var t = 0, n = e.length, r = ""; t < n; t++) r += e[t].value;
            return r
        }

        function be(e, t, n) {
            var r = t.dir, i = t.next, o = i || r, a = n && "parentNode" === o, s = C++;
            return t.first ? function (t, n, i) {
                for (; t = t[r];) if (1 === t.nodeType || a) return e(t, n, i);
                return !1
            } : function (t, n, u) {
                var l, c, f, p = [T, s];
                if (u) {
                    for (; t = t[r];) if ((1 === t.nodeType || a) && e(t, n, u)) return !0
                } else for (; t = t[r];) if (1 === t.nodeType || a) if (c = (f = t[b] || (t[b] = {}))[t.uniqueID] || (f[t.uniqueID] = {}), i && i === t.nodeName.toLowerCase()) t = t[r] || t; else {
                    if ((l = c[o]) && l[0] === T && l[1] === s) return p[2] = l[2];
                    if ((c[o] = p)[2] = e(t, n, u)) return !0
                }
                return !1
            }
        }

        function we(e) {
            return 1 < e.length ? function (t, n, r) {
                for (var i = e.length; i--;) if (!e[i](t, n, r)) return !1;
                return !0
            } : e[0]
        }

        function Te(e, t, n, r, i) {
            for (var o, a = [], s = 0, u = e.length, l = null != t; s < u; s++) (o = e[s]) && (n && !n(o, r, i) || (a.push(o), l && t.push(s)));
            return a
        }

        function Ce(e, t, n, r, i, o) {
            return r && !r[b] && (r = Ce(r)), i && !i[b] && (i = Ce(i, o)), le((function (o, a, s, u) {
                var l, c, f, p = [], d = [], h = a.length, g = o || function (e, t, n) {
                        for (var r = 0, i = t.length; r < i; r++) se(e, t[r], n);
                        return n
                    }(t || "*", s.nodeType ? [s] : s, []), v = !e || !o && t ? g : Te(g, p, e, s, u),
                    y = n ? i || (o ? e : h || r) ? [] : a : v;
                if (n && n(v, y, s, u), r) for (l = Te(y, d), r(l, [], s, u), c = l.length; c--;) (f = l[c]) && (y[d[c]] = !(v[d[c]] = f));
                if (o) {
                    if (i || e) {
                        if (i) {
                            for (l = [], c = y.length; c--;) (f = y[c]) && l.push(v[c] = f);
                            i(null, y = [], l, u)
                        }
                        for (c = y.length; c--;) (f = y[c]) && -1 < (l = i ? P(o, f) : p[c]) && (o[l] = !(a[l] = f))
                    }
                } else y = Te(y === a ? y.splice(h, y.length) : y), i ? i(null, a, y, u) : H.apply(a, y)
            }))
        }

        function Ee(e) {
            for (var t, n, i, o = e.length, a = r.relative[e[0].type], s = a || r.relative[" "], u = a ? 1 : 0, c = be((function (e) {
                return e === t
            }), s, !0), f = be((function (e) {
                return -1 < P(t, e)
            }), s, !0), p = [function (e, n, r) {
                var i = !a && (r || n !== l) || ((t = n).nodeType ? c(e, n, r) : f(e, n, r));
                return t = null, i
            }]; u < o; u++) if (n = r.relative[e[u].type]) p = [be(we(p), n)]; else {
                if ((n = r.filter[e[u].type].apply(null, e[u].matches))[b]) {
                    for (i = ++u; i < o && !r.relative[e[i].type]; i++) ;
                    return Ce(1 < u && we(p), 1 < u && xe(e.slice(0, u - 1).concat({value: " " === e[u - 2].type ? "*" : ""})).replace($, "$1"), n, u < i && Ee(e.slice(u, i)), i < o && Ee(e = e.slice(i)), i < o && xe(e))
                }
                p.push(n)
            }
            return we(p)
        }

        return me.prototype = r.filters = r.pseudos, r.setFilters = new me, a = se.tokenize = function (e, t) {
            var n, i, o, a, s, u, l, c = S[e + " "];
            if (c) return t ? 0 : c.slice(0);
            for (s = e, u = [], l = r.preFilter; s;) {
                for (a in n && !(i = _.exec(s)) || (i && (s = s.slice(i[0].length) || s), u.push(o = [])), n = !1, (i = z.exec(s)) && (n = i.shift(), o.push({
                    value: n,
                    type: i[0].replace($, " ")
                }), s = s.slice(n.length)), r.filter) !(i = G[a].exec(s)) || l[a] && !(i = l[a](i)) || (n = i.shift(), o.push({
                    value: n,
                    type: a,
                    matches: i
                }), s = s.slice(n.length));
                if (!n) break
            }
            return t ? s.length : s ? se.error(e) : S(e, u).slice(0)
        }, s = se.compile = function (e, t) {
            var n, i, o, s, u, c, f = [], h = [], v = k[e + " "];
            if (!v) {
                for (t || (t = a(e)), n = t.length; n--;) (v = Ee(t[n]))[b] ? f.push(v) : h.push(v);
                (v = k(e, (i = h, s = 0 < (o = f).length, u = 0 < i.length, c = function (e, t, n, a, c) {
                    var f, h, v, y = 0, m = "0", x = e && [], b = [], w = l, C = e || u && r.find.TAG("*", c),
                        E = T += null == w ? 1 : Math.random() || .1, S = C.length;
                    for (c && (l = t == d || t || c); m !== S && null != (f = C[m]); m++) {
                        if (u && f) {
                            for (h = 0, t || f.ownerDocument == d || (p(f), n = !g); v = i[h++];) if (v(f, t || d, n)) {
                                a.push(f);
                                break
                            }
                            c && (T = E)
                        }
                        s && ((f = !v && f) && y--, e && x.push(f))
                    }
                    if (y += m, s && m !== y) {
                        for (h = 0; v = o[h++];) v(x, b, t, n);
                        if (e) {
                            if (0 < y) for (; m--;) x[m] || b[m] || (b[m] = q.call(a));
                            b = Te(b)
                        }
                        H.apply(a, b), c && !e && 0 < b.length && 1 < y + o.length && se.uniqueSort(a)
                    }
                    return c && (T = E, l = w), x
                }, s ? le(c) : c))).selector = e
            }
            return v
        }, u = se.select = function (e, t, n, i) {
            var o, u, l, c, f, p = "function" == typeof e && e, d = !i && a(e = p.selector || e);
            if (n = n || [], 1 === d.length) {
                if (2 < (u = d[0] = d[0].slice(0)).length && "ID" === (l = u[0]).type && 9 === t.nodeType && g && r.relative[u[1].type]) {
                    if (!(t = (r.find.ID(l.matches[0].replace(te, ne), t) || [])[0])) return n;
                    p && (t = t.parentNode), e = e.slice(u.shift().value.length)
                }
                for (o = G.needsContext.test(e) ? 0 : u.length; o-- && (l = u[o], !r.relative[c = l.type]);) if ((f = r.find[c]) && (i = f(l.matches[0].replace(te, ne), ee.test(u[0].type) && ye(t.parentNode) || t))) {
                    if (u.splice(o, 1), !(e = i.length && xe(u))) return H.apply(n, i), n;
                    break
                }
            }
            return (p || s(e, d))(i, t, !g, n, !t || ee.test(e) && ye(t.parentNode) || t), n
        }, n.sortStable = b.split("").sort(N).join("") === b, n.detectDuplicates = !!f, p(), n.sortDetached = ce((function (e) {
            return 1 & e.compareDocumentPosition(d.createElement("fieldset"))
        })), ce((function (e) {
            return e.innerHTML = "<a href='#'></a>", "#" === e.firstChild.getAttribute("href")
        })) || fe("type|href|height|width", (function (e, t, n) {
            if (!n) return e.getAttribute(t, "type" === t.toLowerCase() ? 1 : 2)
        })), n.attributes && ce((function (e) {
            return e.innerHTML = "<input/>", e.firstChild.setAttribute("value", ""), "" === e.firstChild.getAttribute("value")
        })) || fe("value", (function (e, t, n) {
            if (!n && "input" === e.nodeName.toLowerCase()) return e.defaultValue
        })), ce((function (e) {
            return null == e.getAttribute("disabled")
        })) || fe(R, (function (e, t, n) {
            var r;
            if (!n) return !0 === e[t] ? t.toLowerCase() : (r = e.getAttributeNode(t)) && r.specified ? r.value : null
        })), se
    }(e);
    w.find = C, w.expr = C.selectors, w.expr[":"] = w.expr.pseudos, w.uniqueSort = w.unique = C.uniqueSort, w.text = C.getText, w.isXMLDoc = C.isXML, w.contains = C.contains, w.escapeSelector = C.escape;
    var E = function (e, t, n) {
        for (var r = [], i = void 0 !== n; (e = e[t]) && 9 !== e.nodeType;) if (1 === e.nodeType) {
            if (i && w(e).is(n)) break;
            r.push(e)
        }
        return r
    }, S = function (e, t) {
        for (var n = []; e; e = e.nextSibling) 1 === e.nodeType && e !== t && n.push(e);
        return n
    }, k = w.expr.match.needsContext;

    function A(e, t) {
        return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase()
    }

    var N = /^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;

    function j(e, t, n) {
        return h(t) ? w.grep(e, (function (e, r) {
            return !!t.call(e, r, e) !== n
        })) : t.nodeType ? w.grep(e, (function (e) {
            return e === t !== n
        })) : "string" != typeof t ? w.grep(e, (function (e) {
            return -1 < s.call(t, e) !== n
        })) : w.filter(t, e, n)
    }

    w.filter = function (e, t, n) {
        var r = t[0];
        return n && (e = ":not(" + e + ")"), 1 === t.length && 1 === r.nodeType ? w.find.matchesSelector(r, e) ? [r] : [] : w.find.matches(e, w.grep(t, (function (e) {
            return 1 === e.nodeType
        })))
    }, w.fn.extend({
        find: function (e) {
            var t, n, r = this.length, i = this;
            if ("string" != typeof e) return this.pushStack(w(e).filter((function () {
                for (t = 0; t < r; t++) if (w.contains(i[t], this)) return !0
            })));
            for (n = this.pushStack([]), t = 0; t < r; t++) w.find(e, i[t], n);
            return 1 < r ? w.uniqueSort(n) : n
        }, filter: function (e) {
            return this.pushStack(j(this, e || [], !1))
        }, not: function (e) {
            return this.pushStack(j(this, e || [], !0))
        }, is: function (e) {
            return !!j(this, "string" == typeof e && k.test(e) ? w(e) : e || [], !1).length
        }
    });
    var D, q = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/;
    (w.fn.init = function (e, t, n) {
        var r, i;
        if (!e) return this;
        if (n = n || D, "string" == typeof e) {
            if (!(r = "<" === e[0] && ">" === e[e.length - 1] && 3 <= e.length ? [null, e, null] : q.exec(e)) || !r[1] && t) return !t || t.jquery ? (t || n).find(e) : this.constructor(t).find(e);
            if (r[1]) {
                if (t = t instanceof w ? t[0] : t, w.merge(this, w.parseHTML(r[1], t && t.nodeType ? t.ownerDocument || t : v, !0)), N.test(r[1]) && w.isPlainObject(t)) for (r in t) h(this[r]) ? this[r](t[r]) : this.attr(r, t[r]);
                return this
            }
            return (i = v.getElementById(r[2])) && (this[0] = i, this.length = 1), this
        }
        return e.nodeType ? (this[0] = e, this.length = 1, this) : h(e) ? void 0 !== n.ready ? n.ready(e) : e(w) : w.makeArray(e, this)
    }).prototype = w.fn, D = w(v);
    var L = /^(?:parents|prev(?:Until|All))/, H = {children: !0, contents: !0, next: !0, prev: !0};

    function O(e, t) {
        for (; (e = e[t]) && 1 !== e.nodeType;) ;
        return e
    }

    w.fn.extend({
        has: function (e) {
            var t = w(e, this), n = t.length;
            return this.filter((function () {
                for (var e = 0; e < n; e++) if (w.contains(this, t[e])) return !0
            }))
        }, closest: function (e, t) {
            var n, r = 0, i = this.length, o = [], a = "string" != typeof e && w(e);
            if (!k.test(e)) for (; r < i; r++) for (n = this[r]; n && n !== t; n = n.parentNode) if (n.nodeType < 11 && (a ? -1 < a.index(n) : 1 === n.nodeType && w.find.matchesSelector(n, e))) {
                o.push(n);
                break
            }
            return this.pushStack(1 < o.length ? w.uniqueSort(o) : o)
        }, index: function (e) {
            return e ? "string" == typeof e ? s.call(w(e), this[0]) : s.call(this, e.jquery ? e[0] : e) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
        }, add: function (e, t) {
            return this.pushStack(w.uniqueSort(w.merge(this.get(), w(e, t))))
        }, addBack: function (e) {
            return this.add(null == e ? this.prevObject : this.prevObject.filter(e))
        }
    }), w.each({
        parent: function (e) {
            var t = e.parentNode;
            return t && 11 !== t.nodeType ? t : null
        }, parents: function (e) {
            return E(e, "parentNode")
        }, parentsUntil: function (e, t, n) {
            return E(e, "parentNode", n)
        }, next: function (e) {
            return O(e, "nextSibling")
        }, prev: function (e) {
            return O(e, "previousSibling")
        }, nextAll: function (e) {
            return E(e, "nextSibling")
        }, prevAll: function (e) {
            return E(e, "previousSibling")
        }, nextUntil: function (e, t, n) {
            return E(e, "nextSibling", n)
        }, prevUntil: function (e, t, n) {
            return E(e, "previousSibling", n)
        }, siblings: function (e) {
            return S((e.parentNode || {}).firstChild, e)
        }, children: function (e) {
            return S(e.firstChild)
        }, contents: function (e) {
            return null != e.contentDocument && r(e.contentDocument) ? e.contentDocument : (A(e, "template") && (e = e.content || e), w.merge([], e.childNodes))
        }
    }, (function (e, t) {
        w.fn[e] = function (n, r) {
            var i = w.map(this, t, n);
            return "Until" !== e.slice(-5) && (r = n), r && "string" == typeof r && (i = w.filter(r, i)), 1 < this.length && (H[e] || w.uniqueSort(i), L.test(e) && i.reverse()), this.pushStack(i)
        }
    }));
    var P = /[^\x20\t\r\n\f]+/g;

    function R(e) {
        return e
    }

    function M(e) {
        throw e
    }

    function I(e, t, n, r) {
        var i;
        try {
            e && h(i = e.promise) ? i.call(e).done(t).fail(n) : e && h(i = e.then) ? i.call(e, t, n) : t.apply(void 0, [e].slice(r))
        } catch (e) {
            n.apply(void 0, [e])
        }
    }

    w.Callbacks = function (e) {
        var t, n;
        e = "string" == typeof e ? (t = e, n = {}, w.each(t.match(P) || [], (function (e, t) {
            n[t] = !0
        })), n) : w.extend({}, e);
        var r, i, o, a, s = [], u = [], l = -1, c = function () {
            for (a = a || e.once, o = r = !0; u.length; l = -1) for (i = u.shift(); ++l < s.length;) !1 === s[l].apply(i[0], i[1]) && e.stopOnFalse && (l = s.length, i = !1);
            e.memory || (i = !1), r = !1, a && (s = i ? [] : "")
        }, f = {
            add: function () {
                return s && (i && !r && (l = s.length - 1, u.push(i)), function t(n) {
                    w.each(n, (function (n, r) {
                        h(r) ? e.unique && f.has(r) || s.push(r) : r && r.length && "string" !== x(r) && t(r)
                    }))
                }(arguments), i && !r && c()), this
            }, remove: function () {
                return w.each(arguments, (function (e, t) {
                    for (var n; -1 < (n = w.inArray(t, s, n));) s.splice(n, 1), n <= l && l--
                })), this
            }, has: function (e) {
                return e ? -1 < w.inArray(e, s) : 0 < s.length
            }, empty: function () {
                return s && (s = []), this
            }, disable: function () {
                return a = u = [], s = i = "", this
            }, disabled: function () {
                return !s
            }, lock: function () {
                return a = u = [], i || r || (s = i = ""), this
            }, locked: function () {
                return !!a
            }, fireWith: function (e, t) {
                return a || (t = [e, (t = t || []).slice ? t.slice() : t], u.push(t), r || c()), this
            }, fire: function () {
                return f.fireWith(this, arguments), this
            }, fired: function () {
                return !!o
            }
        };
        return f
    }, w.extend({
        Deferred: function (t) {
            var n = [["notify", "progress", w.Callbacks("memory"), w.Callbacks("memory"), 2], ["resolve", "done", w.Callbacks("once memory"), w.Callbacks("once memory"), 0, "resolved"], ["reject", "fail", w.Callbacks("once memory"), w.Callbacks("once memory"), 1, "rejected"]],
                r = "pending", i = {
                    state: function () {
                        return r
                    }, always: function () {
                        return o.done(arguments).fail(arguments), this
                    }, catch: function (e) {
                        return i.then(null, e)
                    }, pipe: function () {
                        var e = arguments;
                        return w.Deferred((function (t) {
                            w.each(n, (function (n, r) {
                                var i = h(e[r[4]]) && e[r[4]];
                                o[r[1]]((function () {
                                    var e = i && i.apply(this, arguments);
                                    e && h(e.promise) ? e.promise().progress(t.notify).done(t.resolve).fail(t.reject) : t[r[0] + "With"](this, i ? [e] : arguments)
                                }))
                            })), e = null
                        })).promise()
                    }, then: function (t, r, i) {
                        var o = 0;

                        function a(t, n, r, i) {
                            return function () {
                                var s = this, u = arguments, l = function () {
                                    var e, l;
                                    if (!(t < o)) {
                                        if ((e = r.apply(s, u)) === n.promise()) throw new TypeError("Thenable self-resolution");
                                        l = e && ("object" == typeof e || "function" == typeof e) && e.then, h(l) ? i ? l.call(e, a(o, n, R, i), a(o, n, M, i)) : (o++, l.call(e, a(o, n, R, i), a(o, n, M, i), a(o, n, R, n.notifyWith))) : (r !== R && (s = void 0, u = [e]), (i || n.resolveWith)(s, u))
                                    }
                                }, c = i ? l : function () {
                                    try {
                                        l()
                                    } catch (e) {
                                        w.Deferred.exceptionHook && w.Deferred.exceptionHook(e, c.stackTrace), o <= t + 1 && (r !== M && (s = void 0, u = [e]), n.rejectWith(s, u))
                                    }
                                };
                                t ? c() : (w.Deferred.getStackHook && (c.stackTrace = w.Deferred.getStackHook()), e.setTimeout(c))
                            }
                        }

                        return w.Deferred((function (e) {
                            n[0][3].add(a(0, e, h(i) ? i : R, e.notifyWith)), n[1][3].add(a(0, e, h(t) ? t : R)), n[2][3].add(a(0, e, h(r) ? r : M))
                        })).promise()
                    }, promise: function (e) {
                        return null != e ? w.extend(e, i) : i
                    }
                }, o = {};
            return w.each(n, (function (e, t) {
                var a = t[2], s = t[5];
                i[t[1]] = a.add, s && a.add((function () {
                    r = s
                }), n[3 - e][2].disable, n[3 - e][3].disable, n[0][2].lock, n[0][3].lock), a.add(t[3].fire), o[t[0]] = function () {
                    return o[t[0] + "With"](this === o ? void 0 : this, arguments), this
                }, o[t[0] + "With"] = a.fireWith
            })), i.promise(o), t && t.call(o, o), o
        }, when: function (e) {
            var t = arguments.length, n = t, r = Array(n), o = i.call(arguments), a = w.Deferred(), s = function (e) {
                return function (n) {
                    r[e] = this, o[e] = 1 < arguments.length ? i.call(arguments) : n, --t || a.resolveWith(r, o)
                }
            };
            if (t <= 1 && (I(e, a.done(s(n)).resolve, a.reject, !t), "pending" === a.state() || h(o[n] && o[n].then))) return a.then();
            for (; n--;) I(o[n], s(n), a.reject);
            return a.promise()
        }
    });
    var W = /^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;
    w.Deferred.exceptionHook = function (t, n) {
        e.console && e.console.warn && t && W.test(t.name) && e.console.warn("jQuery.Deferred exception: " + t.message, t.stack, n)
    }, w.readyException = function (t) {
        e.setTimeout((function () {
            throw t
        }))
    };
    var F = w.Deferred();

    function B() {
        v.removeEventListener("DOMContentLoaded", B), e.removeEventListener("load", B), w.ready()
    }

    w.fn.ready = function (e) {
        return F.then(e).catch((function (e) {
            w.readyException(e)
        })), this
    }, w.extend({
        isReady: !1, readyWait: 1, ready: function (e) {
            (!0 === e ? --w.readyWait : w.isReady) || (w.isReady = !0) !== e && 0 < --w.readyWait || F.resolveWith(v, [w])
        }
    }), w.ready.then = F.then, "complete" === v.readyState || "loading" !== v.readyState && !v.documentElement.doScroll ? e.setTimeout(w.ready) : (v.addEventListener("DOMContentLoaded", B), e.addEventListener("load", B));
    var $ = function (e, t, n, r, i, o, a) {
        var s = 0, u = e.length, l = null == n;
        if ("object" === x(n)) for (s in i = !0, n) $(e, t, s, n[s], !0, o, a); else if (void 0 !== r && (i = !0, h(r) || (a = !0), l && (a ? (t.call(e, r), t = null) : (l = t, t = function (e, t, n) {
            return l.call(w(e), n)
        })), t)) for (; s < u; s++) t(e[s], n, a ? r : r.call(e[s], s, t(e[s], n)));
        return i ? e : l ? t.call(e) : u ? t(e[0], n) : o
    }, _ = /^-ms-/, z = /-([a-z])/g;

    function U(e, t) {
        return t.toUpperCase()
    }

    function X(e) {
        return e.replace(_, "ms-").replace(z, U)
    }

    var V = function (e) {
        return 1 === e.nodeType || 9 === e.nodeType || !+e.nodeType
    };

    function G() {
        this.expando = w.expando + G.uid++
    }

    G.uid = 1, G.prototype = {
        cache: function (e) {
            var t = e[this.expando];
            return t || (t = {}, V(e) && (e.nodeType ? e[this.expando] = t : Object.defineProperty(e, this.expando, {
                value: t,
                configurable: !0
            }))), t
        }, set: function (e, t, n) {
            var r, i = this.cache(e);
            if ("string" == typeof t) i[X(t)] = n; else for (r in t) i[X(r)] = t[r];
            return i
        }, get: function (e, t) {
            return void 0 === t ? this.cache(e) : e[this.expando] && e[this.expando][X(t)]
        }, access: function (e, t, n) {
            return void 0 === t || t && "string" == typeof t && void 0 === n ? this.get(e, t) : (this.set(e, t, n), void 0 !== n ? n : t)
        }, remove: function (e, t) {
            var n, r = e[this.expando];
            if (void 0 !== r) {
                if (void 0 !== t) {
                    n = (t = Array.isArray(t) ? t.map(X) : (t = X(t)) in r ? [t] : t.match(P) || []).length;
                    for (; n--;) delete r[t[n]]
                }
                (void 0 === t || w.isEmptyObject(r)) && (e.nodeType ? e[this.expando] = void 0 : delete e[this.expando])
            }
        }, hasData: function (e) {
            var t = e[this.expando];
            return void 0 !== t && !w.isEmptyObject(t)
        }
    };
    var Y = new G, Q = new G, J = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/, K = /[A-Z]/g;

    function Z(e, t, n) {
        var r, i;
        if (void 0 === n && 1 === e.nodeType) if (r = "data-" + t.replace(K, "-$&").toLowerCase(), "string" == typeof (n = e.getAttribute(r))) {
            try {
                n = "true" === (i = n) || "false" !== i && ("null" === i ? null : i === +i + "" ? +i : J.test(i) ? JSON.parse(i) : i)
            } catch (e) {
            }
            Q.set(e, t, n)
        } else n = void 0;
        return n
    }

    w.extend({
        hasData: function (e) {
            return Q.hasData(e) || Y.hasData(e)
        }, data: function (e, t, n) {
            return Q.access(e, t, n)
        }, removeData: function (e, t) {
            Q.remove(e, t)
        }, _data: function (e, t, n) {
            return Y.access(e, t, n)
        }, _removeData: function (e, t) {
            Y.remove(e, t)
        }
    }), w.fn.extend({
        data: function (e, t) {
            var n, r, i, o = this[0], a = o && o.attributes;
            if (void 0 === e) {
                if (this.length && (i = Q.get(o), 1 === o.nodeType && !Y.get(o, "hasDataAttrs"))) {
                    for (n = a.length; n--;) a[n] && 0 === (r = a[n].name).indexOf("data-") && (r = X(r.slice(5)), Z(o, r, i[r]));
                    Y.set(o, "hasDataAttrs", !0)
                }
                return i
            }
            return "object" == typeof e ? this.each((function () {
                Q.set(this, e)
            })) : $(this, (function (t) {
                var n;
                if (o && void 0 === t) return void 0 !== (n = Q.get(o, e)) || void 0 !== (n = Z(o, e)) ? n : void 0;
                this.each((function () {
                    Q.set(this, e, t)
                }))
            }), null, t, 1 < arguments.length, null, !0)
        }, removeData: function (e) {
            return this.each((function () {
                Q.remove(this, e)
            }))
        }
    }), w.extend({
        queue: function (e, t, n) {
            var r;
            if (e) return t = (t || "fx") + "queue", r = Y.get(e, t), n && (!r || Array.isArray(n) ? r = Y.access(e, t, w.makeArray(n)) : r.push(n)), r || []
        }, dequeue: function (e, t) {
            t = t || "fx";
            var n = w.queue(e, t), r = n.length, i = n.shift(), o = w._queueHooks(e, t);
            "inprogress" === i && (i = n.shift(), r--), i && ("fx" === t && n.unshift("inprogress"), delete o.stop, i.call(e, (function () {
                w.dequeue(e, t)
            }), o)), !r && o && o.empty.fire()
        }, _queueHooks: function (e, t) {
            var n = t + "queueHooks";
            return Y.get(e, n) || Y.access(e, n, {
                empty: w.Callbacks("once memory").add((function () {
                    Y.remove(e, [t + "queue", n])
                }))
            })
        }
    }), w.fn.extend({
        queue: function (e, t) {
            var n = 2;
            return "string" != typeof e && (t = e, e = "fx", n--), arguments.length < n ? w.queue(this[0], e) : void 0 === t ? this : this.each((function () {
                var n = w.queue(this, e, t);
                w._queueHooks(this, e), "fx" === e && "inprogress" !== n[0] && w.dequeue(this, e)
            }))
        }, dequeue: function (e) {
            return this.each((function () {
                w.dequeue(this, e)
            }))
        }, clearQueue: function (e) {
            return this.queue(e || "fx", [])
        }, promise: function (e, t) {
            var n, r = 1, i = w.Deferred(), o = this, a = this.length, s = function () {
                --r || i.resolveWith(o, [o])
            };
            for ("string" != typeof e && (t = e, e = void 0), e = e || "fx"; a--;) (n = Y.get(o[a], e + "queueHooks")) && n.empty && (r++, n.empty.add(s));
            return s(), i.promise(t)
        }
    });
    var ee = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source, te = new RegExp("^(?:([+-])=|)(" + ee + ")([a-z%]*)$", "i"),
        ne = ["Top", "Right", "Bottom", "Left"], re = v.documentElement, ie = function (e) {
            return w.contains(e.ownerDocument, e)
        }, oe = {composed: !0};
    re.getRootNode && (ie = function (e) {
        return w.contains(e.ownerDocument, e) || e.getRootNode(oe) === e.ownerDocument
    });
    var ae = function (e, t) {
        return "none" === (e = t || e).style.display || "" === e.style.display && ie(e) && "none" === w.css(e, "display")
    };

    function se(e, t, n, r) {
        var i, o, a = 20, s = r ? function () {
                return r.cur()
            } : function () {
                return w.css(e, t, "")
            }, u = s(), l = n && n[3] || (w.cssNumber[t] ? "" : "px"),
            c = e.nodeType && (w.cssNumber[t] || "px" !== l && +u) && te.exec(w.css(e, t));
        if (c && c[3] !== l) {
            for (u /= 2, l = l || c[3], c = +u || 1; a--;) w.style(e, t, c + l), (1 - o) * (1 - (o = s() / u || .5)) <= 0 && (a = 0), c /= o;
            c *= 2, w.style(e, t, c + l), n = n || []
        }
        return n && (c = +c || +u || 0, i = n[1] ? c + (n[1] + 1) * n[2] : +n[2], r && (r.unit = l, r.start = c, r.end = i)), i
    }

    var ue = {};

    function le(e, t) {
        for (var n, r, i, o, a, s, u, l = [], c = 0, f = e.length; c < f; c++) (r = e[c]).style && (n = r.style.display, t ? ("none" === n && (l[c] = Y.get(r, "display") || null, l[c] || (r.style.display = "")), "" === r.style.display && ae(r) && (l[c] = (u = a = o = void 0, a = (i = r).ownerDocument, s = i.nodeName, (u = ue[s]) || (o = a.body.appendChild(a.createElement(s)), u = w.css(o, "display"), o.parentNode.removeChild(o), "none" === u && (u = "block"), ue[s] = u)))) : "none" !== n && (l[c] = "none", Y.set(r, "display", n)));
        for (c = 0; c < f; c++) null != l[c] && (e[c].style.display = l[c]);
        return e
    }

    w.fn.extend({
        show: function () {
            return le(this, !0)
        }, hide: function () {
            return le(this)
        }, toggle: function (e) {
            return "boolean" == typeof e ? e ? this.show() : this.hide() : this.each((function () {
                ae(this) ? w(this).show() : w(this).hide()
            }))
        }
    });
    var ce, fe, pe = /^(?:checkbox|radio)$/i, de = /<([a-z][^\/\0>\x20\t\r\n\f]*)/i,
        he = /^$|^module$|\/(?:java|ecma)script/i;
    ce = v.createDocumentFragment().appendChild(v.createElement("div")), (fe = v.createElement("input")).setAttribute("type", "radio"), fe.setAttribute("checked", "checked"), fe.setAttribute("name", "t"), ce.appendChild(fe), d.checkClone = ce.cloneNode(!0).cloneNode(!0).lastChild.checked, ce.innerHTML = "<textarea>x</textarea>", d.noCloneChecked = !!ce.cloneNode(!0).lastChild.defaultValue, ce.innerHTML = "<option></option>", d.option = !!ce.lastChild;
    var ge = {
        thead: [1, "<table>", "</table>"],
        col: [2, "<table><colgroup>", "</colgroup></table>"],
        tr: [2, "<table><tbody>", "</tbody></table>"],
        td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
        _default: [0, "", ""]
    };

    function ve(e, t) {
        var n;
        return n = void 0 !== e.getElementsByTagName ? e.getElementsByTagName(t || "*") : void 0 !== e.querySelectorAll ? e.querySelectorAll(t || "*") : [], void 0 === t || t && A(e, t) ? w.merge([e], n) : n
    }

    function ye(e, t) {
        for (var n = 0, r = e.length; n < r; n++) Y.set(e[n], "globalEval", !t || Y.get(t[n], "globalEval"))
    }

    ge.tbody = ge.tfoot = ge.colgroup = ge.caption = ge.thead, ge.th = ge.td, d.option || (ge.optgroup = ge.option = [1, "<select multiple='multiple'>", "</select>"]);
    var me = /<|&#?\w+;/;

    function xe(e, t, n, r, i) {
        for (var o, a, s, u, l, c, f = t.createDocumentFragment(), p = [], d = 0, h = e.length; d < h; d++) if ((o = e[d]) || 0 === o) if ("object" === x(o)) w.merge(p, o.nodeType ? [o] : o); else if (me.test(o)) {
            for (a = a || f.appendChild(t.createElement("div")), s = (de.exec(o) || ["", ""])[1].toLowerCase(), u = ge[s] || ge._default, a.innerHTML = u[1] + w.htmlPrefilter(o) + u[2], c = u[0]; c--;) a = a.lastChild;
            w.merge(p, a.childNodes), (a = f.firstChild).textContent = ""
        } else p.push(t.createTextNode(o));
        for (f.textContent = "", d = 0; o = p[d++];) if (r && -1 < w.inArray(o, r)) i && i.push(o); else if (l = ie(o), a = ve(f.appendChild(o), "script"), l && ye(a), n) for (c = 0; o = a[c++];) he.test(o.type || "") && n.push(o);
        return f
    }

    var be = /^([^.]*)(?:\.(.+)|)/;

    function we() {
        return !0
    }

    function Te() {
        return !1
    }

    function Ce(e, t) {
        return e === function () {
            try {
                return v.activeElement
            } catch (e) {
            }
        }() == ("focus" === t)
    }

    function Ee(e, t, n, r, i, o) {
        var a, s;
        if ("object" == typeof t) {
            for (s in "string" != typeof n && (r = r || n, n = void 0), t) Ee(e, s, n, r, t[s], o);
            return e
        }
        if (null == r && null == i ? (i = n, r = n = void 0) : null == i && ("string" == typeof n ? (i = r, r = void 0) : (i = r, r = n, n = void 0)), !1 === i) i = Te; else if (!i) return e;
        return 1 === o && (a = i, (i = function (e) {
            return w().off(e), a.apply(this, arguments)
        }).guid = a.guid || (a.guid = w.guid++)), e.each((function () {
            w.event.add(this, t, i, r, n)
        }))
    }

    function Se(e, t, n) {
        n ? (Y.set(e, t, !1), w.event.add(e, t, {
            namespace: !1, handler: function (e) {
                var r, o, a = Y.get(this, t);
                if (1 & e.isTrigger && this[t]) {
                    if (a.length) (w.event.special[t] || {}).delegateType && e.stopPropagation(); else if (a = i.call(arguments), Y.set(this, t, a), r = n(this, t), this[t](), a !== (o = Y.get(this, t)) || r ? Y.set(this, t, !1) : o = {}, a !== o) return e.stopImmediatePropagation(), e.preventDefault(), o && o.value
                } else a.length && (Y.set(this, t, {value: w.event.trigger(w.extend(a[0], w.Event.prototype), a.slice(1), this)}), e.stopImmediatePropagation())
            }
        })) : void 0 === Y.get(e, t) && w.event.add(e, t, we)
    }

    w.event = {
        global: {}, add: function (e, t, n, r, i) {
            var o, a, s, u, l, c, f, p, d, h, g, v = Y.get(e);
            if (V(e)) for (n.handler && (n = (o = n).handler, i = o.selector), i && w.find.matchesSelector(re, i), n.guid || (n.guid = w.guid++), (u = v.events) || (u = v.events = Object.create(null)), (a = v.handle) || (a = v.handle = function (t) {
                return void 0 !== w && w.event.triggered !== t.type ? w.event.dispatch.apply(e, arguments) : void 0
            }), l = (t = (t || "").match(P) || [""]).length; l--;) d = g = (s = be.exec(t[l]) || [])[1], h = (s[2] || "").split(".").sort(), d && (f = w.event.special[d] || {}, d = (i ? f.delegateType : f.bindType) || d, f = w.event.special[d] || {}, c = w.extend({
                type: d,
                origType: g,
                data: r,
                handler: n,
                guid: n.guid,
                selector: i,
                needsContext: i && w.expr.match.needsContext.test(i),
                namespace: h.join(".")
            }, o), (p = u[d]) || ((p = u[d] = []).delegateCount = 0, f.setup && !1 !== f.setup.call(e, r, h, a) || e.addEventListener && e.addEventListener(d, a)), f.add && (f.add.call(e, c), c.handler.guid || (c.handler.guid = n.guid)), i ? p.splice(p.delegateCount++, 0, c) : p.push(c), w.event.global[d] = !0)
        }, remove: function (e, t, n, r, i) {
            var o, a, s, u, l, c, f, p, d, h, g, v = Y.hasData(e) && Y.get(e);
            if (v && (u = v.events)) {
                for (l = (t = (t || "").match(P) || [""]).length; l--;) if (d = g = (s = be.exec(t[l]) || [])[1], h = (s[2] || "").split(".").sort(), d) {
                    for (f = w.event.special[d] || {}, p = u[d = (r ? f.delegateType : f.bindType) || d] || [], s = s[2] && new RegExp("(^|\\.)" + h.join("\\.(?:.*\\.|)") + "(\\.|$)"), a = o = p.length; o--;) c = p[o], !i && g !== c.origType || n && n.guid !== c.guid || s && !s.test(c.namespace) || r && r !== c.selector && ("**" !== r || !c.selector) || (p.splice(o, 1), c.selector && p.delegateCount--, f.remove && f.remove.call(e, c));
                    a && !p.length && (f.teardown && !1 !== f.teardown.call(e, h, v.handle) || w.removeEvent(e, d, v.handle), delete u[d])
                } else for (d in u) w.event.remove(e, d + t[l], n, r, !0);
                w.isEmptyObject(u) && Y.remove(e, "handle events")
            }
        }, dispatch: function (e) {
            var t, n, r, i, o, a, s = new Array(arguments.length), u = w.event.fix(e),
                l = (Y.get(this, "events") || Object.create(null))[u.type] || [], c = w.event.special[u.type] || {};
            for (s[0] = u, t = 1; t < arguments.length; t++) s[t] = arguments[t];
            if (u.delegateTarget = this, !c.preDispatch || !1 !== c.preDispatch.call(this, u)) {
                for (a = w.event.handlers.call(this, u, l), t = 0; (i = a[t++]) && !u.isPropagationStopped();) for (u.currentTarget = i.elem, n = 0; (o = i.handlers[n++]) && !u.isImmediatePropagationStopped();) u.rnamespace && !1 !== o.namespace && !u.rnamespace.test(o.namespace) || (u.handleObj = o, u.data = o.data, void 0 !== (r = ((w.event.special[o.origType] || {}).handle || o.handler).apply(i.elem, s)) && !1 === (u.result = r) && (u.preventDefault(), u.stopPropagation()));
                return c.postDispatch && c.postDispatch.call(this, u), u.result
            }
        }, handlers: function (e, t) {
            var n, r, i, o, a, s = [], u = t.delegateCount, l = e.target;
            if (u && l.nodeType && !("click" === e.type && 1 <= e.button)) for (; l !== this; l = l.parentNode || this) if (1 === l.nodeType && ("click" !== e.type || !0 !== l.disabled)) {
                for (o = [], a = {}, n = 0; n < u; n++) void 0 === a[i = (r = t[n]).selector + " "] && (a[i] = r.needsContext ? -1 < w(i, this).index(l) : w.find(i, this, null, [l]).length), a[i] && o.push(r);
                o.length && s.push({elem: l, handlers: o})
            }
            return l = this, u < t.length && s.push({elem: l, handlers: t.slice(u)}), s
        }, addProp: function (e, t) {
            Object.defineProperty(w.Event.prototype, e, {
                enumerable: !0, configurable: !0, get: h(t) ? function () {
                    if (this.originalEvent) return t(this.originalEvent)
                } : function () {
                    if (this.originalEvent) return this.originalEvent[e]
                }, set: function (t) {
                    Object.defineProperty(this, e, {enumerable: !0, configurable: !0, writable: !0, value: t})
                }
            })
        }, fix: function (e) {
            return e[w.expando] ? e : new w.Event(e)
        }, special: {
            load: {noBubble: !0}, click: {
                setup: function (e) {
                    var t = this || e;
                    return pe.test(t.type) && t.click && A(t, "input") && Se(t, "click", we), !1
                }, trigger: function (e) {
                    var t = this || e;
                    return pe.test(t.type) && t.click && A(t, "input") && Se(t, "click"), !0
                }, _default: function (e) {
                    var t = e.target;
                    return pe.test(t.type) && t.click && A(t, "input") && Y.get(t, "click") || A(t, "a")
                }
            }, beforeunload: {
                postDispatch: function (e) {
                    void 0 !== e.result && e.originalEvent && (e.originalEvent.returnValue = e.result)
                }
            }
        }
    }, w.removeEvent = function (e, t, n) {
        e.removeEventListener && e.removeEventListener(t, n)
    }, w.Event = function (e, t) {
        if (!(this instanceof w.Event)) return new w.Event(e, t);
        e && e.type ? (this.originalEvent = e, this.type = e.type, this.isDefaultPrevented = e.defaultPrevented || void 0 === e.defaultPrevented && !1 === e.returnValue ? we : Te, this.target = e.target && 3 === e.target.nodeType ? e.target.parentNode : e.target, this.currentTarget = e.currentTarget, this.relatedTarget = e.relatedTarget) : this.type = e, t && w.extend(this, t), this.timeStamp = e && e.timeStamp || Date.now(), this[w.expando] = !0
    }, w.Event.prototype = {
        constructor: w.Event,
        isDefaultPrevented: Te,
        isPropagationStopped: Te,
        isImmediatePropagationStopped: Te,
        isSimulated: !1,
        preventDefault: function () {
            var e = this.originalEvent;
            this.isDefaultPrevented = we, e && !this.isSimulated && e.preventDefault()
        },
        stopPropagation: function () {
            var e = this.originalEvent;
            this.isPropagationStopped = we, e && !this.isSimulated && e.stopPropagation()
        },
        stopImmediatePropagation: function () {
            var e = this.originalEvent;
            this.isImmediatePropagationStopped = we, e && !this.isSimulated && e.stopImmediatePropagation(), this.stopPropagation()
        }
    }, w.each({
        altKey: !0,
        bubbles: !0,
        cancelable: !0,
        changedTouches: !0,
        ctrlKey: !0,
        detail: !0,
        eventPhase: !0,
        metaKey: !0,
        pageX: !0,
        pageY: !0,
        shiftKey: !0,
        view: !0,
        char: !0,
        code: !0,
        charCode: !0,
        key: !0,
        keyCode: !0,
        button: !0,
        buttons: !0,
        clientX: !0,
        clientY: !0,
        offsetX: !0,
        offsetY: !0,
        pointerId: !0,
        pointerType: !0,
        screenX: !0,
        screenY: !0,
        targetTouches: !0,
        toElement: !0,
        touches: !0,
        which: !0
    }, w.event.addProp), w.each({focus: "focusin", blur: "focusout"}, (function (e, t) {
        w.event.special[e] = {
            setup: function () {
                return Se(this, e, Ce), !1
            }, trigger: function () {
                return Se(this, e), !0
            }, _default: function () {
                return !0
            }, delegateType: t
        }
    })), w.each({
        mouseenter: "mouseover",
        mouseleave: "mouseout",
        pointerenter: "pointerover",
        pointerleave: "pointerout"
    }, (function (e, t) {
        w.event.special[e] = {
            delegateType: t, bindType: t, handle: function (e) {
                var n, r = e.relatedTarget, i = e.handleObj;
                return r && (r === this || w.contains(this, r)) || (e.type = i.origType, n = i.handler.apply(this, arguments), e.type = t), n
            }
        }
    })), w.fn.extend({
        on: function (e, t, n, r) {
            return Ee(this, e, t, n, r)
        }, one: function (e, t, n, r) {
            return Ee(this, e, t, n, r, 1)
        }, off: function (e, t, n) {
            var r, i;
            if (e && e.preventDefault && e.handleObj) return r = e.handleObj, w(e.delegateTarget).off(r.namespace ? r.origType + "." + r.namespace : r.origType, r.selector, r.handler), this;
            if ("object" == typeof e) {
                for (i in e) this.off(i, t, e[i]);
                return this
            }
            return !1 !== t && "function" != typeof t || (n = t, t = void 0), !1 === n && (n = Te), this.each((function () {
                w.event.remove(this, e, n, t)
            }))
        }
    });
    var ke = /<script|<style|<link/i, Ae = /checked\s*(?:[^=]|=\s*.checked.)/i,
        Ne = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;

    function je(e, t) {
        return A(e, "table") && A(11 !== t.nodeType ? t : t.firstChild, "tr") && w(e).children("tbody")[0] || e
    }

    function De(e) {
        return e.type = (null !== e.getAttribute("type")) + "/" + e.type, e
    }

    function qe(e) {
        return "true/" === (e.type || "").slice(0, 5) ? e.type = e.type.slice(5) : e.removeAttribute("type"), e
    }

    function Le(e, t) {
        var n, r, i, o, a, s;
        if (1 === t.nodeType) {
            if (Y.hasData(e) && (s = Y.get(e).events)) for (i in Y.remove(t, "handle events"), s) for (n = 0, r = s[i].length; n < r; n++) w.event.add(t, i, s[i][n]);
            Q.hasData(e) && (o = Q.access(e), a = w.extend({}, o), Q.set(t, a))
        }
    }

    function He(e, t, n, r) {
        t = o(t);
        var i, a, s, u, l, c, f = 0, p = e.length, g = p - 1, v = t[0], y = h(v);
        if (y || 1 < p && "string" == typeof v && !d.checkClone && Ae.test(v)) return e.each((function (i) {
            var o = e.eq(i);
            y && (t[0] = v.call(this, i, o.html())), He(o, t, n, r)
        }));
        if (p && (a = (i = xe(t, e[0].ownerDocument, !1, e, r)).firstChild, 1 === i.childNodes.length && (i = a), a || r)) {
            for (u = (s = w.map(ve(i, "script"), De)).length; f < p; f++) l = i, f !== g && (l = w.clone(l, !0, !0), u && w.merge(s, ve(l, "script"))), n.call(e[f], l, f);
            if (u) for (c = s[s.length - 1].ownerDocument, w.map(s, qe), f = 0; f < u; f++) l = s[f], he.test(l.type || "") && !Y.access(l, "globalEval") && w.contains(c, l) && (l.src && "module" !== (l.type || "").toLowerCase() ? w._evalUrl && !l.noModule && w._evalUrl(l.src, {nonce: l.nonce || l.getAttribute("nonce")}, c) : m(l.textContent.replace(Ne, ""), l, c))
        }
        return e
    }

    function Oe(e, t, n) {
        for (var r, i = t ? w.filter(t, e) : e, o = 0; null != (r = i[o]); o++) n || 1 !== r.nodeType || w.cleanData(ve(r)), r.parentNode && (n && ie(r) && ye(ve(r, "script")), r.parentNode.removeChild(r));
        return e
    }

    w.extend({
        htmlPrefilter: function (e) {
            return e
        }, clone: function (e, t, n) {
            var r, i, o, a, s, u, l, c = e.cloneNode(!0), f = ie(e);
            if (!(d.noCloneChecked || 1 !== e.nodeType && 11 !== e.nodeType || w.isXMLDoc(e))) for (a = ve(c), r = 0, i = (o = ve(e)).length; r < i; r++) s = o[r], "input" === (l = (u = a[r]).nodeName.toLowerCase()) && pe.test(s.type) ? u.checked = s.checked : "input" !== l && "textarea" !== l || (u.defaultValue = s.defaultValue);
            if (t) if (n) for (o = o || ve(e), a = a || ve(c), r = 0, i = o.length; r < i; r++) Le(o[r], a[r]); else Le(e, c);
            return 0 < (a = ve(c, "script")).length && ye(a, !f && ve(e, "script")), c
        }, cleanData: function (e) {
            for (var t, n, r, i = w.event.special, o = 0; void 0 !== (n = e[o]); o++) if (V(n)) {
                if (t = n[Y.expando]) {
                    if (t.events) for (r in t.events) i[r] ? w.event.remove(n, r) : w.removeEvent(n, r, t.handle);
                    n[Y.expando] = void 0
                }
                n[Q.expando] && (n[Q.expando] = void 0)
            }
        }
    }), w.fn.extend({
        detach: function (e) {
            return Oe(this, e, !0)
        }, remove: function (e) {
            return Oe(this, e)
        }, text: function (e) {
            return $(this, (function (e) {
                return void 0 === e ? w.text(this) : this.empty().each((function () {
                    1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || (this.textContent = e)
                }))
            }), null, e, arguments.length)
        }, append: function () {
            return He(this, arguments, (function (e) {
                1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || je(this, e).appendChild(e)
            }))
        }, prepend: function () {
            return He(this, arguments, (function (e) {
                if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                    var t = je(this, e);
                    t.insertBefore(e, t.firstChild)
                }
            }))
        }, before: function () {
            return He(this, arguments, (function (e) {
                this.parentNode && this.parentNode.insertBefore(e, this)
            }))
        }, after: function () {
            return He(this, arguments, (function (e) {
                this.parentNode && this.parentNode.insertBefore(e, this.nextSibling)
            }))
        }, empty: function () {
            for (var e, t = 0; null != (e = this[t]); t++) 1 === e.nodeType && (w.cleanData(ve(e, !1)), e.textContent = "");
            return this
        }, clone: function (e, t) {
            return e = null != e && e, t = null == t ? e : t, this.map((function () {
                return w.clone(this, e, t)
            }))
        }, html: function (e) {
            return $(this, (function (e) {
                var t = this[0] || {}, n = 0, r = this.length;
                if (void 0 === e && 1 === t.nodeType) return t.innerHTML;
                if ("string" == typeof e && !ke.test(e) && !ge[(de.exec(e) || ["", ""])[1].toLowerCase()]) {
                    e = w.htmlPrefilter(e);
                    try {
                        for (; n < r; n++) 1 === (t = this[n] || {}).nodeType && (w.cleanData(ve(t, !1)), t.innerHTML = e);
                        t = 0
                    } catch (e) {
                    }
                }
                t && this.empty().append(e)
            }), null, e, arguments.length)
        }, replaceWith: function () {
            var e = [];
            return He(this, arguments, (function (t) {
                var n = this.parentNode;
                w.inArray(this, e) < 0 && (w.cleanData(ve(this)), n && n.replaceChild(t, this))
            }), e)
        }
    }), w.each({
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith"
    }, (function (e, t) {
        w.fn[e] = function (e) {
            for (var n, r = [], i = w(e), o = i.length - 1, s = 0; s <= o; s++) n = s === o ? this : this.clone(!0), w(i[s])[t](n), a.apply(r, n.get());
            return this.pushStack(r)
        }
    }));
    var Pe = new RegExp("^(" + ee + ")(?!px)[a-z%]+$", "i"), Re = function (t) {
        var n = t.ownerDocument.defaultView;
        return n && n.opener || (n = e), n.getComputedStyle(t)
    }, Me = function (e, t, n) {
        var r, i, o = {};
        for (i in t) o[i] = e.style[i], e.style[i] = t[i];
        for (i in r = n.call(e), t) e.style[i] = o[i];
        return r
    }, Ie = new RegExp(ne.join("|"), "i");

    function We(e, t, n) {
        var r, i, o, a, s = e.style;
        return (n = n || Re(e)) && ("" !== (a = n.getPropertyValue(t) || n[t]) || ie(e) || (a = w.style(e, t)), !d.pixelBoxStyles() && Pe.test(a) && Ie.test(t) && (r = s.width, i = s.minWidth, o = s.maxWidth, s.minWidth = s.maxWidth = s.width = a, a = n.width, s.width = r, s.minWidth = i, s.maxWidth = o)), void 0 !== a ? a + "" : a
    }

    function Fe(e, t) {
        return {
            get: function () {
                if (!e()) return (this.get = t).apply(this, arguments);
                delete this.get
            }
        }
    }

    !function () {
        function t() {
            if (c) {
                l.style.cssText = "position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0", c.style.cssText = "position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%", re.appendChild(l).appendChild(c);
                var t = e.getComputedStyle(c);
                r = "1%" !== t.top, u = 12 === n(t.marginLeft), c.style.right = "60%", a = 36 === n(t.right), i = 36 === n(t.width), c.style.position = "absolute", o = 12 === n(c.offsetWidth / 3), re.removeChild(l), c = null
            }
        }

        function n(e) {
            return Math.round(parseFloat(e))
        }

        var r, i, o, a, s, u, l = v.createElement("div"), c = v.createElement("div");
        c.style && (c.style.backgroundClip = "content-box", c.cloneNode(!0).style.backgroundClip = "", d.clearCloneStyle = "content-box" === c.style.backgroundClip, w.extend(d, {
            boxSizingReliable: function () {
                return t(), i
            }, pixelBoxStyles: function () {
                return t(), a
            }, pixelPosition: function () {
                return t(), r
            }, reliableMarginLeft: function () {
                return t(), u
            }, scrollboxSize: function () {
                return t(), o
            }, reliableTrDimensions: function () {
                var t, n, r, i;
                return null == s && (t = v.createElement("table"), n = v.createElement("tr"), r = v.createElement("div"), t.style.cssText = "position:absolute;left:-11111px;border-collapse:separate", n.style.cssText = "border:1px solid", n.style.height = "1px", r.style.height = "9px", r.style.display = "block", re.appendChild(t).appendChild(n).appendChild(r), i = e.getComputedStyle(n), s = parseInt(i.height, 10) + parseInt(i.borderTopWidth, 10) + parseInt(i.borderBottomWidth, 10) === n.offsetHeight, re.removeChild(t)), s
            }
        }))
    }();
    var Be = ["Webkit", "Moz", "ms"], $e = v.createElement("div").style, _e = {};

    function ze(e) {
        return w.cssProps[e] || _e[e] || (e in $e ? e : _e[e] = function (e) {
            for (var t = e[0].toUpperCase() + e.slice(1), n = Be.length; n--;) if ((e = Be[n] + t) in $e) return e
        }(e) || e)
    }

    var Ue = /^(none|table(?!-c[ea]).+)/, Xe = /^--/,
        Ve = {position: "absolute", visibility: "hidden", display: "block"},
        Ge = {letterSpacing: "0", fontWeight: "400"};

    function Ye(e, t, n) {
        var r = te.exec(t);
        return r ? Math.max(0, r[2] - (n || 0)) + (r[3] || "px") : t
    }

    function Qe(e, t, n, r, i, o) {
        var a = "width" === t ? 1 : 0, s = 0, u = 0;
        if (n === (r ? "border" : "content")) return 0;
        for (; a < 4; a += 2) "margin" === n && (u += w.css(e, n + ne[a], !0, i)), r ? ("content" === n && (u -= w.css(e, "padding" + ne[a], !0, i)), "margin" !== n && (u -= w.css(e, "border" + ne[a] + "Width", !0, i))) : (u += w.css(e, "padding" + ne[a], !0, i), "padding" !== n ? u += w.css(e, "border" + ne[a] + "Width", !0, i) : s += w.css(e, "border" + ne[a] + "Width", !0, i));
        return !r && 0 <= o && (u += Math.max(0, Math.ceil(e["offset" + t[0].toUpperCase() + t.slice(1)] - o - u - s - .5)) || 0), u
    }

    function Je(e, t, n) {
        var r = Re(e), i = (!d.boxSizingReliable() || n) && "border-box" === w.css(e, "boxSizing", !1, r), o = i,
            a = We(e, t, r), s = "offset" + t[0].toUpperCase() + t.slice(1);
        if (Pe.test(a)) {
            if (!n) return a;
            a = "auto"
        }
        return (!d.boxSizingReliable() && i || !d.reliableTrDimensions() && A(e, "tr") || "auto" === a || !parseFloat(a) && "inline" === w.css(e, "display", !1, r)) && e.getClientRects().length && (i = "border-box" === w.css(e, "boxSizing", !1, r), (o = s in e) && (a = e[s])), (a = parseFloat(a) || 0) + Qe(e, t, n || (i ? "border" : "content"), o, r, a) + "px"
    }

    function Ke(e, t, n, r, i) {
        return new Ke.prototype.init(e, t, n, r, i)
    }

    w.extend({
        cssHooks: {
            opacity: {
                get: function (e, t) {
                    if (t) {
                        var n = We(e, "opacity");
                        return "" === n ? "1" : n
                    }
                }
            }
        },
        cssNumber: {
            animationIterationCount: !0,
            columnCount: !0,
            fillOpacity: !0,
            flexGrow: !0,
            flexShrink: !0,
            fontWeight: !0,
            gridArea: !0,
            gridColumn: !0,
            gridColumnEnd: !0,
            gridColumnStart: !0,
            gridRow: !0,
            gridRowEnd: !0,
            gridRowStart: !0,
            lineHeight: !0,
            opacity: !0,
            order: !0,
            orphans: !0,
            widows: !0,
            zIndex: !0,
            zoom: !0
        },
        cssProps: {},
        style: function (e, t, n, r) {
            if (e && 3 !== e.nodeType && 8 !== e.nodeType && e.style) {
                var i, o, a, s = X(t), u = Xe.test(t), l = e.style;
                if (u || (t = ze(s)), a = w.cssHooks[t] || w.cssHooks[s], void 0 === n) return a && "get" in a && void 0 !== (i = a.get(e, !1, r)) ? i : l[t];
                "string" == (o = typeof n) && (i = te.exec(n)) && i[1] && (n = se(e, t, i), o = "number"), null != n && n == n && ("number" !== o || u || (n += i && i[3] || (w.cssNumber[s] ? "" : "px")), d.clearCloneStyle || "" !== n || 0 !== t.indexOf("background") || (l[t] = "inherit"), a && "set" in a && void 0 === (n = a.set(e, n, r)) || (u ? l.setProperty(t, n) : l[t] = n))
            }
        },
        css: function (e, t, n, r) {
            var i, o, a, s = X(t);
            return Xe.test(t) || (t = ze(s)), (a = w.cssHooks[t] || w.cssHooks[s]) && "get" in a && (i = a.get(e, !0, n)), void 0 === i && (i = We(e, t, r)), "normal" === i && t in Ge && (i = Ge[t]), "" === n || n ? (o = parseFloat(i), !0 === n || isFinite(o) ? o || 0 : i) : i
        }
    }), w.each(["height", "width"], (function (e, t) {
        w.cssHooks[t] = {
            get: function (e, n, r) {
                if (n) return !Ue.test(w.css(e, "display")) || e.getClientRects().length && e.getBoundingClientRect().width ? Je(e, t, r) : Me(e, Ve, (function () {
                    return Je(e, t, r)
                }))
            }, set: function (e, n, r) {
                var i, o = Re(e), a = !d.scrollboxSize() && "absolute" === o.position,
                    s = (a || r) && "border-box" === w.css(e, "boxSizing", !1, o), u = r ? Qe(e, t, r, s, o) : 0;
                return s && a && (u -= Math.ceil(e["offset" + t[0].toUpperCase() + t.slice(1)] - parseFloat(o[t]) - Qe(e, t, "border", !1, o) - .5)), u && (i = te.exec(n)) && "px" !== (i[3] || "px") && (e.style[t] = n, n = w.css(e, t)), Ye(0, n, u)
            }
        }
    })), w.cssHooks.marginLeft = Fe(d.reliableMarginLeft, (function (e, t) {
        if (t) return (parseFloat(We(e, "marginLeft")) || e.getBoundingClientRect().left - Me(e, {marginLeft: 0}, (function () {
            return e.getBoundingClientRect().left
        }))) + "px"
    })), w.each({margin: "", padding: "", border: "Width"}, (function (e, t) {
        w.cssHooks[e + t] = {
            expand: function (n) {
                for (var r = 0, i = {}, o = "string" == typeof n ? n.split(" ") : [n]; r < 4; r++) i[e + ne[r] + t] = o[r] || o[r - 2] || o[0];
                return i
            }
        }, "margin" !== e && (w.cssHooks[e + t].set = Ye)
    })), w.fn.extend({
        css: function (e, t) {
            return $(this, (function (e, t, n) {
                var r, i, o = {}, a = 0;
                if (Array.isArray(t)) {
                    for (r = Re(e), i = t.length; a < i; a++) o[t[a]] = w.css(e, t[a], !1, r);
                    return o
                }
                return void 0 !== n ? w.style(e, t, n) : w.css(e, t)
            }), e, t, 1 < arguments.length)
        }
    }), ((w.Tween = Ke).prototype = {
        constructor: Ke, init: function (e, t, n, r, i, o) {
            this.elem = e, this.prop = n, this.easing = i || w.easing._default, this.options = t, this.start = this.now = this.cur(), this.end = r, this.unit = o || (w.cssNumber[n] ? "" : "px")
        }, cur: function () {
            var e = Ke.propHooks[this.prop];
            return e && e.get ? e.get(this) : Ke.propHooks._default.get(this)
        }, run: function (e) {
            var t, n = Ke.propHooks[this.prop];
            return this.options.duration ? this.pos = t = w.easing[this.easing](e, this.options.duration * e, 0, 1, this.options.duration) : this.pos = t = e, this.now = (this.end - this.start) * t + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), n && n.set ? n.set(this) : Ke.propHooks._default.set(this), this
        }
    }).init.prototype = Ke.prototype, (Ke.propHooks = {
        _default: {
            get: function (e) {
                var t;
                return 1 !== e.elem.nodeType || null != e.elem[e.prop] && null == e.elem.style[e.prop] ? e.elem[e.prop] : (t = w.css(e.elem, e.prop, "")) && "auto" !== t ? t : 0
            }, set: function (e) {
                w.fx.step[e.prop] ? w.fx.step[e.prop](e) : 1 !== e.elem.nodeType || !w.cssHooks[e.prop] && null == e.elem.style[ze(e.prop)] ? e.elem[e.prop] = e.now : w.style(e.elem, e.prop, e.now + e.unit)
            }
        }
    }).scrollTop = Ke.propHooks.scrollLeft = {
        set: function (e) {
            e.elem.nodeType && e.elem.parentNode && (e.elem[e.prop] = e.now)
        }
    }, w.easing = {
        linear: function (e) {
            return e
        }, swing: function (e) {
            return .5 - Math.cos(e * Math.PI) / 2
        }, _default: "swing"
    }, w.fx = Ke.prototype.init, w.fx.step = {};
    var Ze, et, tt, nt, rt = /^(?:toggle|show|hide)$/, it = /queueHooks$/;

    function ot() {
        et && (!1 === v.hidden && e.requestAnimationFrame ? e.requestAnimationFrame(ot) : e.setTimeout(ot, w.fx.interval), w.fx.tick())
    }

    function at() {
        return e.setTimeout((function () {
            Ze = void 0
        })), Ze = Date.now()
    }

    function st(e, t) {
        var n, r = 0, i = {height: e};
        for (t = t ? 1 : 0; r < 4; r += 2 - t) i["margin" + (n = ne[r])] = i["padding" + n] = e;
        return t && (i.opacity = i.width = e), i
    }

    function ut(e, t, n) {
        for (var r, i = (lt.tweeners[t] || []).concat(lt.tweeners["*"]), o = 0, a = i.length; o < a; o++) if (r = i[o].call(n, t, e)) return r
    }

    function lt(e, t, n) {
        var r, i, o = 0, a = lt.prefilters.length, s = w.Deferred().always((function () {
            delete u.elem
        })), u = function () {
            if (i) return !1;
            for (var t = Ze || at(), n = Math.max(0, l.startTime + l.duration - t), r = 1 - (n / l.duration || 0), o = 0, a = l.tweens.length; o < a; o++) l.tweens[o].run(r);
            return s.notifyWith(e, [l, r, n]), r < 1 && a ? n : (a || s.notifyWith(e, [l, 1, 0]), s.resolveWith(e, [l]), !1)
        }, l = s.promise({
            elem: e,
            props: w.extend({}, t),
            opts: w.extend(!0, {specialEasing: {}, easing: w.easing._default}, n),
            originalProperties: t,
            originalOptions: n,
            startTime: Ze || at(),
            duration: n.duration,
            tweens: [],
            createTween: function (t, n) {
                var r = w.Tween(e, l.opts, t, n, l.opts.specialEasing[t] || l.opts.easing);
                return l.tweens.push(r), r
            },
            stop: function (t) {
                var n = 0, r = t ? l.tweens.length : 0;
                if (i) return this;
                for (i = !0; n < r; n++) l.tweens[n].run(1);
                return t ? (s.notifyWith(e, [l, 1, 0]), s.resolveWith(e, [l, t])) : s.rejectWith(e, [l, t]), this
            }
        }), c = l.props;
        for (function (e, t) {
            var n, r, i, o, a;
            for (n in e) if (i = t[r = X(n)], o = e[n], Array.isArray(o) && (i = o[1], o = e[n] = o[0]), n !== r && (e[r] = o, delete e[n]), (a = w.cssHooks[r]) && "expand" in a) for (n in o = a.expand(o), delete e[r], o) n in e || (e[n] = o[n], t[n] = i); else t[r] = i
        }(c, l.opts.specialEasing); o < a; o++) if (r = lt.prefilters[o].call(l, e, c, l.opts)) return h(r.stop) && (w._queueHooks(l.elem, l.opts.queue).stop = r.stop.bind(r)), r;
        return w.map(c, ut, l), h(l.opts.start) && l.opts.start.call(e, l), l.progress(l.opts.progress).done(l.opts.done, l.opts.complete).fail(l.opts.fail).always(l.opts.always), w.fx.timer(w.extend(u, {
            elem: e,
            anim: l,
            queue: l.opts.queue
        })), l
    }

    w.Animation = w.extend(lt, {
        tweeners: {
            "*": [function (e, t) {
                var n = this.createTween(e, t);
                return se(n.elem, e, te.exec(t), n), n
            }]
        }, tweener: function (e, t) {
            h(e) ? (t = e, e = ["*"]) : e = e.match(P);
            for (var n, r = 0, i = e.length; r < i; r++) n = e[r], lt.tweeners[n] = lt.tweeners[n] || [], lt.tweeners[n].unshift(t)
        }, prefilters: [function (e, t, n) {
            var r, i, o, a, s, u, l, c, f = "width" in t || "height" in t, p = this, d = {}, h = e.style,
                g = e.nodeType && ae(e), v = Y.get(e, "fxshow");
            for (r in n.queue || (null == (a = w._queueHooks(e, "fx")).unqueued && (a.unqueued = 0, s = a.empty.fire, a.empty.fire = function () {
                a.unqueued || s()
            }), a.unqueued++, p.always((function () {
                p.always((function () {
                    a.unqueued--, w.queue(e, "fx").length || a.empty.fire()
                }))
            }))), t) if (i = t[r], rt.test(i)) {
                if (delete t[r], o = o || "toggle" === i, i === (g ? "hide" : "show")) {
                    if ("show" !== i || !v || void 0 === v[r]) continue;
                    g = !0
                }
                d[r] = v && v[r] || w.style(e, r)
            }
            if ((u = !w.isEmptyObject(t)) || !w.isEmptyObject(d)) for (r in f && 1 === e.nodeType && (n.overflow = [h.overflow, h.overflowX, h.overflowY], null == (l = v && v.display) && (l = Y.get(e, "display")), "none" === (c = w.css(e, "display")) && (l ? c = l : (le([e], !0), l = e.style.display || l, c = w.css(e, "display"), le([e]))), ("inline" === c || "inline-block" === c && null != l) && "none" === w.css(e, "float") && (u || (p.done((function () {
                h.display = l
            })), null == l && (c = h.display, l = "none" === c ? "" : c)), h.display = "inline-block")), n.overflow && (h.overflow = "hidden", p.always((function () {
                h.overflow = n.overflow[0], h.overflowX = n.overflow[1], h.overflowY = n.overflow[2]
            }))), u = !1, d) u || (v ? "hidden" in v && (g = v.hidden) : v = Y.access(e, "fxshow", {display: l}), o && (v.hidden = !g), g && le([e], !0), p.done((function () {
                for (r in g || le([e]), Y.remove(e, "fxshow"), d) w.style(e, r, d[r])
            }))), u = ut(g ? v[r] : 0, r, p), r in v || (v[r] = u.start, g && (u.end = u.start, u.start = 0))
        }], prefilter: function (e, t) {
            t ? lt.prefilters.unshift(e) : lt.prefilters.push(e)
        }
    }), w.speed = function (e, t, n) {
        var r = e && "object" == typeof e ? w.extend({}, e) : {
            complete: n || !n && t || h(e) && e,
            duration: e,
            easing: n && t || t && !h(t) && t
        };
        return w.fx.off ? r.duration = 0 : "number" != typeof r.duration && (r.duration in w.fx.speeds ? r.duration = w.fx.speeds[r.duration] : r.duration = w.fx.speeds._default), null != r.queue && !0 !== r.queue || (r.queue = "fx"), r.old = r.complete, r.complete = function () {
            h(r.old) && r.old.call(this), r.queue && w.dequeue(this, r.queue)
        }, r
    }, w.fn.extend({
        fadeTo: function (e, t, n, r) {
            return this.filter(ae).css("opacity", 0).show().end().animate({opacity: t}, e, n, r)
        }, animate: function (e, t, n, r) {
            var i = w.isEmptyObject(e), o = w.speed(t, n, r), a = function () {
                var t = lt(this, w.extend({}, e), o);
                (i || Y.get(this, "finish")) && t.stop(!0)
            };
            return a.finish = a, i || !1 === o.queue ? this.each(a) : this.queue(o.queue, a)
        }, stop: function (e, t, n) {
            var r = function (e) {
                var t = e.stop;
                delete e.stop, t(n)
            };
            return "string" != typeof e && (n = t, t = e, e = void 0), t && this.queue(e || "fx", []), this.each((function () {
                var t = !0, i = null != e && e + "queueHooks", o = w.timers, a = Y.get(this);
                if (i) a[i] && a[i].stop && r(a[i]); else for (i in a) a[i] && a[i].stop && it.test(i) && r(a[i]);
                for (i = o.length; i--;) o[i].elem !== this || null != e && o[i].queue !== e || (o[i].anim.stop(n), t = !1, o.splice(i, 1));
                !t && n || w.dequeue(this, e)
            }))
        }, finish: function (e) {
            return !1 !== e && (e = e || "fx"), this.each((function () {
                var t, n = Y.get(this), r = n[e + "queue"], i = n[e + "queueHooks"], o = w.timers, a = r ? r.length : 0;
                for (n.finish = !0, w.queue(this, e, []), i && i.stop && i.stop.call(this, !0), t = o.length; t--;) o[t].elem === this && o[t].queue === e && (o[t].anim.stop(!0), o.splice(t, 1));
                for (t = 0; t < a; t++) r[t] && r[t].finish && r[t].finish.call(this);
                delete n.finish
            }))
        }
    }), w.each(["toggle", "show", "hide"], (function (e, t) {
        var n = w.fn[t];
        w.fn[t] = function (e, r, i) {
            return null == e || "boolean" == typeof e ? n.apply(this, arguments) : this.animate(st(t, !0), e, r, i)
        }
    })), w.each({
        slideDown: st("show"),
        slideUp: st("hide"),
        slideToggle: st("toggle"),
        fadeIn: {opacity: "show"},
        fadeOut: {opacity: "hide"},
        fadeToggle: {opacity: "toggle"}
    }, (function (e, t) {
        w.fn[e] = function (e, n, r) {
            return this.animate(t, e, n, r)
        }
    })), w.timers = [], w.fx.tick = function () {
        var e, t = 0, n = w.timers;
        for (Ze = Date.now(); t < n.length; t++) (e = n[t])() || n[t] !== e || n.splice(t--, 1);
        n.length || w.fx.stop(), Ze = void 0
    }, w.fx.timer = function (e) {
        w.timers.push(e), w.fx.start()
    }, w.fx.interval = 13, w.fx.start = function () {
        et || (et = !0, ot())
    }, w.fx.stop = function () {
        et = null
    }, w.fx.speeds = {slow: 600, fast: 200, _default: 400}, w.fn.delay = function (t, n) {
        return t = w.fx && w.fx.speeds[t] || t, n = n || "fx", this.queue(n, (function (n, r) {
            var i = e.setTimeout(n, t);
            r.stop = function () {
                e.clearTimeout(i)
            }
        }))
    }, tt = v.createElement("input"), nt = v.createElement("select").appendChild(v.createElement("option")), tt.type = "checkbox", d.checkOn = "" !== tt.value, d.optSelected = nt.selected, (tt = v.createElement("input")).value = "t", tt.type = "radio", d.radioValue = "t" === tt.value;
    var ct, ft = w.expr.attrHandle;
    w.fn.extend({
        attr: function (e, t) {
            return $(this, w.attr, e, t, 1 < arguments.length)
        }, removeAttr: function (e) {
            return this.each((function () {
                w.removeAttr(this, e)
            }))
        }
    }), w.extend({
        attr: function (e, t, n) {
            var r, i, o = e.nodeType;
            if (3 !== o && 8 !== o && 2 !== o) return void 0 === e.getAttribute ? w.prop(e, t, n) : (1 === o && w.isXMLDoc(e) || (i = w.attrHooks[t.toLowerCase()] || (w.expr.match.bool.test(t) ? ct : void 0)), void 0 !== n ? null === n ? void w.removeAttr(e, t) : i && "set" in i && void 0 !== (r = i.set(e, n, t)) ? r : (e.setAttribute(t, n + ""), n) : i && "get" in i && null !== (r = i.get(e, t)) ? r : null == (r = w.find.attr(e, t)) ? void 0 : r)
        }, attrHooks: {
            type: {
                set: function (e, t) {
                    if (!d.radioValue && "radio" === t && A(e, "input")) {
                        var n = e.value;
                        return e.setAttribute("type", t), n && (e.value = n), t
                    }
                }
            }
        }, removeAttr: function (e, t) {
            var n, r = 0, i = t && t.match(P);
            if (i && 1 === e.nodeType) for (; n = i[r++];) e.removeAttribute(n)
        }
    }), ct = {
        set: function (e, t, n) {
            return !1 === t ? w.removeAttr(e, n) : e.setAttribute(n, n), n
        }
    }, w.each(w.expr.match.bool.source.match(/\w+/g), (function (e, t) {
        var n = ft[t] || w.find.attr;
        ft[t] = function (e, t, r) {
            var i, o, a = t.toLowerCase();
            return r || (o = ft[a], ft[a] = i, i = null != n(e, t, r) ? a : null, ft[a] = o), i
        }
    }));
    var pt = /^(?:input|select|textarea|button)$/i, dt = /^(?:a|area)$/i;

    function ht(e) {
        return (e.match(P) || []).join(" ")
    }

    function gt(e) {
        return e.getAttribute && e.getAttribute("class") || ""
    }

    function vt(e) {
        return Array.isArray(e) ? e : "string" == typeof e && e.match(P) || []
    }

    w.fn.extend({
        prop: function (e, t) {
            return $(this, w.prop, e, t, 1 < arguments.length)
        }, removeProp: function (e) {
            return this.each((function () {
                delete this[w.propFix[e] || e]
            }))
        }
    }), w.extend({
        prop: function (e, t, n) {
            var r, i, o = e.nodeType;
            if (3 !== o && 8 !== o && 2 !== o) return 1 === o && w.isXMLDoc(e) || (t = w.propFix[t] || t, i = w.propHooks[t]), void 0 !== n ? i && "set" in i && void 0 !== (r = i.set(e, n, t)) ? r : e[t] = n : i && "get" in i && null !== (r = i.get(e, t)) ? r : e[t]
        }, propHooks: {
            tabIndex: {
                get: function (e) {
                    var t = w.find.attr(e, "tabindex");
                    return t ? parseInt(t, 10) : pt.test(e.nodeName) || dt.test(e.nodeName) && e.href ? 0 : -1
                }
            }
        }, propFix: {for: "htmlFor", class: "className"}
    }), d.optSelected || (w.propHooks.selected = {
        get: function (e) {
            var t = e.parentNode;
            return t && t.parentNode && t.parentNode.selectedIndex, null
        }, set: function (e) {
            var t = e.parentNode;
            t && (t.selectedIndex, t.parentNode && t.parentNode.selectedIndex)
        }
    }), w.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], (function () {
        w.propFix[this.toLowerCase()] = this
    })), w.fn.extend({
        addClass: function (e) {
            var t, n, r, i, o, a, s, u = 0;
            if (h(e)) return this.each((function (t) {
                w(this).addClass(e.call(this, t, gt(this)))
            }));
            if ((t = vt(e)).length) for (; n = this[u++];) if (i = gt(n), r = 1 === n.nodeType && " " + ht(i) + " ") {
                for (a = 0; o = t[a++];) r.indexOf(" " + o + " ") < 0 && (r += o + " ");
                i !== (s = ht(r)) && n.setAttribute("class", s)
            }
            return this
        }, removeClass: function (e) {
            var t, n, r, i, o, a, s, u = 0;
            if (h(e)) return this.each((function (t) {
                w(this).removeClass(e.call(this, t, gt(this)))
            }));
            if (!arguments.length) return this.attr("class", "");
            if ((t = vt(e)).length) for (; n = this[u++];) if (i = gt(n), r = 1 === n.nodeType && " " + ht(i) + " ") {
                for (a = 0; o = t[a++];) for (; -1 < r.indexOf(" " + o + " ");) r = r.replace(" " + o + " ", " ");
                i !== (s = ht(r)) && n.setAttribute("class", s)
            }
            return this
        }, toggleClass: function (e, t) {
            var n = typeof e, r = "string" === n || Array.isArray(e);
            return "boolean" == typeof t && r ? t ? this.addClass(e) : this.removeClass(e) : h(e) ? this.each((function (n) {
                w(this).toggleClass(e.call(this, n, gt(this), t), t)
            })) : this.each((function () {
                var t, i, o, a;
                if (r) for (i = 0, o = w(this), a = vt(e); t = a[i++];) o.hasClass(t) ? o.removeClass(t) : o.addClass(t); else void 0 !== e && "boolean" !== n || ((t = gt(this)) && Y.set(this, "__className__", t), this.setAttribute && this.setAttribute("class", t || !1 === e ? "" : Y.get(this, "__className__") || ""))
            }))
        }, hasClass: function (e) {
            var t, n, r = 0;
            for (t = " " + e + " "; n = this[r++];) if (1 === n.nodeType && -1 < (" " + ht(gt(n)) + " ").indexOf(t)) return !0;
            return !1
        }
    });
    var yt = /\r/g;
    w.fn.extend({
        val: function (e) {
            var t, n, r, i = this[0];
            return arguments.length ? (r = h(e), this.each((function (n) {
                var i;
                1 === this.nodeType && (null == (i = r ? e.call(this, n, w(this).val()) : e) ? i = "" : "number" == typeof i ? i += "" : Array.isArray(i) && (i = w.map(i, (function (e) {
                    return null == e ? "" : e + ""
                }))), (t = w.valHooks[this.type] || w.valHooks[this.nodeName.toLowerCase()]) && "set" in t && void 0 !== t.set(this, i, "value") || (this.value = i))
            }))) : i ? (t = w.valHooks[i.type] || w.valHooks[i.nodeName.toLowerCase()]) && "get" in t && void 0 !== (n = t.get(i, "value")) ? n : "string" == typeof (n = i.value) ? n.replace(yt, "") : null == n ? "" : n : void 0
        }
    }), w.extend({
        valHooks: {
            option: {
                get: function (e) {
                    var t = w.find.attr(e, "value");
                    return null != t ? t : ht(w.text(e))
                }
            }, select: {
                get: function (e) {
                    var t, n, r, i = e.options, o = e.selectedIndex, a = "select-one" === e.type, s = a ? null : [],
                        u = a ? o + 1 : i.length;
                    for (r = o < 0 ? u : a ? o : 0; r < u; r++) if (((n = i[r]).selected || r === o) && !n.disabled && (!n.parentNode.disabled || !A(n.parentNode, "optgroup"))) {
                        if (t = w(n).val(), a) return t;
                        s.push(t)
                    }
                    return s
                }, set: function (e, t) {
                    for (var n, r, i = e.options, o = w.makeArray(t), a = i.length; a--;) ((r = i[a]).selected = -1 < w.inArray(w.valHooks.option.get(r), o)) && (n = !0);
                    return n || (e.selectedIndex = -1), o
                }
            }
        }
    }), w.each(["radio", "checkbox"], (function () {
        w.valHooks[this] = {
            set: function (e, t) {
                if (Array.isArray(t)) return e.checked = -1 < w.inArray(w(e).val(), t)
            }
        }, d.checkOn || (w.valHooks[this].get = function (e) {
            return null === e.getAttribute("value") ? "on" : e.value
        })
    })), d.focusin = "onfocusin" in e;
    var mt = /^(?:focusinfocus|focusoutblur)$/, xt = function (e) {
        e.stopPropagation()
    };
    w.extend(w.event, {
        trigger: function (t, n, r, i) {
            var o, a, s, u, l, f, p, d, y = [r || v], m = c.call(t, "type") ? t.type : t,
                x = c.call(t, "namespace") ? t.namespace.split(".") : [];
            if (a = d = s = r = r || v, 3 !== r.nodeType && 8 !== r.nodeType && !mt.test(m + w.event.triggered) && (-1 < m.indexOf(".") && (m = (x = m.split(".")).shift(), x.sort()), l = m.indexOf(":") < 0 && "on" + m, (t = t[w.expando] ? t : new w.Event(m, "object" == typeof t && t)).isTrigger = i ? 2 : 3, t.namespace = x.join("."), t.rnamespace = t.namespace ? new RegExp("(^|\\.)" + x.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, t.result = void 0, t.target || (t.target = r), n = null == n ? [t] : w.makeArray(n, [t]), p = w.event.special[m] || {}, i || !p.trigger || !1 !== p.trigger.apply(r, n))) {
                if (!i && !p.noBubble && !g(r)) {
                    for (u = p.delegateType || m, mt.test(u + m) || (a = a.parentNode); a; a = a.parentNode) y.push(a), s = a;
                    s === (r.ownerDocument || v) && y.push(s.defaultView || s.parentWindow || e)
                }
                for (o = 0; (a = y[o++]) && !t.isPropagationStopped();) d = a, t.type = 1 < o ? u : p.bindType || m, (f = (Y.get(a, "events") || Object.create(null))[t.type] && Y.get(a, "handle")) && f.apply(a, n), (f = l && a[l]) && f.apply && V(a) && (t.result = f.apply(a, n), !1 === t.result && t.preventDefault());
                return t.type = m, i || t.isDefaultPrevented() || p._default && !1 !== p._default.apply(y.pop(), n) || !V(r) || l && h(r[m]) && !g(r) && ((s = r[l]) && (r[l] = null), w.event.triggered = m, t.isPropagationStopped() && d.addEventListener(m, xt), r[m](), t.isPropagationStopped() && d.removeEventListener(m, xt), w.event.triggered = void 0, s && (r[l] = s)), t.result
            }
        }, simulate: function (e, t, n) {
            var r = w.extend(new w.Event, n, {type: e, isSimulated: !0});
            w.event.trigger(r, null, t)
        }
    }), w.fn.extend({
        trigger: function (e, t) {
            return this.each((function () {
                w.event.trigger(e, t, this)
            }))
        }, triggerHandler: function (e, t) {
            var n = this[0];
            if (n) return w.event.trigger(e, t, n, !0)
        }
    }), d.focusin || w.each({focus: "focusin", blur: "focusout"}, (function (e, t) {
        var n = function (e) {
            w.event.simulate(t, e.target, w.event.fix(e))
        };
        w.event.special[t] = {
            setup: function () {
                var r = this.ownerDocument || this.document || this, i = Y.access(r, t);
                i || r.addEventListener(e, n, !0), Y.access(r, t, (i || 0) + 1)
            }, teardown: function () {
                var r = this.ownerDocument || this.document || this, i = Y.access(r, t) - 1;
                i ? Y.access(r, t, i) : (r.removeEventListener(e, n, !0), Y.remove(r, t))
            }
        }
    }));
    var bt = e.location, wt = {guid: Date.now()}, Tt = /\?/;
    w.parseXML = function (t) {
        var n, r;
        if (!t || "string" != typeof t) return null;
        try {
            n = (new e.DOMParser).parseFromString(t, "text/xml")
        } catch (t) {
        }
        return r = n && n.getElementsByTagName("parsererror")[0], n && !r || w.error("Invalid XML: " + (r ? w.map(r.childNodes, (function (e) {
            return e.textContent
        })).join("\n") : t)), n
    };
    var Ct = /\[\]$/, Et = /\r?\n/g, St = /^(?:submit|button|image|reset|file)$/i,
        kt = /^(?:input|select|textarea|keygen)/i;

    function At(e, t, n, r) {
        var i;
        if (Array.isArray(t)) w.each(t, (function (t, i) {
            n || Ct.test(e) ? r(e, i) : At(e + "[" + ("object" == typeof i && null != i ? t : "") + "]", i, n, r)
        })); else if (n || "object" !== x(t)) r(e, t); else for (i in t) At(e + "[" + i + "]", t[i], n, r)
    }

    w.param = function (e, t) {
        var n, r = [], i = function (e, t) {
            var n = h(t) ? t() : t;
            r[r.length] = encodeURIComponent(e) + "=" + encodeURIComponent(null == n ? "" : n)
        };
        if (null == e) return "";
        if (Array.isArray(e) || e.jquery && !w.isPlainObject(e)) w.each(e, (function () {
            i(this.name, this.value)
        })); else for (n in e) At(n, e[n], t, i);
        return r.join("&")
    }, w.fn.extend({
        serialize: function () {
            return w.param(this.serializeArray())
        }, serializeArray: function () {
            return this.map((function () {
                var e = w.prop(this, "elements");
                return e ? w.makeArray(e) : this
            })).filter((function () {
                var e = this.type;
                return this.name && !w(this).is(":disabled") && kt.test(this.nodeName) && !St.test(e) && (this.checked || !pe.test(e))
            })).map((function (e, t) {
                var n = w(this).val();
                return null == n ? null : Array.isArray(n) ? w.map(n, (function (e) {
                    return {name: t.name, value: e.replace(Et, "\r\n")}
                })) : {name: t.name, value: n.replace(Et, "\r\n")}
            })).get()
        }
    });
    var Nt = /%20/g, jt = /#.*$/, Dt = /([?&])_=[^&]*/, qt = /^(.*?):[ \t]*([^\r\n]*)$/gm, Lt = /^(?:GET|HEAD)$/,
        Ht = /^\/\//, Ot = {}, Pt = {}, Rt = "*/".concat("*"), Mt = v.createElement("a");

    function It(e) {
        return function (t, n) {
            "string" != typeof t && (n = t, t = "*");
            var r, i = 0, o = t.toLowerCase().match(P) || [];
            if (h(n)) for (; r = o[i++];) "+" === r[0] ? (r = r.slice(1) || "*", (e[r] = e[r] || []).unshift(n)) : (e[r] = e[r] || []).push(n)
        }
    }

    function Wt(e, t, n, r) {
        var i = {}, o = e === Pt;

        function a(s) {
            var u;
            return i[s] = !0, w.each(e[s] || [], (function (e, s) {
                var l = s(t, n, r);
                return "string" != typeof l || o || i[l] ? o ? !(u = l) : void 0 : (t.dataTypes.unshift(l), a(l), !1)
            })), u
        }

        return a(t.dataTypes[0]) || !i["*"] && a("*")
    }

    function Ft(e, t) {
        var n, r, i = w.ajaxSettings.flatOptions || {};
        for (n in t) void 0 !== t[n] && ((i[n] ? e : r || (r = {}))[n] = t[n]);
        return r && w.extend(!0, e, r), e
    }

    Mt.href = bt.href, w.extend({
        active: 0,
        lastModified: {},
        etag: {},
        ajaxSettings: {
            url: bt.href,
            type: "GET",
            isLocal: /^(?:about|app|app-storage|.+-extension|file|res|widget):$/.test(bt.protocol),
            global: !0,
            processData: !0,
            async: !0,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            accepts: {
                "*": Rt,
                text: "text/plain",
                html: "text/html",
                xml: "application/xml, text/xml",
                json: "application/json, text/javascript"
            },
            contents: {xml: /\bxml\b/, html: /\bhtml/, json: /\bjson\b/},
            responseFields: {xml: "responseXML", text: "responseText", json: "responseJSON"},
            converters: {"* text": String, "text html": !0, "text json": JSON.parse, "text xml": w.parseXML},
            flatOptions: {url: !0, context: !0}
        },
        ajaxSetup: function (e, t) {
            return t ? Ft(Ft(e, w.ajaxSettings), t) : Ft(w.ajaxSettings, e)
        },
        ajaxPrefilter: It(Ot),
        ajaxTransport: It(Pt),
        ajax: function (t, n) {
            "object" == typeof t && (n = t, t = void 0), n = n || {};
            var r, i, o, a, s, u, l, c, f, p, d = w.ajaxSetup({}, n), h = d.context || d,
                g = d.context && (h.nodeType || h.jquery) ? w(h) : w.event, y = w.Deferred(),
                m = w.Callbacks("once memory"), x = d.statusCode || {}, b = {}, T = {}, C = "canceled", E = {
                    readyState: 0, getResponseHeader: function (e) {
                        var t;
                        if (l) {
                            if (!a) for (a = {}; t = qt.exec(o);) a[t[1].toLowerCase() + " "] = (a[t[1].toLowerCase() + " "] || []).concat(t[2]);
                            t = a[e.toLowerCase() + " "]
                        }
                        return null == t ? null : t.join(", ")
                    }, getAllResponseHeaders: function () {
                        return l ? o : null
                    }, setRequestHeader: function (e, t) {
                        return null == l && (e = T[e.toLowerCase()] = T[e.toLowerCase()] || e, b[e] = t), this
                    }, overrideMimeType: function (e) {
                        return null == l && (d.mimeType = e), this
                    }, statusCode: function (e) {
                        var t;
                        if (e) if (l) E.always(e[E.status]); else for (t in e) x[t] = [x[t], e[t]];
                        return this
                    }, abort: function (e) {
                        var t = e || C;
                        return r && r.abort(t), S(0, t), this
                    }
                };
            if (y.promise(E), d.url = ((t || d.url || bt.href) + "").replace(Ht, bt.protocol + "//"), d.type = n.method || n.type || d.method || d.type, d.dataTypes = (d.dataType || "*").toLowerCase().match(P) || [""], null == d.crossDomain) {
                u = v.createElement("a");
                try {
                    u.href = d.url, u.href = u.href, d.crossDomain = Mt.protocol + "//" + Mt.host != u.protocol + "//" + u.host
                } catch (t) {
                    d.crossDomain = !0
                }
            }
            if (d.data && d.processData && "string" != typeof d.data && (d.data = w.param(d.data, d.traditional)), Wt(Ot, d, n, E), l) return E;
            for (f in (c = w.event && d.global) && 0 == w.active++ && w.event.trigger("ajaxStart"), d.type = d.type.toUpperCase(), d.hasContent = !Lt.test(d.type), i = d.url.replace(jt, ""), d.hasContent ? d.data && d.processData && 0 === (d.contentType || "").indexOf("application/x-www-form-urlencoded") && (d.data = d.data.replace(Nt, "+")) : (p = d.url.slice(i.length), d.data && (d.processData || "string" == typeof d.data) && (i += (Tt.test(i) ? "&" : "?") + d.data, delete d.data), !1 === d.cache && (i = i.replace(Dt, "$1"), p = (Tt.test(i) ? "&" : "?") + "_=" + wt.guid++ + p), d.url = i + p), d.ifModified && (w.lastModified[i] && E.setRequestHeader("If-Modified-Since", w.lastModified[i]), w.etag[i] && E.setRequestHeader("If-None-Match", w.etag[i])), (d.data && d.hasContent && !1 !== d.contentType || n.contentType) && E.setRequestHeader("Content-Type", d.contentType), E.setRequestHeader("Accept", d.dataTypes[0] && d.accepts[d.dataTypes[0]] ? d.accepts[d.dataTypes[0]] + ("*" !== d.dataTypes[0] ? ", " + Rt + "; q=0.01" : "") : d.accepts["*"]), d.headers) E.setRequestHeader(f, d.headers[f]);
            if (d.beforeSend && (!1 === d.beforeSend.call(h, E, d) || l)) return E.abort();
            if (C = "abort", m.add(d.complete), E.done(d.success), E.fail(d.error), r = Wt(Pt, d, n, E)) {
                if (E.readyState = 1, c && g.trigger("ajaxSend", [E, d]), l) return E;
                d.async && 0 < d.timeout && (s = e.setTimeout((function () {
                    E.abort("timeout")
                }), d.timeout));
                try {
                    l = !1, r.send(b, S)
                } catch (t) {
                    if (l) throw t;
                    S(-1, t)
                }
            } else S(-1, "No Transport");

            function S(t, n, a, u) {
                var f, p, v, b, T, C = n;
                l || (l = !0, s && e.clearTimeout(s), r = void 0, o = u || "", E.readyState = 0 < t ? 4 : 0, f = 200 <= t && t < 300 || 304 === t, a && (b = function (e, t, n) {
                    for (var r, i, o, a, s = e.contents, u = e.dataTypes; "*" === u[0];) u.shift(), void 0 === r && (r = e.mimeType || t.getResponseHeader("Content-Type"));
                    if (r) for (i in s) if (s[i] && s[i].test(r)) {
                        u.unshift(i);
                        break
                    }
                    if (u[0] in n) o = u[0]; else {
                        for (i in n) {
                            if (!u[0] || e.converters[i + " " + u[0]]) {
                                o = i;
                                break
                            }
                            a || (a = i)
                        }
                        o = o || a
                    }
                    if (o) return o !== u[0] && u.unshift(o), n[o]
                }(d, E, a)), !f && -1 < w.inArray("script", d.dataTypes) && w.inArray("json", d.dataTypes) < 0 && (d.converters["text script"] = function () {
                }), b = function (e, t, n, r) {
                    var i, o, a, s, u, l = {}, c = e.dataTypes.slice();
                    if (c[1]) for (a in e.converters) l[a.toLowerCase()] = e.converters[a];
                    for (o = c.shift(); o;) if (e.responseFields[o] && (n[e.responseFields[o]] = t), !u && r && e.dataFilter && (t = e.dataFilter(t, e.dataType)), u = o, o = c.shift()) if ("*" === o) o = u; else if ("*" !== u && u !== o) {
                        if (!(a = l[u + " " + o] || l["* " + o])) for (i in l) if ((s = i.split(" "))[1] === o && (a = l[u + " " + s[0]] || l["* " + s[0]])) {
                            !0 === a ? a = l[i] : !0 !== l[i] && (o = s[0], c.unshift(s[1]));
                            break
                        }
                        if (!0 !== a) if (a && e.throws) t = a(t); else try {
                            t = a(t)
                        } catch (e) {
                            return {state: "parsererror", error: a ? e : "No conversion from " + u + " to " + o}
                        }
                    }
                    return {state: "success", data: t}
                }(d, b, E, f), f ? (d.ifModified && ((T = E.getResponseHeader("Last-Modified")) && (w.lastModified[i] = T), (T = E.getResponseHeader("etag")) && (w.etag[i] = T)), 204 === t || "HEAD" === d.type ? C = "nocontent" : 304 === t ? C = "notmodified" : (C = b.state, p = b.data, f = !(v = b.error))) : (v = C, !t && C || (C = "error", t < 0 && (t = 0))), E.status = t, E.statusText = (n || C) + "", f ? y.resolveWith(h, [p, C, E]) : y.rejectWith(h, [E, C, v]), E.statusCode(x), x = void 0, c && g.trigger(f ? "ajaxSuccess" : "ajaxError", [E, d, f ? p : v]), m.fireWith(h, [E, C]), c && (g.trigger("ajaxComplete", [E, d]), --w.active || w.event.trigger("ajaxStop")))
            }

            return E
        },
        getJSON: function (e, t, n) {
            return w.get(e, t, n, "json")
        },
        getScript: function (e, t) {
            return w.get(e, void 0, t, "script")
        }
    }), w.each(["get", "post"], (function (e, t) {
        w[t] = function (e, n, r, i) {
            return h(n) && (i = i || r, r = n, n = void 0), w.ajax(w.extend({
                url: e,
                type: t,
                dataType: i,
                data: n,
                success: r
            }, w.isPlainObject(e) && e))
        }
    })), w.ajaxPrefilter((function (e) {
        var t;
        for (t in e.headers) "content-type" === t.toLowerCase() && (e.contentType = e.headers[t] || "")
    })), w._evalUrl = function (e, t, n) {
        return w.ajax({
            url: e,
            type: "GET",
            dataType: "script",
            cache: !0,
            async: !1,
            global: !1,
            converters: {
                "text script": function () {
                }
            },
            dataFilter: function (e) {
                w.globalEval(e, t, n)
            }
        })
    }, w.fn.extend({
        wrapAll: function (e) {
            var t;
            return this[0] && (h(e) && (e = e.call(this[0])), t = w(e, this[0].ownerDocument).eq(0).clone(!0), this[0].parentNode && t.insertBefore(this[0]), t.map((function () {
                for (var e = this; e.firstElementChild;) e = e.firstElementChild;
                return e
            })).append(this)), this
        }, wrapInner: function (e) {
            return h(e) ? this.each((function (t) {
                w(this).wrapInner(e.call(this, t))
            })) : this.each((function () {
                var t = w(this), n = t.contents();
                n.length ? n.wrapAll(e) : t.append(e)
            }))
        }, wrap: function (e) {
            var t = h(e);
            return this.each((function (n) {
                w(this).wrapAll(t ? e.call(this, n) : e)
            }))
        }, unwrap: function (e) {
            return this.parent(e).not("body").each((function () {
                w(this).replaceWith(this.childNodes)
            })), this
        }
    }), w.expr.pseudos.hidden = function (e) {
        return !w.expr.pseudos.visible(e)
    }, w.expr.pseudos.visible = function (e) {
        return !!(e.offsetWidth || e.offsetHeight || e.getClientRects().length)
    }, w.ajaxSettings.xhr = function () {
        try {
            return new e.XMLHttpRequest
        } catch (e) {
        }
    };
    var Bt = {0: 200, 1223: 204}, $t = w.ajaxSettings.xhr();
    d.cors = !!$t && "withCredentials" in $t, d.ajax = $t = !!$t, w.ajaxTransport((function (t) {
        var n, r;
        if (d.cors || $t && !t.crossDomain) return {
            send: function (i, o) {
                var a, s = t.xhr();
                if (s.open(t.type, t.url, t.async, t.username, t.password), t.xhrFields) for (a in t.xhrFields) s[a] = t.xhrFields[a];
                for (a in t.mimeType && s.overrideMimeType && s.overrideMimeType(t.mimeType), t.crossDomain || i["X-Requested-With"] || (i["X-Requested-With"] = "XMLHttpRequest"), i) s.setRequestHeader(a, i[a]);
                n = function (e) {
                    return function () {
                        n && (n = r = s.onload = s.onerror = s.onabort = s.ontimeout = s.onreadystatechange = null, "abort" === e ? s.abort() : "error" === e ? "number" != typeof s.status ? o(0, "error") : o(s.status, s.statusText) : o(Bt[s.status] || s.status, s.statusText, "text" !== (s.responseType || "text") || "string" != typeof s.responseText ? {binary: s.response} : {text: s.responseText}, s.getAllResponseHeaders()))
                    }
                }, s.onload = n(), r = s.onerror = s.ontimeout = n("error"), void 0 !== s.onabort ? s.onabort = r : s.onreadystatechange = function () {
                    4 === s.readyState && e.setTimeout((function () {
                        n && r()
                    }))
                }, n = n("abort");
                try {
                    s.send(t.hasContent && t.data || null)
                } catch (i) {
                    if (n) throw i
                }
            }, abort: function () {
                n && n()
            }
        }
    })), w.ajaxPrefilter((function (e) {
        e.crossDomain && (e.contents.script = !1)
    })), w.ajaxSetup({
        accepts: {script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},
        contents: {script: /\b(?:java|ecma)script\b/},
        converters: {
            "text script": function (e) {
                return w.globalEval(e), e
            }
        }
    }), w.ajaxPrefilter("script", (function (e) {
        void 0 === e.cache && (e.cache = !1), e.crossDomain && (e.type = "GET")
    })), w.ajaxTransport("script", (function (e) {
        var t, n;
        if (e.crossDomain || e.scriptAttrs) return {
            send: function (r, i) {
                t = w("<script>").attr(e.scriptAttrs || {}).prop({
                    charset: e.scriptCharset,
                    src: e.url
                }).on("load error", n = function (e) {
                    t.remove(), n = null, e && i("error" === e.type ? 404 : 200, e.type)
                }), v.head.appendChild(t[0])
            }, abort: function () {
                n && n()
            }
        }
    }));
    var _t, zt = [], Ut = /(=)\?(?=&|$)|\?\?/;
    w.ajaxSetup({
        jsonp: "callback", jsonpCallback: function () {
            var e = zt.pop() || w.expando + "_" + wt.guid++;
            return this[e] = !0, e
        }
    }), w.ajaxPrefilter("json jsonp", (function (t, n, r) {
        var i, o, a,
            s = !1 !== t.jsonp && (Ut.test(t.url) ? "url" : "string" == typeof t.data && 0 === (t.contentType || "").indexOf("application/x-www-form-urlencoded") && Ut.test(t.data) && "data");
        if (s || "jsonp" === t.dataTypes[0]) return i = t.jsonpCallback = h(t.jsonpCallback) ? t.jsonpCallback() : t.jsonpCallback, s ? t[s] = t[s].replace(Ut, "$1" + i) : !1 !== t.jsonp && (t.url += (Tt.test(t.url) ? "&" : "?") + t.jsonp + "=" + i), t.converters["script json"] = function () {
            return a || w.error(i + " was not called"), a[0]
        }, t.dataTypes[0] = "json", o = e[i], e[i] = function () {
            a = arguments
        }, r.always((function () {
            void 0 === o ? w(e).removeProp(i) : e[i] = o, t[i] && (t.jsonpCallback = n.jsonpCallback, zt.push(i)), a && h(o) && o(a[0]), a = o = void 0
        })), "script"
    })), d.createHTMLDocument = ((_t = v.implementation.createHTMLDocument("").body).innerHTML = "<form></form><form></form>", 2 === _t.childNodes.length), w.parseHTML = function (e, t, n) {
        return "string" != typeof e ? [] : ("boolean" == typeof t && (n = t, t = !1), t || (d.createHTMLDocument ? ((r = (t = v.implementation.createHTMLDocument("")).createElement("base")).href = v.location.href, t.head.appendChild(r)) : t = v), o = !n && [], (i = N.exec(e)) ? [t.createElement(i[1])] : (i = xe([e], t, o), o && o.length && w(o).remove(), w.merge([], i.childNodes)));
        var r, i, o
    }, w.fn.load = function (e, t, n) {
        var r, i, o, a = this, s = e.indexOf(" ");
        return -1 < s && (r = ht(e.slice(s)), e = e.slice(0, s)), h(t) ? (n = t, t = void 0) : t && "object" == typeof t && (i = "POST"), 0 < a.length && w.ajax({
            url: e,
            type: i || "GET",
            dataType: "html",
            data: t
        }).done((function (e) {
            o = arguments, a.html(r ? w("<div>").append(w.parseHTML(e)).find(r) : e)
        })).always(n && function (e, t) {
            a.each((function () {
                n.apply(this, o || [e.responseText, t, e])
            }))
        }), this
    }, w.expr.pseudos.animated = function (e) {
        return w.grep(w.timers, (function (t) {
            return e === t.elem
        })).length
    }, w.offset = {
        setOffset: function (e, t, n) {
            var r, i, o, a, s, u, l = w.css(e, "position"), c = w(e), f = {};
            "static" === l && (e.style.position = "relative"), s = c.offset(), o = w.css(e, "top"), u = w.css(e, "left"), ("absolute" === l || "fixed" === l) && -1 < (o + u).indexOf("auto") ? (a = (r = c.position()).top, i = r.left) : (a = parseFloat(o) || 0, i = parseFloat(u) || 0), h(t) && (t = t.call(e, n, w.extend({}, s))), null != t.top && (f.top = t.top - s.top + a), null != t.left && (f.left = t.left - s.left + i), "using" in t ? t.using.call(e, f) : c.css(f)
        }
    }, w.fn.extend({
        offset: function (e) {
            if (arguments.length) return void 0 === e ? this : this.each((function (t) {
                w.offset.setOffset(this, e, t)
            }));
            var t, n, r = this[0];
            return r ? r.getClientRects().length ? (t = r.getBoundingClientRect(), n = r.ownerDocument.defaultView, {
                top: t.top + n.pageYOffset,
                left: t.left + n.pageXOffset
            }) : {top: 0, left: 0} : void 0
        }, position: function () {
            if (this[0]) {
                var e, t, n, r = this[0], i = {top: 0, left: 0};
                if ("fixed" === w.css(r, "position")) t = r.getBoundingClientRect(); else {
                    for (t = this.offset(), n = r.ownerDocument, e = r.offsetParent || n.documentElement; e && (e === n.body || e === n.documentElement) && "static" === w.css(e, "position");) e = e.parentNode;
                    e && e !== r && 1 === e.nodeType && ((i = w(e).offset()).top += w.css(e, "borderTopWidth", !0), i.left += w.css(e, "borderLeftWidth", !0))
                }
                return {
                    top: t.top - i.top - w.css(r, "marginTop", !0),
                    left: t.left - i.left - w.css(r, "marginLeft", !0)
                }
            }
        }, offsetParent: function () {
            return this.map((function () {
                for (var e = this.offsetParent; e && "static" === w.css(e, "position");) e = e.offsetParent;
                return e || re
            }))
        }
    }), w.each({scrollLeft: "pageXOffset", scrollTop: "pageYOffset"}, (function (e, t) {
        var n = "pageYOffset" === t;
        w.fn[e] = function (r) {
            return $(this, (function (e, r, i) {
                var o;
                if (g(e) ? o = e : 9 === e.nodeType && (o = e.defaultView), void 0 === i) return o ? o[t] : e[r];
                o ? o.scrollTo(n ? o.pageXOffset : i, n ? i : o.pageYOffset) : e[r] = i
            }), e, r, arguments.length)
        }
    })), w.each(["top", "left"], (function (e, t) {
        w.cssHooks[t] = Fe(d.pixelPosition, (function (e, n) {
            if (n) return n = We(e, t), Pe.test(n) ? w(e).position()[t] + "px" : n
        }))
    })), w.each({Height: "height", Width: "width"}, (function (e, t) {
        w.each({padding: "inner" + e, content: t, "": "outer" + e}, (function (n, r) {
            w.fn[r] = function (i, o) {
                var a = arguments.length && (n || "boolean" != typeof i),
                    s = n || (!0 === i || !0 === o ? "margin" : "border");
                return $(this, (function (t, n, i) {
                    var o;
                    return g(t) ? 0 === r.indexOf("outer") ? t["inner" + e] : t.document.documentElement["client" + e] : 9 === t.nodeType ? (o = t.documentElement, Math.max(t.body["scroll" + e], o["scroll" + e], t.body["offset" + e], o["offset" + e], o["client" + e])) : void 0 === i ? w.css(t, n, s) : w.style(t, n, i, s)
                }), t, a ? i : void 0, a)
            }
        }))
    })), w.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], (function (e, t) {
        w.fn[t] = function (e) {
            return this.on(t, e)
        }
    })), w.fn.extend({
        bind: function (e, t, n) {
            return this.on(e, null, t, n)
        }, unbind: function (e, t) {
            return this.off(e, null, t)
        }, delegate: function (e, t, n, r) {
            return this.on(t, e, n, r)
        }, undelegate: function (e, t, n) {
            return 1 === arguments.length ? this.off(e, "**") : this.off(t, e || "**", n)
        }, hover: function (e, t) {
            return this.mouseenter(e).mouseleave(t || e)
        }
    }), w.each("blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "), (function (e, t) {
        w.fn[t] = function (e, n) {
            return 0 < arguments.length ? this.on(t, null, e, n) : this.trigger(t)
        }
    }));
    var Xt = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
    w.proxy = function (e, t) {
        var n, r, o;
        if ("string" == typeof t && (n = e[t], t = e, e = n), h(e)) return r = i.call(arguments, 2), (o = function () {
            return e.apply(t || this, r.concat(i.call(arguments)))
        }).guid = e.guid = e.guid || w.guid++, o
    }, w.holdReady = function (e) {
        e ? w.readyWait++ : w.ready(!0)
    }, w.isArray = Array.isArray, w.parseJSON = JSON.parse, w.nodeName = A, w.isFunction = h, w.isWindow = g, w.camelCase = X, w.type = x, w.now = Date.now, w.isNumeric = function (e) {
        var t = w.type(e);
        return ("number" === t || "string" === t) && !isNaN(e - parseFloat(e))
    }, w.trim = function (e) {
        return null == e ? "" : (e + "").replace(Xt, "")
    }, "function" == typeof define && define.amd && define("jquery", [], (function () {
        return w
    }));
    var Vt = e.jQuery, Gt = e.$;
    return w.noConflict = function (t) {
        return e.$ === w && (e.$ = Gt), t && e.jQuery === w && (e.jQuery = Vt), w
    }, void 0 === t && (e.jQuery = e.$ = w), w
}));

const previousSiblings = e => {
    let t = [];
    for (; e = e.previousElementSibling;) t.push(e);
    return t
}, nextSiblings = e => {
    let t = [];
    for (; e = e.nextElementSibling;) t.push(e);
    return t
};

function addActiveClassToElement(e, t) {
    const i = document.querySelector(e), n = document.querySelector(t);
    i.addEventListener("click", () => {
        i.classList.add("clicked"), n.classList.add("active"), n.classList.contains("active") || n.classList.remove("active"), n.classList.contains("sidebar") && n.classList.contains("active") && document.body.classList.add("overflow-hidden"), n.classList.contains("sidebar-catalog") && n.classList.contains("active") && document.querySelector(".sidebar-inner").classList.add("overflow-hidden")
    })
}

function removeActiveClassFromElement(e, t) {
    const i = document.querySelector(e), n = document.querySelector(t);
    i.addEventListener("click", () => {
        (n.classList.contains("active") || i.classList.contains("active")) && (n.classList.remove("active"), i.classList.remove("active")), n.classList.contains("sidebar-catalog") && document.querySelector(".sidebar-inner").classList.remove("overflow-hidden")
    })
}

function toggleActiveClass(e, t = !1) {
    const i = document.querySelectorAll(e);
    i.forEach(n => {
        n.addEventListener("click", (function () {
            this.classList.contains("active") ? this.classList.remove("active") : (i.forEach(e => {
                e.classList.remove("active")
            }), this.classList.add("active")), t && scrollToElement(e)
        }))
    })
}

function scrollToElement(e, t = !1, i = 0) {
    const n = document.querySelector(e), a = document.querySelector(t),
        o = n.getBoundingClientRect().top + window.pageYOffset + i;
    t && a.click(), window.scrollTo({top: o, behavior: "smooth"})
}

function scrollToTop() {
    window.scrollTo({top: 0, behavior: "smooth"})
}

let isMenuLoaded = !1;

function scSidebar(e, t, i = 0) {
    if (!e && !t) return;
    let n, a, o = 0, s = () => {
        masked("#sidebar", !1), mobileMenu()
    };
    switch ($(".sidebar-header-text:first").html(e), masked("#sidebar", !0), t) {
        case"menu":
            a = "index.php?route=octemplates/menu/oct_menu", o = 1, n = "mobile=1";
            let e = window.innerWidth;
            if (isMenuLoaded) return r(i), void s();
            $.ajax({
                type: "post",
                url: "index.php?route=octemplates/menu/oct_menu",
                data: "mobile=1",
                cache: !1,
                success: function (n) {
                    "locations" !== t && "search" !== t && ($("#sc_sidebar_content").html(n), isMenuLoaded = !0, 1 === o && e < 1200 && ($("#language").prependTo("#oct_mobile_language"), $("#currency").prependTo("#oct_mobile_currency"))), s(), r(i)
                }
            });
            break;
        case"locations":
            $("#sc_sidebar_content").html("<div></div>"), $("#sc_sidebar_locations").prependTo("#sc_sidebar_content").removeClass("d-none"), s();
            break;
        case"search":
            $("#sc_sidebar_content").html("<div></div>"), $("#search").prependTo("#sc_sidebar_content"), s(), $("#input_search").trigger("focus")
    }

    function r(e) {
        switch (e) {
            case"account":
                $(".sidebar-main-menu-item-account").trigger("click");
                break;
            case"viewed":
                $("#oct_sidebar_viewed_toggle").trigger("click").addClass("clicked")
        }
    }
}

function mobileMenu() {
    const e = document.getElementById("sidebar"), t = document.getElementById("overlay"),
        i = document.querySelectorAll(".sidebar-menu-toggle"), n = document.querySelectorAll(".sidebar-header-menu"),
        a = document.querySelectorAll(".sidebar-menu-catalog"), o = document.querySelectorAll('[data-sidebar="close"]');

    function s() {
        let i = screen.width;
        e.classList.remove("active"), t.classList.remove("active", "z-index"), document.body.classList.remove("overflow-hidden"), a.forEach(e => {
            e.classList.remove("active")
        }), i > 1199 && ($("#language").prependTo("#oct_desktop_language"), $("#currency").prependTo("#oct_desktop_currency")), $("#sc_sidebar_locations").prependTo("#sc_sidebar_locations_inner").addClass("d-none"), clearLiveSearch(), $("#search").prependTo(".header-search"), $("#oct_sidebar_viewed_toggle").hasClass("clicked") && $("#oct_sidebar_viewed_toggle").removeClass("clicked")
    }

    e.classList.add("active"), t.classList.add("active", "z-index"), document.body.classList.add("overflow-hidden"), i.forEach(e => {
        const t = e.querySelector(".sidebar-menu-catalog");
        e.addEventListener("click", e => {
            const i = e.target;
            i.classList.contains("sc-btn-close") || i.classList.contains("sidebar-header-menu") || "a" === i.tagName.toLowerCase() || t.classList.add("active")
        })
    }), n.forEach(e => {
        e.addEventListener("click", t => {
            let i = t.currentTarget;
            i !== e && (i = i.parentNode), i.closest(".sidebar-menu-catalog").classList.remove("active"), $("#oct_sidebar_viewed_toggle").hasClass("clicked") && $("#oct_sidebar_viewed_toggle").removeClass("clicked")
        })
    }), t.addEventListener("click", () => {
        s()
    }), o.forEach(e => {
        e.addEventListener("click", () => {
            s()
        })
    })
}

function mobileMegaMenu() {
    const e = document.querySelector(".sc-megamenu"), t = document.querySelector("header"),
        i = e.querySelectorAll(".sc-megamenu-list .sc-btn"), n = e.querySelectorAll(".sc-megamenu-back"),
        a = e.querySelectorAll(".sc-megamenu-child"), o = document.getElementById("overlay"),
        s = document.querySelectorAll(".sc-megamenu-close"), r = window.innerWidth;
    let l;
    if (document.querySelector(".sidebar") && (l = document.querySelector(".sidebar")), r < 1200) {
        document.addEventListener("click", (function (i) {
            (i.target.matches('[data-menu="open"]') || i.target.closest('[data-menu="open"]')) && (e.classList.add("active"), o.classList.contains("active") || o.classList.add("active"), e.classList.contains("active") ? (document.body.classList.add("overflow-hidden"), t.style.zIndex = "13100") : (document.body.classList.remove("overflow-hidden"), t.removeAttribute("style")))
        })), i.forEach(e => {
            e.addEventListener("click", (function () {
                this.nextElementSibling.classList.add("active")
            }))
        }), n.forEach(e => {
            e.addEventListener("click", (function () {
                this.closest(".sc-megamenu-child").classList.remove("active")
            }))
        });
        const r = () => {
            l && !l.classList.contains("active") && o.classList.remove("active"), e.classList.remove("active"), document.body.classList.remove("overflow-hidden"), t.removeAttribute("style"), l.removeAttribute("style"), o.removeAttribute("style"), a.forEach(e => {
                e.classList.remove("active")
            })
        };
        o.addEventListener("click", () => {
            r()
        }), s.forEach(e => {
            e.addEventListener("click", () => {
                r()
            })
        })
    }
}

function megaMenu() {
    try {
        const e = document.querySelector("#menuToggleButton"), t = document.querySelector(".sc-megamenu"),
            i = document.querySelector(".with-slideshow .sc-megamenu-list"),
            n = document.querySelectorAll(".sc-megamenu-list-item"), a = document.getElementById("overlay"),
            o = document.querySelector("header"), s = document.querySelector(".sc-slideshow-plus");
        if (window.innerWidth > 1199) {
            e.addEventListener("click", (function (e) {
                const i = e.target;
                a.classList.toggle("active"), i.classList.toggle("clicked"), t.classList.toggle("active"), document.body.classList.toggle("overflow-hidden"), o.style.zIndex = "12100"
            })), n.forEach(e => {
                e.addEventListener("mouseout", (function () {
                    e.classList.remove("active")
                }))
            }), a.addEventListener("click", i => {
                i.target.classList.remove("active"), t.classList.remove("active"), e.classList.remove("clicked"), document.body.classList.remove("overflow-hidden")
            }), i.addEventListener("mouseenter", () => {
                o.style.zIndex = "12100", o.classList.contains("with-slideshow") && (a.classList.add("active"), document.body.classList.add("overflow-hidden"))
            }), i.addEventListener("mouseleave", () => {
                o.classList.contains("with-slideshow") && !t.classList.contains("active") && (a.classList.remove("active"), document.body.classList.remove("overflow-hidden"), o.style.zIndex = "5")
            }), new IntersectionObserver((function (e) {
                let n = document.querySelectorAll(".with-slideshow"),
                    a = document.querySelector(".products-of-the-day"), r = s.getBoundingClientRect().height;
                if (!0 === e[0].isIntersecting) {
                    t.classList.add("with-slideshow"), o.classList.add("with-slideshow"), o.style.zIndex = "5", t.classList.contains("active") || (i.style.height = r + "px");
                    let e = !1;
                    window.addEventListener("resize", () => {
                        e || (e = !0, requestAnimationFrame(() => {
                            r = s.getBoundingClientRect().height, t.classList.contains("active") || (i.style.height = r + "px"), e = !1
                        }))
                    }), a || (i.classList.add("without-day-products"), i.style.height = r + "px", i.addEventListener("mouseleave", () => {
                        r = s.getBoundingClientRect().height, i.style.height = r + "px"
                    }))
                } else n.forEach(e => {
                    e.classList.remove("with-slideshow")
                }), o.style.zIndex = "12100"
            }), {threshold: [0]}).observe(s)
        }
    } catch (e) {
    }
}

function toggleColumnCategories() {
    document.querySelectorAll(".sc-column-categories-item > span").forEach(e => {
        const t = e.closest("li").querySelector(".sc-column-categories-children");
        e.addEventListener("click", (function (e) {
            "a" !== e.target.tagName.toLowerCase() && t && (this.closest("li").classList.toggle("clicked"), t.classList.toggle("active"))
        }))
    })
}

function octColumnProducts(e, t, i) {
    const n = document.getElementById(e), a = document.getElementById(t), o = document.getElementById(i);
    let s = o.firstElementChild, r = o.lastElementChild;
    s.classList.add("d-block", "fadeInColumn"), a.addEventListener("click", () => {
        let e = o.querySelector(".sc-column-item.d-block"), t = e.nextElementSibling;
        t ? (e.classList.remove("d-block", "fadeInColumn"), t.classList.add("d-block", "fadeInColumn")) : (e.classList.remove("d-block", "fadeInColumn"), s.classList.add("d-block", "fadeInColumn"))
    }), n.addEventListener("click", () => {
        let e = o.querySelector(".sc-column-item.d-block"), t = e.previousElementSibling;
        t ? (e.classList.remove("d-block", "fadeInColumn"), t.classList.add("d-block", "fadeInColumn")) : (e.classList.remove("d-block", "fadeInColumn"), r.classList.add("d-block", "fadeInColumn"))
    })
}

function switchCategoryDisplay() {
    const e = document.getElementById("list-view"), t = document.getElementById("grid-view"),
        i = document.getElementById("price-view");
    let n = document.querySelectorAll(".product-layout"), a = document.querySelectorAll(".sc-category-appearance-btn");

    function o(e) {
        a.forEach(e => {
            e.classList.remove("active")
        }), e.classList.add("active"), n.forEach(t => {
            t.classList.contains("product-grid") ? t.classList.remove("product-grid", "col-sm-6", "col-md-4", "col-lg-3") : t.classList.contains("product-list") ? t.classList.remove("product-list", "col-12", "col-sm-6", "col-md-12") : t.classList.remove("product-price", "col-12", "col-sm-6", "col-md-12"), "list-view" == e.id ? (t.classList.add("product-list", "col-12", "col-sm-6", "col-md-12"), localStorage.setItem("display", "list")) : "grid-view" == e.id ? (t.classList.add("product-grid", "col-sm-6", "col-md-4", "col-lg-3"), localStorage.setItem("display", "grid")) : "price-view" == e.id && (t.classList.add("product-price", "col-12", "col-sm-6", "col-md-12"), localStorage.setItem("display", "price"))
        })
    }

    "grid" == localStorage.getItem("display") || null === localStorage.getItem("display") ? o(t) : "list" == localStorage.getItem("display") ? o(e) : "price" == localStorage.getItem("display") && o(i), e.addEventListener("click", (function () {
        o(this)
    })), t.addEventListener("click", (function () {
        o(this)
    })), i.addEventListener("click", (function () {
        o(this)
    }))
}

function reviewsRating(e) {
    document.querySelector(e).querySelectorAll(".sc-module-rating-star").forEach(e => {
        e.addEventListener("click", e => {
            const t = e.currentTarget, i = previousSiblings(t);
            nextSiblings(t).forEach(e => e.classList.remove("sc-module-rating-star-is")), t.classList.add("sc-module-rating-star-is"), i.forEach(e => e.classList.add("sc-module-rating-star-is"))
        })
    })
}

function dropdownToggle() {
    const e = document.getElementById("overlay");
    document.documentElement.clientWidth <= 1024 ? ($("body").on("click", ".sc-dropdown-toggle", (function (t) {
        t.preventDefault(), $(this).parent().addClass("active"), e.classList.add("active", "overlay-transparent")
    })), e.addEventListener("click", e => {
        e.target.classList.remove("active", "overlay-transparent"), $(".sc-dropdown-box").removeClass("active")
    })) : $(".sc-dropdown-box").hover((function () {
        $(this).addClass("active")
    }), (function () {
        $(this).removeClass("active")
    }))
}

function showProductButtons() {
    const e = document.querySelector(".sc-product-fixed-btns");
    new IntersectionObserver((function (t) {
        !0 === t[0].isIntersecting ? e.classList.remove("enabled") : e.classList.add("enabled")
    }), {threshold: [0]}).observe(document.getElementById("productImages"))
}

function octProductTabs() {
    let e = document.getElementById("oct-tabs"), t = e.querySelectorAll(".sc-product-tab"), i = window.innerWidth;
    t.forEach(n => {
        n.addEventListener("click", a => {
            const o = a.target;
            let s = 0;
            previousSiblings(o).forEach(e => {
                s += e.offsetWidth
            });
            let r = s - (e.offsetWidth - o.offsetWidth) / 2, l = o.getAttribute("data-tab-target");
            n.classList.contains("active") || (t.forEach(e => {
                e.classList.remove("active")
            }), o.classList.add("active")), r < 0 && (r = 0), e.scroll({
                left: r,
                behavior: "smooth"
            }), scrollToElement(l, !1, i < 768 ? "#sc-related-products_0" == l ? -90 : -80 : "#sc-related-products_0" == l ? -120 : -140)
        })
    })
}

function categoryWall() {
    try {
        let e = document.querySelectorAll(".sc-category-wall-item .sc-category-wall-item-block"),
            t = document.querySelectorAll(".sc-category-wall-item .sc-category-wall-item-list"), i = window.innerWidth;
        e.forEach(e => {
            let n = e.querySelector(".sc-category-wall-item-list");
            n.classList.add("animated"), i < 768 ? e.parentNode.addEventListener("click", () => {
                t.forEach(e => {
                    e.classList.remove("d-flex", "fade-in"), e.classList.add("d-none")
                }), n.classList.toggle("d-none"), n.classList.toggle("d-flex", "fade-in")
            }) : (e.parentNode.addEventListener("mouseenter", () => {
                n.classList.remove("d-none"), n.classList.add("d-flex", "fade-in")
            }), e.parentNode.addEventListener("mouseleave", () => {
                n.classList.remove("d-flex", "fade-in"), n.classList.add("d-none")
            }))
        })
    } catch (e) {
    }
}

function toTopButton() {
    const e = document.getElementById("back-top");
    let t = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    document.documentElement.scrollTop / t > .5 ? e.classList.contains("active") || e.classList.add("active") : e.classList.contains("active") && e.classList.remove("active"), e.addEventListener("click", scrollToTop)
}

function timerSpecial(e, t) {
    const i = e => e <= 9 ? "0" + e : e;
    ((e, t) => {
        const n = document.querySelector(e), a = n.querySelector("#sc-timer-days"),
            o = n.querySelector("#sc-timer-hours"), s = n.querySelector("#sc-timer-minutes"),
            r = n.querySelector("#sc-timer-seconds"), l = setInterval(c, 1e3);

        function c() {
            const e = (e => {
                const t = Date.parse(e) - Date.parse(new Date), i = Math.floor(t / 1e3 % 60),
                    n = Math.floor(t / 1e3 / 60 % 60), a = Math.floor(t / 36e5 % 24);
                return {total: t, days: Math.floor(t / 864e5), hours: a, minutes: n, seconds: i}
            })(t);
            a.textContent = i(e.days), o.textContent = i(e.hours), s.textContent = i(e.minutes), r.textContent = i(e.seconds), e.total <= 0 && (a.textContent = "00", o.textContent = "00", s.textContent = "00", r.textContent = "00", clearInterval(l))
        }

        c()
    })(e, t)
}

function setAddedCompareWishlist() {
    const e = document.querySelector("[data-compare-ids]"), t = document.querySelector("[data-wishlist-ids]");
    if (!e || !t) return;
    let i = e.getAttribute("data-compare-ids").split(","), n = t.getAttribute("data-wishlist-ids").split(",");
    const a = (i, n, a, o) => {
        const s = document.querySelectorAll(`.${i}[onclick="${n}.${o ? "add" : "remove"}('${a}');"]`),
            r = "compare" === n ? e : t;
        s.forEach(e => {
            e.setAttribute("onclick", `${n}.${o ? "remove" : "add"}('${a}');`), e.classList[o ? "add" : "remove"]("added");
            const t = r.getAttribute(o ? `data-${n}-text-in` : `data-${n}-text`);
            e.setAttribute("title", t)
        })
    };
    i.forEach(e => a("sc-compare-btn", "compare", e, !0)), n.forEach(e => a("sc-wishlist-btn", "wishlist", e, !0));
    const o = document.querySelectorAll(".sc-compare-btn"), s = document.querySelectorAll(".sc-wishlist-btn");
    [o, s].forEach(s => {
        const r = s === o ? "compare" : "wishlist", l = "compare" === r ? i : n, c = "compare" === r ? e : t;
        s.forEach(e => {
            e.addEventListener("click", () => {
                const t = (e.getAttribute("onclick") || "").match(/\d+/);
                if (!t) return;
                const o = t[0], s = e.classList.contains("added"), u = s ? l.filter(e => e !== o) : [...l, o];
                a(`sc-${r}-btn`, r, o, !s), c.setAttribute(`data-${r}-ids`, u.join(",")), "compare" === r ? i = u : n = u
            })
        })
    })
}

function setCartBtnAdded(e = !1) {
    let t = document.querySelector("[data-cart-ids]");
    if (!t) return;
    let i = document.querySelectorAll(".sc-module-cart-btn, #button-cart, #oct-popup-button-cart, .sc-product-fixed-cart-btn, .sc-category-cart-btn");
    if (!i) return;
    let n = t.getAttribute("data-cart-ids").split(",").filter(Boolean);
    if (!n) return;
    let a = (e, i, n) => {
        let a = t.getAttribute(n ? "data-cart-text-in" : "data-cart-text");
        try {
            e.querySelector(".sc-btn-text").textContent = a
        } catch (e) {
        }
        e.setAttribute("title", a), n ? e.classList.add("added") : e.classList.remove("added")
    };
    i.forEach(i => {
        let o;
        o = i.parentElement.querySelector('input[name="product_id"]'), o && (productId = o.value), n.includes(productId) && a(i, productId, !0), e && !n.includes(productId) && a(i, productId, !1), i.addEventListener("click", () => {
            n = t.getAttribute("data-cart-ids").split(",").filter(Boolean), n.includes(productId) ? a(i, productId, !0) : a(i, productId, !1)
        })
    })
}

function masked(e, t) {
    1 == t ? $("body").append('<div class="sc-loader-overlay d-flex justify-content-center align-items-center"><span class="sc-loader"></span></div>') : setTimeout((function () {
        $(".sc-loader-overlay").remove()
    }), 600)
}

function octShowMap(e, t) {
    var i = $(t);
    i.hasClass("not_in") && (i.html(e), i.removeClass("not_in"))
}

function octShowMoreModule(e, t = 0, i, n, a, o = 0) {
    let s = parseInt(document.querySelector("#" + a).value) + 1;
    $.ajax({
        type: "post",
        dataType: "html",
        url: "index.php?route=extension/module/oct_product_modules/modulePage",
        data: "module_id=" + e + "&page=" + s + "&oct_path=" + o,
        cache: !1,
        beforeSend: function () {
            masked("body", !0), document.querySelector("#" + i).classList.add("oct-animated")
        },
        complete: function () {
            1 == t && lozad(".oct-lazy").observe(), masked("body", !1), document.querySelector("#" + i).classList.remove("oct-animated")
        },
        success: function (e) {
            let t = document.createElement("div");
            t.innerHTML = e;
            let o = t.querySelectorAll(".sc-module-col");
            const r = Array.from(o);
            let l = document.querySelector("#" + n);
            r.forEach(e => l.insertAdjacentElement("beforeend", e));
            let c = t.querySelectorAll("#" + i);
            Array.from(c);
            document.querySelector("#" + a).value = s, null === t.querySelector(".oct-load-more-button-wrapper") && document.querySelector("#" + n).nextElementSibling.classList.add("d-none"), setAddedCompareWishlist(), setCartBtnAdded()
        }
    })
}

function popupClose(e) {
    document.body.removeAttribute("style")
}

function octPopupCallPhone() {
    masked("body", !0), $(".modal-backdrop").remove(), $.ajax({
        type: "post",
        dataType: "html",
        url: "index.php?route=octemplates/module/oct_popup_call_phone",
        cache: !1,
        success: function (e) {
            masked("body", !1), $(".modal-holder").html(e), $("#callbackModal").modal("show"), popupClose()
        }
    })
}

function octPopupSubscribe() {
    $(".modal-backdrop").length > 0 || (masked("body", !0), $(".modal-backdrop").remove(), $.ajax({
        type: "post",
        dataType: "html",
        url: "index.php?route=octemplates/module/oct_subscribe",
        cache: !1,
        success: function (e) {
            masked("body", !1), $(".modal-holder").html(e), $("#subscribeModal").modal("show"), popupClose()
        }
    }))
}

function octPopupFoundCheaper(e) {
    masked("body", !0), $(".modal-backdrop").remove(), $.ajax({
        type: "post",
        dataType: "html",
        url: "index.php?route=octemplates/module/oct_popup_found_cheaper",
        data: "product_id=" + e,
        cache: !1,
        success: function (e) {
            masked("body", !1), $(".modal-holder").html(e), $("#foundCheaperModal").modal("show"), popupClose()
        }
    })
}

function octPopupLogin() {
    masked("body", !0), $(".modal-backdrop").remove(), $.ajax({
        type: "post",
        url: "index.php?route=octemplates/module/oct_popup_login",
        data: $(this).serialize(),
        cache: !1,
        success: function (e) {
            masked("body", !1), $(".modal-holder").html(e), $("#loginModal").modal("show"), popupClose()
        }
    })
}

function octPopUpView(e) {
    masked("body", !0), $(".modal-backdrop").remove(), $.ajax({
        type: "post",
        dataType: "html",
        url: "index.php?route=octemplates/module/oct_popup_view",
        data: "product_id=" + e,
        cache: !1,
        success: function (e) {
            masked("body", !1), $(".modal-holder").html(e), $("#quickViewModal").modal("show"), popupClose(), setCartBtnAdded()
        }
    })
}

function octPopPurchase(e) {
    masked("body", !0), $.ajax({
        type: "post",
        dataType: "html",
        url: "index.php?route=octemplates/module/oct_popup_purchase",
        data: "product_id=" + e,
        cache: !1,
        success: function (e) {
            masked("body", !1), $(".modal-backdrop").remove(), $(".modal-holder").html(e), $("#quickOrderModal").modal("show"), popupClose()
        }
    })
}

function octPopupCart(e = 0) {
    console.log('window.innerWidth', window.innerWidth)

    if(window.innerWidth < 768){
        let catLink = $('#cart_link').attr('data-link');
        if(catLink.length > 2){
            window.location.href = catLink;
            return true;
        }
    }

    masked("body", !0), $(".modal-backdrop").remove(), $.ajax({
        type: "get",
        dataType: "html",
        url: "index.php?route=octemplates/module/oct_popup_cart&isPopup=1",
        cache: !1,
        success: function (t) {
            if (masked("body", !1), $(".modal-holder").html(t), e) {
                let t = e;
                $("#modalCartBody").html(t)
            }
            $("#cartModal").modal("show"), popupClose()
        }
    })
}

function getOCTCookie(e) {
    var t = document.cookie.match(new RegExp("(?:^|; )" + e.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, "\\$1") + "=([^;]*)"));
    return t ? decodeURIComponent(t[1]) : "undefined"
}

function scNotify(e, t) {
    var i = "info";
    switch (e) {
        case"success":
            i = "fas fa-check";
            break;
        case"danger":
            i = "fas fa-times";
            break;
        case"warning":
            i = "fas fa-exclamation"
    }
    $.notify({message: t, icon: i}, {type: e})
}

function scInputMask(e, t) {
    $(e).inputmask({mask: t})
}

window.addEventListener("DOMContentLoaded", () => {
    "use strict";
    toggleActiveClass(".sc-footer-middle-list .sc-footer-title", !0), addActiveClassToElement("#mobile-search-button", "#overlay"), addActiveClassToElement("#mobile-search-button", "#sidebar"), dropdownToggle(), setAddedCompareWishlist(), setCartBtnAdded(), mobileMegaMenu(), toggleColumnCategories();
    [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map((function (e) {
        return new bootstrap.Tooltip(e)
    })), [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]')).map((function (e) {
        return new bootstrap.Popover(e)
    }))
}), $((function () {
    $(document).on("click", ".sc-plus", (function () {
        $(this).prev().val();
        var e = parseInt($(this).prev().val(), 10) + 1;
        $(this).prev().val(e)
    })), $(document).on("click", ".sc-minus", (function () {
        const e = $(this).next().val(), t = $(this).parent().find(".min-qty").val();
        if (e > 1) var i = parseInt($(this).next().val(), 10) - 1; else i = 1;
        i < t && (i = t), $(this).next().val(i)
    })), $(document).on("click", ".sc-module-cart-btn", (function () {
        const e = $(this).parent().find('input[name="product_id"]').val(),
            t = $(this).parent().find(".sc-module-quantity .form-control").val();
        let i = document.querySelector(".required");
        i && i.classList.contains("option-required") ? cart.add(e, t, 1) : cart.add(e, t, 0)
    })), $("#sc_fixed_contact_button").on("click", (function () {
        $(this).toggleClass("clicked"), $(".sc-fixed-contact-dropdown").toggleClass("expanded"), $(".sc-fixed-contact-icon .fa-envelope, #back-top").toggleClass("d-none"), $(".sc-fixed-contact-icon .sc-fixed-contact-text").toggleClass("d-none"), $("#sc_fixed_contact_substrate").toggleClass("active")
    })), $("#sc_fixed_contact_substrate").on("click", (function () {
        $(this).removeClass("active"), $(".sc-fixed-contact-dropdown").removeClass("expanded"), $(".sc-fixed-contact-icon .fa-envelope, #back-top").removeClass("d-none"), $(".sc-fixed-contact-icon .sc-fixed-contact-text").toggleClass("d-none"), $("#sc_fixed_contact_button").removeClass("clicked")
    })), $(".sc-fixed-contact-dropdown").click((function (e) {
        e.stopPropagation()
    })), $(document).ready((function () {
        $(document).on("click", "#oct_sidebar_viewed_toggle", (function () {
            $(this).hasClass("clicked") || (masked("#sidebar", !0), $.ajax({
                type: "post",
                url: "index.php?route=octemplates/main/oct_functions/productViews",
                cache: !1,
                success: function (e) {
                    masked("#sidebar", !1), $("#oct_sidebar_viewed").html(e)
                }
            }))
        }));
        var e = $("body");
        e.on("mouseover", '[data-bs-toggle="tooltip"]', (function (e) {
            return e.stopPropagation(), new bootstrap.Tooltip(this).show()
        })), e.on("mouseleave", '[data-bs-toggle="tooltip"]', (function (e) {
            $('[role="tooltip"]').fadeOut((function () {
                e.stopPropagation(), $(this).remove()
            }))
        })), e.on("mouseover", '[data-bs-toggle="popover"]', (function (e) {
            return e.stopPropagation(), new bootstrap.Popover(this).show()
        })), e.on("mouseleave", '[data-bs-toggle="popover"]', (function (e) {
            $('[role="tooltip"]').fadeOut((function () {
                e.stopPropagation(), $(this).remove()
            }))
        }))
    }))
})), function (e) {
    "function" == typeof define && define.amd ? define(["jquery"], e) : "object" == typeof exports ? e(require("jquery")) : e(jQuery)
}((function (e) {
    var t = {
        element: "body",
        position: null,
        type: "info",
        allow_dismiss: !0,
        newest_on_top: !1,
        showProgressbar: !1,
        placement: {from: "top", align: "right"},
        offset: 20,
        spacing: 10,
        z_index: 12331,
        delay: 5e3,
        timer: 1e3,
        url_target: "_blank",
        mouse_over: null,
        animate: {enter: "animated fadeInRight", exit: "animated fadeOutUp"},
        onShow: null,
        onShown: null,
        onClose: null,
        onClosed: null,
        icon_type: "class",
        template: '<div class="alert-block d-flex flex-column animated" data-notify-position="top-right">\n\t\t\t\t\t\t<div class="sc-alert br-4 sc-alert-{0}" role="alert">\n\t\t\t\t\t\t\t<div class="sc-alert-content d-flex align-items-stretch position-relative h-100">\n\t\t\t\t\t\t\t\t<button type="button" class="sc-alert-close" aria-hidden="true" data-notify="dismiss">\n\t\t\t\t\t\t\t\t\t<img src="catalog/view/theme/oct_showcase/img/sprite.svg#include--notify-close-icon" width="18" height="18">\n\t\t\t\t\t\t\t\t</button>\n\t\t\t\t\t\t\t\t<div class="sc-alert-icon d-flex align-items-center justify-content-center align-self-stretch">\n\t\t\t\t\t\t\t\t\t<img src="catalog/view/theme/oct_showcase/img/sprite.svg#include--alert-{0}-icon" alt="" width="16" height="16">\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t<div class="sc-alert-text fsz-14 fw-500 py-3 px-4">{2}</div>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t</div>'
    };

    function i(i, n, a) {
        n = {
            content: {
                message: "object" == typeof n ? n.message : n,
                title: n.title ? n.title : "",
                icon: n.icon ? n.icon : "",
                url: n.url ? n.url : "#",
                target: n.target ? n.target : "-"
            }
        };
        a = e.extend(!0, {}, n, a), this.settings = e.extend(!0, {}, t, a), this._defaults = t, "-" == this.settings.content.target && (this.settings.content.target = this.settings.url_target), this.animations = {
            start: "webkitAnimationStart oanimationstart MSAnimationStart animationstart",
            end: "webkitAnimationEnd oanimationend MSAnimationEnd animationend"
        }, "number" == typeof this.settings.offset && (this.settings.offset = {
            x: this.settings.offset,
            y: this.settings.offset
        }), this.init()
    }

    String.format = function () {
        for (var e = arguments[0], t = 1; t < arguments.length; t++) e = e.replace(RegExp("\\{" + (t - 1) + "\\}", "gm"), arguments[t]);
        return e
    }, e.extend(i.prototype, {
        init: function () {
            var e = this;
            this.buildNotify(), this.settings.content.icon && this.setIcon(), "#" != this.settings.content.url && this.styleURL(), this.placement(), this.bind(), this.notify = {
                $ele: this.$ele, update: function (t, i) {
                    var n = {};
                    for (var t in "string" == typeof t ? n[t] = i : n = t, n) switch (t) {
                        case"type":
                            this.$ele.removeClass("alert-" + e.settings.type), this.$ele.find('[data-notify="progressbar"] > .progress-bar').removeClass("progress-bar-" + e.settings.type), e.settings.type = n[t], this.$ele.addClass("alert-" + n[t]).find('[data-notify="progressbar"] > .progress-bar').addClass("progress-bar-" + n[t]);
                            break;
                        case"icon":
                            var a = this.$ele.find('[data-notify="icon"]');
                            "class" == e.settings.icon_type.toLowerCase() ? a.removeClass(e.settings.content.icon).addClass(n[t]) : (a.is("img") || a.find("img"), a.attr("src", n[t]));
                            break;
                        case"progress":
                            var o = e.settings.delay - e.settings.delay * (n[t] / 100);
                            this.$ele.data("notify-delay", o), this.$ele.find('[data-notify="progressbar"] > div').attr("aria-valuenow", n[t]).css("width", n[t] + "%");
                            break;
                        case"url":
                            this.$ele.find('[data-notify="url"]').attr("href", n[t]);
                            break;
                        case"target":
                            this.$ele.find('[data-notify="url"]').attr("target", n[t]);
                            break;
                        default:
                            this.$ele.find('[data-notify="' + t + '"]').html(n[t])
                    }
                    var s = this.$ele.outerHeight() + parseInt(e.settings.spacing) + parseInt(e.settings.offset.y);
                    e.reposition(s)
                }, close: function () {
                    e.close()
                }
            }
        }, buildNotify: function () {
            var t = this.settings.content;
            this.$ele = e(String.format(this.settings.template, this.settings.type, t.title, t.message, t.url, t.target)), this.$ele.attr("data-notify-position", this.settings.placement.from + "-" + this.settings.placement.align), this.settings.allow_dismiss || this.$ele.find('[data-notify="dismiss"]').css("display", "none"), (this.settings.delay <= 0 && !this.settings.showProgressbar || !this.settings.showProgressbar) && this.$ele.find('[data-notify="progressbar"]').remove()
        }, setIcon: function () {
            "class" == this.settings.icon_type.toLowerCase() ? this.$ele.find('[data-notify="icon"]').addClass(this.settings.content.icon) : this.$ele.find('[data-notify="icon"]').is("img") ? this.$ele.find('[data-notify="icon"]').attr("src", this.settings.content.icon) : this.$ele.find('[data-notify="icon"]').append('<img src="' + this.settings.content.icon + '" alt="Notify Icon" />')
        }, styleURL: function () {
            this.$ele.find('[data-notify="url"]').css({
                backgroundImage: "url(data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7)",
                height: "100%",
                left: "0px",
                position: "absolute",
                top: "0px",
                width: "100%",
                zIndex: this.settings.z_index + 1
            }), this.$ele.find('[data-notify="dismiss"]').css({
                position: "absolute",
                right: "10px",
                top: "5px",
                zIndex: this.settings.z_index + 2
            })
        }, placement: function () {
            var t = this, i = this.settings.offset.y, n = {
                display: "inline-block",
                margin: "0px auto",
                position: this.settings.position ? this.settings.position : "body" === this.settings.element ? "fixed" : "absolute",
                transition: "all .5s ease-in-out",
                zIndex: this.settings.z_index
            }, a = !1, o = this.settings;
            switch (e('[data-notify-position="' + this.settings.placement.from + "-" + this.settings.placement.align + '"]:not([data-closing="true"])').each((function () {
                return i = Math.max(i, parseInt(e(this).css(o.placement.from)) + parseInt(e(this).outerHeight()) + parseInt(o.spacing))
            })), 1 == this.settings.newest_on_top && (i = this.settings.offset.y), n[this.settings.placement.from] = i + "px", this.settings.placement.align) {
                case"left":
                case"right":
                    n[this.settings.placement.align] = this.settings.offset.x + "px";
                    break;
                case"center":
                    n.left = 0, n.right = 0
            }
            this.$ele.css(n).addClass(this.settings.animate.enter), e.each(Array("webkit", "moz", "o", "ms", ""), (function (e, i) {
                t.$ele[0].style[i + "AnimationIterationCount"] = 1
            })), e(this.settings.element).append(this.$ele), 1 == this.settings.newest_on_top && (i = parseInt(i) + parseInt(this.settings.spacing) + this.$ele.outerHeight(), this.reposition(i)), e.isFunction(t.settings.onShow) && t.settings.onShow.call(this.$ele), this.$ele.one(this.animations.start, (function (e) {
                a = !0
            })).one(this.animations.end, (function (i) {
                e.isFunction(t.settings.onShown) && t.settings.onShown.call(this)
            })), setTimeout((function () {
                a || e.isFunction(t.settings.onShown) && t.settings.onShown.call(this)
            }), 600)
        }, bind: function () {
            var t = this;
            if (this.$ele.find('[data-notify="dismiss"]').on("click", (function () {
                t.close()
            })), this.$ele.mouseover((function (t) {
                e(this).data("data-hover", "true")
            })).mouseout((function (t) {
                e(this).data("data-hover", "false")
            })), this.$ele.data("data-hover", "false"), this.settings.delay > 0) {
                t.$ele.data("notify-delay", t.settings.delay);
                var i = setInterval((function () {
                    var e = parseInt(t.$ele.data("notify-delay")) - t.settings.timer;
                    if ("false" === t.$ele.data("data-hover") && "pause" == t.settings.mouse_over || "pause" != t.settings.mouse_over) {
                        var n = (t.settings.delay - e) / t.settings.delay * 100;
                        t.$ele.data("notify-delay", e), t.$ele.find('[data-notify="progressbar"] > div').attr("aria-valuenow", n).css("width", n + "%")
                    }
                    e <= -t.settings.timer && (clearInterval(i), t.close())
                }), t.settings.timer)
            }
        }, close: function () {
            var t = this, i = parseInt(this.$ele.css(this.settings.placement.from)), n = !1;
            this.$ele.data("closing", "true").addClass(this.settings.animate.exit), t.reposition(i), e.isFunction(t.settings.onClose) && t.settings.onClose.call(this.$ele), this.$ele.one(this.animations.start, (function (e) {
                n = !0
            })).one(this.animations.end, (function (i) {
                e(this).remove(), e.isFunction(t.settings.onClosed) && t.settings.onClosed.call(this)
            })), setTimeout((function () {
                n || (t.$ele.remove(), t.settings.onClosed && t.settings.onClosed(t.$ele))
            }), 600)
        }, reposition: function (t) {
            var i = this,
                n = '[data-notify-position="' + this.settings.placement.from + "-" + this.settings.placement.align + '"]:not([data-closing="true"])',
                a = this.$ele.nextAll(n);
            1 == this.settings.newest_on_top && (a = this.$ele.prevAll(n)), a.each((function () {
                e(this).css(i.settings.placement.from, t), t = parseInt(t) + parseInt(i.settings.spacing) + e(this).outerHeight()
            }))
        }
    }), e.notify = function (e, t) {
        return new i(this, e, t).notify
    }, e.notifyDefaults = function (i) {
        return t = e.extend(!0, {}, t, i)
    }, e.notifyClose = function (t) {
        void 0 === t || "all" == t ? e("[data-notify]").find('[data-notify="dismiss"]').trigger("click") : e('[data-notify-position="' + t + '"]').find('[data-notify="dismiss"]').trigger("click")
    }
}));
let octLoadMore = function (e) {
    document.querySelectorAll("ul.pagination li").length, parseInt(document.querySelector("ul.pagination li.active span").innerHTML);
    let t = document.querySelector("ul.pagination li.active").nextElementSibling.outerHTML.replace(/.*href="(.*)".*/, "$1");
    t = t.replace(/&amp;/g, "&"), $.ajax({
        url: t, dataType: "html", beforeSend: function () {
            masked("body", !0), document.querySelector(".oct-load-more-button").classList.add("oct-animated")
        }, complete: function () {
            e && lozad(".oct-lazy").observe(), masked("body", !1), octCheckPagination(), octCheckDisplayView(), switchCategoryDisplay(), document.querySelector(".sc-category .oct-load-more-button").classList.remove("oct-animated")
        }, success: function (e) {
            octShowMoreContent(e), history.pushState({}, "", t), setAddedCompareWishlist(), setCartBtnAdded()
        }
    })
}, octCheckPagination = function () {
    document.querySelector("ul.pagination li.active + li") ? document.querySelector(".sc-category .oct-load-more-button").classList.remove("d-none") : (document.querySelector(".sc-category .oct-load-more-button, .sc-category .oct-load-more").classList.add("d-none"), document.querySelector(".sc-category .oct-load-more").classList.remove("d-flex"))
}, octCheckDisplayView = function () {
    if (null !== document.querySelector(".sc-category-sort-limit")) if ("list" == localStorage.getItem("display")) {
        let e = document.querySelector("#list-view");
        simulateClick(e)
    } else if ("grid" == localStorage.getItem("display")) {
        let e = document.querySelector("#grid-view");
        simulateClick(e)
    } else {
        let e = document.querySelector("#price-view");
        simulateClick(e)
    }
}, octShowMoreContent = function (e) {
    let t = document.createElement("div");
    t.innerHTML = e;
    let i = t.querySelectorAll("ul.pagination li");
    const n = Array.from(i);
    document.querySelector("ul.pagination").innerHTML = "";
    let a = document.querySelector("ul.pagination");
    n.forEach(e => a.insertAdjacentElement("beforeend", e));
    let o = t.querySelectorAll(".product-layout.sc-module-col");
    const s = Array.from(o);
    let r = document.querySelector(".sc-category-products");
    s.forEach(e => r.insertAdjacentElement("beforeend", e))
}, simulateClick = function (e) {
    let t = new MouseEvent("click", {bubbles: !0, cancelable: !0, view: window});
    e.dispatchEvent(t)
};
if ($("body").on("click", ".product-layout.product-grid", (function () {
    let e = this.getAttribute("data-pid");
    sessionStorage.setItem("productViewed", e)
})), $("body").on("click", ".product-layout.sc-module-col button", (function (e) {
    let t = $(this).parent().parent().parent().parent().parent().attr("data-pid");
    sessionStorage.setItem("productViewed", t)
})), window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
    "scrollRestoration" in history && (history.scrollRestoration = "manual");
    let e = !1;
    $(window).on("scroll", (function () {
        e || (e = !0, scrollTo(0, 0))
    }));
    let t = sessionStorage.getItem("productViewed");
    if (null !== t) {
        let e = document.querySelector('[data-pid="' + t + '"]'), i = e.offsetTop;
        window.innerWidth > 992 ? i -= 58 : i -= 100, $(window).on("pageshow", (function (e) {
            $("html, body").animate({scrollTop: i}, "50"), sessionStorage.removeItem("productViewed")
        }))
    }
} else sessionStorage.removeItem("productViewed"), history.scrollRestoration = "auto";
/*!
 * jquery.inputmask.bundle.js
 * https://github.com/RobinHerbots/Inputmask
 * Copyright (c) 2010 - 2019 Robin Herbots
 * Licensed under the MIT license (http://www.opensource.org/licenses/mit-license.php)
 * Version: 4.0.6
 */
!function (e) {
    var t = {};

    function i(n) {
        if (t[n]) return t[n].exports;
        var a = t[n] = {i: n, l: !1, exports: {}};
        return e[n].call(a.exports, a, a.exports, i), a.l = !0, a.exports
    }

    i.m = e, i.c = t, i.d = function (e, t, n) {
        i.o(e, t) || Object.defineProperty(e, t, {enumerable: !0, get: n})
    }, i.r = function (e) {
        "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {value: "Module"}), Object.defineProperty(e, "__esModule", {value: !0})
    }, i.t = function (e, t) {
        if (1 & t && (e = i(e)), 8 & t) return e;
        if (4 & t && "object" == typeof e && e && e.__esModule) return e;
        var n = Object.create(null);
        if (i.r(n), Object.defineProperty(n, "default", {
            enumerable: !0,
            value: e
        }), 2 & t && "string" != typeof e) for (var a in e) i.d(n, a, function (t) {
            return e[t]
        }.bind(null, a));
        return n
    }, i.n = function (e) {
        var t = e && e.__esModule ? function () {
            return e.default
        } : function () {
            return e
        };
        return i.d(t, "a", t), t
    }, i.o = function (e, t) {
        return Object.prototype.hasOwnProperty.call(e, t)
    }, i.p = "", i(i.s = 0)
}([function (e, t, i) {
    "use strict";
    i(1), i(6), i(7);
    var n = s(i(2)), a = s(i(3)), o = s(i(4));

    function s(e) {
        return e && e.__esModule ? e : {default: e}
    }

    a.default === o.default && i(8), window.Inputmask = n.default
}, function (e, t, i) {
    "use strict";
    var n, a, o;
    "function" == typeof Symbol && Symbol.iterator;
    a = [i(2)], void 0 === (o = "function" == typeof (n = function (e) {
        return e.extendDefinitions({
            A: {validator: "[A-Za-zА-яЁёÀ-ÿµ]", casing: "upper"},
            "&": {validator: "[0-9A-Za-zА-яЁёÀ-ÿµ]", casing: "upper"},
            "#": {validator: "[0-9A-Fa-f]", casing: "upper"}
        }), e.extendAliases({
            cssunit: {regex: "[+-]?[0-9]+\\.?([0-9]+)?(px|em|rem|ex|%|in|cm|mm|pt|pc)"},
            url: {regex: "(https?|ftp)//.*", autoUnmask: !1},
            ip: {
                mask: "i[i[i]].i[i[i]].i[i[i]].i[i[i]]", definitions: {
                    i: {
                        validator: function (e, t, i, n, a) {
                            return i - 1 > -1 && "." !== t.buffer[i - 1] ? (e = t.buffer[i - 1] + e, e = i - 2 > -1 && "." !== t.buffer[i - 2] ? t.buffer[i - 2] + e : "0" + e) : e = "00" + e, new RegExp("25[0-5]|2[0-4][0-9]|[01][0-9][0-9]").test(e)
                        }
                    }
                }, onUnMask: function (e, t, i) {
                    return e
                }, inputmode: "numeric"
            },
            email: {
                mask: "*{1,64}[.*{1,64}][.*{1,64}][.*{1,63}]@-{1,63}.-{1,63}[.-{1,63}][.-{1,63}]",
                greedy: !1,
                casing: "lower",
                onBeforePaste: function (e, t) {
                    return (e = e.toLowerCase()).replace("mailto:", "")
                },
                definitions: {
                    "*": {validator: "[0-9１-９A-Za-zА-яЁёÀ-ÿµ!#$%&'*+/=?^_`{|}~-]"},
                    "-": {validator: "[0-9A-Za-z-]"}
                },
                onUnMask: function (e, t, i) {
                    return e
                },
                inputmode: "email"
            },
            mac: {mask: "##:##:##:##:##:##"},
            vin: {
                mask: "V{13}9{4}",
                definitions: {V: {validator: "[A-HJ-NPR-Za-hj-npr-z\\d]", casing: "upper"}},
                clearIncomplete: !0,
                autoUnmask: !0
            }
        }), e
    }) ? n.apply(t, a) : n) || (e.exports = o)
}, function (e, t, i) {
    "use strict";
    var n, a, o, s = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
        return typeof e
    } : function (e) {
        return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
    };
    a = [i(3), i(5)], void 0 === (o = "function" == typeof (n = function (e, t, i) {
        var n = t.document, a = navigator.userAgent, o = a.indexOf("MSIE ") > 0 || a.indexOf("Trident/") > 0,
            r = f("touchstart"), l = /iemobile/i.test(a), c = /iphone/i.test(a) && !l;

        function u(t, n, a) {
            if (!(this instanceof u)) return new u(t, n, a);
            this.el = i, this.events = {}, this.maskset = i, this.refreshValue = !1, !0 !== a && (e.isPlainObject(t) ? n = t : (n = n || {}, t && (n.alias = t)), this.opts = e.extend(!0, {}, this.defaults, n), this.noMasksCache = n && n.definitions !== i, this.userOptions = n || {}, this.isRTL = this.opts.numericInput, d(this.opts.alias, n, this.opts))
        }

        function d(t, n, a) {
            var o = u.prototype.aliases[t];
            return o ? (o.alias && d(o.alias, i, a), e.extend(!0, a, o), e.extend(!0, a, n), !0) : (null === a.mask && (a.mask = t), !1)
        }

        function p(t, n) {
            function a(t, a, o) {
                var s = !1;
                if (null !== t && "" !== t || ((s = null !== o.regex) ? t = (t = o.regex).replace(/^(\^)(.*)(\$)$/, "$2") : (s = !0, t = ".*")), 1 === t.length && !1 === o.greedy && 0 !== o.repeat && (o.placeholder = ""), o.repeat > 0 || "*" === o.repeat || "+" === o.repeat) {
                    var r = "*" === o.repeat ? 0 : "+" === o.repeat ? 1 : o.repeat;
                    t = o.groupmarker[0] + t + o.groupmarker[1] + o.quantifiermarker[0] + r + "," + o.repeat + o.quantifiermarker[1]
                }
                var l, c = s ? "regex_" + o.regex : o.numericInput ? t.split("").reverse().join("") : t;
                return u.prototype.masksCache[c] === i || !0 === n ? (l = {
                    mask: t,
                    maskToken: u.prototype.analyseMask(t, s, o),
                    validPositions: {},
                    _buffer: i,
                    buffer: i,
                    tests: {},
                    excludes: {},
                    metadata: a,
                    maskLength: i,
                    jitOffset: {}
                }, !0 !== n && (u.prototype.masksCache[c] = l, l = e.extend(!0, {}, u.prototype.masksCache[c]))) : l = e.extend(!0, {}, u.prototype.masksCache[c]), l
            }

            if (e.isFunction(t.mask) && (t.mask = t.mask(t)), e.isArray(t.mask)) {
                if (t.mask.length > 1) {
                    if (null === t.keepStatic) {
                        t.keepStatic = "auto";
                        for (var o = 0; o < t.mask.length; o++) if (t.mask[o].charAt(0) !== t.mask[0].charAt(0)) {
                            t.keepStatic = !0;
                            break
                        }
                    }
                    var s = t.groupmarker[0];
                    return e.each(t.isRTL ? t.mask.reverse() : t.mask, (function (n, a) {
                        s.length > 1 && (s += t.groupmarker[1] + t.alternatormarker + t.groupmarker[0]), a.mask === i || e.isFunction(a.mask) ? s += a : s += a.mask
                    })), a(s += t.groupmarker[1], t.mask, t)
                }
                t.mask = t.mask.pop()
            }
            return t.mask && t.mask.mask !== i && !e.isFunction(t.mask.mask) ? a(t.mask.mask, t.mask, t) : a(t.mask, t.mask, t)
        }

        function f(e) {
            var t = n.createElement("input"), i = "on" + e, a = i in t;
            return a || (t.setAttribute(i, "return;"), a = "function" == typeof t[i]), t = null, a
        }

        function m(a, d, p) {
            d = d || this.maskset, p = p || this.opts;
            var h, g, v, y, k, b = this, x = this.el, w = this.isRTL, S = !1, E = !1, A = !1, _ = !1;

            function C(e, t, n, a, o) {
                var s = p.greedy;
                o && (p.greedy = !1), t = t || 0;
                var r, l, c, u = [], d = 0;
                M();
                do {
                    if (!0 === e && P().validPositions[d]) l = (c = o && !0 === P().validPositions[d].match.optionality && P().validPositions[d + 1] === i && (!0 === P().validPositions[d].generatedInput || P().validPositions[d].input == p.skipOptionalPartCharacter && d > 0) ? I(d, F(d, r, d - 1)) : P().validPositions[d]).match, r = c.locator.slice(), u.push(!0 === n ? c.input : !1 === n ? l.nativeDef : J(d, l)); else {
                        l = (c = O(d, r, d - 1)).match, r = c.locator.slice();
                        var f = !0 !== a && (!1 !== p.jitMasking ? p.jitMasking : l.jit);
                        (!1 === f || f === i || "number" == typeof f && isFinite(f) && f > d) && u.push(!1 === n ? l.nativeDef : J(d, l))
                    }
                    "auto" === p.keepStatic && l.newBlockMarker && null !== l.fn && (p.keepStatic = d - 1), d++
                } while ((v === i || d < v) && (null !== l.fn || "" !== l.def) || t > d);
                return "" === u[u.length - 1] && u.pop(), !1 === n && P().maskLength !== i || (P().maskLength = d - 1), p.greedy = s, u
            }

            function P() {
                return d
            }

            function L(e) {
                var t = P();
                t.buffer = i, !0 !== e && (t.validPositions = {}, t.p = 0)
            }

            function M(e, t, n) {
                var a = -1, o = -1, s = n || P().validPositions;
                for (var r in e === i && (e = -1), s) {
                    var l = parseInt(r);
                    s[l] && (t || !0 !== s[l].generatedInput) && (l <= e && (a = l), l >= e && (o = l))
                }
                return -1 === a || a == e ? o : -1 == o || e - a < o - e ? a : o
            }

            function $(e) {
                var t = e.locator[e.alternation];
                return "string" == typeof t && t.length > 0 && (t = t.split(",")[0]), t !== i ? t.toString() : ""
            }

            function D(e, t) {
                var n = (e.alternation != i ? e.mloc[$(e)] : e.locator).join("");
                if ("" !== n) for (; n.length < t;) n += "0";
                return n
            }

            function I(e, t) {
                for (var n, a, o, s = D(T(e = e > 0 ? e - 1 : 0)), r = 0; r < t.length; r++) {
                    var l = t[r];
                    n = D(l, s.length);
                    var c = Math.abs(n - s);
                    (a === i || "" !== n && c < a || o && !p.greedy && o.match.optionality && "master" === o.match.newBlockMarker && (!l.match.optionality || !l.match.newBlockMarker) || o && o.match.optionalQuantifier && !l.match.optionalQuantifier) && (a = c, o = l)
                }
                return o
            }

            function O(e, t, i) {
                return P().validPositions[e] || I(e, F(e, t ? t.slice() : t, i))
            }

            function T(e, t) {
                return P().validPositions[e] ? P().validPositions[e] : (t || F(e))[0]
            }

            function j(e, t) {
                for (var i = !1, n = F(e), a = 0; a < n.length; a++) if (n[a].match && n[a].match.def === t) {
                    i = !0;
                    break
                }
                return i
            }

            function F(t, n, a) {
                var o, s = P().maskToken, r = n ? a : 0, l = n ? n.slice() : [0], c = [], u = !1,
                    d = n ? n.join("") : "";

                function f(n, a, s, l) {
                    function m(s, l, h) {
                        function g(t, i) {
                            var n = 0 === e.inArray(t, i.matches);
                            return n || e.each(i.matches, (function (e, a) {
                                if (!0 === a.isQuantifier ? n = g(t, i.matches[e - 1]) : a.hasOwnProperty("matches") && (n = g(t, a)), n) return !1
                            })), n
                        }

                        function v(t, n, a) {
                            var o, s;
                            if ((P().tests[t] || P().validPositions[t]) && e.each(P().tests[t] || [P().validPositions[t]], (function (e, t) {
                                if (t.mloc[n]) return o = t, !1;
                                var r = a !== i ? a : t.alternation,
                                    l = t.locator[r] !== i ? t.locator[r].toString().indexOf(n) : -1;
                                (s === i || l < s) && -1 !== l && (o = t, s = l)
                            })), o) {
                                var r = o.locator[o.alternation];
                                return (o.mloc[n] || o.mloc[r] || o.locator).slice((a !== i ? a : o.alternation) + 1)
                            }
                            return a !== i ? v(t, n) : i
                        }

                        function y(e, t) {
                            function i(e) {
                                for (var t, i, n = [], a = 0, o = e.length; a < o; a++) if ("-" === e.charAt(a)) for (i = e.charCodeAt(a + 1); ++t < i;) n.push(String.fromCharCode(t)); else t = e.charCodeAt(a), n.push(e.charAt(a));
                                return n.join("")
                            }

                            return p.regex && null !== e.match.fn && null !== t.match.fn ? -1 !== i(t.match.def.replace(/[\[\]]/g, "")).indexOf(i(e.match.def.replace(/[\[\]]/g, ""))) : e.match.def === t.match.nativeDef
                        }

                        function k(e, t) {
                            if (t === i || e.alternation === t.alternation && -1 === e.locator[e.alternation].toString().indexOf(t.locator[t.alternation])) {
                                e.mloc = e.mloc || {};
                                var n = e.locator[e.alternation];
                                if (n !== i) {
                                    if ("string" == typeof n && (n = n.split(",")[0]), e.mloc[n] === i && (e.mloc[n] = e.locator.slice()), t !== i) {
                                        for (var a in t.mloc) "string" == typeof a && (a = a.split(",")[0]), e.mloc[a] === i && (e.mloc[a] = t.mloc[a]);
                                        e.locator[e.alternation] = Object.keys(e.mloc).join(",")
                                    }
                                    return !0
                                }
                                e.alternation = i
                            }
                            return !1
                        }

                        if (r > 500 && h !== i) throw "Inputmask: There is probably an error in your mask definition or in the code. Create an issue on github with an example of the mask you are using. " + P().mask;
                        if (r === t && s.matches === i) return c.push({
                            match: s,
                            locator: l.reverse(),
                            cd: d,
                            mloc: {}
                        }), !0;
                        if (s.matches !== i) {
                            if (s.isGroup && h !== s) {
                                if (s = m(n.matches[e.inArray(s, n.matches) + 1], l, h)) return !0
                            } else if (s.isOptional) {
                                var b = s;
                                if (s = f(s, a, l, h)) {
                                    if (e.each(c, (function (e, t) {
                                        t.match.optionality = !0
                                    })), o = c[c.length - 1].match, h !== i || !g(o, b)) return !0;
                                    u = !0, r = t
                                }
                            } else if (s.isAlternator) {
                                var x, w = s, S = [], E = c.slice(), A = l.length, _ = a.length > 0 ? a.shift() : -1;
                                if (-1 === _ || "string" == typeof _) {
                                    var C, L = r, M = a.slice(), $ = [];
                                    if ("string" == typeof _) $ = _.split(","); else for (C = 0; C < w.matches.length; C++) $.push(C.toString());
                                    if (P().excludes[t]) {
                                        for (var D = $.slice(), I = 0, O = P().excludes[t].length; I < O; I++) $.splice($.indexOf(P().excludes[t][I].toString()), 1);
                                        0 === $.length && (P().excludes[t] = i, $ = D)
                                    }
                                    (!0 === p.keepStatic || isFinite(parseInt(p.keepStatic)) && L >= p.keepStatic) && ($ = $.slice(0, 1));
                                    for (var T = !1, j = 0; j < $.length; j++) {
                                        C = parseInt($[j]), c = [], a = "string" == typeof _ && v(r, C, A) || M.slice(), w.matches[C] && m(w.matches[C], [C].concat(l), h) ? s = !0 : 0 === j && (T = !0), x = c.slice(), r = L, c = [];
                                        for (var F = 0; F < x.length; F++) {
                                            var q = x[F], R = !1;
                                            q.match.jit = q.match.jit || T, q.alternation = q.alternation || A, k(q);
                                            for (var B = 0; B < S.length; B++) {
                                                var N = S[B];
                                                if ("string" != typeof _ || q.alternation !== i && -1 !== e.inArray(q.locator[q.alternation].toString(), $)) {
                                                    if (q.match.nativeDef === N.match.nativeDef) {
                                                        R = !0, k(N, q);
                                                        break
                                                    }
                                                    if (y(q, N)) {
                                                        k(q, N) && (R = !0, S.splice(S.indexOf(N), 0, q));
                                                        break
                                                    }
                                                    if (y(N, q)) {
                                                        k(N, q);
                                                        break
                                                    }
                                                    if (U = N, (z = q).locator.slice(z.alternation).join("") == U.locator.slice(U.alternation).join("") && null === z.match.fn && null !== U.match.fn && U.match.fn.test(z.match.def, P(), t, !1, p, !1)) {
                                                        k(q, N) && (R = !0, S.splice(S.indexOf(N), 0, q));
                                                        break
                                                    }
                                                }
                                            }
                                            R || S.push(q)
                                        }
                                    }
                                    c = E.concat(S), r = t, u = c.length > 0, s = S.length > 0, a = M.slice()
                                } else s = m(w.matches[_] || n.matches[_], [_].concat(l), h);
                                if (s) return !0
                            } else if (s.isQuantifier && h !== n.matches[e.inArray(s, n.matches) - 1]) for (var G = s, H = a.length > 0 ? a.shift() : 0; H < (isNaN(G.quantifier.max) ? H + 1 : G.quantifier.max) && r <= t; H++) {
                                var V = n.matches[e.inArray(G, n.matches) - 1];
                                if (s = m(V, [H].concat(l), V)) {
                                    if ((o = c[c.length - 1].match).optionalQuantifier = H >= G.quantifier.min, o.jit = (H || 1) * V.matches.indexOf(o) >= G.quantifier.jit, o.optionalQuantifier && g(o, V)) {
                                        u = !0, r = t;
                                        break
                                    }
                                    return o.jit && (P().jitOffset[t] = V.matches.indexOf(o)), !0
                                }
                            } else if (s = f(s, a, l, h)) return !0
                        } else r++;
                        var z, U
                    }

                    for (var h = a.length > 0 ? a.shift() : 0; h < n.matches.length; h++) if (!0 !== n.matches[h].isQuantifier) {
                        var g = m(n.matches[h], [h].concat(s), l);
                        if (g && r === t) return g;
                        if (r > t) break
                    }
                }

                if (t > -1) {
                    if (n === i) {
                        for (var m, h = t - 1; (m = P().validPositions[h] || P().tests[h]) === i && h > -1;) h--;
                        m !== i && h > -1 && (l = function (t, n) {
                            var a = [];
                            return e.isArray(n) || (n = [n]), n.length > 0 && (n[0].alternation === i ? 0 === (a = I(t, n.slice()).locator.slice()).length && (a = n[0].locator.slice()) : e.each(n, (function (e, t) {
                                if ("" !== t.def) if (0 === a.length) a = t.locator.slice(); else for (var i = 0; i < a.length; i++) t.locator[i] && -1 === a[i].toString().indexOf(t.locator[i]) && (a[i] += "," + t.locator[i])
                            }))), a
                        }(h, m), d = l.join(""), r = h)
                    }
                    if (P().tests[t] && P().tests[t][0].cd === d) return P().tests[t];
                    for (var g = l.shift(); g < s.length && !(f(s[g], l, [g]) && r === t || r > t); g++) ;
                }
                return (0 === c.length || u) && c.push({
                    match: {
                        fn: null,
                        optionality: !1,
                        casing: null,
                        def: "",
                        placeholder: ""
                    }, locator: [], mloc: {}, cd: d
                }), n !== i && P().tests[t] ? e.extend(!0, [], c) : (P().tests[t] = e.extend(!0, [], c), P().tests[t])
            }

            function q() {
                return P()._buffer === i && (P()._buffer = C(!1, 1), P().buffer === i && (P().buffer = P()._buffer.slice())), P()._buffer
            }

            function R(e) {
                return P().buffer !== i && !0 !== e || (P().buffer = C(!0, M(), !0), P()._buffer === i && (P()._buffer = P().buffer.slice())), P().buffer
            }

            function B(e, t, n) {
                var a, o;
                if (!0 === e) L(), e = 0, t = n.length; else for (a = e; a < t; a++) delete P().validPositions[a];
                for (o = e, a = e; a < t; a++) if (L(!0), n[a] !== p.skipOptionalPartCharacter) {
                    var s = V(o, n[a], !0, !0);
                    !1 !== s && (L(!0), o = s.caret !== i ? s.caret : s.pos + 1)
                }
            }

            function N(t, i, n) {
                switch (p.casing || i.casing) {
                    case"upper":
                        t = t.toUpperCase();
                        break;
                    case"lower":
                        t = t.toLowerCase();
                        break;
                    case"title":
                        var a = P().validPositions[n - 1];
                        t = 0 === n || a && a.input === String.fromCharCode(u.keyCode.SPACE) ? t.toUpperCase() : t.toLowerCase();
                        break;
                    default:
                        if (e.isFunction(p.casing)) {
                            var o = Array.prototype.slice.call(arguments);
                            o.push(P().validPositions), t = p.casing.apply(this, o)
                        }
                }
                return t
            }

            function G(t, n, a) {
                for (var o, s = p.greedy ? n : n.slice(0, 1), r = !1, l = a !== i ? a.split(",") : [], c = 0; c < l.length; c++) -1 !== (o = t.indexOf(l[c])) && t.splice(o, 1);
                for (var u = 0; u < t.length; u++) if (-1 !== e.inArray(t[u], s)) {
                    r = !0;
                    break
                }
                return r
            }

            function H(t, n, a, o, s) {
                var r, l, c, u, d, p, f, m = e.extend(!0, {}, P().validPositions), h = !1, g = s !== i ? s : M();
                if (-1 === g && s === i) l = (u = T(r = 0)).alternation; else for (; g >= 0; g--) if ((c = P().validPositions[g]) && c.alternation !== i) {
                    if (u && u.locator[c.alternation] !== c.locator[c.alternation]) break;
                    r = g, l = P().validPositions[r].alternation, u = c
                }
                if (l !== i) {
                    f = parseInt(r), P().excludes[f] = P().excludes[f] || [], !0 !== t && P().excludes[f].push($(u));
                    var v = [], y = 0;
                    for (d = f; d < M(i, !0) + 1; d++) (p = P().validPositions[d]) && !0 !== p.generatedInput ? v.push(p.input) : d < t && y++, delete P().validPositions[d];
                    for (; P().excludes[f] && P().excludes[f].length < 10;) {
                        var k = -1 * y, b = v.slice();
                        for (P().tests[f] = i, L(!0), h = !0; b.length > 0;) {
                            var x = b.shift();
                            if (!(h = V(M(i, !0) + 1, x, !1, o, !0))) break
                        }
                        if (h && n !== i) {
                            var w = M(t) + 1;
                            for (d = f; d < M() + 1; d++) ((p = P().validPositions[d]) === i || null == p.match.fn) && d < t + k && k++;
                            h = V((t += k) > w ? w : t, n, a, o, !0)
                        }
                        if (h) break;
                        if (L(), u = T(f), P().validPositions = e.extend(!0, {}, m), !P().excludes[f]) {
                            h = H(t, n, a, o, f - 1);
                            break
                        }
                        var S = $(u);
                        if (-1 !== P().excludes[f].indexOf(S)) {
                            h = H(t, n, a, o, f - 1);
                            break
                        }
                        for (P().excludes[f].push(S), d = f; d < M(i, !0) + 1; d++) delete P().validPositions[d]
                    }
                }
                return P().excludes[f] = i, h
            }

            function V(t, n, a, o, s, r) {
                function l(e) {
                    return w ? e.begin - e.end > 1 || e.begin - e.end == 1 : e.end - e.begin > 1 || e.end - e.begin == 1
                }

                a = !0 === a;
                var c = t;

                function u(n, a, s) {
                    var r = !1;
                    return e.each(F(n), (function (c, u) {
                        var d = u.match;
                        if (R(!0), !1 !== (r = null != d.fn ? d.fn.test(a, P(), n, s, p, l(t)) : (a === d.def || a === p.skipOptionalPartCharacter) && "" !== d.def && {
                            c: J(n, d, !0) || d.def,
                            pos: n
                        })) {
                            var f = r.c !== i ? r.c : a, m = n;
                            return f = f === p.skipOptionalPartCharacter && null === d.fn ? J(n, d, !0) || d.def : f, r.remove !== i && (e.isArray(r.remove) || (r.remove = [r.remove]), e.each(r.remove.sort((function (e, t) {
                                return t - e
                            })), (function (e, t) {
                                U({begin: t, end: t + 1})
                            }))), r.insert !== i && (e.isArray(r.insert) || (r.insert = [r.insert]), e.each(r.insert.sort((function (e, t) {
                                return e - t
                            })), (function (e, t) {
                                V(t.pos, t.c, !0, o)
                            }))), !0 !== r && r.pos !== i && r.pos !== n && (m = r.pos), !0 !== r && r.pos === i && r.c === i || U(t, e.extend({}, u, {input: N(f, d, m)}), o, m) || (r = !1), !1
                        }
                    })), r
                }

                t.begin !== i && (c = w ? t.end : t.begin);
                var d = !0, f = e.extend(!0, {}, P().validPositions);
                if (e.isFunction(p.preValidation) && !a && !0 !== o && !0 !== r && (d = p.preValidation(R(), c, n, l(t), p, P())), !0 === d) {
                    if (z(i, c, !0), (v === i || c < v) && (d = u(c, n, a), (!a || !0 === o) && !1 === d && !0 !== r)) {
                        var m = P().validPositions[c];
                        if (!m || null !== m.match.fn || m.match.def !== n && n !== p.skipOptionalPartCharacter) {
                            if ((p.insertMode || P().validPositions[W(c)] === i) && (!K(c, !0) || P().jitOffset[c])) if (P().jitOffset[c] && P().validPositions[W(c)] === i) !1 !== (d = V(c + P().jitOffset[c], n, a)) && (d.caret = c); else for (var h = c + 1, g = W(c); h <= g; h++) if (!1 !== (d = u(h, n, a))) {
                                d = z(c, d.pos !== i ? d.pos : h) || d, c = h;
                                break
                            }
                        } else d = {caret: W(c)}
                    }
                    !1 !== d || !1 === p.keepStatic || null != p.regex && !re(R()) || a || !0 === s || (d = H(c, n, a, o)), !0 === d && (d = {pos: c})
                }
                if (e.isFunction(p.postValidation) && !1 !== d && !a && !0 !== o && !0 !== r) {
                    var y = p.postValidation(R(!0), t.begin !== i ? w ? t.end : t.begin : t, d, p);
                    if (y !== i) {
                        if (y.refreshFromBuffer && y.buffer) {
                            var k = y.refreshFromBuffer;
                            B(!0 === k ? k : k.start, k.end, y.buffer)
                        }
                        d = !0 === y ? d : y
                    }
                }
                return d && d.pos === i && (d.pos = c), !1 !== d && !0 !== r || (L(!0), P().validPositions = e.extend(!0, {}, f)), d
            }

            function z(t, n, a) {
                var o;
                if (t === i) for (t = n - 1; t > 0 && !P().validPositions[t]; t--) ;
                for (var s = t; s < n; s++) if (P().validPositions[s] === i && !K(s, !0) && (0 == s ? T(s) : P().validPositions[s - 1])) {
                    var r = F(s).slice();
                    "" === r[r.length - 1].match.def && r.pop();
                    var l = I(s, r);
                    if ((l = e.extend({}, l, {input: J(s, l.match, !0) || l.match.def})).generatedInput = !0, U(s, l, !0), !0 !== a) {
                        var c = P().validPositions[n].input;
                        P().validPositions[n] = i, o = V(n, c, !0, !0)
                    }
                }
                return o
            }

            function U(t, n, a, o) {
                function s(e, t, n) {
                    var a = t[e];
                    if (a !== i && (null === a.match.fn && !0 !== a.match.optionality || a.input === p.radixPoint)) {
                        var o = n.begin <= e - 1 ? t[e - 1] && null === t[e - 1].match.fn && t[e - 1] : t[e - 1],
                            s = n.end > e + 1 ? t[e + 1] && null === t[e + 1].match.fn && t[e + 1] : t[e + 1];
                        return o && s
                    }
                    return !1
                }

                var r = t.begin !== i ? t.begin : t, l = t.end !== i ? t.end : t;
                if (t.begin > t.end && (r = t.end, l = t.begin), o = o !== i ? o : r, r !== l || p.insertMode && P().validPositions[o] !== i && a === i) {
                    var c = e.extend(!0, {}, P().validPositions), u = M(i, !0);
                    for (P().p = r, g = u; g >= r; g--) P().validPositions[g] && "+" === P().validPositions[g].match.nativeDef && (p.isNegative = !1), delete P().validPositions[g];
                    var d = !0, f = o, m = (P().validPositions, !1), h = f, g = f;
                    for (n && (P().validPositions[o] = e.extend(!0, {}, n), h++, f++, r < l && g++); g <= u; g++) {
                        var v = c[g];
                        if (v !== i && (g >= l || g >= r && !0 !== v.generatedInput && s(g, c, {begin: r, end: l}))) {
                            for (; "" !== T(h).match.def;) {
                                if (!1 === m && c[h] && c[h].match.nativeDef === v.match.nativeDef) P().validPositions[h] = e.extend(!0, {}, c[h]), P().validPositions[h].input = v.input, z(i, h, !0), f = h + 1, d = !0; else if (p.shiftPositions && j(h, v.match.def)) {
                                    var y = V(h, v.input, !0, !0);
                                    d = !1 !== y, f = y.caret || y.insert ? M() : h + 1, m = !0
                                } else d = !0 === v.generatedInput || v.input === p.radixPoint && !0 === p.numericInput;
                                if (d) break;
                                if (!d && h > l && K(h, !0) && (null !== v.match.fn || h > P().maskLength)) break;
                                h++
                            }
                            "" == T(h).match.def && (d = !1), h = f
                        }
                        if (!d) break
                    }
                    if (!d) return P().validPositions = e.extend(!0, {}, c), L(!0), !1
                } else n && (P().validPositions[o] = e.extend(!0, {}, n));
                return L(!0), !0
            }

            function K(e, t) {
                var i = O(e).match;
                if ("" === i.def && (i = T(e).match), null != i.fn) return i.fn;
                if (!0 !== t && e > -1) {
                    var n = F(e);
                    return n.length > 1 + ("" === n[n.length - 1].match.def ? 1 : 0)
                }
                return !1
            }

            function W(e, t) {
                for (var i = e + 1; "" !== T(i).match.def && (!0 === t && (!0 !== T(i).match.newBlockMarker || !K(i)) || !0 !== t && !K(i));) i++;
                return i
            }

            function Q(e, t) {
                var i, n = e;
                if (n <= 0) return 0;
                for (; --n > 0 && (!0 === t && !0 !== T(n).match.newBlockMarker || !0 !== t && !K(n) && ((i = F(n)).length < 2 || 2 === i.length && "" === i[1].match.def));) ;
                return n
            }

            function Z(t, n, a, o, s) {
                if (o && e.isFunction(p.onBeforeWrite)) {
                    var r = p.onBeforeWrite.call(b, o, n, a, p);
                    if (r) {
                        if (r.refreshFromBuffer) {
                            var l = r.refreshFromBuffer;
                            B(!0 === l ? l : l.start, l.end, r.buffer || n), n = R(!0)
                        }
                        a !== i && (a = r.caret !== i ? r.caret : a)
                    }
                }
                if (t !== i && (t.inputmask._valueSet(n.join("")), a === i || o !== i && "blur" === o.type ? ue(t, a, 0 === n.length) : ae(t, a), !0 === s)) {
                    var c = e(t), u = t.inputmask._valueGet();
                    E = !0, c.trigger("input"), setTimeout((function () {
                        u === q().join("") ? c.trigger("cleared") : !0 === re(n) && c.trigger("complete")
                    }), 0)
                }
            }

            function J(t, n, a) {
                if ((n = n || T(t).match).placeholder !== i || !0 === a) return e.isFunction(n.placeholder) ? n.placeholder(p) : n.placeholder;
                if (null === n.fn) {
                    if (t > -1 && P().validPositions[t] === i) {
                        var o, s = F(t), r = [];
                        if (s.length > 1 + ("" === s[s.length - 1].match.def ? 1 : 0)) for (var l = 0; l < s.length; l++) if (!0 !== s[l].match.optionality && !0 !== s[l].match.optionalQuantifier && (null === s[l].match.fn || o === i || !1 !== s[l].match.fn.test(o.match.def, P(), t, !0, p)) && (r.push(s[l]), null === s[l].match.fn && (o = s[l]), r.length > 1 && /[0-9a-bA-Z]/.test(r[0].match.def))) return p.placeholder.charAt(t % p.placeholder.length)
                    }
                    return n.def
                }
                return p.placeholder.charAt(t % p.placeholder.length)
            }

            function Y(e, t) {
                if (o) {
                    if (e.inputmask._valueGet() !== t && (e.placeholder !== t || "" === e.placeholder)) {
                        var i = R().slice(), n = e.inputmask._valueGet();
                        if (n !== t) {
                            var a = M();
                            -1 === a && n === q().join("") ? i = [] : -1 !== a && se(i), Z(e, i)
                        }
                    }
                } else e.placeholder !== t && (e.placeholder = t, "" === e.placeholder && e.removeAttribute("placeholder"))
            }

            var X, ee = {
                on: function (t, n, a) {
                    var o = function (t) {
                        var n = this;
                        if (n.inputmask === i && "FORM" !== this.nodeName) {
                            var o = e.data(n, "_inputmask_opts");
                            o ? new u(o).mask(n) : ee.off(n)
                        } else {
                            if ("setvalue" === t.type || "FORM" === this.nodeName || !(n.disabled || n.readOnly && !("keydown" === t.type && t.ctrlKey && 67 === t.keyCode || !1 === p.tabThrough && t.keyCode === u.keyCode.TAB))) {
                                switch (t.type) {
                                    case"input":
                                        if (!0 === E) return E = !1, t.preventDefault();
                                        if (r) {
                                            var s = arguments;
                                            return setTimeout((function () {
                                                a.apply(n, s), ae(n, n.inputmask.caretPos, i, !0)
                                            }), 0), !1
                                        }
                                        break;
                                    case"keydown":
                                        S = !1, E = !1;
                                        break;
                                    case"keypress":
                                        if (!0 === S) return t.preventDefault();
                                        S = !0;
                                        break;
                                    case"click":
                                        if (l || c) return s = arguments, setTimeout((function () {
                                            a.apply(n, s)
                                        }), 0), !1
                                }
                                var d = a.apply(n, arguments);
                                return !1 === d && (t.preventDefault(), t.stopPropagation()), d
                            }
                            t.preventDefault()
                        }
                    };
                    t.inputmask.events[n] = t.inputmask.events[n] || [], t.inputmask.events[n].push(o), -1 !== e.inArray(n, ["submit", "reset"]) ? null !== t.form && e(t.form).on(n, o) : e(t).on(n, o)
                }, off: function (t, i) {
                    var n;
                    t.inputmask && t.inputmask.events && (i ? (n = [])[i] = t.inputmask.events[i] : n = t.inputmask.events, e.each(n, (function (i, n) {
                        for (; n.length > 0;) {
                            var a = n.pop();
                            -1 !== e.inArray(i, ["submit", "reset"]) ? null !== t.form && e(t.form).off(i, a) : e(t).off(i, a)
                        }
                        delete t.inputmask.events[i]
                    })))
                }
            }, te = {
                keydownEvent: function (t) {
                    var i = e(this), n = t.keyCode, a = ae(this);
                    if (n === u.keyCode.BACKSPACE || n === u.keyCode.DELETE || c && n === u.keyCode.BACKSPACE_SAFARI || t.ctrlKey && n === u.keyCode.X && !f("cut")) t.preventDefault(), le(0, n, a), Z(this, R(!0), P().p, t, this.inputmask._valueGet() !== R().join("")); else if (n === u.keyCode.END || n === u.keyCode.PAGE_DOWN) {
                        t.preventDefault();
                        var o = W(M());
                        ae(this, t.shiftKey ? a.begin : o, o, !0)
                    } else n === u.keyCode.HOME && !t.shiftKey || n === u.keyCode.PAGE_UP ? (t.preventDefault(), ae(this, 0, t.shiftKey ? a.begin : 0, !0)) : (p.undoOnEscape && n === u.keyCode.ESCAPE || 90 === n && t.ctrlKey) && !0 !== t.altKey ? (ie(this, !0, !1, h.split("")), i.trigger("click")) : n !== u.keyCode.INSERT || t.shiftKey || t.ctrlKey ? !0 === p.tabThrough && n === u.keyCode.TAB && (!0 === t.shiftKey ? (null === T(a.begin).match.fn && (a.begin = W(a.begin)), a.end = Q(a.begin, !0), a.begin = Q(a.end, !0)) : (a.begin = W(a.begin, !0), a.end = W(a.begin, !0), a.end < P().maskLength && a.end--), a.begin < P().maskLength && (t.preventDefault(), ae(this, a.begin, a.end))) : (p.insertMode = !p.insertMode, this.setAttribute("im-insert", p.insertMode));
                    p.onKeyDown.call(this, t, R(), ae(this).begin, p), A = -1 !== e.inArray(n, p.ignorables)
                }, keypressEvent: function (t, n, a, o, s) {
                    var r = this, l = e(r), c = t.which || t.charCode || t.keyCode;
                    if (!(!0 === n || t.ctrlKey && t.altKey) && (t.ctrlKey || t.metaKey || A)) return c === u.keyCode.ENTER && h !== R().join("") && (h = R().join(""), setTimeout((function () {
                        l.trigger("change")
                    }), 0)), !0;
                    if (c) {
                        46 === c && !1 === t.shiftKey && "" !== p.radixPoint && (c = p.radixPoint.charCodeAt(0));
                        var d, f = n ? {begin: s, end: s} : ae(r), m = String.fromCharCode(c), g = 0;
                        if (p._radixDance && p.numericInput) {
                            var v = R().indexOf(p.radixPoint.charAt(0)) + 1;
                            f.begin <= v && (c === p.radixPoint.charCodeAt(0) && (g = 1), f.begin -= 1, f.end -= 1)
                        }
                        P().writeOutBuffer = !0;
                        var y = V(f, m, o);
                        if (!1 !== y && (L(!0), d = y.caret !== i ? y.caret : W(y.pos.begin ? y.pos.begin : y.pos), P().p = d), d = (p.numericInput && y.caret === i ? Q(d) : d) + g, !1 !== a && (setTimeout((function () {
                            p.onKeyValidation.call(r, c, y, p)
                        }), 0), P().writeOutBuffer && !1 !== y)) {
                            var k = R();
                            Z(r, k, d, t, !0 !== n)
                        }
                        if (t.preventDefault(), n) return !1 !== y && (y.forwardPosition = d), y
                    }
                }, pasteEvent: function (i) {
                    var n, a = i.originalEvent || i, o = (e(this), this.inputmask._valueGet(!0)), s = ae(this);
                    w && (n = s.end, s.end = s.begin, s.begin = n);
                    var r = o.substr(0, s.begin), l = o.substr(s.end, o.length);
                    if (r === (w ? q().reverse() : q()).slice(0, s.begin).join("") && (r = ""), l === (w ? q().reverse() : q()).slice(s.end).join("") && (l = ""), t.clipboardData && t.clipboardData.getData) o = r + t.clipboardData.getData("Text") + l; else {
                        if (!a.clipboardData || !a.clipboardData.getData) return !0;
                        o = r + a.clipboardData.getData("text/plain") + l
                    }
                    var c = o;
                    if (e.isFunction(p.onBeforePaste)) {
                        if (!1 === (c = p.onBeforePaste.call(b, o, p))) return i.preventDefault();
                        c || (c = o)
                    }
                    return ie(this, !1, !1, c.toString().split("")), Z(this, R(), W(M()), i, h !== R().join("")), i.preventDefault()
                }, inputFallBackEvent: function (t) {
                    var i = this, n = i.inputmask._valueGet();
                    if (R().join("") !== n) {
                        var a = ae(i);
                        if (n = function (e, t, i) {
                            if (l) {
                                var n = t.replace(R().join(""), "");
                                if (1 === n.length) {
                                    var a = t.split("");
                                    a.splice(i.begin, 0, n), t = a.join("")
                                }
                            }
                            return t
                        }(0, n = function (e, t, i) {
                            return "." === t.charAt(i.begin - 1) && "" !== p.radixPoint && ((t = t.split(""))[i.begin - 1] = p.radixPoint.charAt(0), t = t.join("")), t
                        }(0, n, a), a), R().join("") !== n) {
                            var o = R().join(""), s = !p.numericInput && n.length > o.length ? -1 : 0,
                                r = n.substr(0, a.begin), c = n.substr(a.begin), d = o.substr(0, a.begin + s),
                                f = o.substr(a.begin + s), m = a, h = "", g = !1;
                            if (r !== d) {
                                var v, y = (g = r.length >= d.length) ? r.length : d.length;
                                for (v = 0; r.charAt(v) === d.charAt(v) && v < y; v++) ;
                                g && (m.begin = v - s, h += r.slice(v, m.end))
                            }
                            if (c !== f && (c.length > f.length ? h += c.slice(0, 1) : c.length < f.length && (m.end += f.length - c.length, g || "" === p.radixPoint || "" !== c || r.charAt(m.begin + s - 1) !== p.radixPoint || (m.begin--, h = p.radixPoint))), Z(i, R(), {
                                begin: m.begin + s,
                                end: m.end + s
                            }), h.length > 0) e.each(h.split(""), (function (t, n) {
                                var a = new e.Event("keypress");
                                a.which = n.charCodeAt(0), A = !1, te.keypressEvent.call(i, a)
                            })); else {
                                m.begin === m.end - 1 && (m.begin = Q(m.begin + 1), m.begin === m.end - 1 ? ae(i, m.begin) : ae(i, m.begin, m.end));
                                var k = new e.Event("keydown");
                                k.keyCode = p.numericInput ? u.keyCode.BACKSPACE : u.keyCode.DELETE, te.keydownEvent.call(i, k)
                            }
                            t.preventDefault()
                        }
                    }
                }, beforeInputEvent: function (t) {
                    if (t.cancelable) {
                        var i = this;
                        switch (t.inputType) {
                            case"insertText":
                                return e.each(t.data.split(""), (function (t, n) {
                                    var a = new e.Event("keypress");
                                    a.which = n.charCodeAt(0), A = !1, te.keypressEvent.call(i, a)
                                })), t.preventDefault();
                            case"deleteContentBackward":
                                return (n = new e.Event("keydown")).keyCode = u.keyCode.BACKSPACE, te.keydownEvent.call(i, n), t.preventDefault();
                            case"deleteContentForward":
                                var n;
                                return (n = new e.Event("keydown")).keyCode = u.keyCode.DELETE, te.keydownEvent.call(i, n), t.preventDefault()
                        }
                    }
                }, setValueEvent: function (t) {
                    this.inputmask.refreshValue = !1;
                    var i = this, n = (n = t && t.detail ? t.detail[0] : arguments[1]) || i.inputmask._valueGet(!0);
                    e.isFunction(p.onBeforeMask) && (n = p.onBeforeMask.call(b, n, p) || n), ie(i, !0, !1, n = n.split("")), h = R().join(""), (p.clearMaskOnLostFocus || p.clearIncomplete) && i.inputmask._valueGet() === q().join("") && i.inputmask._valueSet("")
                }, focusEvent: function (e) {
                    var t = this.inputmask._valueGet();
                    p.showMaskOnFocus && (t !== R().join("") ? Z(this, R(), W(M())) : !1 === _ && ae(this, W(M()))), !0 === p.positionCaretOnTab && !1 === _ && te.clickEvent.apply(this, [e, !0]), h = R().join("")
                }, mouseleaveEvent: function (e) {
                    _ = !1, p.clearMaskOnLostFocus && n.activeElement !== this && Y(this, k)
                }, clickEvent: function (t, a) {
                    var o = this;
                    setTimeout((function () {
                        if (n.activeElement === o) {
                            var t = ae(o);
                            if (a && (w ? t.end = t.begin : t.begin = t.end), t.begin === t.end) switch (p.positionCaretOnClick) {
                                case"none":
                                    break;
                                case"select":
                                    ae(o, 0, R().length);
                                    break;
                                case"ignore":
                                    ae(o, W(M()));
                                    break;
                                case"radixFocus":
                                    if (function (t) {
                                        if ("" !== p.radixPoint) {
                                            var n = P().validPositions;
                                            if (n[t] === i || n[t].input === J(t)) {
                                                if (t < W(-1)) return !0;
                                                var a = e.inArray(p.radixPoint, R());
                                                if (-1 !== a) {
                                                    for (var o in n) if (a < o && n[o].input !== J(o)) return !1;
                                                    return !0
                                                }
                                            }
                                        }
                                        return !1
                                    }(t.begin)) {
                                        var s = R().join("").indexOf(p.radixPoint);
                                        ae(o, p.numericInput ? W(s) : s);
                                        break
                                    }
                                default:
                                    var r = t.begin, l = M(r, !0), c = W(l);
                                    if (r < c) ae(o, K(r, !0) || K(r - 1, !0) ? r : W(r)); else {
                                        var u = P().validPositions[l], d = O(c, u ? u.match.locator : i, u),
                                            f = J(c, d.match);
                                        if ("" !== f && R()[c] !== f && !0 !== d.match.optionalQuantifier && !0 !== d.match.newBlockMarker || !K(c, p.keepStatic) && d.match.def === f) {
                                            var m = W(c);
                                            (r >= m || r === c) && (c = m)
                                        }
                                        ae(o, c)
                                    }
                            }
                        }
                    }), 0)
                }, cutEvent: function (i) {
                    e(this);
                    var a = ae(this), o = i.originalEvent || i, s = t.clipboardData || o.clipboardData,
                        r = w ? R().slice(a.end, a.begin) : R().slice(a.begin, a.end);
                    s.setData("text", w ? r.reverse().join("") : r.join("")), n.execCommand && n.execCommand("copy"), le(0, u.keyCode.DELETE, a), Z(this, R(), P().p, i, h !== R().join(""))
                }, blurEvent: function (t) {
                    var n = e(this);
                    if (this.inputmask) {
                        Y(this, k);
                        var a = this.inputmask._valueGet(), o = R().slice();
                        "" === a && y === i || (p.clearMaskOnLostFocus && (-1 === M() && a === q().join("") ? o = [] : se(o)), !1 === re(o) && (setTimeout((function () {
                            n.trigger("incomplete")
                        }), 0), p.clearIncomplete && (L(), o = p.clearMaskOnLostFocus ? [] : q().slice())), Z(this, o, i, t)), h !== R().join("") && (h = o.join(""), n.trigger("change"))
                    }
                }, mouseenterEvent: function (e) {
                    _ = !0, n.activeElement !== this && p.showMaskOnHover && Y(this, (w ? R().slice().reverse() : R()).join(""))
                }, submitEvent: function (e) {
                    h !== R().join("") && g.trigger("change"), p.clearMaskOnLostFocus && -1 === M() && x.inputmask._valueGet && x.inputmask._valueGet() === q().join("") && x.inputmask._valueSet(""), p.clearIncomplete && !1 === re(R()) && x.inputmask._valueSet(""), p.removeMaskOnSubmit && (x.inputmask._valueSet(x.inputmask.unmaskedvalue(), !0), setTimeout((function () {
                        Z(x, R())
                    }), 0))
                }, resetEvent: function (e) {
                    x.inputmask.refreshValue = !0, setTimeout((function () {
                        g.trigger("setvalue")
                    }), 0)
                }
            };

            function ie(t, n, a, o, s) {
                var r = this || t.inputmask, l = o.slice(), c = "", d = -1, f = i;
                if (L(), a || !0 === p.autoUnmask) d = W(d); else {
                    var m = q().slice(0, W(-1)).join(""), h = l.join("").match(new RegExp("^" + u.escapeRegex(m), "g"));
                    h && h.length > 0 && (l.splice(0, h.length * m.length), d = W(d))
                }
                -1 === d ? (P().p = W(d), d = 0) : P().p = d, r.caretPos = {begin: d}, e.each(l, (function (n, o) {
                    if (o !== i) if (P().validPositions[n] === i && l[n] === J(n) && K(n, !0) && !1 === V(n, l[n], !0, i, i, !0)) P().p++; else {
                        var s = new e.Event("_checkval");
                        s.which = o.charCodeAt(0), c += o;
                        var u = M(i, !0);
                        !function (e, t) {
                            return -1 !== C(!0, 0, !1).slice(e, W(e)).join("").replace(/'/g, "").indexOf(t) && !K(e) && (T(e).match.nativeDef === t.charAt(0) || null === T(e).match.fn && T(e).match.nativeDef === "'" + t.charAt(0) || " " === T(e).match.nativeDef && (T(e + 1).match.nativeDef === t.charAt(0) || null === T(e + 1).match.fn && T(e + 1).match.nativeDef === "'" + t.charAt(0)))
                        }(d, c) ? (f = te.keypressEvent.call(t, s, !0, !1, a, r.caretPos.begin)) && (d = r.caretPos.begin + 1, c = "") : f = te.keypressEvent.call(t, s, !0, !1, a, u + 1), f && (Z(i, R(), f.forwardPosition, s, !1), r.caretPos = {
                            begin: f.forwardPosition,
                            end: f.forwardPosition
                        })
                    }
                })), n && Z(t, R(), f ? f.forwardPosition : i, s || new e.Event("checkval"), s && "input" === s.type)
            }

            function ne(t) {
                if (t) {
                    if (t.inputmask === i) return t.value;
                    t.inputmask && t.inputmask.refreshValue && te.setValueEvent.call(t)
                }
                var n = [], a = P().validPositions;
                for (var o in a) a[o].match && null != a[o].match.fn && n.push(a[o].input);
                var s = 0 === n.length ? "" : (w ? n.reverse() : n).join("");
                if (e.isFunction(p.onUnMask)) {
                    var r = (w ? R().slice().reverse() : R()).join("");
                    s = p.onUnMask.call(b, r, s, p)
                }
                return s
            }

            function ae(a, o, s, r) {
                function l(e) {
                    return !w || "number" != typeof e || p.greedy && "" === p.placeholder || !x || (e = x.inputmask._valueGet().length - e), e
                }

                var c;
                if (o === i) return "selectionStart" in a ? (o = a.selectionStart, s = a.selectionEnd) : t.getSelection ? (c = t.getSelection().getRangeAt(0)).commonAncestorContainer.parentNode !== a && c.commonAncestorContainer !== a || (o = c.startOffset, s = c.endOffset) : n.selection && n.selection.createRange && (s = (o = 0 - (c = n.selection.createRange()).duplicate().moveStart("character", -a.inputmask._valueGet().length)) + c.text.length), {
                    begin: r ? o : l(o),
                    end: r ? s : l(s)
                };
                if (e.isArray(o) && (s = w ? o[0] : o[1], o = w ? o[1] : o[0]), o.begin !== i && (s = w ? o.begin : o.end, o = w ? o.end : o.begin), "number" == typeof o) {
                    o = r ? o : l(o), s = "number" == typeof (s = r ? s : l(s)) ? s : o;
                    var u = parseInt(((a.ownerDocument.defaultView || t).getComputedStyle ? (a.ownerDocument.defaultView || t).getComputedStyle(a, null) : a.currentStyle).fontSize) * s;
                    if (a.scrollLeft = u > a.scrollWidth ? u : 0, a.inputmask.caretPos = {
                        begin: o,
                        end: s
                    }, a === n.activeElement) {
                        if ("selectionStart" in a) a.selectionStart = o, a.selectionEnd = s; else if (t.getSelection) {
                            if (c = n.createRange(), a.firstChild === i || null === a.firstChild) {
                                var d = n.createTextNode("");
                                a.appendChild(d)
                            }
                            c.setStart(a.firstChild, o < a.inputmask._valueGet().length ? o : a.inputmask._valueGet().length), c.setEnd(a.firstChild, s < a.inputmask._valueGet().length ? s : a.inputmask._valueGet().length), c.collapse(!0);
                            var f = t.getSelection();
                            f.removeAllRanges(), f.addRange(c)
                        } else a.createTextRange && ((c = a.createTextRange()).collapse(!0), c.moveEnd("character", s), c.moveStart("character", o), c.select());
                        ue(a, {begin: o, end: s})
                    }
                }
            }

            function oe(t) {
                var n, a, o = C(!0, M(), !0, !0), s = o.length, r = M(), l = {}, c = P().validPositions[r],
                    u = c !== i ? c.locator.slice() : i;
                for (n = r + 1; n < o.length; n++) u = (a = O(n, u, n - 1)).locator.slice(), l[n] = e.extend(!0, {}, a);
                var d = c && c.alternation !== i ? c.locator[c.alternation] : i;
                for (n = s - 1; n > r && ((a = l[n]).match.optionality || a.match.optionalQuantifier && a.match.newBlockMarker || d && (d !== l[n].locator[c.alternation] && null != a.match.fn || null === a.match.fn && a.locator[c.alternation] && G(a.locator[c.alternation].toString().split(","), d.toString().split(",")) && "" !== F(n)[0].def)) && o[n] === J(n, a.match); n--) s--;
                return t ? {l: s, def: l[s] ? l[s].match : i} : s
            }

            function se(e) {
                e.length = 0;
                for (var t, n = C(!0, 0, !0, i, !0); (t = n.shift()) !== i;) e.push(t);
                return e
            }

            function re(t) {
                if (e.isFunction(p.isComplete)) return p.isComplete(t, p);
                if ("*" === p.repeat) return i;
                var n = !1, a = oe(!0), o = Q(a.l);
                if (a.def === i || a.def.newBlockMarker || a.def.optionality || a.def.optionalQuantifier) {
                    n = !0;
                    for (var s = 0; s <= o; s++) {
                        var r = O(s).match;
                        if (null !== r.fn && P().validPositions[s] === i && !0 !== r.optionality && !0 !== r.optionalQuantifier || null === r.fn && t[s] !== J(s, r)) {
                            n = !1;
                            break
                        }
                    }
                }
                return n
            }

            function le(e, t, n, a, o) {
                if ((p.numericInput || w) && (t === u.keyCode.BACKSPACE ? t = u.keyCode.DELETE : t === u.keyCode.DELETE && (t = u.keyCode.BACKSPACE), w)) {
                    var s = n.end;
                    n.end = n.begin, n.begin = s
                }
                if (t === u.keyCode.BACKSPACE && n.end - n.begin < 1 ? (n.begin = Q(n.begin), P().validPositions[n.begin] !== i && P().validPositions[n.begin].input === p.groupSeparator && n.begin--) : t === u.keyCode.DELETE && n.begin === n.end && (n.end = K(n.end, !0) && P().validPositions[n.end] && P().validPositions[n.end].input !== p.radixPoint ? n.end + 1 : W(n.end) + 1, P().validPositions[n.begin] !== i && P().validPositions[n.begin].input === p.groupSeparator && n.end++), U(n), !0 !== a && !1 !== p.keepStatic || null !== p.regex) {
                    var r = H(!0);
                    if (r) {
                        var l = r.caret !== i ? r.caret : r.pos ? W(r.pos.begin ? r.pos.begin : r.pos) : M(-1, !0);
                        (t !== u.keyCode.DELETE || n.begin > l) && n.begin
                    }
                }
                var c = M(n.begin, !0);
                if (c < n.begin || -1 === n.begin) P().p = W(c); else if (!0 !== a && (P().p = n.begin, !0 !== o)) for (; P().p < c && P().validPositions[P().p] === i;) P().p++
            }

            function ce(i) {
                var a = (i.ownerDocument.defaultView || t).getComputedStyle(i, null), o = n.createElement("div");
                o.style.width = a.width, o.style.textAlign = a.textAlign, y = n.createElement("div"), i.inputmask.colorMask = y, y.className = "im-colormask", i.parentNode.insertBefore(y, i), i.parentNode.removeChild(i), y.appendChild(i), y.appendChild(o), i.style.left = o.offsetLeft + "px", e(y).on("mouseleave", (function (e) {
                    return te.mouseleaveEvent.call(i, [e])
                })), e(y).on("mouseenter", (function (e) {
                    return te.mouseenterEvent.call(i, [e])
                })), e(y).on("click", (function (e) {
                    return ae(i, function (e) {
                        var t, o = n.createElement("span");
                        for (var s in a) isNaN(s) && -1 !== s.indexOf("font") && (o.style[s] = a[s]);
                        o.style.textTransform = a.textTransform, o.style.letterSpacing = a.letterSpacing, o.style.position = "absolute", o.style.height = "auto", o.style.width = "auto", o.style.visibility = "hidden", o.style.whiteSpace = "nowrap", n.body.appendChild(o);
                        var r, l = i.inputmask._valueGet(), c = 0;
                        for (t = 0, r = l.length; t <= r; t++) {
                            if (o.innerHTML += l.charAt(t) || "_", o.offsetWidth >= e) {
                                var u = e - c, d = o.offsetWidth - e;
                                o.innerHTML = l.charAt(t), t = (u -= o.offsetWidth / 3) < d ? t - 1 : t;
                                break
                            }
                            c = o.offsetWidth
                        }
                        return n.body.removeChild(o), t
                    }(e.clientX)), te.clickEvent.call(i, [e])
                }))
            }

            function ue(e, t, a) {
                var o, s, r, l = [], c = !1, u = 0;

                function d(e) {
                    if (e === i && (e = ""), c || null !== o.fn && s.input !== i) if (c && (null !== o.fn && s.input !== i || "" === o.def)) {
                        c = !1;
                        var t = l.length;
                        l[t - 1] = l[t - 1] + "</span>", l.push(e)
                    } else l.push(e); else c = !0, l.push("<span class='im-static'>" + e)
                }

                if (y !== i) {
                    var f = R();
                    if (t === i ? t = ae(e) : t.begin === i && (t = {begin: t, end: t}), !0 !== a) {
                        var m = M();
                        do {
                            P().validPositions[u] ? (s = P().validPositions[u], o = s.match, r = s.locator.slice(), d(f[u])) : (s = O(u, r, u - 1), o = s.match, r = s.locator.slice(), !1 === p.jitMasking || u < m || "number" == typeof p.jitMasking && isFinite(p.jitMasking) && p.jitMasking > u ? d(J(u, o)) : c = !1), u++
                        } while ((v === i || u < v) && (null !== o.fn || "" !== o.def) || m > u || c);
                        c && d(), n.activeElement === e && (l.splice(t.begin, 0, t.begin === t.end || t.end > P().maskLength ? '<mark class="im-caret" style="border-right-width: 1px;border-right-style: solid;">' : '<mark class="im-caret-select">'), l.splice(t.end + 1, 0, "</mark>"))
                    }
                    var h = y.getElementsByTagName("div")[0];
                    h.innerHTML = l.join(""), e.inputmask.positionColorMask(e, h)
                }
            }

            if (u.prototype.positionColorMask = function (e, t) {
                e.style.left = t.offsetLeft + "px"
            }, a !== i) switch (a.action) {
                case"isComplete":
                    return x = a.el, re(R());
                case"unmaskedvalue":
                    return x !== i && a.value === i || (X = a.value, X = (e.isFunction(p.onBeforeMask) && p.onBeforeMask.call(b, X, p) || X).split(""), ie.call(this, i, !1, !1, X), e.isFunction(p.onBeforeWrite) && p.onBeforeWrite.call(b, i, R(), 0, p)), ne(x);
                case"mask":
                    !function (t) {
                        ee.off(t);
                        var a = function (t, a) {
                            var o = t.getAttribute("type"),
                                r = "INPUT" === t.tagName && -1 !== e.inArray(o, a.supportsInputType) || t.isContentEditable || "TEXTAREA" === t.tagName;
                            if (!r) if ("INPUT" === t.tagName) {
                                var l = n.createElement("input");
                                l.setAttribute("type", o), r = "text" === l.type, l = null
                            } else r = "partial";
                            return !1 !== r ? function (t) {
                                var o, r;

                                function l() {
                                    return this.inputmask ? this.inputmask.opts.autoUnmask ? this.inputmask.unmaskedvalue() : -1 !== M() || !0 !== a.nullable ? n.activeElement === this && a.clearMaskOnLostFocus ? (w ? se(R().slice()).reverse() : se(R().slice())).join("") : o.call(this) : "" : o.call(this)
                                }

                                function c(t) {
                                    r.call(this, t), this.inputmask && e(this).trigger("setvalue", [t])
                                }

                                if (!t.inputmask.__valueGet) {
                                    if (!0 !== a.noValuePatching) {
                                        if (Object.getOwnPropertyDescriptor) {
                                            "function" != typeof Object.getPrototypeOf && (Object.getPrototypeOf = "object" === s("test".__proto__) ? function (e) {
                                                return e.__proto__
                                            } : function (e) {
                                                return e.constructor.prototype
                                            });
                                            var u = Object.getPrototypeOf ? Object.getOwnPropertyDescriptor(Object.getPrototypeOf(t), "value") : i;
                                            u && u.get && u.set ? (o = u.get, r = u.set, Object.defineProperty(t, "value", {
                                                get: l,
                                                set: c,
                                                configurable: !0
                                            })) : "INPUT" !== t.tagName && (o = function () {
                                                return this.textContent
                                            }, r = function (e) {
                                                this.textContent = e
                                            }, Object.defineProperty(t, "value", {get: l, set: c, configurable: !0}))
                                        } else n.__lookupGetter__ && t.__lookupGetter__("value") && (o = t.__lookupGetter__("value"), r = t.__lookupSetter__("value"), t.__defineGetter__("value", l), t.__defineSetter__("value", c));
                                        t.inputmask.__valueGet = o, t.inputmask.__valueSet = r
                                    }
                                    t.inputmask._valueGet = function (e) {
                                        return w && !0 !== e ? o.call(this.el).split("").reverse().join("") : o.call(this.el)
                                    }, t.inputmask._valueSet = function (e, t) {
                                        r.call(this.el, null === e || e === i ? "" : !0 !== t && w ? e.split("").reverse().join("") : e)
                                    }, o === i && (o = function () {
                                        return this.value
                                    }, r = function (e) {
                                        this.value = e
                                    }, function (t) {
                                        if (e.valHooks && (e.valHooks[t] === i || !0 !== e.valHooks[t].inputmaskpatch)) {
                                            var n = e.valHooks[t] && e.valHooks[t].get ? e.valHooks[t].get : function (e) {
                                                    return e.value
                                                },
                                                o = e.valHooks[t] && e.valHooks[t].set ? e.valHooks[t].set : function (e, t) {
                                                    return e.value = t, e
                                                };
                                            e.valHooks[t] = {
                                                get: function (e) {
                                                    if (e.inputmask) {
                                                        if (e.inputmask.opts.autoUnmask) return e.inputmask.unmaskedvalue();
                                                        var t = n(e);
                                                        return -1 !== M(i, i, e.inputmask.maskset.validPositions) || !0 !== a.nullable ? t : ""
                                                    }
                                                    return n(e)
                                                }, set: function (t, i) {
                                                    var n, a = e(t);
                                                    return n = o(t, i), t.inputmask && a.trigger("setvalue", [i]), n
                                                }, inputmaskpatch: !0
                                            }
                                        }
                                    }(t.type), function (t) {
                                        ee.on(t, "mouseenter", (function (t) {
                                            var i = e(this);
                                            this.inputmask._valueGet() !== R().join("") && i.trigger("setvalue")
                                        }))
                                    }(t))
                                }
                            }(t) : t.inputmask = i, r
                        }(t, p);
                        if (!1 !== a && (g = e(x = t), k = x.placeholder, -1 === (v = x !== i ? x.maxLength : i) && (v = i), !0 === p.colorMask && ce(x), r && ("inputmode" in x && (x.inputmode = p.inputmode, x.setAttribute("inputmode", p.inputmode)), !0 === p.disablePredictiveText && ("autocorrect" in x ? x.autocorrect = !1 : (!0 !== p.colorMask && ce(x), x.type = "password"))), !0 === a && (x.setAttribute("im-insert", p.insertMode), ee.on(x, "submit", te.submitEvent), ee.on(x, "reset", te.resetEvent), ee.on(x, "blur", te.blurEvent), ee.on(x, "focus", te.focusEvent), !0 !== p.colorMask && (ee.on(x, "click", te.clickEvent), ee.on(x, "mouseleave", te.mouseleaveEvent), ee.on(x, "mouseenter", te.mouseenterEvent)), ee.on(x, "paste", te.pasteEvent), ee.on(x, "cut", te.cutEvent), ee.on(x, "complete", p.oncomplete), ee.on(x, "incomplete", p.onincomplete), ee.on(x, "cleared", p.oncleared), r || !0 === p.inputEventOnly ? x.removeAttribute("maxLength") : (ee.on(x, "keydown", te.keydownEvent), ee.on(x, "keypress", te.keypressEvent)), ee.on(x, "input", te.inputFallBackEvent), ee.on(x, "beforeinput", te.beforeInputEvent)), ee.on(x, "setvalue", te.setValueEvent), h = q().join(""), "" !== x.inputmask._valueGet(!0) || !1 === p.clearMaskOnLostFocus || n.activeElement === x)) {
                            var o = e.isFunction(p.onBeforeMask) && p.onBeforeMask.call(b, x.inputmask._valueGet(!0), p) || x.inputmask._valueGet(!0);
                            "" !== o && ie(x, !0, !1, o.split(""));
                            var l = R().slice();
                            h = l.join(""), !1 === re(l) && p.clearIncomplete && L(), p.clearMaskOnLostFocus && n.activeElement !== x && (-1 === M() ? l = [] : se(l)), (!1 === p.clearMaskOnLostFocus || p.showMaskOnFocus && n.activeElement === x || "" !== x.inputmask._valueGet(!0)) && Z(x, l), n.activeElement === x && ae(x, W(M()))
                        }
                    }(x);
                    break;
                case"format":
                    return X = (e.isFunction(p.onBeforeMask) && p.onBeforeMask.call(b, a.value, p) || a.value).split(""), ie.call(this, i, !0, !1, X), a.metadata ? {
                        value: w ? R().slice().reverse().join("") : R().join(""),
                        metadata: m.call(this, {action: "getmetadata"}, d, p)
                    } : w ? R().slice().reverse().join("") : R().join("");
                case"isValid":
                    a.value ? (X = a.value.split(""), ie.call(this, i, !0, !0, X)) : a.value = R().join("");
                    for (var de = R(), pe = oe(), fe = de.length - 1; fe > pe && !K(fe); fe--) ;
                    return de.splice(pe, fe + 1 - pe), re(de) && a.value === R().join("");
                case"getemptymask":
                    return q().join("");
                case"remove":
                    return x && x.inputmask && (e.data(x, "_inputmask_opts", null), g = e(x), x.inputmask._valueSet(p.autoUnmask ? ne(x) : x.inputmask._valueGet(!0)), ee.off(x), x.inputmask.colorMask && ((y = x.inputmask.colorMask).removeChild(x), y.parentNode.insertBefore(x, y), y.parentNode.removeChild(y)), Object.getOwnPropertyDescriptor && Object.getPrototypeOf ? Object.getOwnPropertyDescriptor(Object.getPrototypeOf(x), "value") && x.inputmask.__valueGet && Object.defineProperty(x, "value", {
                        get: x.inputmask.__valueGet,
                        set: x.inputmask.__valueSet,
                        configurable: !0
                    }) : n.__lookupGetter__ && x.__lookupGetter__("value") && x.inputmask.__valueGet && (x.__defineGetter__("value", x.inputmask.__valueGet), x.__defineSetter__("value", x.inputmask.__valueSet)), x.inputmask = i), x;
                case"getmetadata":
                    if (e.isArray(d.metadata)) {
                        var me = C(!0, 0, !1).join("");
                        return e.each(d.metadata, (function (e, t) {
                            if (t.mask === me) return me = t, !1
                        })), me
                    }
                    return d.metadata
            }
        }

        return u.prototype = {
            dataAttribute: "data-inputmask",
            defaults: {
                placeholder: "_",
                optionalmarker: ["[", "]"],
                quantifiermarker: ["{", "}"],
                groupmarker: ["(", ")"],
                alternatormarker: "|",
                escapeChar: "\\",
                mask: null,
                regex: null,
                oncomplete: e.noop,
                onincomplete: e.noop,
                oncleared: e.noop,
                repeat: 0,
                greedy: !1,
                autoUnmask: !1,
                removeMaskOnSubmit: !1,
                clearMaskOnLostFocus: !0,
                insertMode: !0,
                clearIncomplete: !1,
                alias: null,
                onKeyDown: e.noop,
                onBeforeMask: null,
                onBeforePaste: function (t, i) {
                    return e.isFunction(i.onBeforeMask) ? i.onBeforeMask.call(this, t, i) : t
                },
                onBeforeWrite: null,
                onUnMask: null,
                showMaskOnFocus: !0,
                showMaskOnHover: !0,
                onKeyValidation: e.noop,
                skipOptionalPartCharacter: " ",
                numericInput: !1,
                rightAlign: !1,
                undoOnEscape: !0,
                radixPoint: "",
                _radixDance: !1,
                groupSeparator: "",
                keepStatic: null,
                positionCaretOnTab: !0,
                tabThrough: !1,
                supportsInputType: ["text", "tel", "url", "password", "search"],
                ignorables: [8, 9, 13, 19, 27, 33, 34, 35, 36, 37, 38, 39, 40, 45, 46, 93, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 0, 229],
                isComplete: null,
                preValidation: null,
                postValidation: null,
                staticDefinitionSymbol: i,
                jitMasking: !1,
                nullable: !0,
                inputEventOnly: !1,
                noValuePatching: !1,
                positionCaretOnClick: "lvp",
                casing: null,
                inputmode: "verbatim",
                colorMask: !1,
                disablePredictiveText: !1,
                importDataAttributes: !0,
                shiftPositions: !0
            },
            definitions: {
                9: {validator: "[0-9１-９]", definitionSymbol: "*"},
                a: {validator: "[A-Za-zА-яЁёÀ-ÿµ]", definitionSymbol: "*"},
                "*": {validator: "[0-9１-９A-Za-zА-яЁёÀ-ÿµ]"}
            },
            aliases: {},
            masksCache: {},
            mask: function (a) {
                var o = this;
                return "string" == typeof a && (a = n.getElementById(a) || n.querySelectorAll(a)), a = a.nodeName ? [a] : a, e.each(a, (function (n, a) {
                    var s = e.extend(!0, {}, o.opts);
                    if (function (n, a, o, s) {
                        if (!0 === a.importDataAttributes) {
                            var r, l, c, u, p = function (e, a) {
                                null !== (a = a !== i ? a : n.getAttribute(s + "-" + e)) && ("string" == typeof a && (0 === e.indexOf("on") ? a = t[a] : "false" === a ? a = !1 : "true" === a && (a = !0)), o[e] = a)
                            }, f = n.getAttribute(s);
                            if (f && "" !== f && (f = f.replace(/'/g, '"'), l = JSON.parse("{" + f + "}")), l) for (u in c = i, l) if ("alias" === u.toLowerCase()) {
                                c = l[u];
                                break
                            }
                            for (r in p("alias", c), o.alias && d(o.alias, o, a), a) {
                                if (l) for (u in c = i, l) if (u.toLowerCase() === r.toLowerCase()) {
                                    c = l[u];
                                    break
                                }
                                p(r, c)
                            }
                        }
                        return e.extend(!0, a, o), ("rtl" === n.dir || a.rightAlign) && (n.style.textAlign = "right"), ("rtl" === n.dir || a.numericInput) && (n.dir = "ltr", n.removeAttribute("dir"), a.isRTL = !0), Object.keys(o).length
                    }(a, s, e.extend(!0, {}, o.userOptions), o.dataAttribute)) {
                        var r = p(s, o.noMasksCache);
                        r !== i && (a.inputmask !== i && (a.inputmask.opts.autoUnmask = !0, a.inputmask.remove()), a.inputmask = new u(i, i, !0), a.inputmask.opts = s, a.inputmask.noMasksCache = o.noMasksCache, a.inputmask.userOptions = e.extend(!0, {}, o.userOptions), a.inputmask.isRTL = s.isRTL || s.numericInput, a.inputmask.el = a, a.inputmask.maskset = r, e.data(a, "_inputmask_opts", s), m.call(a.inputmask, {action: "mask"}))
                    }
                })), a && a[0] && a[0].inputmask || this
            },
            option: function (t, i) {
                return "string" == typeof t ? this.opts[t] : "object" === (void 0 === t ? "undefined" : s(t)) ? (e.extend(this.userOptions, t), this.el && !0 !== i && this.mask(this.el), this) : void 0
            },
            unmaskedvalue: function (e) {
                return this.maskset = this.maskset || p(this.opts, this.noMasksCache), m.call(this, {
                    action: "unmaskedvalue",
                    value: e
                })
            },
            remove: function () {
                return m.call(this, {action: "remove"})
            },
            getemptymask: function () {
                return this.maskset = this.maskset || p(this.opts, this.noMasksCache), m.call(this, {action: "getemptymask"})
            },
            hasMaskedValue: function () {
                return !this.opts.autoUnmask
            },
            isComplete: function () {
                return this.maskset = this.maskset || p(this.opts, this.noMasksCache), m.call(this, {action: "isComplete"})
            },
            getmetadata: function () {
                return this.maskset = this.maskset || p(this.opts, this.noMasksCache), m.call(this, {action: "getmetadata"})
            },
            isValid: function (e) {
                return this.maskset = this.maskset || p(this.opts, this.noMasksCache), m.call(this, {
                    action: "isValid",
                    value: e
                })
            },
            format: function (e, t) {
                return this.maskset = this.maskset || p(this.opts, this.noMasksCache), m.call(this, {
                    action: "format",
                    value: e,
                    metadata: t
                })
            },
            setValue: function (t) {
                this.el && e(this.el).trigger("setvalue", [t])
            },
            analyseMask: function (t, n, a) {
                var o, s, r, l, c, d,
                    p = /(?:[?*+]|\{[0-9\+\*]+(?:,[0-9\+\*]*)?(?:\|[0-9\+\*]*)?\})|[^.?*+^${[]()|\\]+|./g,
                    f = /\[\^?]?(?:[^\\\]]+|\\[\S\s]?)*]?|\\(?:0(?:[0-3][0-7]{0,2}|[4-7][0-7]?)?|[1-9][0-9]*|x[0-9A-Fa-f]{2}|u[0-9A-Fa-f]{4}|c[A-Za-z]|[\S\s]?)|\((?:\?[:=!]?)?|(?:[?*+]|\{[0-9]+(?:,[0-9]*)?\})\??|[^.?*+^${[()|\\]+|./g,
                    m = !1, h = new y, g = [], v = [];

                function y(e, t, i, n) {
                    this.matches = [], this.openGroup = e || !1, this.alternatorGroup = !1, this.isGroup = e || !1, this.isOptional = t || !1, this.isQuantifier = i || !1, this.isAlternator = n || !1, this.quantifier = {
                        min: 1,
                        max: 1
                    }
                }

                function k(t, o, s) {
                    s = s !== i ? s : t.matches.length;
                    var r = t.matches[s - 1];
                    if (n) 0 === o.indexOf("[") || m && /\\d|\\s|\\w]/i.test(o) || "." === o ? t.matches.splice(s++, 0, {
                        fn: new RegExp(o, a.casing ? "i" : ""),
                        optionality: !1,
                        newBlockMarker: r === i ? "master" : r.def !== o,
                        casing: null,
                        def: o,
                        placeholder: i,
                        nativeDef: o
                    }) : (m && (o = o[o.length - 1]), e.each(o.split(""), (function (e, n) {
                        r = t.matches[s - 1], t.matches.splice(s++, 0, {
                            fn: null,
                            optionality: !1,
                            newBlockMarker: r === i ? "master" : r.def !== n && null !== r.fn,
                            casing: null,
                            def: a.staticDefinitionSymbol || n,
                            placeholder: a.staticDefinitionSymbol !== i ? n : i,
                            nativeDef: (m ? "'" : "") + n
                        })
                    }))), m = !1; else {
                        var l = (a.definitions ? a.definitions[o] : i) || u.prototype.definitions[o];
                        l && !m ? t.matches.splice(s++, 0, {
                            fn: l.validator ? "string" == typeof l.validator ? new RegExp(l.validator, a.casing ? "i" : "") : new function () {
                                this.test = l.validator
                            } : new RegExp("."),
                            optionality: !1,
                            newBlockMarker: r === i ? "master" : r.def !== (l.definitionSymbol || o),
                            casing: l.casing,
                            def: l.definitionSymbol || o,
                            placeholder: l.placeholder,
                            nativeDef: o
                        }) : (t.matches.splice(s++, 0, {
                            fn: null,
                            optionality: !1,
                            newBlockMarker: r === i ? "master" : r.def !== o && null !== r.fn,
                            casing: null,
                            def: a.staticDefinitionSymbol || o,
                            placeholder: a.staticDefinitionSymbol !== i ? o : i,
                            nativeDef: (m ? "'" : "") + o
                        }), m = !1)
                    }
                }

                function b() {
                    if (g.length > 0) {
                        if (k(l = g[g.length - 1], s), l.isAlternator) {
                            c = g.pop();
                            for (var e = 0; e < c.matches.length; e++) c.matches[e].isGroup && (c.matches[e].isGroup = !1);
                            g.length > 0 ? (l = g[g.length - 1]).matches.push(c) : h.matches.push(c)
                        }
                    } else k(h, s)
                }

                function x(e) {
                    var t = new y(!0);
                    return t.openGroup = !1, t.matches = e, t
                }

                for (n && (a.optionalmarker[0] = i, a.optionalmarker[1] = i); o = n ? f.exec(t) : p.exec(t);) {
                    if (s = o[0], n) switch (s.charAt(0)) {
                        case"?":
                            s = "{0,1}";
                            break;
                        case"+":
                        case"*":
                            s = "{" + s + "}"
                    }
                    if (m) b(); else switch (s.charAt(0)) {
                        case"(?=":
                        case"(?!":
                        case"(?<=":
                        case"(?<!":
                            break;
                        case a.escapeChar:
                            m = !0, n && b();
                            break;
                        case a.optionalmarker[1]:
                        case a.groupmarker[1]:
                            if ((r = g.pop()).openGroup = !1, r !== i) if (g.length > 0) {
                                if ((l = g[g.length - 1]).matches.push(r), l.isAlternator) {
                                    c = g.pop();
                                    for (var w = 0; w < c.matches.length; w++) c.matches[w].isGroup = !1, c.matches[w].alternatorGroup = !1;
                                    g.length > 0 ? (l = g[g.length - 1]).matches.push(c) : h.matches.push(c)
                                }
                            } else h.matches.push(r); else b();
                            break;
                        case a.optionalmarker[0]:
                            g.push(new y(!1, !0));
                            break;
                        case a.groupmarker[0]:
                            g.push(new y(!0));
                            break;
                        case a.quantifiermarker[0]:
                            var S = new y(!1, !1, !0), E = (s = s.replace(/[{}]/g, "")).split("|"), A = E[0].split(","),
                                _ = isNaN(A[0]) ? A[0] : parseInt(A[0]),
                                C = 1 === A.length ? _ : isNaN(A[1]) ? A[1] : parseInt(A[1]);
                            "*" !== _ && "+" !== _ || (_ = "*" === C ? 0 : 1), S.quantifier = {
                                min: _,
                                max: C,
                                jit: E[1]
                            };
                            var P = g.length > 0 ? g[g.length - 1].matches : h.matches;
                            if ((o = P.pop()).isAlternator) {
                                P.push(o), P = o.matches;
                                var L = new y(!0), M = P.pop();
                                P.push(L), P = L.matches, o = M
                            }
                            o.isGroup || (o = x([o])), P.push(o), P.push(S);
                            break;
                        case a.alternatormarker:
                            var $ = function (e) {
                                var t = e.pop();
                                return t.isQuantifier && (t = x([e.pop(), t])), t
                            };
                            if (g.length > 0) {
                                var D = (l = g[g.length - 1]).matches[l.matches.length - 1];
                                d = l.openGroup && (D.matches === i || !1 === D.isGroup && !1 === D.isAlternator) ? g.pop() : $(l.matches)
                            } else d = $(h.matches);
                            if (d.isAlternator) g.push(d); else if (d.alternatorGroup ? (c = g.pop(), d.alternatorGroup = !1) : c = new y(!1, !1, !1, !0), c.matches.push(d), g.push(c), d.openGroup) {
                                d.openGroup = !1;
                                var I = new y(!0);
                                I.alternatorGroup = !0, g.push(I)
                            }
                            break;
                        default:
                            b()
                    }
                }
                for (; g.length > 0;) r = g.pop(), h.matches.push(r);
                return h.matches.length > 0 && (function t(o) {
                    o && o.matches && e.each(o.matches, (function (e, s) {
                        var r = o.matches[e + 1];
                        (r === i || r.matches === i || !1 === r.isQuantifier) && s && s.isGroup && (s.isGroup = !1, n || (k(s, a.groupmarker[0], 0), !0 !== s.openGroup && k(s, a.groupmarker[1]))), t(s)
                    }))
                }(h), v.push(h)), (a.numericInput || a.isRTL) && function e(t) {
                    for (var n in t.matches = t.matches.reverse(), t.matches) if (t.matches.hasOwnProperty(n)) {
                        var o = parseInt(n);
                        if (t.matches[n].isQuantifier && t.matches[o + 1] && t.matches[o + 1].isGroup) {
                            var s = t.matches[n];
                            t.matches.splice(n, 1), t.matches.splice(o + 1, 0, s)
                        }
                        t.matches[n].matches !== i ? t.matches[n] = e(t.matches[n]) : t.matches[n] = ((r = t.matches[n]) === a.optionalmarker[0] ? r = a.optionalmarker[1] : r === a.optionalmarker[1] ? r = a.optionalmarker[0] : r === a.groupmarker[0] ? r = a.groupmarker[1] : r === a.groupmarker[1] && (r = a.groupmarker[0]), r)
                    }
                    var r;
                    return t
                }(v[0]), v
            }
        }, u.extendDefaults = function (t) {
            e.extend(!0, u.prototype.defaults, t)
        }, u.extendDefinitions = function (t) {
            e.extend(!0, u.prototype.definitions, t)
        }, u.extendAliases = function (t) {
            e.extend(!0, u.prototype.aliases, t)
        }, u.format = function (e, t, i) {
            return u(t).format(e, i)
        }, u.unmask = function (e, t) {
            return u(t).unmaskedvalue(e)
        }, u.isValid = function (e, t) {
            return u(t).isValid(e)
        }, u.remove = function (t) {
            "string" == typeof t && (t = n.getElementById(t) || n.querySelectorAll(t)), t = t.nodeName ? [t] : t, e.each(t, (function (e, t) {
                t.inputmask && t.inputmask.remove()
            }))
        }, u.setValue = function (t, i) {
            "string" == typeof t && (t = n.getElementById(t) || n.querySelectorAll(t)), t = t.nodeName ? [t] : t, e.each(t, (function (t, n) {
                n.inputmask ? n.inputmask.setValue(i) : e(n).trigger("setvalue", [i])
            }))
        }, u.escapeRegex = function (e) {
            return e.replace(new RegExp("(\\" + ["/", ".", "*", "+", "?", "|", "(", ")", "[", "]", "{", "}", "\\", "$", "^"].join("|\\") + ")", "gim"), "\\$1")
        }, u.keyCode = {
            BACKSPACE: 8,
            BACKSPACE_SAFARI: 127,
            DELETE: 46,
            DOWN: 40,
            END: 35,
            ENTER: 13,
            ESCAPE: 27,
            HOME: 36,
            INSERT: 45,
            LEFT: 37,
            PAGE_DOWN: 34,
            PAGE_UP: 33,
            RIGHT: 39,
            SPACE: 32,
            TAB: 9,
            UP: 38,
            X: 88,
            CONTROL: 17
        }, u.dependencyLib = e, u
    }) ? n.apply(t, a) : n) || (e.exports = o)
}, function (e, t, i) {
    "use strict";
    var n, a, o;
    "function" == typeof Symbol && Symbol.iterator;
    a = [i(4)], void 0 === (o = "function" == typeof (n = function (e) {
        return e
    }) ? n.apply(t, a) : n) || (e.exports = o)
}, function (e, t) {
    e.exports = jQuery
}, function (module, exports, __webpack_require__) {
    "use strict";
    var __WEBPACK_AMD_DEFINE_RESULT__,
        _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
            return typeof e
        } : function (e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        };
    __WEBPACK_AMD_DEFINE_RESULT__ = function () {
        return "undefined" != typeof window ? window : new (eval("require('jsdom').JSDOM"))("").window
    }.call(exports, __webpack_require__, exports, module), void 0 === __WEBPACK_AMD_DEFINE_RESULT__ || (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)
}, function (e, t, i) {
    "use strict";
    var n, a, o, s = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
        return typeof e
    } : function (e) {
        return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
    };
    a = [i(2)], void 0 === (o = "function" == typeof (n = function (e) {
        var t = e.dependencyLib, i = {
            d: ["[1-9]|[12][0-9]|3[01]", Date.prototype.setDate, "day", Date.prototype.getDate],
            dd: ["0[1-9]|[12][0-9]|3[01]", Date.prototype.setDate, "day", function () {
                return r(Date.prototype.getDate.call(this), 2)
            }],
            ddd: [""],
            dddd: [""],
            m: ["[1-9]|1[012]", Date.prototype.setMonth, "month", function () {
                return Date.prototype.getMonth.call(this) + 1
            }],
            mm: ["0[1-9]|1[012]", Date.prototype.setMonth, "month", function () {
                return r(Date.prototype.getMonth.call(this) + 1, 2)
            }],
            mmm: [""],
            mmmm: [""],
            yy: ["[0-9]{2}", Date.prototype.setFullYear, "year", function () {
                return r(Date.prototype.getFullYear.call(this), 2)
            }],
            yyyy: ["[0-9]{4}", Date.prototype.setFullYear, "year", function () {
                return r(Date.prototype.getFullYear.call(this), 4)
            }],
            h: ["[1-9]|1[0-2]", Date.prototype.setHours, "hours", Date.prototype.getHours],
            hh: ["0[1-9]|1[0-2]", Date.prototype.setHours, "hours", function () {
                return r(Date.prototype.getHours.call(this), 2)
            }],
            hhh: ["[0-9]+", Date.prototype.setHours, "hours", Date.prototype.getHours],
            H: ["1?[0-9]|2[0-3]", Date.prototype.setHours, "hours", Date.prototype.getHours],
            HH: ["0[0-9]|1[0-9]|2[0-3]", Date.prototype.setHours, "hours", function () {
                return r(Date.prototype.getHours.call(this), 2)
            }],
            HHH: ["[0-9]+", Date.prototype.setHours, "hours", Date.prototype.getHours],
            M: ["[1-5]?[0-9]", Date.prototype.setMinutes, "minutes", Date.prototype.getMinutes],
            MM: ["0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]", Date.prototype.setMinutes, "minutes", function () {
                return r(Date.prototype.getMinutes.call(this), 2)
            }],
            ss: ["[0-5][0-9]", Date.prototype.setSeconds, "seconds", function () {
                return r(Date.prototype.getSeconds.call(this), 2)
            }],
            l: ["[0-9]{3}", Date.prototype.setMilliseconds, "milliseconds", function () {
                return r(Date.prototype.getMilliseconds.call(this), 3)
            }],
            L: ["[0-9]{2}", Date.prototype.setMilliseconds, "milliseconds", function () {
                return r(Date.prototype.getMilliseconds.call(this), 2)
            }],
            t: ["[ap]"],
            tt: ["[ap]m"],
            T: ["[AP]"],
            TT: ["[AP]M"],
            Z: [""],
            o: [""],
            S: [""]
        }, n = {
            isoDate: "yyyy-mm-dd",
            isoTime: "HH:MM:ss",
            isoDateTime: "yyyy-mm-dd'T'HH:MM:ss",
            isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
        };

        function a(e) {
            if (!e.tokenizer) {
                var t = [];
                for (var n in i) -1 === t.indexOf(n[0]) && t.push(n[0]);
                e.tokenizer = "(" + t.join("+|") + ")+?|.", e.tokenizer = new RegExp(e.tokenizer, "g")
            }
            return e.tokenizer
        }

        function o(t, n, o, s) {
            for (var r, l = ""; r = a(o).exec(t);) if (void 0 === n) if (i[r[0]]) l += "(" + i[r[0]][0] + ")"; else switch (r[0]) {
                case"[":
                    l += "(";
                    break;
                case"]":
                    l += ")?";
                    break;
                default:
                    l += e.escapeRegex(r[0])
            } else i[r[0]] ? !0 !== s && i[r[0]][3] ? l += i[r[0]][3].call(n.date) : i[r[0]][2] ? l += n["raw" + i[r[0]][2]] : l += r[0] : l += r[0];
            return l
        }

        function r(e, t) {
            for (e = String(e), t = t || 2; e.length < t;) e = "0" + e;
            return e
        }

        function l(e, t, n) {
            var o, r, l, c = {date: new Date(1, 0, 1)}, u = e;

            function d(e) {
                var t = e.replace(/[^0-9]/g, "0");
                if (t != e) {
                    var i = e.replace(/[^0-9]/g, ""), a = (n.min && n.min[o] || e).toString(),
                        s = (n.max && n.max[o] || e).toString();
                    t = i + (i < a.slice(0, i.length) ? a.slice(i.length) : i > s.slice(0, i.length) ? s.slice(i.length) : t.toString().slice(i.length))
                }
                return t
            }

            function p(e, t, i) {
                e[o] = d(t), e["raw" + o] = t, void 0 !== l && l.call(e.date, "month" == o ? parseInt(e[o]) - 1 : e[o])
            }

            if ("string" == typeof u) {
                for (; r = a(n).exec(t);) {
                    var f = u.slice(0, r[0].length);
                    i.hasOwnProperty(r[0]) && (i[r[0]][0], o = i[r[0]][2], l = i[r[0]][1], p(c, f)), u = u.slice(f.length)
                }
                return c
            }
            if (u && "object" === (void 0 === u ? "undefined" : s(u)) && u.hasOwnProperty("date")) return u
        }

        return e.extendAliases({
            datetime: {
                mask: function (e) {
                    return i.S = e.i18n.ordinalSuffix.join("|"), e.inputFormat = n[e.inputFormat] || e.inputFormat, e.displayFormat = n[e.displayFormat] || e.displayFormat || e.inputFormat, e.outputFormat = n[e.outputFormat] || e.outputFormat || e.inputFormat, e.placeholder = "" !== e.placeholder ? e.placeholder : e.inputFormat.replace(/[\[\]]/, ""), e.regex = o(e.inputFormat, void 0, e), null
                },
                placeholder: "",
                inputFormat: "isoDateTime",
                displayFormat: void 0,
                outputFormat: void 0,
                min: null,
                max: null,
                i18n: {
                    dayNames: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
                    monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                    ordinalSuffix: ["st", "nd", "rd", "th"]
                },
                postValidation: function (e, t, i, n) {
                    n.min = l(n.min, n.inputFormat, n), n.max = l(n.max, n.inputFormat, n);
                    var a = i, s = l(e.join(""), n.inputFormat, n);
                    return a && s.date.getTime() == s.date.getTime() && (a = (a = function (e, t) {
                        return (!isFinite(e.rawday) || "29" == e.day && !isFinite(e.rawyear) || new Date(e.date.getFullYear(), isFinite(e.rawmonth) ? e.month : e.date.getMonth() + 1, 0).getDate() >= e.day) && t
                    }(s, a)) && function (e, t) {
                        var i = !0;
                        if (t.min) {
                            if (e.rawyear) {
                                var n = e.rawyear.replace(/[^0-9]/g, ""), a = t.min.year.substr(0, n.length);
                                i = a <= n
                            }
                            e.year === e.rawyear && t.min.date.getTime() == t.min.date.getTime() && (i = t.min.date.getTime() <= e.date.getTime())
                        }
                        return i && t.max && t.max.date.getTime() == t.max.date.getTime() && (i = t.max.date.getTime() >= e.date.getTime()), i
                    }(s, n)), t && a && i.pos !== t ? {
                        buffer: o(n.inputFormat, s, n),
                        refreshFromBuffer: {start: t, end: i.pos}
                    } : a
                },
                onKeyDown: function (i, n, o, s) {
                    if (i.ctrlKey && i.keyCode === e.keyCode.RIGHT) {
                        for (var l, c = new Date, u = ""; l = a(s).exec(s.inputFormat);) "d" === l[0].charAt(0) ? u += r(c.getDate(), l[0].length) : "m" === l[0].charAt(0) ? u += r(c.getMonth() + 1, l[0].length) : "yyyy" === l[0] ? u += c.getFullYear().toString() : "y" === l[0].charAt(0) && (u += r(c.getYear(), l[0].length));
                        this.inputmask._valueSet(u), t(this).trigger("setvalue")
                    }
                },
                onUnMask: function (e, t, i) {
                    return o(i.outputFormat, l(e, i.inputFormat, i), i, !0)
                },
                casing: function (e, t, i, n) {
                    return 0 == t.nativeDef.indexOf("[ap]") ? e.toLowerCase() : 0 == t.nativeDef.indexOf("[AP]") ? e.toUpperCase() : e
                },
                insertMode: !1,
                shiftPositions: !1
            }
        }), e
    }) ? n.apply(t, a) : n) || (e.exports = o)
}, function (e, t, i) {
    "use strict";
    var n, a, o;
    "function" == typeof Symbol && Symbol.iterator;
    a = [i(2)], void 0 === (o = "function" == typeof (n = function (e) {
        var t = e.dependencyLib;

        function i(t, i) {
            for (var n = "", a = 0; a < t.length; a++) e.prototype.definitions[t.charAt(a)] || i.definitions[t.charAt(a)] || i.optionalmarker.start === t.charAt(a) || i.optionalmarker.end === t.charAt(a) || i.quantifiermarker.start === t.charAt(a) || i.quantifiermarker.end === t.charAt(a) || i.groupmarker.start === t.charAt(a) || i.groupmarker.end === t.charAt(a) || i.alternatormarker === t.charAt(a) ? n += "\\" + t.charAt(a) : n += t.charAt(a);
            return n
        }

        return e.extendAliases({
            numeric: {
                mask: function (e) {
                    if (0 !== e.repeat && isNaN(e.integerDigits) && (e.integerDigits = e.repeat), e.repeat = 0, e.groupSeparator === e.radixPoint && e.digits && "0" !== e.digits && ("." === e.radixPoint ? e.groupSeparator = "," : "," === e.radixPoint ? e.groupSeparator = "." : e.groupSeparator = ""), " " === e.groupSeparator && (e.skipOptionalPartCharacter = void 0), e.autoGroup = e.autoGroup && "" !== e.groupSeparator, e.autoGroup && ("string" == typeof e.groupSize && isFinite(e.groupSize) && (e.groupSize = parseInt(e.groupSize)), isFinite(e.integerDigits))) {
                        var t = Math.floor(e.integerDigits / e.groupSize), n = e.integerDigits % e.groupSize;
                        e.integerDigits = parseInt(e.integerDigits) + (0 === n ? t - 1 : t), e.integerDigits < 1 && (e.integerDigits = "*")
                    }
                    e.placeholder.length > 1 && (e.placeholder = e.placeholder.charAt(0)), "radixFocus" === e.positionCaretOnClick && "" === e.placeholder && !1 === e.integerOptional && (e.positionCaretOnClick = "lvp"), e.definitions[";"] = e.definitions["~"], e.definitions[";"].definitionSymbol = "~", !0 === e.numericInput && (e.positionCaretOnClick = "radixFocus" === e.positionCaretOnClick ? "lvp" : e.positionCaretOnClick, e.digitsOptional = !1, isNaN(e.digits) && (e.digits = 2), e.decimalProtect = !1);
                    var a = "[+]";
                    if (a += i(e.prefix, e), !0 === e.integerOptional ? a += "~{1," + e.integerDigits + "}" : a += "~{" + e.integerDigits + "}", void 0 !== e.digits) {
                        var o = e.decimalProtect ? ":" : e.radixPoint, s = e.digits.toString().split(",");
                        isFinite(s[0]) && s[1] && isFinite(s[1]) ? a += o + ";{" + e.digits + "}" : (isNaN(e.digits) || parseInt(e.digits) > 0) && (e.digitsOptional ? a += "[" + o + ";{1," + e.digits + "}]" : a += o + ";{" + e.digits + "}")
                    }
                    return a += i(e.suffix, e), a += "[-]", e.greedy = !1, a
                },
                placeholder: "",
                greedy: !1,
                digits: "*",
                digitsOptional: !0,
                enforceDigitsOnBlur: !1,
                radixPoint: ".",
                positionCaretOnClick: "radixFocus",
                groupSize: 3,
                groupSeparator: "",
                autoGroup: !1,
                allowMinus: !0,
                negationSymbol: {front: "-", back: ""},
                integerDigits: "+",
                integerOptional: !0,
                prefix: "",
                suffix: "",
                rightAlign: !0,
                decimalProtect: !0,
                min: null,
                max: null,
                step: 1,
                insertMode: !0,
                autoUnmask: !1,
                unmaskAsNumber: !1,
                inputType: "text",
                inputmode: "numeric",
                preValidation: function (e, i, n, a, o, s) {
                    if ("-" === n || n === o.negationSymbol.front) return !0 === o.allowMinus && (o.isNegative = void 0 === o.isNegative || !o.isNegative, "" === e.join("") || {
                        caret: s.validPositions[i] ? i : void 0,
                        dopost: !0
                    });
                    if (!1 === a && n === o.radixPoint && void 0 !== o.digits && (isNaN(o.digits) || parseInt(o.digits) > 0)) {
                        var r = t.inArray(o.radixPoint, e);
                        if (-1 !== r && void 0 !== s.validPositions[r]) return !0 === o.numericInput ? i === r : {caret: r + 1}
                    }
                    return !0
                },
                postValidation: function (i, n, a, o) {
                    var s = o.suffix.split(""), r = o.prefix.split("");
                    if (void 0 === a.pos && void 0 !== a.caret && !0 !== a.dopost) return a;
                    var l = void 0 !== a.caret ? a.caret : a.pos, c = i.slice();
                    o.numericInput && (l = c.length - l - 1, c = c.reverse());
                    var u = c[l];
                    if (u === o.groupSeparator && (u = c[l += 1]), l === c.length - o.suffix.length - 1 && u === o.radixPoint) return a;
                    void 0 !== u && u !== o.radixPoint && u !== o.negationSymbol.front && u !== o.negationSymbol.back && (c[l] = "?", o.prefix.length > 0 && l >= (!1 === o.isNegative ? 1 : 0) && l < o.prefix.length - 1 + (!1 === o.isNegative ? 1 : 0) ? r[l - (!1 === o.isNegative ? 1 : 0)] = "?" : o.suffix.length > 0 && l >= c.length - o.suffix.length - (!1 === o.isNegative ? 1 : 0) && (s[l - (c.length - o.suffix.length - (!1 === o.isNegative ? 1 : 0))] = "?")), r = r.join(""), s = s.join("");
                    var d = c.join("").replace(r, "");
                    if (d = (d = (d = (d = d.replace(s, "")).replace(new RegExp(e.escapeRegex(o.groupSeparator), "g"), "")).replace(new RegExp("[-" + e.escapeRegex(o.negationSymbol.front) + "]", "g"), "")).replace(new RegExp(e.escapeRegex(o.negationSymbol.back) + "$"), ""), isNaN(o.placeholder) && (d = d.replace(new RegExp(e.escapeRegex(o.placeholder), "g"), "")), d.length > 1 && 1 !== d.indexOf(o.radixPoint) && ("0" === u && (d = d.replace(/^\?/g, "")), d = d.replace(/^0/g, "")), d.charAt(0) === o.radixPoint && "" !== o.radixPoint && !0 !== o.numericInput && (d = "0" + d), "" !== d) {
                        if (d = d.split(""), (!o.digitsOptional || o.enforceDigitsOnBlur && "blur" === a.event) && isFinite(o.digits)) {
                            var p = t.inArray(o.radixPoint, d), f = t.inArray(o.radixPoint, c);
                            -1 === p && (d.push(o.radixPoint), p = d.length - 1);
                            for (var m = 1; m <= o.digits; m++) o.digitsOptional && (!o.enforceDigitsOnBlur || "blur" !== a.event) || void 0 !== d[p + m] && d[p + m] !== o.placeholder.charAt(0) ? -1 !== f && void 0 !== c[f + m] && (d[p + m] = d[p + m] || c[f + m]) : d[p + m] = a.placeholder || o.placeholder.charAt(0)
                        }
                        if (!0 !== o.autoGroup || "" === o.groupSeparator || u === o.radixPoint && void 0 === a.pos && !a.dopost) d = d.join(""); else {
                            var h = d[d.length - 1] === o.radixPoint && a.c === o.radixPoint;
                            d = e(function (e, t) {
                                var i = "";
                                if (i += "(" + t.groupSeparator + "*{" + t.groupSize + "}){*}", "" !== t.radixPoint) {
                                    var n = e.join("").split(t.radixPoint);
                                    n[1] && (i += t.radixPoint + "*{" + n[1].match(/^\d*\??\d*/)[0].length + "}")
                                }
                                return i
                            }(d, o), {
                                numericInput: !0,
                                jitMasking: !0,
                                definitions: {"*": {validator: "[0-9?]", cardinality: 1}}
                            }).format(d.join("")), h && (d += o.radixPoint), d.charAt(0) === o.groupSeparator && d.substr(1)
                        }
                    }
                    if (o.isNegative && "blur" === a.event && (o.isNegative = "0" !== d), d = r + d, d += s, o.isNegative && (d = o.negationSymbol.front + d, d += o.negationSymbol.back), d = d.split(""), void 0 !== u) if (u !== o.radixPoint && u !== o.negationSymbol.front && u !== o.negationSymbol.back) (l = t.inArray("?", d)) > -1 ? d[l] = u : l = a.caret || 0; else if (u === o.radixPoint || u === o.negationSymbol.front || u === o.negationSymbol.back) {
                        var g = t.inArray(u, d);
                        -1 !== g && (l = g)
                    }
                    o.numericInput && (l = d.length - l - 1, d = d.reverse());
                    var v = {
                        caret: void 0 !== u && void 0 === a.pos || void 0 === l ? l : l + (o.numericInput ? -1 : 1),
                        buffer: d,
                        refreshFromBuffer: a.dopost || i.join("") !== d.join("")
                    };
                    return v.refreshFromBuffer ? v : a
                },
                onBeforeWrite: function (i, n, a, o) {
                    if (i) switch (i.type) {
                        case"keydown":
                            return o.postValidation(n, a, {caret: a, dopost: !0}, o);
                        case"blur":
                        case"checkval":
                            var s;
                            if (function (t) {
                                void 0 === t.parseMinMaxOptions && (null !== t.min && (t.min = t.min.toString().replace(new RegExp(e.escapeRegex(t.groupSeparator), "g"), ""), "," === t.radixPoint && (t.min = t.min.replace(t.radixPoint, ".")), t.min = isFinite(t.min) ? parseFloat(t.min) : NaN, isNaN(t.min) && (t.min = Number.MIN_VALUE)), null !== t.max && (t.max = t.max.toString().replace(new RegExp(e.escapeRegex(t.groupSeparator), "g"), ""), "," === t.radixPoint && (t.max = t.max.replace(t.radixPoint, ".")), t.max = isFinite(t.max) ? parseFloat(t.max) : NaN, isNaN(t.max) && (t.max = Number.MAX_VALUE)), t.parseMinMaxOptions = "done")
                            }(o), null !== o.min || null !== o.max) {
                                if (s = o.onUnMask(n.join(""), void 0, t.extend({}, o, {unmaskAsNumber: !0})), null !== o.min && s < o.min) return o.isNegative = o.min < 0, o.postValidation(o.min.toString().replace(".", o.radixPoint).split(""), a, {
                                    caret: a,
                                    dopost: !0,
                                    placeholder: "0"
                                }, o);
                                if (null !== o.max && s > o.max) return o.isNegative = o.max < 0, o.postValidation(o.max.toString().replace(".", o.radixPoint).split(""), a, {
                                    caret: a,
                                    dopost: !0,
                                    placeholder: "0"
                                }, o)
                            }
                            return o.postValidation(n, a, {caret: a, placeholder: "0", event: "blur"}, o);
                        case"_checkval":
                            return {caret: a}
                    }
                },
                regex: {
                    integerPart: function (t, i) {
                        return i ? new RegExp("[" + e.escapeRegex(t.negationSymbol.front) + "+]?") : new RegExp("[" + e.escapeRegex(t.negationSymbol.front) + "+]?\\d+")
                    }, integerNPart: function (t) {
                        return new RegExp("[\\d" + e.escapeRegex(t.groupSeparator) + e.escapeRegex(t.placeholder.charAt(0)) + "]+")
                    }
                },
                definitions: {
                    "~": {
                        validator: function (t, i, n, a, o, s) {
                            var r;
                            if ("k" === t || "m" === t) {
                                r = {insert: [], c: 0};
                                for (var l = 0, c = "k" === t ? 2 : 5; l < c; l++) r.insert.push({pos: n + l, c: 0});
                                return r.pos = n + c, r
                            }
                            if (!0 === (r = a ? new RegExp("[0-9" + e.escapeRegex(o.groupSeparator) + "]").test(t) : new RegExp("[0-9]").test(t))) {
                                if (!0 !== o.numericInput && void 0 !== i.validPositions[n] && "~" === i.validPositions[n].match.def && !s) {
                                    var u = i.buffer.join(""),
                                        d = (u = (u = u.replace(new RegExp("[-" + e.escapeRegex(o.negationSymbol.front) + "]", "g"), "")).replace(new RegExp(e.escapeRegex(o.negationSymbol.back) + "$"), "")).split(o.radixPoint);
                                    d.length > 1 && (d[1] = d[1].replace(/0/g, o.placeholder.charAt(0))), "0" === d[0] && (d[0] = d[0].replace(/0/g, o.placeholder.charAt(0))), u = d[0] + o.radixPoint + d[1] || "";
                                    var p = i._buffer.join("");
                                    for (u === o.radixPoint && (u = p); null === u.match(e.escapeRegex(p) + "$");) p = p.slice(1);
                                    r = void 0 === (u = (u = u.replace(p, "")).split(""))[n] ? {
                                        pos: n,
                                        remove: n
                                    } : {pos: n}
                                }
                            } else a || t !== o.radixPoint || void 0 !== i.validPositions[n - 1] || (r = {
                                insert: {
                                    pos: n,
                                    c: 0
                                }, pos: n + 1
                            });
                            return r
                        }, cardinality: 1
                    }, "+": {
                        validator: function (e, t, i, n, a) {
                            return a.allowMinus && ("-" === e || e === a.negationSymbol.front)
                        }, cardinality: 1, placeholder: ""
                    }, "-": {
                        validator: function (e, t, i, n, a) {
                            return a.allowMinus && e === a.negationSymbol.back
                        }, cardinality: 1, placeholder: ""
                    }, ":": {
                        validator: function (t, i, n, a, o) {
                            var s = "[" + e.escapeRegex(o.radixPoint) + "]", r = new RegExp(s).test(t);
                            return r && i.validPositions[n] && i.validPositions[n].match.placeholder === o.radixPoint && (r = {caret: n + 1}), r
                        }, cardinality: 1, placeholder: function (e) {
                            return e.radixPoint
                        }
                    }
                },
                onUnMask: function (t, i, n) {
                    if ("" === i && !0 === n.nullable) return i;
                    var a = t.replace(n.prefix, "");
                    return a = (a = a.replace(n.suffix, "")).replace(new RegExp(e.escapeRegex(n.groupSeparator), "g"), ""), "" !== n.placeholder.charAt(0) && (a = a.replace(new RegExp(n.placeholder.charAt(0), "g"), "0")), n.unmaskAsNumber ? ("" !== n.radixPoint && -1 !== a.indexOf(n.radixPoint) && (a = a.replace(e.escapeRegex.call(this, n.radixPoint), ".")), a = (a = a.replace(new RegExp("^" + e.escapeRegex(n.negationSymbol.front)), "-")).replace(new RegExp(e.escapeRegex(n.negationSymbol.back) + "$"), ""), Number(a)) : a
                },
                isComplete: function (t, i) {
                    var n = (i.numericInput ? t.slice().reverse() : t).join("");
                    return n = (n = (n = (n = (n = n.replace(new RegExp("^" + e.escapeRegex(i.negationSymbol.front)), "-")).replace(new RegExp(e.escapeRegex(i.negationSymbol.back) + "$"), "")).replace(i.prefix, "")).replace(i.suffix, "")).replace(new RegExp(e.escapeRegex(i.groupSeparator) + "([0-9]{3})", "g"), "$1"), "," === i.radixPoint && (n = n.replace(e.escapeRegex(i.radixPoint), ".")), isFinite(n)
                },
                onBeforeMask: function (i, n) {
                    n.isNegative = void 0;
                    var a = n.radixPoint || ",";
                    "number" != typeof i && "number" !== n.inputType || "" === a || (i = i.toString().replace(".", a));
                    var o = i.split(a), s = o[0].replace(/[^\-0-9]/g, ""),
                        r = o.length > 1 ? o[1].replace(/[^0-9]/g, "") : "";
                    i = s + ("" !== r ? a + r : r);
                    var l = 0;
                    if ("" !== a && (l = r.length, "" !== r)) {
                        var c = Math.pow(10, l || 1);
                        isFinite(n.digits) && (l = parseInt(n.digits), c = Math.pow(10, l)), i = i.replace(e.escapeRegex(a), "."), isFinite(i) && (i = Math.round(parseFloat(i) * c) / c), i = i.toString().replace(".", a)
                    }
                    return 0 === n.digits && -1 !== i.indexOf(e.escapeRegex(a)) && (i = i.substring(0, i.indexOf(e.escapeRegex(a)))), function (e, i, n) {
                        if (i > 0) {
                            var a = t.inArray(n.radixPoint, e);
                            -1 === a && (e.push(n.radixPoint), a = e.length - 1);
                            for (var o = 1; o <= i; o++) e[a + o] = e[a + o] || "0"
                        }
                        return e
                    }(i.toString().split(""), l, n).join("")
                },
                onKeyDown: function (i, n, a, o) {
                    var s = t(this);
                    if (i.ctrlKey) switch (i.keyCode) {
                        case e.keyCode.UP:
                            s.val(parseFloat(this.inputmask.unmaskedvalue()) + parseInt(o.step)), s.trigger("setvalue");
                            break;
                        case e.keyCode.DOWN:
                            s.val(parseFloat(this.inputmask.unmaskedvalue()) - parseInt(o.step)), s.trigger("setvalue")
                    }
                }
            },
            currency: {
                prefix: "$ ",
                groupSeparator: ",",
                alias: "numeric",
                placeholder: "0",
                autoGroup: !0,
                digits: 2,
                digitsOptional: !1,
                clearMaskOnLostFocus: !1
            },
            decimal: {alias: "numeric"},
            integer: {alias: "numeric", digits: 0, radixPoint: ""},
            percentage: {
                alias: "numeric",
                digits: 2,
                digitsOptional: !0,
                radixPoint: ".",
                placeholder: "0",
                autoGroup: !1,
                min: 0,
                max: 100,
                suffix: " %",
                allowMinus: !1
            }
        }), e
    }) ? n.apply(t, a) : n) || (e.exports = o)
}, function (e, t, i) {
    "use strict";
    var n, a, o, s = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
        return typeof e
    } : function (e) {
        return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
    };
    a = [i(4), i(2)], void 0 === (o = "function" == typeof (n = function (e, t) {
        return void 0 === e.fn.inputmask && (e.fn.inputmask = function (i, n) {
            var a, o = this[0];
            if (void 0 === n && (n = {}), "string" == typeof i) switch (i) {
                case"unmaskedvalue":
                    return o && o.inputmask ? o.inputmask.unmaskedvalue() : e(o).val();
                case"remove":
                    return this.each((function () {
                        this.inputmask && this.inputmask.remove()
                    }));
                case"getemptymask":
                    return o && o.inputmask ? o.inputmask.getemptymask() : "";
                case"hasMaskedValue":
                    return !(!o || !o.inputmask) && o.inputmask.hasMaskedValue();
                case"isComplete":
                    return !o || !o.inputmask || o.inputmask.isComplete();
                case"getmetadata":
                    return o && o.inputmask ? o.inputmask.getmetadata() : void 0;
                case"setvalue":
                    t.setValue(o, n);
                    break;
                case"option":
                    if ("string" != typeof n) return this.each((function () {
                        if (void 0 !== this.inputmask) return this.inputmask.option(n)
                    }));
                    if (o && void 0 !== o.inputmask) return o.inputmask.option(n);
                    break;
                default:
                    return n.alias = i, a = new t(n), this.each((function () {
                        a.mask(this)
                    }))
            } else {
                if (Array.isArray(i)) return n.alias = i, a = new t(n), this.each((function () {
                    a.mask(this)
                }));
                if ("object" == (void 0 === i ? "undefined" : s(i))) return a = new t(i), void 0 === i.mask && void 0 === i.alias ? this.each((function () {
                    if (void 0 !== this.inputmask) return this.inputmask.option(i);
                    a.mask(this)
                })) : this.each((function () {
                    a.mask(this)
                }));
                if (void 0 === i) return this.each((function () {
                    (a = new t(n)).mask(this)
                }))
            }
        }), e.fn.inputmask
    }) ? n.apply(t, a) : n) || (e.exports = o)
}]);

// common
function getURLVar(key) {
    var value = [];

    var query = String(document.location).split('?');

    if (query[1]) {
        var part = query[1].split('&');

        for (i = 0; i < part.length; i++) {
            var data = part[i].split('=');

            if (data[0] && data[1]) {
                value[data[0]] = data[1];
            }
        }

        if (value[key]) {
            return value[key];
        } else {
            return '';
        }
    }
}

$(document).ready(function () {

    // Highlight any found errors
    $('.text-danger').each(function () {
        var element = $(this).parent().parent();

        if (element.hasClass('form-group')) {
            element.addClass('has-error');
        }
    });

    // Currency
    $('body').on('click', '#form-currency .currency-select', function (e) {
        e.preventDefault();

        $('#form-currency input[name=\'code\']').val($(this).attr('name'));

        $('#form-currency').submit();
    });

    // Language
    $('body').on('click', '#form-language .language-select', function (e) {
        e.preventDefault();

        $('#form-language input[name=\'code\']').val($(this).attr('name'));

        $('#form-language').submit();
    });

    /* Search */
    $('#search input[name=\'search\']').parent().find('button').on('click', function () {
        var url = $('base').attr('href') + 'index.php?route=product/search';

        var value = $('#search input[name=\'search\']').val();

        if (!value.length) {
            value = $('header form input[name=\'search\']').val();
        }

        if (value.length > 0) {
            url += '&search=' + encodeURIComponent(value);
            location = url;
        }
    });

    $('#search input[name=\'search\']').on('keydown', function (e) {
        if (e.keyCode == 13) {
            $('#search input[name=\'search\']').parent().find('button').trigger('click');
        }
    });

    const searchForm = document.getElementById('search');
    searchForm.addEventListener('submit', (e) => {
        e.preventDefault();
    });

    /* Blog Search */
    $('#oct-blog-search-button').on('click', function () {
        var url = $('base').attr('href') + 'index.php?route=octemplates/blog/oct_blogsearch';

        var value = $('#blog_search input[name=\'blog_search\']').val();

        if (value.length > 0) {
            url += '&search=' + encodeURIComponent(value);
            location = url;
        }

    });

    $('#blog_search input[name=\'blog_search\']').on('keydown', function (e) {
        if (e.keyCode == 13) {
            $('#oct-blog-search-button').trigger('click');
        }
    });

    // Menu
    $('#menu .dropdown-menu').each(function () {
        var menu = $('#menu').offset();
        var dropdown = $(this).parent().offset();

        var i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu').outerWidth());

        if (i > 0) {
            $(this).css('margin-left', '-' + (i + 10) + 'px');
        }
    });

    // hide tooltip after click
    $("#grid-view, #list-view").mouseleave(function () {
        $('[data-toggle="tooltip"]').tooltip("hide");
    });

    // Checkout
    $(document).on('keydown', '#collapse-checkout-option input[name=\'email\'], #collapse-checkout-option input[name=\'password\']', function (e) {
        if (e.keyCode == 13) {
            $('#collapse-checkout-option #button-login').trigger('click');
        }
    });

    // tooltips on hover
    $('[data-toggle=\'tooltip\']').tooltip({
        container: 'body',
        boundary: 'window'
    });

    // Makes tooltips work on ajax generated content
    $(document).ajaxStop(function () {
        $('[data-toggle=\'tooltip\']').tooltip({
            container: 'body',
            boundary: 'window'
        });
    });
});

// Cart add remove functions
var cart = {
    'add': function (product_id, quantity, page = 0) {
        $.ajax({
            url: 'index.php?route=checkout/cart/add',
            type: 'post',
            data: 'product_id=' + product_id + '&quantity=' + (typeof (quantity) != 'undefined' ? quantity : 1),
            dataType: 'json',
            cache: false,
            beforeSend: function () {
                $('#cart > button').button('loading');
            },
            complete: function () {
                $('#cart > button').button('reset');
            },
            success: function (json) {
                $('.alert-dismissible, .text-danger').remove();

                if (page == 1 && json['error']) {
                    scrollToElement('.sc-product-actions-middle', false, -80);
                    return;
                }

                if (json['redirect']) {
                    location = json['redirect'];
                }

                if (json['error'] && json['error']['error_warning']) {
                    scNotify('danger', '<div class="alert-text-item">' + json['error']['error_warning'] + '</div>');
                }

                if (json['success']) {
                    if (json['isPopup']) {
                        octPopupCart();
                    } else {
                        scNotify('success', json['success']);
                    }

                    let cartIdsHolder = document.querySelector("[data-cart-ids]");

                    if (json.oct_cart_ids && json.oct_cart_ids.length > 0 && cartIdsHolder) {
                        cartIdsHolder.dataset.cartIds = json.oct_cart_ids;
                        setCartBtnAdded();
                    }

                    // Need to set timeout otherwise it wont update the total
                    setTimeout(function () {
                        $('#cart .header-buttons-cart-quantity').html(json['total_products']);
                        $('.rm-header-cart-text').html(json['total_amount']);
                    }, 100);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    },
    'update': function (key, quantity) {
        $.ajax({
            url: 'index.php?route=checkout/cart/edit',
            type: 'post',
            data: 'key=' + key + '&quantity=' + (typeof (quantity) != 'undefined' ? quantity : 1),
            dataType: 'json',
            cache: false,
            beforeSend: function () {
                $('#cart > button').button('loading');
            },
            complete: function () {
                $('#cart > button').button('reset');
            },
            success: function (json) {
                // Need to set timeout otherwise it wont update the total
                setTimeout(function () {
                    $('#cart .header-buttons-cart-quantity').html(json['total_products']);
                    $('.rm-header-cart-text').html(json['total_amount']);
                }, 100);

                var now_location = String(document.location.pathname);

                if ((now_location == '/cart/') || (now_location == '/cart') || (now_location == '/checkout/') || (now_location == '/checkout') || (getURLVar('route') == 'checkout/cart') || (getURLVar('route') == 'checkout/checkout')) {
                    location = 'index.php?route=checkout/cart';
                } else {
                    $('#cart > ul').load('index.php?route=common/cart/info ul li');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    },
    'remove': function (key) {
        $.ajax({
            url: 'index.php?route=checkout/cart/remove',
            type: 'post',
            data: 'key=' + key,
            dataType: 'json',
            cache: false,
            beforeSend: function () {
                $('#cart > button').button('loading');
            },
            complete: function () {
                $('#cart > button').button('reset');
            },
            success: function (json) {
                let cartIdsHolder = document.querySelector("[data-cart-ids]");

                if (json.oct_cart_ids && json.oct_cart_ids.length > 0 && cartIdsHolder) {
                    cartIdsHolder.dataset.cartIds = json.oct_cart_ids;
                }

                // Need to set timeout otherwise it wont update the total
                setTimeout(function () {
                    $('#cart .header-buttons-cart-quantity').html(json['total_products']);
                    $('.rm-header-cart-text').html(json['total_amount']);
                }, 100);

                var now_location = String(document.location.pathname);

                if ((now_location == '/cart/') || (now_location == '/cart') || (now_location == '/checkout/') || (now_location == '/checkout') || (getURLVar('route') == 'checkout/cart') || (getURLVar('route') == 'checkout/checkout')) {
                    location = 'index.php?route=checkout/cart';
                } else {
                    $('#cart > ul').load('index.php?route=common/cart/info ul li');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
}

var voucher = {
    'add': function () {

    },
    'remove': function (key) {
        $.ajax({
            url: 'index.php?route=checkout/cart/remove',
            type: 'post',
            data: 'key=' + key,
            dataType: 'json',
            cache: false,
            beforeSend: function () {
                $('#cart > button').button('loading');
            },
            complete: function () {
                $('#cart > button').button('reset');
            },
            success: function (json) {
                // Need to set timeout otherwise it wont update the total
                setTimeout(function () {
                    $('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
                }, 100);

                var now_location = String(document.location.pathname);

                if ((now_location == '/cart/') || (now_location == '/cart') || (now_location == '/checkout/') || (now_location == '/checkout') || (getURLVar('route') == 'checkout/cart') || (getURLVar('route') == 'checkout/checkout')) {
                    location = 'index.php?route=checkout/cart';
                } else {
                    $('#cart > ul').load('index.php?route=common/cart/info ul li');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
}

var wishlist = {
    'add': function (product_id) {
        $.ajax({
            url: 'index.php?route=account/wishlist/add',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            cache: false,
            success: function (json) {
                $('.alert-dismissible').remove();

                if (json['redirect']) {
                    location = json['redirect'];
                }

                if (json['success']) {
                    scNotify('success', json['success']);
                    $('.header-buttons-wishlist .header-buttons-cart-quantity').html(json['total_wishlist']);
                }

            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    },
    'remove': function (product_id) {
        $.ajax({
            url: 'index.php?route=octemplates/events/helper/wishlistRemove',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            cache: false,
            success: function (json) {

                if (json['success']) {
                    scNotify('success', json['success']);
                    $('.header-buttons-wishlist .header-buttons-cart-quantity').html(json['total_wishlist']);
                }
            }
        });
    }
}

var compare = {
    'add': function (product_id) {
        $.ajax({
            url: 'index.php?route=product/compare/add',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            cache: false,
            success: function (json) {
                $('.alert-dismissible').remove();

                if (json['success']) {
                    scNotify('success', json['success']);
                    $('.header-buttons-compare .header-buttons-cart-quantity').html(json['total_compare']);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    },
    'remove': function (product_id) {
        $.ajax({
            url: 'index.php?route=octemplates/events/helper/compareRemove',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            cache: false,
            success: function (json) {

                if (json['success']) {
                    scNotify('success', json['success']);
                    $('.header-buttons-compare .header-buttons-cart-quantity').html(json['total_compare']);
                }
            }
        });
    }
}

/* Agree to Terms */
$(document).delegate('.agree', 'click', function (e) {
    e.preventDefault();
    masked('body', true);
    $('#modal-agree').remove();

    var element = this,
        link = '';
    var r = $(element).data('rel');

    if (r && r != 'undefined') {
        link = 'index.php?route=information/information/agree&information_id=' + r;
    } else {
        link = $(element).attr('href');
    }

    $.ajax({
        url: link,
        type: 'get',
        dataType: 'html',
        cache: false,
        success: function (data) {
            html = '<div class="modal fade" id="modal-agree" tabindex="-1" role="dialog" aria-labelledby="modal-agree" aria-hidden="true">';
            html += '  <div class="modal-dialog modal-dialog-centered wide">';
            html += '    <div class="modal-content">';
            html += '      <div class="modal-header p-4">';
            html += '        <h5 class="modal-title fsz-20 d-flex align-items-center justify-content-between">' + $(element).text() + '</h5>';
            html += '        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
            html += '      </div>';
            html += '      <div class="modal-body modal-body-agree p-4">' + data + '</div>';
            html += '    </div>';
            html += '  </div>';
            html += '</div>';

            $('body').append(html);
            masked('body', false);
            $('#modal-agree').modal('show');
        }
    });
});

// Autocomplete */
(function ($) {
    $.fn.autocomplete = function (option) {
        return this.each(function () {
            this.timer = null;
            this.items = new Array();

            $.extend(this, option);

            $(this).attr('autocomplete', 'off');

            // Focus
            $(this).on('focus', function () {
                this.request();
            });

            // Blur
            $(this).on('blur', function () {
                setTimeout(function (object) {
                    object.hide();
                }, 200, this);
            });

            // Keydown
            $(this).on('keydown', function (event) {
                switch (event.keyCode) {
                    case 27: // escape
                        this.hide();
                        break;
                    default:
                        this.request();
                        break;
                }
            });

            // Click
            this.click = function (event) {
                event.preventDefault();

                value = $(event.target).parent().attr('data-value');

                if (value && this.items[value]) {
                    this.select(this.items[value]);
                }
            }

            // Show
            this.show = function () {
                var pos = $(this).position();

                $(this).siblings('ul.dropdown-menu').css({
                    top: pos.top + $(this).outerHeight(),
                    left: pos.left
                });

                $(this).siblings('ul.dropdown-menu').show();
            }

            // Hide
            this.hide = function () {
                $(this).siblings('ul.dropdown-menu').hide();
            }

            // Request
            this.request = function () {
                clearTimeout(this.timer);

                this.timer = setTimeout(function (object) {
                    object.source($(object).val(), $.proxy(object.response, object));
                }, 200, this);
            }

            // Response
            this.response = function (json) {
                html = '';

                if (json.length) {
                    for (i = 0; i < json.length; i++) {
                        this.items[json[i]['value']] = json[i];
                    }

                    for (i = 0; i < json.length; i++) {
                        if (!json[i]['category']) {
                            html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
                        }
                    }

                    // Get all the ones with a categories
                    var category = new Array();

                    for (i = 0; i < json.length; i++) {
                        if (json[i]['category']) {
                            if (!category[json[i]['category']]) {
                                category[json[i]['category']] = new Array();
                                category[json[i]['category']]['name'] = json[i]['category'];
                                category[json[i]['category']]['item'] = new Array();
                            }

                            category[json[i]['category']]['item'].push(json[i]);
                        }
                    }

                    for (i in category) {
                        html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';

                        for (j = 0; j < category[i]['item'].length; j++) {
                            html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
                        }
                    }
                }

                if (html) {
                    this.show();
                } else {
                    this.hide();
                }

                $(this).siblings('ul.dropdown-menu').html(html);
            }

            $(this).after('<ul class="dropdown-menu"></ul>');
            $(this).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));

        });
    }
})(window.jQuery);
/*! jQuery UI - v1.11.4 - 2015-10-20
* http://jqueryui.com
* Includes: core.js, widget.js, mouse.js, slider.js
* Copyright 2015 jQuery Foundation and other contributors; Licensed MIT */

(function(e){"function"==typeof define&&define.amd?define(["jquery"],e):e(jQuery)})(function(e){function t(t,s){var n,a,o,r=t.nodeName.toLowerCase();return"area"===r?(n=t.parentNode,a=n.name,t.href&&a&&"map"===n.nodeName.toLowerCase()?(o=e("img[usemap='#"+a+"']")[0],!!o&&i(o)):!1):(/^(input|select|textarea|button|object)$/.test(r)?!t.disabled:"a"===r?t.href||s:s)&&i(t)}function i(t){return e.expr.filters.visible(t)&&!e(t).parents().addBack().filter(function(){return"hidden"===e.css(this,"visibility")}).length}e.ui=e.ui||{},e.extend(e.ui,{version:"1.11.4",keyCode:{BACKSPACE:8,COMMA:188,DELETE:46,DOWN:40,END:35,ENTER:13,ESCAPE:27,HOME:36,LEFT:37,PAGE_DOWN:34,PAGE_UP:33,PERIOD:190,RIGHT:39,SPACE:32,TAB:9,UP:38}}),e.fn.extend({scrollParent:function(t){var i=this.css("position"),s="absolute"===i,n=t?/(auto|scroll|hidden)/:/(auto|scroll)/,a=this.parents().filter(function(){var t=e(this);return s&&"static"===t.css("position")?!1:n.test(t.css("overflow")+t.css("overflow-y")+t.css("overflow-x"))}).eq(0);return"fixed"!==i&&a.length?a:e(this[0].ownerDocument||document)},uniqueId:function(){var e=0;return function(){return this.each(function(){this.id||(this.id="ui-id-"+ ++e)})}}(),removeUniqueId:function(){return this.each(function(){/^ui-id-\d+$/.test(this.id)&&e(this).removeAttr("id")})}}),e.extend(e.expr[":"],{data:e.expr.createPseudo?e.expr.createPseudo(function(t){return function(i){return!!e.data(i,t)}}):function(t,i,s){return!!e.data(t,s[3])},focusable:function(i){return t(i,!isNaN(e.attr(i,"tabindex")))},tabbable:function(i){var s=e.attr(i,"tabindex"),n=isNaN(s);return(n||s>=0)&&t(i,!n)}}),e("<a>").outerWidth(1).jquery||e.each(["Width","Height"],function(t,i){function s(t,i,s,a){return e.each(n,function(){i-=parseFloat(e.css(t,"padding"+this))||0,s&&(i-=parseFloat(e.css(t,"border"+this+"Width"))||0),a&&(i-=parseFloat(e.css(t,"margin"+this))||0)}),i}var n="Width"===i?["Left","Right"]:["Top","Bottom"],a=i.toLowerCase(),o={innerWidth:e.fn.innerWidth,innerHeight:e.fn.innerHeight,outerWidth:e.fn.outerWidth,outerHeight:e.fn.outerHeight};e.fn["inner"+i]=function(t){return void 0===t?o["inner"+i].call(this):this.each(function(){e(this).css(a,s(this,t)+"px")})},e.fn["outer"+i]=function(t,n){return"number"!=typeof t?o["outer"+i].call(this,t):this.each(function(){e(this).css(a,s(this,t,!0,n)+"px")})}}),e.fn.addBack||(e.fn.addBack=function(e){return this.add(null==e?this.prevObject:this.prevObject.filter(e))}),e("<a>").data("a-b","a").removeData("a-b").data("a-b")&&(e.fn.removeData=function(t){return function(i){return arguments.length?t.call(this,e.camelCase(i)):t.call(this)}}(e.fn.removeData)),e.ui.ie=!!/msie [\w.]+/.exec(navigator.userAgent.toLowerCase()),e.fn.extend({focus:function(t){return function(i,s){return"number"==typeof i?this.each(function(){var t=this;setTimeout(function(){e(t).focus(),s&&s.call(t)},i)}):t.apply(this,arguments)}}(e.fn.focus),disableSelection:function(){var e="onselectstart"in document.createElement("div")?"selectstart":"mousedown";return function(){return this.bind(e+".ui-disableSelection",function(e){e.preventDefault()})}}(),enableSelection:function(){return this.unbind(".ui-disableSelection")},zIndex:function(t){if(void 0!==t)return this.css("zIndex",t);if(this.length)for(var i,s,n=e(this[0]);n.length&&n[0]!==document;){if(i=n.css("position"),("absolute"===i||"relative"===i||"fixed"===i)&&(s=parseInt(n.css("zIndex"),10),!isNaN(s)&&0!==s))return s;n=n.parent()}return 0}}),e.ui.plugin={add:function(t,i,s){var n,a=e.ui[t].prototype;for(n in s)a.plugins[n]=a.plugins[n]||[],a.plugins[n].push([i,s[n]])},call:function(e,t,i,s){var n,a=e.plugins[t];if(a&&(s||e.element[0].parentNode&&11!==e.element[0].parentNode.nodeType))for(n=0;a.length>n;n++)e.options[a[n][0]]&&a[n][1].apply(e.element,i)}};var s=0,n=Array.prototype.slice;e.cleanData=function(t){return function(i){var s,n,a;for(a=0;null!=(n=i[a]);a++)try{s=e._data(n,"events"),s&&s.remove&&e(n).triggerHandler("remove")}catch(o){}t(i)}}(e.cleanData),e.widget=function(t,i,s){var n,a,o,r,h={},l=t.split(".")[0];return t=t.split(".")[1],n=l+"-"+t,s||(s=i,i=e.Widget),e.expr[":"][n.toLowerCase()]=function(t){return!!e.data(t,n)},e[l]=e[l]||{},a=e[l][t],o=e[l][t]=function(e,t){return this._createWidget?(arguments.length&&this._createWidget(e,t),void 0):new o(e,t)},e.extend(o,a,{version:s.version,_proto:e.extend({},s),_childConstructors:[]}),r=new i,r.options=e.widget.extend({},r.options),e.each(s,function(t,s){return e.isFunction(s)?(h[t]=function(){var e=function(){return i.prototype[t].apply(this,arguments)},n=function(e){return i.prototype[t].apply(this,e)};return function(){var t,i=this._super,a=this._superApply;return this._super=e,this._superApply=n,t=s.apply(this,arguments),this._super=i,this._superApply=a,t}}(),void 0):(h[t]=s,void 0)}),o.prototype=e.widget.extend(r,{widgetEventPrefix:a?r.widgetEventPrefix||t:t},h,{constructor:o,namespace:l,widgetName:t,widgetFullName:n}),a?(e.each(a._childConstructors,function(t,i){var s=i.prototype;e.widget(s.namespace+"."+s.widgetName,o,i._proto)}),delete a._childConstructors):i._childConstructors.push(o),e.widget.bridge(t,o),o},e.widget.extend=function(t){for(var i,s,a=n.call(arguments,1),o=0,r=a.length;r>o;o++)for(i in a[o])s=a[o][i],a[o].hasOwnProperty(i)&&void 0!==s&&(t[i]=e.isPlainObject(s)?e.isPlainObject(t[i])?e.widget.extend({},t[i],s):e.widget.extend({},s):s);return t},e.widget.bridge=function(t,i){var s=i.prototype.widgetFullName||t;e.fn[t]=function(a){var o="string"==typeof a,r=n.call(arguments,1),h=this;return o?this.each(function(){var i,n=e.data(this,s);return"instance"===a?(h=n,!1):n?e.isFunction(n[a])&&"_"!==a.charAt(0)?(i=n[a].apply(n,r),i!==n&&void 0!==i?(h=i&&i.jquery?h.pushStack(i.get()):i,!1):void 0):e.error("no such method '"+a+"' for "+t+" widget instance"):e.error("cannot call methods on "+t+" prior to initialization; "+"attempted to call method '"+a+"'")}):(r.length&&(a=e.widget.extend.apply(null,[a].concat(r))),this.each(function(){var t=e.data(this,s);t?(t.option(a||{}),t._init&&t._init()):e.data(this,s,new i(a,this))})),h}},e.Widget=function(){},e.Widget._childConstructors=[],e.Widget.prototype={widgetName:"widget",widgetEventPrefix:"",defaultElement:"<div>",options:{disabled:!1,create:null},_createWidget:function(t,i){i=e(i||this.defaultElement||this)[0],this.element=e(i),this.uuid=s++,this.eventNamespace="."+this.widgetName+this.uuid,this.bindings=e(),this.hoverable=e(),this.focusable=e(),i!==this&&(e.data(i,this.widgetFullName,this),this._on(!0,this.element,{remove:function(e){e.target===i&&this.destroy()}}),this.document=e(i.style?i.ownerDocument:i.document||i),this.window=e(this.document[0].defaultView||this.document[0].parentWindow)),this.options=e.widget.extend({},this.options,this._getCreateOptions(),t),this._create(),this._trigger("create",null,this._getCreateEventData()),this._init()},_getCreateOptions:e.noop,_getCreateEventData:e.noop,_create:e.noop,_init:e.noop,destroy:function(){this._destroy(),this.element.unbind(this.eventNamespace).removeData(this.widgetFullName).removeData(e.camelCase(this.widgetFullName)),this.widget().unbind(this.eventNamespace).removeAttr("aria-disabled").removeClass(this.widgetFullName+"-disabled "+"ui-state-disabled"),this.bindings.unbind(this.eventNamespace),this.hoverable.removeClass("ui-state-hover"),this.focusable.removeClass("ui-state-focus")},_destroy:e.noop,widget:function(){return this.element},option:function(t,i){var s,n,a,o=t;if(0===arguments.length)return e.widget.extend({},this.options);if("string"==typeof t)if(o={},s=t.split("."),t=s.shift(),s.length){for(n=o[t]=e.widget.extend({},this.options[t]),a=0;s.length-1>a;a++)n[s[a]]=n[s[a]]||{},n=n[s[a]];if(t=s.pop(),1===arguments.length)return void 0===n[t]?null:n[t];n[t]=i}else{if(1===arguments.length)return void 0===this.options[t]?null:this.options[t];o[t]=i}return this._setOptions(o),this},_setOptions:function(e){var t;for(t in e)this._setOption(t,e[t]);return this},_setOption:function(e,t){return this.options[e]=t,"disabled"===e&&(this.widget().toggleClass(this.widgetFullName+"-disabled",!!t),t&&(this.hoverable.removeClass("ui-state-hover"),this.focusable.removeClass("ui-state-focus"))),this},enable:function(){return this._setOptions({disabled:!1})},disable:function(){return this._setOptions({disabled:!0})},_on:function(t,i,s){var n,a=this;"boolean"!=typeof t&&(s=i,i=t,t=!1),s?(i=n=e(i),this.bindings=this.bindings.add(i)):(s=i,i=this.element,n=this.widget()),e.each(s,function(s,o){function r(){return t||a.options.disabled!==!0&&!e(this).hasClass("ui-state-disabled")?("string"==typeof o?a[o]:o).apply(a,arguments):void 0}"string"!=typeof o&&(r.guid=o.guid=o.guid||r.guid||e.guid++);var h=s.match(/^([\w:-]*)\s*(.*)$/),l=h[1]+a.eventNamespace,u=h[2];u?n.delegate(u,l,r):i.bind(l,r)})},_off:function(t,i){i=(i||"").split(" ").join(this.eventNamespace+" ")+this.eventNamespace,t.unbind(i).undelegate(i),this.bindings=e(this.bindings.not(t).get()),this.focusable=e(this.focusable.not(t).get()),this.hoverable=e(this.hoverable.not(t).get())},_delay:function(e,t){function i(){return("string"==typeof e?s[e]:e).apply(s,arguments)}var s=this;return setTimeout(i,t||0)},_hoverable:function(t){this.hoverable=this.hoverable.add(t),this._on(t,{mouseenter:function(t){e(t.currentTarget).addClass("ui-state-hover")},mouseleave:function(t){e(t.currentTarget).removeClass("ui-state-hover")}})},_focusable:function(t){this.focusable=this.focusable.add(t),this._on(t,{focusin:function(t){e(t.currentTarget).addClass("ui-state-focus")},focusout:function(t){e(t.currentTarget).removeClass("ui-state-focus")}})},_trigger:function(t,i,s){var n,a,o=this.options[t];if(s=s||{},i=e.Event(i),i.type=(t===this.widgetEventPrefix?t:this.widgetEventPrefix+t).toLowerCase(),i.target=this.element[0],a=i.originalEvent)for(n in a)n in i||(i[n]=a[n]);return this.element.trigger(i,s),!(e.isFunction(o)&&o.apply(this.element[0],[i].concat(s))===!1||i.isDefaultPrevented())}},e.each({show:"fadeIn",hide:"fadeOut"},function(t,i){e.Widget.prototype["_"+t]=function(s,n,a){"string"==typeof n&&(n={effect:n});var o,r=n?n===!0||"number"==typeof n?i:n.effect||i:t;n=n||{},"number"==typeof n&&(n={duration:n}),o=!e.isEmptyObject(n),n.complete=a,n.delay&&s.delay(n.delay),o&&e.effects&&e.effects.effect[r]?s[t](n):r!==t&&s[r]?s[r](n.duration,n.easing,a):s.queue(function(i){e(this)[t](),a&&a.call(s[0]),i()})}}),e.widget;var a=!1;e(document).mouseup(function(){a=!1}),e.widget("ui.mouse",{version:"1.11.4",options:{cancel:"input,textarea,button,select,option",distance:1,delay:0},_mouseInit:function(){var t=this;this.element.bind("mousedown."+this.widgetName,function(e){return t._mouseDown(e)}).bind("click."+this.widgetName,function(i){return!0===e.data(i.target,t.widgetName+".preventClickEvent")?(e.removeData(i.target,t.widgetName+".preventClickEvent"),i.stopImmediatePropagation(),!1):void 0}),this.started=!1},_mouseDestroy:function(){this.element.unbind("."+this.widgetName),this._mouseMoveDelegate&&this.document.unbind("mousemove."+this.widgetName,this._mouseMoveDelegate).unbind("mouseup."+this.widgetName,this._mouseUpDelegate)},_mouseDown:function(t){if(!a){this._mouseMoved=!1,this._mouseStarted&&this._mouseUp(t),this._mouseDownEvent=t;var i=this,s=1===t.which,n="string"==typeof this.options.cancel&&t.target.nodeName?e(t.target).closest(this.options.cancel).length:!1;return s&&!n&&this._mouseCapture(t)?(this.mouseDelayMet=!this.options.delay,this.mouseDelayMet||(this._mouseDelayTimer=setTimeout(function(){i.mouseDelayMet=!0},this.options.delay)),this._mouseDistanceMet(t)&&this._mouseDelayMet(t)&&(this._mouseStarted=this._mouseStart(t)!==!1,!this._mouseStarted)?(t.preventDefault(),!0):(!0===e.data(t.target,this.widgetName+".preventClickEvent")&&e.removeData(t.target,this.widgetName+".preventClickEvent"),this._mouseMoveDelegate=function(e){return i._mouseMove(e)},this._mouseUpDelegate=function(e){return i._mouseUp(e)},this.document.bind("mousemove."+this.widgetName,this._mouseMoveDelegate).bind("mouseup."+this.widgetName,this._mouseUpDelegate),t.preventDefault(),a=!0,!0)):!0}},_mouseMove:function(t){if(this._mouseMoved){if(e.ui.ie&&(!document.documentMode||9>document.documentMode)&&!t.button)return this._mouseUp(t);if(!t.which)return this._mouseUp(t)}return(t.which||t.button)&&(this._mouseMoved=!0),this._mouseStarted?(this._mouseDrag(t),t.preventDefault()):(this._mouseDistanceMet(t)&&this._mouseDelayMet(t)&&(this._mouseStarted=this._mouseStart(this._mouseDownEvent,t)!==!1,this._mouseStarted?this._mouseDrag(t):this._mouseUp(t)),!this._mouseStarted)},_mouseUp:function(t){return this.document.unbind("mousemove."+this.widgetName,this._mouseMoveDelegate).unbind("mouseup."+this.widgetName,this._mouseUpDelegate),this._mouseStarted&&(this._mouseStarted=!1,t.target===this._mouseDownEvent.target&&e.data(t.target,this.widgetName+".preventClickEvent",!0),this._mouseStop(t)),a=!1,!1},_mouseDistanceMet:function(e){return Math.max(Math.abs(this._mouseDownEvent.pageX-e.pageX),Math.abs(this._mouseDownEvent.pageY-e.pageY))>=this.options.distance},_mouseDelayMet:function(){return this.mouseDelayMet},_mouseStart:function(){},_mouseDrag:function(){},_mouseStop:function(){},_mouseCapture:function(){return!0}}),e.widget("ui.slider",e.ui.mouse,{version:"1.11.4",widgetEventPrefix:"slide",options:{animate:!1,distance:0,max:100,min:0,orientation:"horizontal",range:!1,step:1,value:0,values:null,change:null,slide:null,start:null,stop:null},numPages:5,_create:function(){this._keySliding=!1,this._mouseSliding=!1,this._animateOff=!0,this._handleIndex=null,this._detectOrientation(),this._mouseInit(),this._calculateNewMax(),this.element.addClass("ui-slider ui-slider-"+this.orientation+" ui-widget"+" ui-widget-content"+" ui-corner-all"),this._refresh(),this._setOption("disabled",this.options.disabled),this._animateOff=!1},_refresh:function(){this._createRange(),this._createHandles(),this._setupEvents(),this._refreshValue()},_createHandles:function(){var t,i,s=this.options,n=this.element.find(".ui-slider-handle").addClass("ui-state-default ui-corner-all"),a="<span class='ui-slider-handle ui-state-default ui-corner-all' tabindex='0'></span>",o=[];for(i=s.values&&s.values.length||1,n.length>i&&(n.slice(i).remove(),n=n.slice(0,i)),t=n.length;i>t;t++)o.push(a);this.handles=n.add(e(o.join("")).appendTo(this.element)),this.handle=this.handles.eq(0),this.handles.each(function(t){e(this).data("ui-slider-handle-index",t)})},_createRange:function(){var t=this.options,i="";t.range?(t.range===!0&&(t.values?t.values.length&&2!==t.values.length?t.values=[t.values[0],t.values[0]]:e.isArray(t.values)&&(t.values=t.values.slice(0)):t.values=[this._valueMin(),this._valueMin()]),this.range&&this.range.length?this.range.removeClass("ui-slider-range-min ui-slider-range-max").css({left:"",bottom:""}):(this.range=e("<div></div>").appendTo(this.element),i="ui-slider-range ui-widget-header ui-corner-all"),this.range.addClass(i+("min"===t.range||"max"===t.range?" ui-slider-range-"+t.range:""))):(this.range&&this.range.remove(),this.range=null)},_setupEvents:function(){this._off(this.handles),this._on(this.handles,this._handleEvents),this._hoverable(this.handles),this._focusable(this.handles)},_destroy:function(){this.handles.remove(),this.range&&this.range.remove(),this.element.removeClass("ui-slider ui-slider-horizontal ui-slider-vertical ui-widget ui-widget-content ui-corner-all"),this._mouseDestroy()},_mouseCapture:function(t){var i,s,n,a,o,r,h,l,u=this,d=this.options;return d.disabled?!1:(this.elementSize={width:this.element.outerWidth(),height:this.element.outerHeight()},this.elementOffset=this.element.offset(),i={x:t.pageX,y:t.pageY},s=this._normValueFromMouse(i),n=this._valueMax()-this._valueMin()+1,this.handles.each(function(t){var i=Math.abs(s-u.values(t));(n>i||n===i&&(t===u._lastChangedValue||u.values(t)===d.min))&&(n=i,a=e(this),o=t)}),r=this._start(t,o),r===!1?!1:(this._mouseSliding=!0,this._handleIndex=o,a.addClass("ui-state-active").focus(),h=a.offset(),l=!e(t.target).parents().addBack().is(".ui-slider-handle"),this._clickOffset=l?{left:0,top:0}:{left:t.pageX-h.left-a.width()/2,top:t.pageY-h.top-a.height()/2-(parseInt(a.css("borderTopWidth"),10)||0)-(parseInt(a.css("borderBottomWidth"),10)||0)+(parseInt(a.css("marginTop"),10)||0)},this.handles.hasClass("ui-state-hover")||this._slide(t,o,s),this._animateOff=!0,!0))},_mouseStart:function(){return!0},_mouseDrag:function(e){var t={x:e.pageX,y:e.pageY},i=this._normValueFromMouse(t);return this._slide(e,this._handleIndex,i),!1},_mouseStop:function(e){return this.handles.removeClass("ui-state-active"),this._mouseSliding=!1,this._stop(e,this._handleIndex),this._change(e,this._handleIndex),this._handleIndex=null,this._clickOffset=null,this._animateOff=!1,!1},_detectOrientation:function(){this.orientation="vertical"===this.options.orientation?"vertical":"horizontal"},_normValueFromMouse:function(e){var t,i,s,n,a;return"horizontal"===this.orientation?(t=this.elementSize.width,i=e.x-this.elementOffset.left-(this._clickOffset?this._clickOffset.left:0)):(t=this.elementSize.height,i=e.y-this.elementOffset.top-(this._clickOffset?this._clickOffset.top:0)),s=i/t,s>1&&(s=1),0>s&&(s=0),"vertical"===this.orientation&&(s=1-s),n=this._valueMax()-this._valueMin(),a=this._valueMin()+s*n,this._trimAlignValue(a)},_start:function(e,t){var i={handle:this.handles[t],value:this.value()};return this.options.values&&this.options.values.length&&(i.value=this.values(t),i.values=this.values()),this._trigger("start",e,i)},_slide:function(e,t,i){var s,n,a;this.options.values&&this.options.values.length?(s=this.values(t?0:1),2===this.options.values.length&&this.options.range===!0&&(0===t&&i>s||1===t&&s>i)&&(i=s),i!==this.values(t)&&(n=this.values(),n[t]=i,a=this._trigger("slide",e,{handle:this.handles[t],value:i,values:n}),s=this.values(t?0:1),a!==!1&&this.values(t,i))):i!==this.value()&&(a=this._trigger("slide",e,{handle:this.handles[t],value:i}),a!==!1&&this.value(i))},_stop:function(e,t){var i={handle:this.handles[t],value:this.value()};this.options.values&&this.options.values.length&&(i.value=this.values(t),i.values=this.values()),this._trigger("stop",e,i)},_change:function(e,t){if(!this._keySliding&&!this._mouseSliding){var i={handle:this.handles[t],value:this.value()};this.options.values&&this.options.values.length&&(i.value=this.values(t),i.values=this.values()),this._lastChangedValue=t,this._trigger("change",e,i)}},value:function(e){return arguments.length?(this.options.value=this._trimAlignValue(e),this._refreshValue(),this._change(null,0),void 0):this._value()},values:function(t,i){var s,n,a;if(arguments.length>1)return this.options.values[t]=this._trimAlignValue(i),this._refreshValue(),this._change(null,t),void 0;if(!arguments.length)return this._values();if(!e.isArray(arguments[0]))return this.options.values&&this.options.values.length?this._values(t):this.value();for(s=this.options.values,n=arguments[0],a=0;s.length>a;a+=1)s[a]=this._trimAlignValue(n[a]),this._change(null,a);this._refreshValue()},_setOption:function(t,i){var s,n=0;switch("range"===t&&this.options.range===!0&&("min"===i?(this.options.value=this._values(0),this.options.values=null):"max"===i&&(this.options.value=this._values(this.options.values.length-1),this.options.values=null)),e.isArray(this.options.values)&&(n=this.options.values.length),"disabled"===t&&this.element.toggleClass("ui-state-disabled",!!i),this._super(t,i),t){case"orientation":this._detectOrientation(),this.element.removeClass("ui-slider-horizontal ui-slider-vertical").addClass("ui-slider-"+this.orientation),this._refreshValue(),this.handles.css("horizontal"===i?"bottom":"left","");break;case"value":this._animateOff=!0,this._refreshValue(),this._change(null,0),this._animateOff=!1;break;case"values":for(this._animateOff=!0,this._refreshValue(),s=0;n>s;s+=1)this._change(null,s);this._animateOff=!1;break;case"step":case"min":case"max":this._animateOff=!0,this._calculateNewMax(),this._refreshValue(),this._animateOff=!1;break;case"range":this._animateOff=!0,this._refresh(),this._animateOff=!1}},_value:function(){var e=this.options.value;return e=this._trimAlignValue(e)},_values:function(e){var t,i,s;if(arguments.length)return t=this.options.values[e],t=this._trimAlignValue(t);if(this.options.values&&this.options.values.length){for(i=this.options.values.slice(),s=0;i.length>s;s+=1)i[s]=this._trimAlignValue(i[s]);return i}return[]},_trimAlignValue:function(e){if(this._valueMin()>=e)return this._valueMin();if(e>=this._valueMax())return this._valueMax();var t=this.options.step>0?this.options.step:1,i=(e-this._valueMin())%t,s=e-i;return 2*Math.abs(i)>=t&&(s+=i>0?t:-t),parseFloat(s.toFixed(5))},_calculateNewMax:function(){var e=this.options.max,t=this._valueMin(),i=this.options.step,s=Math.floor(+(e-t).toFixed(this._precision())/i)*i;e=s+t,this.max=parseFloat(e.toFixed(this._precision()))},_precision:function(){var e=this._precisionOf(this.options.step);return null!==this.options.min&&(e=Math.max(e,this._precisionOf(this.options.min))),e},_precisionOf:function(e){var t=""+e,i=t.indexOf(".");return-1===i?0:t.length-i-1},_valueMin:function(){return this.options.min},_valueMax:function(){return this.max},_refreshValue:function(){var t,i,s,n,a,o=this.options.range,r=this.options,h=this,l=this._animateOff?!1:r.animate,u={};this.options.values&&this.options.values.length?this.handles.each(function(s){i=100*((h.values(s)-h._valueMin())/(h._valueMax()-h._valueMin())),u["horizontal"===h.orientation?"left":"bottom"]=i+"%",e(this).stop(1,1)[l?"animate":"css"](u,r.animate),h.options.range===!0&&("horizontal"===h.orientation?(0===s&&h.range.stop(1,1)[l?"animate":"css"]({left:i+"%"},r.animate),1===s&&h.range[l?"animate":"css"]({width:i-t+"%"},{queue:!1,duration:r.animate})):(0===s&&h.range.stop(1,1)[l?"animate":"css"]({bottom:i+"%"},r.animate),1===s&&h.range[l?"animate":"css"]({height:i-t+"%"},{queue:!1,duration:r.animate}))),t=i}):(s=this.value(),n=this._valueMin(),a=this._valueMax(),i=a!==n?100*((s-n)/(a-n)):0,u["horizontal"===this.orientation?"left":"bottom"]=i+"%",this.handle.stop(1,1)[l?"animate":"css"](u,r.animate),"min"===o&&"horizontal"===this.orientation&&this.range.stop(1,1)[l?"animate":"css"]({width:i+"%"},r.animate),"max"===o&&"horizontal"===this.orientation&&this.range[l?"animate":"css"]({width:100-i+"%"},{queue:!1,duration:r.animate}),"min"===o&&"vertical"===this.orientation&&this.range.stop(1,1)[l?"animate":"css"]({height:i+"%"},r.animate),"max"===o&&"vertical"===this.orientation&&this.range[l?"animate":"css"]({height:100-i+"%"},{queue:!1,duration:r.animate}))},_handleEvents:{keydown:function(t){var i,s,n,a,o=e(t.target).data("ui-slider-handle-index");switch(t.keyCode){case e.ui.keyCode.HOME:case e.ui.keyCode.END:case e.ui.keyCode.PAGE_UP:case e.ui.keyCode.PAGE_DOWN:case e.ui.keyCode.UP:case e.ui.keyCode.RIGHT:case e.ui.keyCode.DOWN:case e.ui.keyCode.LEFT:if(t.preventDefault(),!this._keySliding&&(this._keySliding=!0,e(t.target).addClass("ui-state-active"),i=this._start(t,o),i===!1))return}switch(a=this.options.step,s=n=this.options.values&&this.options.values.length?this.values(o):this.value(),t.keyCode){case e.ui.keyCode.HOME:n=this._valueMin();break;case e.ui.keyCode.END:n=this._valueMax();break;case e.ui.keyCode.PAGE_UP:n=this._trimAlignValue(s+(this._valueMax()-this._valueMin())/this.numPages);break;case e.ui.keyCode.PAGE_DOWN:n=this._trimAlignValue(s-(this._valueMax()-this._valueMin())/this.numPages);break;case e.ui.keyCode.UP:case e.ui.keyCode.RIGHT:if(s===this._valueMax())return;n=this._trimAlignValue(s+a);break;case e.ui.keyCode.DOWN:case e.ui.keyCode.LEFT:if(s===this._valueMin())return;n=this._trimAlignValue(s-a)}this._slide(t,o,n)},keyup:function(t){var i=e(t.target).data("ui-slider-handle-index");this._keySliding&&(this._keySliding=!1,this._stop(t,i),this._change(t,i),e(t.target).removeClass("ui-state-active"))}}})});
!function(a){function f(a,b){if(!(a.originalEvent.touches.length>1)){a.preventDefault();var c=a.originalEvent.changedTouches[0],d=document.createEvent("MouseEvents");d.initMouseEvent(b,!0,!0,window,1,c.screenX,c.screenY,c.clientX,c.clientY,!1,!1,!1,!1,0,null),a.target.dispatchEvent(d)}}if(a.support.touch="ontouchend"in document,a.support.touch){var e,b=a.ui.mouse.prototype,c=b._mouseInit,d=b._mouseDestroy;b._touchStart=function(a){var b=this;!e&&b._mouseCapture(a.originalEvent.changedTouches[0])&&(e=!0,b._touchMoved=!1,f(a,"mouseover"),f(a,"mousemove"),f(a,"mousedown"))},b._touchMove=function(a){e&&(this._touchMoved=!0,f(a,"mousemove"))},b._touchEnd=function(a){e&&(f(a,"mouseup"),f(a,"mouseout"),this._touchMoved||f(a,"click"),e=!1)},b._mouseInit=function(){var b=this;b.element.bind({touchstart:a.proxy(b,"_touchStart"),touchmove:a.proxy(b,"_touchMove"),touchend:a.proxy(b,"_touchEnd")}),c.call(b)},b._mouseDestroy=function(){var b=this;b.element.unbind({touchstart:a.proxy(b,"_touchStart"),touchmove:a.proxy(b,"_touchMove"),touchend:a.proxy(b,"_touchEnd")}),d.call(b)}}}(jQuery);
/*! Magnific Popup - v0.9.9 - 2013-11-15
* http://dimsemenov.com/plugins/magnific-popup/
* Copyright (c) 2013 Dmitry Semenov; */
(function(e){var t,n,i,o,r,a,s,l="Close",c="BeforeClose",d="AfterClose",u="BeforeAppend",p="MarkupParse",f="Open",m="Change",g="mfp",v="."+g,h="mfp-ready",C="mfp-removing",y="mfp-prevent-close",w=function(){},b=!!window.jQuery,I=e(window),x=function(e,n){t.ev.on(g+e+v,n)},k=function(t,n,i,o){var r=document.createElement("div");return r.className="mfp-"+t,i&&(r.innerHTML=i),o?n&&n.appendChild(r):(r=e(r),n&&r.appendTo(n)),r},T=function(n,i){t.ev.triggerHandler(g+n,i),t.st.callbacks&&(n=n.charAt(0).toLowerCase()+n.slice(1),t.st.callbacks[n]&&t.st.callbacks[n].apply(t,e.isArray(i)?i:[i]))},E=function(n){return n===s&&t.currTemplate.closeBtn||(t.currTemplate.closeBtn=e(t.st.closeMarkup.replace("%title%",t.st.tClose)),s=n),t.currTemplate.closeBtn},_=function(){e.magnificPopup.instance||(t=new w,t.init(),e.magnificPopup.instance=t)},S=function(){var e=document.createElement("p").style,t=["ms","O","Moz","Webkit"];if(void 0!==e.transition)return!0;for(;t.length;)if(t.pop()+"Transition"in e)return!0;return!1};w.prototype={constructor:w,init:function(){var n=navigator.appVersion;t.isIE7=-1!==n.indexOf("MSIE 7."),t.isIE8=-1!==n.indexOf("MSIE 8."),t.isLowIE=t.isIE7||t.isIE8,t.isAndroid=/android/gi.test(n),t.isIOS=/iphone|ipad|ipod/gi.test(n),t.supportsTransition=S(),t.probablyMobile=t.isAndroid||t.isIOS||/(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent),i=e(document.body),o=e(document),t.popupsCache={}},open:function(n){var i;if(n.isObj===!1){t.items=n.items.toArray(),t.index=0;var r,s=n.items;for(i=0;s.length>i;i++)if(r=s[i],r.parsed&&(r=r.el[0]),r===n.el[0]){t.index=i;break}}else t.items=e.isArray(n.items)?n.items:[n.items],t.index=n.index||0;if(t.isOpen)return t.updateItemHTML(),void 0;t.types=[],a="",t.ev=n.mainEl&&n.mainEl.length?n.mainEl.eq(0):o,n.key?(t.popupsCache[n.key]||(t.popupsCache[n.key]={}),t.currTemplate=t.popupsCache[n.key]):t.currTemplate={},t.st=e.extend(!0,{},e.magnificPopup.defaults,n),t.fixedContentPos="auto"===t.st.fixedContentPos?!t.probablyMobile:t.st.fixedContentPos,t.st.modal&&(t.st.closeOnContentClick=!1,t.st.closeOnBgClick=!1,t.st.showCloseBtn=!1,t.st.enableEscapeKey=!1),t.bgOverlay||(t.bgOverlay=k("bg").on("click"+v,function(){t.close()}),t.wrap=k("wrap").attr("tabindex",-1).on("click"+v,function(e){t._checkIfClose(e.target)&&t.close()}),t.container=k("container",t.wrap)),t.contentContainer=k("content"),t.st.preloader&&(t.preloader=k("preloader",t.container,t.st.tLoading));var l=e.magnificPopup.modules;for(i=0;l.length>i;i++){var c=l[i];c=c.charAt(0).toUpperCase()+c.slice(1),t["init"+c].call(t)}T("BeforeOpen"),t.st.showCloseBtn&&(t.st.closeBtnInside?(x(p,function(e,t,n,i){n.close_replaceWith=E(i.type)}),a+=" mfp-close-btn-in"):t.wrap.append(E())),t.st.alignTop&&(a+=" mfp-align-top"),t.fixedContentPos?t.wrap.css({overflow:t.st.overflowY,overflowX:"hidden",overflowY:t.st.overflowY}):t.wrap.css({top:I.scrollTop(),position:"absolute"}),(t.st.fixedBgPos===!1||"auto"===t.st.fixedBgPos&&!t.fixedContentPos)&&t.bgOverlay.css({height:o.height(),position:"absolute"}),t.st.enableEscapeKey&&o.on("keyup"+v,function(e){27===e.keyCode&&t.close()}),I.on("resize"+v,function(){t.updateSize()}),t.st.closeOnContentClick||(a+=" mfp-auto-cursor"),a&&t.wrap.addClass(a);var d=t.wH=I.height(),u={};if(t.fixedContentPos&&t._hasScrollBar(d)){var m=t._getScrollbarSize();m&&(u.marginRight=m)}t.fixedContentPos&&(t.isIE7?e("body, html").css("overflow","hidden"):u.overflow="hidden");var g=t.st.mainClass;return t.isIE7&&(g+=" mfp-ie7"),g&&t._addClassToMFP(g),t.updateItemHTML(),T("BuildControls"),e("html").css(u),t.bgOverlay.add(t.wrap).prependTo(document.body),t._lastFocusedEl=document.activeElement,setTimeout(function(){t.content?(t._addClassToMFP(h),t._setFocus()):t.bgOverlay.addClass(h),o.on("focusin"+v,t._onFocusIn)},16),t.isOpen=!0,t.updateSize(d),T(f),n},close:function(){t.isOpen&&(T(c),t.isOpen=!1,t.st.removalDelay&&!t.isLowIE&&t.supportsTransition?(t._addClassToMFP(C),setTimeout(function(){t._close()},t.st.removalDelay)):t._close())},_close:function(){T(l);var n=C+" "+h+" ";if(t.bgOverlay.detach(),t.wrap.detach(),t.container.empty(),t.st.mainClass&&(n+=t.st.mainClass+" "),t._removeClassFromMFP(n),t.fixedContentPos){var i={marginRight:""};t.isIE7?e("body, html").css("overflow",""):i.overflow="",e("html").css(i)}o.off("keyup"+v+" focusin"+v),t.ev.off(v),t.wrap.attr("class","mfp-wrap").removeAttr("style"),t.bgOverlay.attr("class","mfp-bg"),t.container.attr("class","mfp-container"),!t.st.showCloseBtn||t.st.closeBtnInside&&t.currTemplate[t.currItem.type]!==!0||t.currTemplate.closeBtn&&t.currTemplate.closeBtn.detach(),t._lastFocusedEl&&e(t._lastFocusedEl).focus(),t.currItem=null,t.content=null,t.currTemplate=null,t.prevHeight=0,T(d)},updateSize:function(e){if(t.isIOS){var n=document.documentElement.clientWidth/window.innerWidth,i=window.innerHeight*n;t.wrap.css("height",i),t.wH=i}else t.wH=e||I.height();t.fixedContentPos||t.wrap.css("height",t.wH),T("Resize")},updateItemHTML:function(){var n=t.items[t.index];t.contentContainer.detach(),t.content&&t.content.detach(),n.parsed||(n=t.parseEl(t.index));var i=n.type;if(T("BeforeChange",[t.currItem?t.currItem.type:"",i]),t.currItem=n,!t.currTemplate[i]){var o=t.st[i]?t.st[i].markup:!1;T("FirstMarkupParse",o),t.currTemplate[i]=o?e(o):!0}r&&r!==n.type&&t.container.removeClass("mfp-"+r+"-holder");var a=t["get"+i.charAt(0).toUpperCase()+i.slice(1)](n,t.currTemplate[i]);t.appendContent(a,i),n.preloaded=!0,T(m,n),r=n.type,t.container.prepend(t.contentContainer),T("AfterChange")},appendContent:function(e,n){t.content=e,e?t.st.showCloseBtn&&t.st.closeBtnInside&&t.currTemplate[n]===!0?t.content.find(".mfp-close").length||t.content.append(E()):t.content=e:t.content="",T(u),t.container.addClass("mfp-"+n+"-holder"),t.contentContainer.append(t.content)},parseEl:function(n){var i=t.items[n],o=i.type;if(i=i.tagName?{el:e(i)}:{data:i,src:i.src},i.el){for(var r=t.types,a=0;r.length>a;a++)if(i.el.hasClass("mfp-"+r[a])){o=r[a];break}i.src=i.el.attr("data-mfp-src"),i.src||(i.src=i.el.attr("href"))}return i.type=o||t.st.type||"inline",i.index=n,i.parsed=!0,t.items[n]=i,T("ElementParse",i),t.items[n]},addGroup:function(e,n){var i=function(i){i.mfpEl=this,t._openClick(i,e,n)};n||(n={});var o="click.magnificPopup";n.mainEl=e,n.items?(n.isObj=!0,e.off(o).on(o,i)):(n.isObj=!1,n.delegate?e.off(o).on(o,n.delegate,i):(n.items=e,e.off(o).on(o,i)))},_openClick:function(n,i,o){var r=void 0!==o.midClick?o.midClick:e.magnificPopup.defaults.midClick;if(r||2!==n.which&&!n.ctrlKey&&!n.metaKey){var a=void 0!==o.disableOn?o.disableOn:e.magnificPopup.defaults.disableOn;if(a)if(e.isFunction(a)){if(!a.call(t))return!0}else if(a>I.width())return!0;n.type&&(n.preventDefault(),t.isOpen&&n.stopPropagation()),o.el=e(n.mfpEl),o.delegate&&(o.items=i.find(o.delegate)),t.open(o)}},updateStatus:function(e,i){if(t.preloader){n!==e&&t.container.removeClass("mfp-s-"+n),i||"loading"!==e||(i=t.st.tLoading);var o={status:e,text:i};T("UpdateStatus",o),e=o.status,i=o.text,t.preloader.html(i),t.preloader.find("a").on("click",function(e){e.stopImmediatePropagation()}),t.container.addClass("mfp-s-"+e),n=e}},_checkIfClose:function(n){if(!e(n).hasClass(y)){var i=t.st.closeOnContentClick,o=t.st.closeOnBgClick;if(i&&o)return!0;if(!t.content||e(n).hasClass("mfp-close")||t.preloader&&n===t.preloader[0])return!0;if(n===t.content[0]||e.contains(t.content[0],n)){if(i)return!0}else if(o&&e.contains(document,n))return!0;return!1}},_addClassToMFP:function(e){t.bgOverlay.addClass(e),t.wrap.addClass(e)},_removeClassFromMFP:function(e){this.bgOverlay.removeClass(e),t.wrap.removeClass(e)},_hasScrollBar:function(e){return(t.isIE7?o.height():document.body.scrollHeight)>(e||I.height())},_setFocus:function(){(t.st.focus?t.content.find(t.st.focus).eq(0):t.wrap).focus()},_onFocusIn:function(n){return n.target===t.wrap[0]||e.contains(t.wrap[0],n.target)?void 0:(t._setFocus(),!1)},_parseMarkup:function(t,n,i){var o;i.data&&(n=e.extend(i.data,n)),T(p,[t,n,i]),e.each(n,function(e,n){if(void 0===n||n===!1)return!0;if(o=e.split("_"),o.length>1){var i=t.find(v+"-"+o[0]);if(i.length>0){var r=o[1];"replaceWith"===r?i[0]!==n[0]&&i.replaceWith(n):"img"===r?i.is("img")?i.attr("src",n):i.replaceWith('<img src="'+n+'" class="'+i.attr("class")+'" />'):i.attr(o[1],n)}}else t.find(v+"-"+e).html(n)})},_getScrollbarSize:function(){if(void 0===t.scrollbarSize){var e=document.createElement("div");e.id="mfp-sbm",e.style.cssText="width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;",document.body.appendChild(e),t.scrollbarSize=e.offsetWidth-e.clientWidth,document.body.removeChild(e)}return t.scrollbarSize}},e.magnificPopup={instance:null,proto:w.prototype,modules:[],open:function(t,n){return _(),t=t?e.extend(!0,{},t):{},t.isObj=!0,t.index=n||0,this.instance.open(t)},close:function(){return e.magnificPopup.instance&&e.magnificPopup.instance.close()},registerModule:function(t,n){n.options&&(e.magnificPopup.defaults[t]=n.options),e.extend(this.proto,n.proto),this.modules.push(t)},defaults:{disableOn:0,key:null,midClick:!1,mainClass:"",preloader:!0,focus:"",closeOnContentClick:!1,closeOnBgClick:!0,closeBtnInside:!0,showCloseBtn:!0,enableEscapeKey:!0,modal:!1,alignTop:!1,removalDelay:0,fixedContentPos:"auto",fixedBgPos:"auto",overflowY:"auto",closeMarkup:'<button title="%title%" type="button" class="mfp-close">&times;</button>',tClose:"Close (Esc)",tLoading:"Loading..."}},e.fn.magnificPopup=function(n){_();var i=e(this);if("string"==typeof n)if("open"===n){var o,r=b?i.data("magnificPopup"):i[0].magnificPopup,a=parseInt(arguments[1],10)||0;r.items?o=r.items[a]:(o=i,r.delegate&&(o=o.find(r.delegate)),o=o.eq(a)),t._openClick({mfpEl:o},i,r)}else t.isOpen&&t[n].apply(t,Array.prototype.slice.call(arguments,1));else n=e.extend(!0,{},n),b?i.data("magnificPopup",n):i[0].magnificPopup=n,t.addGroup(i,n);return i};var P,O,z,M="inline",B=function(){z&&(O.after(z.addClass(P)).detach(),z=null)};e.magnificPopup.registerModule(M,{options:{hiddenClass:"hide",markup:"",tNotFound:"Content not found"},proto:{initInline:function(){t.types.push(M),x(l+"."+M,function(){B()})},getInline:function(n,i){if(B(),n.src){var o=t.st.inline,r=e(n.src);if(r.length){var a=r[0].parentNode;a&&a.tagName&&(O||(P=o.hiddenClass,O=k(P),P="mfp-"+P),z=r.after(O).detach().removeClass(P)),t.updateStatus("ready")}else t.updateStatus("error",o.tNotFound),r=e("<div>");return n.inlineElement=r,r}return t.updateStatus("ready"),t._parseMarkup(i,{},n),i}}});var F,H="ajax",L=function(){F&&i.removeClass(F)},A=function(){L(),t.req&&t.req.abort()};e.magnificPopup.registerModule(H,{options:{settings:null,cursor:"mfp-ajax-cur",tError:'<a href="%url%">The content</a> could not be loaded.'},proto:{initAjax:function(){t.types.push(H),F=t.st.ajax.cursor,x(l+"."+H,A),x("BeforeChange."+H,A)},getAjax:function(n){F&&i.addClass(F),t.updateStatus("loading");var o=e.extend({url:n.src,success:function(i,o,r){var a={data:i,xhr:r};T("ParseAjax",a),t.appendContent(e(a.data),H),n.finished=!0,L(),t._setFocus(),setTimeout(function(){t.wrap.addClass(h)},16),t.updateStatus("ready"),T("AjaxContentAdded")},error:function(){L(),n.finished=n.loadError=!0,t.updateStatus("error",t.st.ajax.tError.replace("%url%",n.src))}},t.st.ajax.settings);return t.req=e.ajax(o),""}}});var j,N=function(n){if(n.data&&void 0!==n.data.title)return n.data.title;var i=t.st.image.titleSrc;if(i){if(e.isFunction(i))return i.call(t,n);if(n.el)return n.el.attr(i)||""}return""};e.magnificPopup.registerModule("image",{options:{markup:'<div class="mfp-figure"><div class="mfp-close"></div><figure><div class="mfp-img"></div><figcaption><div class="mfp-bottom-bar"><div class="mfp-title"></div><div class="mfp-counter"></div></div></figcaption></figure></div>',cursor:"mfp-zoom-out-cur",titleSrc:"title",verticalFit:!0,tError:'<a href="%url%">The image</a> could not be loaded.'},proto:{initImage:function(){var e=t.st.image,n=".image";t.types.push("image"),x(f+n,function(){"image"===t.currItem.type&&e.cursor&&i.addClass(e.cursor)}),x(l+n,function(){e.cursor&&i.removeClass(e.cursor),I.off("resize"+v)}),x("Resize"+n,t.resizeImage),t.isLowIE&&x("AfterChange",t.resizeImage)},resizeImage:function(){var e=t.currItem;if(e&&e.img&&t.st.image.verticalFit){var n=0;t.isLowIE&&(n=parseInt(e.img.css("padding-top"),10)+parseInt(e.img.css("padding-bottom"),10)),e.img.css("max-height",t.wH-n)}},_onImageHasSize:function(e){e.img&&(e.hasSize=!0,j&&clearInterval(j),e.isCheckingImgSize=!1,T("ImageHasSize",e),e.imgHidden&&(t.content&&t.content.removeClass("mfp-loading"),e.imgHidden=!1))},findImageSize:function(e){var n=0,i=e.img[0],o=function(r){j&&clearInterval(j),j=setInterval(function(){return i.naturalWidth>0?(t._onImageHasSize(e),void 0):(n>200&&clearInterval(j),n++,3===n?o(10):40===n?o(50):100===n&&o(500),void 0)},r)};o(1)},getImage:function(n,i){var o=0,r=function(){n&&(n.img[0].complete?(n.img.off(".mfploader"),n===t.currItem&&(t._onImageHasSize(n),t.updateStatus("ready")),n.hasSize=!0,n.loaded=!0,T("ImageLoadComplete")):(o++,200>o?setTimeout(r,100):a()))},a=function(){n&&(n.img.off(".mfploader"),n===t.currItem&&(t._onImageHasSize(n),t.updateStatus("error",s.tError.replace("%url%",n.src))),n.hasSize=!0,n.loaded=!0,n.loadError=!0)},s=t.st.image,l=i.find(".mfp-img");if(l.length){var c=document.createElement("img");c.className="mfp-img",n.img=e(c).on("load.mfploader",r).on("error.mfploader",a),c.src=n.src,l.is("img")&&(n.img=n.img.clone()),n.img[0].naturalWidth>0&&(n.hasSize=!0)}return t._parseMarkup(i,{title:N(n),img_replaceWith:n.img},n),t.resizeImage(),n.hasSize?(j&&clearInterval(j),n.loadError?(i.addClass("mfp-loading"),t.updateStatus("error",s.tError.replace("%url%",n.src))):(i.removeClass("mfp-loading"),t.updateStatus("ready")),i):(t.updateStatus("loading"),n.loading=!0,n.hasSize||(n.imgHidden=!0,i.addClass("mfp-loading"),t.findImageSize(n)),i)}}});var W,R=function(){return void 0===W&&(W=void 0!==document.createElement("p").style.MozTransform),W};e.magnificPopup.registerModule("zoom",{options:{enabled:!1,easing:"ease-in-out",duration:300,opener:function(e){return e.is("img")?e:e.find("img")}},proto:{initZoom:function(){var e,n=t.st.zoom,i=".zoom";if(n.enabled&&t.supportsTransition){var o,r,a=n.duration,s=function(e){var t=e.clone().removeAttr("style").removeAttr("class").addClass("mfp-animated-image"),i="all "+n.duration/1e3+"s "+n.easing,o={position:"fixed",zIndex:9999,left:0,top:0,"-webkit-backface-visibility":"hidden"},r="transition";return o["-webkit-"+r]=o["-moz-"+r]=o["-o-"+r]=o[r]=i,t.css(o),t},d=function(){t.content.css("visibility","visible")};x("BuildControls"+i,function(){if(t._allowZoom()){if(clearTimeout(o),t.content.css("visibility","hidden"),e=t._getItemToZoom(),!e)return d(),void 0;r=s(e),r.css(t._getOffset()),t.wrap.append(r),o=setTimeout(function(){r.css(t._getOffset(!0)),o=setTimeout(function(){d(),setTimeout(function(){r.remove(),e=r=null,T("ZoomAnimationEnded")},16)},a)},16)}}),x(c+i,function(){if(t._allowZoom()){if(clearTimeout(o),t.st.removalDelay=a,!e){if(e=t._getItemToZoom(),!e)return;r=s(e)}r.css(t._getOffset(!0)),t.wrap.append(r),t.content.css("visibility","hidden"),setTimeout(function(){r.css(t._getOffset())},16)}}),x(l+i,function(){t._allowZoom()&&(d(),r&&r.remove(),e=null)})}},_allowZoom:function(){return"image"===t.currItem.type},_getItemToZoom:function(){return t.currItem.hasSize?t.currItem.img:!1},_getOffset:function(n){var i;i=n?t.currItem.img:t.st.zoom.opener(t.currItem.el||t.currItem);var o=i.offset(),r=parseInt(i.css("padding-top"),10),a=parseInt(i.css("padding-bottom"),10);o.top-=e(window).scrollTop()-r;var s={width:i.width(),height:(b?i.innerHeight():i[0].offsetHeight)-a-r};return R()?s["-moz-transform"]=s.transform="translate("+o.left+"px,"+o.top+"px)":(s.left=o.left,s.top=o.top),s}}});var Z="iframe",q="//about:blank",D=function(e){if(t.currTemplate[Z]){var n=t.currTemplate[Z].find("iframe");n.length&&(e||(n[0].src=q),t.isIE8&&n.css("display",e?"block":"none"))}};e.magnificPopup.registerModule(Z,{options:{markup:'<div class="mfp-iframe-scaler"><div class="mfp-close"></div><iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe></div>',srcAction:"iframe_src",patterns:{youtube:{index:"youtube.com",id:"v=",src:"//www.youtube.com/embed/%id%?autoplay=1"},vimeo:{index:"vimeo.com/",id:"/",src:"//player.vimeo.com/video/%id%?autoplay=1"},gmaps:{index:"//maps.google.",src:"%id%&output=embed"}}},proto:{initIframe:function(){t.types.push(Z),x("BeforeChange",function(e,t,n){t!==n&&(t===Z?D():n===Z&&D(!0))}),x(l+"."+Z,function(){D()})},getIframe:function(n,i){var o=n.src,r=t.st.iframe;e.each(r.patterns,function(){return o.indexOf(this.index)>-1?(this.id&&(o="string"==typeof this.id?o.substr(o.lastIndexOf(this.id)+this.id.length,o.length):this.id.call(this,o)),o=this.src.replace("%id%",o),!1):void 0});var a={};return r.srcAction&&(a[r.srcAction]=o),t._parseMarkup(i,a,n),t.updateStatus("ready"),i}}});var K=function(e){var n=t.items.length;return e>n-1?e-n:0>e?n+e:e},Y=function(e,t,n){return e.replace(/%curr%/gi,t+1).replace(/%total%/gi,n)};e.magnificPopup.registerModule("gallery",{options:{enabled:!1,arrowMarkup:'<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',preload:[0,2],navigateByImgClick:!0,arrows:!0,tPrev:"Previous (Left arrow key)",tNext:"Next (Right arrow key)",tCounter:"%curr% of %total%"},proto:{initGallery:function(){var n=t.st.gallery,i=".mfp-gallery",r=Boolean(e.fn.mfpFastClick);return t.direction=!0,n&&n.enabled?(a+=" mfp-gallery",x(f+i,function(){n.navigateByImgClick&&t.wrap.on("click"+i,".mfp-img",function(){return t.items.length>1?(t.next(),!1):void 0}),o.on("keydown"+i,function(e){37===e.keyCode?t.prev():39===e.keyCode&&t.next()})}),x("UpdateStatus"+i,function(e,n){n.text&&(n.text=Y(n.text,t.currItem.index,t.items.length))}),x(p+i,function(e,i,o,r){var a=t.items.length;o.counter=a>1?Y(n.tCounter,r.index,a):""}),x("BuildControls"+i,function(){if(t.items.length>1&&n.arrows&&!t.arrowLeft){var i=n.arrowMarkup,o=t.arrowLeft=e(i.replace(/%title%/gi,n.tPrev).replace(/%dir%/gi,"left")).addClass(y),a=t.arrowRight=e(i.replace(/%title%/gi,n.tNext).replace(/%dir%/gi,"right")).addClass(y),s=r?"mfpFastClick":"click";o[s](function(){t.prev()}),a[s](function(){t.next()}),t.isIE7&&(k("b",o[0],!1,!0),k("a",o[0],!1,!0),k("b",a[0],!1,!0),k("a",a[0],!1,!0)),t.container.append(o.add(a))}}),x(m+i,function(){t._preloadTimeout&&clearTimeout(t._preloadTimeout),t._preloadTimeout=setTimeout(function(){t.preloadNearbyImages(),t._preloadTimeout=null},16)}),x(l+i,function(){o.off(i),t.wrap.off("click"+i),t.arrowLeft&&r&&t.arrowLeft.add(t.arrowRight).destroyMfpFastClick(),t.arrowRight=t.arrowLeft=null}),void 0):!1},next:function(){t.direction=!0,t.index=K(t.index+1),t.updateItemHTML()},prev:function(){t.direction=!1,t.index=K(t.index-1),t.updateItemHTML()},goTo:function(e){t.direction=e>=t.index,t.index=e,t.updateItemHTML()},preloadNearbyImages:function(){var e,n=t.st.gallery.preload,i=Math.min(n[0],t.items.length),o=Math.min(n[1],t.items.length);for(e=1;(t.direction?o:i)>=e;e++)t._preloadItem(t.index+e);for(e=1;(t.direction?i:o)>=e;e++)t._preloadItem(t.index-e)},_preloadItem:function(n){if(n=K(n),!t.items[n].preloaded){var i=t.items[n];i.parsed||(i=t.parseEl(n)),T("LazyLoad",i),"image"===i.type&&(i.img=e('<img class="mfp-img" />').on("load.mfploader",function(){i.hasSize=!0}).on("error.mfploader",function(){i.hasSize=!0,i.loadError=!0,T("LazyLoadError",i)}).attr("src",i.src)),i.preloaded=!0}}}});var U="retina";e.magnificPopup.registerModule(U,{options:{replaceSrc:function(e){return e.src.replace(/\.\w+$/,function(e){return"@2x"+e})},ratio:1},proto:{initRetina:function(){if(window.devicePixelRatio>1){var e=t.st.retina,n=e.ratio;n=isNaN(n)?n():n,n>1&&(x("ImageHasSize."+U,function(e,t){t.img.css({"max-width":t.img[0].naturalWidth/n,width:"100%"})}),x("ElementParse."+U,function(t,i){i.src=e.replaceSrc(i,n)}))}}}}),function(){var t=1e3,n="ontouchstart"in window,i=function(){I.off("touchmove"+r+" touchend"+r)},o="mfpFastClick",r="."+o;e.fn.mfpFastClick=function(o){return e(this).each(function(){var a,s=e(this);if(n){var l,c,d,u,p,f;s.on("touchstart"+r,function(e){u=!1,f=1,p=e.originalEvent?e.originalEvent.touches[0]:e.touches[0],c=p.clientX,d=p.clientY,I.on("touchmove"+r,function(e){p=e.originalEvent?e.originalEvent.touches:e.touches,f=p.length,p=p[0],(Math.abs(p.clientX-c)>10||Math.abs(p.clientY-d)>10)&&(u=!0,i())}).on("touchend"+r,function(e){i(),u||f>1||(a=!0,e.preventDefault(),clearTimeout(l),l=setTimeout(function(){a=!1},t),o())})})}s.on("click"+r,function(){a||o()})})},e.fn.destroyMfpFastClick=function(){e(this).off("touchstart"+r+" click"+r),n&&I.off("touchmove"+r+" touchend"+r)}}(),_()})(window.jQuery||window.Zepto);
function submitPreOrder() {
	$.ajax({
		url: 'index.php?route=extension/module/preorder',
		type: 'post',
		dataType: 'json',
		data: $("#form-preorder").serialize(),
		success: function(json) {
			$('.alert-success, .alert-danger').remove();
				
			if (json['error']) {
				$('.preorder-alert').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('.preorder-alert').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				setTimeout(function () {
					$('#preorder-box').modal('hide');
				}, 2000);
			}
		}
	});
}

function addPreOrder(option_status, product_id, module_id) {
	$('#preorder-box').remove();
	
	if (option_status) {
		var product = '#product' + (typeof(module_id) != 'undefined' ? module_id + product_id : '');
		var product_option = $(product + ' input[type=\'radio\']:checked, ' + product + ' input[type=\'checkbox\']:checked, ' + product + ' select, ' + product + ' input[type=\'hidden\']');
	} else {
		var product_option = '';
	}
	
	$.ajax({
		url: 'index.php?route=extension/module/preorder/form&product_id=' + product_id,
		type: 'post',
		dataType: 'json',
		data: product_option,
		success: function(json) {
			if (json) {
				html  = '<div id="preorder-box" class="modal fade">';
				html += '<div class="modal-dialog">';
				html += '<div class="modal-content">';
				html += '<div class="modal-header">';
				html += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>';
				
				if (json['text_title']) {
					html += '<h3 class="modal-title preorder-form-title">' + json['text_title'] + '</h3>';

					html += '<div class="modal-description preorder-form-description">' + json['product'] + '</div>';
				}
				
				if (json['text_top']) {
					html += json['text_top'];
				}
				
				html += '</div>';
				html += '<div class="modal-body">';
				html += '<div class="preorder-alert"></div>';
				html += '<div class="row">';
					/*html += '<div class="col-md-4" >';
						html += '<div class="image">';
						html += '<a href="' + json['href'] + '"><img src="' + json['image'] + '" class="img-responsive" /></a>';
						html += '</div>';
						html += '<h4 class="text-center"><a href="' + json['href'] + '">' + json['product'] + '</a></h4>';
					html += '</div>';*/
				html += '<div class="col-md-12">';
				html += '<form class="form-horizontal" id="form-preorder" accept-charset="UTF-8">';
				
				if (json['field_name'] > 0) {
					html += '<div class="form-group' + ((json['field_name'] == 2) ? ' required' : '') + '">';
					html += '<div class="col-xs-12 col-md-3 p-xs-0">';
					html += '<label class="control-label" for="input-preorder-name">' + json['entry_name'] + '</label>';	  
					html += '</div>';
					html += '<div class="col-xs-12 col-md-9 p-xs-0">';
					html += '<input type="text" name="name" value="' + json['name'] + '" id="input-preorder-name" class="form-control">';
					html += '</div>';
					html += '</div>';
				}
				
				if (json['field_email'] > 0) {
					html += '<div class="form-group' + ((json['field_email'] == 2) ? ' required' : '') + '">';
					html += '<div class="col-xs-12 col-md-3 p-xs-0">';
					html += '<label class="control-label" for="input-preorder-email">' + json['entry_email'] + '</label>';	  
					html += '</div>';
					html += '<div class="col-xs-12 col-md-9 p-xs-0">';
					html += '<input type="email" name="email" value="' + json['email'] + '" id="input-preorder-email" class="form-control">';
					html += '</div>';
					html += '</div>';
				}
				
				if (json['field_phone'] > 0) {
					html += '<div class="form-group' + ((json['field_phone'] == 2) ? ' required' : '') + '">';
					html += '<div class="col-sm-3">';
					html += '<label class="control-label" for="input-preorder-phone">' + json['entry_phone'] + '</label>';	  
					html += '</div>';
					html += '<div class="col-sm-9">';
					
					countries = json['preorder_countries'];
					
					if (json['phone_mask'] == 1 && countries.length > 0) {

						if (countries.length > 1) {
							html += '<div class="input-group">';
							html += '<label class="input-group-addon dropdown-toggle code" data-toggle="dropdown"></label>';
							html += '<div class="dropdown-menu countries">';
							html += '<div>';
							
							countries.forEach(function(country, i, countries) {
								html += '<div class="dropdown-item">';
								html += '<button onclick="selectCountryPreOrder(this);" data-image="' + country['image'] + '" data-code="' + country['code'] + '" data-mask="' + country['mask'] + '" type="button" class="btn btn-link btn-block' + country['default'] + country['customer_default'] + '"><span>' + (country['image'] ? '<img src="' + country['image'] + '" alt="' + country['name'] + '" /> ' : '') + country['name'] + '</span> <span>' + country['code'] + '</span></button>';
								html += '</div>';
							});

							html += '</div>';
							html += '</div>';

							html += '<input type="hidden" name="code" value="">';
							html += '<input type="tel" name="phone" value="' + json['phone'] + '" id="input-preorder-phone" class="form-control">';
							html += '</div>';
						} else {
							countries.forEach(function(country, i, countries) {
								if (country['code']) {
									html += '<div class="input-group">';
									html += '<label class="input-group-addon">' + (country['image'] ? '<img src="' + country['image'] + '" alt="' + country['name'] + '" /> ' : '') + country['code'] + '</label>';
									html += '<input type="hidden" name="code" value="' + country['code'] + '">';
									html += '<input data-mask="' + country['mask'] + '" type="tel" name="phone" value="' + json['phone'] + '" id="input-preorder-phone" class="form-control">';
									html += '</div>';
								} else {
									html += '<input data-mask="' + country['mask'] + '" type="tel" name="phone" value="' + json['phone'] + '" id="input-preorder-phone" class="form-control">';
								}
							});
						}
					} else {
						html += '<input type="tel" name="phone" value="' + json['phone'] + '" id="input-preorder-phone" class="form-control">';
					}
					
					html += '</div>';
					html += '</div>';
				}
				
				if (json['captcha']) {
					html += json['captcha'];
				}
				
				if (json['field_agree'] > 0) {
					html += '<div class="form-group">';
					html += '<div class="col-sm-12">';
					html += '<div class="checkbox">';
					html += '<label>';
					html += '<input type="checkbox" name="agree" value="1"> ' + json['text_agree'];
					html += '</label>';
					html += '</div>';
					html += '</div>';
					html += '</div>';
				}
				
				html += '<input type="hidden" name="product_id" value="' + product_id + '" />';
				
				if (json['product_option']) {
					$.each(json['product_option'], function(index, value) {
						html += '<input type="hidden" name="product_option[' + index + ']" value="' + value + '">';
					});
				}
				
				html += '</form>';
				html += '</div>';
				html += '</div>';
				html += '</div>';
				html += '<div class="modal-footer">';
				
				if (json['text_bottom']) {
					html += '<div class="text-left">';
					html += json['text_bottom'];
					html += '</div>';
				}
				
				html += '<button type="button" class="btn btn-primary" onclick="submitPreOrder();">' + json['button_submit'] + '</button>';
				html += '</div>';
				html += '</div>';
				html += '</div>';
				html += '</div>';
				
				$('body').append(html);
				
				if (json['field_phone'] != 0 && json['phone_mask'] == 1 && countries.length != 0) {
					if (countries.length > 1) {
						if ($('#form-preorder .countries .customer_default').length == 1) {
							country_default = $('#form-preorder .countries .customer_default');
						} else {
							country_default = $('#form-preorder .countries .default');
						}
						$('#form-preorder .code').html((country_default.data('image') ? '<img src="' + country_default.data('image') + '" alt="' + country_default.data('name') + '" /> ' : '') + country_default.data('code'));
						$('#form-preorder input[name=\'phone\']').inputmask(country_default.data('mask'));
						$('#form-preorder input[name=\'code\']').val(country_default.data('code'));
					} else {
						$('#form-preorder input[name=\'phone\']').inputmask($('#form-preorder input[name=\'phone\']').data('mask'));
					}
				}
				
				$("#preorder-box").modal('show');
			}
		}
	});
}

function selectCountryPreOrder(data) {
	$('#form-preorder .code').html(($(data).data('image') ? '<img src="' + $(data).data('image') + '" alt="' + $(data).data('name') + '" /> ' : '') + $(data).data('code'));
	$('#form-preorder input[name=\'phone\']').inputmask($(data).data('mask'));
	$('#form-preorder input[name=\'code\']').val($(data).data('code'));
}

function changeOptionPreOrder(id) {
	var product = '#product' + id;
	var out_of_stock = false;
	
	$(product + ' input:checked, ' + product + ' option:selected').each(function() {
		if ($(this).data('preorder-quantity') <= 0) {
			out_of_stock = true;
			return false;
		}
	});
	
	if (out_of_stock) {
		
		if ($('.preorder-stock-status' + id).length > 0) {
			$('.preorder-stock-status' + id).html($('.preorder-stock-status' + id).data('preorder-outstock'));
		}
		
		$('#button-preorder' + id).show(); 
		$('#button-cart' + id).hide();
	} else {
		
		if ($('.preorder-stock-status' + id).length > 0) {
			$('.preorder-stock-status' + id).html($('.preorder-stock-status' + id).data('preorder-stock'));
		}
		
		$('#button-preorder' + id).hide(); 
		$('#button-cart' + id).show();
	}
}
/*! lightgallery - v1.6.9 - 2018-04-03
* http://sachinchoolur.github.io/lightGallery/
* Copyright (c) 2018 Sachin N; Licensed GPLv3 */
!function(a,b){"function"==typeof define&&define.amd?define(["jquery"],function(a){return b(a)}):"object"==typeof module&&module.exports?module.exports=b(require("jquery")):b(a.jQuery)}(this,function(a){!function(){"use strict";function b(b,d){if(this.el=b,this.$el=a(b),this.s=a.extend({},c,d),this.s.dynamic&&"undefined"!==this.s.dynamicEl&&this.s.dynamicEl.constructor===Array&&!this.s.dynamicEl.length)throw"When using dynamic mode, you must also define dynamicEl as an Array.";return this.modules={},this.lGalleryOn=!1,this.lgBusy=!1,this.hideBartimeout=!1,this.isTouch="ontouchstart"in document.documentElement,this.s.slideEndAnimatoin&&(this.s.hideControlOnEnd=!1),this.s.dynamic?this.$items=this.s.dynamicEl:"this"===this.s.selector?this.$items=this.$el:""!==this.s.selector?this.s.selectWithin?this.$items=a(this.s.selectWithin).find(this.s.selector):this.$items=this.$el.find(a(this.s.selector)):this.$items=this.$el.children(),this.$slide="",this.$outer="",this.init(),this}var c={mode:"lg-slide",cssEasing:"ease",easing:"linear",speed:600,height:"100%",width:"100%",addClass:"",startClass:"lg-start-zoom",backdropDuration:150,hideBarsDelay:6e3,useLeft:!1,closable:!0,loop:!0,escKey:!0,keyPress:!0,controls:!0,slideEndAnimatoin:!0,hideControlOnEnd:!1,mousewheel:!0,getCaptionFromTitleOrAlt:!0,appendSubHtmlTo:".lg-sub-html",subHtmlSelectorRelative:!1,preload:1,showAfterLoad:!0,selector:"",selectWithin:"",nextHtml:"",prevHtml:"",index:!1,iframeMaxWidth:"100%",download:!0,counter:!0,appendCounterTo:".lg-toolbar",swipeThreshold:50,enableSwipe:!0,enableDrag:!0,dynamic:!1,dynamicEl:[],galleryId:1};b.prototype.init=function(){var b=this;b.s.preload>b.$items.length&&(b.s.preload=b.$items.length);var c=window.location.hash;c.indexOf("lg="+this.s.galleryId)>0&&(b.index=parseInt(c.split("&slide=")[1],10),a("body").addClass("lg-from-hash"),a("body").hasClass("lg-on")||(setTimeout(function(){b.build(b.index)}),a("body").addClass("lg-on"))),b.s.dynamic?(b.$el.trigger("onBeforeOpen.lg"),b.index=b.s.index||0,a("body").hasClass("lg-on")||setTimeout(function(){b.build(b.index),a("body").addClass("lg-on")})):b.$items.on("click.lgcustom",function(c){try{c.preventDefault(),c.preventDefault()}catch(a){c.returnValue=!1}b.$el.trigger("onBeforeOpen.lg"),b.index=b.s.index||b.$items.index(this),a("body").hasClass("lg-on")||(b.build(b.index),a("body").addClass("lg-on"))})},b.prototype.build=function(b){var c=this;c.structure(),a.each(a.fn.lightGallery.modules,function(b){c.modules[b]=new a.fn.lightGallery.modules[b](c.el)}),c.slide(b,!1,!1,!1),c.s.keyPress&&c.keyPress(),c.$items.length>1?(c.arrow(),setTimeout(function(){c.enableDrag(),c.enableSwipe()},50),c.s.mousewheel&&c.mousewheel()):c.$slide.on("click.lg",function(){c.$el.trigger("onSlideClick.lg")}),c.counter(),c.closeGallery(),c.$el.trigger("onAfterOpen.lg"),c.$outer.on("mousemove.lg click.lg touchstart.lg",function(){c.$outer.removeClass("lg-hide-items"),clearTimeout(c.hideBartimeout),c.hideBartimeout=setTimeout(function(){c.$outer.addClass("lg-hide-items")},c.s.hideBarsDelay)}),c.$outer.trigger("mousemove.lg")},b.prototype.structure=function(){var b,c="",d="",e=0,f="",g=this;for(a("body").append('<div class="lg-backdrop"></div>'),a(".lg-backdrop").css("transition-duration",this.s.backdropDuration+"ms"),e=0;e<this.$items.length;e++)c+='<div class="lg-item"></div>';if(this.s.controls&&this.$items.length>1&&(d='<div class="lg-actions"><button class="lg-prev lg-icon">'+this.s.prevHtml+'</button><button class="lg-next lg-icon">'+this.s.nextHtml+"</button></div>"),".lg-sub-html"===this.s.appendSubHtmlTo&&(f='<div class="lg-sub-html"></div>'),b='<div class="lg-outer '+this.s.addClass+" "+this.s.startClass+'"><div class="lg" style="width:'+this.s.width+"; height:"+this.s.height+'"><div class="lg-inner">'+c+'</div><div class="lg-toolbar lg-group"><span class="lg-close lg-icon"></span></div>'+d+f+"</div></div>",a("body").append(b),this.$outer=a(".lg-outer"),this.$slide=this.$outer.find(".lg-item"),this.s.useLeft?(this.$outer.addClass("lg-use-left"),this.s.mode="lg-slide"):this.$outer.addClass("lg-use-css3"),g.setTop(),a(window).on("resize.lg orientationchange.lg",function(){setTimeout(function(){g.setTop()},100)}),this.$slide.eq(this.index).addClass("lg-current"),this.doCss()?this.$outer.addClass("lg-css3"):(this.$outer.addClass("lg-css"),this.s.speed=0),this.$outer.addClass(this.s.mode),this.s.enableDrag&&this.$items.length>1&&this.$outer.addClass("lg-grab"),this.s.showAfterLoad&&this.$outer.addClass("lg-show-after-load"),this.doCss()){var h=this.$outer.find(".lg-inner");h.css("transition-timing-function",this.s.cssEasing),h.css("transition-duration",this.s.speed+"ms")}setTimeout(function(){a(".lg-backdrop").addClass("in")}),setTimeout(function(){g.$outer.addClass("lg-visible")},this.s.backdropDuration),this.s.download&&this.$outer.find(".lg-toolbar").append('<a id="lg-download" target="_blank" download class="lg-download lg-icon"></a>'),this.prevScrollTop=a(window).scrollTop()},b.prototype.setTop=function(){if("100%"!==this.s.height){var b=a(window).height(),c=(b-parseInt(this.s.height,10))/2,d=this.$outer.find(".lg");b>=parseInt(this.s.height,10)?d.css("top",c+"px"):d.css("top","0px")}},b.prototype.doCss=function(){return!!function(){var a=["transition","MozTransition","WebkitTransition","OTransition","msTransition","KhtmlTransition"],b=document.documentElement,c=0;for(c=0;c<a.length;c++)if(a[c]in b.style)return!0}()},b.prototype.isVideo=function(a,b){var c;if(c=this.s.dynamic?this.s.dynamicEl[b].html:this.$items.eq(b).attr("data-html"),!a)return c?{html5:!0}:(console.error("lightGallery :- data-src is not pvovided on slide item "+(b+1)+". Please make sure the selector property is properly configured. More info - http://sachinchoolur.github.io/lightGallery/demos/html-markup.html"),!1);var d=a.match(/\/\/(?:www\.)?youtu(?:\.be|be\.com)\/(?:watch\?v=|embed\/)?([a-z0-9\-\_\%]+)/i),e=a.match(/\/\/(?:www\.)?vimeo.com\/([0-9a-z\-_]+)/i),f=a.match(/\/\/(?:www\.)?dai.ly\/([0-9a-z\-_]+)/i),g=a.match(/\/\/(?:www\.)?(?:vk\.com|vkontakte\.ru)\/(?:video_ext\.php\?)(.*)/i);return d?{youtube:d}:e?{vimeo:e}:f?{dailymotion:f}:g?{vk:g}:void 0},b.prototype.counter=function(){this.s.counter&&a(this.s.appendCounterTo).append('<div id="lg-counter"><span id="lg-counter-current">'+(parseInt(this.index,10)+1)+'</span> / <span id="lg-counter-all">'+this.$items.length+"</span></div>")},b.prototype.addHtml=function(b){var c,d,e=null;if(this.s.dynamic?this.s.dynamicEl[b].subHtmlUrl?c=this.s.dynamicEl[b].subHtmlUrl:e=this.s.dynamicEl[b].subHtml:(d=this.$items.eq(b),d.attr("data-sub-html-url")?c=d.attr("data-sub-html-url"):(e=d.attr("data-sub-html"),this.s.getCaptionFromTitleOrAlt&&!e&&(e=d.attr("title")||d.find("img").first().attr("alt")))),!c)if(void 0!==e&&null!==e){var f=e.substring(0,1);"."!==f&&"#"!==f||(e=this.s.subHtmlSelectorRelative&&!this.s.dynamic?d.find(e).html():a(e).html())}else e="";".lg-sub-html"===this.s.appendSubHtmlTo?c?this.$outer.find(this.s.appendSubHtmlTo).load(c):this.$outer.find(this.s.appendSubHtmlTo).html(e):c?this.$slide.eq(b).load(c):this.$slide.eq(b).append(e),void 0!==e&&null!==e&&(""===e?this.$outer.find(this.s.appendSubHtmlTo).addClass("lg-empty-html"):this.$outer.find(this.s.appendSubHtmlTo).removeClass("lg-empty-html")),this.$el.trigger("onAfterAppendSubHtml.lg",[b])},b.prototype.preload=function(a){var b=1,c=1;for(b=1;b<=this.s.preload&&!(b>=this.$items.length-a);b++)this.loadContent(a+b,!1,0);for(c=1;c<=this.s.preload&&!(a-c<0);c++)this.loadContent(a-c,!1,0)},b.prototype.loadContent=function(b,c,d){var e,f,g,h,i,j,k=this,l=!1,m=function(b){for(var c=[],d=[],e=0;e<b.length;e++){var g=b[e].split(" ");""===g[0]&&g.splice(0,1),d.push(g[0]),c.push(g[1])}for(var h=a(window).width(),i=0;i<c.length;i++)if(parseInt(c[i],10)>h){f=d[i];break}};if(k.s.dynamic){if(k.s.dynamicEl[b].poster&&(l=!0,g=k.s.dynamicEl[b].poster),j=k.s.dynamicEl[b].html,f=k.s.dynamicEl[b].src,k.s.dynamicEl[b].responsive){m(k.s.dynamicEl[b].responsive.split(","))}h=k.s.dynamicEl[b].srcset,i=k.s.dynamicEl[b].sizes}else{if(k.$items.eq(b).attr("data-poster")&&(l=!0,g=k.$items.eq(b).attr("data-poster")),j=k.$items.eq(b).attr("data-html"),f=k.$items.eq(b).attr("href")||k.$items.eq(b).attr("data-src"),k.$items.eq(b).attr("data-responsive")){m(k.$items.eq(b).attr("data-responsive").split(","))}h=k.$items.eq(b).attr("data-srcset"),i=k.$items.eq(b).attr("data-sizes")}var n=!1;k.s.dynamic?k.s.dynamicEl[b].iframe&&(n=!0):"true"===k.$items.eq(b).attr("data-iframe")&&(n=!0);var o=k.isVideo(f,b);if(!k.$slide.eq(b).hasClass("lg-loaded")){if(n)k.$slide.eq(b).prepend('<div class="lg-video-cont lg-has-iframe" style="max-width:'+k.s.iframeMaxWidth+'"><div class="lg-video"><iframe class="lg-object" frameborder="0" src="'+f+'"  allowfullscreen="true"></iframe></div></div>');else if(l){var p="";p=o&&o.youtube?"lg-has-youtube":o&&o.vimeo?"lg-has-vimeo":"lg-has-html5",k.$slide.eq(b).prepend('<div class="lg-video-cont '+p+' "><div class="lg-video"><span class="lg-video-play"></span><img class="lg-object lg-has-poster" src="'+g+'" /></div></div>')}else o?(k.$slide.eq(b).prepend('<div class="lg-video-cont "><div class="lg-video"></div></div>'),k.$el.trigger("hasVideo.lg",[b,f,j])):k.$slide.eq(b).prepend('<div class="lg-img-wrap"><img class="lg-object lg-image" src="'+f+'" /></div>');if(k.$el.trigger("onAferAppendSlide.lg",[b]),e=k.$slide.eq(b).find(".lg-object"),i&&e.attr("sizes",i),h){e.attr("srcset",h);try{picturefill({elements:[e[0]]})}catch(a){console.warn("lightGallery :- If you want srcset to be supported for older browser please include picturefil version 2 javascript library in your document.")}}".lg-sub-html"!==this.s.appendSubHtmlTo&&k.addHtml(b),k.$slide.eq(b).addClass("lg-loaded")}k.$slide.eq(b).find(".lg-object").on("load.lg error.lg",function(){var c=0;d&&!a("body").hasClass("lg-from-hash")&&(c=d),setTimeout(function(){k.$slide.eq(b).addClass("lg-complete"),k.$el.trigger("onSlideItemLoad.lg",[b,d||0])},c)}),o&&o.html5&&!l&&k.$slide.eq(b).addClass("lg-complete"),!0===c&&(k.$slide.eq(b).hasClass("lg-complete")?k.preload(b):k.$slide.eq(b).find(".lg-object").on("load.lg error.lg",function(){k.preload(b)}))},b.prototype.slide=function(b,c,d,e){var f=this.$outer.find(".lg-current").index(),g=this;if(!g.lGalleryOn||f!==b){var h=this.$slide.length,i=g.lGalleryOn?this.s.speed:0;if(!g.lgBusy){if(this.s.download){var j;j=g.s.dynamic?!1!==g.s.dynamicEl[b].downloadUrl&&(g.s.dynamicEl[b].downloadUrl||g.s.dynamicEl[b].src):"false"!==g.$items.eq(b).attr("data-download-url")&&(g.$items.eq(b).attr("data-download-url")||g.$items.eq(b).attr("href")||g.$items.eq(b).attr("data-src")),j?(a("#lg-download").attr("href",j),g.$outer.removeClass("lg-hide-download")):g.$outer.addClass("lg-hide-download")}if(this.$el.trigger("onBeforeSlide.lg",[f,b,c,d]),g.lgBusy=!0,clearTimeout(g.hideBartimeout),".lg-sub-html"===this.s.appendSubHtmlTo&&setTimeout(function(){g.addHtml(b)},i),this.arrowDisable(b),e||(b<f?e="prev":b>f&&(e="next")),c){this.$slide.removeClass("lg-prev-slide lg-current lg-next-slide");var k,l;h>2?(k=b-1,l=b+1,0===b&&f===h-1?(l=0,k=h-1):b===h-1&&0===f&&(l=0,k=h-1)):(k=0,l=1),"prev"===e?g.$slide.eq(l).addClass("lg-next-slide"):g.$slide.eq(k).addClass("lg-prev-slide"),g.$slide.eq(b).addClass("lg-current")}else g.$outer.addClass("lg-no-trans"),this.$slide.removeClass("lg-prev-slide lg-next-slide"),"prev"===e?(this.$slide.eq(b).addClass("lg-prev-slide"),this.$slide.eq(f).addClass("lg-next-slide")):(this.$slide.eq(b).addClass("lg-next-slide"),this.$slide.eq(f).addClass("lg-prev-slide")),setTimeout(function(){g.$slide.removeClass("lg-current"),g.$slide.eq(b).addClass("lg-current"),g.$outer.removeClass("lg-no-trans")},50);g.lGalleryOn?(setTimeout(function(){g.loadContent(b,!0,0)},this.s.speed+50),setTimeout(function(){g.lgBusy=!1,g.$el.trigger("onAfterSlide.lg",[f,b,c,d])},this.s.speed)):(g.loadContent(b,!0,g.s.backdropDuration),g.lgBusy=!1,g.$el.trigger("onAfterSlide.lg",[f,b,c,d])),g.lGalleryOn=!0,this.s.counter&&a("#lg-counter-current").text(b+1)}g.index=b}},b.prototype.goToNextSlide=function(a){var b=this,c=b.s.loop;a&&b.$slide.length<3&&(c=!1),b.lgBusy||(b.index+1<b.$slide.length?(b.index++,b.$el.trigger("onBeforeNextSlide.lg",[b.index]),b.slide(b.index,a,!1,"next")):c?(b.index=0,b.$el.trigger("onBeforeNextSlide.lg",[b.index]),b.slide(b.index,a,!1,"next")):b.s.slideEndAnimatoin&&!a&&(b.$outer.addClass("lg-right-end"),setTimeout(function(){b.$outer.removeClass("lg-right-end")},400)))},b.prototype.goToPrevSlide=function(a){var b=this,c=b.s.loop;a&&b.$slide.length<3&&(c=!1),b.lgBusy||(b.index>0?(b.index--,b.$el.trigger("onBeforePrevSlide.lg",[b.index,a]),b.slide(b.index,a,!1,"prev")):c?(b.index=b.$items.length-1,b.$el.trigger("onBeforePrevSlide.lg",[b.index,a]),b.slide(b.index,a,!1,"prev")):b.s.slideEndAnimatoin&&!a&&(b.$outer.addClass("lg-left-end"),setTimeout(function(){b.$outer.removeClass("lg-left-end")},400)))},b.prototype.keyPress=function(){var b=this;this.$items.length>1&&a(window).on("keyup.lg",function(a){b.$items.length>1&&(37===a.keyCode&&(a.preventDefault(),b.goToPrevSlide()),39===a.keyCode&&(a.preventDefault(),b.goToNextSlide()))}),a(window).on("keydown.lg",function(a){!0===b.s.escKey&&27===a.keyCode&&(a.preventDefault(),b.$outer.hasClass("lg-thumb-open")?b.$outer.removeClass("lg-thumb-open"):b.destroy())})},b.prototype.arrow=function(){var a=this;this.$outer.find(".lg-prev").on("click.lg",function(){a.goToPrevSlide()}),this.$outer.find(".lg-next").on("click.lg",function(){a.goToNextSlide()})},b.prototype.arrowDisable=function(a){!this.s.loop&&this.s.hideControlOnEnd&&(a+1<this.$slide.length?this.$outer.find(".lg-next").removeAttr("disabled").removeClass("disabled"):this.$outer.find(".lg-next").attr("disabled","disabled").addClass("disabled"),a>0?this.$outer.find(".lg-prev").removeAttr("disabled").removeClass("disabled"):this.$outer.find(".lg-prev").attr("disabled","disabled").addClass("disabled"))},b.prototype.setTranslate=function(a,b,c){this.s.useLeft?a.css("left",b):a.css({transform:"translate3d("+b+"px, "+c+"px, 0px)"})},b.prototype.touchMove=function(b,c){var d=c-b;Math.abs(d)>15&&(this.$outer.addClass("lg-dragging"),this.setTranslate(this.$slide.eq(this.index),d,0),this.setTranslate(a(".lg-prev-slide"),-this.$slide.eq(this.index).width()+d,0),this.setTranslate(a(".lg-next-slide"),this.$slide.eq(this.index).width()+d,0))},b.prototype.touchEnd=function(a){var b=this;"lg-slide"!==b.s.mode&&b.$outer.addClass("lg-slide"),this.$slide.not(".lg-current, .lg-prev-slide, .lg-next-slide").css("opacity","0"),setTimeout(function(){b.$outer.removeClass("lg-dragging"),a<0&&Math.abs(a)>b.s.swipeThreshold?b.goToNextSlide(!0):a>0&&Math.abs(a)>b.s.swipeThreshold?b.goToPrevSlide(!0):Math.abs(a)<5&&b.$el.trigger("onSlideClick.lg"),b.$slide.removeAttr("style")}),setTimeout(function(){b.$outer.hasClass("lg-dragging")||"lg-slide"===b.s.mode||b.$outer.removeClass("lg-slide")},b.s.speed+100)},b.prototype.enableSwipe=function(){var a=this,b=0,c=0,d=!1;a.s.enableSwipe&&a.doCss()&&(a.$slide.on("touchstart.lg",function(c){a.$outer.hasClass("lg-zoomed")||a.lgBusy||(c.preventDefault(),a.manageSwipeClass(),b=c.originalEvent.targetTouches[0].pageX)}),a.$slide.on("touchmove.lg",function(e){a.$outer.hasClass("lg-zoomed")||(e.preventDefault(),c=e.originalEvent.targetTouches[0].pageX,a.touchMove(b,c),d=!0)}),a.$slide.on("touchend.lg",function(){a.$outer.hasClass("lg-zoomed")||(d?(d=!1,a.touchEnd(c-b)):a.$el.trigger("onSlideClick.lg"))}))},b.prototype.enableDrag=function(){var b=this,c=0,d=0,e=!1,f=!1;b.s.enableDrag&&b.doCss()&&(b.$slide.on("mousedown.lg",function(d){b.$outer.hasClass("lg-zoomed")||b.lgBusy||a(d.target).text().trim()||(d.preventDefault(),b.manageSwipeClass(),c=d.pageX,e=!0,b.$outer.scrollLeft+=1,b.$outer.scrollLeft-=1,b.$outer.removeClass("lg-grab").addClass("lg-grabbing"),b.$el.trigger("onDragstart.lg"))}),a(window).on("mousemove.lg",function(a){e&&(f=!0,d=a.pageX,b.touchMove(c,d),b.$el.trigger("onDragmove.lg"))}),a(window).on("mouseup.lg",function(g){f?(f=!1,b.touchEnd(d-c),b.$el.trigger("onDragend.lg")):(a(g.target).hasClass("lg-object")||a(g.target).hasClass("lg-video-play"))&&b.$el.trigger("onSlideClick.lg"),e&&(e=!1,b.$outer.removeClass("lg-grabbing").addClass("lg-grab"))}))},b.prototype.manageSwipeClass=function(){var a=this.index+1,b=this.index-1;this.s.loop&&this.$slide.length>2&&(0===this.index?b=this.$slide.length-1:this.index===this.$slide.length-1&&(a=0)),this.$slide.removeClass("lg-next-slide lg-prev-slide"),b>-1&&this.$slide.eq(b).addClass("lg-prev-slide"),this.$slide.eq(a).addClass("lg-next-slide")},b.prototype.mousewheel=function(){var a=this;a.$outer.on("mousewheel.lg",function(b){b.deltaY&&(b.deltaY>0?a.goToPrevSlide():a.goToNextSlide(),b.preventDefault())})},b.prototype.closeGallery=function(){var b=this,c=!1;this.$outer.find(".lg-close").on("click.lg",function(){b.destroy()}),b.s.closable&&(b.$outer.on("mousedown.lg",function(b){c=!!(a(b.target).is(".lg-outer")||a(b.target).is(".lg-item ")||a(b.target).is(".lg-img-wrap"))}),b.$outer.on("mousemove.lg",function(){c=!1}),b.$outer.on("mouseup.lg",function(d){(a(d.target).is(".lg-outer")||a(d.target).is(".lg-item ")||a(d.target).is(".lg-img-wrap")&&c)&&(b.$outer.hasClass("lg-dragging")||b.destroy())}))},b.prototype.destroy=function(b){var c=this;b||(c.$el.trigger("onBeforeClose.lg"),a(window).scrollTop(c.prevScrollTop)),b&&(c.s.dynamic||this.$items.off("click.lg click.lgcustom"),a.removeData(c.el,"lightGallery")),this.$el.off(".lg.tm"),a.each(a.fn.lightGallery.modules,function(a){c.modules[a]&&c.modules[a].destroy()}),this.lGalleryOn=!1,clearTimeout(c.hideBartimeout),this.hideBartimeout=!1,a(window).off(".lg"),a("body").removeClass("lg-on lg-from-hash"),c.$outer&&c.$outer.removeClass("lg-visible"),a(".lg-backdrop").removeClass("in"),setTimeout(function(){c.$outer&&c.$outer.remove(),a(".lg-backdrop").remove(),b||c.$el.trigger("onCloseAfter.lg")},c.s.backdropDuration+50)},a.fn.lightGallery=function(c){return this.each(function(){if(a.data(this,"lightGallery"))try{a(this).data("lightGallery").init()}catch(a){console.error("lightGallery has not initiated properly")}else a.data(this,"lightGallery",new b(this,c))})},a.fn.lightGallery.modules={}}()}),function(a,b){"function"==typeof define&&define.amd?define(["jquery"],function(a){return b(a)}):"object"==typeof exports?module.exports=b(require("jquery")):b(jQuery)}(0,function(a){!function(){"use strict";var b={autoplay:!1,pause:5e3,progressBar:!0,fourceAutoplay:!1,autoplayControls:!0,appendAutoplayControlsTo:".lg-toolbar"},c=function(c){return this.core=a(c).data("lightGallery"),this.$el=a(c),!(this.core.$items.length<2)&&(this.core.s=a.extend({},b,this.core.s),this.interval=!1,this.fromAuto=!0,this.canceledOnTouch=!1,this.fourceAutoplayTemp=this.core.s.fourceAutoplay,this.core.doCss()||(this.core.s.progressBar=!1),this.init(),this)};c.prototype.init=function(){var a=this;a.core.s.autoplayControls&&a.controls(),a.core.s.progressBar&&a.core.$outer.find(".lg").append('<div class="lg-progress-bar"><div class="lg-progress"></div></div>'),a.progress(),a.core.s.autoplay&&a.$el.one("onSlideItemLoad.lg.tm",function(){a.startlAuto()}),a.$el.on("onDragstart.lg.tm touchstart.lg.tm",function(){a.interval&&(a.cancelAuto(),a.canceledOnTouch=!0)}),a.$el.on("onDragend.lg.tm touchend.lg.tm onSlideClick.lg.tm",function(){!a.interval&&a.canceledOnTouch&&(a.startlAuto(),a.canceledOnTouch=!1)})},c.prototype.progress=function(){var a,b,c=this;c.$el.on("onBeforeSlide.lg.tm",function(){c.core.s.progressBar&&c.fromAuto&&(a=c.core.$outer.find(".lg-progress-bar"),b=c.core.$outer.find(".lg-progress"),c.interval&&(b.removeAttr("style"),a.removeClass("lg-start"),setTimeout(function(){b.css("transition","width "+(c.core.s.speed+c.core.s.pause)+"ms ease 0s"),a.addClass("lg-start")},20))),c.fromAuto||c.core.s.fourceAutoplay||c.cancelAuto(),c.fromAuto=!1})},c.prototype.controls=function(){var b=this;a(this.core.s.appendAutoplayControlsTo).append('<span class="lg-autoplay-button lg-icon"></span>'),b.core.$outer.find(".lg-autoplay-button").on("click.lg",function(){a(b.core.$outer).hasClass("lg-show-autoplay")?(b.cancelAuto(),b.core.s.fourceAutoplay=!1):b.interval||(b.startlAuto(),b.core.s.fourceAutoplay=b.fourceAutoplayTemp)})},c.prototype.startlAuto=function(){var a=this;a.core.$outer.find(".lg-progress").css("transition","width "+(a.core.s.speed+a.core.s.pause)+"ms ease 0s"),a.core.$outer.addClass("lg-show-autoplay"),a.core.$outer.find(".lg-progress-bar").addClass("lg-start"),a.interval=setInterval(function(){a.core.index+1<a.core.$items.length?a.core.index++:a.core.index=0,a.fromAuto=!0,a.core.slide(a.core.index,!1,!1,"next")},a.core.s.speed+a.core.s.pause)},c.prototype.cancelAuto=function(){clearInterval(this.interval),this.interval=!1,this.core.$outer.find(".lg-progress").removeAttr("style"),this.core.$outer.removeClass("lg-show-autoplay"),this.core.$outer.find(".lg-progress-bar").removeClass("lg-start")},c.prototype.destroy=function(){this.cancelAuto(),this.core.$outer.find(".lg-progress-bar").remove()},a.fn.lightGallery.modules.autoplay=c}()}),function(a,b){"function"==typeof define&&define.amd?define(["jquery"],function(a){return b(a)}):"object"==typeof exports?module.exports=b(require("jquery")):b(jQuery)}(0,function(a){!function(){"use strict";var b={fullScreen:!0},c=function(c){return this.core=a(c).data("lightGallery"),this.$el=a(c),this.core.s=a.extend({},b,this.core.s),this.init(),this};c.prototype.init=function(){var a="";if(this.core.s.fullScreen){if(!(document.fullscreenEnabled||document.webkitFullscreenEnabled||document.mozFullScreenEnabled||document.msFullscreenEnabled))return;a='<span class="lg-fullscreen lg-icon"></span>',this.core.$outer.find(".lg-toolbar").append(a),this.fullScreen()}},c.prototype.requestFullscreen=function(){var a=document.documentElement;a.requestFullscreen?a.requestFullscreen():a.msRequestFullscreen?a.msRequestFullscreen():a.mozRequestFullScreen?a.mozRequestFullScreen():a.webkitRequestFullscreen&&a.webkitRequestFullscreen()},c.prototype.exitFullscreen=function(){document.exitFullscreen?document.exitFullscreen():document.msExitFullscreen?document.msExitFullscreen():document.mozCancelFullScreen?document.mozCancelFullScreen():document.webkitExitFullscreen&&document.webkitExitFullscreen()},c.prototype.fullScreen=function(){var b=this;a(document).on("fullscreenchange.lg webkitfullscreenchange.lg mozfullscreenchange.lg MSFullscreenChange.lg",function(){b.core.$outer.toggleClass("lg-fullscreen-on")}),this.core.$outer.find(".lg-fullscreen").on("click.lg",function(){document.fullscreenElement||document.mozFullScreenElement||document.webkitFullscreenElement||document.msFullscreenElement?b.exitFullscreen():b.requestFullscreen()})},c.prototype.destroy=function(){this.exitFullscreen(),a(document).off("fullscreenchange.lg webkitfullscreenchange.lg mozfullscreenchange.lg MSFullscreenChange.lg")},a.fn.lightGallery.modules.fullscreen=c}()}),function(a,b){"function"==typeof define&&define.amd?define(["jquery"],function(a){return b(a)}):"object"==typeof exports?module.exports=b(require("jquery")):b(jQuery)}(0,function(a){!function(){"use strict";var b={pager:!1},c=function(c){return this.core=a(c).data("lightGallery"),this.$el=a(c),this.core.s=a.extend({},b,this.core.s),this.core.s.pager&&this.core.$items.length>1&&this.init(),this};c.prototype.init=function(){var b,c,d,e=this,f="";if(e.core.$outer.find(".lg").append('<div class="lg-pager-outer"></div>'),e.core.s.dynamic)for(var g=0;g<e.core.s.dynamicEl.length;g++)f+='<span class="lg-pager-cont"> <span class="lg-pager"></span><div class="lg-pager-thumb-cont"><span class="lg-caret"></span> <img src="'+e.core.s.dynamicEl[g].thumb+'" /></div></span>';else e.core.$items.each(function(){e.core.s.exThumbImage?f+='<span class="lg-pager-cont"> <span class="lg-pager"></span><div class="lg-pager-thumb-cont"><span class="lg-caret"></span> <img src="'+a(this).attr(e.core.s.exThumbImage)+'" /></div></span>':f+='<span class="lg-pager-cont"> <span class="lg-pager"></span><div class="lg-pager-thumb-cont"><span class="lg-caret"></span> <img src="'+a(this).find("img").attr("src")+'" /></div></span>'});c=e.core.$outer.find(".lg-pager-outer"),c.html(f),b=e.core.$outer.find(".lg-pager-cont"),b.on("click.lg touchend.lg",function(){var b=a(this);e.core.index=b.index(),e.core.slide(e.core.index,!1,!0,!1)}),c.on("mouseover.lg",function(){clearTimeout(d),c.addClass("lg-pager-hover")}),c.on("mouseout.lg",function(){d=setTimeout(function(){c.removeClass("lg-pager-hover")})}),e.core.$el.on("onBeforeSlide.lg.tm",function(a,c,d){b.removeClass("lg-pager-active"),b.eq(d).addClass("lg-pager-active")})},c.prototype.destroy=function(){},a.fn.lightGallery.modules.pager=c}()}),function(a,b){"function"==typeof define&&define.amd?define(["jquery"],function(a){return b(a)}):"object"==typeof exports?module.exports=b(require("jquery")):b(jQuery)}(0,function(a){!function(){"use strict";var b={thumbnail:!0,animateThumb:!0,currentPagerPosition:"middle",thumbWidth:100,thumbHeight:"80px",thumbContHeight:100,thumbMargin:5,exThumbImage:!1,showThumbByDefault:!0,toogleThumb:!0,pullCaptionUp:!0,enableThumbDrag:!0,enableThumbSwipe:!0,swipeThreshold:50,loadYoutubeThumbnail:!0,youtubeThumbSize:1,loadVimeoThumbnail:!0,vimeoThumbSize:"thumbnail_small",loadDailymotionThumbnail:!0},c=function(c){return this.core=a(c).data("lightGallery"),this.core.s=a.extend({},b,this.core.s),this.$el=a(c),this.$thumbOuter=null,this.thumbOuterWidth=0,this.thumbTotalWidth=this.core.$items.length*(this.core.s.thumbWidth+this.core.s.thumbMargin),this.thumbIndex=this.core.index,this.core.s.animateThumb&&(this.core.s.thumbHeight="100%"),this.left=0,this.init(),this};c.prototype.init=function(){var a=this;this.core.s.thumbnail&&this.core.$items.length>1&&(this.core.s.showThumbByDefault&&setTimeout(function(){a.core.$outer.addClass("lg-thumb-open")},700),this.core.s.pullCaptionUp&&this.core.$outer.addClass("lg-pull-caption-up"),this.build(),this.core.s.animateThumb&&this.core.doCss()?(this.core.s.enableThumbDrag&&this.enableThumbDrag(),this.core.s.enableThumbSwipe&&this.enableThumbSwipe(),this.thumbClickable=!1):this.thumbClickable=!0,this.toogle(),this.thumbkeyPress())},c.prototype.build=function(){function b(a,b,c){var g,h=d.core.isVideo(a,c)||{},i="";h.youtube||h.vimeo||h.dailymotion?h.youtube?g=d.core.s.loadYoutubeThumbnail?"//img.youtube.com/vi/"+h.youtube[1]+"/"+d.core.s.youtubeThumbSize+".jpg":b:h.vimeo?d.core.s.loadVimeoThumbnail?(g="//i.vimeocdn.com/video/error_"+f+".jpg",i=h.vimeo[1]):g=b:h.dailymotion&&(g=d.core.s.loadDailymotionThumbnail?"//www.dailymotion.com/thumbnail/video/"+h.dailymotion[1]:b):g=b,e+='<div data-vimeo-id="'+i+'" class="lg-thumb-item" style="width:'+d.core.s.thumbWidth+"px; height: "+d.core.s.thumbHeight+"; margin-right: "+d.core.s.thumbMargin+'px"><img src="'+g+'" /></div>',i=""}var c,d=this,e="",f="",g='<div class="lg-thumb-outer"><div class="lg-thumb lg-group"></div></div>';switch(this.core.s.vimeoThumbSize){case"thumbnail_large":f="640";break;case"thumbnail_medium":f="200x150";break;case"thumbnail_small":f="100x75"}if(d.core.$outer.addClass("lg-has-thumb"),d.core.$outer.find(".lg").append(g),d.$thumbOuter=d.core.$outer.find(".lg-thumb-outer"),d.thumbOuterWidth=d.$thumbOuter.width(),d.core.s.animateThumb&&d.core.$outer.find(".lg-thumb").css({width:d.thumbTotalWidth+"px",position:"relative"}),this.core.s.animateThumb&&d.$thumbOuter.css("height",d.core.s.thumbContHeight+"px"),d.core.s.dynamic)for(var h=0;h<d.core.s.dynamicEl.length;h++)b(d.core.s.dynamicEl[h].src,d.core.s.dynamicEl[h].thumb,h);else d.core.$items.each(function(c){d.core.s.exThumbImage?b(a(this).attr("href")||a(this).attr("data-src"),a(this).attr(d.core.s.exThumbImage),c):b(a(this).attr("href")||a(this).attr("data-src"),a(this).find("img").attr("src"),c)});d.core.$outer.find(".lg-thumb").html(e),c=d.core.$outer.find(".lg-thumb-item"),c.each(function(){var b=a(this),c=b.attr("data-vimeo-id");c&&a.getJSON("//www.vimeo.com/api/v2/video/"+c+".json?callback=?",{format:"json"},function(a){b.find("img").attr("src",a[0][d.core.s.vimeoThumbSize])})}),c.eq(d.core.index).addClass("active"),d.core.$el.on("onBeforeSlide.lg.tm",function(){c.removeClass("active"),c.eq(d.core.index).addClass("active")}),c.on("click.lg touchend.lg",function(){var b=a(this);setTimeout(function(){(d.thumbClickable&&!d.core.lgBusy||!d.core.doCss())&&(d.core.index=b.index(),d.core.slide(d.core.index,!1,!0,!1))},50)}),d.core.$el.on("onBeforeSlide.lg.tm",function(){d.animateThumb(d.core.index)}),a(window).on("resize.lg.thumb orientationchange.lg.thumb",function(){setTimeout(function(){d.animateThumb(d.core.index),d.thumbOuterWidth=d.$thumbOuter.width()},200)})},c.prototype.setTranslate=function(a){this.core.$outer.find(".lg-thumb").css({transform:"translate3d(-"+a+"px, 0px, 0px)"})},c.prototype.animateThumb=function(a){var b=this.core.$outer.find(".lg-thumb");if(this.core.s.animateThumb){var c;switch(this.core.s.currentPagerPosition){case"left":c=0;break;case"middle":c=this.thumbOuterWidth/2-this.core.s.thumbWidth/2;break;case"right":c=this.thumbOuterWidth-this.core.s.thumbWidth}this.left=(this.core.s.thumbWidth+this.core.s.thumbMargin)*a-1-c,this.left>this.thumbTotalWidth-this.thumbOuterWidth&&(this.left=this.thumbTotalWidth-this.thumbOuterWidth),this.left<0&&(this.left=0),this.core.lGalleryOn?(b.hasClass("on")||this.core.$outer.find(".lg-thumb").css("transition-duration",this.core.s.speed+"ms"),this.core.doCss()||b.animate({left:-this.left+"px"},this.core.s.speed)):this.core.doCss()||b.css("left",-this.left+"px"),this.setTranslate(this.left)}},c.prototype.enableThumbDrag=function(){var b=this,c=0,d=0,e=!1,f=!1,g=0;b.$thumbOuter.addClass("lg-grab"),b.core.$outer.find(".lg-thumb").on("mousedown.lg.thumb",function(a){b.thumbTotalWidth>b.thumbOuterWidth&&(a.preventDefault(),c=a.pageX,e=!0,b.core.$outer.scrollLeft+=1,b.core.$outer.scrollLeft-=1,b.thumbClickable=!1,b.$thumbOuter.removeClass("lg-grab").addClass("lg-grabbing"))}),a(window).on("mousemove.lg.thumb",function(a){e&&(g=b.left,f=!0,d=a.pageX,b.$thumbOuter.addClass("lg-dragging"),g-=d-c,g>b.thumbTotalWidth-b.thumbOuterWidth&&(g=b.thumbTotalWidth-b.thumbOuterWidth),g<0&&(g=0),b.setTranslate(g))}),a(window).on("mouseup.lg.thumb",function(){f?(f=!1,b.$thumbOuter.removeClass("lg-dragging"),b.left=g,Math.abs(d-c)<b.core.s.swipeThreshold&&(b.thumbClickable=!0)):b.thumbClickable=!0,e&&(e=!1,b.$thumbOuter.removeClass("lg-grabbing").addClass("lg-grab"))})},c.prototype.enableThumbSwipe=function(){var a=this,b=0,c=0,d=!1,e=0;a.core.$outer.find(".lg-thumb").on("touchstart.lg",function(c){a.thumbTotalWidth>a.thumbOuterWidth&&(c.preventDefault(),b=c.originalEvent.targetTouches[0].pageX,a.thumbClickable=!1)}),a.core.$outer.find(".lg-thumb").on("touchmove.lg",function(f){a.thumbTotalWidth>a.thumbOuterWidth&&(f.preventDefault(),c=f.originalEvent.targetTouches[0].pageX,d=!0,a.$thumbOuter.addClass("lg-dragging"),e=a.left,e-=c-b,e>a.thumbTotalWidth-a.thumbOuterWidth&&(e=a.thumbTotalWidth-a.thumbOuterWidth),e<0&&(e=0),a.setTranslate(e))}),a.core.$outer.find(".lg-thumb").on("touchend.lg",function(){a.thumbTotalWidth>a.thumbOuterWidth&&d?(d=!1,a.$thumbOuter.removeClass("lg-dragging"),Math.abs(c-b)<a.core.s.swipeThreshold&&(a.thumbClickable=!0),a.left=e):a.thumbClickable=!0})},c.prototype.toogle=function(){var a=this;a.core.s.toogleThumb&&(a.core.$outer.addClass("lg-can-toggle"),a.$thumbOuter.append('<span class="lg-toogle-thumb lg-icon"></span>'),a.core.$outer.find(".lg-toogle-thumb").on("click.lg",function(){a.core.$outer.toggleClass("lg-thumb-open")}))},c.prototype.thumbkeyPress=function(){var b=this;a(window).on("keydown.lg.thumb",function(a){38===a.keyCode?(a.preventDefault(),b.core.$outer.addClass("lg-thumb-open")):40===a.keyCode&&(a.preventDefault(),b.core.$outer.removeClass("lg-thumb-open"))})},c.prototype.destroy=function(){this.core.s.thumbnail&&this.core.$items.length>1&&(a(window).off("resize.lg.thumb orientationchange.lg.thumb keydown.lg.thumb"),
this.$thumbOuter.remove(),this.core.$outer.removeClass("lg-has-thumb"))},a.fn.lightGallery.modules.Thumbnail=c}()}),function(a,b){"function"==typeof define&&define.amd?define(["jquery"],function(a){return b(a)}):"object"==typeof module&&module.exports?module.exports=b(require("jquery")):b(a.jQuery)}(this,function(a){!function(){"use strict";function b(a,b,c,d){var e=this;if(e.core.$slide.eq(b).find(".lg-video").append(e.loadVideo(c,"lg-object",!0,b,d)),d)if(e.core.s.videojs)try{videojs(e.core.$slide.eq(b).find(".lg-html5").get(0),e.core.s.videojsOptions,function(){!e.videoLoaded&&e.core.s.autoplayFirstVideo&&this.play()})}catch(a){console.error("Make sure you have included videojs")}else!e.videoLoaded&&e.core.s.autoplayFirstVideo&&e.core.$slide.eq(b).find(".lg-html5").get(0).play()}function c(a,b){var c=this.core.$slide.eq(b).find(".lg-video-cont");c.hasClass("lg-has-iframe")||(c.css("max-width",this.core.s.videoMaxWidth),this.videoLoaded=!0)}function d(b,c,d){var e=this,f=e.core.$slide.eq(c),g=f.find(".lg-youtube").get(0),h=f.find(".lg-vimeo").get(0),i=f.find(".lg-dailymotion").get(0),j=f.find(".lg-vk").get(0),k=f.find(".lg-html5").get(0);if(g)g.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}',"*");else if(h)try{$f(h).api("pause")}catch(a){console.error("Make sure you have included froogaloop2 js")}else if(i)i.contentWindow.postMessage("pause","*");else if(k)if(e.core.s.videojs)try{videojs(k).pause()}catch(a){console.error("Make sure you have included videojs")}else k.pause();j&&a(j).attr("src",a(j).attr("src").replace("&autoplay","&noplay"));var l;l=e.core.s.dynamic?e.core.s.dynamicEl[d].src:e.core.$items.eq(d).attr("href")||e.core.$items.eq(d).attr("data-src");var m=e.core.isVideo(l,d)||{};(m.youtube||m.vimeo||m.dailymotion||m.vk)&&e.core.$outer.addClass("lg-hide-download")}var e={videoMaxWidth:"855px",autoplayFirstVideo:!0,youtubePlayerParams:!1,vimeoPlayerParams:!1,dailymotionPlayerParams:!1,vkPlayerParams:!1,videojs:!1,videojsOptions:{}},f=function(b){return this.core=a(b).data("lightGallery"),this.$el=a(b),this.core.s=a.extend({},e,this.core.s),this.videoLoaded=!1,this.init(),this};f.prototype.init=function(){var e=this;e.core.$el.on("hasVideo.lg.tm",b.bind(this)),e.core.$el.on("onAferAppendSlide.lg.tm",c.bind(this)),e.core.doCss()&&e.core.$items.length>1&&(e.core.s.enableSwipe||e.core.s.enableDrag)?e.core.$el.on("onSlideClick.lg.tm",function(){var a=e.core.$slide.eq(e.core.index);e.loadVideoOnclick(a)}):e.core.$slide.on("click.lg",function(){e.loadVideoOnclick(a(this))}),e.core.$el.on("onBeforeSlide.lg.tm",d.bind(this)),e.core.$el.on("onAfterSlide.lg.tm",function(a,b){e.core.$slide.eq(b).removeClass("lg-video-playing")})},f.prototype.loadVideo=function(b,c,d,e,f){var g="",h=1,i="",j=this.core.isVideo(b,e)||{};if(d&&(h=this.videoLoaded?0:this.core.s.autoplayFirstVideo?1:0),j.youtube)i="?wmode=opaque&autoplay="+h+"&enablejsapi=1",this.core.s.youtubePlayerParams&&(i=i+"&"+a.param(this.core.s.youtubePlayerParams)),g='<iframe class="lg-video-object lg-youtube '+c+'" width="560" height="315" src="//www.youtube.com/embed/'+j.youtube[1]+i+'" frameborder="0" allowfullscreen></iframe>';else if(j.vimeo)i="?autoplay="+h+"&api=1",this.core.s.vimeoPlayerParams&&(i=i+"&"+a.param(this.core.s.vimeoPlayerParams)),g='<iframe class="lg-video-object lg-vimeo '+c+'" width="560" height="315"  src="//player.vimeo.com/video/'+j.vimeo[1]+i+'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';else if(j.dailymotion)i="?wmode=opaque&autoplay="+h+"&api=postMessage",this.core.s.dailymotionPlayerParams&&(i=i+"&"+a.param(this.core.s.dailymotionPlayerParams)),g='<iframe class="lg-video-object lg-dailymotion '+c+'" width="560" height="315" src="//www.dailymotion.com/embed/video/'+j.dailymotion[1]+i+'" frameborder="0" allowfullscreen></iframe>';else if(j.html5){var k=f.substring(0,1);"."!==k&&"#"!==k||(f=a(f).html()),g=f}else j.vk&&(i="&autoplay="+h,this.core.s.vkPlayerParams&&(i=i+"&"+a.param(this.core.s.vkPlayerParams)),g='<iframe class="lg-video-object lg-vk '+c+'" width="560" height="315" src="//vk.com/video_ext.php?'+j.vk[1]+i+'" frameborder="0" allowfullscreen></iframe>');return g},f.prototype.loadVideoOnclick=function(a){var b=this;if(a.find(".lg-object").hasClass("lg-has-poster")&&a.find(".lg-object").is(":visible"))if(a.hasClass("lg-has-video")){var c=a.find(".lg-youtube").get(0),d=a.find(".lg-vimeo").get(0),e=a.find(".lg-dailymotion").get(0),f=a.find(".lg-html5").get(0);if(c)c.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}',"*");else if(d)try{$f(d).api("play")}catch(a){console.error("Make sure you have included froogaloop2 js")}else if(e)e.contentWindow.postMessage("play","*");else if(f)if(b.core.s.videojs)try{videojs(f).play()}catch(a){console.error("Make sure you have included videojs")}else f.play();a.addClass("lg-video-playing")}else{a.addClass("lg-video-playing lg-has-video");var g,h,i=function(c,d){if(a.find(".lg-video").append(b.loadVideo(c,"",!1,b.core.index,d)),d)if(b.core.s.videojs)try{videojs(b.core.$slide.eq(b.core.index).find(".lg-html5").get(0),b.core.s.videojsOptions,function(){this.play()})}catch(a){console.error("Make sure you have included videojs")}else b.core.$slide.eq(b.core.index).find(".lg-html5").get(0).play()};b.core.s.dynamic?(g=b.core.s.dynamicEl[b.core.index].src,h=b.core.s.dynamicEl[b.core.index].html,i(g,h)):(g=b.core.$items.eq(b.core.index).attr("href")||b.core.$items.eq(b.core.index).attr("data-src"),h=b.core.$items.eq(b.core.index).attr("data-html"),i(g,h));var j=a.find(".lg-object");a.find(".lg-video").append(j),a.find(".lg-video-object").hasClass("lg-html5")||(a.removeClass("lg-complete"),a.find(".lg-video-object").on("load.lg error.lg",function(){a.addClass("lg-complete")}))}},f.prototype.destroy=function(){this.videoLoaded=!1},a.fn.lightGallery.modules.video=f}()}),function(a,b){"function"==typeof define&&define.amd?define(["jquery"],function(a){return b(a)}):"object"==typeof exports?module.exports=b(require("jquery")):b(jQuery)}(0,function(a){!function(){"use strict";var b=function(){var a=!1,b=navigator.userAgent.match(/Chrom(e|ium)\/([0-9]+)\./);return b&&parseInt(b[2],10)<54&&(a=!0),a},c={scale:1,zoom:!0,actualSize:!0,enableZoomAfter:300,useLeftForZoom:b()},d=function(b){return this.core=a(b).data("lightGallery"),this.core.s=a.extend({},c,this.core.s),this.core.s.zoom&&this.core.doCss()&&(this.init(),this.zoomabletimeout=!1,this.pageX=a(window).width()/2,this.pageY=a(window).height()/2+a(window).scrollTop()),this};d.prototype.init=function(){var b=this,c='<span id="lg-zoom-in" class="lg-icon"></span><span id="lg-zoom-out" class="lg-icon"></span>';b.core.s.actualSize&&(c+='<span id="lg-actual-size" class="lg-icon"></span>'),b.core.s.useLeftForZoom?b.core.$outer.addClass("lg-use-left-for-zoom"):b.core.$outer.addClass("lg-use-transition-for-zoom"),this.core.$outer.find(".lg-toolbar").append(c),b.core.$el.on("onSlideItemLoad.lg.tm.zoom",function(c,d,e){var f=b.core.s.enableZoomAfter+e;a("body").hasClass("lg-from-hash")&&e?f=0:a("body").removeClass("lg-from-hash"),b.zoomabletimeout=setTimeout(function(){b.core.$slide.eq(d).addClass("lg-zoomable")},f+30)});var d=1,e=function(c){var d,e,f=b.core.$outer.find(".lg-current .lg-image"),g=(a(window).width()-f.prop("offsetWidth"))/2,h=(a(window).height()-f.prop("offsetHeight"))/2+a(window).scrollTop();d=b.pageX-g,e=b.pageY-h;var i=(c-1)*d,j=(c-1)*e;f.css("transform","scale3d("+c+", "+c+", 1)").attr("data-scale",c),b.core.s.useLeftForZoom?f.parent().css({left:-i+"px",top:-j+"px"}).attr("data-x",i).attr("data-y",j):f.parent().css("transform","translate3d(-"+i+"px, -"+j+"px, 0)").attr("data-x",i).attr("data-y",j)},f=function(){d>1?b.core.$outer.addClass("lg-zoomed"):b.resetZoom(),d<1&&(d=1),e(d)},g=function(c,e,g,h){var i,j=e.prop("offsetWidth");i=b.core.s.dynamic?b.core.s.dynamicEl[g].width||e[0].naturalWidth||j:b.core.$items.eq(g).attr("data-width")||e[0].naturalWidth||j;var k;b.core.$outer.hasClass("lg-zoomed")?d=1:i>j&&(k=i/j,d=k||2),h?(b.pageX=a(window).width()/2,b.pageY=a(window).height()/2+a(window).scrollTop()):(b.pageX=c.pageX||c.originalEvent.targetTouches[0].pageX,b.pageY=c.pageY||c.originalEvent.targetTouches[0].pageY),f(),setTimeout(function(){b.core.$outer.removeClass("lg-grabbing").addClass("lg-grab")},10)},h=!1;b.core.$el.on("onAferAppendSlide.lg.tm.zoom",function(a,c){var d=b.core.$slide.eq(c).find(".lg-image");d.on("dblclick",function(a){g(a,d,c)}),d.on("touchstart",function(a){h?(clearTimeout(h),h=null,g(a,d,c)):h=setTimeout(function(){h=null},300),a.preventDefault()})}),a(window).on("resize.lg.zoom scroll.lg.zoom orientationchange.lg.zoom",function(){b.pageX=a(window).width()/2,b.pageY=a(window).height()/2+a(window).scrollTop(),e(d)}),a("#lg-zoom-out").on("click.lg",function(){b.core.$outer.find(".lg-current .lg-image").length&&(d-=b.core.s.scale,f())}),a("#lg-zoom-in").on("click.lg",function(){b.core.$outer.find(".lg-current .lg-image").length&&(d+=b.core.s.scale,f())}),a("#lg-actual-size").on("click.lg",function(a){g(a,b.core.$slide.eq(b.core.index).find(".lg-image"),b.core.index,!0)}),b.core.$el.on("onBeforeSlide.lg.tm",function(){d=1,b.resetZoom()}),b.zoomDrag(),b.zoomSwipe()},d.prototype.resetZoom=function(){this.core.$outer.removeClass("lg-zoomed"),this.core.$slide.find(".lg-img-wrap").removeAttr("style data-x data-y"),this.core.$slide.find(".lg-image").removeAttr("style data-scale"),this.pageX=a(window).width()/2,this.pageY=a(window).height()/2+a(window).scrollTop()},d.prototype.zoomSwipe=function(){var a=this,b={},c={},d=!1,e=!1,f=!1;a.core.$slide.on("touchstart.lg",function(c){if(a.core.$outer.hasClass("lg-zoomed")){var d=a.core.$slide.eq(a.core.index).find(".lg-object");f=d.prop("offsetHeight")*d.attr("data-scale")>a.core.$outer.find(".lg").height(),e=d.prop("offsetWidth")*d.attr("data-scale")>a.core.$outer.find(".lg").width(),(e||f)&&(c.preventDefault(),b={x:c.originalEvent.targetTouches[0].pageX,y:c.originalEvent.targetTouches[0].pageY})}}),a.core.$slide.on("touchmove.lg",function(g){if(a.core.$outer.hasClass("lg-zoomed")){var h,i,j=a.core.$slide.eq(a.core.index).find(".lg-img-wrap");g.preventDefault(),d=!0,c={x:g.originalEvent.targetTouches[0].pageX,y:g.originalEvent.targetTouches[0].pageY},a.core.$outer.addClass("lg-zoom-dragging"),i=f?-Math.abs(j.attr("data-y"))+(c.y-b.y):-Math.abs(j.attr("data-y")),h=e?-Math.abs(j.attr("data-x"))+(c.x-b.x):-Math.abs(j.attr("data-x")),(Math.abs(c.x-b.x)>15||Math.abs(c.y-b.y)>15)&&(a.core.s.useLeftForZoom?j.css({left:h+"px",top:i+"px"}):j.css("transform","translate3d("+h+"px, "+i+"px, 0)"))}}),a.core.$slide.on("touchend.lg",function(){a.core.$outer.hasClass("lg-zoomed")&&d&&(d=!1,a.core.$outer.removeClass("lg-zoom-dragging"),a.touchendZoom(b,c,e,f))})},d.prototype.zoomDrag=function(){var b=this,c={},d={},e=!1,f=!1,g=!1,h=!1;b.core.$slide.on("mousedown.lg.zoom",function(d){var f=b.core.$slide.eq(b.core.index).find(".lg-object");h=f.prop("offsetHeight")*f.attr("data-scale")>b.core.$outer.find(".lg").height(),g=f.prop("offsetWidth")*f.attr("data-scale")>b.core.$outer.find(".lg").width(),b.core.$outer.hasClass("lg-zoomed")&&a(d.target).hasClass("lg-object")&&(g||h)&&(d.preventDefault(),c={x:d.pageX,y:d.pageY},e=!0,b.core.$outer.scrollLeft+=1,b.core.$outer.scrollLeft-=1,b.core.$outer.removeClass("lg-grab").addClass("lg-grabbing"))}),a(window).on("mousemove.lg.zoom",function(a){if(e){var i,j,k=b.core.$slide.eq(b.core.index).find(".lg-img-wrap");f=!0,d={x:a.pageX,y:a.pageY},b.core.$outer.addClass("lg-zoom-dragging"),j=h?-Math.abs(k.attr("data-y"))+(d.y-c.y):-Math.abs(k.attr("data-y")),i=g?-Math.abs(k.attr("data-x"))+(d.x-c.x):-Math.abs(k.attr("data-x")),b.core.s.useLeftForZoom?k.css({left:i+"px",top:j+"px"}):k.css("transform","translate3d("+i+"px, "+j+"px, 0)")}}),a(window).on("mouseup.lg.zoom",function(a){e&&(e=!1,b.core.$outer.removeClass("lg-zoom-dragging"),!f||c.x===d.x&&c.y===d.y||(d={x:a.pageX,y:a.pageY},b.touchendZoom(c,d,g,h)),f=!1),b.core.$outer.removeClass("lg-grabbing").addClass("lg-grab")})},d.prototype.touchendZoom=function(a,b,c,d){var e=this,f=e.core.$slide.eq(e.core.index).find(".lg-img-wrap"),g=e.core.$slide.eq(e.core.index).find(".lg-object"),h=-Math.abs(f.attr("data-x"))+(b.x-a.x),i=-Math.abs(f.attr("data-y"))+(b.y-a.y),j=(e.core.$outer.find(".lg").height()-g.prop("offsetHeight"))/2,k=Math.abs(g.prop("offsetHeight")*Math.abs(g.attr("data-scale"))-e.core.$outer.find(".lg").height()+j),l=(e.core.$outer.find(".lg").width()-g.prop("offsetWidth"))/2,m=Math.abs(g.prop("offsetWidth")*Math.abs(g.attr("data-scale"))-e.core.$outer.find(".lg").width()+l);(Math.abs(b.x-a.x)>15||Math.abs(b.y-a.y)>15)&&(d&&(i<=-k?i=-k:i>=-j&&(i=-j)),c&&(h<=-m?h=-m:h>=-l&&(h=-l)),d?f.attr("data-y",Math.abs(i)):i=-Math.abs(f.attr("data-y")),c?f.attr("data-x",Math.abs(h)):h=-Math.abs(f.attr("data-x")),e.core.s.useLeftForZoom?f.css({left:h+"px",top:i+"px"}):f.css("transform","translate3d("+h+"px, "+i+"px, 0)"))},d.prototype.destroy=function(){var b=this;b.core.$el.off(".lg.zoom"),a(window).off(".lg.zoom"),b.core.$slide.off(".lg.zoom"),b.core.$el.off(".lg.tm.zoom"),b.resetZoom(),clearTimeout(b.zoomabletimeout),b.zoomabletimeout=!1},a.fn.lightGallery.modules.zoom=d}()}),function(a,b){"function"==typeof define&&define.amd?define(["jquery"],function(a){return b(a)}):"object"==typeof exports?module.exports=b(require("jquery")):b(jQuery)}(0,function(a){!function(){"use strict";var b={hash:!0},c=function(c){return this.core=a(c).data("lightGallery"),this.core.s=a.extend({},b,this.core.s),this.core.s.hash&&(this.oldHash=window.location.hash,this.init()),this};c.prototype.init=function(){var b,c=this;c.core.$el.on("onAfterSlide.lg.tm",function(a,b,d){history.replaceState?history.replaceState(null,null,window.location.pathname+window.location.search+"#lg="+c.core.s.galleryId+"&slide="+d):window.location.hash="lg="+c.core.s.galleryId+"&slide="+d}),a(window).on("hashchange.lg.hash",function(){b=window.location.hash;var a=parseInt(b.split("&slide=")[1],10);b.indexOf("lg="+c.core.s.galleryId)>-1?c.core.slide(a,!1,!1):c.core.lGalleryOn&&c.core.destroy()})},c.prototype.destroy=function(){this.core.s.hash&&(this.oldHash&&this.oldHash.indexOf("lg="+this.core.s.galleryId)<0?history.replaceState?history.replaceState(null,null,this.oldHash):window.location.hash=this.oldHash:history.replaceState?history.replaceState(null,document.title,window.location.pathname+window.location.search):window.location.hash="",this.core.$el.off(".lg.hash"))},a.fn.lightGallery.modules.hash=c}()}),function(a,b){"function"==typeof define&&define.amd?define(["jquery"],function(a){return b(a)}):"object"==typeof exports?module.exports=b(require("jquery")):b(jQuery)}(0,function(a){!function(){"use strict";var b={share:!0,facebook:!0,facebookDropdownText:"Facebook",twitter:!0,twitterDropdownText:"Twitter",googlePlus:!0,googlePlusDropdownText:"GooglePlus",pinterest:!0,pinterestDropdownText:"Pinterest"},c=function(c){return this.core=a(c).data("lightGallery"),this.core.s=a.extend({},b,this.core.s),this.core.s.share&&this.init(),this};c.prototype.init=function(){var b=this,c='<span id="lg-share" class="lg-icon"><ul class="lg-dropdown" style="position: absolute;">';c+=b.core.s.facebook?'<li><a id="lg-share-facebook" target="_blank"><span class="lg-icon"></span><span class="lg-dropdown-text">'+this.core.s.facebookDropdownText+"</span></a></li>":"",c+=b.core.s.twitter?'<li><a id="lg-share-twitter" target="_blank"><span class="lg-icon"></span><span class="lg-dropdown-text">'+this.core.s.twitterDropdownText+"</span></a></li>":"",c+=b.core.s.googlePlus?'<li><a id="lg-share-googleplus" target="_blank"><span class="lg-icon"></span><span class="lg-dropdown-text">'+this.core.s.googlePlusDropdownText+"</span></a></li>":"",c+=b.core.s.pinterest?'<li><a id="lg-share-pinterest" target="_blank"><span class="lg-icon"></span><span class="lg-dropdown-text">'+this.core.s.pinterestDropdownText+"</span></a></li>":"",c+="</ul></span>",this.core.$outer.find(".lg-toolbar").append(c),this.core.$outer.find(".lg").append('<div id="lg-dropdown-overlay"></div>'),a("#lg-share").on("click.lg",function(){b.core.$outer.toggleClass("lg-dropdown-active")}),a("#lg-dropdown-overlay").on("click.lg",function(){b.core.$outer.removeClass("lg-dropdown-active")}),b.core.$el.on("onAfterSlide.lg.tm",function(c,d,e){setTimeout(function(){a("#lg-share-facebook").attr("href","https://www.facebook.com/sharer/sharer.php?u="+encodeURIComponent(b.getSahreProps(e,"facebookShareUrl")||window.location.href)),a("#lg-share-twitter").attr("href","https://twitter.com/intent/tweet?text="+b.getSahreProps(e,"tweetText")+"&url="+encodeURIComponent(b.getSahreProps(e,"twitterShareUrl")||window.location.href)),a("#lg-share-googleplus").attr("href","https://plus.google.com/share?url="+encodeURIComponent(b.getSahreProps(e,"googleplusShareUrl")||window.location.href)),a("#lg-share-pinterest").attr("href","http://www.pinterest.com/pin/create/button/?url="+encodeURIComponent(b.getSahreProps(e,"pinterestShareUrl")||window.location.href)+"&media="+encodeURIComponent(b.getSahreProps(e,"src"))+"&description="+b.getSahreProps(e,"pinterestText"))},100)})},c.prototype.getSahreProps=function(a,b){var c="";if(this.core.s.dynamic)c=this.core.s.dynamicEl[a][b];else{var d=this.core.$items.eq(a).attr("href"),e=this.core.$items.eq(a).data(b);c="src"===b?d||e:e}return c},c.prototype.destroy=function(){},a.fn.lightGallery.modules.share=c}()});
/*! lightgallery - v1.6.9 - 2018-04-03
* http://sachinchoolur.github.io/lightGallery/
* Copyright (c) 2018 Sachin N; Licensed GPLv3 */
(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module unless amdModuleId is set
    define(['jquery'], function (a0) {
      return (factory(a0));
    });
  } else if (typeof module === 'object' && module.exports) {
    // Node. Does not work with strict CommonJS, but
    // only CommonJS-like environments that support module.exports,
    // like Node.
    module.exports = factory(require('jquery'));
  } else {
    factory(root["jQuery"]);
  }
}(this, function ($) {

(function() {
    'use strict';

    var defaults = {

        mode: 'lg-slide',

        // Ex : 'ease'
        cssEasing: 'ease',

        //'for jquery animation'
        easing: 'linear',
        speed: 600,
        height: '100%',
        width: '100%',
        addClass: '',
        startClass: 'lg-start-zoom',
        backdropDuration: 150,
        hideBarsDelay: 6000,

        useLeft: false,

        closable: true,
        loop: true,
        escKey: true,
        keyPress: true,
        controls: true,
        slideEndAnimatoin: true,
        hideControlOnEnd: false,
        mousewheel: true,

        getCaptionFromTitleOrAlt: true,

        // .lg-item || '.lg-sub-html'
        appendSubHtmlTo: '.lg-sub-html',

        subHtmlSelectorRelative: false,

        /**
         * @desc number of preload slides
         * will exicute only after the current slide is fully loaded.
         *
         * @ex you clicked on 4th image and if preload = 1 then 3rd slide and 5th
         * slide will be loaded in the background after the 4th slide is fully loaded..
         * if preload is 2 then 2nd 3rd 5th 6th slides will be preloaded.. ... ...
         *
         */
        preload: 1,
        showAfterLoad: true,
        selector: '',
        selectWithin: '',
        nextHtml: '',
        prevHtml: '',

        // 0, 1
        index: false,

        iframeMaxWidth: '100%',

        download: true,
        counter: true,
        appendCounterTo: '.lg-toolbar',

        swipeThreshold: 50,
        enableSwipe: true,
        enableDrag: true,

        dynamic: false,
        dynamicEl: [],
        galleryId: 1
    };

    function Plugin(element, options) {

        // Current lightGallery element
        this.el = element;

        // Current jquery element
        this.$el = $(element);

        // lightGallery settings
        this.s = $.extend({}, defaults, options);

        // When using dynamic mode, ensure dynamicEl is an array
        if (this.s.dynamic && this.s.dynamicEl !== 'undefined' && this.s.dynamicEl.constructor === Array && !this.s.dynamicEl.length) {
            throw ('When using dynamic mode, you must also define dynamicEl as an Array.');
        }

        // lightGallery modules
        this.modules = {};

        // false when lightgallery complete first slide;
        this.lGalleryOn = false;

        this.lgBusy = false;

        // Timeout function for hiding controls;
        this.hideBartimeout = false;

        // To determine browser supports for touch events;
        this.isTouch = ('ontouchstart' in document.documentElement);

        // Disable hideControlOnEnd if sildeEndAnimation is true
        if (this.s.slideEndAnimatoin) {
            this.s.hideControlOnEnd = false;
        }

        // Gallery items
        if (this.s.dynamic) {
            this.$items = this.s.dynamicEl;
        } else {
            if (this.s.selector === 'this') {
                this.$items = this.$el;
            } else if (this.s.selector !== '') {
                if (this.s.selectWithin) {
                    this.$items = $(this.s.selectWithin).find(this.s.selector);
                } else {
                    this.$items = this.$el.find($(this.s.selector));
                }
            } else {
                this.$items = this.$el.children();
            }
        }

        // .lg-item
        this.$slide = '';

        // .lg-outer
        this.$outer = '';

        this.init();

        return this;
    }

    Plugin.prototype.init = function() {

        var _this = this;

        // s.preload should not be more than $item.length
        if (_this.s.preload > _this.$items.length) {
            _this.s.preload = _this.$items.length;
        }

        // if dynamic option is enabled execute immediately
        var _hash = window.location.hash;
        if (_hash.indexOf('lg=' + this.s.galleryId) > 0) {

            _this.index = parseInt(_hash.split('&slide=')[1], 10);

            $('body').addClass('lg-from-hash');
            if (!$('body').hasClass('lg-on')) {
                setTimeout(function() {
                    _this.build(_this.index);
                });

                $('body').addClass('lg-on');
            }
        }

        if (_this.s.dynamic) {

            _this.$el.trigger('onBeforeOpen.lg');

            _this.index = _this.s.index || 0;

            // prevent accidental double execution
            if (!$('body').hasClass('lg-on')) {
                setTimeout(function() {
                    _this.build(_this.index);
                    $('body').addClass('lg-on');
                });
            }
        } else {

            // Using different namespace for click because click event should not unbind if selector is same object('this')
            _this.$items.on('click.lgcustom', function(event) {

                // For IE8
                try {
                    event.preventDefault();
                    event.preventDefault();
                } catch (er) {
                    event.returnValue = false;
                }

                _this.$el.trigger('onBeforeOpen.lg');

                _this.index = _this.s.index || _this.$items.index(this);

                // prevent accidental double execution
                if (!$('body').hasClass('lg-on')) {
                    _this.build(_this.index);
                    $('body').addClass('lg-on');
                }
            });
        }

    };

    Plugin.prototype.build = function(index) {

        var _this = this;

        _this.structure();

        // module constructor
        $.each($.fn.lightGallery.modules, function(key) {
            _this.modules[key] = new $.fn.lightGallery.modules[key](_this.el);
        });

        // initiate slide function
        _this.slide(index, false, false, false);

        if (_this.s.keyPress) {
            _this.keyPress();
        }

        if (_this.$items.length > 1) {

            _this.arrow();

            setTimeout(function() {
                _this.enableDrag();
                _this.enableSwipe();
            }, 50);

            if (_this.s.mousewheel) {
                _this.mousewheel();
            }
        } else {
            _this.$slide.on('click.lg', function() {
                _this.$el.trigger('onSlideClick.lg');
            });
        }

        _this.counter();

        _this.closeGallery();

        _this.$el.trigger('onAfterOpen.lg');

        // Hide controllers if mouse doesn't move for some period
        _this.$outer.on('mousemove.lg click.lg touchstart.lg', function() {

            _this.$outer.removeClass('lg-hide-items');

            clearTimeout(_this.hideBartimeout);

            // Timeout will be cleared on each slide movement also
            _this.hideBartimeout = setTimeout(function() {
                _this.$outer.addClass('lg-hide-items');
            }, _this.s.hideBarsDelay);

        });

        _this.$outer.trigger('mousemove.lg');

    };

    Plugin.prototype.structure = function() {
        var list = '';
        var controls = '';
        var i = 0;
        var subHtmlCont = '';
        var template;
        var _this = this;

        $('body').append('<div class="lg-backdrop"></div>');
        $('.lg-backdrop').css('transition-duration', this.s.backdropDuration + 'ms');

        // Create gallery items
        for (i = 0; i < this.$items.length; i++) {
            list += '<div class="lg-item"></div>';
        }

        // Create controlls
        if (this.s.controls && this.$items.length > 1) {
            controls = '<div class="lg-actions">' +
                '<button class="lg-prev lg-icon">' + this.s.prevHtml + '</button>' +
                '<button class="lg-next lg-icon">' + this.s.nextHtml + '</button>' +
                '</div>';
        }

        if (this.s.appendSubHtmlTo === '.lg-sub-html') {
            subHtmlCont = '<div class="lg-sub-html"></div>';
        }

        template = '<div class="lg-outer ' + this.s.addClass + ' ' + this.s.startClass + '">' +
            '<div class="lg" style="width:' + this.s.width + '; height:' + this.s.height + '">' +
            '<div class="lg-inner">' + list + '</div>' +
            '<div class="lg-toolbar lg-group">' +
            '<span class="lg-close lg-icon"></span>' +
            '</div>' +
            controls +
            subHtmlCont +
            '</div>' +
            '</div>';

        $('body').append(template);
        this.$outer = $('.lg-outer');
        this.$slide = this.$outer.find('.lg-item');

        if (this.s.useLeft) {
            this.$outer.addClass('lg-use-left');

            // Set mode lg-slide if use left is true;
            this.s.mode = 'lg-slide';
        } else {
            this.$outer.addClass('lg-use-css3');
        }

        // For fixed height gallery
        _this.setTop();
        $(window).on('resize.lg orientationchange.lg', function() {
            setTimeout(function() {
                _this.setTop();
            }, 100);
        });

        // add class lg-current to remove initial transition
        this.$slide.eq(this.index).addClass('lg-current');

        // add Class for css support and transition mode
        if (this.doCss()) {
            this.$outer.addClass('lg-css3');
        } else {
            this.$outer.addClass('lg-css');

            // Set speed 0 because no animation will happen if browser doesn't support css3
            this.s.speed = 0;
        }

        this.$outer.addClass(this.s.mode);

        if (this.s.enableDrag && this.$items.length > 1) {
            this.$outer.addClass('lg-grab');
        }

        if (this.s.showAfterLoad) {
            this.$outer.addClass('lg-show-after-load');
        }

        if (this.doCss()) {
            var $inner = this.$outer.find('.lg-inner');
            $inner.css('transition-timing-function', this.s.cssEasing);
            $inner.css('transition-duration', this.s.speed + 'ms');
        }

        setTimeout(function() {
            $('.lg-backdrop').addClass('in');
        });

        setTimeout(function() {
            _this.$outer.addClass('lg-visible');
        }, this.s.backdropDuration);

        if (this.s.download) {
            this.$outer.find('.lg-toolbar').append('<a id="lg-download" target="_blank" download class="lg-download lg-icon"></a>');
        }

        // Store the current scroll top value to scroll back after closing the gallery..
        this.prevScrollTop = $(window).scrollTop();

    };

    // For fixed height gallery
    Plugin.prototype.setTop = function() {
        if (this.s.height !== '100%') {
            var wH = $(window).height();
            var top = (wH - parseInt(this.s.height, 10)) / 2;
            var $lGallery = this.$outer.find('.lg');
            if (wH >= parseInt(this.s.height, 10)) {
                $lGallery.css('top', top + 'px');
            } else {
                $lGallery.css('top', '0px');
            }
        }
    };

    // Find css3 support
    Plugin.prototype.doCss = function() {
        // check for css animation support
        var support = function() {
            var transition = ['transition', 'MozTransition', 'WebkitTransition', 'OTransition', 'msTransition', 'KhtmlTransition'];
            var root = document.documentElement;
            var i = 0;
            for (i = 0; i < transition.length; i++) {
                if (transition[i] in root.style) {
                    return true;
                }
            }
        };

        if (support()) {
            return true;
        }

        return false;
    };

    /**
     *  @desc Check the given src is video
     *  @param {String} src
     *  @return {Object} video type
     *  Ex:{ youtube  :  ["//www.youtube.com/watch?v=c0asJgSyxcY", "c0asJgSyxcY"] }
     */
    Plugin.prototype.isVideo = function(src, index) {

        var html;
        if (this.s.dynamic) {
            html = this.s.dynamicEl[index].html;
        } else {
            html = this.$items.eq(index).attr('data-html');
        }

        if (!src) {
            if(html) {
                return {
                    html5: true
                };
            } else {
                console.error('lightGallery :- data-src is not pvovided on slide item ' + (index + 1) + '. Please make sure the selector property is properly configured. More info - http://sachinchoolur.github.io/lightGallery/demos/html-markup.html');
                return false;
            }
        }

        var youtube = src.match(/\/\/(?:www\.)?youtu(?:\.be|be\.com)\/(?:watch\?v=|embed\/)?([a-z0-9\-\_\%]+)/i);
        var vimeo = src.match(/\/\/(?:www\.)?vimeo.com\/([0-9a-z\-_]+)/i);
        var dailymotion = src.match(/\/\/(?:www\.)?dai.ly\/([0-9a-z\-_]+)/i);
        var vk = src.match(/\/\/(?:www\.)?(?:vk\.com|vkontakte\.ru)\/(?:video_ext\.php\?)(.*)/i);

        if (youtube) {
            return {
                youtube: youtube
            };
        } else if (vimeo) {
            return {
                vimeo: vimeo
            };
        } else if (dailymotion) {
            return {
                dailymotion: dailymotion
            };
        } else if (vk) {
            return {
                vk: vk
            };
        }
    };

    /**
     *  @desc Create image counter
     *  Ex: 1/10
     */
    Plugin.prototype.counter = function() {
        if (this.s.counter) {
            $(this.s.appendCounterTo).append('<div id="lg-counter"><span id="lg-counter-current">' + (parseInt(this.index, 10) + 1) + '</span> / <span id="lg-counter-all">' + this.$items.length + '</span></div>');
        }
    };

    /**
     *  @desc add sub-html into the slide
     *  @param {Number} index - index of the slide
     */
    Plugin.prototype.addHtml = function(index) {
        var subHtml = null;
        var subHtmlUrl;
        var $currentEle;
        if (this.s.dynamic) {
            if (this.s.dynamicEl[index].subHtmlUrl) {
                subHtmlUrl = this.s.dynamicEl[index].subHtmlUrl;
            } else {
                subHtml = this.s.dynamicEl[index].subHtml;
            }
        } else {
            $currentEle = this.$items.eq(index);
            if ($currentEle.attr('data-sub-html-url')) {
                subHtmlUrl = $currentEle.attr('data-sub-html-url');
            } else {
                subHtml = $currentEle.attr('data-sub-html');
                if (this.s.getCaptionFromTitleOrAlt && !subHtml) {
                    subHtml = $currentEle.attr('title') || $currentEle.find('img').first().attr('alt');
                }
            }
        }

        if (!subHtmlUrl) {
            if (typeof subHtml !== 'undefined' && subHtml !== null) {

                // get first letter of subhtml
                // if first letter starts with . or # get the html form the jQuery object
                var fL = subHtml.substring(0, 1);
                if (fL === '.' || fL === '#') {
                    if (this.s.subHtmlSelectorRelative && !this.s.dynamic) {
                        subHtml = $currentEle.find(subHtml).html();
                    } else {
                        subHtml = $(subHtml).html();
                    }
                }
            } else {
                subHtml = '';
            }
        }

        if (this.s.appendSubHtmlTo === '.lg-sub-html') {

            if (subHtmlUrl) {
                this.$outer.find(this.s.appendSubHtmlTo).load(subHtmlUrl);
            } else {
                this.$outer.find(this.s.appendSubHtmlTo).html(subHtml);
            }

        } else {

            if (subHtmlUrl) {
                this.$slide.eq(index).load(subHtmlUrl);
            } else {
                this.$slide.eq(index).append(subHtml);
            }
        }

        // Add lg-empty-html class if title doesn't exist
        if (typeof subHtml !== 'undefined' && subHtml !== null) {
            if (subHtml === '') {
                this.$outer.find(this.s.appendSubHtmlTo).addClass('lg-empty-html');
            } else {
                this.$outer.find(this.s.appendSubHtmlTo).removeClass('lg-empty-html');
            }
        }

        this.$el.trigger('onAfterAppendSubHtml.lg', [index]);
    };

    /**
     *  @desc Preload slides
     *  @param {Number} index - index of the slide
     */
    Plugin.prototype.preload = function(index) {
        var i = 1;
        var j = 1;
        for (i = 1; i <= this.s.preload; i++) {
            if (i >= this.$items.length - index) {
                break;
            }

            this.loadContent(index + i, false, 0);
        }

        for (j = 1; j <= this.s.preload; j++) {
            if (index - j < 0) {
                break;
            }

            this.loadContent(index - j, false, 0);
        }
    };

    /**
     *  @desc Load slide content into slide.
     *  @param {Number} index - index of the slide.
     *  @param {Boolean} rec - if true call loadcontent() function again.
     *  @param {Boolean} delay - delay for adding complete class. it is 0 except first time.
     */
    Plugin.prototype.loadContent = function(index, rec, delay) {

        var _this = this;
        var _hasPoster = false;
        var _$img;
        var _src;
        var _poster;
        var _srcset;
        var _sizes;
        var _html;
        var getResponsiveSrc = function(srcItms) {
            var rsWidth = [];
            var rsSrc = [];
            for (var i = 0; i < srcItms.length; i++) {
                var __src = srcItms[i].split(' ');

                // Manage empty space
                if (__src[0] === '') {
                    __src.splice(0, 1);
                }

                rsSrc.push(__src[0]);
                rsWidth.push(__src[1]);
            }

            var wWidth = $(window).width();
            for (var j = 0; j < rsWidth.length; j++) {
                if (parseInt(rsWidth[j], 10) > wWidth) {
                    _src = rsSrc[j];
                    break;
                }
            }
        };

        if (_this.s.dynamic) {

            if (_this.s.dynamicEl[index].poster) {
                _hasPoster = true;
                _poster = _this.s.dynamicEl[index].poster;
            }

            _html = _this.s.dynamicEl[index].html;
            _src = _this.s.dynamicEl[index].src;

            if (_this.s.dynamicEl[index].responsive) {
                var srcDyItms = _this.s.dynamicEl[index].responsive.split(',');
                getResponsiveSrc(srcDyItms);
            }

            _srcset = _this.s.dynamicEl[index].srcset;
            _sizes = _this.s.dynamicEl[index].sizes;

        } else {

            if (_this.$items.eq(index).attr('data-poster')) {
                _hasPoster = true;
                _poster = _this.$items.eq(index).attr('data-poster');
            }

            _html = _this.$items.eq(index).attr('data-html');
            _src = _this.$items.eq(index).attr('href') || _this.$items.eq(index).attr('data-src');

            if (_this.$items.eq(index).attr('data-responsive')) {
                var srcItms = _this.$items.eq(index).attr('data-responsive').split(',');
                getResponsiveSrc(srcItms);
            }

            _srcset = _this.$items.eq(index).attr('data-srcset');
            _sizes = _this.$items.eq(index).attr('data-sizes');

        }

        //if (_src || _srcset || _sizes || _poster) {

        var iframe = false;
        if (_this.s.dynamic) {
            if (_this.s.dynamicEl[index].iframe) {
                iframe = true;
            }
        } else {
            if (_this.$items.eq(index).attr('data-iframe') === 'true') {
                iframe = true;
            }
        }

        var _isVideo = _this.isVideo(_src, index);
        if (!_this.$slide.eq(index).hasClass('lg-loaded')) {
            if (iframe) {
                _this.$slide.eq(index).prepend('<div class="lg-video-cont lg-has-iframe" style="max-width:' + _this.s.iframeMaxWidth + '"><div class="lg-video"><iframe class="lg-object" frameborder="0" src="' + _src + '"  allowfullscreen="true"></iframe></div></div>');
            } else if (_hasPoster) {
                var videoClass = '';
                if (_isVideo && _isVideo.youtube) {
                    videoClass = 'lg-has-youtube';
                } else if (_isVideo && _isVideo.vimeo) {
                    videoClass = 'lg-has-vimeo';
                } else {
                    videoClass = 'lg-has-html5';
                }

                _this.$slide.eq(index).prepend('<div class="lg-video-cont ' + videoClass + ' "><div class="lg-video"><span class="lg-video-play"></span><img class="lg-object lg-has-poster" src="' + _poster + '" /></div></div>');

            } else if (_isVideo) {
                _this.$slide.eq(index).prepend('<div class="lg-video-cont "><div class="lg-video"></div></div>');
                _this.$el.trigger('hasVideo.lg', [index, _src, _html]);
            } else {
                _this.$slide.eq(index).prepend('<div class="lg-img-wrap"><img class="lg-object lg-image" src="' + _src + '" /></div>');
            }

            _this.$el.trigger('onAferAppendSlide.lg', [index]);

            _$img = _this.$slide.eq(index).find('.lg-object');
            if (_sizes) {
                _$img.attr('sizes', _sizes);
            }

            if (_srcset) {
                _$img.attr('srcset', _srcset);
                try {
                    picturefill({
                        elements: [_$img[0]]
                    });
                } catch (e) {
                    console.warn('lightGallery :- If you want srcset to be supported for older browser please include picturefil version 2 javascript library in your document.');
                }
            }

            if (this.s.appendSubHtmlTo !== '.lg-sub-html') {
                _this.addHtml(index);
            }

            _this.$slide.eq(index).addClass('lg-loaded');
        }

        _this.$slide.eq(index).find('.lg-object').on('load.lg error.lg', function() {

            // For first time add some delay for displaying the start animation.
            var _speed = 0;

            // Do not change the delay value because it is required for zoom plugin.
            // If gallery opened from direct url (hash) speed value should be 0
            if (delay && !$('body').hasClass('lg-from-hash')) {
                _speed = delay;
            }

            setTimeout(function() {
                _this.$slide.eq(index).addClass('lg-complete');
                _this.$el.trigger('onSlideItemLoad.lg', [index, delay || 0]);
            }, _speed);

        });

        // @todo check load state for html5 videos
        if (_isVideo && _isVideo.html5 && !_hasPoster) {
            _this.$slide.eq(index).addClass('lg-complete');
        }

        if (rec === true) {
            if (!_this.$slide.eq(index).hasClass('lg-complete')) {
                _this.$slide.eq(index).find('.lg-object').on('load.lg error.lg', function() {
                    _this.preload(index);
                });
            } else {
                _this.preload(index);
            }
        }

        //}
    };

    /**
    *   @desc slide function for lightgallery
        ** Slide() gets call on start
        ** ** Set lg.on true once slide() function gets called.
        ** Call loadContent() on slide() function inside setTimeout
        ** ** On first slide we do not want any animation like slide of fade
        ** ** So on first slide( if lg.on if false that is first slide) loadContent() should start loading immediately
        ** ** Else loadContent() should wait for the transition to complete.
        ** ** So set timeout s.speed + 50
    <=> ** loadContent() will load slide content in to the particular slide
        ** ** It has recursion (rec) parameter. if rec === true loadContent() will call preload() function.
        ** ** preload will execute only when the previous slide is fully loaded (images iframe)
        ** ** avoid simultaneous image load
    <=> ** Preload() will check for s.preload value and call loadContent() again accoring to preload value
        ** loadContent()  <====> Preload();

    *   @param {Number} index - index of the slide
    *   @param {Boolean} fromTouch - true if slide function called via touch event or mouse drag
    *   @param {Boolean} fromThumb - true if slide function called via thumbnail click
    *   @param {String} direction - Direction of the slide(next/prev)
    */
    Plugin.prototype.slide = function(index, fromTouch, fromThumb, direction) {

        var _prevIndex = this.$outer.find('.lg-current').index();
        var _this = this;

        // Prevent if multiple call
        // Required for hsh plugin
        if (_this.lGalleryOn && (_prevIndex === index)) {
            return;
        }

        var _length = this.$slide.length;
        var _time = _this.lGalleryOn ? this.s.speed : 0;

        if (!_this.lgBusy) {

            if (this.s.download) {
                var _src;
                if (_this.s.dynamic) {
                    _src = _this.s.dynamicEl[index].downloadUrl !== false && (_this.s.dynamicEl[index].downloadUrl || _this.s.dynamicEl[index].src);
                } else {
                    _src = _this.$items.eq(index).attr('data-download-url') !== 'false' && (_this.$items.eq(index).attr('data-download-url') || _this.$items.eq(index).attr('href') || _this.$items.eq(index).attr('data-src'));

                }

                if (_src) {
                    $('#lg-download').attr('href', _src);
                    _this.$outer.removeClass('lg-hide-download');
                } else {
                    _this.$outer.addClass('lg-hide-download');
                }
            }

            this.$el.trigger('onBeforeSlide.lg', [_prevIndex, index, fromTouch, fromThumb]);

            _this.lgBusy = true;

            clearTimeout(_this.hideBartimeout);

            // Add title if this.s.appendSubHtmlTo === lg-sub-html
            if (this.s.appendSubHtmlTo === '.lg-sub-html') {

                // wait for slide animation to complete
                setTimeout(function() {
                    _this.addHtml(index);
                }, _time);
            }

            this.arrowDisable(index);

            if (!direction) {
                if (index < _prevIndex) {
                    direction = 'prev';
                } else if (index > _prevIndex) {
                    direction = 'next';
                }
            }

            if (!fromTouch) {

                // remove all transitions
                _this.$outer.addClass('lg-no-trans');

                this.$slide.removeClass('lg-prev-slide lg-next-slide');

                if (direction === 'prev') {

                    //prevslide
                    this.$slide.eq(index).addClass('lg-prev-slide');
                    this.$slide.eq(_prevIndex).addClass('lg-next-slide');
                } else {

                    // next slide
                    this.$slide.eq(index).addClass('lg-next-slide');
                    this.$slide.eq(_prevIndex).addClass('lg-prev-slide');
                }

                // give 50 ms for browser to add/remove class
                setTimeout(function() {
                    _this.$slide.removeClass('lg-current');

                    //_this.$slide.eq(_prevIndex).removeClass('lg-current');
                    _this.$slide.eq(index).addClass('lg-current');

                    // reset all transitions
                    _this.$outer.removeClass('lg-no-trans');
                }, 50);
            } else {

                this.$slide.removeClass('lg-prev-slide lg-current lg-next-slide');
                var touchPrev;
                var touchNext;
                if (_length > 2) {
                    touchPrev = index - 1;
                    touchNext = index + 1;

                    if ((index === 0) && (_prevIndex === _length - 1)) {

                        // next slide
                        touchNext = 0;
                        touchPrev = _length - 1;
                    } else if ((index === _length - 1) && (_prevIndex === 0)) {

                        // prev slide
                        touchNext = 0;
                        touchPrev = _length - 1;
                    }

                } else {
                    touchPrev = 0;
                    touchNext = 1;
                }

                if (direction === 'prev') {
                    _this.$slide.eq(touchNext).addClass('lg-next-slide');
                } else {
                    _this.$slide.eq(touchPrev).addClass('lg-prev-slide');
                }

                _this.$slide.eq(index).addClass('lg-current');
            }

            if (_this.lGalleryOn) {
                setTimeout(function() {
                    _this.loadContent(index, true, 0);
                }, this.s.speed + 50);

                setTimeout(function() {
                    _this.lgBusy = false;
                    _this.$el.trigger('onAfterSlide.lg', [_prevIndex, index, fromTouch, fromThumb]);
                }, this.s.speed);

            } else {
                _this.loadContent(index, true, _this.s.backdropDuration);

                _this.lgBusy = false;
                _this.$el.trigger('onAfterSlide.lg', [_prevIndex, index, fromTouch, fromThumb]);
            }

            _this.lGalleryOn = true;

            if (this.s.counter) {
                $('#lg-counter-current').text(index + 1);
            }

        }
        _this.index = index;

    };

    /**
     *  @desc Go to next slide
     *  @param {Boolean} fromTouch - true if slide function called via touch event
     */
    Plugin.prototype.goToNextSlide = function(fromTouch) {
        var _this = this;
        var _loop = _this.s.loop;
        if (fromTouch && _this.$slide.length < 3) {
            _loop = false;
        }

        if (!_this.lgBusy) {
            if ((_this.index + 1) < _this.$slide.length) {
                _this.index++;
                _this.$el.trigger('onBeforeNextSlide.lg', [_this.index]);
                _this.slide(_this.index, fromTouch, false, 'next');
            } else {
                if (_loop) {
                    _this.index = 0;
                    _this.$el.trigger('onBeforeNextSlide.lg', [_this.index]);
                    _this.slide(_this.index, fromTouch, false, 'next');
                } else if (_this.s.slideEndAnimatoin && !fromTouch) {
                    _this.$outer.addClass('lg-right-end');
                    setTimeout(function() {
                        _this.$outer.removeClass('lg-right-end');
                    }, 400);
                }
            }
        }
    };

    /**
     *  @desc Go to previous slide
     *  @param {Boolean} fromTouch - true if slide function called via touch event
     */
    Plugin.prototype.goToPrevSlide = function(fromTouch) {
        var _this = this;
        var _loop = _this.s.loop;
        if (fromTouch && _this.$slide.length < 3) {
            _loop = false;
        }

        if (!_this.lgBusy) {
            if (_this.index > 0) {
                _this.index--;
                _this.$el.trigger('onBeforePrevSlide.lg', [_this.index, fromTouch]);
                _this.slide(_this.index, fromTouch, false, 'prev');
            } else {
                if (_loop) {
                    _this.index = _this.$items.length - 1;
                    _this.$el.trigger('onBeforePrevSlide.lg', [_this.index, fromTouch]);
                    _this.slide(_this.index, fromTouch, false, 'prev');
                } else if (_this.s.slideEndAnimatoin && !fromTouch) {
                    _this.$outer.addClass('lg-left-end');
                    setTimeout(function() {
                        _this.$outer.removeClass('lg-left-end');
                    }, 400);
                }
            }
        }
    };

    Plugin.prototype.keyPress = function() {
        var _this = this;
        if (this.$items.length > 1) {
            $(window).on('keyup.lg', function(e) {
                if (_this.$items.length > 1) {
                    if (e.keyCode === 37) {
                        e.preventDefault();
                        _this.goToPrevSlide();
                    }

                    if (e.keyCode === 39) {
                        e.preventDefault();
                        _this.goToNextSlide();
                    }
                }
            });
        }

        $(window).on('keydown.lg', function(e) {
            if (_this.s.escKey === true && e.keyCode === 27) {
                e.preventDefault();
                if (!_this.$outer.hasClass('lg-thumb-open')) {
                    _this.destroy();
                } else {
                    _this.$outer.removeClass('lg-thumb-open');
                }
            }
        });
    };

    Plugin.prototype.arrow = function() {
        var _this = this;
        this.$outer.find('.lg-prev').on('click.lg', function() {
            _this.goToPrevSlide();
        });

        this.$outer.find('.lg-next').on('click.lg', function() {
            _this.goToNextSlide();
        });
    };

    Plugin.prototype.arrowDisable = function(index) {

        // Disable arrows if s.hideControlOnEnd is true
        if (!this.s.loop && this.s.hideControlOnEnd) {
            if ((index + 1) < this.$slide.length) {
                this.$outer.find('.lg-next').removeAttr('disabled').removeClass('disabled');
            } else {
                this.$outer.find('.lg-next').attr('disabled', 'disabled').addClass('disabled');
            }

            if (index > 0) {
                this.$outer.find('.lg-prev').removeAttr('disabled').removeClass('disabled');
            } else {
                this.$outer.find('.lg-prev').attr('disabled', 'disabled').addClass('disabled');
            }
        }
    };

    Plugin.prototype.setTranslate = function($el, xValue, yValue) {
        // jQuery supports Automatic CSS prefixing since jQuery 1.8.0
        if (this.s.useLeft) {
            $el.css('left', xValue);
        } else {
            $el.css({
                transform: 'translate3d(' + (xValue) + 'px, ' + yValue + 'px, 0px)'
            });
        }
    };

    Plugin.prototype.touchMove = function(startCoords, endCoords) {

        var distance = endCoords - startCoords;

        if (Math.abs(distance) > 15) {
            // reset opacity and transition duration
            this.$outer.addClass('lg-dragging');

            // move current slide
            this.setTranslate(this.$slide.eq(this.index), distance, 0);

            // move next and prev slide with current slide
            this.setTranslate($('.lg-prev-slide'), -this.$slide.eq(this.index).width() + distance, 0);
            this.setTranslate($('.lg-next-slide'), this.$slide.eq(this.index).width() + distance, 0);
        }
    };

    Plugin.prototype.touchEnd = function(distance) {
        var _this = this;

        // keep slide animation for any mode while dragg/swipe
        if (_this.s.mode !== 'lg-slide') {
            _this.$outer.addClass('lg-slide');
        }

        this.$slide.not('.lg-current, .lg-prev-slide, .lg-next-slide').css('opacity', '0');

        // set transition duration
        setTimeout(function() {
            _this.$outer.removeClass('lg-dragging');
            if ((distance < 0) && (Math.abs(distance) > _this.s.swipeThreshold)) {
                _this.goToNextSlide(true);
            } else if ((distance > 0) && (Math.abs(distance) > _this.s.swipeThreshold)) {
                _this.goToPrevSlide(true);
            } else if (Math.abs(distance) < 5) {

                // Trigger click if distance is less than 5 pix
                _this.$el.trigger('onSlideClick.lg');
            }

            _this.$slide.removeAttr('style');
        });

        // remove slide class once drag/swipe is completed if mode is not slide
        setTimeout(function() {
            if (!_this.$outer.hasClass('lg-dragging') && _this.s.mode !== 'lg-slide') {
                _this.$outer.removeClass('lg-slide');
            }
        }, _this.s.speed + 100);

    };

    Plugin.prototype.enableSwipe = function() {
        var _this = this;
        var startCoords = 0;
        var endCoords = 0;
        var isMoved = false;

        if (_this.s.enableSwipe && _this.doCss()) {

            _this.$slide.on('touchstart.lg', function(e) {
                if (!_this.$outer.hasClass('lg-zoomed') && !_this.lgBusy) {
                    e.preventDefault();
                    _this.manageSwipeClass();
                    startCoords = e.originalEvent.targetTouches[0].pageX;
                }
            });

            _this.$slide.on('touchmove.lg', function(e) {
                if (!_this.$outer.hasClass('lg-zoomed')) {
                    e.preventDefault();
                    endCoords = e.originalEvent.targetTouches[0].pageX;
                    _this.touchMove(startCoords, endCoords);
                    isMoved = true;
                }
            });

            _this.$slide.on('touchend.lg', function() {
                if (!_this.$outer.hasClass('lg-zoomed')) {
                    if (isMoved) {
                        isMoved = false;
                        _this.touchEnd(endCoords - startCoords);
                    } else {
                        _this.$el.trigger('onSlideClick.lg');
                    }
                }
            });
        }

    };

    Plugin.prototype.enableDrag = function() {
        var _this = this;
        var startCoords = 0;
        var endCoords = 0;
        var isDraging = false;
        var isMoved = false;
        if (_this.s.enableDrag && _this.doCss()) {
            _this.$slide.on('mousedown.lg', function(e) {
                if (!_this.$outer.hasClass('lg-zoomed') && !_this.lgBusy && !$(e.target).text().trim()) {
                    e.preventDefault();
                    _this.manageSwipeClass();
                    startCoords = e.pageX;
                    isDraging = true;

                    // ** Fix for webkit cursor issue https://code.google.com/p/chromium/issues/detail?id=26723
                    _this.$outer.scrollLeft += 1;
                    _this.$outer.scrollLeft -= 1;

                    // *

                    _this.$outer.removeClass('lg-grab').addClass('lg-grabbing');

                    _this.$el.trigger('onDragstart.lg');
                }
            });

            $(window).on('mousemove.lg', function(e) {
                if (isDraging) {
                    isMoved = true;
                    endCoords = e.pageX;
                    _this.touchMove(startCoords, endCoords);
                    _this.$el.trigger('onDragmove.lg');
                }
            });

            $(window).on('mouseup.lg', function(e) {
                if (isMoved) {
                    isMoved = false;
                    _this.touchEnd(endCoords - startCoords);
                    _this.$el.trigger('onDragend.lg');
                } else if ($(e.target).hasClass('lg-object') || $(e.target).hasClass('lg-video-play')) {
                    _this.$el.trigger('onSlideClick.lg');
                }

                // Prevent execution on click
                if (isDraging) {
                    isDraging = false;
                    _this.$outer.removeClass('lg-grabbing').addClass('lg-grab');
                }
            });

        }
    };

    Plugin.prototype.manageSwipeClass = function() {
        var _touchNext = this.index + 1;
        var _touchPrev = this.index - 1;
        if (this.s.loop && this.$slide.length > 2) {
            if (this.index === 0) {
                _touchPrev = this.$slide.length - 1;
            } else if (this.index === this.$slide.length - 1) {
                _touchNext = 0;
            }
        }

        this.$slide.removeClass('lg-next-slide lg-prev-slide');
        if (_touchPrev > -1) {
            this.$slide.eq(_touchPrev).addClass('lg-prev-slide');
        }

        this.$slide.eq(_touchNext).addClass('lg-next-slide');
    };

    Plugin.prototype.mousewheel = function() {
        var _this = this;
        _this.$outer.on('mousewheel.lg', function(e) {

            if (!e.deltaY) {
                return;
            }

            if (e.deltaY > 0) {
                _this.goToPrevSlide();
            } else {
                _this.goToNextSlide();
            }

            e.preventDefault();
        });

    };

    Plugin.prototype.closeGallery = function() {

        var _this = this;
        var mousedown = false;
        this.$outer.find('.lg-close').on('click.lg', function() {
            _this.destroy();
        });

        if (_this.s.closable) {

            // If you drag the slide and release outside gallery gets close on chrome
            // for preventing this check mousedown and mouseup happened on .lg-item or lg-outer
            _this.$outer.on('mousedown.lg', function(e) {

                if ($(e.target).is('.lg-outer') || $(e.target).is('.lg-item ') || $(e.target).is('.lg-img-wrap')) {
                    mousedown = true;
                } else {
                    mousedown = false;
                }

            });
            
            _this.$outer.on('mousemove.lg', function() {
                mousedown = false;
            });

            _this.$outer.on('mouseup.lg', function(e) {

                if ($(e.target).is('.lg-outer') || $(e.target).is('.lg-item ') || $(e.target).is('.lg-img-wrap') && mousedown) {
                    if (!_this.$outer.hasClass('lg-dragging')) {
                        _this.destroy();
                    }
                }

            });

        }

    };

    Plugin.prototype.destroy = function(d) {

        var _this = this;

        if (!d) {
            _this.$el.trigger('onBeforeClose.lg');
            $(window).scrollTop(_this.prevScrollTop);
        }


        /**
         * if d is false or undefined destroy will only close the gallery
         * plugins instance remains with the element
         *
         * if d is true destroy will completely remove the plugin
         */

        if (d) {
            if (!_this.s.dynamic) {
                // only when not using dynamic mode is $items a jquery collection
                this.$items.off('click.lg click.lgcustom');
            }

            $.removeData(_this.el, 'lightGallery');
        }

        // Unbind all events added by lightGallery
        this.$el.off('.lg.tm');

        // Distroy all lightGallery modules
        $.each($.fn.lightGallery.modules, function(key) {
            if (_this.modules[key]) {
                _this.modules[key].destroy();
            }
        });

        this.lGalleryOn = false;

        clearTimeout(_this.hideBartimeout);
        this.hideBartimeout = false;
        $(window).off('.lg');
        $('body').removeClass('lg-on lg-from-hash');

        if (_this.$outer) {
            _this.$outer.removeClass('lg-visible');
        }

        $('.lg-backdrop').removeClass('in');

        setTimeout(function() {
            if (_this.$outer) {
                _this.$outer.remove();
            }

            $('.lg-backdrop').remove();

            if (!d) {
                _this.$el.trigger('onCloseAfter.lg');
            }

        }, _this.s.backdropDuration + 50);
    };

    $.fn.lightGallery = function(options) {
        return this.each(function() {
            if (!$.data(this, 'lightGallery')) {
                $.data(this, 'lightGallery', new Plugin(this, options));
            } else {
                try {
                    $(this).data('lightGallery').init();
                } catch (err) {
                    console.error('lightGallery has not initiated properly');
                }
            }
        });
    };

    $.fn.lightGallery.modules = {};

})();


}));

/*! lozad.js - v1.14.0 - 2019-10-31
* https://github.com/ApoorvSaxena/lozad.js
* Copyright (c) 2019 Apoorv Saxena; Licensed MIT */


(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
  typeof define === 'function' && define.amd ? define(factory) :
  (global.lozad = factory());
}(this, (function () { 'use strict';

  /**
   * Detect IE browser
   * @const {boolean}
   * @private
   */
  var isIE = typeof document !== 'undefined' && document.documentMode;

  var defaultConfig = {
    rootMargin: '0px',
    threshold: 0,
    load: function load(element) {
      if (element.nodeName.toLowerCase() === 'picture') {
        var img = document.createElement('img');
        if (isIE && element.getAttribute('data-iesrc')) {
          img.src = element.getAttribute('data-iesrc');
        }

        if (element.getAttribute('data-alt')) {
          img.alt = element.getAttribute('data-alt');
        }

        element.append(img);
      }

      if (element.nodeName.toLowerCase() === 'video' && !element.getAttribute('data-src')) {
        if (element.children) {
          var childs = element.children;
          var childSrc = void 0;
          for (var i = 0; i <= childs.length - 1; i++) {
            childSrc = childs[i].getAttribute('data-src');
            if (childSrc) {
              childs[i].src = childSrc;
            }
          }

          element.load();
        }
      }

      if (element.getAttribute('data-poster')) {
        element.poster = element.getAttribute('data-poster');
      }

      if (element.getAttribute('data-src')) {
        element.src = element.getAttribute('data-src');
      }

      if (element.getAttribute('data-srcset')) {
        element.setAttribute('srcset', element.getAttribute('data-srcset'));
      }

      if (element.getAttribute('data-toggle-class')) {
        element.classList.toggle(element.getAttribute('data-toggle-class'));
      }
    },
    loaded: function loaded() {}
  };

  function markAsLoaded(element) {
    element.setAttribute('data-loaded', true);
  }

  var isLoaded = function isLoaded(element) {
    return element.getAttribute('data-loaded') === 'true';
  };

  var onIntersection = function onIntersection(load, loaded) {
    return function (entries, observer) {
      entries.forEach(function (entry) {
        if (entry.intersectionRatio > 0 || entry.isIntersecting) {
          observer.unobserve(entry.target);

          if (!isLoaded(entry.target)) {
            load(entry.target);
            markAsLoaded(entry.target);
            loaded(entry.target);
          }
        }
      });
    };
  };

  var getElements = function getElements(selector) {
    var root = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : document;

    if (selector instanceof Element) {
      return [selector];
    }

    if (selector instanceof NodeList) {
      return selector;
    }

    return root.querySelectorAll(selector);
  };

  function lozad () {
    var selector = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '.lozad';
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

    var _Object$assign = Object.assign({}, defaultConfig, options),
        root = _Object$assign.root,
        rootMargin = _Object$assign.rootMargin,
        threshold = _Object$assign.threshold,
        load = _Object$assign.load,
        loaded = _Object$assign.loaded;

    var observer = void 0;

    if (typeof window !== 'undefined' && window.IntersectionObserver) {
      observer = new IntersectionObserver(onIntersection(load, loaded), {
        root: root,
        rootMargin: rootMargin,
        threshold: threshold
      });
    }

    return {
      observe: function observe() {
        var elements = getElements(selector, root);

        for (var i = 0; i < elements.length; i++) {
          if (isLoaded(elements[i])) {
            continue;
          }

          if (observer) {
            observer.observe(elements[i]);
            continue;
          }

          load(elements[i]);
          markAsLoaded(elements[i]);
          loaded(elements[i]);
        }
      },
      triggerLoad: function triggerLoad(element) {
        if (isLoaded(element)) {
          return;
        }

        load(element);
        markAsLoaded(element);
        loaded(element);
      },

      observer: observer
    };
  }

  return lozad;

})));

$(document).ready(function() {
	//add lazy loading
	lozad('.oct-lazy').observe();
});

(function() {
 function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
      "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, "\\$1") + "=([^;]*)"
    ))
    return matches ? decodeURIComponent(matches[1]) : undefined
 }

 function setCookie(name, value, props) {
    props = props || {}
    var exp = props.expires
    if (typeof exp == "number" && exp) {
       var d = new Date()
       d.setTime(d.getTime() + exp * 1000 * 86400)
       exp = props.expires = d
    }
    if(exp && exp.toUTCString) { props.expires = exp.toUTCString() }

    value = decodeURIComponent(value)
    var updatedCookie = name + "=" + value
    for(var propName in props){
       updatedCookie += "; " + propName
       var propValue = props[propName]
       if(propValue !== true){ updatedCookie += "=" + propValue }
    }
    document.cookie = updatedCookie
 }

 function parseURL(url) {
    var a =  document.createElement("a");
    a.href = url;
    return {
       source: url,
       protocol: a.protocol.replace(":",""),
       host: a.hostname,
       port: a.port,
       query: a.search,
       params: (function(){
          var ret = {},
             seg = a.search.replace(/^\?/,"").split("&"),
             len = seg.length, i = 0, s;
          for (;i<len;i++) {
             if (!seg[i]) { continue; }
             s = seg[i].split("=");
             ret[s[0]] = s[1];
          }
          return ret;
       })(),
       file: (a.pathname.match(/\/([^\/?#]+)$/i) || [,""])[1],
       hash: a.hash.replace("#",""),
       path: a.pathname.replace(/^([^\/])/,"/$1"),
       relative: (a.href.match(/tps?:\/\/[^\/]+(.+)/) || [,""])[1],
       segments: a.pathname.replace(/^\//,"").split("/")
    };
 }

 function parseGetParams() {
    var $_GET = {};
    var __GET = window.location.search.substring(1).split("&");
    for(var i=0; i<__GET.length; i++) {
       var getVar = __GET[i].split("=");
       $_GET[getVar[0]] = typeof(getVar[1])=="undefined" ? "" : decodeURIComponent(getVar[1]);
    }

    return $_GET;
 }

 function setCookieThisDomain(hostname_arr, i)
 {
    var this_domain_tmp = hostname_arr.slice(i).join(".");
    var cookie_param = {expires: 365, path: "/", domain: "." + this_domain_tmp}
    setCookie("prodex24cur_domain", this_domain_tmp, cookie_param);
    var tmp_m = getCookie("prodex24cur_domain");
    if (typeof(tmp_m) == "undefined")
    {
       i--;
       if (i < 0)
          return;

       setCookieThisDomain(hostname_arr, i);
    }
 }

 var hostname = location.host || location.hostname;
 var hostname_arr = hostname.split(".");
 var len = hostname_arr.length - 2;
 setCookieThisDomain(hostname_arr, len);
 this_domain = getCookie("prodex24cur_domain");
 var cookie_param = {expires: 365, path: "/", domain: "." + this_domain};
 
 var refer = document.referrer || location.referrer;
 
 var get = parseGetParams();
 if (typeof(get.utm_expid) != "undefined")
 {
    //setCookie("prodex24experiment", get.utm_expid, cookie_param);
 }

 var myURL = parseURL(refer);
 myURLhost = myURL.host;

 if (typeof(get.utm_source) != "undefined" || typeof(get.utm_medium) != "undefined" || typeof(get.utm_campaign) != "undefined" || typeof(get.utm_content) != "undefined" || typeof(get.utm_term) != "undefined" || typeof(get.yclid) != "undefined" || typeof(get.gclid) != "undefined")
 {
    setCookie("prodex24source", get.utm_source || "", cookie_param);
    if (typeof(get.utm_source) == "undefined")
    {
       if (typeof(get.gclid) != "undefined")
       {setCookie("prodex24source", "google", cookie_param);}
    }

    setCookie("prodex24medium", get.utm_medium || "", cookie_param);
    if (typeof(get.utm_medium) == "undefined")
    {
       if (typeof(get.yclid) != "undefined")
       {setCookie("prodex24medium", "cpc", cookie_param);}
       if (typeof(get.gclid) != "undefined")
       {setCookie("prodex24medium", "cpc", cookie_param);}
    }
    setCookie("prodex24campaign", get.utm_campaign || "", cookie_param);
    setCookie("prodex24content", get.utm_content || "", cookie_param);
    setCookie("prodex24term", get.utm_term || "", cookie_param);

    if (refer && myURLhost.indexOf(window.location.hostname) == -1 && window.location.hostname.indexOf(myURLhost) == -1)
    {setCookie("prodex24source_full", refer || "", cookie_param);}
 }
 else if (refer)
 {
    if  (myURLhost.indexOf(window.location.hostname) == -1 && window.location.hostname.indexOf(myURLhost) == -1)
    {
       setCookie("prodex24source_full", refer, cookie_param);
       var domain = myURL.host.replace(/^www\./i, "");
       setCookie("prodex24source", domain, cookie_param);

       if (typeof(get.gclid) != "undefined")
       {setCookie("prodex24medium", "cpc", cookie_param);}
       else if (/^(((google|search\.yahoo|yandex|bing)(\.[^.]+)+)|(rambler\.ru)|(ukr\.net)|(mail\.ru))$/i.test(domain))
       {setCookie("prodex24medium", "organic", cookie_param);}
       else
       {setCookie("prodex24medium", "referral", cookie_param);}

       setCookie("prodex24campaign", "", cookie_param);
       setCookie("prodex24content", "", cookie_param);
       setCookie("prodex24term", "", cookie_param);

    }
 }
})();
function remarketingAddToCart(json) {
	console.log ('%c%s', 'color: #a700ff', 'add_to_cart_sent');
	
	heading = $('title').text() || 'other'; 

	if (json['remarketing']) {
		if (json['remarketing']['google_status'] != null) {
			if (typeof gtag != 'undefined') {
				gtag('event', 'add_to_cart', json['remarketing']['google_remarketing_event']);
			}
			
			if (json['remarketing']['google_ads_identifier_cart'] != '') { 
				if (typeof gtag != 'undefined') {
					gtag('event', 'conversion', json['remarketing']['google_ads_event']);
				}
			}
		}

		if (json['remarketing']['facebook_status'] != null && json['remarketing']['facebook_pixel_status'] != null) {
			if (typeof fbq != 'undefined') {
				fbq('track', 'AddToCart', json['remarketing']['facebook_pixel_event'], {eventID: json['remarketing']['event_id']}); 
			}
		}
		
		if (json['remarketing']['tiktok_status'] != null && json['remarketing']['tiktok_pixel_status'] != null) {
			if (typeof ttq != 'undefined') {
				ttq.track('AddToCart', json['remarketing']['tiktok_event'], {eventID: json['remarketing']['event_id']}); 
			}
		}

		if (json['remarketing']['snapchat_status'] != null && json['remarketing']['snapchat_pixel_status'] != null) {
			if (typeof snaptr != 'undefined') {
				snaptr('track', 'ADD_CART', json['remarketing']['snapchat_event']);
			}
		}
		
		if (json['remarketing']['ecommerce_status'] !== null) {
			window.dataLayer = window.dataLayer || [];
			dataLayer.push({ ecommerce: null });
			dataLayer.push(json['remarketing']['ga4_datalayer']);  
		}
		
		if (json['remarketing']['ecommerce_ga4_status'] != null) {
			if (typeof gtag != 'undefined') {
				json['remarketing']['ecommerce_ga4_event']['items'][0]['item_list_name'] = heading;
				gtag('event', 'add_to_cart', json['remarketing']['ecommerce_ga4_event']);
			}
		}
		
		if (json['remarketing']['esputnik_status'] != null) {
			if (typeof eS != 'undefined') {
				eS('sendEvent', 'StatusCart', json['remarketing']['esputnik_event']); 
			}
		}
		
		if (json['remarketing']['uet_status'] != null) {
			window.uetq = window.uetq || [];
			window.uetq.push('event', 'add_to_cart', json['remarketing']['uet_event']);
		}
		
		if (typeof events_cart_add != 'undefined') {
			events_cart_add();
		}
	}
}	  

function remarketingRemoveFromCart(json) {
	console.log ('%c%s', 'color: #a700ff', 'remove_from_cart_sent');
	heading = $('title').text() || 'other';

	if (json['remarketing']) {
		if (json['remarketing']['ecommerce_status'] != null) {
			window.dataLayer = window.dataLayer || [];
			dataLayer.push({ ecommerce: null });
			dataLayer.push(json['remarketing']['ga4_datalayer']);   
		}
		
		if (json['remarketing']['ecommerce_ga4_status'] != null) {
			if (typeof gtag != 'undefined') {
				json['remarketing']['ecommerce_ga4_event']['items'][0]['item_list_name'] = heading;
				gtag('event', 'remove_from_cart', json['remarketing']['ecommerce_ga4_event']);
			}
		}

		if (json['remarketing']['esputnik_status'] != null) {
			if (typeof eS != 'undefined') {
				eS('sendEvent', 'StatusCart', json['remarketing']['esputnik_event']); 
			}
		}
	}
}	

function remarketingRemoveFromSimpleCart(cart_product_id, quantity) {
	if (cart_product_id && quantity) {
		$.ajax({ 
        type: 'post',
        url:  'index.php?route=common/remarketing/removeProduct',
		data: {'product_id' : cart_product_id, 'quantity': quantity},
			dataType: 'json',
            success: function(json) { 
				remarketingRemoveFromCart(json);
			}
		});
	}
}

function sendGa4Impressions(data, search = false, measurement = false, ga4_send_to, ga4_currency) {
	console.log ('%c%s', 'color: #a700ff', 'ga4_impressions_sent');
	heading = $('title').text() || 'other';
	if (!search) {
		event_name = 'view_item_list';
	} else {
		event_name = 'view_search_results';
	}
	
	if (data && measurement == false) {
		if (typeof gtag != 'undefined') {
			gtag('event', event_name, {
				'send_to': ga4_send_to,
				'currency': ga4_currency,
				'items': data 
			});
		}
	}
	if (data && measurement == true) {
		$.ajax({ 
        type: 'post',
        url:  'index.php?route=common/remarketing/sendGa4MeasurementImpressions',
		data: {products: data, event_name: event_name, heading: heading},
			dataType: 'json',
            success: function(json) {
				console.log ('%c%s', 'color: #a700ff', 'details_ga4_measurement_sent');
			}
		});
	}
}	 

function sendGa4Details(data, measurement = false) {
	if (data && measurement == false) {
		if (typeof gtag != 'undefined') {
			gtag('event', 'view_item', data);
			if (typeof(localStorage.remarketing_product_id) !== 'undefined' && typeof(localStorage.remarketing_heading) !== 'undefined') {
				click_data = data;
				click_data.items[0].item_list_name = localStorage.remarketing_heading;
				gtag('event', 'select_item', click_data);  
				delete localStorage.remarketing_product_id;
				delete localStorage.remarketing_heading;  
			}
		}
		console.log ('%c%s', 'color: #a700ff', 'details_ga4_sent');
	}	
	if (data && measurement == true) {
		$.ajax({ 
        type: 'post',
        url:  'index.php?route=common/remarketing/sendGa4Details',
		data: {products : data},
			dataType: 'json',
            success: function(json) {
				console.log ('%c%s', 'color: #a700ff', 'details_ga4_measurement_sent');
			}
		});
	}
}	 

function sendGa4Cart(data) { 
	if (data) {
		$.ajax({ 
        type: 'post',
        url:  'index.php?route=common/remarketing/sendGa4Cart',
		data: {cart : data},
			dataType: 'json',
            success: function(json) {
				console.log ('%c%s', 'color: #a700ff', 'ecommerce_ga4_cart_sent');
			}
		});
	}
}	 

function sendFacebookDetails(data) {
	if (data) {
		$.ajax({ 
        type: 'post',
        url:  'index.php?route=common/remarketing/sendFacebookDetails',
		data: {products: data['products'], event_id: data['event_id'], time: data['time'], url: window.location.href},
			dataType: 'json',
            success: function(json) {
				console.log ('%c%s', 'color: #a700ff', 'details_facebook_sent');
			}
		});
	}
}	 

function sendTiktokDetails(data) {
	if (data) {
		$.ajax({ 
        type: 'post',
        url:  'index.php?route=common/remarketing/sendTiktokDetails',
		data: {properties: data['properties'], event_id: data['event_id'], url: window.location.href},
			dataType: 'json',
            success: function() {
				console.log ('%c%s', 'color: #a700ff', 'details_tiktok_sent'); 
			}
		});
	}
}	 

function sendFacebookCart(data) {
	if (data) {
		$.ajax({ 
        type: 'post',
        url:  'index.php?route=common/remarketing/sendFacebookCart',
		data: {cart : data, url : window.location.href},
			dataType: 'json',
            success: function(json) {
				console.log ('%c%s', 'color: #a700ff', 'facebook_cart_sent');
			}
		});
	}
}	 

function sendTiktokCart(data) {
	if (data) {
		$.ajax({ 
        type: 'post',
        url:  'index.php?route=common/remarketing/sendTiktokCart',
		data: {cart : data, url : window.location.href},
			dataType: 'json',
            success: function(json) {
				console.log ('%c%s', 'color: #a700ff', 'tiktok_cart_sent');
			}
		});
	}
}	 

function sendFacebookCategoryDetails(data, search_page) {
	if (data) {
		$.ajax({ 
        type: 'post',
        url:  'index.php?route=common/remarketing/sendFacebookCategory',
		data: {products: data['products'], event_id: data['event_id'], time: data['time'], url: window.location.href, search: search_page},
			dataType: 'json',
            success: function(json) {
				console.log ('%c%s', 'color: #a700ff', 'category_details_facebook_sent');
			}
		});
	}
}	 

function sendEsputnikDetails(data) {
	if (data) {
		$.ajax({ 
        type: 'post',
        url:  'index.php?route=common/remarketing/sendEsputnik',
		data: {product : data},
			dataType: 'json',
            success: function(json) {
				console.log ('%c%s', 'color: #a700ff', 'details_esputnik_sent');
			}
		});
	}
}

function sendEsputnikCategoryDetails(data) {
	if (data) {
		$.ajax({ 
        type: 'post',
        url:  'index.php?route=common/remarketing/sendEsputnikCategory',
		data: {category : data},
			dataType: 'json',
            success: function(json) {
				console.log ('%c%s', 'color: #a700ff', 'category_esputnik_sent');
			}
		});
	}
}

function sendGoogleRemarketing(data) {
	console.log ('%c%s', 'color: #a700ff', 'remarketing_event_sent');
	if (typeof gtag != 'undefined') {
		gtag('event', data['event'], data['data']);
	}
}	

function sendWishList(json) {
	console.log ('%c%s', 'color: #a700ff', 'wishlist_sent');
	
	heading = $('title').text() || 'other';
	
	if (json['remarketing']['facebook_status'] != null && json['remarketing']['facebook_pixel_status'] != null) {
		if (typeof fbq != 'undefined') {
			fbq('track', 'AddToWishlist', json['remarketing']['facebook_pixel_event'], {eventID: json['remarketing']['event_id']}); 
		}
	}
	
	if (json['remarketing']['tiktok_status'] != null && json['remarketing']['tiktok_pixel_status'] != null) {
		if (typeof ttq != 'undefined') { 
			ttq.track('AddToWishlist', json['remarketing']['tiktok_event'], {eventID: json['remarketing']['event_id']}); 
		}
	}
	
	if (json['remarketing']['snapchat_status'] != null && json['remarketing']['snapchat_pixel_status'] != null) {
		if (typeof snaptr != 'undefined') {
			snaptr('track', 'ADD_TO_WISHLIST', json['remarketing']['snapchat_event']);
		}
	}
	
	if (json['remarketing']['ecommerce_ga4_status'] != null) {
		if (typeof gtag != 'undefined') {
			json['remarketing']['ecommerce_ga4_event']['items'][0]['item_list_name'] = heading;
			gtag('event', 'add_to_wishlist', json['remarketing']['ecommerce_ga4_event']);
		}
	}
	
	if (json['remarketing']['ecommerce_status'] !== null) {
		window.dataLayer = window.dataLayer || [];
		dataLayer.push({ ecommerce: null });
		dataLayer.push(json['remarketing']['ga4_datalayer']);  
	} 
	
	if (json['remarketing']['esputnik_status'] != null) {
		if (typeof eS != 'undefined') {
			eS('sendEvent', 'AddToWishlist', json['remarketing']['esputnik_event']);
		}
	}
	
	if (typeof events_wishlist != 'undefined') {
		events_wishlist();
	}
}

function sendCompare(json) {
	console.log ('%c%s', 'color: #a700ff', 'compare_sent');
	
	heading = $('title').text() || 'other';
	
	if (json['remarketing']['facebook_status'] != null && json['remarketing']['facebook_pixel_status'] != null) {
		if (typeof fbq != 'undefined') {
			fbq('trackCustom', 'Compare', json['remarketing']['facebook_pixel_event'], {eventID: json['remarketing']['event_id']}); 
		}
	}
	
	if (json['remarketing']['ecommerce_ga4_status'] != null) {
		if (typeof gtag != 'undefined') {
			json['remarketing']['ecommerce_ga4_event']['items'][0]['item_list_name'] = heading;
			gtag('event', 'add_to_compare', json['remarketing']['ecommerce_ga4_event']);
		}
	}
	
	if (json['remarketing']['ecommerce_status'] !== null) {
		window.dataLayer = window.dataLayer || [];
		dataLayer.push({ ecommerce: null });
		dataLayer.push(json['remarketing']['ga4_datalayer']);  
	} 
}

function remarketingCallback(json) {
	console.log ('%c%s', 'color: #a700ff', 'callback_sent');
	
	if (json['remarketing']['facebook_status'] != null && json['remarketing']['facebook_pixel_status'] != null) {
		if (typeof fbq != 'undefined') {
			fbq('track', 'Contact'); 
		}
	}
	
	if (json['remarketing']['tiktok_status'] != null && json['remarketing']['tiktok_pixel_status'] != null) {
		if (typeof ttq != 'undefined') { 
			ttq.track('Contact'); 
		}
	}
	
	if (json['remarketing']['ecommerce_ga4_status'] != null) {
		if (typeof gtag != 'undefined') {
			gtag('event', 'callback', json['remarketing']['ecommerce_ga4_event']);
		}
	}
	
	if (json['remarketing']['ecommerce_status'] != null) {
		window.dataLayer = window.dataLayer || [];
		dataLayer.push({'event': 'ga4_callback'})
	}

} 

function remarketingFoundCheaper(json) {
	console.log ('%c%s', 'color: #a700ff', 'found_cheaper_sent');
	
	if (json['remarketing']['facebook_status'] != null && json['remarketing']['facebook_pixel_status'] != null) {
		if (typeof fbq != 'undefined') {
			fbq('track', 'Contact'); 
		}
	}
	
	if (json['remarketing']['tiktok_status'] != null && json['remarketing']['tiktok_pixel_status'] != null) {
		if (typeof ttq != 'undefined') { 
			ttq.track('Contact'); 
		}
	}
	
	if (json['remarketing']['ecommerce_ga4_status'] != null) {
		if (typeof gtag != 'undefined') {
			gtag('event', 'found_cheaper', json['remarketing']['ecommerce_ga4_event']);
		}
	}
	
	if (json['remarketing']['ecommerce_status'] != null) {
		window.dataLayer = window.dataLayer || [];
		dataLayer.push({'event': 'ga4_found_cheaper'})
	}
} 

function remarketingNewsletter(json) {
	if (json['success'] || (json['output'] && typeof(json['error']) === 'undefined')) {
		console.log ('%c%s', 'color: #a700ff', 'newsletter_sent');
		window.dataLayer = window.dataLayer || [];
		dataLayer.push({'event': 'ga4_newsletter'})
		if (typeof gtag != 'undefined') {
			gtag('event', 'newsletter');
		}
		if (typeof snaptr != 'undefined') {
			snaptr('track', 'SIGN_UP');
		}
	}
} 

function remarketingTelephoneClick() {
	console.log ('%c%s', 'color: #a700ff', 'telephone_click');
	window.dataLayer = window.dataLayer || [];
	dataLayer.push({'event': 'ga4_telephone_click'})
	if (typeof gtag != 'undefined') {
		gtag('event', 'telephone_click'); 
	}
	if (typeof fbq != 'undefined') {
		fbq('track', 'Contact'); 
	}
} 

function remarketingMailClick() {
	console.log ('%c%s', 'color: #a700ff', 'mail_click');
	window.dataLayer = window.dataLayer || [];
	dataLayer.push({'event': 'ga4_mail_click'})
	if (typeof gtag != 'undefined') {
		gtag('event', 'mail_click'); 
	}
	if (typeof fbq != 'undefined') {
		fbq('track', 'Contact'); 
	}
} 

function remarketingTgClick() {
	console.log ('%c%s', 'color: #a700ff', 'tg_click');
	window.dataLayer = window.dataLayer || [];
	dataLayer.push({'event': 'ga4_tg_click'})
	if (typeof gtag != 'undefined') {
		gtag('event', 'tg_click');  
	}
	if (typeof fbq != 'undefined') {
		fbq('track', 'Contact'); 
	}
} 
function remarketingQuickOrder(json) {
	console.log ('%c%s', 'color: #a700ff', 'quick_order_sent');
	
	if (json['remarketing']) {
		
		if (json['remarketing']['google_status'] != null) {
			if (typeof gtag != 'undefined') {
				gtag('set', 'user_data', json['remarketing']['ads_user_data']);
				gtag('event', 'purchase', json['remarketing']['ads_event']);
			}
		
			if (json['remarketing']['google_ads_quick_identifier'] != '') { 
				if (typeof gtag != 'undefined') {
					gtag('event', 'conversion', json['remarketing']['ads_conversion_event']);
				}
			}
		} 
		
		if (json['remarketing']['ecommerce_status'] != null && json['remarketing']['ecommerce_status']) {
			window.dataLayer = window.dataLayer || [];
			dataLayer.push({ ecommerce: null });
			dataLayer.push(json['remarketing']['ga4_datalayer']);
		}

		if (json['remarketing']['ecommerce_ga4_status'] != null && json['remarketing']['ecommerce_ga4_status']) {
			if (typeof gtag != 'undefined') {
				gtag('event', json['remarketing']['ga4_event_name'], json['remarketing']['ga4_event']);	
			}			
		}
		
		if (json['remarketing']['facebook_status'] != null && json['remarketing']['facebook_pixel_status'] != null) {
			if (typeof fbq != 'undefined') {
				fbq('track', 'Purchase', json['remarketing']['facebook_event'], {'eventID': json['remarketing']['fb_event_id']}); 
				if (json['remarketing']['facebook_lead'] != null) {
					fbq('track', 'Lead', json['remarketing']['facebook_lead_event'], {'eventID': json['remarketing']['fb_lead_event_id']}); 
				}
			}
		} 
		
		if (json['remarketing']['facebook_pixel_status'] != null && json['remarketing']['facebook_lead'] != null) {
			if (typeof fbq != 'undefined') {
				fbq('track', 'Lead', json['remarketing']['facebook_lead_event'], {'eventID': json['remarketing']['fb_lead_event_id']}); 
			}
		} 
		
		if (json['remarketing']['tiktok_status'] != null && json['remarketing']['tiktok_pixel_status'] != null) {
			if (typeof ttq != 'undefined') {
				ttq.track('CompletePayment', json['remarketing']['tt_event'], {'eventID': json['remarketing']['tt_event_id']}); 
			}
		}
		
		if (json['remarketing']['snapchat_status'] != null && json['remarketing']['snapchat_pixel_status'] != null) {
			if (typeof snaptr != 'undefined') {
				snaptr('track', 'PURCHASE', json['remarketing']['snapchat_event']); 
			}
		}

		if (json['remarketing']['reviews_status'] != null && json['remarketing']['reviews_status'] != false) {
			$.getScript('https://apis.google.com/js/platform.js?onload=renderOptIn');
			window.renderOptIn = function() {  
				window.gapi.load('surveyoptin', function() {
					window.gapi.surveyoptin.render(json['remarketing']['reviews_event']);
				})
			}
		}

		if (json['remarketing']['esputnik_status'] != null) {
			if (typeof eS != 'undefined') {
				eS('sendEvent', 'PurchasedItems', json['remarketing']['esputnik_event']); 
			}
		}
		
		if (json['remarketing']['uet_status'] != null) {
			window.uetq = window.uetq || [];
			window.uetq.push('event', 'purchase', json['remarketing']['uet_event']);
		}
		
		if (typeof quickPurchase != 'undefined') { 
			quickPurchase(json['remarketing']['order_id'], json['remarketing']['default_total']);
		}
		
	}
}
	
function decodePostParams(str) {
    return (str || document.location.search).replace(/(^\?)/,'').split("&").map(function(n){return n = n.split("="),this[n[0]] = n[1],this}.bind({}))[0];
}

$(document).ready(function() {
	console.log ('%c%s', 'color: #a700ff', 'sp remarketing 7.5.21513890285.51100 start');

	$.each($("[onclick*='cart.add'], [onclick*='get_revpopup_cart'], [onclick*='addToCart'], [onclick*='get_oct_popup_add_to_cart']"), function() {
		product_id = $(this).attr('onclick').match(/[0-9]+/);
		$(this).addClass('remarketing_cart_button').attr('data-product_id', product_id);
	});
	
	$(document).on('click', 'a[href^="tel:"]', function() {
		if (typeof remarketingTelephoneClick == 'function') {
			remarketingTelephoneClick();
		}	
	});
	
	$(document).on('click', 'a[href^="mailto"]', function() {
		if (typeof remarketingMailClick == 'function') {
			remarketingMailClick();
		}	
	});  
	
	$(document).on('click', 'a[href*="t.me"]', function() {
		if (typeof remarketingTgClick == 'function') {
			remarketingTgClick();
		}	
	});
	
	$(document).ajaxSuccess(function(event, xhr, settings) {
		
		cartRoutes = [
			'checkout/cart/add',
			'extension/module/technics/technicscart/fastadd2cart',
			'checkout/cart/add&oct_dirrect_add=1',
			'extension/module/frametheme/ft_cart/add',
			'extension/basel/basel_features/add_to_cart',
			'extension/soconfig/cart/add'
		];  
		
		if (cartRoutes.some(url => settings.url.includes(url))) {
			if (settings.type === 'POST' && xhr.responseJSON?.remarketing !== undefined) {
				if (typeof remarketingAddToCart === 'function') {
					remarketingAddToCart(xhr.responseJSON);
				}
			}
		}

		if (settings.url.indexOf('checkout/cart/remove') != -1 || settings.url.indexOf('status_cart') != -1 || settings.url.indexOf('statusCart') != -1 || settings.url.indexOf('extension/soconfig/cart/remove') != -1) {
			if (typeof xhr.responseJSON !== 'undefined' && typeof xhr.responseJSON['remarketing'] !== 'undefined') {
				if (typeof remarketingRemoveFromCart == 'function') {
					remarketingRemoveFromCart(xhr.responseJSON);
				}
			}
		}
		
		if (settings.url.indexOf('account/wishlist/add') != -1) {
			if (typeof xhr.responseJSON !== 'undefined' && typeof xhr.responseJSON['remarketing'] !== 'undefined') {
				if (typeof sendWishList == 'function') {
					sendWishList(xhr.responseJSON);
				}
			} 
		}
		
		if (settings.url.indexOf('product/compare/add') != -1) {
			if (typeof xhr.responseJSON !== 'undefined' && typeof xhr.responseJSON['remarketing'] !== 'undefined') {
				if (typeof sendCompare == 'function') {
					sendCompare(xhr.responseJSON);
				}
			} 
		}
		
		if (settings.url.indexOf('oct_popup_call_phone/send') != -1 || settings.url.indexOf('_callback') != -1) {
			if (typeof xhr.responseJSON !== 'undefined' && typeof xhr.responseJSON['remarketing'] !== 'undefined') {
				if (typeof remarketingCallback == 'function') {
					remarketingCallback(xhr.responseJSON);
				}
			} 
		} 
		
		if (settings.url.indexOf('footer/addToNewsletter') != -1 || settings.url.indexOf('oct_subscribe/makeSubscribe') != -1) {
			if (typeof xhr.responseJSON !== 'undefined') {
				if (typeof remarketingNewsletter == 'function') {
					remarketingNewsletter(xhr.responseJSON);
				}
			} 
		} 
		
		if (settings.url.indexOf('found_cheaper_product_confirm') != -1) {
			if (typeof xhr.responseJSON !== 'undefined' && typeof xhr.responseJSON['remarketing'] !== 'undefined') {
				if (typeof remarketingFoundCheaper == 'function') {
					remarketingFoundCheaper(xhr.responseJSON);
				}
			} 
		} 
		
		if (settings.url.indexOf('module/oct_popup_found_cheaper/send') != -1) {
			if (typeof xhr.responseJSON !== 'undefined' && typeof xhr.responseJSON['remarketing'] !== 'undefined') {
				if (typeof remarketingFoundCheaper == 'function') {
					remarketingFoundCheaper(xhr.responseJSON);
				}
			} 
		} 		
		
		if (settings.url.indexOf('oct_product_faq/write') != -1) {
			if (typeof xhr.responseJSON !== 'undefined' && xhr.responseJSON['success']) {
				window.dataLayer = window.dataLayer || [];
				dataLayer.push({'event': 'ga4_product_faq'})
				if (typeof gtag != 'undefined') {
					gtag('event', 'product_faq');
				}
			} 
		} 
		
		if (settings.url.indexOf('product/product/write') != -1) {
			if (typeof xhr.responseJSON !== 'undefined' && xhr.responseJSON['success']) {
				window.dataLayer = window.dataLayer || [];
				dataLayer.push({'event': 'ga4_product_review'})
				if (typeof gtag != 'undefined') {
					gtag('event', 'product_review');
				}
			} 
		} 
		
		if (settings.url.indexOf('oct_sreview_reviews/write') != -1) {
			if (typeof xhr.responseJSON !== 'undefined' && xhr.responseJSON['success']) {
				window.dataLayer = window.dataLayer || [];
				dataLayer.push({'event': 'ga4_store_review'})
				if (typeof gtag != 'undefined') {
					gtag('event', 'store_review');
				}
			} 
		} 
		
		quickOrderRoutes = [
			'extension/module/luxshop_newfastordercart',
			'extension/module/luxshop_newfastorder',
			'extension/module/cyber_newfastordercart',
			'extension/module/cyber_newfastorder',
			'extension/module/chameleon_newfastorder/addFastOrder',
			'extension/module/newfastorder',
			'extension/module/newfastordercart',
			'extension/module/upstore_newfastorder/addFastOrder',
			'extension/module/uni_quick_order/add'
		];  
		
		if (quickOrderRoutes.some(url => settings.url.includes(url))) {
			if (settings.type === 'POST' && xhr.responseJSON?.success !== undefined && xhr.responseJSON?.remarketing !== undefined) {
				if (typeof remarketingQuickOrder === 'function') {
					remarketingQuickOrder(xhr.responseJSON);
				}
			}
		}		
		
		if (settings.url.indexOf('checkout/simplecheckout&group=0') != -1) {
			simple_data = decodePostParams(decodeURI(settings.data));
			if (simple_data.remove !== 'undefined' && simple_data.remove !== '') {
				quantity_key = 'quantity[' + simple_data.remove + ']';
				quantity = simple_data[quantity_key]; 
				if (typeof cart_products[simple_data.remove] !== 'undefined') {
					cart_product_id = cart_products[simple_data.remove]['product_id'];
					if (typeof remarketingRemoveFromSimpleCart == 'function') {
						remarketingRemoveFromSimpleCart(cart_product_id, quantity);
					}
				}
			}
		}
		
		if (settings.url.indexOf('checkout/simplecheckout/prevent_delete') != -1) {
			if (typeof fbq != 'undefined' && typeof facebook_payment_data != 'undefined') {
				fbq('track', 'AddPaymentInfo', facebook_payment_data);
			}
			if (typeof ttq != 'undefined' && typeof tiktok_payment_data != 'undefined') {
				ttq('track', 'AddPaymentInfo', tiktok_payment_data);
			}
			if (typeof gtag != 'undefined' && typeof ga4_payment_data != 'undefined') {
				gtag('event', 'add_payment_info', ga4_payment_data);
			}
		}
	});
	/* 7.5.21513890285.51100 */
});
$(document).delegate("input[name='uniqueid']","keyup",function(){var e=$(this).val();$(".salesagentalert").remove(),$.ajax({url:"index.php?route=extension/module/salesagent/agentcode&uniqueid="+encodeURIComponent(e),dataType:"json",success:function(e){$(".salesagentalert").remove(),e.firstname&&$("input[name='uniqueid']").after('<div class="alert alert-success salesagentalert">Successfully connected to '+e.firstname+" "+e.lastname+"<div>")}})}),$(document).delegate("select[name='salesagent_id']","change",function(){$.ajax({url:"index.php?route=extension/module/salesagent/save",type:"post",data:$("select[name='salesagent_id']"),dataType:"json",success:function(e){console.log(e)}})});
