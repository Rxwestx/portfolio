document.addEventListener('alpine:init', () => {
     console.log('chart-tabs loaded') // ←追加
     Alpine.data('chartTabs',()=> ({
        activeTab: 'weekly',
        weekly: {},
        monthly: {},
        yearly: {},

        init() {
            // Bladeに埋め込まれたJSONを読む
            this.weekly = this.readJsonById('weeklyData')
            this.monthly = this.readJsonById('monthlyData')
            this.yearly = this.readJsonById('yearlyData')
        },

        setTab(tab) {
            this.activeTab = tab
            //this.render()
        },

        // いま表示すべきデータを返す（Bladeのx-forが期待するのは「オブジェクト」）

        getCurrentData() {
            if (this.activeTab === 'weekly') return this.weekly || {}
            if (this.activeTab === 'monthly') return this.monthly || {}
            if (this.activeTab === 'yearly') return this.yearly || {}
            return {}
        },
            // 棒の高さ（%）を返す
        getBarHeight(value, maxValue) {
          const v = Number(value) || 0
          const m = Number(maxValue) || 0
          if (m <= 0) return 0
          return Math.round((v / m) * 100)
        },
        // JSON読み取り（<script type="application/json" id="..."> から読む）
        readJsonById(id) {
          const el = document.getElementById(id)
          if (!el) return {}
          try {
            const text = (el.textContent || '').trim() 
            return text ? JSON.parse(text) : {}
          } catch (e) {
            console.error(`Failed to parse ${id}`, e)
            return {}
            }
        },
    }))
})
