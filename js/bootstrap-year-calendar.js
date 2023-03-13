/* 
 * Bootstrap year calendar v1.1.0
 * Created by Paul David-Sivelle
 * Licensed under the Apache License, Version 2.0
 */
! function(e) {
    var t = function(e, t) {
        this.element = e, this.element.addClass("calendar"), this._initializeEvents(t), this._initializeOptions(t), this._render()
    };
    t.prototype = {
        constructor: t,
        _initializeOptions: function(t) {
            null == t && (t = []), this.options = {
                startYear: isNaN(parseInt(t.startYear)) ? (new Date).getFullYear() : parseInt(t.startYear),
                minDate: t.minDate instanceof Date ? t.minDate : null,
                maxDate: t.maxDate instanceof Date ? t.maxDate : null,
                language: null != t.language && null != n[t.language] ? t.language : "en",
                allowOverlap: null != t.allowOverlap ? t.allowOverlap : !0,
                displayWeekNumber: null != t.displayWeekNumber ? t.displayWeekNumber : !1,
                alwaysHalfDay: null != t.alwaysHalfDay ? t.alwaysHalfDay : !1,
                enableRangeSelection: null != t.enableRangeSelection ? t.enableRangeSelection : !1,
                disabledDays: t.disabledDays instanceof Array ? t.disabledDays : [],
                roundRangeLimits: null != t.roundRangeLimits ? t.roundRangeLimits : !1,
                dataSource: t.dataSource instanceof Array != null ? t.dataSource : [],
                style: "background" == t.style || "border" == t.style || "custom" == t.style ? t.style : "border",
                enableContextMenu: null != t.enableContextMenu ? t.enableContextMenu : !1,
                contextMenuItems: t.contextMenuItems instanceof Array ? t.contextMenuItems : [],
                customDayRenderer: e.isFunction(t.customDayRenderer) ? t.customDayRenderer : null,
                customDataSourceRenderer: e.isFunction(t.customDataSourceRenderer) ? t.customDataSourceRenderer : null
            }, this._initializeDatasourceColors()
        },
        _initializeEvents: function(e) {
            null == e && (e = []), e.renderEnd && this.element.bind("renderEnd", e.renderEnd), e.clickDay && this.element.bind("clickDay", e.clickDay), e.dayContextMenu && this.element.bind("dayContextMenu", e.dayContextMenu), e.selectRange && this.element.bind("selectRange", e.selectRange), e.mouseOnDay && this.element.bind("mouseOnDay", e.mouseOnDay), e.mouseOutDay && this.element.bind("mouseOutDay", e.mouseOutDay)
        },
        _initializeDatasourceColors: function() {
            for (var e in this.options.dataSource) null == this.options.dataSource[e].color && (this.options.dataSource[e].color = a[e % a.length])
        },
        _render: function() {
            this.element.empty(), this._renderHeader(), this._renderBody(), this._renderDataSource(), this._applyEvents(), this.element.find(".months-container").fadeIn(500), this._triggerEvent("renderEnd", {
                currentYear: this.options.startYear
            })
        },
        _renderHeader: function() {
            var t = e(document.createElement("div"));
            t.addClass("calendar-header panel panel-default");
            var n = e(document.createElement("table")),
                a = e(document.createElement("th"));
            a.addClass("prev slid-controal"), null != this.options.minDate && this.options.minDate > new Date(this.options.startYear - 1, 11, 31) && a.addClass("disabled");
            var s = e(document.createElement("span"));
            s.addClass("fa fa-angle-double-left"), a.append(s), n.append(a);
            var i = e(document.createElement("th"));
            i.addClass("year-title year-neighbor2 hidden-sm hidden-xs"), i.text(this.options.startYear - 2), null != this.options.minDate && this.options.minDate > new Date(this.options.startYear - 2, 11, 31) && i.addClass("disabled"), n.append(i);
            var o = e(document.createElement("th"));
            o.addClass("year-title year-neighbor hidden-xs"), o.text(this.options.startYear - 1), null != this.options.minDate && this.options.minDate > new Date(this.options.startYear - 1, 11, 31) && o.addClass("disabled"), n.append(o);
            var r = e(document.createElement("th"));
            r.addClass("year-title year-heading"), r.text(this.options.startYear), n.append(r);
            var d = e(document.createElement("th"));
            d.addClass("year-title year-neighbor hidden-xs"), d.text(this.options.startYear + 1), null != this.options.maxDate && this.options.maxDate < new Date(this.options.startYear + 1, 0, 1) && d.addClass("disabled"), n.append(d);
            var l = e(document.createElement("th"));
            //l.addClass("year-title year-neighbor2 hidden-sm hidden-xs"), l.text(this.options.startYear + 2), null != this.options.maxDate && this.options.maxDate < new Date(this.options.startYear + 2, 0, 1) && l.addClass("disabled"), n.append(l);
            var u = e(document.createElement("th"));
            u.addClass("next slid-controal"), null != this.options.maxDate && this.options.maxDate < new Date(this.options.startYear + 1, 0, 1) && u.addClass("disabled");
            var c = e(document.createElement("span"));
            c.addClass("fa fa-angle-double-right"), u.append(c), n.append(u), t.append(n), this.element.append(t)
        },
        _renderBody: function() {
            var t = e(document.createElement("div"));
            t.addClass("months-container");
            for (var a = 0; 12 > a; a++) {
                var s = e(document.createElement("div"));
                s.addClass("month-container"), s.data("month-id", a);
				
				var selected_year = this.options.startYear;
                var i = new Date(this.options.startYear, a, 1),
                    o = e(document.createElement("table"));
					
					// alert(i);
                o.addClass("month");
                var r = e(document.createElement("thead")),
                    d = e(document.createElement("tr")),
                    l = e(document.createElement("th")),
                    month_anchor = e(document.createElement("a"));
					
				var	href= "rota_page.php?month="+ encodeURI(n[this.options.language].months[a]) + "&year=" + encodeURI(selected_year)
                l.addClass("month-title" + ' ' + n[this.options.language].months[a] + ' --- ' + selected_year), l.attr("colspan", this.options.displayWeekNumber ? 8 : 7), d.append(l), r.append(d);
                month_anchor.addClass("month-title" + ' ' + n[this.options.language].months[a] + ' --- ' + selected_year), month_anchor.attr("href",href), month_anchor.text(n[this.options.language].months[a]), l.append(month_anchor), d.append(l);
                var u = e(document.createElement("tr"));
                if (this.options.displayWeekNumber) {
                    var c = e(document.createElement("th"));
                    c.addClass("week-number"), c.text(n[this.options.language].weekShort), u.append(c)
                }
                var h = n[this.options.language].weekStart;
                do {
                    var m = e(document.createElement("th"));
                    //m.addClass("day-header"), m.text(n[this.options.language].daysMin[h]), u.append(m), h++, h >= 7 && (h = 0)
                } while (h != n[this.options.language].weekStart);
                r.append(u), o.append(r);
                for (var p = new Date(i.getTime()), g = new Date(this.options.startYear, a + 1, 0), f = n[this.options.language].weekStart; p.getDay() != f;) p.setDate(p.getDate() - 1);
                s.append(o), t.append(s)
            }
            this.element.append(t)
        },
        _renderDataSource: function() {
            var t = this;
            null != this.options.dataSource && this.options.dataSource.length > 0 && this.element.find(".month-container").each(function() {
                var n = e(this).data("month-id"),
                    a = new Date(t.options.startYear, n, 1),
                    s = new Date(t.options.startYear, n + 1, 0);
                if ((null == t.options.minDate || s >= t.options.minDate) && (null == t.options.maxDate || a <= t.options.maxDate)) {
                    var i = [];
                    for (var o in t.options.dataSource)(!(t.options.dataSource[o].startDate > s) || t.options.dataSource[o].endDate < a) && i.push(t.options.dataSource[o]);
                    i.length > 0 && e(this).find(".day-content").each(function() {
                        var a = new Date(t.options.startYear, n, e(this).text()),
                            s = [];
                        if ((null == t.options.minDate || a >= t.options.minDate) && (null == t.options.maxDate || a <= t.options.maxDate)) {
                            for (var o in i) i[o].startDate <= a && i[o].endDate >= a && s.push(i[o]);
                            s.length > 0 && t._renderDataSourceDay(e(this), a, s)
                        }
                    })
                }
            })
        },
        _applyEvents: function() {
            var t = this;
            this.element.find(".year-neighbor, .year-neighbor2").click(function() { 
                e(this).hasClass("disabled") || t.setYear(parseInt(e(this).text()))
            }), this.element.find(".calendar-header .prev").click(function() {
                e(this).hasClass("disabled") || t.element.find(".months-container").animate({
                    "opacity": "0%"
                }, 0, function() {
                    t.element.find(".months-container").hide(), t.element.find(".months-container").css("opacity", "0"), setTimeout(function() {
                        t.setYear(t.options.startYear - 1)
                    },0)
                })
            }), this.element.find(".calendar-header .next").click(function() {
                e(this).hasClass("disabled") || t.element.find(".months-container").animate({
                    "opacity": "-0%"
                }, 0, function() {
                    t.element.find(".months-container").hide(), t.element.find(".months-container").css("opacity", "0"), setTimeout(function() {
                        t.setYear(t.options.startYear + 1)
                    }, 0)
                })
            });
            var n = this.element.find(".day:not(.old, .new, .disabled)");
            this.options.enableRangeSelection && (n.mousedown(function(n) { alert('dd');
            }), e(window).mouseup(function(e) {
                if (t._mouseDown) {
                    t._mouseDown = !1, t._refreshRange();
                    var n = t._rangeStart < t._rangeEnd ? t._rangeStart : t._rangeEnd,
                        a = t._rangeEnd > t._rangeStart ? t._rangeEnd : t._rangeStart;
                    t._triggerEvent("selectRange", {
                        startDate: n,
                        endDate: a
                    })
                }
            })),  setInterval(function() {
                var n = e(t.element).width(),
                    a = e(t.element).find(".month").first().width() + 1000,
                    s = "month-container";
                 e(t.element).find(".month-container").attr("class", s)
            }, 300)
        },
       
        getEvents: function(e) {
            var t = [];
            if (this.options.dataSource && e)
                for (var n in this.options.dataSource) this.options.dataSource[n].startDate <= e && this.options.dataSource[n].endDate >= e && t.push(this.options.dataSource[n]);
            return t
        },
        getYear: function() {
            return this.options.startYear
        },
        setYear: function(e) {
            var t = parseInt(e);
            isNaN(t) || (this.options.startYear = t, this._render())
        },
       
        getStyle: function() {
            return this.options.style
        },
        setStyle: function(e) {
            this.options.style = "background" == e || "border" == e || "custom" == e ? e : "border", this._render()
        },
        getAllowOverlap: function() {
            return this.options.allowOverlap
        },
        setAllowOverlap: function(e) {
            this.options.allowOverlap = e
        },
        getDisplayWeekNumber: function() {
            return this.options.displayWeekNumber
        },
        setDisplayWeekNumber: function(e) {
            this.options.displayWeekNumber = e, this._render()
        },
        getAlwaysHalfDay: function() {
            return this.options.alwaysHalfDay
        },
        setAlwaysHalfDay: function(e) {
            this.options.alwaysHalfDay = e, this._render()
        },
        getEnableRangeSelection: function() {
            return this.options.enableRangeSelection
        },
        setEnableRangeSelection: function(e) {
            this.options.enableRangeSelection = e, this._render()
        },
        getDisabledDays: function() {
            return this.options.disabledDays
        },
        setDisabledDays: function(e) {
            this.options.disabledDays = e instanceof Array ? e : [], this._render()
        },
        getRoundRangeLimits: function() {
            return this.options.roundRangeLimits
        },
        setRoundRangeLimits: function(e) {
            this.options.roundRangeLimits = e, this._render()
        },
        getEnableContextMenu: function() {
            return this.options.enableContextMenu
        },
        setEnableContextMenu: function(e) {
            this.options.enableContextMenu = e, this._render()
        },
        getContextMenuItems: function() {
            return this.options.contextMenuItems
        },
        setContextMenuItems: function(e) {
            this.options.contextMenuItems = e instanceof Array ? e : [], this._render()
        },
        getCustomDayRenderer: function() {
            return this.options.customDayRenderer
        },
        setCustomDayRenderer: function(t) {
            this.options.customDayRenderer = e.isFunction(t) ? t : null, this._render()
        },
        getCustomDataSourceRenderer: function() {
            return this.options.customDataSourceRenderer
        },
        setCustomDataSourceRenderer: function(t) {
            this.options.customDataSourceRenderer = e.isFunction(t) ? t : null, this._render()
        },
        getLanguage: function() {
            return this.options.language
        },
        setLanguage: function(e) {
            null != e && null != n[e] && (this.options.language = e, this._render())
        },
        getDataSource: function() {
            return this.options.dataSource
        },
        setDataSource: function(e) {
            this.options.dataSource = e instanceof Array ? e : [], this._initializeDatasourceColors(), this._render()
        },
        addEvent: function(e) {
            this.options.dataSource.push(e), this._render()
        }
    }, e.fn.calendar = function(n) {
        var a = new t(e(this), n);
        return e(this).data("calendar", a), a
    }, e.fn.renderEnd = function(t) {
        e(this).bind("renderEnd", t)
    }, e.fn.clickDay = function(t) {
        e(this).bind("clickDay", t)
    }, e.fn.dayContextMenu = function(t) {
        e(this).bind("dayContextMenu", t)
    }, e.fn.selectRange = function(t) {
        e(this).bind("selectRange", t)
    }, e.fn.mouseOnDay = function(t) {
        e(this).bind("mouseOnDay", t)
    }, e.fn.mouseOutDay = function(t) {
        e(this).bind("mouseOutDay", t)
    };
    var n = e.fn.calendar.dates = {
            en: {
               
                months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],               
                weekStart: 0
            }
        },
        a = e.fn.calendar.colors = ["#2C8FC9", "#9CB703", "#F5BB00", "#FF4A32", "#B56CE2", "#45A597"];
    e(function() {
        e('[data-provide="calendar"]').each(function() {
            e(this).calendar()
        })
    })
}(window.jQuery);