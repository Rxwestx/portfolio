export function initChartTabs() {
    return {
        activeTab: "weekly",

        weeklyData: JSON.parse(
            document.getElementById("weeklyData")?.textContent || "{}"
        ),
        monthlyData: JSON.parse(
            document.getElementById("monthlyData")?.textContent || "{}"
        ),
        yearlyData: JSON.parse(
            document.getElementById("yearlyData")?.textContent || "{}"
        ),

        setTab(tab) {
            this.activeTab = tab;
        },

        getChartHeight(data) {
            return Math.max(...Object.values(data)) || 100;
        },

        getBarHeight(value, maxValue) {
            return (value / maxValue) * 100;
        },

        getCurrentData() {
            if (this.activeTab === "weekly") return this.weeklyData;
            if (this.activeTab === "monthly") return this.monthlyData;
            if (this.activeTab === "yearly") return this.yearlyData;
            return {};
        },
    };
}
