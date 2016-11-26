<template lang="html">
  <div class="jumbotron" :style="'background: url(https://images.igdb.com/igdb/image/upload/t_screenshot_med_2x/' + banner_slug + '.jpg)'">
    <div class="jumbotron-cover">
      <div class="container">
        <h1>Find a Playlist for <span style="color: #AA3939">{{ header }}</span></h1>
        <p>
          No more weeding through review videos, advertisements, trailers, etc when trying to find your next <strong>Let's Play</strong> series.
        </p>
        <!-- <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p> -->
      </div>
    </div>
  </div>
</template>

<script>
import eventHub from '../events.js'

export default {
  data () {
    return {
      header: ' the Game of your choice',
      game: {},
      banner_slug: 'pyvs7oejfhvvttiqb4s0'
    }
  },

  methods: {
    changeGame(game) {
      this.game = game;
    }
  },

  mounted () {
    var self = this;
    eventHub.$on('banner.game', function (gameId) {
      self.$http.get('/api/games/' + gameId).then((res) => {
        self.banner_slug = res.body.image ? res.body.image : 'pyvs7oejfhvvttiqb4s0';
        self.game = res.body;
        self.header = res.body.title;
      })
    })
  }
}
</script>

<style lang="css">
</style>
