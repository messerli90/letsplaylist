<template lang="html">
  <div class="">
    <div v-if="loading" class="text-center loading-wrapper">
      <i class="fa fa-spin fa-spinner fa-5x"></i>
      <h3>Looking for playlists that match your search.</h3>
    </div>
    <div v-if="!playlists.length && !loading" class="text-center loading-wrapper">
      <i class="fa fa-binoculars fa-5x"></i>
      <h3>Couldn't find anything matching your search.</h3>
    </div>
    <playlist-card v-if="!loading" v-for="playlist in playlists" :playlist="playlist"></playlist-card>
  </div>
</template>

<script>
import eventHub from '../events.js'

export default {
  data () {
    return {
      playlists: [],
      meta: {},
      page: 1,
      game: '',
      search: '',
      loading: true
    }
  },

  methods: {
    getPlaylists() {
      var url = '/api/playlists?page=' + this.page + '&search=' + this.search + '&game=' + this.game;
      this.loading = true;

      this.$http.get(url).then((res) => {
        this.loading = false;
        this.playlists = res.body.data;
        this.meta = res.body.meta;
      })
    },
    setPage(page) {
      this.page = page;
      this.getPlaylists();
    },
    setSearch(search) {
      this.search = search;
      this.page = 1;
      this.getPlaylists();
    },
    changeGame(game) {
      this.game = game;
      this.page = 1;
      this.getPlaylists();
    }
  },

  mounted() {
    this.getPlaylists()

    eventHub.$on('playlists.switched-page', this.setPage)
    eventHub.$on('filters.search', this.setSearch)
    eventHub.$on('filters.game', this.changeGame)
  }
}
</script>

<style scoped>
  .loading-wrapper {
    padding: 10rem 0;
  }
</style>
