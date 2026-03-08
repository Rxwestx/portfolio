document.addEventListener("alpine:init", () => {
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
        updateUrl() {
            const url = new URL(window.location.href);
            url.searchParams.set("tab", this.activeTab);
            url.searchParams.set("week_offset", String(this.weekOffset));
            url.searchParams.set("month_offset", String(this.monthOffset));
            url.searchParams.set("year_offset", String(this.yearOffset));
            window.history.replaceState(null, "", url.toString());
        },

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
        //コンポーネントの初期化処理
        init() {
            this.weekly = this.readJsonById("weeklyData");
            this.monthly = this.readJsonById("monthlyData");
            this.yearly = this.readJsonById("yearlyData");

            this.weekOffset = Number(this.$el?.dataset?.weekOffset ?? 0);
            this.monthOffset = Number(this.$el?.dataset?.monthOffset ?? 0);
            this.yearOffset = Number(this.$el?.dataset?.yearOffset ?? 0);

            const params = new URLSearchParams(window.location.search);
            const tab = params.get("tab");
            if (["weekly", "monthly", "yearly"].includes(tab)) {
                this.activeTab = tab;
            }

            const weekOffset = Number(params.get("week_offset"));
            const monthOffset = Number(params.get("month_offset"));
            const yearOffset = Number(params.get("year_offset"));

            if (Number.isInteger(weekOffset) && weekOffset <= 0) this.weekOffset = weekOffset;
            if (Number.isInteger(monthOffset) && monthOffset <= 0) this.monthOffset = monthOffset;
            if (Number.isInteger(yearOffset) && yearOffset <= 0) this.yearOffset = yearOffset;
        },

        async fetchChartData() {
            // 読み込み開始フラグを立て,前回エラー表示を消す。

            this.isLoading = true;
            this.error = "";

            try {
            // URLSearchParamsを使ってtab と各 offset をクエリ文字列化する。
                const params = new URLSearchParams({
                    tab: this.activeTab,
                    week_offset: String(this.weekOffset),
                    month_offset: String(this.monthOffset),
                    year_offset: String(this.yearOffset),
                });
            // APIへ非同期リクエストを送る。
                const res = await fetch(`/dashboard/chart-data?${params.toString()}`, {
                    headers: { "X-Requested-With": "XMLHttpRequest" },
                });
            // 200番台以外なら失敗として例外にする。
                if (!res.ok) throw new Error("Fetch failed");
            // JSONレスポンスをJSオブジェクトに変換する。
                const data = await res.json();
            // 取得データをAlpineのAPIのレスポンスに応じて、weeklyData, monthlyData, yearlyData, weekoffset, monthoffset, yearoffset をstateにセットする。
                this.weekly = data.weeklyData ?? {};
                this.monthly = data.monthlyData ?? {};
                this.yearly = data.yearlyData ?? {};
            // サーバーから返ったoffsetでstateを同期する。
                this.weekOffset = Number(data.weekOffset ?? this.weekOffset);
                this.monthOffset = Number(data.monthOffset ?? this.monthOffset);
                this.yearOffset = Number(data.yearOffset ?? this.yearOffset);
            // 現在stateをURLに反映する（リロードなし）。
                this.updateUrl();
            // 通信失敗時にユーザー向けエラー文言をセット。
            } catch (e) {
                this.error = "データの取得に失敗しました,再試行してください。";
            // 成功/失敗に関係なく読み込み終了フラグを下げる。
            } finally {
                this.isLoading = false;
            }
        },

        setTab(tab) {
            // タブ切替の処理。引数のtabをactiveTabにセットしてfetchChartDataを一本化。
            if (this.activeTab === tab) return; // 同じタブなら何もしない（任意）
            this.activeTab = tab;
            this.fetchChartData();
        },
        changeWeekOffset(delta) {
            // 表示中タブが違う場合は切替しない
            if (this.activeTab !== "weekly") return;
            const next = this.weekOffset + delta;
            if (next > 0) return; // 未来週は不可
            this.weekOffset = next;
            this.fetchChartData();
        },
        changeMonthOffset(delta) {
            if (this.activeTab !== "monthly") return;
            const next = this.monthOffset + delta;
            if (next > 0) return; // 未来月は不可
            this.monthOffset = next;
            this.fetchChartData();
        },
        changeYearOffset(delta) {
            if (this.activeTab !== "yearly") return;
            const next = this.yearOffset + delta;
            if (next > 0) return; // 未来年は不可
            this.yearOffset = next;
            this.fetchChartData();
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
