
Vue.component('playlist-filter', require('./components/PlaylistFilter.vue'));
Vue.component('playlist-store', require('./components/PlaylistStore.vue'));
Vue.component('playlist-index', require('./components/PlaylistIndex.vue'));

Vue.component('playlist-item', require('./components/PlaylistItem.vue'));
Vue.component('playlist-card', require('./components/PlaylistCard.vue'));
Vue.component('banner', require('./components/Banner.vue'));

const app = new Vue({
    el: '#app'
});
