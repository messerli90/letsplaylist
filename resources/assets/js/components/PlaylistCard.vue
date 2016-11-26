<template lang="html">
  <div class="panel panel-default">
    <div class="panel-heading">
      <span class="text-muted pull-right"><a class="text-muted" href="#" @click.prevent="changeGame">{{ playlist.game.data.title }}</a></span>
      <h3 class="panel-title"><a :href="channelUrl">{{ playlist.channel.data.name }}</a></h3>
    </div>
    <div class="panel-body">
      <div class="media">
        <div class="media-left">
          <a :href="playlistUrl" target="_blank">
            <img class="media-object" :src="playlist.image" alt="Playlist thumbnail">
          </a>
        </div>
        <div class="media-body">
          <h4 class="media-heading"><a :href="playlistUrl" target="_blank">{{ playlist.title }}</a></h4>
          {{ playlist.description }}
        </div>
      </div>
    </div>
    <div class="panel-footer clearfix">
      <ul class="text-right list-inline">
        <li class="text-muted"><i class="fa fa-clock-o fa-fw"></i> {{ published }}</li>
        <li><a class="text-muted" href="#" @click.prevent="getPreview">Preview <i class="fa fa-caret-down"></i></a></li>
      </ul>

      <hr v-if="preview_open" />

      <div class="embed-responsive embed-responsive-16by9" v-if="preview_open">
        <div class="loading-wrapper text-center" v-if="loading">
          <p><i class="fa fa-spin fa-spinner fa-3x"></i></p>
          <p>Loading first video of series</p>
        </div>
        <iframe class="embed-responsive-item" v-if="preview" :src="preview" allowfullscreen></iframe>
      </div>
    </div>
  </div>
</template>

<script>
import eventHub from '../events.js'

export default {
  data () {
    return {
      preview_open: false,
      loading: false,
      preview: null
    }
  },

  computed: {
    published () {
      return moment(this.playlist.published_at).fromNow()
    },
    playlistUrl () {
      return "https://www.youtube.com/playlist?list=" + this.playlist.key
    },
    channelUrl () {
      return "https://www.youtube.com/user/" + this.playlist.channel.data.slug
    }
  },

  props: ['playlist'],

  methods: {
    getPreview () {
      this.loading = true;
      this.preview_open = true;

      if (! this.preview) {
        this.$http.get('/playlists/' + this.playlist.id + '/preview')
        .then((response) => {
          this.loading = false;
          var videoId = response.body.results[0].snippet.resourceId.videoId;
          this.preview = '//www.youtube.com/embed/' + videoId;
        });
      }
      else {
        this.preview_open = false;
        this.loading = false;
        this.preview = null;
      }
    },
    changeGame () {
      eventHub.$emit('filters.game', this.playlist.game.data.id)
    }
  },

  mounted () {

  }
}
</script>

<style scoped>
.loading-wrapper {
  padding: 25%;
}
.panel-footer > ul {
  margin-bottom: 0;
}

.list-inline > li {
  padding-left: 2rem;
  padding-right: 2rem;
}

.list-inline > li:last-of-type {
  padding-left: 2rem;
  padding-right: 0;
}
</style>
