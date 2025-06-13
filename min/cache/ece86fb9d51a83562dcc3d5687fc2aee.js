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
!function(i){"use strict";"function"==typeof define&&define.amd?define(["jquery"],i):"undefined"!=typeof exports?module.exports=i(require("jquery")):i(jQuery)}(function(i){"use strict";var e=window.Slick||{};(e=function(){var e=0;return function(t,o){var s,n=this;n.defaults={accessibility:!0,adaptiveHeight:!1,appendArrows:i(t),appendDots:i(t),arrows:!0,asNavFor:null,prevArrow:'<button class="slick-prev" aria-label="Previous" type="button">Previous</button>',nextArrow:'<button class="slick-next" aria-label="Next" type="button">Next</button>',autoplay:!1,autoplaySpeed:3e3,centerMode:!1,centerPadding:"50px",cssEase:"ease",customPaging:function(e,t){return i('<button type="button" />').text(t+1)},dots:!1,dotsClass:"slick-dots",draggable:!0,easing:"linear",edgeFriction:.35,fade:!1,focusOnSelect:!1,focusOnChange:!1,infinite:!0,initialSlide:0,lazyLoad:"ondemand",mobileFirst:!1,pauseOnHover:!0,pauseOnFocus:!0,pauseOnDotsHover:!1,respondTo:"window",responsive:null,rows:1,rtl:!1,slide:"",slidesPerRow:1,slidesToShow:1,slidesToScroll:1,speed:500,swipe:!0,swipeToSlide:!1,touchMove:!0,touchThreshold:5,useCSS:!0,useTransform:!0,variableWidth:!1,vertical:!1,verticalSwiping:!1,waitForAnimate:!0,zIndex:1e3},n.initials={animating:!1,dragging:!1,autoPlayTimer:null,currentDirection:0,currentLeft:null,currentSlide:0,direction:1,$dots:null,listWidth:null,listHeight:null,loadIndex:0,$nextArrow:null,$prevArrow:null,scrolling:!1,slideCount:null,slideWidth:null,$slideTrack:null,$slides:null,sliding:!1,slideOffset:0,swipeLeft:null,swiping:!1,$list:null,touchObject:{},transformsEnabled:!1,unslicked:!1},i.extend(n,n.initials),n.activeBreakpoint=null,n.animType=null,n.animProp=null,n.breakpoints=[],n.breakpointSettings=[],n.cssTransitions=!1,n.focussed=!1,n.interrupted=!1,n.hidden="hidden",n.paused=!0,n.positionProp=null,n.respondTo=null,n.rowCount=1,n.shouldClick=!0,n.$slider=i(t),n.$slidesCache=null,n.transformType=null,n.transitionType=null,n.visibilityChange="visibilitychange",n.windowWidth=0,n.windowTimer=null,s=i(t).data("slick")||{},n.options=i.extend({},n.defaults,o,s),n.currentSlide=n.options.initialSlide,n.originalSettings=n.options,void 0!==document.mozHidden?(n.hidden="mozHidden",n.visibilityChange="mozvisibilitychange"):void 0!==document.webkitHidden&&(n.hidden="webkitHidden",n.visibilityChange="webkitvisibilitychange"),n.autoPlay=i.proxy(n.autoPlay,n),n.autoPlayClear=i.proxy(n.autoPlayClear,n),n.autoPlayIterator=i.proxy(n.autoPlayIterator,n),n.changeSlide=i.proxy(n.changeSlide,n),n.clickHandler=i.proxy(n.clickHandler,n),n.selectHandler=i.proxy(n.selectHandler,n),n.setPosition=i.proxy(n.setPosition,n),n.swipeHandler=i.proxy(n.swipeHandler,n),n.dragHandler=i.proxy(n.dragHandler,n),n.keyHandler=i.proxy(n.keyHandler,n),n.instanceUid=e++,n.htmlExpr=/^(?:\s*(<[\w\W]+>)[^>]*)$/,n.registerBreakpoints(),n.init(!0)}}()).prototype.activateADA=function(){this.$slideTrack.find(".slick-active").attr({"aria-hidden":"false"}).find("a, input, button, select").attr({tabindex:"0"})},e.prototype.addSlide=e.prototype.slickAdd=function(e,t,o){var s=this;if("boolean"==typeof t)o=t,t=null;else if(t<0||t>=s.slideCount)return!1;s.unload(),"number"==typeof t?0===t&&0===s.$slides.length?i(e).appendTo(s.$slideTrack):o?i(e).insertBefore(s.$slides.eq(t)):i(e).insertAfter(s.$slides.eq(t)):!0===o?i(e).prependTo(s.$slideTrack):i(e).appendTo(s.$slideTrack),s.$slides=s.$slideTrack.children(this.options.slide),s.$slideTrack.children(this.options.slide).detach(),s.$slideTrack.append(s.$slides),s.$slides.each(function(e,t){i(t).attr("data-slick-index",e)}),s.$slidesCache=s.$slides,s.reinit()},e.prototype.animateHeight=function(){var i=this;if(1===i.options.slidesToShow&&!0===i.options.adaptiveHeight&&!1===i.options.vertical){var e=i.$slides.eq(i.currentSlide).outerHeight(!0);i.$list.animate({height:e},i.options.speed)}},e.prototype.animateSlide=function(e,t){var o={},s=this;s.animateHeight(),!0===s.options.rtl&&!1===s.options.vertical&&(e=-e),!1===s.transformsEnabled?!1===s.options.vertical?s.$slideTrack.animate({left:e},s.options.speed,s.options.easing,t):s.$slideTrack.animate({top:e},s.options.speed,s.options.easing,t):!1===s.cssTransitions?(!0===s.options.rtl&&(s.currentLeft=-s.currentLeft),i({animStart:s.currentLeft}).animate({animStart:e},{duration:s.options.speed,easing:s.options.easing,step:function(i){i=Math.ceil(i),!1===s.options.vertical?(o[s.animType]="translate("+i+"px, 0px)",s.$slideTrack.css(o)):(o[s.animType]="translate(0px,"+i+"px)",s.$slideTrack.css(o))},complete:function(){t&&t.call()}})):(s.applyTransition(),e=Math.ceil(e),!1===s.options.vertical?o[s.animType]="translate3d("+e+"px, 0px, 0px)":o[s.animType]="translate3d(0px,"+e+"px, 0px)",s.$slideTrack.css(o),t&&setTimeout(function(){s.disableTransition(),t.call()},s.options.speed))},e.prototype.getNavTarget=function(){var e=this,t=e.options.asNavFor;return t&&null!==t&&(t=i(t).not(e.$slider)),t},e.prototype.asNavFor=function(e){var t=this.getNavTarget();null!==t&&"object"==typeof t&&t.each(function(){var t=i(this).slick("getSlick");t.unslicked||t.slideHandler(e,!0)})},e.prototype.applyTransition=function(i){var e=this,t={};!1===e.options.fade?t[e.transitionType]=e.transformType+" "+e.options.speed+"ms "+e.options.cssEase:t[e.transitionType]="opacity "+e.options.speed+"ms "+e.options.cssEase,!1===e.options.fade?e.$slideTrack.css(t):e.$slides.eq(i).css(t)},e.prototype.autoPlay=function(){var i=this;i.autoPlayClear(),i.slideCount>i.options.slidesToShow&&(i.autoPlayTimer=setInterval(i.autoPlayIterator,i.options.autoplaySpeed))},e.prototype.autoPlayClear=function(){var i=this;i.autoPlayTimer&&clearInterval(i.autoPlayTimer)},e.prototype.autoPlayIterator=function(){var i=this,e=i.currentSlide+i.options.slidesToScroll;i.paused||i.interrupted||i.focussed||(!1===i.options.infinite&&(1===i.direction&&i.currentSlide+1===i.slideCount-1?i.direction=0:0===i.direction&&(e=i.currentSlide-i.options.slidesToScroll,i.currentSlide-1==0&&(i.direction=1))),i.slideHandler(e))},e.prototype.buildArrows=function(){var e=this;!0===e.options.arrows&&(e.$prevArrow=i(e.options.prevArrow).addClass("slick-arrow"),e.$nextArrow=i(e.options.nextArrow).addClass("slick-arrow"),e.slideCount>e.options.slidesToShow?(e.$prevArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"),e.$nextArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"),e.htmlExpr.test(e.options.prevArrow)&&e.$prevArrow.prependTo(e.options.appendArrows),e.htmlExpr.test(e.options.nextArrow)&&e.$nextArrow.appendTo(e.options.appendArrows),!0!==e.options.infinite&&e.$prevArrow.addClass("slick-disabled").attr("aria-disabled","true")):e.$prevArrow.add(e.$nextArrow).addClass("slick-hidden").attr({"aria-disabled":"true",tabindex:"-1"}))},e.prototype.buildDots=function(){var e,t,o=this;if(!0===o.options.dots){for(o.$slider.addClass("slick-dotted"),t=i("<ul />").addClass(o.options.dotsClass),e=0;e<=o.getDotCount();e+=1)t.append(i("<li />").append(o.options.customPaging.call(this,o,e)));o.$dots=t.appendTo(o.options.appendDots),o.$dots.find("li").first().addClass("slick-active")}},e.prototype.buildOut=function(){var e=this;e.$slides=e.$slider.children(e.options.slide+":not(.slick-cloned)").addClass("slick-slide"),e.slideCount=e.$slides.length,e.$slides.each(function(e,t){i(t).attr("data-slick-index",e).data("originalStyling",i(t).attr("style")||"")}),e.$slider.addClass("slick-slider"),e.$slideTrack=0===e.slideCount?i('<div class="slick-track"/>').appendTo(e.$slider):e.$slides.wrapAll('<div class="slick-track"/>').parent(),e.$list=e.$slideTrack.wrap('<div class="slick-list"/>').parent(),e.$slideTrack.css("opacity",0),!0!==e.options.centerMode&&!0!==e.options.swipeToSlide||(e.options.slidesToScroll=1),i("img[data-lazy]",e.$slider).not("[src]").addClass("slick-loading"),e.setupInfinite(),e.buildArrows(),e.buildDots(),e.updateDots(),e.setSlideClasses("number"==typeof e.currentSlide?e.currentSlide:0),!0===e.options.draggable&&e.$list.addClass("draggable")},e.prototype.buildRows=function(){var i,e,t,o,s,n,r,l=this;if(o=document.createDocumentFragment(),n=l.$slider.children(),l.options.rows>1){for(r=l.options.slidesPerRow*l.options.rows,s=Math.ceil(n.length/r),i=0;i<s;i++){var d=document.createElement("div");for(e=0;e<l.options.rows;e++){var a=document.createElement("div");for(t=0;t<l.options.slidesPerRow;t++){var c=i*r+(e*l.options.slidesPerRow+t);n.get(c)&&a.appendChild(n.get(c))}d.appendChild(a)}o.appendChild(d)}l.$slider.empty().append(o),l.$slider.children().children().children().css({width:100/l.options.slidesPerRow+"%",display:"inline-block"})}},e.prototype.checkResponsive=function(e,t){var o,s,n,r=this,l=!1,d=r.$slider.width(),a=window.innerWidth||i(window).width();if("window"===r.respondTo?n=a:"slider"===r.respondTo?n=d:"min"===r.respondTo&&(n=Math.min(a,d)),r.options.responsive&&r.options.responsive.length&&null!==r.options.responsive){s=null;for(o in r.breakpoints)r.breakpoints.hasOwnProperty(o)&&(!1===r.originalSettings.mobileFirst?n<r.breakpoints[o]&&(s=r.breakpoints[o]):n>r.breakpoints[o]&&(s=r.breakpoints[o]));null!==s?null!==r.activeBreakpoint?(s!==r.activeBreakpoint||t)&&(r.activeBreakpoint=s,"unslick"===r.breakpointSettings[s]?r.unslick(s):(r.options=i.extend({},r.originalSettings,r.breakpointSettings[s]),!0===e&&(r.currentSlide=r.options.initialSlide),r.refresh(e)),l=s):(r.activeBreakpoint=s,"unslick"===r.breakpointSettings[s]?r.unslick(s):(r.options=i.extend({},r.originalSettings,r.breakpointSettings[s]),!0===e&&(r.currentSlide=r.options.initialSlide),r.refresh(e)),l=s):null!==r.activeBreakpoint&&(r.activeBreakpoint=null,r.options=r.originalSettings,!0===e&&(r.currentSlide=r.options.initialSlide),r.refresh(e),l=s),e||!1===l||r.$slider.trigger("breakpoint",[r,l])}},e.prototype.changeSlide=function(e,t){var o,s,n,r=this,l=i(e.currentTarget);switch(l.is("a")&&e.preventDefault(),l.is("li")||(l=l.closest("li")),n=r.slideCount%r.options.slidesToScroll!=0,o=n?0:(r.slideCount-r.currentSlide)%r.options.slidesToScroll,e.data.message){case"previous":s=0===o?r.options.slidesToScroll:r.options.slidesToShow-o,r.slideCount>r.options.slidesToShow&&r.slideHandler(r.currentSlide-s,!1,t);break;case"next":s=0===o?r.options.slidesToScroll:o,r.slideCount>r.options.slidesToShow&&r.slideHandler(r.currentSlide+s,!1,t);break;case"index":var d=0===e.data.index?0:e.data.index||l.index()*r.options.slidesToScroll;r.slideHandler(r.checkNavigable(d),!1,t),l.children().trigger("focus");break;default:return}},e.prototype.checkNavigable=function(i){var e,t;if(e=this.getNavigableIndexes(),t=0,i>e[e.length-1])i=e[e.length-1];else for(var o in e){if(i<e[o]){i=t;break}t=e[o]}return i},e.prototype.cleanUpEvents=function(){var e=this;e.options.dots&&null!==e.$dots&&(i("li",e.$dots).off("click.slick",e.changeSlide).off("mouseenter.slick",i.proxy(e.interrupt,e,!0)).off("mouseleave.slick",i.proxy(e.interrupt,e,!1)),!0===e.options.accessibility&&e.$dots.off("keydown.slick",e.keyHandler)),e.$slider.off("focus.slick blur.slick"),!0===e.options.arrows&&e.slideCount>e.options.slidesToShow&&(e.$prevArrow&&e.$prevArrow.off("click.slick",e.changeSlide),e.$nextArrow&&e.$nextArrow.off("click.slick",e.changeSlide),!0===e.options.accessibility&&(e.$prevArrow&&e.$prevArrow.off("keydown.slick",e.keyHandler),e.$nextArrow&&e.$nextArrow.off("keydown.slick",e.keyHandler))),e.$list.off("touchstart.slick mousedown.slick",e.swipeHandler),e.$list.off("touchmove.slick mousemove.slick",e.swipeHandler),e.$list.off("touchend.slick mouseup.slick",e.swipeHandler),e.$list.off("touchcancel.slick mouseleave.slick",e.swipeHandler),e.$list.off("click.slick",e.clickHandler),i(document).off(e.visibilityChange,e.visibility),e.cleanUpSlideEvents(),!0===e.options.accessibility&&e.$list.off("keydown.slick",e.keyHandler),!0===e.options.focusOnSelect&&i(e.$slideTrack).children().off("click.slick",e.selectHandler),i(window).off("orientationchange.slick.slick-"+e.instanceUid,e.orientationChange),i(window).off("resize.slick.slick-"+e.instanceUid,e.resize),i("[draggable!=true]",e.$slideTrack).off("dragstart",e.preventDefault),i(window).off("load.slick.slick-"+e.instanceUid,e.setPosition)},e.prototype.cleanUpSlideEvents=function(){var e=this;e.$list.off("mouseenter.slick",i.proxy(e.interrupt,e,!0)),e.$list.off("mouseleave.slick",i.proxy(e.interrupt,e,!1))},e.prototype.cleanUpRows=function(){var i,e=this;e.options.rows>1&&((i=e.$slides.children().children()).removeAttr("style"),e.$slider.empty().append(i))},e.prototype.clickHandler=function(i){!1===this.shouldClick&&(i.stopImmediatePropagation(),i.stopPropagation(),i.preventDefault())},e.prototype.destroy=function(e){var t=this;t.autoPlayClear(),t.touchObject={},t.cleanUpEvents(),i(".slick-cloned",t.$slider).detach(),t.$dots&&t.$dots.remove(),t.$prevArrow&&t.$prevArrow.length&&(t.$prevArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display",""),t.htmlExpr.test(t.options.prevArrow)&&t.$prevArrow.remove()),t.$nextArrow&&t.$nextArrow.length&&(t.$nextArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display",""),t.htmlExpr.test(t.options.nextArrow)&&t.$nextArrow.remove()),t.$slides&&(t.$slides.removeClass("slick-slide slick-active slick-center slick-visible slick-current").removeAttr("aria-hidden").removeAttr("data-slick-index").each(function(){i(this).attr("style",i(this).data("originalStyling"))}),t.$slideTrack.children(this.options.slide).detach(),t.$slideTrack.detach(),t.$list.detach(),t.$slider.append(t.$slides)),t.cleanUpRows(),t.$slider.removeClass("slick-slider"),t.$slider.removeClass("slick-initialized"),t.$slider.removeClass("slick-dotted"),t.unslicked=!0,e||t.$slider.trigger("destroy",[t])},e.prototype.disableTransition=function(i){var e=this,t={};t[e.transitionType]="",!1===e.options.fade?e.$slideTrack.css(t):e.$slides.eq(i).css(t)},e.prototype.fadeSlide=function(i,e){var t=this;!1===t.cssTransitions?(t.$slides.eq(i).css({zIndex:t.options.zIndex}),t.$slides.eq(i).animate({opacity:1},t.options.speed,t.options.easing,e)):(t.applyTransition(i),t.$slides.eq(i).css({opacity:1,zIndex:t.options.zIndex}),e&&setTimeout(function(){t.disableTransition(i),e.call()},t.options.speed))},e.prototype.fadeSlideOut=function(i){var e=this;!1===e.cssTransitions?e.$slides.eq(i).animate({opacity:0,zIndex:e.options.zIndex-2},e.options.speed,e.options.easing):(e.applyTransition(i),e.$slides.eq(i).css({opacity:0,zIndex:e.options.zIndex-2}))},e.prototype.filterSlides=e.prototype.slickFilter=function(i){var e=this;null!==i&&(e.$slidesCache=e.$slides,e.unload(),e.$slideTrack.children(this.options.slide).detach(),e.$slidesCache.filter(i).appendTo(e.$slideTrack),e.reinit())},e.prototype.focusHandler=function(){var e=this;e.$slider.off("focus.slick blur.slick").on("focus.slick blur.slick","*",function(t){t.stopImmediatePropagation();var o=i(this);setTimeout(function(){e.options.pauseOnFocus&&(e.focussed=o.is(":focus"),e.autoPlay())},0)})},e.prototype.getCurrent=e.prototype.slickCurrentSlide=function(){return this.currentSlide},e.prototype.getDotCount=function(){var i=this,e=0,t=0,o=0;if(!0===i.options.infinite)if(i.slideCount<=i.options.slidesToShow)++o;else for(;e<i.slideCount;)++o,e=t+i.options.slidesToScroll,t+=i.options.slidesToScroll<=i.options.slidesToShow?i.options.slidesToScroll:i.options.slidesToShow;else if(!0===i.options.centerMode)o=i.slideCount;else if(i.options.asNavFor)for(;e<i.slideCount;)++o,e=t+i.options.slidesToScroll,t+=i.options.slidesToScroll<=i.options.slidesToShow?i.options.slidesToScroll:i.options.slidesToShow;else o=1+Math.ceil((i.slideCount-i.options.slidesToShow)/i.options.slidesToScroll);return o-1},e.prototype.getLeft=function(i){var e,t,o,s,n=this,r=0;return n.slideOffset=0,t=n.$slides.first().outerHeight(!0),!0===n.options.infinite?(n.slideCount>n.options.slidesToShow&&(n.slideOffset=n.slideWidth*n.options.slidesToShow*-1,s=-1,!0===n.options.vertical&&!0===n.options.centerMode&&(2===n.options.slidesToShow?s=-1.5:1===n.options.slidesToShow&&(s=-2)),r=t*n.options.slidesToShow*s),n.slideCount%n.options.slidesToScroll!=0&&i+n.options.slidesToScroll>n.slideCount&&n.slideCount>n.options.slidesToShow&&(i>n.slideCount?(n.slideOffset=(n.options.slidesToShow-(i-n.slideCount))*n.slideWidth*-1,r=(n.options.slidesToShow-(i-n.slideCount))*t*-1):(n.slideOffset=n.slideCount%n.options.slidesToScroll*n.slideWidth*-1,r=n.slideCount%n.options.slidesToScroll*t*-1))):i+n.options.slidesToShow>n.slideCount&&(n.slideOffset=(i+n.options.slidesToShow-n.slideCount)*n.slideWidth,r=(i+n.options.slidesToShow-n.slideCount)*t),n.slideCount<=n.options.slidesToShow&&(n.slideOffset=0,r=0),!0===n.options.centerMode&&n.slideCount<=n.options.slidesToShow?n.slideOffset=n.slideWidth*Math.floor(n.options.slidesToShow)/2-n.slideWidth*n.slideCount/2:!0===n.options.centerMode&&!0===n.options.infinite?n.slideOffset+=n.slideWidth*Math.floor(n.options.slidesToShow/2)-n.slideWidth:!0===n.options.centerMode&&(n.slideOffset=0,n.slideOffset+=n.slideWidth*Math.floor(n.options.slidesToShow/2)),e=!1===n.options.vertical?i*n.slideWidth*-1+n.slideOffset:i*t*-1+r,!0===n.options.variableWidth&&(o=n.slideCount<=n.options.slidesToShow||!1===n.options.infinite?n.$slideTrack.children(".slick-slide").eq(i):n.$slideTrack.children(".slick-slide").eq(i+n.options.slidesToShow),e=!0===n.options.rtl?o[0]?-1*(n.$slideTrack.width()-o[0].offsetLeft-o.width()):0:o[0]?-1*o[0].offsetLeft:0,!0===n.options.centerMode&&(o=n.slideCount<=n.options.slidesToShow||!1===n.options.infinite?n.$slideTrack.children(".slick-slide").eq(i):n.$slideTrack.children(".slick-slide").eq(i+n.options.slidesToShow+1),e=!0===n.options.rtl?o[0]?-1*(n.$slideTrack.width()-o[0].offsetLeft-o.width()):0:o[0]?-1*o[0].offsetLeft:0,e+=(n.$list.width()-o.outerWidth())/2)),e},e.prototype.getOption=e.prototype.slickGetOption=function(i){return this.options[i]},e.prototype.getNavigableIndexes=function(){var i,e=this,t=0,o=0,s=[];for(!1===e.options.infinite?i=e.slideCount:(t=-1*e.options.slidesToScroll,o=-1*e.options.slidesToScroll,i=2*e.slideCount);t<i;)s.push(t),t=o+e.options.slidesToScroll,o+=e.options.slidesToScroll<=e.options.slidesToShow?e.options.slidesToScroll:e.options.slidesToShow;return s},e.prototype.getSlick=function(){return this},e.prototype.getSlideCount=function(){var e,t,o=this;return t=!0===o.options.centerMode?o.slideWidth*Math.floor(o.options.slidesToShow/2):0,!0===o.options.swipeToSlide?(o.$slideTrack.find(".slick-slide").each(function(s,n){if(n.offsetLeft-t+i(n).outerWidth()/2>-1*o.swipeLeft)return e=n,!1}),Math.abs(i(e).attr("data-slick-index")-o.currentSlide)||1):o.options.slidesToScroll},e.prototype.goTo=e.prototype.slickGoTo=function(i,e){this.changeSlide({data:{message:"index",index:parseInt(i)}},e)},e.prototype.init=function(e){var t=this;i(t.$slider).hasClass("slick-initialized")||(i(t.$slider).addClass("slick-initialized"),t.buildRows(),t.buildOut(),t.setProps(),t.startLoad(),t.loadSlider(),t.initializeEvents(),t.updateArrows(),t.updateDots(),t.checkResponsive(!0),t.focusHandler()),e&&t.$slider.trigger("init",[t]),!0===t.options.accessibility&&t.initADA(),t.options.autoplay&&(t.paused=!1,t.autoPlay())},e.prototype.initADA=function(){var e=this,t=Math.ceil(e.slideCount/e.options.slidesToShow),o=e.getNavigableIndexes().filter(function(i){return i>=0&&i<e.slideCount});e.$slides.add(e.$slideTrack.find(".slick-cloned")).attr({"aria-hidden":"true",tabindex:"-1"}).find("a, input, button, select").attr({tabindex:"-1"}),null!==e.$dots&&(e.$slides.not(e.$slideTrack.find(".slick-cloned")).each(function(t){var s=o.indexOf(t);i(this).attr({role:"tabpanel",id:"slick-slide"+e.instanceUid+t,tabindex:-1}),-1!==s&&i(this).attr({"aria-describedby":"slick-slide-control"+e.instanceUid+s})}),e.$dots.attr("role","tablist").find("li").each(function(s){var n=o[s];i(this).attr({role:"presentation"}),i(this).find("button").first().attr({role:"tab",id:"slick-slide-control"+e.instanceUid+s,"aria-controls":"slick-slide"+e.instanceUid+n,"aria-label":s+1+" of "+t,"aria-selected":null,tabindex:"-1"})}).eq(e.currentSlide).find("button").attr({"aria-selected":"true",tabindex:"0"}).end());for(var s=e.currentSlide,n=s+e.options.slidesToShow;s<n;s++)e.$slides.eq(s).attr("tabindex",0);e.activateADA()},e.prototype.initArrowEvents=function(){var i=this;!0===i.options.arrows&&i.slideCount>i.options.slidesToShow&&(i.$prevArrow.off("click.slick").on("click.slick",{message:"previous"},i.changeSlide),i.$nextArrow.off("click.slick").on("click.slick",{message:"next"},i.changeSlide),!0===i.options.accessibility&&(i.$prevArrow.on("keydown.slick",i.keyHandler),i.$nextArrow.on("keydown.slick",i.keyHandler)))},e.prototype.initDotEvents=function(){var e=this;!0===e.options.dots&&(i("li",e.$dots).on("click.slick",{message:"index"},e.changeSlide),!0===e.options.accessibility&&e.$dots.on("keydown.slick",e.keyHandler)),!0===e.options.dots&&!0===e.options.pauseOnDotsHover&&i("li",e.$dots).on("mouseenter.slick",i.proxy(e.interrupt,e,!0)).on("mouseleave.slick",i.proxy(e.interrupt,e,!1))},e.prototype.initSlideEvents=function(){var e=this;e.options.pauseOnHover&&(e.$list.on("mouseenter.slick",i.proxy(e.interrupt,e,!0)),e.$list.on("mouseleave.slick",i.proxy(e.interrupt,e,!1)))},e.prototype.initializeEvents=function(){var e=this;e.initArrowEvents(),e.initDotEvents(),e.initSlideEvents(),e.$list.on("touchstart.slick mousedown.slick",{action:"start"},e.swipeHandler),e.$list.on("touchmove.slick mousemove.slick",{action:"move"},e.swipeHandler),e.$list.on("touchend.slick mouseup.slick",{action:"end"},e.swipeHandler),e.$list.on("touchcancel.slick mouseleave.slick",{action:"end"},e.swipeHandler),e.$list.on("click.slick",e.clickHandler),i(document).on(e.visibilityChange,i.proxy(e.visibility,e)),!0===e.options.accessibility&&e.$list.on("keydown.slick",e.keyHandler),!0===e.options.focusOnSelect&&i(e.$slideTrack).children().on("click.slick",e.selectHandler),i(window).on("orientationchange.slick.slick-"+e.instanceUid,i.proxy(e.orientationChange,e)),i(window).on("resize.slick.slick-"+e.instanceUid,i.proxy(e.resize,e)),i("[draggable!=true]",e.$slideTrack).on("dragstart",e.preventDefault),i(window).on("load.slick.slick-"+e.instanceUid,e.setPosition),i(e.setPosition)},e.prototype.initUI=function(){var i=this;!0===i.options.arrows&&i.slideCount>i.options.slidesToShow&&(i.$prevArrow.show(),i.$nextArrow.show()),!0===i.options.dots&&i.slideCount>i.options.slidesToShow&&i.$dots.show()},e.prototype.keyHandler=function(i){var e=this;i.target.tagName.match("TEXTAREA|INPUT|SELECT")||(37===i.keyCode&&!0===e.options.accessibility?e.changeSlide({data:{message:!0===e.options.rtl?"next":"previous"}}):39===i.keyCode&&!0===e.options.accessibility&&e.changeSlide({data:{message:!0===e.options.rtl?"previous":"next"}}))},e.prototype.lazyLoad=function(){function e(e){i("img[data-lazy]",e).each(function(){var e=i(this),t=i(this).attr("data-lazy"),o=i(this).attr("data-srcset"),s=i(this).attr("data-sizes")||n.$slider.attr("data-sizes"),r=document.createElement("img");r.onload=function(){e.animate({opacity:0},100,function(){o&&(e.attr("srcset",o),s&&e.attr("sizes",s)),e.attr("src",t).animate({opacity:1},200,function(){e.removeAttr("data-lazy data-srcset data-sizes").removeClass("slick-loading")}),n.$slider.trigger("lazyLoaded",[n,e,t])})},r.onerror=function(){e.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"),n.$slider.trigger("lazyLoadError",[n,e,t])},r.src=t})}var t,o,s,n=this;if(!0===n.options.centerMode?!0===n.options.infinite?s=(o=n.currentSlide+(n.options.slidesToShow/2+1))+n.options.slidesToShow+2:(o=Math.max(0,n.currentSlide-(n.options.slidesToShow/2+1)),s=n.options.slidesToShow/2+1+2+n.currentSlide):(o=n.options.infinite?n.options.slidesToShow+n.currentSlide:n.currentSlide,s=Math.ceil(o+n.options.slidesToShow),!0===n.options.fade&&(o>0&&o--,s<=n.slideCount&&s++)),t=n.$slider.find(".slick-slide").slice(o,s),"anticipated"===n.options.lazyLoad)for(var r=o-1,l=s,d=n.$slider.find(".slick-slide"),a=0;a<n.options.slidesToScroll;a++)r<0&&(r=n.slideCount-1),t=(t=t.add(d.eq(r))).add(d.eq(l)),r--,l++;e(t),n.slideCount<=n.options.slidesToShow?e(n.$slider.find(".slick-slide")):n.currentSlide>=n.slideCount-n.options.slidesToShow?e(n.$slider.find(".slick-cloned").slice(0,n.options.slidesToShow)):0===n.currentSlide&&e(n.$slider.find(".slick-cloned").slice(-1*n.options.slidesToShow))},e.prototype.loadSlider=function(){var i=this;i.setPosition(),i.$slideTrack.css({opacity:1}),i.$slider.removeClass("slick-loading"),i.initUI(),"progressive"===i.options.lazyLoad&&i.progressiveLazyLoad()},e.prototype.next=e.prototype.slickNext=function(){this.changeSlide({data:{message:"next"}})},e.prototype.orientationChange=function(){var i=this;i.checkResponsive(),i.setPosition()},e.prototype.pause=e.prototype.slickPause=function(){var i=this;i.autoPlayClear(),i.paused=!0},e.prototype.play=e.prototype.slickPlay=function(){var i=this;i.autoPlay(),i.options.autoplay=!0,i.paused=!1,i.focussed=!1,i.interrupted=!1},e.prototype.postSlide=function(e){var t=this;t.unslicked||(t.$slider.trigger("afterChange",[t,e]),t.animating=!1,t.slideCount>t.options.slidesToShow&&t.setPosition(),t.swipeLeft=null,t.options.autoplay&&t.autoPlay(),!0===t.options.accessibility&&(t.initADA(),t.options.focusOnChange&&i(t.$slides.get(t.currentSlide)).attr("tabindex",0).focus()))},e.prototype.prev=e.prototype.slickPrev=function(){this.changeSlide({data:{message:"previous"}})},e.prototype.preventDefault=function(i){i.preventDefault()},e.prototype.progressiveLazyLoad=function(e){e=e||1;var t,o,s,n,r,l=this,d=i("img[data-lazy]",l.$slider);d.length?(t=d.first(),o=t.attr("data-lazy"),s=t.attr("data-srcset"),n=t.attr("data-sizes")||l.$slider.attr("data-sizes"),(r=document.createElement("img")).onload=function(){s&&(t.attr("srcset",s),n&&t.attr("sizes",n)),t.attr("src",o).removeAttr("data-lazy data-srcset data-sizes").removeClass("slick-loading"),!0===l.options.adaptiveHeight&&l.setPosition(),l.$slider.trigger("lazyLoaded",[l,t,o]),l.progressiveLazyLoad()},r.onerror=function(){e<3?setTimeout(function(){l.progressiveLazyLoad(e+1)},500):(t.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"),l.$slider.trigger("lazyLoadError",[l,t,o]),l.progressiveLazyLoad())},r.src=o):l.$slider.trigger("allImagesLoaded",[l])},e.prototype.refresh=function(e){var t,o,s=this;o=s.slideCount-s.options.slidesToShow,!s.options.infinite&&s.currentSlide>o&&(s.currentSlide=o),s.slideCount<=s.options.slidesToShow&&(s.currentSlide=0),t=s.currentSlide,s.destroy(!0),i.extend(s,s.initials,{currentSlide:t}),s.init(),e||s.changeSlide({data:{message:"index",index:t}},!1)},e.prototype.registerBreakpoints=function(){var e,t,o,s=this,n=s.options.responsive||null;if("array"===i.type(n)&&n.length){s.respondTo=s.options.respondTo||"window";for(e in n)if(o=s.breakpoints.length-1,n.hasOwnProperty(e)){for(t=n[e].breakpoint;o>=0;)s.breakpoints[o]&&s.breakpoints[o]===t&&s.breakpoints.splice(o,1),o--;s.breakpoints.push(t),s.breakpointSettings[t]=n[e].settings}s.breakpoints.sort(function(i,e){return s.options.mobileFirst?i-e:e-i})}},e.prototype.reinit=function(){var e=this;e.$slides=e.$slideTrack.children(e.options.slide).addClass("slick-slide"),e.slideCount=e.$slides.length,e.currentSlide>=e.slideCount&&0!==e.currentSlide&&(e.currentSlide=e.currentSlide-e.options.slidesToScroll),e.slideCount<=e.options.slidesToShow&&(e.currentSlide=0),e.registerBreakpoints(),e.setProps(),e.setupInfinite(),e.buildArrows(),e.updateArrows(),e.initArrowEvents(),e.buildDots(),e.updateDots(),e.initDotEvents(),e.cleanUpSlideEvents(),e.initSlideEvents(),e.checkResponsive(!1,!0),!0===e.options.focusOnSelect&&i(e.$slideTrack).children().on("click.slick",e.selectHandler),e.setSlideClasses("number"==typeof e.currentSlide?e.currentSlide:0),e.setPosition(),e.focusHandler(),e.paused=!e.options.autoplay,e.autoPlay(),e.$slider.trigger("reInit",[e])},e.prototype.resize=function(){var e=this;i(window).width()!==e.windowWidth&&(clearTimeout(e.windowDelay),e.windowDelay=window.setTimeout(function(){e.windowWidth=i(window).width(),e.checkResponsive(),e.unslicked||e.setPosition()},50))},e.prototype.removeSlide=e.prototype.slickRemove=function(i,e,t){var o=this;if(i="boolean"==typeof i?!0===(e=i)?0:o.slideCount-1:!0===e?--i:i,o.slideCount<1||i<0||i>o.slideCount-1)return!1;o.unload(),!0===t?o.$slideTrack.children().remove():o.$slideTrack.children(this.options.slide).eq(i).remove(),o.$slides=o.$slideTrack.children(this.options.slide),o.$slideTrack.children(this.options.slide).detach(),o.$slideTrack.append(o.$slides),o.$slidesCache=o.$slides,o.reinit()},e.prototype.setCSS=function(i){var e,t,o=this,s={};!0===o.options.rtl&&(i=-i),e="left"==o.positionProp?Math.ceil(i)+"px":"0px",t="top"==o.positionProp?Math.ceil(i)+"px":"0px",s[o.positionProp]=i,!1===o.transformsEnabled?o.$slideTrack.css(s):(s={},!1===o.cssTransitions?(s[o.animType]="translate("+e+", "+t+")",o.$slideTrack.css(s)):(s[o.animType]="translate3d("+e+", "+t+", 0px)",o.$slideTrack.css(s)))},e.prototype.setDimensions=function(){var i=this;!1===i.options.vertical?!0===i.options.centerMode&&i.$list.css({padding:"0px "+i.options.centerPadding}):(i.$list.height(i.$slides.first().outerHeight(!0)*i.options.slidesToShow),!0===i.options.centerMode&&i.$list.css({padding:i.options.centerPadding+" 0px"})),i.listWidth=i.$list.width(),i.listHeight=i.$list.height(),!1===i.options.vertical&&!1===i.options.variableWidth?(i.slideWidth=Math.ceil(i.listWidth/i.options.slidesToShow),i.$slideTrack.width(Math.ceil(i.slideWidth*i.$slideTrack.children(".slick-slide").length))):!0===i.options.variableWidth?i.$slideTrack.width(5e3*i.slideCount):(i.slideWidth=Math.ceil(i.listWidth),i.$slideTrack.height(Math.ceil(i.$slides.first().outerHeight(!0)*i.$slideTrack.children(".slick-slide").length)));var e=i.$slides.first().outerWidth(!0)-i.$slides.first().width();!1===i.options.variableWidth&&i.$slideTrack.children(".slick-slide").width(i.slideWidth-e)},e.prototype.setFade=function(){var e,t=this;t.$slides.each(function(o,s){e=t.slideWidth*o*-1,!0===t.options.rtl?i(s).css({position:"relative",right:e,top:0,zIndex:t.options.zIndex-2,opacity:0}):i(s).css({position:"relative",left:e,top:0,zIndex:t.options.zIndex-2,opacity:0})}),t.$slides.eq(t.currentSlide).css({zIndex:t.options.zIndex-1,opacity:1})},e.prototype.setHeight=function(){var i=this;if(1===i.options.slidesToShow&&!0===i.options.adaptiveHeight&&!1===i.options.vertical){var e=i.$slides.eq(i.currentSlide).outerHeight(!0);i.$list.css("height",e)}},e.prototype.setOption=e.prototype.slickSetOption=function(){var e,t,o,s,n,r=this,l=!1;if("object"===i.type(arguments[0])?(o=arguments[0],l=arguments[1],n="multiple"):"string"===i.type(arguments[0])&&(o=arguments[0],s=arguments[1],l=arguments[2],"responsive"===arguments[0]&&"array"===i.type(arguments[1])?n="responsive":void 0!==arguments[1]&&(n="single")),"single"===n)r.options[o]=s;else if("multiple"===n)i.each(o,function(i,e){r.options[i]=e});else if("responsive"===n)for(t in s)if("array"!==i.type(r.options.responsive))r.options.responsive=[s[t]];else{for(e=r.options.responsive.length-1;e>=0;)r.options.responsive[e].breakpoint===s[t].breakpoint&&r.options.responsive.splice(e,1),e--;r.options.responsive.push(s[t])}l&&(r.unload(),r.reinit())},e.prototype.setPosition=function(){var i=this;i.setDimensions(),i.setHeight(),!1===i.options.fade?i.setCSS(i.getLeft(i.currentSlide)):i.setFade(),i.$slider.trigger("setPosition",[i])},e.prototype.setProps=function(){var i=this,e=document.body.style;i.positionProp=!0===i.options.vertical?"top":"left","top"===i.positionProp?i.$slider.addClass("slick-vertical"):i.$slider.removeClass("slick-vertical"),void 0===e.WebkitTransition&&void 0===e.MozTransition&&void 0===e.msTransition||!0===i.options.useCSS&&(i.cssTransitions=!0),i.options.fade&&("number"==typeof i.options.zIndex?i.options.zIndex<3&&(i.options.zIndex=3):i.options.zIndex=i.defaults.zIndex),void 0!==e.OTransform&&(i.animType="OTransform",i.transformType="-o-transform",i.transitionType="OTransition",void 0===e.perspectiveProperty&&void 0===e.webkitPerspective&&(i.animType=!1)),void 0!==e.MozTransform&&(i.animType="MozTransform",i.transformType="-moz-transform",i.transitionType="MozTransition",void 0===e.perspectiveProperty&&void 0===e.MozPerspective&&(i.animType=!1)),void 0!==e.webkitTransform&&(i.animType="webkitTransform",i.transformType="-webkit-transform",i.transitionType="webkitTransition",void 0===e.perspectiveProperty&&void 0===e.webkitPerspective&&(i.animType=!1)),void 0!==e.msTransform&&(i.animType="msTransform",i.transformType="-ms-transform",i.transitionType="msTransition",void 0===e.msTransform&&(i.animType=!1)),void 0!==e.transform&&!1!==i.animType&&(i.animType="transform",i.transformType="transform",i.transitionType="transition"),i.transformsEnabled=i.options.useTransform&&null!==i.animType&&!1!==i.animType},e.prototype.setSlideClasses=function(i){var e,t,o,s,n=this;if(t=n.$slider.find(".slick-slide").removeClass("slick-active slick-center slick-current").attr("aria-hidden","true"),n.$slides.eq(i).addClass("slick-current"),!0===n.options.centerMode){var r=n.options.slidesToShow%2==0?1:0;e=Math.floor(n.options.slidesToShow/2),!0===n.options.infinite&&(i>=e&&i<=n.slideCount-1-e?n.$slides.slice(i-e+r,i+e+1).addClass("slick-active").attr("aria-hidden","false"):(o=n.options.slidesToShow+i,t.slice(o-e+1+r,o+e+2).addClass("slick-active").attr("aria-hidden","false")),0===i?t.eq(t.length-1-n.options.slidesToShow).addClass("slick-center"):i===n.slideCount-1&&t.eq(n.options.slidesToShow).addClass("slick-center")),n.$slides.eq(i).addClass("slick-center")}else i>=0&&i<=n.slideCount-n.options.slidesToShow?n.$slides.slice(i,i+n.options.slidesToShow).addClass("slick-active").attr("aria-hidden","false"):t.length<=n.options.slidesToShow?t.addClass("slick-active").attr("aria-hidden","false"):(s=n.slideCount%n.options.slidesToShow,o=!0===n.options.infinite?n.options.slidesToShow+i:i,n.options.slidesToShow==n.options.slidesToScroll&&n.slideCount-i<n.options.slidesToShow?t.slice(o-(n.options.slidesToShow-s),o+s).addClass("slick-active").attr("aria-hidden","false"):t.slice(o,o+n.options.slidesToShow).addClass("slick-active").attr("aria-hidden","false"));"ondemand"!==n.options.lazyLoad&&"anticipated"!==n.options.lazyLoad||n.lazyLoad()},e.prototype.setupInfinite=function(){var e,t,o,s=this;if(!0===s.options.fade&&(s.options.centerMode=!1),!0===s.options.infinite&&!1===s.options.fade&&(t=null,s.slideCount>s.options.slidesToShow)){for(o=!0===s.options.centerMode?s.options.slidesToShow+1:s.options.slidesToShow,e=s.slideCount;e>s.slideCount-o;e-=1)t=e-1,i(s.$slides[t]).clone(!0).attr("id","").attr("data-slick-index",t-s.slideCount).prependTo(s.$slideTrack).addClass("slick-cloned");for(e=0;e<o+s.slideCount;e+=1)t=e,i(s.$slides[t]).clone(!0).attr("id","").attr("data-slick-index",t+s.slideCount).appendTo(s.$slideTrack).addClass("slick-cloned");s.$slideTrack.find(".slick-cloned").find("[id]").each(function(){i(this).attr("id","")})}},e.prototype.interrupt=function(i){var e=this;i||e.autoPlay(),e.interrupted=i},e.prototype.selectHandler=function(e){var t=this,o=i(e.target).is(".slick-slide")?i(e.target):i(e.target).parents(".slick-slide"),s=parseInt(o.attr("data-slick-index"));s||(s=0),t.slideCount<=t.options.slidesToShow?t.slideHandler(s,!1,!0):t.slideHandler(s)},e.prototype.slideHandler=function(i,e,t){var o,s,n,r,l,d=null,a=this;if(e=e||!1,!(!0===a.animating&&!0===a.options.waitForAnimate||!0===a.options.fade&&a.currentSlide===i))if(!1===e&&a.asNavFor(i),o=i,d=a.getLeft(o),r=a.getLeft(a.currentSlide),a.currentLeft=null===a.swipeLeft?r:a.swipeLeft,!1===a.options.infinite&&!1===a.options.centerMode&&(i<0||i>a.getDotCount()*a.options.slidesToScroll))!1===a.options.fade&&(o=a.currentSlide,!0!==t?a.animateSlide(r,function(){a.postSlide(o)}):a.postSlide(o));else if(!1===a.options.infinite&&!0===a.options.centerMode&&(i<0||i>a.slideCount-a.options.slidesToScroll))!1===a.options.fade&&(o=a.currentSlide,!0!==t?a.animateSlide(r,function(){a.postSlide(o)}):a.postSlide(o));else{if(a.options.autoplay&&clearInterval(a.autoPlayTimer),s=o<0?a.slideCount%a.options.slidesToScroll!=0?a.slideCount-a.slideCount%a.options.slidesToScroll:a.slideCount+o:o>=a.slideCount?a.slideCount%a.options.slidesToScroll!=0?0:o-a.slideCount:o,a.animating=!0,a.$slider.trigger("beforeChange",[a,a.currentSlide,s]),n=a.currentSlide,a.currentSlide=s,a.setSlideClasses(a.currentSlide),a.options.asNavFor&&(l=(l=a.getNavTarget()).slick("getSlick")).slideCount<=l.options.slidesToShow&&l.setSlideClasses(a.currentSlide),a.updateDots(),a.updateArrows(),!0===a.options.fade)return!0!==t?(a.fadeSlideOut(n),a.fadeSlide(s,function(){a.postSlide(s)})):a.postSlide(s),void a.animateHeight();!0!==t?a.animateSlide(d,function(){a.postSlide(s)}):a.postSlide(s)}},e.prototype.startLoad=function(){var i=this;!0===i.options.arrows&&i.slideCount>i.options.slidesToShow&&(i.$prevArrow.hide(),i.$nextArrow.hide()),!0===i.options.dots&&i.slideCount>i.options.slidesToShow&&i.$dots.hide(),i.$slider.addClass("slick-loading")},e.prototype.swipeDirection=function(){var i,e,t,o,s=this;return i=s.touchObject.startX-s.touchObject.curX,e=s.touchObject.startY-s.touchObject.curY,t=Math.atan2(e,i),(o=Math.round(180*t/Math.PI))<0&&(o=360-Math.abs(o)),o<=45&&o>=0?!1===s.options.rtl?"left":"right":o<=360&&o>=315?!1===s.options.rtl?"left":"right":o>=135&&o<=225?!1===s.options.rtl?"right":"left":!0===s.options.verticalSwiping?o>=35&&o<=135?"down":"up":"vertical"},e.prototype.swipeEnd=function(i){var e,t,o=this;if(o.dragging=!1,o.swiping=!1,o.scrolling)return o.scrolling=!1,!1;if(o.interrupted=!1,o.shouldClick=!(o.touchObject.swipeLength>10),void 0===o.touchObject.curX)return!1;if(!0===o.touchObject.edgeHit&&o.$slider.trigger("edge",[o,o.swipeDirection()]),o.touchObject.swipeLength>=o.touchObject.minSwipe){switch(t=o.swipeDirection()){case"left":case"down":e=o.options.swipeToSlide?o.checkNavigable(o.currentSlide+o.getSlideCount()):o.currentSlide+o.getSlideCount(),o.currentDirection=0;break;case"right":case"up":e=o.options.swipeToSlide?o.checkNavigable(o.currentSlide-o.getSlideCount()):o.currentSlide-o.getSlideCount(),o.currentDirection=1}"vertical"!=t&&(o.slideHandler(e),o.touchObject={},o.$slider.trigger("swipe",[o,t]))}else o.touchObject.startX!==o.touchObject.curX&&(o.slideHandler(o.currentSlide),o.touchObject={})},e.prototype.swipeHandler=function(i){var e=this;if(!(!1===e.options.swipe||"ontouchend"in document&&!1===e.options.swipe||!1===e.options.draggable&&-1!==i.type.indexOf("mouse")))switch(e.touchObject.fingerCount=i.originalEvent&&void 0!==i.originalEvent.touches?i.originalEvent.touches.length:1,e.touchObject.minSwipe=e.listWidth/e.options.touchThreshold,!0===e.options.verticalSwiping&&(e.touchObject.minSwipe=e.listHeight/e.options.touchThreshold),i.data.action){case"start":e.swipeStart(i);break;case"move":e.swipeMove(i);break;case"end":e.swipeEnd(i)}},e.prototype.swipeMove=function(i){var e,t,o,s,n,r,l=this;return n=void 0!==i.originalEvent?i.originalEvent.touches:null,!(!l.dragging||l.scrolling||n&&1!==n.length)&&(e=l.getLeft(l.currentSlide),l.touchObject.curX=void 0!==n?n[0].pageX:i.clientX,l.touchObject.curY=void 0!==n?n[0].pageY:i.clientY,l.touchObject.swipeLength=Math.round(Math.sqrt(Math.pow(l.touchObject.curX-l.touchObject.startX,2))),r=Math.round(Math.sqrt(Math.pow(l.touchObject.curY-l.touchObject.startY,2))),!l.options.verticalSwiping&&!l.swiping&&r>4?(l.scrolling=!0,!1):(!0===l.options.verticalSwiping&&(l.touchObject.swipeLength=r),t=l.swipeDirection(),void 0!==i.originalEvent&&l.touchObject.swipeLength>4&&(l.swiping=!0,i.preventDefault()),s=(!1===l.options.rtl?1:-1)*(l.touchObject.curX>l.touchObject.startX?1:-1),!0===l.options.verticalSwiping&&(s=l.touchObject.curY>l.touchObject.startY?1:-1),o=l.touchObject.swipeLength,l.touchObject.edgeHit=!1,!1===l.options.infinite&&(0===l.currentSlide&&"right"===t||l.currentSlide>=l.getDotCount()&&"left"===t)&&(o=l.touchObject.swipeLength*l.options.edgeFriction,l.touchObject.edgeHit=!0),!1===l.options.vertical?l.swipeLeft=e+o*s:l.swipeLeft=e+o*(l.$list.height()/l.listWidth)*s,!0===l.options.verticalSwiping&&(l.swipeLeft=e+o*s),!0!==l.options.fade&&!1!==l.options.touchMove&&(!0===l.animating?(l.swipeLeft=null,!1):void l.setCSS(l.swipeLeft))))},e.prototype.swipeStart=function(i){var e,t=this;if(t.interrupted=!0,1!==t.touchObject.fingerCount||t.slideCount<=t.options.slidesToShow)return t.touchObject={},!1;void 0!==i.originalEvent&&void 0!==i.originalEvent.touches&&(e=i.originalEvent.touches[0]),t.touchObject.startX=t.touchObject.curX=void 0!==e?e.pageX:i.clientX,t.touchObject.startY=t.touchObject.curY=void 0!==e?e.pageY:i.clientY,t.dragging=!0},e.prototype.unfilterSlides=e.prototype.slickUnfilter=function(){var i=this;null!==i.$slidesCache&&(i.unload(),i.$slideTrack.children(this.options.slide).detach(),i.$slidesCache.appendTo(i.$slideTrack),i.reinit())},e.prototype.unload=function(){var e=this;i(".slick-cloned",e.$slider).remove(),e.$dots&&e.$dots.remove(),e.$prevArrow&&e.htmlExpr.test(e.options.prevArrow)&&e.$prevArrow.remove(),e.$nextArrow&&e.htmlExpr.test(e.options.nextArrow)&&e.$nextArrow.remove(),e.$slides.removeClass("slick-slide slick-active slick-visible slick-current").attr("aria-hidden","true").css("width","")},e.prototype.unslick=function(i){var e=this;e.$slider.trigger("unslick",[e,i]),e.destroy()},e.prototype.updateArrows=function(){var i=this;Math.floor(i.options.slidesToShow/2),!0===i.options.arrows&&i.slideCount>i.options.slidesToShow&&!i.options.infinite&&(i.$prevArrow.removeClass("slick-disabled").attr("aria-disabled","false"),i.$nextArrow.removeClass("slick-disabled").attr("aria-disabled","false"),0===i.currentSlide?(i.$prevArrow.addClass("slick-disabled").attr("aria-disabled","true"),i.$nextArrow.removeClass("slick-disabled").attr("aria-disabled","false")):i.currentSlide>=i.slideCount-i.options.slidesToShow&&!1===i.options.centerMode?(i.$nextArrow.addClass("slick-disabled").attr("aria-disabled","true"),i.$prevArrow.removeClass("slick-disabled").attr("aria-disabled","false")):i.currentSlide>=i.slideCount-1&&!0===i.options.centerMode&&(i.$nextArrow.addClass("slick-disabled").attr("aria-disabled","true"),i.$prevArrow.removeClass("slick-disabled").attr("aria-disabled","false")))},e.prototype.updateDots=function(){var i=this;null!==i.$dots&&(i.$dots.find("li").removeClass("slick-active").end(),i.$dots.find("li").eq(Math.floor(i.currentSlide/i.options.slidesToScroll)).addClass("slick-active"))},e.prototype.visibility=function(){var i=this;i.options.autoplay&&(document[i.hidden]?i.interrupted=!0:i.interrupted=!1)},i.fn.slick=function(){var i,t,o=this,s=arguments[0],n=Array.prototype.slice.call(arguments,1),r=o.length;for(i=0;i<r;i++)if("object"==typeof s||void 0===s?o[i].slick=new e(o[i],s):t=o[i].slick[s].apply(o[i].slick,n),void 0!==t)return t;return o}});

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
$(document).delegate("input[name='uniqueid']","keyup",function(){var e=$(this).val();$(".salesagentalert").remove(),$.ajax({url:"index.php?route=extension/module/salesagent/agentcode&uniqueid="+encodeURIComponent(e),dataType:"json",success:function(e){$(".salesagentalert").remove(),e.firstname&&$("input[name='uniqueid']").after('<div class="alert alert-success salesagentalert">Successfully connected to '+e.firstname+" "+e.lastname+"<div>")}})}),$(document).delegate("select[name='salesagent_id']","change",function(){$.ajax({url:"index.php?route=extension/module/salesagent/save",type:"post",data:$("select[name='salesagent_id']"),dataType:"json",success:function(e){console.log(e)}})});
