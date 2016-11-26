<template lang="html">
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="media">
        <div class="media-left">
          <a :href="videoURL">
            <img class="media-object" :src="this.videoItem.snippet.thumbnails.default.url" alt="Video Thumbnail">
          </a>
        </div>
        <div class="media-body">
          <h4 class="media-heading"><a :href="videoURL">{{ this.videoItem.snippet.title }}</a></h4>
          {{ this.videoItem.snippet.description.substring(0, 160) }}
        </div>
      </div>
    </div>
    <div class="panel-footer">
      <i class="fa fa-clock-o"></i> {{ published }}
    </div>
  </div>
</template>

<script>
export default {
  props: ['videoItem'],

  computed: {
    published () {
      return moment(this.videoItem.snippet.publishedAt).fromNow()
    },
    videoURL () {
      return '/playlists/' + this.videoItem.snippet.playlistId + '/videos/' + this.videoItem.snippet.resourceId.videoId;
    }
  },

  mounted () {

  }
}
</script>
