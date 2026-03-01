document.addEventListener("alpine:init", () => {
    console.log("chart-tabs loaded"); // ←追加
    Alpine.data("chartTabs", () => ({
        activeTab: "weekly",
        weekly: {},
        monthly: {},
        yearly: {},
        weekOffset: 0,
        monthOffset: 0,
        yearOffset: 0,
        isLoading: false,
        error: "",

        // 分を「X時間Y分」形式にフォーマットして返す
        formatMinutes(value) {
            const m = Math.round(Number(value) || 0);
            const h = Math.floor(m / 60);
            const r = m % 60;

            if (h === 0) return `${r}min`;
            if (r === 0) return `${h}h`;
            return `${h}h${r}min`;
        },

        // 日付ラベルをフォーマット（タブに応じて表示を変える）
        formatDateLabel(date) {
            if (this.activeTab === "weekly") {
                // 週間: mm-dd → dd日
                const parts = date.split("-");
                return parts[2] ? `${parseInt(parts[2])}日` : date;
            }
            if (this.activeTab === "monthly") {
                // 月間: mm-dd → dd日
                const parts = date.split("-");
                return parts[2] ? `${parseInt(parts[2])}日` : date;
            }
            if (this.activeTab === "yearly") {
                // 年別: YYYY-MM → MM月
                const parts = date.split("-");
                return parts[1] ? `${parseInt(parts[1])}月` : date;
            }
            return date;
        },

        // 期間ラベル（タブ右側に表示）
        getPeriodLabel() {
            const data = this.getCurrentData();
            const keys = Object.keys(data);
            if (keys.length === 0) return "";

            if (this.activeTab === "weekly") {
                const firstDate = keys[0];
                const lastDate = keys[keys.length - 1];
                const f = firstDate.split("-");
                const l = lastDate.split("-");

                if (f.length === 3 && l.length === 3) {
                    const fm = f[1];
                    const fd = f[2];
                    const lm = l[1];
                    const ld = l[2];
                    return `${fm}月${fd}日〜${lm}月${ld}日`;
                }
                return `${firstDate}〜${lastDate}`;
            }

            if (this.activeTab === "monthly") {
                const lastDate = keys[keys.length - 1];
                const parts = lastDate.split("-");
                if (parts.length >= 2) {
                    const y = parts[0];
                    const m = parseInt(parts[1], 10);
                    return `${y}年${m}月`;
                }
                return lastDate;
            }

            if (this.activeTab === "yearly") {
                const year = keys[0].split("-")[0];
                return `${year}年`;
            }
            return "";
        },

        init() {
            // Bladeに埋め込まれたJSONを読む
            this.weekly = this.readJsonById("weeklyData");
            this.monthly = this.readJsonById("monthlyData");
            this.yearly = this.readJsonById("yearlyData");

            // 週のずらしを取得（0=今週, -1=前週, -2=前々週）
            const offset = this.$el?.dataset?.weekOffset;
            this.weekOffset = Number(offset || 0);
            // 月のずらしを取得（0=今月, -1=前月, -2=前々月）
            const monthOffset = this.$el?.dataset?.monthOffset;
            this.monthOffset = Number(monthOffset || 0);
            // 年のずらしを取得（0=今年, -1=前年, -2=前々年）
            const yearOffset = this.$el?.dataset?.yearOffset;
            this.yearOffset = Number(yearOffset || 0);
            // URLからタブを復元して、再読み込み後も同じ表示にする
            const tab = new URLSearchParams(window.location.search).get("tab");
            if (tab) this.activeTab = tab;
        },

        setTab(tab) {
            this.activeTab = tab;
            // setTabでURLにtabを保存する
            const url = new URL(window.location.href);
            url.searchParams.set("tab", tab);
            window.history.replaceState(null, "", url.toString());
            //this.render()
        },

        changeWeekOffset(delta) {
            // 表示中タブが違う場合は切替しない
            if (this.activeTab !== "weekly") return;
            const next = this.weekOffset + delta;
            if (next > 0) return; // 未来週は不可
            this.weekOffset = next;

            const url = new URL(window.location.href);
            url.searchParams.set("week_offset", String(this.weekOffset));
            // 再読み込み後も同じタブになるようURLに保持
            url.searchParams.set("tab", this.activeTab);
            url.hash = "chart";
            window.location.href = url.toString();
        },
        changeMonthOffset(delta) {
            if (this.activeTab !== "monthly") return;
            const next = this.monthOffset + delta;
            if (next > 0) return; // 未来月は不可
            this.monthOffset = next;
            const url = new URL(window.location.href);
            url.searchParams.set("month_offset", String(this.monthOffset));
            // 再読み込み後も同じタブになるようURLに保持
            url.searchParams.set("tab", this.activeTab);
            url.hash = "chart";
            window.location.href = url.toString();
        },
        changeYearOffset(delta) {
            if (this.activeTab !== "yearly") return;
            const next = this.yearOffset + delta;
            if (next > 0) return; // 未来年は不可
            this.yearOffset = next;
            const url = new URL(window.location.href);
            url.searchParams.set("year_offset", String(this.yearOffset));
            // 再読み込み後も同じタブになるようURLに保持
            url.searchParams.set("tab", this.activeTab);
            url.hash = "chart";
            window.location.href = url.toString();
        },

        // いま表示すべきデータを返す（Bladeのx-forが期待するのは「オブジェクト」）

        getCurrentData() {
            if (this.activeTab === "weekly") return this.weekly || {};
            if (this.activeTab === "monthly") return this.monthly || {};
            if (this.activeTab === "yearly") return this.yearly || {};
            return {};
        },
        // 棒の高さ（%）を返す
        getBarHeight(value, maxValue) {
            const v = Number(value) || 0;
            const m = Number(maxValue) || 0;
            if (m <= 0) return 0;
            return Math.round((v / m) * 100);
        },
        // JSON読み取り（<script type="application/json" id="..."> から読む）
        readJsonById(id) {
            const el = document.getElementById(id);
            if (!el) return {};
            try {
                const text = (el.textContent || "").trim();
                return text ? JSON.parse(text) : {};
            } catch (e) {
                console.error(`Failed to parse ${id}`, e);
                return {};
            }
        },
    }));
});
